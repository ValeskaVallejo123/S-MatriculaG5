<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class CambiarContraseniaController extends Controller
{
    // Constructor opcional: quitamos el middleware auth
    public function __construct()
    {
        // $this->middleware('auth'); // Comentado para permitir acceso sin login
    }

    /**
     * Mostrar el formulario para cambiar la contraseña
     */
    public function edit()
    {
        return view('cambiarcontrasenia.editContrasenia');
    }

    /**
     * Actualizar la contraseña del usuario autenticado
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Verifica si hay usuario autenticado
        if (!$user) {
            return redirect()->back()->withErrors([
                'general' => 'No hay usuario autenticado. Esta acción requiere autenticación.'
            ]);
        }

        // Validación de campos
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Debe ingresar su contraseña actual.',
            'new_password.required' => 'Debe ingresar una nueva contraseña.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmación no coincide con la nueva contraseña.',
        ]);

        // Verifica si la contraseña actual es correcta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        // Actualiza la contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', '¡Tu contraseña ha sido cambiada correctamente!');
    }
}




