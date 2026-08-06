<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargaDocenteController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->get('anio', date('Y'));

        // ── 1. Base: profesores con sus grados y materias ────────────────────
        $profesores = DB::table('profesores')
            ->leftJoin('profesor_materia_grados as pmg', 'profesores.id', '=', 'pmg.profesor_id')
            ->leftJoin('grados', function ($j) use ($anio) {
                $j->on('pmg.grado_id', '=', 'grados.id')
                  ->where('grados.anio_lectivo', $anio);
            })
            ->leftJoin('materias', 'pmg.materia_id', '=', 'materias.id')
            ->where('profesores.estado', 'activo')
            ->select(
                'profesores.id',
                'profesores.nombre',
                'profesores.apellido',
                'profesores.especialidad',
                'profesores.tipo_contrato',
                DB::raw('COUNT(DISTINCT pmg.materia_id) as total_materias'),
                DB::raw('COUNT(DISTINCT pmg.grado_id)   as total_grados'),
                DB::raw('SUM(DISTINCT 0)                as total_horas'),   // placeholder
                DB::raw('GROUP_CONCAT(DISTINCT materias.nombre ORDER BY materias.nombre SEPARATOR ", ") as nombres_materias'),
                DB::raw('GROUP_CONCAT(DISTINCT
                    CONCAT(grados.numero, "° ", CONCAT(UPPER(SUBSTRING(grados.nivel,1,1)), LOWER(SUBSTRING(grados.nivel,2))), " — Sec. ", grados.seccion)
                    ORDER BY grados.numero, grados.seccion SEPARATOR ", ") as nombres_grados')
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

        // ── 2. Para cada profesor: contar estudiantes y armar detalle ────────
        foreach ($profesores as $profesor) {

            // Grados asignados a este profesor (filtrado por año)
            $gradoIds = DB::table('profesor_materia_grados as pmg')
                ->join('grados', 'pmg.grado_id', '=', 'grados.id')
                ->where('pmg.profesor_id', $profesor->id)
                ->where('grados.anio_lectivo', $anio)
                ->pluck('pmg.grado_id')
                ->unique()
                ->values()
                ->toArray();

            if (empty($gradoIds)) {
                $profesor->total_estudiantes    = 0;
                $profesor->total_horas          = 0;
                $profesor->estudiantes_detalle  = '[]';
                $profesor->estudiantes_por_grado = '{}';
                continue;
            }

            // Estudiantes asignados a esos grados vía grado_id
            $estudiantes = DB::table('estudiantes')
                ->join('grados', 'estudiantes.grado_id', '=', 'grados.id')
                ->whereIn('estudiantes.grado_id', $gradoIds)
                ->where('estudiantes.estado', 'activo')
                ->select(
                    'estudiantes.id',
                    'estudiantes.nombre1',
                    'estudiantes.nombre2',
                    'estudiantes.apellido1',
                    'estudiantes.apellido2',
                    'estudiantes.dni',
                    'grados.numero',
                    'grados.nivel',
                    'grados.seccion'
                )
                ->orderBy('grados.numero')
                ->orderBy('grados.seccion')
                ->orderBy('estudiantes.apellido1')
                ->get();

            // Detalle para el modal (nombre, dni, grado label)
            $detalle = $estudiantes->map(function ($e) {
                $nombre = trim(
                    trim("{$e->nombre1} {$e->nombre2}") . ' ' .
                    trim("{$e->apellido1} {$e->apellido2}")
                );
                $gradoLabel = "{$e->numero}° " . ucfirst($e->nivel) . " — Sec. {$e->seccion}";

                return [
                    'nombre' => $nombre,
                    'dni'    => $e->dni ?? '',
                    'grado'  => $gradoLabel,
                    'materia' => '',    // se podría agregar si se necesita
                ];
            })->values()->toArray();

            // Conteo por grado (para la columna expandible)
            $porGrado = [];
            foreach ($estudiantes as $e) {
                $key = "{$e->numero}° " . ucfirst($e->nivel) . " — Sec. {$e->seccion}";
                $porGrado[$key] = ($porGrado[$key] ?? 0) + 1;
            }

            // Horas: materias asignadas × 4 horas semanales (aproximado)
            $totalHoras = DB::table('profesor_materia_grados as pmg')
                ->join('grados', 'pmg.grado_id', '=', 'grados.id')
                ->where('pmg.profesor_id', $profesor->id)
                ->where('grados.anio_lectivo', $anio)
                ->count() * 4;

            $profesor->total_estudiantes     = $estudiantes->count();
            $profesor->total_horas           = $totalHoras;
            $profesor->estudiantes_detalle   = json_encode($detalle);
            $profesor->estudiantes_por_grado = json_encode($porGrado);
        }

        // ── 3. Solo profesores con materias asignadas, ordenados por estudiantes ─
        $profesores = $profesores->filter(fn($p) => $p->total_materias > 0)
                                  ->sortByDesc('total_estudiantes')
                                  ->values();

        // ── 4. Stats globales ────────────────────────────────────────────────
        $totalProfesores = $profesores->count();           // solo con carga
        $totalConCarga   = $totalProfesores;
        $totalSinCarga   = Profesor::where('estado', 'activo')->count() - $totalProfesores;
        $promEstudiantes = $totalProfesores > 0
            ? round($profesores->avg('total_estudiantes'), 1)
            : 0;

        // ── 5. Años disponibles ──────────────────────────────────────────────
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
