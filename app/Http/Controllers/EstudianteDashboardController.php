<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstudianteDashboardController extends Controller
{
    public function index()
    {
        // Usuario autenticado
        $usuario = Auth::user();
        $estudiante = $usuario->estudiante;

        // Datos de ejemplo del dashboard
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

        // ✅ Notificaciones solo del estudiante
        $notificacionesNoLeidas = Notificacion::where('estudiante_id', $estudiante->id)
                                              ->where('leida', false)
                                              ->get();

        $todasNotificaciones = Notificacion::where('estudiante_id', $estudiante->id)
                                           ->orderByDesc('created_at')
                                           ->get();

        // Retornar vista con los datos
        return view('estudiante.dashboard.index', compact(
            'usuario',
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
