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
        $grados = Grado::where('activo', true)
            ->orderBy('nivel')
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get();

        $materias = Materia::all();
        $periodos = PeriodoAcademico::all();
        $profesores = Profesor::orderBy('apellido')->get();
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
            'grados',
            'materias',
            'periodos',
            'profesores',
            'estudiantes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'profesor_id'          => 'required|exists:profesores,id',
            'grado_id'             => 'required|exists:grados,id',
            'materia_id'           => 'required|exists:materias,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            'notas'                => 'required|array|min:1',
            'notas.*'              => 'nullable|numeric|min:0|max:100',
            'observacion'          => 'nullable|array',
        ]);

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
            ->with('success', 'Calificaciones guardadas correctamente');
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
}