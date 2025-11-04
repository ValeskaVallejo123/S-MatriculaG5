<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => 'estudiante', // Por defecto es estudiante
        ]);

        Auth::login($user);

        // Guardar correo para sugerencias internas
        $correos = json_decode($request->cookie('correosRegistrados', '[]'), true);
        if (!in_array($user->email, $correos)) {
            $correos[] = $user->email;
        }

        return redirect($user->rol === 'admin' ? route('admins.index') : route('matriculas.index'))
            ->withCookie(cookie('correosRegistrados', json_encode($correos), 525600)); // 1 año
    }
}
