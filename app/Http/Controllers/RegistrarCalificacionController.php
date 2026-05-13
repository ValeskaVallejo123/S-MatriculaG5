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
     * Primero intenta por user_id; si no, busca por email.
     */
    private function getProfesorActual(): ?Profesor
    {
        $user = Auth::user();
        if (!$user) return null;

        // Intentar por user_id
        $profesor = Profesor::where('user_id', $user->id)->first();

        // Si no, buscar por email (los profesores se vinculan por email)
        if (!$profesor && $user->email) {
            $profesor = Profesor::where('email', $user->email)->first();
        }

        return $profesor;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $profesorActual = $this->getProfesorActual();

        // ── Si es profesor, solo ve sus grados y materias ────────────────────
        if ($profesorActual) {

            // Grados asignados al profesor desde profesor_materia_grados
            $gradoIds = DB::table('profesor_materia_grados')
                ->where('profesor_id', $profesorActual->id)
                ->pluck('grado_id')
                ->unique()
                ->values();

            $grados = Grado::whereIn('id', $gradoIds)
                ->where('activo', true)
                ->orderBy('nivel')
                ->orderBy('numero')
                ->orderBy('seccion')
                ->get();

            // Solo las materias que imparte este profesor
            $materiaIds = DB::table('profesor_materia_grados')
                ->where('profesor_id', $profesorActual->id)
                ->pluck('materia_id')
                ->unique()
                ->values();

            $materias   = Materia::whereIn('id', $materiaIds)->orderBy('nombre')->get();
            $profesores = collect([$profesorActual]);

        } else {
            // Admin / superadmin — ve todo
            $grados     = Grado::where('activo', true)
                ->orderBy('nivel')
                ->orderBy('numero')
                ->orderBy('seccion')
                ->get();
            $materias   = Materia::orderBy('nombre')->get();
            $profesores = Profesor::where('estado', 'activo')->orderBy('apellido')->get();
        }

        $periodos           = PeriodoAcademico::all();
        $estudiantes        = collect();
        $gradoSeleccionado  = null;
        $profesoresDelGrado = collect(); // profesores asignados al grado seleccionado

        if ($request->filled('grado_id')) {
            $grado = Grado::find($request->grado_id);

            if ($grado) {
                $gradoSeleccionado = $grado;

                // Si es profesor, verificar que ese grado le pertenece
                if ($profesorActual) {
                    $tieneGrado = DB::table('profesor_materia_grados')
                        ->where('profesor_id', $profesorActual->id)
                        ->where('grado_id', $grado->id)
                        ->exists();

                    if (!$tieneGrado) {
                        return redirect()->route('registrarcalificaciones.index')
                            ->with('error', 'No tienes acceso a ese grado.');
                    }

                    // Filtrar materias solo para este grado
                    $materiaIds = DB::table('profesor_materia_grados')
                        ->where('profesor_id', $profesorActual->id)
                        ->where('grado_id', $grado->id)
                        ->pluck('materia_id')
                        ->unique()
                        ->values();

                    $materias = Materia::whereIn('id', $materiaIds)->orderBy('nombre')->get();
                } else {
                    // Admin: solo materias del grado
                    $materiaIds = DB::table('profesor_materia_grados')
                        ->where('grado_id', $grado->id)
                        ->pluck('materia_id')
                        ->unique()
                        ->values();

                    $materias = Materia::whereIn('id', $materiaIds)->orderBy('nombre')->get();
                }

                // Estudiantes del grado
                $estudiantes = Estudiante::where('grado_id', $grado->id)
                    ->where('estado', 'activo')
                    ->orderBy('apellido1')
                    ->orderBy('nombre1')
                    ->get();

                // Profesores asignados a este grado con sus materias
                $profesoresDelGrado = DB::table('profesor_materia_grados')
                    ->join('profesores', 'profesores.id', '=', 'profesor_materia_grados.profesor_id')
                    ->join('materias',   'materias.id',   '=', 'profesor_materia_grados.materia_id')
                    ->where('profesor_materia_grados.grado_id', $grado->id)
                    ->select(
                        'profesores.id',
                        'profesores.nombre',
                        'profesores.apellido',
                        'materias.nombre as materia_nombre'
                    )
                    ->orderBy('profesores.apellido')
                    ->orderBy('materias.nombre')
                    ->get()
                    ->groupBy('id'); // agrupar por profesor_id
            }
        }

        return view('registrarcalificaciones.index', compact(
            'grados',
            'materias',
            'periodos',
            'profesores',
            'estudiantes',
            'profesorActual',
            'gradoSeleccionado',
            'profesoresDelGrado'
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

        // Seguridad: si es profesor, no puede guardar calificaciones de otro
        if ($profesorActual && (int) $request->profesor_id !== $profesorActual->id) {
            return back()->with('error', 'No puedes guardar calificaciones de otro profesor.');
        }

        $gradoId = $request->grado_id;

        DB::transaction(function () use ($request, $gradoId) {
            foreach ($request->notas as $estudianteId => $nota) {
                if ($nota === null || $nota === '') continue;

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
            ->route('registrarcalificaciones.index', ['grado_id' => $gradoId])
            ->with('success', 'Calificaciones guardadas correctamente.');
    }

    /**
     * JSON: devuelve las notas ya registradas para profesor+grado+materia+periodo.
     * Usado por el formulario con fetch() para pre-rellenar los inputs.
     */
    public function notasExistentes(Request $request)
    {
        $profesorActual = $this->getProfesorActual();

        // Seguridad: profesor solo puede consultar sus propias notas
        $profesorId = $request->profesor_id;
        if ($profesorActual && (int) $profesorId !== $profesorActual->id) {
            return response()->json([]);
        }

        $notas = RegistrarCalificacion::where('profesor_id',          $profesorId)
            ->where('grado_id',             $request->grado_id)
            ->where('materia_id',           $request->materia_id)
            ->where('periodo_academico_id', $request->periodo_academico_id)
            ->get(['estudiante_id', 'nota', 'observacion'])
            ->keyBy('estudiante_id');

        return response()->json($notas);
    }

    /**
     * Vista para admin/superadmin/profesor: ver calificaciones registradas.
     */
    public function ver(Request $request)
    {
        $profesorActual = $this->getProfesorActual();

        $query = RegistrarCalificacion::with([
            'estudiante',
            'grado',
            'materia',
            'periodoAcademico',
            'profesor',
        ]);

        // Profesor: solo ve sus calificaciones
        if ($profesorActual) {
            $query->where('profesor_id', $profesorActual->id);
        }

        // Filtros opcionales
        if ($request->filled('grado_id')) {
            $query->where('grado_id', $request->grado_id);
        }
        if ($request->filled('materia_id')) {
            $query->where('materia_id', $request->materia_id);
        }
        if ($request->filled('periodo_id')) {
            $query->where('periodo_academico_id', $request->periodo_id);
        }

        $calificaciones = $query->orderBy('grado_id')->orderBy('materia_id')->orderBy('created_at', 'desc')->paginate(20);

        // Datos para filtros
        if ($profesorActual) {
            $gradosFiltro = Grado::whereIn('id',
                DB::table('profesor_materia_grados')->where('profesor_id', $profesorActual->id)->pluck('grado_id')
            )->get();
        } else {
            $gradosFiltro = Grado::where('activo', true)->orderBy('numero')->get();
        }

        $materiasFiltro = Materia::orderBy('nombre')->get();
        $periodosFiltro = PeriodoAcademico::all();

        return view('registrarcalificaciones.ver', compact(
            'calificaciones',
            'gradosFiltro',
            'materiasFiltro',
            'periodosFiltro',
            'profesorActual'
        ));
    }
}
