<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login (con soporte para cookie de correo)
     */
    public function showLogin(Request $request)
    {
        return view('auth.login', [
            'correoGuardado' => $request->cookie('correo_usuario') ?? ''
        ]);
    }

    /**
     * Mostrar formulario de login (método alternativo)
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login con validación completa y múltiples opciones
     */
    public function login(Request $request)
    {
        // Validar credenciales
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $inputEmail = $request->email;
        $password = $request->password;

        // Primero intentar login exacto con Auth::attempt (método seguro estándar)
        $credentials = [
            'email' => $inputEmail,
            'password' => $password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Guardar correo en cookie para autocompletar
            $cookie = cookie('correo_usuario', $user->email, 525600);

            // Redirigir según el rol del usuario
            if ($user->role === 'super_admin' || $user->rol === 'super_admin') {
                return redirect()->route('superadmin.perfil')
                    ->with('success', 'Bienvenido Super Administrador')
                    ->withCookie($cookie);
            } elseif ($user->role === 'admin' || $user->rol === 'admin') {
                return redirect()->intended(route('admins.index'))
                    ->with('success', 'Bienvenido Administrador')
                    ->withCookie($cookie);
            } else {
                return redirect()->intended(route('matriculas.index'))
                    ->with('success', 'Bienvenido')
                    ->withCookie($cookie);
            }
        }

        // Si falla el login exacto, intentar búsqueda parcial (fallback)
        $user = User::where('email', 'like', "%{$inputEmail}%")->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            // Guardar correo en cookie para autocompletar
            $cookie = cookie('correo_usuario', $user->email, 525600);

            // Redirigir según el rol del usuario
            if ($user->role === 'super_admin' || $user->rol === 'super_admin') {
                return redirect()->route('superadmin.perfil')
                    ->with('success', 'Bienvenido Super Administrador')
                    ->withCookie($cookie);
            } elseif ($user->role === 'admin' || $user->rol === 'admin') {
                return redirect()->intended(route('admins.index'))
                    ->with('success', 'Bienvenido Administrador')
                    ->withCookie($cookie);
            } else {
                return redirect()->intended(route('matriculas.index'))
                    ->with('success', 'Bienvenido')
                    ->withCookie($cookie);
            }

            
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
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente');

        return redirect('/login')->with('success', 'Sesión cerrada exitosamente.');

    }
}