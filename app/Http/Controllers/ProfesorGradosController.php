<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use App\Models\Grado;

class ProfesorGradosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:profesor']);
    }

    /**
     * Mostrar los cursos (grados + materia) asignados al profesor autenticado
     */
    public function index()
    {
        $user = Auth::user();

        // Buscar el profesor por email del usuario autenticado
        $profesor = DB::table('profesores')
            ->where('email', $user->email)
            ->first();

        if (!$profesor) {
            return redirect()->route('profesor.dashboard')
                ->with('error', 'No tienes perfil de profesor asignado.');
        }

        // Obtener todos los grados y materias asignados al profesor
        $cursos = DB::table('profesor_materia_grados')
            ->join('grados', 'profesor_materia_grados.grado_id', '=', 'grados.id')
            ->join('materias', 'profesor_materia_grados.materia_id', '=', 'materias.id')
            ->where('profesor_materia_grados.profesor_id', $profesor->id)

            ->select(
                'grados.id as grado_id',
                'grados.nivel',
                'grados.numero',
                'grados.seccion',
                'grados.anio_lectivo',
                'materias.id as materia_id',
                'materias.nombre as materia_nombre',
                'materias.area',
            )
            ->orderBy('grados.numero')
            ->orderBy('grados.seccion')
            ->get();

        // Contar estudiantes activos por grado
        foreach ($cursos as $curso) {
            $curso->total_estudiantes = DB::table('estudiantes')
                ->where('grado', $curso->numero)
                ->where('seccion', $curso->seccion)
                ->where('estado', 'activo')
                ->count();
        }

        // Agrupar por grado para mostrar varias materias por grado
        $gradosAgrupados = $cursos->groupBy(fn($c) => $c->grado_id);

        $totalCursos     = $gradosAgrupados->count();
        $totalMaterias   = $cursos->count();
        $totalEstudiantes = $cursos->groupBy('grado_id')
            ->map(fn($g) => $g->first()->total_estudiantes)
            ->sum();

        return view('profesor.grados.index', compact(
            'profesor',
            'gradosAgrupados',
            'totalCursos',
            'totalMaterias',
            'totalEstudiantes'
        ));
    }
}
