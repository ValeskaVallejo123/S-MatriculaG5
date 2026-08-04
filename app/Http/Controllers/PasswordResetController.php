<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class PasswordResetController extends Controller
{

public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email|exists:users,email'], [
        'email.exists' => 'No encontramos un usuario con ese correo electrónico.'
    ]);

    // 1. Crear un token único
    $token = Str::random(64);

    // 2. Guardar en la tabla password_resets
    DB::table('password_resets')->updateOrInsert(
        ['email' => $request->email],
        [
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]
    );

    // 3. Enviar el correo
    Mail::send('recuperarcontrasenia.email_link', ['token' => $token, 'email' => $request->email], function($message) use($request){
        $message->to($request->email);
        $message->subject('Restablecer Contraseña - Escuela Gabriela Mistral');
    });

    return back()->with('status', '¡Hemos enviado un enlace de recuperación a tu correo!');
}
    // Muestra el formulario para ingresar el correo (solicitar.blade.php)
    public function showForgotForm()
    {
        return view('recuperarcontrasenia.solicitar');
    }

    // Muestra el formulario de los hexágonos (restablecer.blade.php)
    public function showResetForm($token, Request $request)
    {
        return view('recuperarcontrasenia.restablecer', [
            'token' => $token, 
            'email' => $request->email
        ]);
    }

    // Procesa el cambio final de contraseña
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
        ]);

        // 1. Verificar si el token existe y es válido para ese correo
        $reset = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'El enlace es inválido o ha expirado.']);
        }

        // 2. Actualizar la contraseña en la tabla users
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // 3. Borrar el token para que no se use de nuevo
        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('login')->with('status', '¡Contraseña restablecida con éxito!');
    }
}