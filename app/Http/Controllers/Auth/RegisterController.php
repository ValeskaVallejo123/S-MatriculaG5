<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|in:admin,estudiante',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        // Guardar correo y contraseña en cookie temporal (solo para autocompletar interno)
        $cookie = cookie('correo_usuario', $user->email, 525600);

        return redirect(route('login.show'))
            ->withCookie($cookie)
            ->with('success', 'Registro exitoso, ahora inicia sesión.');
    }
}
