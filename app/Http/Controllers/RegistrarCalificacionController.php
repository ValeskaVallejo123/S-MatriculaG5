<?php

namespace App\Http\Controllers;

use App\Models\RegistrarCalificacion;
use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Estudiante;
use App\Models\PeriodoAcademico;
use App\Models\Grado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrarCalificacionController extends Controller
{
    public function index(Request $request)
    {
        $profesor = auth()->user()->docente;

        if (!$profesor) {
            return back()->with('error', 'No tienes perfil de profesor asignado.');
        }

        $grados = Grado::where('activo', true)
            ->orderBy('nivel')
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get();

        $materias = Materia::all();
        $periodos = PeriodoAcademico::all();

        $estudiantes = collect();

        if ($request->filled('grado_id')) {
            $grado = Grado::find($request->grado_id);

            if ($grado) {
                $estudiantes = Estudiante::where('grado', $grado->numero)
                    ->where('seccion', $grado->seccion)
                    ->orderBy('apellido1')
                    ->get();
            }
        }

        return view('registrarcalificaciones.index', compact(
            'profesor',
            'grados',
            'materias',
            'periodos',
            'estudiantes'
        ));
    }

    public function create(Request $request)
    {
        return $this->index($request);
    }

    public function store(Request $request)
    {
        $request->validate([
            'grado_id'             => 'required|exists:grados,id',
            'materia_id'           => 'required|exists:materias,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            'notas'                => 'required|array|min:1',
            'notas.*'              => 'nullable|numeric|min:0|max:100',
            'observacion'          => 'nullable|array',
        ]);

        $profesor = auth()->user()->docente;

        if (!$profesor) {
            return back()->with('error', 'No tienes perfil de profesor.');
        }

        $grado = Grado::findOrFail($request->grado_id);

        DB::transaction(function () use ($request, $profesor, $grado) {
            foreach ($request->notas as $estudianteId => $nota) {
                RegistrarCalificacion::updateOrCreate(
                    [
                        'profesor_id'          => $profesor->id,
                        'grado_id'             => $grado->id,
                        'materia_id'           => $request->materia_id,
                        'estudiante_id'        => $estudianteId,
                        'periodo_academico_id' => $request->periodo_academico_id,
                    ],
                    [
                        'nota'        => $nota,
                        'observacion' => $request->observacion[$estudianteId] ?? null,
                    ]
                );
            }
        });

        return redirect()
            ->route('registrarcalificaciones.index')
            ->with('success', 'Calificaciones guardadas correctamente.');
    }

    public function ver()
    {
        $calificaciones = RegistrarCalificacion::with([
            'estudiante',
            'grado',
            'materia',
            'periodoAcademico'
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('registrarcalificaciones.ver', compact('calificaciones'));
    }

    public function obtenerEstudiantes($cursoId)
    {
        $grado = Grado::find($cursoId);

        if (!$grado) {
            return response()->json([]);
        }

        $estudiantes = Estudiante::where('grado', $grado->numero)
            ->where('seccion', $grado->seccion)
            ->orderBy('apellido1')
            ->get(['id', 'nombre1', 'apellido1', 'apellido2']);

        return response()->json($estudiantes);
    }

    public function destroy($id)
    {
        RegistrarCalificacion::findOrFail($id)->delete();

        return back()->with('success', 'Calificación eliminada.');
    }
}