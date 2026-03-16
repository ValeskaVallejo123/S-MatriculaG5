<?php

namespace App\Http\Controllers;

//use App\Models\Profesor;
use App\Models\Grado;
//use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargaDocenteController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->get('anio', date('Y'));

        // Obtener carga docente: por cada profesor, cuántos grados y materias tiene
        // y cuántos estudiantes hay en esos grados
        $profesores = DB::table('profesores')
            ->leftJoin('profesor_materia_grados', 'profesores.id', '=', 'profesor_materia_grados.profesor_id')
            ->leftJoin('grados', 'profesor_materia_grados.grado_id', '=', 'grados.id')
            ->leftJoin('materias', 'profesor_materia_grados.materia_id', '=', 'materias.id')
            ->where('profesores.estado', 'activo')
            ->when($anio, function ($q) use ($anio) {
                $q->where(function ($q2) use ($anio) {
                    $q2->where('grados.anio_lectivo', $anio)
                       ->orWhereNull('grados.anio_lectivo');
                });
            })
            ->select(
                'profesores.id',
                'profesores.nombre',
                'profesores.apellido',
                'profesores.especialidad',
                'profesores.tipo_contrato',
                DB::raw('COUNT(DISTINCT profesor_materia_grados.materia_id) as total_materias'),
                DB::raw('COUNT(DISTINCT profesor_materia_grados.grado_id) as total_grados'),
                DB::raw('GROUP_CONCAT(DISTINCT materias.nombre ORDER BY materias.nombre SEPARATOR ", ") as nombres_materias'),
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(grados.numero, "° ", grados.seccion) ORDER BY grados.numero SEPARATOR ", ") as nombres_grados')
            )
            ->groupBy(
                'profesores.id',
                'profesores.nombre',
                'profesores.apellido',
                'profesores.especialidad',
                'profesores.tipo_contrato'
            )
            ->orderByDesc('total_materias')
            ->get();

        // Calcular total de estudiantes por profesor según los grados asignados
        foreach ($profesores as $profesor) {
            $gradoIds = DB::table('profesor_materia_grados')
                ->where('profesor_id', $profesor->id)
                ->pluck('grado_id')
                ->unique()
                ->toArray();

            $totalEstudiantes = 0;

            if (!empty($gradoIds)) {
                $grados = Grado::whereIn('id', $gradoIds)
                    ->when($anio, fn($q) => $q->where('anio_lectivo', $anio))
                    ->get();

                foreach ($grados as $grado) {
                    $count = DB::table('estudiantes')
                        ->where('grado', $grado->numero)
                        ->where('seccion', $grado->seccion)
                        ->where('estado', 'activo')
                        ->count();
                    $totalEstudiantes += $count;
                }
            }

            $profesor->total_estudiantes = $totalEstudiantes;
        }

        // Ordenar por total_estudiantes desc
        $profesores = $profesores->sortByDesc('total_estudiantes')->values();

        // Stats globales
        $totalProfesores = $profesores->count();
        $totalConCarga   = $profesores->filter(fn($p) => $p->total_materias > 0)->count();
        $totalSinCarga   = $totalProfesores - $totalConCarga;
        $promEstudiantes = $totalProfesores > 0
            ? round($profesores->avg('total_estudiantes'), 1)
            : 0;

        // Años disponibles para el filtro
        $aniosDisponibles = Grado::select('anio_lectivo')
            ->distinct()
            ->orderByDesc('anio_lectivo')
            ->pluck('anio_lectivo');

        return view('carga-docente.index', compact(
            'profesores',
            'anio',
            'aniosDisponibles',
            'totalProfesores',
            'totalConCarga',
            'totalSinCarga',
            'promEstudiantes'
        ));
    }
}
