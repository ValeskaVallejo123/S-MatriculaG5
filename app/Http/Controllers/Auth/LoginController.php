<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el intento de login.
     */
    public function login(Request $request)
    {
        // ── Validación ──────────────────────────────────────────────
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ── Intento de autenticación ────────────────────────────────
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            Log::warning('Login fallido', ['email' => $request->email]);
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas. Verifica tu correo y contraseña.'])
                ->onlyInput('email');
        }

        // FIX: cargar siempre con eager loading para evitar
        // "Attempt to read property on null" al acceder a $usuario->rol->nombre
        $usuario = User::with('rol')->find(Auth::id());
        Auth::setUser($usuario);

        Log::info('Login exitoso', [
            'id'    => $usuario->id,
            'email' => $usuario->email,
        ]);

        // ── Verificar que tenga rol ─────────────────────────────────
        if (!$usuario->rol) {
            Auth::logout();
            Log::error('Usuario sin rol', ['id' => $usuario->id]);
            return back()
                ->withErrors(['email' => 'Tu cuenta no tiene un rol asignado. Contacta al administrador.'])
                ->onlyInput('email');
        }

        // ── Verificar cuenta activa ─────────────────────────────────
        if ($usuario->activo == 0 || $usuario->activo === false) {

            $esPadre = $usuario->isPadre();

            if ($esPadre) {
                // Activar al padre en su primer login si su matrícula fue aprobada
                DB::table('users')
                    ->where('id', $usuario->id)
                    ->update(['activo' => 1]);

                // FIX: recargar CON la relación rol para que isPadre()
                // y redirigirSegunRol() funcionen correctamente después
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

        Log::info('Redirigiendo', ['id' => $usuario->id, 'rol' => $usuario->rol->nombre]);

        return $this->redirigirSegunRol($usuario);
    }

    /**
     * Redirigir al dashboard según el rol del usuario.
     */
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

        // Buscar por nombre de rol primero
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

        // Fallback final: usar helpers del modelo User
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
            'userType' => $usuario->user_type ?? 'null',
        ]);

        return back()->withErrors([
            'email' => 'Rol no reconocido. Contacta al administrador del sistema.',
        ]);
    }

    /**
     * Cerrar sesión.
     */
    public function logout(Request $request)
    {
        $id = Auth::id();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Logout', ['id' => $id]);

        return redirect()->route('login');
    }
}
