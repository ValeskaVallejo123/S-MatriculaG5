<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

            // Obtener el usuario autenticado
            $user = Auth::user();

            // Redirección según el dominio del correo electrónico
            
            // Super Administrador - @egm.edu.hn
            if (Str::endsWith($user->email, '@egm.edu.hn')) {
                return redirect()->route('estudiantes.index')
                    ->with('success', 'Bienvenido Super Administrador');
            }
            
            // Administrador de Área - @admin.egm.edu.hn
            elseif (Str::endsWith($user->email, '@admin.egm.edu.hn')) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenido Administrador');
            }
            
            // Profesor - @profesor.egm.edu.hn
            elseif (Str::endsWith($user->email, '@profesor.egm.edu.hn')) {
                return redirect()->route('profesor.dashboard')
                    ->with('success', 'Bienvenido Profesor');
            }
            
            // Padre o Tutor - @padre.egm.edu.hn
            elseif (Str::endsWith($user->email, '@padre.egm.edu.hn')) {
                return redirect()->route('padre.dashboard')
                    ->with('success', 'Bienvenido Padre/Tutor');
            }
            
            // Estudiante - @estudiante.egm.edu.hn
            elseif (Str::endsWith($user->email, '@estudiante.egm.edu.hn')) {
                return redirect()->route('estudiante.dashboard')
                    ->with('success', 'Bienvenido Estudiante');
            }
            
            // Correo no autorizado
            else {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Correo no autorizado para este sistema.'
                ]);
            }
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