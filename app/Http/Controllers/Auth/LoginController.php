<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (Str::endsWith($user->email, '@gm.hn')) {
                return redirect()->route('matriculas.index');
            } elseif (Str::endsWith($user->email, '@adm.hn')) {
                return redirect()->route('admins.index');
            } else {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Correo no autorizado para acceder al sistema.']);
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas. Verifique su correo o contraseña.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }
}
