<?php

namespace App\Http\Controllers;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Seccion;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    public const GRADOS = [
        '1er Grado', '2do Grado', '3er Grado',
        '4to Grado', '5to Grado', '6to Grado',
        '7mo Grado', '8vo Grado', '9no Grado' // Corregido '7to' a '7mo'
    ];

public function index(Request $request)
{
    // ── 1. Secciones ──────────────────────────────────────────────────────
    $secciones = Seccion::orderBy('grado')->orderBy('nombre')->get();

    // ── 2. Grados desde la tabla grados (activos) ─────────────────────────
    $nombresGrado = [
        1 => '1er Grado', 2 => '2do Grado', 3 => '3er Grado',
        4 => '4to Grado', 5 => '5to Grado', 6 => '6to Grado',
        7 => '7mo Grado', 8 => '8vo Grado', 9 => '9no Grado',
    ];

    $grados = Grado::where('activo', true)
                ->orderBy('numero')
                ->get()
                ->pluck('numero')
                ->unique()
                ->map(fn($n) => $nombresGrado[$n] ?? "{$n}° Grado");

    // ── 3. Letras de sección disponibles ──────────────────────────────────
    $letras = Seccion::orderBy('nombre')
                     ->pluck('nombre')
                     ->unique()
                     ->values();

    // ── 4. Query base con filtros ──────────────────────────────────────────
    $query = Matricula::with(['estudiante', 'seccion'])->whereHas('estudiante');

    if ($request->filled('buscar')) {
        $buscar = $request->buscar;
        $query->whereHas('estudiante', function ($q) use ($buscar) {
            $q->where('nombre1',   'like', "%{$buscar}%")
              ->orWhere('apellido1', 'like', "%{$buscar}%")
              ->orWhere('dni',       'like', "%{$buscar}%");
        });
    }

    if ($request->filled('grado')) {
        $query->whereHas('estudiante', function ($q) use ($request) {
            $q->where('grado', $request->grado);
        });
    }

    if ($request->filled('estado')) {
        if ($request->estado === 'sin_asignar') {
            $query->whereNull('seccion_id');
        } else {
            $seccionIds = Seccion::where('nombre', $request->estado)->pluck('id');
            $query->whereIn('seccion_id', $seccionIds);
        }
    }

    $matriculas = $query->paginate(20);

    // ── 5. Estadísticas ───────────────────────────────────────────────────
    $totalMatriculas = Matricula::count();           // ← definido aquí
    $conSeccion      = Matricula::whereNotNull('seccion_id')->count();
    $sinSeccion      = Matricula::whereNull('seccion_id')->count();

    // ── 6. Pestaña 2 ──────────────────────────────────────────────────────
    $gradosSecciones = Seccion::with(['matriculas.estudiante'])
                        ->orderBy('grado')->orderBy('nombre')
                        ->get()->groupBy('grado');

    $matriculasSinSeccionPorGrado = Matricula::with('estudiante')
                        ->whereNull('seccion_id')->get()
                        ->groupBy(fn($m) => $m->estudiante->grado);

    $seccionesDisponibles = Seccion::orderBy('grado')->orderBy('nombre')->get();

    return view('secciones.index', compact(
        'matriculas',
        'totalMatriculas',
        'secciones',
        'grados',
        'letras',
        'gradosSecciones',
        'matriculasSinSeccionPorGrado',
        'conSeccion',
        'sinSeccion',
        'seccionesDisponibles'
    ));
}

    public function asignar(Request $request)
    {
        $validated = $request->validate([
            'matricula_id' => 'required|exists:matriculas,id',
            'seccion_id'   => 'required|exists:seccions,id', // Cambiado 'seccion' a 'seccions' (plural común en Laravel)
        ]);

        $matricula = Matricula::findOrFail($validated['matricula_id']);
        $seccion   = Seccion::findOrFail($validated['seccion_id']);

        if ($matricula->seccion_id !== $seccion->id) {
            $asignados = Matricula::where('seccion_id', $seccion->id)->count();
            if ($asignados >= $seccion->capacidad) {
                return back()->with(
                    'error',
                    "La sección {$seccion->letra} del {$seccion->grado} no tiene cupo disponible."
                );
            }
        }

        $matricula->update(['seccion_id' => $seccion->id]);

        return back()->with('success', 'Sección asignada correctamente.');
    }

    public function quitar(Request $request)
    {
        $validated = $request->validate([
            'matricula_id' => 'required|exists:matriculas,id',
        ]);

        $matricula = Matricula::with('estudiante')->findOrFail($validated['matricula_id']);

        if (is_null($matricula->seccion_id)) {
            return back()->withErrors(['error' => 'Este alumno no tiene sección asignada.']);
        }

        $matricula->update(['seccion_id' => null]);

        return back()->with(
            'success',
            "Alumno {$matricula->estudiante->nombre1} {$matricula->estudiante->apellido1} removido de la sección."
        );
    }

    public function create()
    {
        $grados = self::GRADOS;
        return view('secciones.create', compact('grados'));
    }

    /**
     * Guardar una nueva sección con la lógica de validación integrada.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'grado'     => 'required|in:' . implode(',', self::GRADOS),
            'seccion'   => 'required|in:A,B,C,D', // El input del form se llama 'seccion'
            'capacidad' => 'required|integer|min:1|max:60',
        ]);

        $existe = Seccion::where('grado', $validated['grado'])
                         ->where('nombre', $validated['seccion']) 
                         ->exists();

        if ($existe) {
            return back()->withInput()->withErrors([
                'seccion' => "Ya existe la Sección {$validated['seccion']} para {$validated['grado']}.",
            ]);
        }

        Seccion::create([
            'grado'     => $validated['grado'],
            'nombre'     => $validated['seccion'], 
            'capacidad' => $validated['capacidad'],
        ]);

        return redirect()->route('secciones.index')
            ->with('success', 'Sección creada correctamente.');
    }

    public function edit(Seccion $seccion)
    {
        $grados = self::GRADOS;
        return view('secciones.edit', compact('seccion', 'grados'));
    }

    public function update(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'grado'     => 'required|in:' . implode(',', self::GRADOS),
            'seccion'   => 'required|in:A,B,C,D',
            'capacidad' => 'required|integer|min:1|max:60',
        ]);

        // Verificar si se intenta cambiar a una combinación que ya existe (excluyendo a sí misma)
        $existeOtro = Seccion::where('grado', $validated['grado'])
            ->where('letra', $validated['seccion'])
            ->where('id', '!=', $seccion->id)
            ->exists();

        if ($existeOtro) {
            return back()->withInput()->withErrors([
                'seccion' => "Ya existe otra sección con esa letra para este grado.",
            ]);
        }

        $asignados = $seccion->matriculas()->count();
        if ($validated['capacidad'] < $asignados) {
            return back()->withInput()->withErrors([
                'capacidad' => "No puedes reducir la capacidad a {$validated['capacidad']} porque ya hay {$asignados} alumno(s) asignados.",
            ]);
        }

        $seccion->update([
            'grado'     => $validated['grado'],
            'letra'     => $validated['seccion'],
            'capacidad' => $validated['capacidad'],
        ]);

        return redirect()->route('secciones.index')
            ->with('success', 'Sección actualizada correctamente.');
    }

    public function destroy(Seccion $seccion)
    {
        if ($seccion->matriculas()->exists()) {
            return back()->with('error', 'No se puede eliminar una sección con alumnos inscritos.');
        }

        $seccion->delete();

        return redirect()->route('secciones.index')
            ->with('success', 'La sección fue eliminada correctamente.');
    }
}