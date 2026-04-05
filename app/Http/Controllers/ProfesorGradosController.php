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
        $anio = date('Y');

        // Buscar el profesor por email del usuario autenticado
        $profesor = DB::table('profesores')
            ->where('email', $user->email)
            ->first();

        if (!$profesor) {
            return redirect()->route('profesor.dashboard')
                ->with('error', 'No tienes perfil de profesor asignado.');
        }

        // Obtener grados y materias asignados al profesor en el año actual
        $cursos = DB::table('profesor_materia_grados as pmg')
            ->join('grados', function ($j) use ($anio) {
                $j->on('pmg.grado_id', '=', 'grados.id')
                  ->where('grados.anio_lectivo', $anio);
            })
            ->join('materias', 'pmg.materia_id', '=', 'materias.id')
            ->where('pmg.profesor_id', $profesor->id)
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

        // Contar estudiantes activos por grado usando grado_id
        foreach ($cursos as $curso) {
            $curso->total_estudiantes = DB::table('estudiantes')
                ->where('grado_id', $curso->grado_id)
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
