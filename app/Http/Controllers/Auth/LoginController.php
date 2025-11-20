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
        $domain = substr(strrchr($email, "@"), 1);

        switch ($domain) {
            case 'egm.edu.hn':
            case 'admin.egm.edu.hn':
                return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido Administrador!');

            case 'profesor.egm.edu.hn':
                return redirect()->route('profesores.dashboard')->with('success', '¡Bienvenido Profesor!');

            case 'padre.egm.edu.hn':
                return redirect()->route('padres.dashboard')->with('success', '¡Bienvenido Padre/Tutor!');

            case 'estudiante.egm.edu.hn':
                return redirect()->route('estudiantes.dashboard')->with('success', '¡Bienvenido Estudiante!');

            case 'gmail.com':
            case 'yahoo.com':
            case 'yahoo.es':
            case 'yahoo.com.mx':
            case 'hotmail.com':
            case 'outlook.com':
            case 'live.com':
            default:
                return $this->redirectByUserRole();
        }
    }

    /**
     * Redirigir según el rol del usuario
     */
    protected function redirectByUserRole()
    {
        $user = Auth::user();

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

        return redirect()->route('home')->with('success', '¡Bienvenido!');
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
