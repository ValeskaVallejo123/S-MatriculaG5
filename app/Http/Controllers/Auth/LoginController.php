<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // Mostrar el formulario de login
    public function showLoginForm()
    {
        return view('login'); // Asegúrate que resources/views/login.blade.php exista
    }

    // Procesar login
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar iniciar sesión
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Evitar fijación de sesión
            $user = Auth::user();

            // Redirección según dominio del correo
            if (Str::endsWith($user->email, '@gm.hn')) {
                return redirect()->route('matriculas.index');
            } elseif (Str::endsWith($user->email, '@adm.hn')) {
                return redirect()->route('admins.index');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Correo no autorizado para este sistema.'
                ]);
            }
        }

        // Si falla el inicio de sesión
        return back()->withErrors([
            'email' => 'Las credenciales ingresadas no son correctas.',
        ])->withInput();
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }
}
