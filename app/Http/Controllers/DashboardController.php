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
     * Redirigir según el rol del usuario
     */
    public function redirect()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();

        switch ($usuario->id_rol) {
            case 1: // SuperAdmin
                return redirect()->route('superadmin.dashboard');

            case 2: // Administrador
                return redirect()->route('admins.dashboard');

            case 3: // Profesor
                return redirect()->route('profesor.dashboard');

            case 4: // Estudiante
                return redirect()->route('estudiante.dashboard');

            case 5: // Padre
                return redirect()->route('padre.dashboard');

            default:
                return $this->dashboardFallback();
        }
    }

    /**
     * Dashboard de Administrador
     */
    public function admin()
    {
        try {
            // Estadísticas
            $totalEstudiantes = Estudiante::where('activo', 1)->count();
            $estudiantesActivos = Estudiante::where('estado', 'activo')->count();
            $totalProfesores = Profesor::where('activo', 1)->count();
            $profesoresActivos = Profesor::where('estado', 'activo')->count();
            $totalCursos = Curso::count();
            $totalMatriculas = Matricula::count();
            $matriculasAprobadas = Matricula::where('estado', 'aprobada')->count();
            $matriculasPendientes = Matricula::where('estado', 'pendiente')->count();

            // Usuarios del sistema
            $totalUsuarios = User::where('activo', 1)->count();
            $totalAdministradores = User::whereIn('id_rol', [1, 2])
                ->where('activo', 1)->count();

            // Estudiantes por grado
            $estudiantesPorGrado = Estudiante::select('grado', DB::raw('count(*) as total'))
                ->where('estado', 'activo')
                ->groupBy('grado')
                ->orderBy('grado')
                ->get();

            // Estudiantes por sección
            $estudiantesPorSeccion = Estudiante::select('seccion', DB::raw('count(*) as total'))
                ->where('estado', 'activo')
                ->groupBy('seccion')
                ->orderBy('seccion')
                ->get();

            // Profesores por especialidad
            $profesoresPorEspecialidad = Profesor::select('especialidad', DB::raw('count(*) as total'))
                ->where('estado', 'activo')
                ->groupBy('especialidad')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            // Últimas matrículas
            $ultimasMatriculas = Matricula::with(['estudiante', 'padre'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            // Recientes
            $estudiantesRecientes = Estudiante::orderByDesc('created_at')->limit(5)->get();
            $profesoresRecientes = Profesor::orderByDesc('created_at')->limit(5)->get();

            // Período académico actual
            $periodoActual = PeriodoAcademico::where('fecha_inicio', '<=', now())
                ->where('fecha_fin', '>=', now())
                ->first();

            // 👉 Vista correcta del dashboard admin
            return view('admins.dashboard', compact(
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
     * Dashboard genérico si el rol no coincide
     */
    public function dashboardFallback()
    {
        $totalEstudiantes = Estudiante::where('activo', 1)->count();
        $totalProfesores = Profesor::where('activo', 1)->count();
        $totalMatriculas = Matricula::count();

        return view('superadmin.dashboard', compact(
            'totalEstudiantes',
            'totalProfesores',
            'totalMatriculas'
        ));
    }
}
