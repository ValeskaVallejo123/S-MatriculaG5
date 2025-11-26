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
        $usuario = Auth::user(); // Usuario autenticado
        return view('Perfil.perfil', compact('usuario'));
    }

    /**
     * Actualizar los datos del perfil del usuario (opcional si lo implementarás).
     */
    public function actualizarPerfil(Request $request)
    {
        $usuario = Auth::user();

        // Validar datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        // Actualizar datos en la base
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->save();

        // Redirigir con mensaje
        return redirect()->route('perfil.mostrar')->with('success', 'Perfil actualizado correctamente.');
    }
}

