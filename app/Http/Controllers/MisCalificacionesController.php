<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\RegistrarCalificacion;
use App\Models\PeriodoAcademico;
use Illuminate\Support\Facades\Auth;

class MisCalificacionesController extends Controller
{
    /**
     * Vista de calificaciones para el estudiante logueado.
     * Solo muestra sus propias notas.
     */
    public function index()
    {
        $user = Auth::user();

        // Obtener el registro de estudiante vinculado al usuario
        $estudiante = Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            return view('estudiante.calificaciones', [
                'estudiante'      => null,
                'periodos'        => collect(),
                'porPeriodo'      => collect(),
                'resumenMaterias' => collect(),
                'promedioGeneral' => null,
            ]);
        }

        // Todas las calificaciones del estudiante
        $calificaciones = RegistrarCalificacion::with(['materia', 'periodoAcademico', 'profesor', 'grado'])
            ->where('estudiante_id', $estudiante->id)
            ->orderBy('periodo_academico_id')
            ->orderBy('materia_id')
            ->get();

        $periodos = PeriodoAcademico::all()->keyBy('id');

        // Agrupar por período
        $porPeriodo = $calificaciones->groupBy('periodo_academico_id');

        // Resumen por materia (promedio de todos los períodos)
        $resumenMaterias = $calificaciones
            ->groupBy('materia_id')
            ->map(function ($notas) {
                $conNota = $notas->whereNotNull('nota');
                return [
                    'materia'  => $notas->first()->materia,
                    'promedio' => $conNota->isNotEmpty() ? round($conNota->avg('nota'), 2) : null,
                    'aprobado' => $conNota->isNotEmpty() && $conNota->avg('nota') >= 60,
                    'notas'    => $notas,
                ];
            });

        // Promedio general
        $conNota = $calificaciones->whereNotNull('nota');
        $promedioGeneral = $conNota->isNotEmpty() ? round($conNota->avg('nota'), 2) : null;

        return view('estudiante.calificaciones', compact(
            'estudiante',
            'periodos',
            'porPeriodo',
            'resumenMaterias',
            'promedioGeneral'
        ));
    }
}
