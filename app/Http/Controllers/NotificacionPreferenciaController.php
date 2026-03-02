<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionPreferencia;
use App\Models\User;

class NotificacionPreferenciaController extends Controller
{
    /**
     * Mostrar el formulario de preferencias del usuario
     */
    public function edit()
    {
        $user = Auth::user();

        // Obtener preferencias del usuario
        $preferencias = $user->notificacionPreferencias;

        // Si no existen, crearlas con valores por defecto
        if (!$preferencias) {
            $preferencias = NotificacionPreferencia::create([
                'user_id' => $user->id,

                // Canales
                'correo'                         => true,
                'mensaje_interno'                => true,
                'alerta_visual'                  => true,

                // Generales
                'notificacion_horario'           => true,
                'notificacion_administrativa'    => true,

                // Estudiante
                'notificacion_nueva_materia'     => true,
                'notificacion_calificaciones'    => true,
                'notificacion_observaciones'     => true,

                // Padre
                'notificacion_conducta'          => true,
                'notificacion_tareas'            => true,
                'notificacion_eventos'           => true,
                'notificacion_matricula'         => true,

                // Profesor
                'notificacion_estudiante_matricula' => true,
                'notificacion_recordatorio_docente' => true,
            ]);
        }

        return view('notificaciones.preferencias', compact('preferencias'));
    }

    /**
     * Actualizar preferencias
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $preferencias = $user->notificacionPreferencias;

        if (!$preferencias) {
            return back()->with('error', 'No se encontraron preferencias para actualizar.');
        }

        // Lista de campos permitidos (coincide con la migración + modelo)
        $campos = [
            'correo',
            'mensaje_interno',
            'alerta_visual',
            'notificacion_horario',
            'notificacion_administrativa',
            'notificacion_nueva_materia',
            'notificacion_calificaciones',
            'notificacion_observaciones',
            'notificacion_conducta',
            'notificacion_tareas',
            'notificacion_eventos',
            'notificacion_matricula',
            'notificacion_estudiante_matricula',
            'notificacion_recordatorio_docente',
        ];

        // Actualizar dinámicamente
        foreach ($campos as $campo) {
            $preferencias->{$campo} = $request->has($campo);
        }

        $preferencias->save();

        return back()->with('success', 'Tus preferencias han sido actualizadas correctamente.');
    }

    /**
     * Listar notificaciones del usuario, según su rol
     */
    public function index()
    {
        $user = Auth::user();

        // Cargar notificaciones del usuario
        $notificaciones = $user->notificaciones()->orderBy('created_at', 'desc')->get();

        // Vista por rol
        return match ($user->id_rol) {
            4 => view('estudiante.notificaciones.index', compact('notificaciones')),
            3 => view('profesor.notificaciones.index', compact('notificaciones')),
            5 => view('padre.notificaciones.index', compact('notificaciones')),
            1 => view('superadmin.notificaciones.index', compact('notificaciones')),
            2 => view('admin.notificaciones.index', compact('notificaciones')),
            default => abort(403, 'Rol no autorizado'),
        };
    }
}
