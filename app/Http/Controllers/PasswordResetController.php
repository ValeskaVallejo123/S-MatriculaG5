<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Estudiante;
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
        return view('recuperarcontrasenia.solicitar');
    }

    /**
     * Envía el enlace de recuperación al correo del usuario.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
        ]);

        $email = $request->email;

        // Verificar si el correo existe en alguna de las tablas
        $existsInUsers = User::where('email', $email)->exists();
        $existsInAdmins = Admin::where('email', $email)->exists();
        $existsInEstudiantes = Estudiante::where('email', $email)->exists();

        if (!($existsInUsers || $existsInAdmins || $existsInEstudiantes)) {
            return back()->withErrors(['email' => 'El correo ingresado no está registrado en el sistema.']);
        }

        // Generar token y guardarlo
        $reset = PasswordReset::generateToken($email);

        // Enlace de recuperación
        $link = url('/password/restablecer/' . $reset->token);

        // Enviar correo usando tu plantilla personalizada
        Mail::send('emails.recuperar_contrasenia', ['link' => $link], function ($message) use ($email) {
            $message->to($email)
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
     * Guarda la nueva contraseña del usuario, administrador o estudiante.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Buscar registro en tabla password_resets
        $reset = PasswordReset::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'El token es inválido o ha expirado.']);
        }

        $email = $request->email;
        $newPassword = Hash::make($request->password);

        // Buscar en cada tabla y actualizar
        if ($user = User::where('email', $email)->first()) {
            $user->update(['password' => $newPassword]);
        } elseif ($admin = Admin::where('email', $email)->first()) {
            $admin->update(['password' => $newPassword]);
        } elseif ($estudiante = Estudiante::where('email', $email)->first()) {
            $estudiante->update(['password' => $newPassword]);
        } else {
            return back()->withErrors(['email' => 'No se encontró ninguna cuenta asociada a este correo.']);
        }

        // Eliminar token usado
        $reset->delete();

        return redirect('/login')->with('status', 'Tu contraseña se ha restablecido correctamente.');
    }
}
