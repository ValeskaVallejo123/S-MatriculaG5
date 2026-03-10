<?php

namespace App\Http\Controllers;

use App\Models\RegistrarCalificacion;
use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Estudiante;
use App\Models\PeriodoAcademico;
use App\Models\ProfesorMateriaGrado;
use App\Models\Grado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrarCalificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'rol:profesor']);
    }

    /**
     * Mostrar formulario y listado
     */
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

    /**
     * Guardar calificaciones
     */
    public function store(Request $request)
    {
        $request->validate([
            'grado_id' => 'required|exists:grados,id',
            'materia_id' => 'required|exists:materias,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            'notas' => 'required|array',
            'notas.*' => 'nullable|numeric|min:0|max:100',
            'observacion' => 'nullable|array',
        ]);

        $profesor = auth()->user()->docente;

        if (!$profesor) {
            return back()->with('error', 'No tienes perfil de profesor.');
        }

        $grado = Grado::findOrFail($request->grado_id);

        // Validar asignación profesor-materia-grado
        $valido = ProfesorMateriaGrado::where('profesor_id', $profesor->id)
            ->where('materia_id', $request->materia_id)
            ->where('grado_id', $grado->id)
            ->where('seccion', $grado->seccion)
            ->exists();

        if (!$valido) {
            return back()->with('error', 'No estás autorizado para esta asignación.');
        }

        DB::transaction(function () use ($request, $profesor, $grado) {

            foreach ($request->notas as $estudianteId => $nota) {

                RegistrarCalificacion::updateOrCreate(
                    [
                        'profesor_id' => $profesor->id,
                        'grado_id' => $grado->id,
                        'materia_id' => $request->materia_id,
                        'estudiante_id' => $estudianteId,
                        'periodo_academico_id' => $request->periodo_academico_id,
                    ],
                    [
                        'nota' => $nota,
                        'observacion' => $request->observacion[$estudianteId] ?? null,
                    ]
                );
            }
        });

        return redirect()
            ->route('registrarcalificaciones.index')
            ->with('success', 'Calificaciones guardadas correctamente.');
    }

    /**
     * Ver calificaciones registradas
     */
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

    /**
     * Eliminar calificación
     */
    public function destroy($id)
    {
        RegistrarCalificacion::findOrFail($id)->delete();

        return back()->with('success', 'Calificación eliminada.');
    }
}