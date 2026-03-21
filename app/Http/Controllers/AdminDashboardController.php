<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuario = Auth::user();

        // Verificar rol de acceso
        if (!in_array($usuario->id_rol, [1,2])) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        // Estadísticas
        $totalEstudiantes = Estudiante::count();
        $estudiantesActivos = Estudiante::where('estado', 'activo')->count();
        $totalProfesores = Profesor::count();
        $matriculasPendientes = Matricula::where('estado', 'pendiente')->count();

        // Actividades recientes: reemplazar con consultas dinámicas si quieres
        $actividadesRecientes = []; // se pueden traer de un log, o últimas matrículas/calificaciones

        // Tareas pendientes
        $tareasPendientes = [
            ['titulo' => 'Revisar solicitudes de matrícula', 'prioridad' => 'alta', 'cantidad' => $matriculasPendientes],
            ['titulo' => 'Actualizar información de profesores', 'prioridad' => 'media', 'cantidad' => 3],
            ['titulo' => 'Generar reportes mensuales', 'prioridad' => 'baja', 'cantidad' => 1],
        ];

        // Accesos rápidos
        $accesosRapidos = [
            ['titulo' => 'Matrículas', 'icono' => 'fas fa-clipboard-list', 'ruta' => route('matriculas.index'), 'color' => '#f093fb'],
            ['titulo' => 'Estudiantes', 'icono' => 'fas fa-user-graduate', 'ruta' => route('estudiantes.index'), 'color' => '#4ec7d2'],
            ['titulo' => 'Profesores', 'icono' => 'fas fa-chalkboard-teacher', 'ruta' => route('profesores.index'), 'color' => '#667eea'],
            ['titulo' => 'Reportes', 'icono' => 'fas fa-chart-bar', 'ruta' => '#', 'color' => '#fa709a'],
        ];

        return view('admin.dashboard.index', compact(
            'usuario',
            'totalEstudiantes',
            'estudiantesActivos',
            'totalProfesores',
            'matriculasPendientes',
            'actividadesRecientes',
            'tareasPendientes',
            'accesosRapidos'
        ));
    }
}
