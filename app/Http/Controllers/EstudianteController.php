<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Notificacion; // Asegúrate de tener un modelo Notificacion
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    // ... tu CRUD actual ...

    /**
     * Mostrar las notificaciones del estudiante
     */
    public function notificaciones($id)
    {
        $estudiante = Estudiante::findOrFail($id);

        // Obtener solo notificaciones dirigidas a este estudiante
        $notificaciones = Notificacion::where('estudiante_id', $estudiante->id)
            ->orderByDesc('created_at')
            ->get();

        return view('estudiantes.notificaciones', compact('estudiante', 'notificaciones'));
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);

        // Verificar que la notificación pertenece al estudiante
        if ($notificacion->estudiante_id !== Auth::user()->estudiante->id) {
            abort(403, 'No tienes permiso para esta acción.');
        }

        $notificacion->update(['leida' => true]);

        return back()->with('success', 'Notificación marcada como leída.');
    }
}
