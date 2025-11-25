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



class LoginController extends Controller
{

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



        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente');

        return redirect('/login')->with('success', 'Sesión cerrada exitosamente.');


        return redirect('/login')->with('success', 'Sesión cerrada correctamente');

    }
}