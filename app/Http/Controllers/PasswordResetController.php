<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // ──────────────────────────────────────────────────────────────
    // Formulario: solicitar enlace
    // ──────────────────────────────────────────────────────────────
    public function showForgotForm()
    {
        return view('recuperarcontrasenia.solicitar');
    }

    // ──────────────────────────────────────────────────────────────
    // Enviar enlace de recuperación al correo
    // ──────────────────────────────────────────────────────────────
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // CORRECCIÓN: no revelar si el correo existe o no (seguridad)
        $user = User::where('email', $email)->first();
        if (!$user) {
            // Mensaje genérico para no exponer qué correos existen
            return back()->with('status', 'Si el correo está registrado, recibirás un enlace en breve.');
        }

        // Borrar tokens antiguos del mismo correo
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Token plano para el enlace, hasheado para guardar en BD
        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email'      => $email,
            'token'      => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        // CORRECCIÓN: nombre de ruta correcto según web.php
        $link = route('password.restablecer', ['token' => $token, 'email' => $email]);

        // Enviar correo
        Mail::send('emails.recuperar_contrasenia', ['link' => $link, 'user' => $user], function ($message) use ($email) {
            $message->to($email)->subject('Recuperar contraseña - Escuela Gabriela Mistral');
        });

        return back()->with('status', 'Si el correo está registrado, recibirás un enlace en breve.');
    }

    // ──────────────────────────────────────────────────────────────
    // Formulario: nueva contraseña (con token)
    // ──────────────────────────────────────────────────────────────
    public function showResetForm($token)
    {
        $email = request()->query('email');

        // Verificar que el token exista antes de mostrar el formulario
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || !Hash::check($token, $record->token)) {
            return redirect()->route('password.solicitar')
                ->withErrors(['email' => 'El enlace de recuperación no es válido o ya fue usado.']);
        }

        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('password.solicitar')
                ->withErrors(['email' => 'El enlace ha expirado. Solicita uno nuevo.']);
        }

        return view('recuperarcontrasenia.restablecer', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    // ──────────────────────────────────────────────────────────────
    // Guardar nueva contraseña
    // ──────────────────────────────────────────────────────────────
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8', // CORRECCIÓN: mínimo 8 (buena práctica)
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        // Token inválido
        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'El enlace no es válido o ya fue utilizado.']);
        }

        // Token expirado
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('password.solicitar')
                ->withErrors(['email' => 'El enlace ha expirado. Solicita uno nuevo.']);
        }

        // Actualizar contraseña
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Usuario no encontrado.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Borrar token usado
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // CORRECCIÓN: nombre de ruta correcto según web.php
        return redirect()->route('login')->with('status', '✅ Contraseña restablecida correctamente. Ya puedes iniciar sesión.');
    }
}
