<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLogin(Request $request)
    {
        return view('auth.login', [
            'correoGuardado' => $request->cookie('correo_usuario') ?? ''
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $inputEmail = $request->email;
        $password = $request->password;

        // Buscar usuario por coincidencia parcial del correo
        $user = User::where('email', 'like', "%{$inputEmail}%")->first();

        if($user && Hash::check($password, $user->password)){
            Auth::login($user);

            // Guardar correo en cookie para autocompletar interno
            $cookie = cookie('correo_usuario', $user->email, 525600);

            return redirect($user->rol === 'admin' ? route('admins.index') : route('matriculas.index'))
                ->withCookie($cookie);
        }

        return back()->withErrors(['email' => 'Usuario o contraseña incorrectos']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.show');
    }
}
