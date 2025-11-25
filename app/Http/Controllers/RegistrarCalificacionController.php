<?php

namespace App\Http\Controllers;

use App\Models\RegistrarCalificacion;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Materia;
use App\Models\Estudiante;
use App\Models\PeriodoAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrarCalificacionController extends Controller
{
    // Mostrar listado de calificaciones del profesor logueado
    public function index()
    {
        $profesor = auth()->user();

        $calificaciones = RegistrarCalificacion::with(['estudiante', 'materia', 'curso', 'periodoAcademico'])
            ->where('profesor_id', $profesor->id)
            ->get();

        return view('registrarcalificaciones.index', compact('calificaciones'));

    }

    // Mostrar formulario para registrar calificaciones (filtros)
    public function create(Request $request)
    {
        $profesor = auth()->user();

        // Si tienes relación profesor-cursos, filtra aquí. Por ahora traemos todos.
        $cursos = Curso::all();
        $materias = Materia::all();
        $periodos = PeriodoAcademico::all();

        // Si vienen curso+periodo (GET), cargar estudiantes matriculados
        $estudiantes = collect();
        $calificacionesExistentes = [];
        $observacionesExistentes = [];

        if ($request->has('curso') && $request->has('periodo')) {
            $cursoId = (int) $request->input('curso');

            // Obtener estudiantes matriculados — ADAPTAR según tu esquema de matriculas
            // Preferible: usar relación matriculas. Ej:
            // $estudiantes = Estudiante::whereHas('matriculas', fn($q) => $q->where('curso_id', $cursoId))->get();
            // Si tu esquema usa 'grado' en estudiantes:
            $estudiantes = Estudiante::where('grado', $cursoId)->get();

            // Cargar calificaciones existentes para prefill
            $periodoId = (int) $request->input('periodo');
            $materiaId = $request->input('materia') ? (int)$request->input('materia') : null;
            $profesorId = $profesor->id;

            $query = RegistrarCalificacion::where('profesor_id', $profesorId)
                ->where('curso_id', $cursoId)
                ->where('periodo_academico_id', $periodoId);

            if ($materiaId) {
                $query->where('materia_id', $materiaId);
            }

            $existing = $query->get();
            foreach ($existing as $c) {
                $calificacionesExistentes[$c->estudiante_id] = $c->nota;
                $observacionesExistentes[$c->estudiante_id] = $c->observacion;
            }
        }

        return view('registrarcalificaciones.registrarcalificaciones', compact(
            'cursos','materias','periodos','estudiantes','calificacionesExistentes','observacionesExistentes'
        ));

    }

    // Cargar estudiantes según curso seleccionado (AJAX)
    public function obtenerEstudiantes($curso_id)
    {
        // Si existe tabla matriculas usar whereHas; si no usas 'grado' ajustar:
        $estudiantes = Estudiante::where('grado', $curso_id)->get();

        return response()->json($estudiantes);
    }

    // Guardar las calificaciones (store)
    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'materia_id' => 'required|exists:materias,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            'notas' => 'required|array|min:1',
            'notas.*' => 'nullable|numeric|min:0|max:100',
            'observacion' => 'nullable|array',
            'observacion.*' => 'nullable|string|max:2000',
        ]);

        $profesorId = auth()->id();
        $cursoId = (int)$request->curso_id;
        $materiaId = (int)$request->materia_id;
        $periodoId = (int)$request->periodo_academico_id;

        // Validar que los estudiantes enviados pertenecen al curso seleccionado
        $estudianteIds = array_map('intval', array_keys($request->notas));

        // ADAPTAR: usar tabla matriculas si existe. Ej:
        // $validEstudiantes = Estudiante::whereHas('matriculas', fn($q) => $q->where('curso_id', $cursoId))
        //     ->whereIn('id', $estudianteIds)->pluck('id')->toArray();

        // Si tu esquema usa 'grado' en la tabla estudiantes:
        $validEstudiantes = Estudiante::whereIn('id', $estudianteIds)
            ->where('grado', $cursoId)
            ->pluck('id')
            ->toArray();

        DB::transaction(function () use ($request, $profesorId, $cursoId, $materiaId, $periodoId, $validEstudiantes) {
            $rows = [];
            foreach ($request->notas as $estudianteId => $nota) {
                $estudianteId = (int)$estudianteId;
                if (! in_array($estudianteId, $validEstudiantes)) {
                    continue; // prevenir manipulación
                }

                $rows[] = [
                    'profesor_id' => $profesorId,
                    'curso_id' => $cursoId,
                    'materia_id' => $materiaId,
                    'estudiante_id' => $estudianteId,
                    'periodo_academico_id' => $periodoId,
                    'nota' => is_null($nota) ? null : (float)$nota,
                    'observacion' => $request->observacion[$estudianteId] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (! empty($rows)) {
                // upsert para insertar o actualizar según unique key
                RegistrarCalificacion::upsert(
                    $rows,
                    ['profesor_id','curso_id','materia_id','estudiante_id','periodo_academico_id'],
                    ['nota','observacion','updated_at']
                );
            }
        });

        return redirect()->route('registrarcalificaciones.index')->with('success', 'Calificaciones registradas correctamente.');

    }

    // Editar una calificación
    public function edit($id)
    {
        $calificacion = RegistrarCalificacion::findOrFail($id);
        $periodos = PeriodoAcademico::all();

        return view('calificaciones.edit', compact('calificacion', 'periodos'));
    }

    // Actualizar una calificación
    public function update(Request $request, $id)
    {
        $request->validate([
            'nota' => 'required|numeric|min:0|max:100',
            'observacion' => 'nullable|string|max:2000',
        ]);

        $calificacion = RegistrarCalificacion::findOrFail($id);

        $calificacion->update([
            'nota' => (float)$request->nota,
            'observacion' => $request->observacion,
        ]);

        return redirect()->route('calificaciones.index')->with('success', 'Calificación actualizada.');
    }

    // Eliminar una calificación (opcional)
    public function destroy($id)
    {
        RegistrarCalificacion::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Calificación eliminada.');
    }
}
