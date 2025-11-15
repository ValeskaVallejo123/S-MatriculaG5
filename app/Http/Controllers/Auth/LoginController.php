<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
<<<<<<< HEAD
    /**
     * Mostrar formulario de login
     */
=======
>>>>>>> origin/main
    public function showLoginForm()
    {
        return view('auth.login');
    }

<<<<<<< HEAD
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

            // Redirigir según el rol del usuario
            if ($user->role === 'super_admin') {
                // Redirigir al perfil del super admin
                return redirect()->route('superadmin.perfil')
                    ->with('success', 'Bienvenido Super Administrador');
            } elseif ($user->role === 'admin') {
                return redirect()->intended('/dashboard')
                    ->with('success', 'Bienvenido Administrador');
            } else {
                return redirect()->intended('/dashboard')
                    ->with('success', 'Bienvenido');
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
=======
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('error', 'Credenciales incorrectas.');
        }

        return $this->authenticated($request, Auth::user());
    }

    protected function authenticated(Request $request, $user)
    {
        if (str_ends_with($user->email, '@gmail.edu')) {
            $user->rol = 'admin';
            $user->save();
            return redirect()->route('admins.index');
        }

        $user->rol = 'estudiante';
        $user->save();
        return redirect()->route('matriculas.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.show');
>>>>>>> origin/main
    }
}