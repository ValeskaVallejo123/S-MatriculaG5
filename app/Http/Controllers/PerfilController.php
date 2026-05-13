<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    /**
     * Mostrar el perfil del usuario autenticado.
     */
    public function mostrarPerfil()
    {
        $usuario = Auth::user();
        return view('Perfil.perfil', compact('usuario'));
    }

    /**
     * Actualizar datos del perfil del usuario autenticado.
     */
    public function actualizarPerfil(Request $request)
    {
        $usuario = Auth::user();

        // Validar datos del perfil
        $request->validate([
            'name' => 'required|string|max:255',
            // el email debe ser único, excepto el propio usuario
            'email' => 'required|email|unique:users,email,' . $usuario->id,
        ]);

        // Actualizar datos
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->save();

        return redirect()
            ->route('perfil.mostrar')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}
