<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CambioContrasenia;
use App\Models\User;

class CambiarContraseniaController extends Controller
{
    /**
     * Muestra el formulario para cambiar la contraseña
     */
    public function edit()
    {
        return view('usuarios.cambiar_contrasenia');
    }

    /**
     * Actualiza la contraseña del usuario autenticado
     */
    public function update(Request $request)
    {
        $request->validate([
            'password_actual' => ['required'],
            'nueva_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password_actual.required' => 'Debe ingresar su contraseña actual.',
            'nueva_password.required' => 'Debe ingresar una nueva contraseña.',
            'nueva_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'nueva_password.confirmed' => 'La confirmación no coincide con la nueva contraseña.',
        ]);

        $user = Auth::user();

        // Verifica si la contraseña actual es correcta
        if (!Hash::check($request->password_actual, $user->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }

        // Guarda el historial del cambio en la tabla cambio_contrasenias
        CambioContrasenia::create([
            'user_id' => $user->id,
            'old_password' => $user->password,
            'new_password' => Hash::make($request->nueva_password),
        ]);

        // Actualiza la contraseña del usuario
        $user->password = Hash::make($request->nueva_password);
        $user->save();

        return redirect()->route('perfil')->with('success', '¡Tu contraseña ha sido cambiada correctamente!');
    }
}
