<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CambiarContraseniaController extends Controller
{
    // Mostrar el formulario
    public function edit()
    {

        return view('editContrasenia');
    }

    // Actualizar la contraseña
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'La contraseña actual no es correcta.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Tu contraseña ha sido cambiada exitosamente.');
    }
}


