<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (Str::endsWith($user->email, '@gm.hn')) {
                return redirect()->route('matricula.index');
            } elseif (Str::endsWith($user->email, '@adm.hn')) {
                return redirect()->route('admins.index');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Correo no autorizado.']);
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ]);
    }
}
