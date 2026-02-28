<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesorGradosController extends Controller
{
    public function __construct()
    {
        // Solo profesores pueden ver esto
        $this->middleware(['auth', 'rol:profesor']);
    }

    /**
     * Mostrar grado y sección donde el profesor es GUIA
     * Y los grados donde IMPARTE clases
     */
    public function index()
    {
        $profesor = Auth::user()->docente;

        if (!$profesor) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes perfil de profesor asignado.');
        }

        // Grado donde es profesor guía
        $gradoGuia = $profesor->gradoGuia;

        // Sección donde es profesor guía
        $seccionGuia = $profesor->seccion_guia;

        // Grados donde IMPARTE clases (si tienes esa relación)
        $gradosImpartidos = $profesor->gradosImpartidos ?? collect();

        return view('profesor.grados.index', compact(
            'profesor',
            'gradoGuia',
            'seccionGuia',
            'gradosImpartidos'
        ));
    }
}
