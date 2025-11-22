<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\PeriodoAcademico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Dashboard genérico - Redirige según el rol del usuario
     */
    public function redirect()
    {
        // Usar Auth facade en lugar de auth()
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();

        if (!$usuario->rol) {
            Log::warning('Usuario sin rol', ['id' => $usuario->id]);
            return view('admin.dashboard', [
                'totalEstudiantes' => 0,
                'totalProfesores' => 0,
                'totalMatriculas' => 0
            ]);
        }

        switch ($usuario->rol->nombre) {
            case 'Super Administrador':
                return redirect()->route('superadmin.dashboard');
            case 'Administrador':
                return $this->admin();
            case 'Profesor':
                return redirect()->route('profesor.dashboard');
            case 'Estudiante':
                return redirect()->route('estudiante.dashboard');
            case 'Padre':
                return redirect()->route('padre.dashboard');
            default:
                return view('dashboard', [
                    'totalEstudiantes' => 0,
                    'totalProfesores' => 0,
                    'totalMatriculas' => 0
                ]);
        }
    }

    /**
     * Dashboard del Administrador
     */
    public function admin()
    {
        try {
            // Estadísticas generales
            $totalEstudiantes = Estudiante::count();
            $estudiantesActivos = Estudiante::where('estado', 'activo')->count();
            $totalProfesores = Profesor::count();
            $profesoresActivos = Profesor::where('estado', 'activo')->count();
            $totalCursos = Curso::count();
            $totalMatriculas = Matricula::count();
            $matriculasAprobadas = Matricula::where('estado', 'aprobada')->count();
            $matriculasPendientes = Matricula::where('estado', 'pendiente')->count();

            // Usuarios del sistema
            $totalUsuarios = User::count();
            $totalAdministradores = User::whereHas('rol', function($query) {
                $query->whereIn('nombre', ['Administrador', 'Super Administrador']);
            })->count();

            // Estudiantes por grado
            $estudiantesPorGrado = Estudiante::select('grado', DB::raw('count(*) as total'))
                ->where('estado', 'activo')
                ->groupBy('grado')
                ->orderByRaw("FIELD(grado, '1ro Primaria', '2do Primaria', '3ro Primaria', '4to Primaria', '5to Primaria', '6to Primaria', '1ro Secundaria', '2do Secundaria', '3ro Secundaria')")
                ->get();

            // Estudiantes por sección
            $estudiantesPorSeccion = Estudiante::select('seccion', DB::raw('count(*) as total'))
                ->where('estado', 'activo')
                ->groupBy('seccion')
                ->orderBy('seccion')
                ->get();

            // Profesores por especialidad (top 5)
            $profesoresPorEspecialidad = Profesor::select('especialidad', DB::raw('count(*) as total'))
                ->where('estado', 'activo')
                ->groupBy('especialidad')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            // Últimas matrículas registradas
            $ultimasMatriculas = Matricula::with(['estudiante', 'padre'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            // Estudiantes registrados recientemente
            $estudiantesRecientes = Estudiante::orderByDesc('created_at')
                ->limit(5)
                ->get();

            // Profesores registrados recientemente
            $profesoresRecientes = Profesor::orderByDesc('created_at')
                ->limit(5)
                ->get();

            // Período académico actual
            $periodoActual = PeriodoAcademico::where('fecha_inicio', '<=', now())
                ->where('fecha_fin', '>=', now())
                ->first();

            return view('admin.dashboard', compact(
                'totalEstudiantes',
                'estudiantesActivos',
                'totalProfesores',
                'profesoresActivos',
                'totalCursos',
                'totalMatriculas',
                'matriculasAprobadas',
                'matriculasPendientes',
                'totalUsuarios',
                'totalAdministradores',
                'estudiantesPorGrado',
                'estudiantesPorSeccion',
                'profesoresPorEspecialidad',
                'ultimasMatriculas',
                'estudiantesRecientes',
                'profesoresRecientes',
                'periodoActual'
            ));
        } catch (\Exception $e) {
            Log::error('Error en dashboard admin', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error al cargar el dashboard');
        }
    }

    /**
     * Dashboard genérico (fallback)
     */
    public function index()
    {
        // Estadísticas básicas
        $totalEstudiantes = Estudiante::count();
        $totalProfesores = Profesor::count();
        $totalMatriculas = Matricula::count();

        return view('dashboard', compact(
            'totalEstudiantes',
            'totalProfesores',
            'totalMatriculas'
        ));
    }
}
