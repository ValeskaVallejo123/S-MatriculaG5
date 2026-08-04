<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Estudiante;
use App\Models\Grado;
use App\Models\MateriaPorcentaje;
use App\Models\Materia;
use App\Models\PeriodoAcademico;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalificacionController extends Controller
{
    // ══════════════════════════════════════════
    //  PANEL DEL PROFESOR
    // ══════════════════════════════════════════

    public function indexProfesor(Request $request)
    {
        $profesor  = Profesor::where('user_id', Auth::id())->firstOrFail();
        $periodos  = PeriodoAcademico::orderBy('fecha_inicio')->get();
        $periodoId = $request->get('periodo_id', PeriodoAcademico::activos()->first()?->id ?? $periodos->first()?->id);
        $gradoId   = $request->get('grado_id');

        // Grados donde imparte este profesor (vía profesor_materia_grados)
        $grados = Grado::whereHas('profesorMateriaGrados', fn($q) =>
            $q->where('profesor_id', $profesor->id)
        )->get();

        if (!$gradoId && $grados->isNotEmpty()) {
            $gradoId = $grados->first()->id;
        }

        // Materias del profesor en ese grado
        $materias = Materia::whereHas('profesorMateriaGrados', fn($q) =>
            $q->where('profesor_id', $profesor->id)
              ->where('grado_id', $gradoId)
        )->get();

        // Estudiantes del grado
        $estudiantes = $gradoId
            ? Estudiante::where('grado_id', $gradoId)->orderBy('apellido1')->get()
            : collect();

        // Calificaciones existentes agrupadas por estudiante_materia
        $calificaciones = Calificacion::with(['estudiante', 'materia'])
            ->where('profesor_id', $profesor->id)
            ->where('periodo_id', $periodoId)
            ->where('grado_id', $gradoId)
            ->get()
            ->groupBy(fn($c) => $c->estudiante_id . '_' . $c->materia_id);

        // Porcentajes configurados
        $porcentajes = MateriaPorcentaje::where('profesor_id', $profesor->id)
            ->where('periodo_id', $periodoId)
            ->whereIn('materia_id', $materias->pluck('id'))
            ->get()
            ->keyBy('materia_id');

        return view('calificaciones.profesor', compact(
            'profesor', 'periodos', 'periodoId',
            'grados', 'gradoId', 'estudiantes', 'materias',
            'calificaciones', 'porcentajes'
        ));
    }

    public function guardarPorcentajes(Request $request)
    {
        $validated = $request->validate([
            'materia_id'         => 'required|exists:materias,id',
            'periodo_id'         => 'required|exists:periodos_academicos,id',
            'porcentaje_tarea'   => 'required|numeric|min:0|max:100',
            'porcentaje_parcial' => 'required|numeric|min:0|max:100',
            'porcentaje_final'   => 'required|numeric|min:0|max:100',
        ]);

        $suma = $validated['porcentaje_tarea'] +
                $validated['porcentaje_parcial'] +
                $validated['porcentaje_final'];

        if (round($suma, 2) !== 100.00) {
            return back()->withErrors(['porcentajes' => 'Los porcentajes deben sumar exactamente 100%.']);
        }

        $profesor = Profesor::where('user_id', Auth::id())->firstOrFail();

        MateriaPorcentaje::updateOrCreate(
            [
                'materia_id'  => $validated['materia_id'],
                'periodo_id'  => $validated['periodo_id'],
                'profesor_id' => $profesor->id,
            ],
            [
                'porcentaje_tarea'   => $validated['porcentaje_tarea'],
                'porcentaje_parcial' => $validated['porcentaje_parcial'],
                'porcentaje_final'   => $validated['porcentaje_final'],
            ]
        );

        return back()->with('success', 'Porcentajes guardados correctamente.');
    }

    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'periodo_id'                      => 'required|exists:periodos_academicos,id',
            'grado_id'                        => 'required|exists:grados,id',
            'calificaciones'                  => 'required|array',
            'calificaciones.*.estudiante_id'  => 'required|exists:estudiantes,id',
            'calificaciones.*.materia_id'     => 'required|exists:materias,id',
            'calificaciones.*.nota_tarea'     => 'nullable|numeric|min:0|max:100',
            'calificaciones.*.nota_parcial'   => 'nullable|numeric|min:0|max:100',
            'calificaciones.*.nota_final'     => 'nullable|numeric|min:0|max:100',
            'calificaciones.*.observaciones'  => 'nullable|string|max:500',
        ]);

        $profesor = Profesor::where('user_id', Auth::id())->firstOrFail();

        DB::transaction(function () use ($validated, $profesor) {
            foreach ($validated['calificaciones'] as $item) {
                Calificacion::updateOrCreate(
                    [
                        'estudiante_id' => $item['estudiante_id'],
                        'materia_id'    => $item['materia_id'],
                        'periodo_id'    => $validated['periodo_id'],
                    ],
                    [
                        'profesor_id'   => $profesor->id,
                        'grado_id'      => $validated['grado_id'],
                        'nota_tarea'    => $item['nota_tarea']    ?? null,
                        'nota_parcial'  => $item['nota_parcial']  ?? null,
                        'nota_final'    => $item['nota_final']    ?? null,
                        'observaciones' => $item['observaciones'] ?? null,
                    ]
                );
            }
        });

        return back()->with('success', 'Calificaciones guardadas correctamente.');
    }

    // ══════════════════════════════════════════
    //  PANEL DEL PADRE
    // ══════════════════════════════════════════

    public function indexPadre(Request $request)
    {
        // Estudiantes vinculados a este padre vía matriculas
        $padre       = Auth::user()->padre ?? null;
        $estudiantes = $padre
            ? Estudiante::whereHas('matriculas', fn($q) => $q->where('padre_id', $padre->id))->get()
            : collect();

        $periodos     = PeriodoAcademico::orderBy('fecha_inicio')->get();
        $estudianteId = $request->get('estudiante_id', $estudiantes->first()?->id);
        $periodoId    = $request->get('periodo_id');

        $estudianteSeleccionado = $estudiantes->find($estudianteId);

        $calificaciones = collect();
        $promedioGeneral = null;

        if ($estudianteId) {
            $query = Calificacion::with(['materia', 'periodo'])
                ->where('estudiante_id', $estudianteId);

            if ($periodoId) {
                $query->where('periodo_id', $periodoId);
            }

            $calificaciones = $query->get()
                ->groupBy('materia_id')
                ->map(fn($grupo) => [
                    'materia'          => $grupo->first()->materia,
                    'periodos'         => $grupo->keyBy('periodo_id'),
                    'promedio_general' => round($grupo->whereNotNull('promedio')->avg('promedio'), 2),
                ]);

            $promedioGeneral = round(
                $calificaciones->pluck('promedio_general')->filter()->avg(),
                2
            );
        }

        return view('calificaciones.padre', compact(
            'estudiantes', 'estudianteSeleccionado', 'periodos',
            'periodoId', 'calificaciones', 'promedioGeneral'
        ));
    }

    // ══════════════════════════════════════════
    //  PANEL DEL ESTUDIANTE
    // ══════════════════════════════════════════

    public function indexAlumno(Request $request)
    {
        $estudiante = Estudiante::where('user_id', Auth::id())->firstOrFail();
        $periodos   = PeriodoAcademico::orderBy('fecha_inicio')->get();
        $periodoId  = $request->get('periodo_id');

        $query = Calificacion::with(['materia', 'periodo'])
            ->where('estudiante_id', $estudiante->id);

        if ($periodoId) {
            $query->where('periodo_id', $periodoId);
        }

        $calificaciones = $query->get()
            ->groupBy('materia_id')
            ->map(fn($grupo) => [
                'materia'          => $grupo->first()->materia,
                'periodos'         => $grupo->keyBy('periodo_id'),
                'promedio_general' => round($grupo->whereNotNull('promedio')->avg('promedio'), 2),
                'estado_final'     => $this->estadoFinal($grupo->whereNotNull('promedio')->avg('promedio')),
            ]);

        $promedioGeneral     = round($calificaciones->pluck('promedio_general')->filter()->avg(), 2);
        $materias_aprobadas  = $calificaciones->where('estado_final', 'aprobado')->count();
        $materias_reprobadas = $calificaciones->where('estado_final', 'reprobado')->count();

        return view('calificaciones.alumno', compact(
            'estudiante', 'periodos', 'periodoId',
            'calificaciones', 'promedioGeneral',
            'materias_aprobadas', 'materias_reprobadas'
        ));
    }

    private function estadoFinal(?float $promedio): string
    {
        if (is_null($promedio)) return 'pendiente';
        return $promedio >= 60 ? 'aprobado' : 'reprobado';
    }
}