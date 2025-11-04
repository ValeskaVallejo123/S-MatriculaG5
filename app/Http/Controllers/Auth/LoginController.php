<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            // Obtener usuario autenticado
            $user = Auth::user();

            // ✅ Redirección correcta según rol
            if ($user->rol === 'admin') {
                return redirect()->route('admins.index'); // Panel Admin
            } else {
                return redirect()->route('matriculas.index'); // Vista Estudiante
            }
        }

        return back()->with('error', 'Correo o contraseña incorrectos.')->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.show');
    }
}
