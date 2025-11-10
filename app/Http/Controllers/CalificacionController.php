<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Calificacion;
use App\Models\Materia;
use App\Models\PeriodoAcademico;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function indexCalificaciones(Request $request)
    {
        // Filtros
        $periodoId = $request->input('periodo_id');
        $materiaId = $request->input('materia_id');

        // Consulta base
        $query = Calificacion::with(['materia', 'periodo']);

        if ($periodoId) $query->where('periodo_id', $periodoId);
        if ($materiaId) $query->where('materia_id', $materiaId);

        $calificaciones = $query->get();
        $promedio = $calificaciones->avg('nota');

        $materias = Materia::all();
        $periodos = PeriodoAcademico::all();

        // Retornar la vista
        return view('calificaciones.indexCalificaciones', compact('calificaciones', 'promedio', 'materias', 'periodos'));
    }
}


