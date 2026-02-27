<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Calificacion;
use App\Models\Materia;
use App\Models\PeriodoAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Todos deben estar autenticados
    }

    /**
     * SOLO estudiantes pueden ver sus propias calificaciones
     */
    public function misCalificaciones()
    {
        $usuario = Auth::user();

        if ($usuario->id_rol != 4) { // 4 = estudiante
            return back()->with('error', 'No tienes permisos para ver esta sección.');
        }

        $calificaciones = Calificacion::where('estudiante_id', $usuario->id)
            ->with(['materia', 'periodo'])
            ->get();

        $promedio = $calificaciones->avg('nota');

        return view('calificaciones.misCalificaciones', compact('calificaciones', 'promedio'));
    }

    /**
     * VISTA GENERAL PARA PROFESORES, ADMIN Y SUPERADMIN
     */
    public function indexCalificaciones(Request $request)
    {
        $usuario = Auth::user();

        if (!in_array($usuario->id_rol, [1, 2, 3])) {
            return redirect()->route('calificaciones.mis')
                ->with('error', 'No tienes permisos para ver todas las calificaciones.');
        }

        $periodoId = $request->periodo_id;
        $materiaId = $request->materia_id;

        $query = Calificacion::with(['materia', 'periodo']);

        if ($periodoId) $query->where('periodo_id', $periodoId);
        if ($materiaId) $query->where('materia_id', $materiaId);

        // Profesores solo ven sus materias si lo deseas
        if ($usuario->id_rol == 3) {
            $query->where('profesor_id', $usuario->id);
        }

        $calificaciones = $query->get();
        $promedio = $calificaciones->avg('nota');

        $materias = Materia::all();
        $periodos = PeriodoAcademico::all();

        return view('calificaciones.indexCalificaciones', compact(
            'calificaciones', 'promedio', 'materias', 'periodos'
        ));
    }

    /**
     * CRUD RESTRINGIDO PARA PROFESORES, ADMIN Y SUPERADMIN
     */
    public function index()
    {
        $usuario = Auth::user();

        if (!in_array($usuario->id_rol, [1, 2, 3])) {
            return redirect()->route('calificaciones.mis')
                ->with('error', 'No tienes permisos para ver todas las calificaciones.');
        }

        $calificaciones = Calificacion::orderBy('nombre_alumno')->get();

        return view('calificaciones.index', compact('calificaciones'));
    }

    public function create()
    {
        $this->autorizarProfesor();

        return view('calificaciones.create');
    }

    public function store(Request $request)
    {
        $this->autorizarProfesor();

        $validated = $this->validar($request);

        $calificacion = Calificacion::create($validated);

        $calificacion->calcularNotaFinal();
        $calificacion->save();

        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación registrada exitosamente.');
    }

    public function show(Calificacion $calificacion)
    {
        return view('calificaciones.show', compact('calificacion'));
    }

    public function edit(Calificacion $calificacion)
    {
        $this->autorizarProfesor();

        return view('calificaciones.edit', compact('calificacion'));
    }

    public function update(Request $request, Calificacion $calificacion)
    {
        $this->autorizarProfesor();

        $validated = $this->validar($request);

        $calificacion->update($validated);

        $calificacion->calcularNotaFinal();
        $calificacion->save();

        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación actualizada exitosamente.');
    }

    public function destroy(Calificacion $calificacion)
    {
        $this->autorizarProfesor();

        $calificacion->delete();

        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación eliminada exitosamente.');
    }

    /**
     * Validación común
     */
    private function validar(Request $request)
    {
        return $request->validate([
            'nombre_alumno' => 'required|string|max:255',
            'primer_parcial' => 'nullable|numeric|min:0|max:100',
            'segundo_parcial' => 'nullable|numeric|min:0|max:100',
            'tercer_parcial' => 'nullable|numeric|min:0|max:100',
            'cuarto_parcial' => 'nullable|numeric|min:0|max:100',
            'recuperacion' => 'nullable|numeric|min:0|max:100',
        ]);
    }

    /**
     * Autorizar solo admin, superadmin y profesor
     */
    private function autorizarProfesor()
    {
        $usuario = Auth::user();

        if (!in_array($usuario->id_rol, [1, 2, 3])) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }
    }
}
