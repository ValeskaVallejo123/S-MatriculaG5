<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Estudiante;

class ConsultaestudiantexcursoController extends Controller
{
    public function index()
    {
        $cursos = Estudiante::select('grado', 'seccion')
            ->selectRaw('COUNT(*) as total_estudiantes')
            ->groupBy('grado', 'seccion')
            ->paginate(15);

        return view('consultaestudiantesxcurso.index', compact('cursos'));
    }

    public function show($grado, $seccion)
    {
        $estudiantes = Estudiante::where('grado', $grado)
            ->where('seccion', $seccion)
            ->get();

        return view('consultaestudiantesxcurso.show', compact('estudiantes', 'grado', 'seccion'));
    }


}
