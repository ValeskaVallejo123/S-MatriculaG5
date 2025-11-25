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
        // Obtener el usuario logueado
        $usuario = Auth::user();

        // Obtener el estudiante asociado al usuario
        
        // Reemplaza esta línea con la lógica real de tu aplicación
        $estudiante = Estudiante::first(); // <-- Temporal, reemplazar con: $usuario->estudiante;

        // Datos de ejemplo del dashboard
        $misClases = 8; // Total de materias
        $asistencia = 95; // Porcentaje de asistencia
        $promedioGeneral = 88; // Promedio general
        $tareasPendientes = 3; // Tareas pendientes

        // Materias del estudiante (datos de ejemplo)
        $misMaterias = [
            [
                'nombre' => 'Matemáticas',
                'profesor' => 'Prof. Juan Pérez',
                'promedio' => 90,
                'asistencia' => 95
            ],
            [
                'nombre' => 'Lenguaje',
                'profesor' => 'Prof. María López',
                'promedio' => 88,
                'asistencia' => 98
            ],
            [
                'nombre' => 'Ciencias',
                'profesor' => 'Prof. Carlos Martínez',
                'promedio' => 85,
                'asistencia' => 92
            ],
            [
                'nombre' => 'Estudios Sociales',
                'profesor' => 'Prof. Ana Rodríguez',
                'promedio' => 92,
                'asistencia' => 100
            ]
        ];

        // Tareas próximas (datos de ejemplo)
        $tareasProximas = [
            [
                'materia' => 'Matemáticas',
                'titulo' => 'Ejercicios de álgebra',
                'fecha_entrega' => '2025-11-20',
                'estado' => 'pendiente'
            ],
            [
                'materia' => 'Lenguaje',
                'titulo' => 'Ensayo sobre la lectura',
                'fecha_entrega' => '2025-11-22',
                'estado' => 'pendiente'
            ],
            [
                'materia' => 'Ciencias',
                'titulo' => 'Proyecto del sistema solar',
                'fecha_entrega' => '2025-11-25',
                'estado' => 'pendiente'
            ]
        ];

        // Obtener notificaciones no leídas del estudiante
        $// Notificaciones no leídas
$notificacionesNoLeidas = $usuario->notificaciones
                                  ->where('leida', false); // Collection ya filtrada en memoria

// Todas las notificaciones ordenadas por fecha
$todasNotificaciones = $usuario->notificaciones
                               ->sortByDesc('created_at');


        // Retornar la vista con todos los datos
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
