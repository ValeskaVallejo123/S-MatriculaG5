<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Padre;
use App\Models\Matricula;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal con estadísticas
     */
    public function index()
    {
        // Obtener estadísticas generales
        $stats = [
            'total_admins' => Admin::count(),
            'total_estudiantes' => Estudiante::count(),
            'total_profesores' => Profesor::count(),
            'total_padres' => Padre::count(),
            'total_matriculas' => Matricula::count(),
            
            // Matrículas por estado
            'matriculas_pendientes' => Matricula::where('estado', 'pendiente')->count(),
            'matriculas_aprobadas' => Matricula::where('estado', 'aprobada')->count(),
            'matriculas_rechazadas' => Matricula::where('estado', 'rechazada')->count(),
            
            // Nuevos registros hoy
            'estudiantes_hoy' => Estudiante::whereDate('created_at', today())->count(),
            'matriculas_hoy' => Matricula::whereDate('created_at', today())->count(),
            'profesores_hoy' => Profesor::whereDate('created_at', today())->count(),
            
            // Nuevos esta semana
            'estudiantes_semana' => Estudiante::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'matriculas_semana' => Matricula::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'profesores_semana' => Profesor::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
        
        // Estudiantes por grado
        $estudiantesPorGrado = Estudiante::selectRaw('grado, COUNT(*) as total')
            ->groupBy('grado')
            ->orderByRaw("
                CASE 
                    WHEN grado LIKE '%Primaria%' THEN 1
                    WHEN grado LIKE '%Secundaria%' THEN 2
                    ELSE 3
                END
            ")
            ->get();
        
        // Últimas matrículas
        $ultimasMatriculas = Matricula::with(['estudiante', 'padre'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Últimos estudiantes registrados
        $ultimosEstudiantes = Estudiante::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Actividad reciente
        $actividad_reciente = $this->obtenerActividadReciente();
        
        return view('dashboard.index', compact(
            'stats', 
            'estudiantesPorGrado',
            'ultimasMatriculas',
            'ultimosEstudiantes',
            'actividad_reciente'
        ));
    }
    
    /**
     * Obtiene la actividad reciente del sistema
     */
    private function obtenerActividadReciente()
    {
        $actividades = [];
        
        // Últimas matrículas
        $matriculas = Matricula::with('estudiante')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function($matricula) {
                return [
                    'tipo' => 'matricula_creada',
                    'icono' => 'file',
                    'color' => 'blue',
                    'mensaje' => "Nueva matrícula: " . ($matricula->estudiante->nombre_completo ?? 'Estudiante'),
                    'fecha' => $matricula->created_at,
                ];
            });
        
        // Últimos estudiantes
        $estudiantes = Estudiante::orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function($estudiante) {
                return [
                    'tipo' => 'estudiante_creado',
                    'icono' => 'user',
                    'color' => 'green',
                    'mensaje' => "Nuevo estudiante: {$estudiante->nombre_completo}",
                    'fecha' => $estudiante->created_at,
                ];
            });
        
        // Últimos profesores
        $profesores = Profesor::orderBy('created_at', 'desc')
            ->take(2)
            ->get()
            ->map(function($profesor) {
                return [
                    'tipo' => 'profesor_creado',
                    'icono' => 'briefcase',
                    'color' => 'purple',
                    'mensaje' => "Nuevo profesor: {$profesor->nombre_completo}",
                    'fecha' => $profesor->created_at,
                ];
            });
        
        // Combinar todas las actividades
        $actividades = array_merge(
            $matriculas->toArray(),
            $estudiantes->toArray(),
            $profesores->toArray()
        );
        
        // Ordenar por fecha
        usort($actividades, function($a, $b) {
            return $b['fecha'] <=> $a['fecha'];
        });
        
        return array_slice($actividades, 0, 10);
    }
}