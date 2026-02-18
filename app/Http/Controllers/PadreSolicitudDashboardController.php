<?php
// app/Http/Controllers/PadreSolicitudDashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;

class PadreSolicitudDashboardController extends Controller
{
    /**
     * Mostrar dashboard del padre con el estado de la solicitud
     */
    public function index()
    {
        // Obtener el ID de la solicitud desde la sesión
        $solicitudId = session('solicitud_id');

        // Verificar que existe
        if (!$solicitudId) {
            return redirect()->route('padres.login')
                ->with('error', 'Sesión expirada. Por favor, inicie sesión nuevamente.');
        }

        // Cargar la solicitud con la relación del estudiante
        $solicitud = Solicitud::with('estudiante')->findOrFail($solicitudId);

        // CAMBIO: Usar la vista que ya tienes del padre
        return view('padre.dashboard.index', compact('solicitud'));
    }
}