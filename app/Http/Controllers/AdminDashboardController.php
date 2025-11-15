<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        
        // Estadísticas del área administrativa
        $totalEstudiantes = Estudiante::count();
        $estudiantesActivos = Estudiante::where('estado', 'activo')->count();
        $totalProfesores = Profesor::count();
        $matriculasPendientes = Matricula::where('estado', 'pendiente')->count();
        
        // Actividades recientes del área
        $actividadesRecientes = [
            [
                'tipo' => 'matricula',
                'descripcion' => 'Nueva matrícula aprobada',
                'usuario' => 'Ana García',
                'fecha' => now()->subHours(2)
            ],
            [
                'tipo' => 'profesor',
                'descripcion' => 'Profesor actualizado',
                'usuario' => 'Carlos López',
                'fecha' => now()->subHours(5)
            ],
            [
                'tipo' => 'estudiante',
                'descripcion' => 'Nuevo estudiante registrado',
                'usuario' => 'María Rodríguez',
                'fecha' => now()->subHours(8)
            ]
        ];
        
        // Tareas pendientes del administrador
        $tareasPendientes = [
            [
                'titulo' => 'Revisar solicitudes de matrícula',
                'prioridad' => 'alta',
                'cantidad' => $matriculasPendientes
            ],
            [
                'titulo' => 'Actualizar información de profesores',
                'prioridad' => 'media',
                'cantidad' => 3
            ],
            [
                'titulo' => 'Generar reportes mensuales',
                'prioridad' => 'baja',
                'cantidad' => 1
            ]
        ];
        
        // Accesos rápidos
        $accesosRapidos = [
            [
                'titulo' => 'Matrículas',
                'icono' => 'fas fa-clipboard-list',
                'ruta' => 'matriculas.index',
                'color' => '#f093fb'
            ],
            [
                'titulo' => 'Estudiantes',
                'icono' => 'fas fa-user-graduate',
                'ruta' => 'estudiantes.index',
                'color' => '#4ec7d2'
            ],
            [
                'titulo' => 'Profesores',
                'icono' => 'fas fa-chalkboard-teacher',
                'ruta' => 'profesores.index',
                'color' => '#667eea'
            ],
            [
                'titulo' => 'Reportes',
                'icono' => 'fas fa-chart-bar',
                'ruta' => '#',
                'color' => '#fa709a'
            ]
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