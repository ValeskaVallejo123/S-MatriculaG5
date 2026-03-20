<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Estudiante;
use App\Models\PeriodoAcademico;
use App\Models\Profesor;
use App\Models\ProfesorMateriaGrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:profesor');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers privados
    |--------------------------------------------------------------------------
    */

    /** Devuelve el Profesor asociado al usuario autenticado o aborta */
    private function profesorActual(): Profesor
    {
        $profesor = Profesor::where('user_id', Auth::id())->first();

        if (!$profesor) {
            abort(403, 'No tienes un perfil de profesor asociado a tu cuenta.');
        }

        return $profesor;
    }

    /**
     * Verifica que el profesor tenga asignado ese grado/sección/materia.
     * Usa grado_id (FK a tabla grados) que viene de ProfesorMateriaGrado.
     */
    private function verificarAcceso(Profesor $profesor, int $gradoId, string $seccion, int $materiaId): ProfesorMateriaGrado
    {
        $asignacion = ProfesorMateriaGrado::with(['grado', 'materia'])
            ->where('profesor_id', $profesor->id)
            ->where('grado_id',    $gradoId)
            ->where('seccion',     $seccion)
            ->where('materia_id',  $materiaId)
            ->first();

        if (!$asignacion) {
            abort(403, 'No tienes permiso para gestionar calificaciones en este grupo.');
        }

        return $asignacion;
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX — grupos asignados al profesor
    | GET /profesor/calificaciones
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $profesor = $this->profesorActual();

        // Todas las asignaciones del profesor con grado y materia cargados
        $asignaciones = ProfesorMateriaGrado::with(['grado', 'materia'])
            ->where('profesor_id', $profesor->id)
            ->orderBy('grado_id')
            ->orderBy('seccion')
            ->get();

        // Agrupar por "grado_id - seccion" para mostrar tarjetas por grupo
        $grupos = $asignaciones->groupBy(fn($a) => $a->grado_id . '|' . $a->seccion);

        return view('profesor.calificaciones.index', compact('grupos', 'profesor'));
    }

    /*
    |--------------------------------------------------------------------------
    | LISTAR — tabla de estudiantes con notas por grupo/materia/periodo
    | GET /profesor/calificaciones/{gradoId}/{seccion}/{materiaId}
    |--------------------------------------------------------------------------
    */
    public function listar(int $gradoId, string $seccion, int $materiaId, Request $request)
    {
        $profesor   = $this->profesorActual();
        $asignacion = $this->verificarAcceso($profesor, $gradoId, $seccion, $materiaId);

        $periodos  = PeriodoAcademico::orderBy('nombre_periodo')->get();
        $periodoId = $request->periodo_id ?? $periodos->first()?->id;

        // Buscar estudiantes por grado_id (FK directo, más confiable que el campo texto)
        $nombreGrado = $asignacion->grado->nombre;

        $estudiantes = Estudiante::where('grado_id', $gradoId)
            ->where('seccion', $seccion)
            ->where('estado',  'activo')
            ->orderBy('apellido1')
            ->orderBy('nombre1')
            ->get();

        // Calificaciones ya registradas, indexadas por estudiante_id
        $calificaciones = Calificacion::where('grado_id',   $gradoId)
            ->where('seccion',    $seccion)
            ->where('materia_id', $materiaId)
            ->where('periodo_id', $periodoId)
            ->get()
            ->keyBy('estudiante_id');

        return view('profesor.calificaciones.listar', compact(
            'asignacion', 'estudiantes', 'calificaciones',
            'periodos', 'periodoId', 'gradoId', 'seccion', 'materiaId', 'nombreGrado'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR MASIVO — tabla de notas completa
    | POST /profesor/calificaciones/{gradoId}/{seccion}/{materiaId}/guardar
    |--------------------------------------------------------------------------
    */
    public function guardarMasivo(Request $request, int $gradoId, string $seccion, int $materiaId)
    {
        $profesor   = $this->profesorActual();
        $asignacion = $this->verificarAcceso($profesor, $gradoId, $seccion, $materiaId);

        $request->validate([
            'periodo_id'                        => 'required|exists:periodos_academicos,id',
            'calificaciones'                    => 'required|array',
            'calificaciones.*.estudiante_id'    => 'required|exists:estudiantes,id',
            'calificaciones.*.primer_parcial'   => 'nullable|numeric|min:0|max:100',
            'calificaciones.*.segundo_parcial'  => 'nullable|numeric|min:0|max:100',
            'calificaciones.*.tercer_parcial'   => 'nullable|numeric|min:0|max:100',
            'calificaciones.*.recuperacion'     => 'nullable|numeric|min:0|max:100',
            'calificaciones.*.observacion'      => 'nullable|string|max:500',
        ]);

        foreach ($request->calificaciones as $data) {
            // Verificar que el estudiante pertenezca a este grupo
            $estudianteValido = Estudiante::where('id',      $data['estudiante_id'])
                ->where('grado',   $asignacion->grado->nombre)
                ->where('seccion', $seccion)
                ->exists();

            if (!$estudianteValido) continue; // saltar si alguien manipuló el form

            $cal = Calificacion::firstOrNew([
                'estudiante_id' => $data['estudiante_id'],
                'materia_id'    => $materiaId,
                'periodo_id'    => $request->periodo_id,
                'grado_id'      => $gradoId,
                'seccion'       => $seccion,
            ]);

            $cal->profesor_id     = $profesor->id;
            $cal->grado_nombre    = $asignacion->grado->nombre;
            $cal->primer_parcial  = $data['primer_parcial']  ?? null;
            $cal->segundo_parcial = $data['segundo_parcial'] ?? null;
            $cal->tercer_parcial  = $data['tercer_parcial']  ?? null;
            $cal->recuperacion    = $data['recuperacion']    ?? null;
            $cal->observacion     = $data['observacion']     ?? null;

            // Calcular nota_final manualmente (evita el problema de los mutadores)
            $parciales = array_filter([
                $cal->primer_parcial,
                $cal->segundo_parcial,
                $cal->tercer_parcial,
            ], fn($p) => $p !== null);

            $promedio = count($parciales) > 0
                ? array_sum($parciales) / count($parciales)
                : null;

            if ($promedio !== null && $promedio < 60 && $cal->recuperacion !== null) {
                $cal->nota_final = max($promedio, $cal->recuperacion);
            } else {
                $cal->nota_final = $promedio;
            }

            $cal->save();
        }

        return redirect()
            ->route('profesor.calificaciones.listar', [
                'gradoId'   => $gradoId,
                'seccion'   => $seccion,
                'materiaId' => $materiaId,
            ])
            ->withInput(['periodo_id' => $request->periodo_id])
            ->with('success', '✅ Calificaciones guardadas correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT — formulario individual de una calificación
    | GET /profesor/calificaciones/{calificacion}/editar
    |--------------------------------------------------------------------------
    */
    public function edit(Calificacion $calificacion)
{
    $profesor = $this->profesorActual();

    if ($calificacion->profesor_id !== $profesor->id) {
        abort(403, 'No puedes editar calificaciones que no registraste tú.');
    }

    $periodos = PeriodoAcademico::orderBy('nombre_periodo')->get();

    return view('profesor.calificaciones.editar', compact('calificacion', 'periodos'));
}

    /*
    |--------------------------------------------------------------------------
    | UPDATE — guardar edición individual
    | PUT /profesor/calificaciones/{calificacion}
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Calificacion $calificacion)
    {
        $profesor = $this->profesorActual();

        if ($calificacion->profesor_id !== $profesor->id) {
            abort(403, 'No puedes editar calificaciones que no registraste tú.');
        }

        $validated = $request->validate([
            'primer_parcial'  => 'nullable|numeric|min:0|max:100',
            'segundo_parcial' => 'nullable|numeric|min:0|max:100',
            'tercer_parcial'  => 'nullable|numeric|min:0|max:100',
            'recuperacion'    => 'nullable|numeric|min:0|max:100',
            'observacion'     => 'nullable|string|max:500',
        ]);

        $calificacion->fill($validated);
        $calificacion->calcularNotaFinal();
        $calificacion->save();

        return redirect()
            ->route('profesor.calificaciones.listar', [
                'gradoId'   => $calificacion->grado_id,
                'seccion'   => $calificacion->seccion,
                'materiaId' => $calificacion->materia_id,
            ])
            ->with('success', '✅ Calificación actualizada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY — eliminar calificación individual
    | DELETE /profesor/calificaciones/{calificacion}
    |--------------------------------------------------------------------------
    */
    public function destroy(Calificacion $calificacion)
    {
        $profesor = $this->profesorActual();

        if ($calificacion->profesor_id !== $profesor->id) {
            abort(403, 'No puedes eliminar calificaciones que no registraste tú.');
        }

        // Guardar para redirección antes de eliminar
        $gradoId   = $calificacion->grado_id;
        $seccion   = $calificacion->seccion;
        $materiaId = $calificacion->materia_id;

        $calificacion->delete();

        return redirect()
            ->route('profesor.calificaciones.listar', [
                'gradoId'   => $gradoId,
                'seccion'   => $seccion,
                'materiaId' => $materiaId,
            ])
            ->with('success', 'Calificación eliminada.');
    }
}
