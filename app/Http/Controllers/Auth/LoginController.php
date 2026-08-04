<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // Máximo de intentos antes de bloquear
    private const MAX_INTENTOS  = 5;
    // Segundos de bloqueo tras superar intentos
    private const SEGUNDOS_BLOQUEO = 60;

    /* ============================================================
       MOSTRAR FORMULARIO DE LOGIN
    ============================================================ */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /* ============================================================
       PROCESAR LOGIN
    ============================================================ */
    public function login(Request $request)
    {
        // ── 1. Validación de inputs ────────────────────────────────
        $request->validate([
            'email'    => ['required', 'email:rfc', 'max:100'],
            'password' => ['required', 'string', 'min:1', 'max:100'],
        ], [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Ingresa un correo electrónico válido.',
            'email.max'         => 'El correo no puede superar los 100 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.max'      => 'La contraseña no puede superar los 100 caracteres.',
        ]);

        // ── 2. Rate limiting — bloquear tras demasiados intentos ───
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_INTENTOS)) {
            $segundos = RateLimiter::availableIn($throttleKey);

            Log::warning('Login bloqueado por rate limit', [
                'email' => $request->email,
                'ip'    => $request->ip(),
            ]);

            return back()
                ->withErrors(['email' =>
                    "Demasiados intentos fallidos. Intenta de nuevo en {$segundos} segundos."
                ])
                ->onlyInput('email');
        }

        // ── 3. Intento de autenticación ────────────────────────────
        $credentials = [
            'email'    => strtolower(trim($request->input('email'))),
            'password' => $request->input('password'),
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            // Registrar intento fallido
            RateLimiter::hit($throttleKey, self::SEGUNDOS_BLOQUEO);

            $intentosRestantes = self::MAX_INTENTOS - RateLimiter::attempts($throttleKey);

            Log::warning('Login fallido', [
                'email'    => $request->email,
                'ip'       => $request->ip(),
                'intentos' => RateLimiter::attempts($throttleKey),
            ]);

            $mensaje = 'Credenciales incorrectas. Verifica tu correo y contraseña.';
            if ($intentosRestantes <= 2 && $intentosRestantes > 0) {
                $mensaje .= " Te quedan {$intentosRestantes} intento(s) antes del bloqueo.";
            }

            return back()
                ->withErrors(['email' => $mensaje])
                ->onlyInput('email');
        }

        // ── 4. Login exitoso — limpiar rate limiter ────────────────
        RateLimiter::clear($throttleKey);

        // Cargar usuario con relación rol
        $usuario = User::with('rol')->find(Auth::id());
        Auth::setUser($usuario);

        Log::info('Login exitoso', [
            'id'    => $usuario->id,
            'email' => $usuario->email,
            'ip'    => $request->ip(),
        ]);

        // ── 5. Verificar que tenga rol asignado ────────────────────
        if (!$usuario->rol) {
            Auth::logout();

            Log::error('Usuario sin rol', ['id' => $usuario->id]);

            return back()
                ->withErrors(['email' => 'Tu cuenta no tiene un rol asignado. Contacta al administrador.'])
                ->onlyInput('email');
        }

        // ── 6. Verificar cuenta activa ─────────────────────────────
        if ($usuario->activo == 0 || $usuario->activo === false) {

            $esPadre = $usuario->isPadre();

            if ($esPadre) {
                // Activar al padre en su primer login si su matrícula fue aprobada
                DB::table('users')
                    ->where('id', $usuario->id)
                    ->update(['activo' => 1]);

                $usuario = User::with('rol')->find($usuario->id);
                Auth::setUser($usuario);

                Log::info('Padre activado en primer login', ['id' => $usuario->id]);

            } else {
                Auth::logout();

                Log::warning('Login bloqueado — cuenta inactiva', ['id' => $usuario->id]);

                return back()
                    ->withErrors(['email' => 'Tu cuenta está pendiente de aprobación por el administrador.'])
                    ->onlyInput('email');
            }
        }

        // ── 7. Regenerar sesión para prevenir session fixation ─────
        $request->session()->regenerate();

        Log::info('Redirigiendo', [
            'id'  => $usuario->id,
            'rol' => $usuario->rol->nombre ?? 'sin rol',
        ]);

        return $this->redirigirSegunRol($usuario);
    }

    /* ============================================================
       REDIRIGIR SEGÚN ROL
    ============================================================ */
    private function redirigirSegunRol(User $usuario): \Illuminate\Http\RedirectResponse
    {
        $nombreRol = strtolower(trim($usuario->rol->nombre ?? ''));
        $userType  = strtolower(trim($usuario->user_type ?? ''));

        $mapa = [
            'super administrador' => 'superadmin.dashboard',
            'superadministrador'  => 'superadmin.dashboard',
            'superadmin'          => 'superadmin.dashboard',
            'administrador'       => 'admin.dashboard',
            'admin'               => 'admin.dashboard',
            'profesor'            => 'profesor.dashboard',
            'docente'             => 'profesor.dashboard',
            'estudiante'          => 'estudiante.dashboard',
            'alumno'              => 'estudiante.dashboard',
            'padre'               => 'padre.dashboard',
            'tutor'               => 'padre.dashboard',
        ];

        // Buscar por nombre de rol
        if (isset($mapa[$nombreRol])) {
            Log::info('Redirigiendo por rol', [
                'id'   => $usuario->id,
                'rol'  => $nombreRol,
                'ruta' => $mapa[$nombreRol],
            ]);
            return redirect()->route($mapa[$nombreRol]);
        }

        // Fallback: buscar por user_type
        if (isset($mapa[$userType])) {
            Log::info('Redirigiendo por user_type', [
                'id'        => $usuario->id,
                'user_type' => $userType,
                'ruta'      => $mapa[$userType],
            ]);
            return redirect()->route($mapa[$userType]);
        }

        // Fallback: helpers del modelo
        if ($usuario->isSuperAdmin()) return redirect()->route('superadmin.dashboard');
        if ($usuario->isAdmin())      return redirect()->route('admin.dashboard');
        if ($usuario->isDocente())    return redirect()->route('profesor.dashboard');
        if ($usuario->isEstudiante()) return redirect()->route('estudiante.dashboard');
        if ($usuario->isPadre())      return redirect()->route('padre.dashboard');

        // Rol completamente desconocido
        Auth::logout();

        Log::error('Rol no reconocido', [
            'id'       => $usuario->id,
            'rol'      => $usuario->rol->nombre ?? 'null',
            'userType' => $usuario->user_type   ?? 'null',
        ]);

        return back()->withErrors([
            'email' => 'Rol no reconocido. Contacta al administrador del sistema.',
        ]);
    }

    /* ============================================================
       CERRAR SESIÓN
    ============================================================ */
    public function logout(Request $request)
    {
        $id = Auth::id();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Logout', ['id' => $id]);

        return redirect()->route('login');
    }

    /* ============================================================
       HELPER: clave única para rate limiting
    ============================================================ */
    private function throttleKey(Request $request): string
    {
        // Combina email + IP para evitar bloqueos masivos por email
        return Str::lower($request->input('email', '')) . '|' . $request->ip();
    }
}