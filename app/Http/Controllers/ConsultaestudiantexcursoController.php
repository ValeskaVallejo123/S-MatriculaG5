<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Grado;
use App\Models\ProfesorMateriaGrado;

class ConsultaestudiantexcursoController extends Controller
{
    public function index()
    {
        // Agrupa estudiantes por grado+seccion (texto real de la BD)
        $cursos = Estudiante::select('grado', 'seccion')
            ->selectRaw('COUNT(*) as total_estudiantes')
            ->whereNotNull('grado')
            ->whereNotNull('seccion')
            ->where('grado', '!=', '')
            ->where('seccion', '!=', '')
            ->groupBy('grado', 'seccion')
            ->orderBy('grado')
            ->orderBy('seccion')
            ->get();

        return view('consultaestudiantesxcurso.index', compact('cursos'));
    }

    public function show($grado, $seccion)
    {
        $estudiantes = Estudiante::where('grado', $grado)
            ->where('seccion', $seccion)
            ->orderBy('apellido1')
            ->orderBy('nombre1')
            ->get();

        return view('consultaestudiantesxcurso.show', compact(
            'estudiantes', 'grado', 'seccion'
        ));
    }
}
