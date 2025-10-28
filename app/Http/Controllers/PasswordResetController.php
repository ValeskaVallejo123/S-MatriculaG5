<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Mostrar formulario para solicitar enlace de recuperación
     */
    public function showForgotForm()
    {
        return view('recuperarcontrasenia.solicitar');
    }

    /**
     * Enviar enlace de recuperación de contraseña
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes ingresar un correo electrónico válido.',
        ]);

        $email = $request->email;

        // Verificar si el correo existe en cualquier tipo de usuario
        if (!User::where('email', $email)->exists() &&
            !Admin::where('email', $email)->exists() &&
            !Estudiante::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'El correo no está registrado en el sistema.']);
        }

        // Crear token aleatorio y guardar hasheado en DB
        $token = Str::random(64);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Generar enlace de restablecimiento
        $link = url('/recuperarcontrasenia/restablecer/' . $token . '?email=' . urlencode($email));

        // Enviar correo
        Mail::send('emails.recuperar_contrasenia', ['link' => $link], function ($message) use ($email) {
            $message->to($email)
                    ->subject('Recuperar contraseña - Escuela Gabriela Mistral');
        });

        return back()->with('status', 'Se ha enviado un enlace de recuperación a tu correo.');
    }

    /**
     * Mostrar formulario para restablecer contraseña
     */
    public function showResetForm($token)
    {
        $email = request()->query('email');
        return view('recuperarcontrasenia.restablecer', [
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * Procesar restablecimiento de contraseña
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes ingresar un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $record = DB::table('password_resets')->where('email', $request->email)->first();

        // Verificar token y existencia
        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'El token es inválido.']);
        }

        // Verificar expiración (60 minutos)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'El token ha expirado. Solicita uno nuevo.']);
        }

        $email = $request->email;
        $newPassword = Hash::make($request->password);

        // Actualizar contraseña según tipo de usuario
        if ($user = User::where('email', $email)->first()) {
            $user->password = $newPassword;
            $user->save();
        } elseif ($admin = Admin::where('email', $email)->first()) {
            $admin->password = $newPassword;
            $admin->save();
        } elseif ($estudiante = Estudiante::where('email', $email)->first()) {
            $estudiante->password = $newPassword;
            $estudiante->save();
        } else {
            return back()->withErrors(['email' => 'No se encontró el usuario.']);
        }

        // Eliminar token usado
        DB::table('password_resets')->where('email', $email)->delete();

        return redirect()->route('login')
            ->with('status', 'Tu contraseña se ha restablecido correctamente. Ahora puedes iniciar sesión.');
    }
}
        