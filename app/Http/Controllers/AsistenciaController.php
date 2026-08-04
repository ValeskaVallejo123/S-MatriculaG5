<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Grado;
use App\Models\Materia;
use App\Models\Profesor;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    // INDEX — lista de sesiones de asistencia registradas
    // ══════════════════════════════════════════════════════════════

    public function index(Request $request)
    {
        $user     = Auth::user();
        $profesor = $this->getProfesor($user);

        // Filtros desde query string
        $gradoId   = $request->query('grado_id');
        $materiaId = $request->query('materia_id');
        $fecha     = $request->query('fecha');

        // Sesiones agrupadas: una fila por fecha+grado+materia
        $sesiones = Asistencia::select(
                'fecha',
                'grado_id',
                'materia_id',
                'profesor_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(estado = "presente")    as presentes'),
                DB::raw('SUM(estado = "ausente")     as ausentes'),
                DB::raw('SUM(estado = "tardanza")    as tardanzas'),
                DB::raw('SUM(estado = "justificado") as justificados')
            )
            ->when($gradoId,   fn ($q) => $q->where('grado_id',   $gradoId))
            ->when($materiaId, fn ($q) => $q->where('materia_id', $materiaId))
            ->when($fecha,     fn ($q) => $q->where('fecha',      $fecha))
            ->when($profesor,  fn ($q) => $q->where('profesor_id', $profesor->id))
            ->groupBy('fecha', 'grado_id', 'materia_id', 'profesor_id')
            ->orderByDesc('fecha')
            ->paginate(20);

        // Datos para los selectores de filtro
        if ($profesor) {
            $gradoIds = DB::table('profesor_materia_grados')
                ->where('profesor_id', $profesor->id)
                ->pluck('grado_id')
                ->unique();

            $grados   = Grado::whereIn('id', $gradoIds)
                ->orderBy('numero')
                ->orderBy('seccion')
                ->get();

            $materias = Materia::whereIn('id',
                DB::table('profesor_materia_grados')
                    ->where('profesor_id', $profesor->id)
                    ->pluck('materia_id')
            )->orderBy('nombre')->get();
        } else {
            $grados   = Grado::where('activo', true)
                ->orderBy('numero')
                ->orderBy('seccion')
                ->get();

            $materias = Materia::where('activo', true)
                ->orderBy('nombre')
                ->get();
        }

        return view('asistencias.index', compact(
            'sesiones', 'grados', 'materias', 'profesor'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    // CREATE — formulario para registrar asistencia
    // ══════════════════════════════════════════════════════════════

    public function create(Request $request)
    {
        $user     = Auth::user();
        $profesor = $this->getProfesor($user);

        // Grados disponibles según rol
        if ($profesor) {
            $gradoIds = DB::table('profesor_materia_grados')
                ->where('profesor_id', $profesor->id)
                ->pluck('grado_id')
                ->unique();

            $grados = Grado::whereIn('id', $gradoIds)
                ->orderBy('nivel')
                ->orderBy('numero')
                ->orderBy('seccion')
                ->get();
        } else {
            $grados = Grado::where('activo', true)
                ->orderBy('nivel')
                ->orderBy('numero')
                ->orderBy('seccion')
                ->get();
        }

        $gradoSeleccionado   = $request->grado_id
            ? Grado::find($request->grado_id)
            : null;

        $materiaSeleccionada = $request->materia_id
            ? Materia::find($request->materia_id)
            : null;

        $fechaSeleccionada = $request->fecha ?? now()->toDateString();

        $estudiantes           = collect();
        $materias              = collect();
        $asistenciasExistentes = collect();

        if ($gradoSeleccionado) {
            // Materias del grado filtradas por profesor si aplica
            if ($profesor) {
                $materiaIds = DB::table('profesor_materia_grados')
                    ->where('profesor_id', $profesor->id)
                    ->where('grado_id', $gradoSeleccionado->id)
                    ->pluck('materia_id');
            } else {
                $materiaIds = DB::table('grado_materia')
                    ->where('grado_id', $gradoSeleccionado->id)
                    ->pluck('materia_id');
            }

            $materias = Materia::whereIn('id', $materiaIds)
                ->orderBy('nombre')
                ->get();

            // Estudiantes activos del grado
            $estudiantes = Estudiante::where('grado_id', $gradoSeleccionado->id)
                ->where('estado', 'activo')
                ->orderBy('apellido1')
                ->orderBy('nombre1')
                ->get();

            // Asistencias ya registradas para reeditar
            if ($materiaSeleccionada && $fechaSeleccionada) {
                $asistenciasExistentes = Asistencia::where('grado_id',   $gradoSeleccionado->id)
                    ->where('materia_id', $materiaSeleccionada->id)
                    ->where('fecha',      $fechaSeleccionada)
                    ->get()
                    ->keyBy('estudiante_id');
            }
        }

        return view('asistencias.create', compact(
            'grados',
            'materias',
            'gradoSeleccionado',
            'materiaSeleccionada',
            'fechaSeleccionada',
            'estudiantes',
            'asistenciasExistentes',
            'profesor'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    // STORE — guardar / actualizar asistencia
    // ══════════════════════════════════════════════════════════════

    public function store(Request $request)
    {
        $request->validate([
            'grado_id'             => 'required|exists:grados,id',
            'materia_id'           => 'required|exists:materias,id',
            'fecha'                => 'required|date|before_or_equal:today',
            'asistencias'          => 'required|array',
            'asistencias.*.estado' => 'required|in:presente,ausente,tardanza,justificado',
        ]);

        $user     = Auth::user();
        $profesor = $this->getProfesor($user);

        $gradoId   = $request->grado_id;
        $materiaId = $request->materia_id;
        $fecha     = $request->fecha;
        $profId    = $profesor?->id;

        DB::transaction(function () use ($request, $gradoId, $materiaId, $fecha, $profId) {
            foreach ($request->asistencias as $estudianteId => $datos) {
                Asistencia::updateOrCreate(
                    [
                        'estudiante_id' => $estudianteId,
                        'materia_id'    => $materiaId,
                        'fecha'         => $fecha,
                    ],
                    [
                        'grado_id'    => $gradoId,
                        'profesor_id' => $profId,
                        'estado'      => $datos['estado'],
                        'observacion' => $datos['observacion'] ?? null,
                    ]
                );
            }
        });

        return redirect()
            ->route('asistencias.create', [
                'grado_id'   => $gradoId,
                'materia_id' => $materiaId,
                'fecha'      => $fecha,
            ])
            ->with('success', 'Asistencia registrada correctamente para el '
                . \Carbon\Carbon::parse($fecha)->format('d/m/Y') . '.');
    }

    // ══════════════════════════════════════════════════════════════
    // SHOW — detalle de una sesión (fecha + grado + materia)
    //
    // Ruta: GET /asistencias/ver?grado_id=X&materia_id=Y&fecha=Z
    // Los parámetros llegan como query string, NO como route params.
    // ══════════════════════════════════════════════════════════════

    public function show(Request $request)
    {
        $gradoId   = $request->query('grado_id');
        $materiaId = $request->query('materia_id');
        $fecha     = $request->query('fecha');

        // Si faltan parámetros devolver 404 con mensaje claro
        if (!$gradoId || !$materiaId || !$fecha) {
            abort(404, 'Faltan parámetros: grado_id, materia_id y fecha son requeridos.');
        }

        $grado   = Grado::findOrFail($gradoId);
        $materia = Materia::findOrFail($materiaId);

        $asistencias = Asistencia::with('estudiante')
            ->where('grado_id',   $gradoId)
            ->where('materia_id', $materiaId)
            ->where('fecha',      $fecha)
            ->orderBy('estado')
            ->get();

        return view('asistencias.show', compact(
            'grado', 'materia', 'fecha', 'asistencias'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    // REPORTE — resumen de asistencia por estudiante
    // ══════════════════════════════════════════════════════════════

    public function reporte(Request $request)
    {
        $gradoId   = $request->query('grado_id');
        $materiaId = $request->query('materia_id');

        $grados   = Grado::where('activo', true)
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get();

        $materias = collect();
        $reporte  = collect();
        $grado    = null;
        $materia  = null;

        if ($gradoId) {
            $grado    = Grado::find($gradoId);
            $materias = Materia::whereIn('id',
                DB::table('grado_materia')
                    ->where('grado_id', $gradoId)
                    ->pluck('materia_id')
            )->orderBy('nombre')->get();
        }

        if ($gradoId && $materiaId) {
            $materia = Materia::find($materiaId);

            $reporte = DB::table('asistencias as a')
                ->join('estudiantes as e', 'a.estudiante_id', '=', 'e.id')
                ->where('a.grado_id',   $gradoId)
                ->where('a.materia_id', $materiaId)
                ->select(
                    'e.id',
                    DB::raw("CONCAT(e.nombre1, ' ', e.apellido1) as nombre"),
                    'e.dni',
                    DB::raw('COUNT(*) as total_clases'),
                    DB::raw('SUM(a.estado = "presente")    as presentes'),
                    DB::raw('SUM(a.estado = "ausente")     as ausentes'),
                    DB::raw('SUM(a.estado = "tardanza")    as tardanzas'),
                    DB::raw('SUM(a.estado = "justificado") as justificados'),
                    DB::raw('ROUND(SUM(a.estado = "presente") / COUNT(*) * 100, 1) as pct_asistencia')
                )
                ->groupBy('e.id', 'e.nombre1', 'e.apellido1', 'e.dni')
                ->orderBy('e.apellido1')
                ->get();
        }

        return view('asistencias.reporte', compact(
            'grados', 'materias', 'grado', 'materia', 'reporte'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    // API — materias de un grado para el selector dinámico
    // ══════════════════════════════════════════════════════════════

    public function apiMaterias(Request $request, $gradoId)
    {
        $user     = Auth::user();
        $profesor = $this->getProfesor($user);

        if ($profesor) {
            $materias = DB::table('profesor_materia_grados as pmg')
                ->join('materias as m', 'pmg.materia_id', '=', 'm.id')
                ->where('pmg.profesor_id', $profesor->id)
                ->where('pmg.grado_id',   $gradoId)
                ->select('m.id', 'm.nombre')
                ->orderBy('m.nombre')
                ->get();
        } else {
            $materias = DB::table('grado_materia as gm')
                ->join('materias as m', 'gm.materia_id', '=', 'm.id')
                ->where('gm.grado_id', $gradoId)
                ->select('m.id', 'm.nombre')
                ->orderBy('m.nombre')
                ->get();
        }

        return response()->json($materias);
    }

    // ── Helper privado: obtener el Profesor vinculado al usuario ──

    private function getProfesor($user): ?Profesor
    {
        if (!$user) return null;
        return Profesor::where('email', $user->email)->first();
    }
}