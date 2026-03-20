<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Estudiante;
use App\Models\PeriodoAcademico;
use Illuminate\Support\Facades\Auth;

class MisCalificacionesController extends Controller
{
    /**
     * Vista de calificaciones para el estudiante logueado.
     * Solo muestra sus propias notas (read-only).
     */
    public function index()
    {
        $user       = Auth::user();
        $estudiante = Estudiante::where('user_id', $user->id)->with('gradoAsignado')->first();

        if (!$estudiante) {
            return view('estudiante.calificaciones', [
                'estudiante'      => null,
                'periodos'        => collect(),
                'porPeriodo'      => collect(),
                'resumenMaterias' => collect(),
                'promedioGeneral' => null,
            ]);
        }

        // Calificaciones del estudiante desde la tabla calificaciones (registradas por el profesor)
        $calificaciones = Calificacion::with(['materia', 'periodo', 'profesor'])
            ->where('estudiante_id', $estudiante->id)
            ->orderBy('periodo_id')
            ->orderBy('materia_id')
            ->get();

        $periodos = PeriodoAcademico::orderBy('id')->get()->keyBy('id');

        // Agrupar por período
        $porPeriodo = $calificaciones->groupBy('periodo_id');

        // Resumen por materia
        $resumenMaterias = $calificaciones
            ->groupBy('materia_id')
            ->map(function ($notas) {
                $conNota = $notas->whereNotNull('nota_final');
                return [
                    'materia'  => $notas->first()->materia,
                    'promedio' => $conNota->isNotEmpty() ? round($conNota->avg('nota_final'), 2) : null,
                    'aprobado' => $conNota->isNotEmpty() && $conNota->avg('nota_final') >= 60,
                    'notas'    => $notas,
                ];
            });

        // Promedio general
        $conNota         = $calificaciones->whereNotNull('nota_final');
        $promedioGeneral = $conNota->isNotEmpty() ? round($conNota->avg('nota_final'), 2) : null;

        return view('estudiante.calificaciones', compact(
            'estudiante',
            'periodos',
            'porPeriodo',
            'resumenMaterias',
            'promedioGeneral'
        ));
    }
}
