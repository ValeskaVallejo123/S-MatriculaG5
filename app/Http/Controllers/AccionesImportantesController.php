<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Solicitud;
use App\Models\RegistrarCalificacion;

class AccionesImportantesController extends Controller
{
    /**
     * Constructor del controlador
     * Aplica middleware para proteger el acceso a usuarios autenticados
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar información importante en el dashboard
     */
    public function index()
    {
        // Últimas 5 matrículas con relación estudiante
        $matriculasRecientes = Matricula::with('estudiante')
            ->latest()
            ->take(5)
            ->get();

        // Últimas 5 solicitudes pendientes con relación estudiante
        $solicitudesPendientes = Solicitud::with('estudiante')
            ->where('estado', 'pendiente')
            ->latest()
            ->take(5)
            ->get();

        // Últimas 5 calificaciones con relaciones estudiante, materia y curso
        $calificacionesRecientes = RegistrarCalificacion::with(['estudiante', 'materia', 'curso'])
            ->orderBy('fecha', 'desc') // asegúrate de que la columna fecha exista
            ->take(5)
            ->get();

        // Retornar la vista con los datos
        return view('acciones_importantes.index', compact(
            'matriculasRecientes',
            'solicitudesPendientes',
            'calificacionesRecientes'
        ));
    }
}
