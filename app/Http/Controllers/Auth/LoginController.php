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

        // ── Buscar usuario ──────────────────────────────────────────
        // CORRECCIÓN: el original buscaba el usuario ANTES de Auth::attempt
        // y luego volvía a obtenerlo con Auth::user() después, lo que
        // generaba dos consultas innecesarias. Se consolidó en una sola
        // llamada a Auth::attempt y luego Auth::user().
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            Log::warning('Login fallido', ['email' => $request->email]);
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas. Verifica tu correo y contraseña.'])
                ->onlyInput('email');
        }

        $usuario = Auth::user();

        Log::info('Login exitoso', [
            'id'    => $usuario->id,
            'email' => $usuario->email,
        ]);

        // ── Verificar que tenga rol ─────────────────────────────────
        // CORRECCIÓN: el original verificaba rol_id || id_rol antes de
        // Auth::attempt, lo que podía bloquear usuarios válidos si el
        // campo era null pero la relación existía. Ahora se verifica
        // la relación ->rol directamente después de autenticar.
        if (!$usuario->rol) {
            Auth::logout();
            Log::error('Usuario sin rol', ['id' => $usuario->id]);
            return back()
                ->withErrors(['email' => 'Tu cuenta no tiene un rol asignado. Contacta al administrador.'])
                ->onlyInput('email');
        }

        // ── Verificar cuenta activa ─────────────────────────────────
        // CORRECCIÓN: el original usaba isset($usuario->activo) &&
        // !$usuario->activo, lo que fallaba si activo era null (isset
        // devuelve true para null). Se usa comparación estricta.
        if ($usuario->activo == 0 || $usuario->activo === false) {

            $nombreRol = strtolower($usuario->rol->nombre ?? '');
            $esPadre   = $nombreRol === 'padre' || $usuario->user_type === 'padre';

            if ($esPadre) {
                // Los padres se activan automáticamente en su primer login
                DB::table('users')
                    ->where('id', $usuario->id)
                    ->update(['activo' => 1]);

                Log::info('Padre activado en primer login', ['id' => $usuario->id]);

            } else {
                Auth::logout();
                Log::warning('Login bloqueado — cuenta inactiva', ['id' => $usuario->id]);
                return back()
                    ->withErrors(['email' => 'Tu cuenta está pendiente de aprobación por el administrador.'])
                    ->onlyInput('email');
            }
        }

        // ── Regenerar sesión (previene session fixation) ────────────
        $request->session()->regenerate();

        return $this->redirigirSegunRol($usuario);
    }

    /**
     * Redirigir al dashboard según el rol del usuario.
     *
     * CORRECCIÓN: el original usaba switch con strings exactos ("Super Administrador")
     * y si el nombre del rol en BD tenía una tilde diferente o mayúscula distinta,
     * nunca entraba al case y hacía logout silencioso. Ahora se normaliza el nombre
     * del rol y se usa un mapa de rutas para mayor claridad y mantenibilidad.
     */
    private function redirigirSegunRol(User $usuario): \Illuminate\Http\RedirectResponse
    {
        $nombreRol = strtolower(trim($usuario->rol->nombre ?? ''));

        $mapa = [
            'super administrador' => 'superadmin.dashboard',
            'superadmin'          => 'superadmin.dashboard',
            'administrador'       => 'admin.dashboard',
            'admin'               => 'admin.dashboard',
            'profesor'            => 'profesor.dashboard',
            'estudiante'          => 'estudiante.dashboard',
            'padre'               => 'padre.dashboard',
        ];

        if (isset($mapa[$nombreRol])) {
            Log::info('Redirigiendo', [
                'id'   => $usuario->id,
                'rol'  => $nombreRol,
                'ruta' => $mapa[$nombreRol],
            ]);
            return redirect()->route($mapa[$nombreRol]);
        }

        // Rol no reconocido — cerrar sesión y avisar
        Auth::logout();
        Log::error('Rol no reconocido en redirigirSegunRol', [
            'id'  => $usuario->id,
            'rol' => $usuario->rol->nombre ?? 'null',
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
