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
use Illuminate\Support\Facades\Auth;

class RegistrarCalificacionController extends Controller
{
    /**
     * Obtener el profesor vinculado al usuario logueado.
     * Retorna null si el usuario no tiene un profesor asociado.
     */
    private function getProfesorActual(): ?Profesor
    {
        return Profesor::where('user_id', Auth::id())->first();
    }

    public function index(Request $request)
    {
        $profesorActual = $this->getProfesorActual();

        // Si el usuario logueado es un profesor, filtramos solo sus grados
        if ($profesorActual) {

            // Grados asignados al profesor a través de ProfesorGradoSeccion
            $gradosIds = $profesorActual->gradosAsignados()
                ->pluck('grado_id')
                ->unique();

            $grados = Grado::whereIn('id', $gradosIds)
                ->where('activo', true)
                ->orderBy('nivel')
                ->orderBy('numero')
                ->orderBy('seccion')
                ->get();

            // Solo sus materias asignadas
            $materiasIds = $profesorActual->materiasGrupos()
                ->pluck('materia_id')
                ->unique();

            $materias = Materia::whereIn('id', $materiasIds)->get();

            // Solo él en la lista de profesores
            $profesores = collect([$profesorActual]);

        } else {
            // Admin / superadmin — ve todo
            $grados = Grado::where('activo', true)
                ->orderBy('nivel')
                ->orderBy('numero')
                ->orderBy('seccion')
                ->get();

            $materias   = Materia::all();
            $profesores = Profesor::orderBy('apellido')->get();
        }

        $periodos    = PeriodoAcademico::all();
        $estudiantes = collect();

        if ($request->filled('grado_id')) {
            $grado = Grado::find($request->grado_id);

            if ($grado) {
                // Si es profesor, verificar que ese grado le pertenece
                if ($profesorActual) {
                    $tieneGrado = $profesorActual->gradosAsignados()
                        ->where('grado_id', $grado->id)
                        ->exists();

                    if (!$tieneGrado) {
                        return redirect()->route('registrarcalificaciones.index')
                            ->with('error', 'No tienes acceso a ese grado.');
                    }
                }

                $estudiantes = Estudiante::where('grado', $grado->numero)
                    ->where('seccion', $grado->seccion)
                    ->orderBy('apellido1')
                    ->get();
            }
        }

        return view('registrarcalificaciones.index', compact(
            'grados',
            'materias',
            'periodos',
            'profesores',
            'estudiantes',
            'profesorActual'
        ));
    }

    public function store(Request $request)
    {
        $profesorActual = $this->getProfesorActual();

        $request->validate([
            'profesor_id'          => 'required|exists:profesores,id',
            'grado_id'             => 'required|exists:grados,id',
            'materia_id'           => 'required|exists:materias,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            'notas'                => 'required|array|min:1',
            'notas.*'              => 'nullable|numeric|min:0|max:100',
            'observacion'          => 'nullable|array',
        ]);

        // Seguridad: si es profesor, no puede guardar calificaciones de otro profesor
        if ($profesorActual && $request->profesor_id != $profesorActual->id) {
            return back()->with('error', 'No puedes guardar calificaciones de otro profesor.');
        }

        $gradoId = $request->grado_id;

        DB::transaction(function () use ($request, $gradoId) {
            foreach ($request->notas as $estudianteId => $nota) {
                RegistrarCalificacion::updateOrCreate(
                    [
                        'profesor_id'          => $request->profesor_id,
                        'grado_id'             => $gradoId,
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
        $profesorActual = $this->getProfesorActual();

        $query = RegistrarCalificacion::with([
            'estudiante',
            'grado',
            'materia',
            'periodoAcademico'
        ]);

        // Si es profesor, solo ve sus calificaciones
        if ($profesorActual) {
            $query->where('profesor_id', $profesorActual->id);
        }

        $calificaciones = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('registrarcalificaciones.ver', compact('calificaciones'));
    }
}
