<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class ConsultaestudiantexcursoController extends Controller
{
    // Mostrar todos los cursos con cantidad de estudiantes
    public function index()
    {
        // Traemos los cursos con conteo de estudiantes
        $cursos = Curso::withCount('estudiantes')->paginate(15);

        return view('cursos.index', compact('cursos'));
    }

    // Mostrar detalle de un curso con sus estudiantes
    public function show($id)
    {
        $curso = Curso::with('estudiantes')->findOrFail($id);

        return view('cursos.show', compact('curso'));
    }

}
