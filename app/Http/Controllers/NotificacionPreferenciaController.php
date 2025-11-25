<?php

namespace App\Http\Controllers;

use App\Models\NotificacionPreferencia;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionPreferenciaController extends Controller
{
    /**
     * Mostrar el formulario de preferencias de notificación
     */
    public function edit()
    {
        $preferencias = Auth::user()->notificacionPreferencias;

        // Crear preferencias por defecto si no existen
        if (!$preferencias) {
            $preferencias = NotificacionPreferencia::create([
                'user_id' => Auth::id(),
                // Valores por defecto para nuevas notificaciones
                'correo' => true,
                'mensaje_interno' => true,
                'alerta_visual' => true,
                'notificacion_horario' => true,
                'notificacion_administrativa' => true,
                'notificacion_nueva_materia' => true,
                'notificacion_calificaciones' => true,
                'notificacion_observaciones' => true,
                'notificacion_estudiante_matricula' => true,
                'notificacion_recordatorio_docente' => true,
            ]);
        }

        return view('notificaciones.preferencias', compact('preferencias'));
    }

    /**
     * Actualizar las preferencias de notificación
     */
    public function update(Request $request)
    {
        $preferencias = Auth::user()->notificacionPreferencias;

        $preferencias->update([
            // Canales de notificación
            'correo' => $request->has('correo'),
            'mensaje_interno' => $request->has('mensaje_interno'),
            'alerta_visual' => $request->has('alerta_visual'),

            // Tipos de notificación generales
            'notificacion_horario' => $request->has('notificacion_horario'),
            'notificacion_administrativa' => $request->has('notificacion_administrativa'),

            // Notificaciones específicas para estudiantes
            'notificacion_nueva_materia' => $request->has('notificacion_nueva_materia'),
            'notificacion_calificaciones' => $request->has('notificacion_calificaciones'),
            'notificacion_observaciones' => $request->has('notificacion_observaciones'),

            // Notificaciones específicas para profesores
            'notificacion_estudiante_matricula' => $request->has('notificacion_estudiante_matricula'),
            'notificacion_recordatorio_docente' => $request->has('notificacion_recordatorio_docente'),
        ]);

        return back()->with('success', 'Tus preferencias han sido actualizadas correctamente.');
    }
    /**
     * Listar notificaciones del estudiante
     */
    public function index()
    {
        $user = Auth::user();
        $notificaciones = $user->notificaciones()->orderBy('created_at', 'desc')->get();

        return view('estudiante.notificaciones.index', compact('notificaciones'));
    }

    /**
     * Listar notificaciones del profesor
     */
    public function indexProfesor()
    {
        $user = Auth::user();
        $notificaciones = $user->notificaciones()->orderBy('created_at', 'desc')->get();

        return view('profesor.notificaciones.index', compact('notificaciones'));
    }
}
