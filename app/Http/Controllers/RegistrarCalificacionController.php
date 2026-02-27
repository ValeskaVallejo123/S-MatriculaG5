<?php

namespace App\Http\Controllers;

use App\Models\RegistrarCalificacion;
use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Estudiante;
use App\Models\PeriodoAcademico;
use App\Models\ProfesorMateriaGrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrarCalificacionController extends Controller
{
    public function __construct()
    {
        // Solo PROFESORES pueden registrar calificaciones
        $this->middleware(['auth', 'rol:profesor']);
    }

    /**
     * Mostrar calificaciones registradas por el profesor autenticado
     */
    public function index()
    {
        $profesor = auth()->user()->docente;

        if (! $profesor) {
            return back()->with('error', 'No tienes perfil de profesor asignado.');
        }

        $calificaciones = RegistrarCalificacion::with(['estudiante', 'materia', 'periodoAcademico'])
            ->where('profesor_id', $profesor->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('registrarcalificaciones.index', compact('calificaciones'));
    }

    /**
     * Mostrar formulario con filtros para registrar calificaciones
     */
    public function create(Request $request)
    {
        $profesor = auth()->user()->docente;

        if (! $profesor) {
            return back()->with('error', 'No tienes perfil de profesor asignado.');
        }

        // Grados y secciones asignados a este profesor
        $asignaciones = ProfesorMateriaGrado::where('profesor_id', $profesor->id)
            ->with(['materia', 'grado'])
            ->get();

        $periodos = PeriodoAcademico::all();

        $estudiantes = collect();
        $calificacionesExistentes = [];

        // Si se seleccionó un grado + sección + materia
        if ($request->filled(['grado_id', 'seccion', 'materia_id', 'periodo_id'])) {

            $gradoId = $request->grado_id;
            $seccion = $request->seccion;
            $materiaId = $request->materia_id;
            $periodoId = $request->periodo_id;

            // VALIDAR que el profesor imparte esa materia en ese grado y sección
            $valido = ProfesorMateriaGrado::where('profesor_id', $profesor->id)
                ->where('materia_id', $materiaId)
                ->where('grado_id', $gradoId)
                ->where('seccion', $seccion)
                ->exists();

            if (! $valido) {
                return back()->with('error', 'No puedes registrar calificaciones para esta materia, grado o sección.');
            }

            // Cargar estudiantes del grado+sección
            $estudiantes = Estudiante::where('grado', $gradoId)
                ->where('seccion', $seccion)
                ->get();

            // Calificaciones existentes para prellenar
            $existing = RegistrarCalificacion::where([
                'profesor_id' => $profesor->id,
                'materia_id' => $materiaId,
                'periodo_academico_id' => $periodoId,
                'grado_id' => $gradoId,
                'seccion' => $seccion,
            ])->get();

            foreach ($existing as $c) {
                $calificacionesExistentes[$c->estudiante_id] = [
                    'nota' => $c->nota,
                    'observacion' => $c->observacion,
                ];
            }
        }

        return view('registrarcalificaciones.registrarcalificaciones', compact(
            'profesor',
            'asignaciones',
            'periodos',
            'estudiantes',
            'calificacionesExistentes'
        ));
    }

    /**
     * Guardar calificaciones masivamente
     */
    public function store(Request $request)
    {
        $request->validate([
            'grado_id' => 'required|exists:grados,id',
            'seccion' => 'required|string',
            'materia_id' => 'required|exists:materias,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            'notas' => 'required|array',
            'notas.*' => 'nullable|numeric|min:0|max:100',
            'observacion.*' => 'nullable|string|max:2000',
        ]);

        $profesor = auth()->user()->docente;

        if (! $profesor) {
            return back()->with('error', 'No tienes perfil de profesor asignado.');
        }

        // Validar asignación profesor–materia–grado–sección
        $valido = ProfesorMateriaGrado::where('profesor_id', $profesor->id)
            ->where('materia_id', $request->materia_id)
            ->where('grado_id', $request->grado_id)
            ->where('seccion', $request->seccion)
            ->exists();

        if (! $valido) {
            return back()->with('error', 'No estás autorizado para registrar calificaciones en esta asignación.');
        }

        DB::transaction(function () use ($request, $profesor) {

            foreach ($request->notas as $estudianteId => $nota) {

                RegistrarCalificacion::updateOrCreate(
                    [
                        'profesor_id' => $profesor->id,
                        'estudiante_id' => $estudianteId,
                        'materia_id' => $request->materia_id,
                        'periodo_academico_id' => $request->periodo_academico_id,
                        'grado_id' => $request->grado_id,
                        'seccion' => $request->seccion,
                    ],
                    [
                        'nota' => $nota,
                        'observacion' => $request->observacion[$estudianteId] ?? null,
                    ]
                );
            }
        });

        return redirect()->route('registrarcalificaciones.index')
            ->with('success', 'Calificaciones registradas correctamente.');
    }

    /**
     * Eliminar una calificación
     */
    public function destroy($id)
    {
        RegistrarCalificacion::findOrFail($id)->delete();

        return back()->with('success', 'Calificación eliminada.');
    }
}
