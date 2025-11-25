<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        // Buscar el usuario por email
        $usuario = User::where('email', $request->email)->first();

        // Verificar si el usuario existe
        if (!$usuario) {
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        // Verificar si la cuenta está activa
        if (isset($usuario->activo) && !$usuario->activo) {
            return back()->withErrors([
                'email' => 'Tu cuenta está pendiente de aprobación. Un administrador debe activarla antes de que puedas acceder.',
            ])->onlyInput('email');
        }

        // Verificar si tiene rol asignado
        if (!$usuario->rol_id && !$usuario->id_rol) {
            return back()->withErrors([
                'email' => 'Tu cuenta no tiene un rol asignado. Por favor contacta al administrador.',
            ])->onlyInput('email');
        }

        // Intentar autenticar
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $usuario = Auth::user();

            // Redirigir según el rol del usuario
            if ($usuario->rol) {
                $nombreRol = $usuario->rol->nombre;

                switch ($nombreRol) {
                    case 'Super Administrador':
                        return redirect()->route('superadmin.dashboard')
                            ->with('success', 'Bienvenido Super Administrador');
                    
                    case 'Administrador':
                        return redirect()->route('admin.dashboard')
                            ->with('success', 'Bienvenido Administrador');
                    
                    case 'Profesor':
                        return redirect()->route('profesor.dashboard')
                            ->with('success', 'Bienvenido Profesor');
                    
                    case 'Estudiante':
                        return redirect()->route('estudiante.dashboard')
                            ->with('success', 'Bienvenido Estudiante');
                    
                    case 'Padre':
                        return redirect()->route('padre.dashboard')
                            ->with('success', 'Bienvenido Padre/Tutor');
                    
                    default:
                        // Si el rol no coincide con ninguno, redirigir a /home
                        return redirect()->route('home')
                            ->with('warning', 'Rol no reconocido. Contacta al administrador.');
                }
            }

            // Si no tiene rol asignado (fallback)
            Auth::logout();
            return back()->withErrors([
                'email' => 'Tu cuenta no tiene un rol asignado. Por favor contacta al administrador.',
            ])->onlyInput('email');
        }

        // Si falla la autenticación
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
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
