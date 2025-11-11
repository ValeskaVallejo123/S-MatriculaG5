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

            // Obtener el usuario autenticado
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
    }
}