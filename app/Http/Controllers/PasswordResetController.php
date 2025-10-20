<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    /**
     * Muestra el formulario para solicitar el enlace de recuperación.
     */
    public function showForgotForm()
    {
        // Vista personalizada dentro de resources/views/recuperarcontrasenia/
        return view('recuperarcontrasenia.solicitar');
    }

    /**
     * Envía el enlace de recuperación al correo del usuario.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'El correo ingresado no está registrado.',
            'email.email' => 'El formato del correo no es válido.',
        ]);


        // Generar token y guardarlo en la tabla password_resets
        $reset = PasswordReset::generateToken($request->email);

        // Enlace de recuperación
        $link = url('/password/reset/' . $reset->token);

        // Enviar correo con plantilla Blade
        Mail::send('emails.recuperar_contrasenia', ['link' => $link], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Recuperar contraseña - Escuela Gabriela Mistral');
        });

        return back()->with('status', 'Se ha enviado un enlace de recuperación a tu correo.');
    }

    /**
     * Muestra el formulario para establecer una nueva contraseña.
     */
    public function showResetForm($token)
    {
        return view('recuperarcontrasenia.restablecer', ['token' => $token]);
    }

    /**
     * Guarda la nueva contraseña del usuario.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Buscar registro en tabla password_resets
        $reset = PasswordReset::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'El token es inválido o ha expirado.']);
        }

        // Actualizar la contraseña del usuario
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Eliminar token usado
        $reset->delete();

        return redirect('/login')->with('status', 'Tu contraseña se ha restablecido correctamente.');
    }
}
