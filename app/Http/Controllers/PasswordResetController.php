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
    public function showForgotForm() {
        return view('recuperarcontrasenia.solicitar');
    }

    public function sendResetLink(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // Verificar si existe
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'El correo no está registrado.']);
        }

        // Borrar tokens antiguos del mismo correo
        DB::table('password_resets')->where('email', $email)->delete();

        // Crear token plano
        $token = Str::random(64);

        // Hashear para guardar, pero mantener el token real para el enlace
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => Hash::make($token),  // Se guarda hasheado
            'created_at' => Carbon::now()
        ]);

        // Crear link seguro basado en routes
        $link = route('password.reset.form', ['token' => $token, 'email' => $email]);

        // Enviar correo
        Mail::send('emails.recuperar_contrasenia', ['link' => $link], function($message) use ($email){
            $message->to($email)->subject('Recuperar contraseña');
        });

        return back()->with('status', 'Se ha enviado un enlace de recuperación.');
    }

    public function showResetForm($token) {
        $email = request()->query('email');
        return view('recuperarcontrasenia.restablecer', [
            'token' => $token,
            'email' => $email
        ]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);

        // Obtener registro del token
        $record = DB::table('password_resets')->where('email', $request->email)->first();

        // Validar token
        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token inválido']);
        }

        // Verificar expiración (1 hora)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Token expirado.']);
        }

        // Actualizar contraseña del usuario
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Borrar token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login.show')->with('success', 'Contraseña restablecida correctamente.');
    }
}
