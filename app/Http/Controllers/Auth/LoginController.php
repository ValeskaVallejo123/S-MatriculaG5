<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

<<<<<<< HEAD
            $user = Auth::user();

            // Redirigir según el dominio del correo
            return $this->redirectByEmailDomain($user->email);
        }

        // Si falla la autenticación
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    /**
     * Redirigir según el dominio del correo electrónico
     */
    protected function redirectByEmailDomain($email)
    {
        // Extraer el dominio del correo
        $domain = substr(strrchr($email, "@"), 1);

        // Definir redirecciones según el dominio
        switch ($domain) {
            // Super Administrador
            case 'egm.edu.hn':
                return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido Super Administrador!');

            // Administrador de área
            case 'admin.egm.edu.hn':
                return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido Administrador!');

            // Profesor
            case 'profesor.egm.edu.hn':
                return redirect()->route('profesores.dashboard')->with('success', '¡Bienvenido Profesor!');

            // Padre/Tutor
            case 'padre.egm.edu.hn':
                return redirect()->route('padres.dashboard')->with('success', '¡Bienvenido Padre/Tutor!');

            // Estudiante
            case 'estudiante.egm.edu.hn':
                return redirect()->route('estudiantes.dashboard')->with('success', '¡Bienvenido Estudiante!');

            // Gmail - Permitir acceso general (puedes personalizarlo)
            case 'gmail.com':
                return $this->redirectByUserRole();

            // Yahoo - Permitir acceso general (puedes personalizarlo)
            case 'yahoo.com':
            case 'yahoo.es':
            case 'yahoo.com.mx':
                return $this->redirectByUserRole();

            // Hotmail/Outlook - Por si también quieres aceptarlos
            case 'hotmail.com':
            case 'outlook.com':
            case 'live.com':
                return $this->redirectByUserRole();

            // Dominio no reconocido - Redirigir según rol del usuario
            default:
                return $this->redirectByUserRole();
        }
    }

    /**
     * Redirigir según el rol del usuario (para correos públicos como Gmail, Yahoo, etc.)
     */
    protected function redirectByUserRole()
    {
        $user = Auth::user();

        // Verificar si el usuario tiene un campo 'rol' o 'role'
        if (isset($user->rol)) {
            switch ($user->rol) {
                case 'super_admin':
                case 'superadmin':
                    return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido Super Administrador!');

                case 'admin':
                case 'administrador':
                    return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido Administrador!');

                case 'profesor':
                case 'teacher':
                    return redirect()->route('profesores.dashboard')->with('success', '¡Bienvenido Profesor!');

                case 'padre':
                case 'tutor':
                case 'parent':
                    return redirect()->route('padres.dashboard')->with('success', '¡Bienvenido Padre/Tutor!');

                case 'estudiante':
                case 'student':
                    return redirect()->route('estudiantes.dashboard')->with('success', '¡Bienvenido Estudiante!');

                default:
                    return redirect()->route('home')->with('success', '¡Bienvenido!');
            }
        }

        // Si no tiene rol definido, redirigir a una página general
        return redirect()->route('home')->with('success', '¡Bienvenido!');
=======
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
                    return redirect()->route('dashboard')
                        ->with('success', 'Bienvenido al sistema');
            }
        }

        // Si no tiene rol asignado
        return redirect()->route('dashboard')
            ->with('success', 'Bienvenido');
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
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

        return redirect('/login')->with('success', 'Sesión cerrada exitosamente.');
    }
}
