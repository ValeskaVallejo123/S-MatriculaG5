<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstudianteDashboardController extends Controller
{
    public function index()
    {
        //  Usuario autenticado
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Usuario no autenticado');
        }

        // Perfil estudiante (NO usuario)
        $estudiante = $user->estudiante;

        if (!$estudiante) {
            abort(403, 'Este usuario no tiene perfil de estudiante');
        }

        /*
        |------------------------------------------------------------------
        | DATOS DE EJEMPLO DEL DASHBOARD (NO SE BORRA NADA)
        |------------------------------------------------------------------
        */
        $misClases = 8;
        $asistencia = 95;
        $promedioGeneral = 88;
        $tareasPendientes = 3;

        $misMaterias = [
            ['nombre' => 'Matemáticas', 'profesor' => 'Prof. Juan Pérez', 'promedio' => 90, 'asistencia' => 95],
            ['nombre' => 'Lenguaje', 'profesor' => 'Prof. María López', 'promedio' => 88, 'asistencia' => 98],
            ['nombre' => 'Ciencias', 'profesor' => 'Prof. Carlos Martínez', 'promedio' => 85, 'asistencia' => 92],
            ['nombre' => 'Estudios Sociales', 'profesor' => 'Prof. Ana Rodríguez', 'promedio' => 92, 'asistencia' => 100],
        ];

        $tareasProximas = [
            ['materia' => 'Matemáticas', 'titulo' => 'Ejercicios de álgebra', 'fecha_entrega' => '2025-11-20', 'estado' => 'pendiente'],
            ['materia' => 'Lenguaje', 'titulo' => 'Ensayo sobre la lectura', 'fecha_entrega' => '2025-11-22', 'estado' => 'pendiente'],
            ['materia' => 'Ciencias', 'titulo' => 'Proyecto del sistema solar', 'fecha_entrega' => '2025-11-25', 'estado' => 'pendiente'],
        ];

        /*
        |------------------------------------------------------------------
        | NOTIFICACIONES (POR user_id, CORRECTO)
        |------------------------------------------------------------------
        */
        $notificacionesNoLeidas = Notificacion::where('user_id', $user->id)
            ->where('leida', false)
            ->get();

        $todasNotificaciones = Notificacion::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        /*
        |------------------------------------------------------------------
        | RETORNAR VISTA
        |------------------------------------------------------------------
        */
        return view('estudiante.dashboard.index', compact(
            'user',
            'estudiante',
            'misClases',
            'asistencia',
            'promedioGeneral',
            'tareasPendientes',
            'misMaterias',
            'tareasProximas',
            'notificacionesNoLeidas',
            'todasNotificaciones'
        ));
    }
}
