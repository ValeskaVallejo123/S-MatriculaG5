<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Solicitud;
use App\Models\RegistrarCalificacion;

class AccionesImportantesController extends Controller
{
    public function index()
    {
        // Últimas matrículas
        $matriculasRecientes = Matricula::with('estudiante')
            ->latest()
            ->take(5)
            ->get();

        // Solicitudes pendientes
        $solicitudesPendientes = Solicitud::with('estudiante')
            ->where('estado', 'pendiente')
            ->latest()
            ->take(5)
            ->get();

        // Últimas calificaciones
        $calificacionesRecientes = RegistrarCalificacion::with(['estudiante', 'materia', 'curso'])
            ->latest()
            ->take(5)
            ->get();

        return view('acciones_importantes.index', compact(
            'matriculasRecientes',
            'solicitudesPendientes',
            'calificacionesRecientes'
        ));

    }
}

