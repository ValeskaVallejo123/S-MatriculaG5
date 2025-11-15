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

class DashboardController extends Controller
{
    public function index()
    {
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
        $totalAdministradores = User::where('role', 'admin')
    ->orWhere('role', 'super_admin')
    ->count();
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

     return view('dashboard.index', compact(
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
    }
}