<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','min:3','max:50','regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => ['required','max:100','unique:users,email','regex:/^[\w.+-]+@(gm|adm)\.hn$/'],
            'password' => ['required','confirmed','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo ya está registrado.',
            'email.regex' => 'Solo se permiten correos que terminen en @gm.hn o @adm.hn.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Autologin
        Auth::login($user);

        // Redirigir según dominio
        if (str_ends_with($user->email, '@gm.hn')) {
            return redirect()->route('matriculas.index')->with('success', 'Bienvenido, '.$user->name.'!');
        } elseif (str_ends_with($user->email, '@adm.hn')) {
            return redirect()->route('admins.index')->with('success', 'Bienvenido, '.$user->name.'!');
        }

        return redirect()->route('login')->with('status', 'Usuario registrado correctamente.');
    }
}
