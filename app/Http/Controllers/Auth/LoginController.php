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
     * Procesar login
     */
    public function login(Request $request)
    {
        // Validación
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intento de login
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Correo o contraseña incorrectos.',
            ])->withInput();
        }

        // Regenerar sesión
        $request->session()->regenerate();

        $usuario = Auth::user();

        // Usuario sin rol
        if (!$usuario->id_rol) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Tu cuenta no tiene rol asignado. Contacta al administrador.',
            ]);
        }

        // Usuario no activo (solo si NO es superadmin)
        if ($usuario->id_rol != 1 && $usuario->activo == 0) {

            // Notificar a administradores
            $admins = User::whereIn('id_rol', [1, 2])->get();

            foreach ($admins as $admin) {
                Notificacion::create([
                    'user_id' => $admin->id,
                    'titulo' => 'Cuenta pendiente de aprobación',
                    'mensaje' => "El usuario {$usuario->name} ({$usuario->email}) intentó iniciar sesión sin estar aprobado.",
                    'tipo' => 'administrativa',
                    'leida' => false,
                ]);
            }

            Auth::logout();

            return back()->withErrors([
                'email' => 'Tu cuenta necesita aprobación de un administrador.',
            ]);
        }

        // Redirección por rol
        return match ($usuario->id_rol) {
            1 => redirect()->route('superadmin.dashboard')->with('success', 'Bienvenido Super Administrador'),
            2 => redirect()->route('admins.dashboard')->with('success', 'Bienvenido Administrador'),
            3 => redirect()->route('profesor.dashboard')->with('success', 'Bienvenido Profesor'),
            4 => redirect()->route('estudiante.dashboard')->with('success', 'Bienvenido Estudiante'),
            5 => redirect()->route('padre.dashboard')->with('success', 'Bienvenido Padre'),
            default => redirect()->route('login')->with('warning', 'Rol no reconocido'),
        };
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
