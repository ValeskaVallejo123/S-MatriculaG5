<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grado; // Modelo de Grados
use Illuminate\Support\Facades\Auth;

class ProfesorGradosController extends Controller
{
    /**
     * Mostrar los grados donde enseña el profesor
     */
    public function index()
    {
        // Obtener el profesor relacionado con el usuario autenticado
        $profesor = Auth::user()->docente; // Asegúrate de tener la relación docente() en User

        if (!$profesor) {
            return redirect()->route('dashboard')->with('error', 'No tienes perfil de profesor asignado.');
        }

        // Obtener los grados donde enseña este profesor
        $grados = $profesor->grados ?? collect(); // relación profesor->grados()

        return view('profesor.grados.index', compact('grados', 'profesor'));
    }
}
