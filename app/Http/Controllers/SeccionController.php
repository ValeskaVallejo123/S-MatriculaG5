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
        '7mo Grado', '8vo Grado', '9no Grado'
    ];

    public const GRADO_MAP = [
        // Variantes textuales
        'Primero'   => '1er Grado',
        'Segundo'   => '2do Grado',
        'Tercero'   => '3er Grado',
        'Cuarto'    => '4to Grado',
        'Quinto'    => '5to Grado',
        'Sexto'     => '6to Grado',
        'Séptimo'   => '7mo Grado',
        'Octavo'    => '8vo Grado',
        'Noveno'    => '9no Grado',
        // Variantes numéricas
        '1'         => '1er Grado',
        '2'         => '2do Grado',
        '3'         => '3er Grado',
        '4'         => '4to Grado',
        '5'         => '5to Grado',
        '6'         => '6to Grado',
        '7'         => '7mo Grado',
        '8'         => '8vo Grado',
        '9'         => '9no Grado',
        // Identidades (ya normalizados)
        '1er Grado' => '1er Grado',
        '2do Grado' => '2do Grado',
        '3er Grado' => '3er Grado',
        '4to Grado' => '4to Grado',
        '5to Grado' => '5to Grado',
        '6to Grado' => '6to Grado',
        '7mo Grado' => '7mo Grado',
        '8vo Grado' => '8vo Grado',
        '9no Grado' => '9no Grado',
    ];

    /** Normaliza cualquier variante al formato canónico */
    public static function normalizarGrado(?string $grado): string
    {
        if ($grado === null) return 'Sin Grado';
        return self::GRADO_MAP[$grado] ?? $grado;
    }

    public function index(Request $request)
    {
        // Todas las secciones de la BD
        $secciones = Seccion::orderBy('grado')->orderBy('nombre')->get();

        $nombresGrado = [
            1 => '1er Grado', 2 => '2do Grado', 3 => '3er Grado',
            4 => '4to Grado', 5 => '5to Grado', 6 => '6to Grado',
            7 => '7mo Grado', 8 => '8vo Grado', 9 => '9no Grado',
        ];

        $grados = Grado::where('activo', true)
                    ->orderBy('numero')->get()
                    ->pluck('numero')->unique()
                    ->map(fn($n) => $nombresGrado[$n] ?? "{$n}° Grado");

        $letras = Seccion::orderBy('nombre')->pluck('nombre')->unique()->values();

        // ── Índice de secciones por grado NORMALIZADO ────────────────────────
        // Normaliza TAMBIÉN el lado de secciones.grado para que el match
        // funcione sin importar cómo esté guardado en la BD.
        $seccionesPorGrado = $secciones->groupBy(
            fn($s) => self::normalizarGrado($s->grado)
        );

        // ── Query de matrículas ──────────────────────────────────────────────
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
            // El filtro envía "1er Grado"; buscamos TODAS sus variantes en BD
            $gradoBuscado = $request->grado;
            $variantes    = array_unique(array_merge(
                array_keys(self::GRADO_MAP, $gradoBuscado),
                [$gradoBuscado]
            ));
            $query->whereHas('estudiante', fn($q) => $q->whereIn('grado', $variantes));
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'sin_asignar') {
                $query->whereNull('seccion_id');
            } elseif ($request->estado === 'asignada') {
                $query->whereNotNull('seccion_id');
            } else {
                $query->where('seccion_id', $request->estado);
            }
        }

        $matriculas = $query->paginate(20);

        $conSeccion = Matricula::whereNotNull('seccion_id')->count();
        $sinSeccion = Matricula::whereNull('seccion_id')->count();

        $gradosSecciones = Seccion::with(['matriculas.estudiante'])
                            ->orderBy('grado')->orderBy('nombre')
                            ->get()->groupBy('grado');

        // Agrupar con grado NORMALIZADO → claves "1er Grado", "2do Grado", etc.
        $matriculasSinSeccionPorGrado = Matricula::with('estudiante')
                            ->whereNull('seccion_id')->get()
                            ->groupBy(fn($m) => self::normalizarGrado($m->estudiante->grado ?? null));

        $gradoMap = self::GRADO_MAP;

        return view('secciones.index', compact(
            'matriculas', 'secciones', 'grados', 'letras',
            'gradosSecciones', 'matriculasSinSeccionPorGrado',
            'conSeccion', 'sinSeccion', 'gradoMap', 'seccionesPorGrado'
        ));
    }

    public function create()
    {
        // ✅ Pasar $grados a la vista de creación
        $grados = self::GRADOS;
        return view('secciones.create', compact('grados'));
    }

    public function asignar(Request $request)
    {
        $validated = $request->validate([
            'matricula_id' => 'required|exists:matriculas,id',
            'seccion_id'   => 'required|exists:secciones,id',
        ]);

        $matricula = Matricula::findOrFail($validated['matricula_id']);
        $seccion   = Seccion::findOrFail($validated['seccion_id']);

        if ($matricula->seccion_id !== $seccion->id) {
            $asignados = Matricula::where('seccion_id', $seccion->id)->count();
            if ($asignados >= $seccion->capacidad) {
                return back()->with('error', "La sección {$seccion->nombre} del {$seccion->grado} no tiene cupo.");
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

        $matricula = Matricula::findOrFail($validated['matricula_id']);
        $matricula->update(['seccion_id' => null]);
        return back()->with('success', 'Alumno quitado de la sección correctamente.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grado'     => 'required|in:' . implode(',', self::GRADOS),
            'seccion'   => 'required|in:A,B,C,D',
            'capacidad' => 'required|integer|min:1|max:60',
        ]);

        $existe = Seccion::where('grado', $validated['grado'])
                         ->where('nombre', $validated['seccion'])
                         ->exists();

        if ($existe) {
            return back()->withInput()->withErrors([
                'seccion' => "Ya existe la Sección {$validated['seccion']} para {$validated['grado']}."
            ]);
        }

        Seccion::create([
            'grado'     => $validated['grado'],
            'nombre'    => $validated['seccion'],
            'capacidad' => $validated['capacidad'],
        ]);

        return redirect()->route('secciones.index')->with('success', 'Sección creada correctamente.');
    }

    public function update(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'grado'     => 'required|in:' . implode(',', self::GRADOS),
            'seccion'   => 'required|in:A,B,C,D',
            'capacidad' => 'required|integer|min:1|max:60',
        ]);

        $existeOtro = Seccion::where('grado', $validated['grado'])
            ->where('nombre', $validated['seccion'])
            ->where('id', '!=', $seccion->id)
            ->exists();

        if ($existeOtro) {
            return back()->withInput()->withErrors(['seccion' => 'Ya existe esa sección para este grado.']);
        }

        if ($validated['capacidad'] < $seccion->matriculas()->count()) {
            return back()->withInput()->withErrors([
                'capacidad' => 'La capacidad no puede ser menor a los alumnos ya inscritos.'
            ]);
        }

        $seccion->update([
            'grado'     => $validated['grado'],
            'nombre'    => $validated['seccion'],
            'capacidad' => $validated['capacidad'],
        ]);

        return redirect()->route('secciones.index')->with('success', 'Sección actualizada correctamente.');
    }
}