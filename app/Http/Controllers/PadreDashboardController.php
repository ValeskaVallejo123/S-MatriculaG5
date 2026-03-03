<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PadreDashboardController extends Controller
{
    /**
     * Dashboard principal del padre/tutor.
     * Carga todos sus hijos vinculados con sus matrículas aprobadas.
     */
    public function index()
    {
        $user  = Auth::user();
        $padre = $user->padre;

        if (!$padre) {
            abort(403, 'No tienes un perfil de padre/tutor vinculado.');
        }

        // Cargar hijos con sus matrículas aprobadas
        $matriculas = $padre->matriculas()
            ->with('estudiante')
            ->where('estado', 'aprobada')
            ->orderBy('anio_lectivo', 'desc')
            ->get();

        // También cargar matrículas en otros estados para mostrar historial
        $todasMatriculas = $padre->matriculas()
            ->with('estudiante')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('padre.dashboard', compact('padre', 'matriculas', 'todasMatriculas'));
    }

    /**
     * Vista de detalle de un hijo específico.
     */
    public function verHijo($estudianteId)
    {
        $user  = Auth::user();
        $padre = $user->padre;

        if (!$padre) {
            abort(403);
        }

        // Verificar que este estudiante realmente sea hijo de este padre
        $matricula = $padre->matriculas()
            ->with('estudiante')
            ->where('estudiante_id', $estudianteId)
            ->where('estado', 'aprobada')
            ->firstOrFail();

        $estudiante = $matricula->estudiante;

        return view('padre.hijo', compact('padre', 'estudiante', 'matricula'));
    }
}