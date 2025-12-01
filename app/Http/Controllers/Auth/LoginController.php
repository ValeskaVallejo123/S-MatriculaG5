<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notificacion;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        // Validar credenciales
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Intentar autenticar
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $usuario = Auth::user();

            /*
            |--------------------------------------------------------------------------
            | 🔥 BLOQUEAR ACCESO A USUARIOS INACTIVOS
            | Y NOTIFICAR AL SUPERADMIN/ADMIN
            |--------------------------------------------------------------------------
            */

            if ($usuario->id_rol !== 1 && isset($usuario->activo) && !$usuario->activo) {

                // Obtener superadmins y admins
                $destinatarios = User::whereIn('id_rol', [1, 2])->get();

                foreach ($destinatarios as $admin) {
                    Notificacion::create([
                        'user_id' => $admin->id,
                        'titulo' => 'Cuenta pendiente de aprobación',
                        'mensaje' => "El usuario {$usuario->name} ({$usuario->email}) intentó iniciar sesión, pero su cuenta aún no está activada.",
                        'tipo' => 'administrativa',
                        'leida' => false,
                    ]);
                }

                Auth::logout();

                return back()->withErrors([
                    'email' => 'Tu cuenta está pendiente de aprobación. Un administrador debe activarla antes de que puedas acceder.',
                ])->withInput();
            }

            /*
            |--------------------------------------------------------------------------
            | 🔒 USUARIO SIN ROL ASIGNADO
            |--------------------------------------------------------------------------
            */
            if (!$usuario->rol) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta no tiene un rol asignado. Por favor contacta al administrador.',
                ])->withInput();
            }

           /*
|--------------------------------------------------------------------------
| 🔀 REDIRIGIR SEGÚN ROL (POR ID, NO POR NOMBRE)
|--------------------------------------------------------------------------
*/
$rolId = $usuario->id_rol;

switch ($rolId) {

    case 1: // super_admin
        return redirect()->route('superadmin.dashboard')
            ->with('success', 'Bienvenido Super Administrador');

    case 7: // Administrador
        return redirect()->route('admin.dashboard')
            ->with('success', 'Bienvenido Administrador');

    case 3: // Profesor
        return redirect()->route('profesor.dashboard')
            ->with('success', 'Bienvenido Profesor');

    case 4: // Estudiante
        return redirect()->route('estudiante.dashboard')
            ->with('success', 'Bienvenido Estudiante');

    case 5: // Padre
        return redirect()->route('padre.dashboard')
            ->with('success', 'Bienvenido Padre/Tutor');

    case 8: // Maestro
        return redirect()->route('profesor.dashboard')
            ->with('success', 'Bienvenido Maestro');

    default:
        Auth::logout();
        return redirect()->route('login')
            ->with('warning', 'Rol no reconocido. Contacta al administrador.');
}

        }

        /*
        |--------------------------------------------------------------------------
        | ❌ Credenciales incorrectas
        |--------------------------------------------------------------------------
        */
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput();
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada correctamente');
    }
}
