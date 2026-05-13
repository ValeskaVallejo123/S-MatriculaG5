<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Seccion;
use App\Models\Grado;
use App\Helpers\GradoHelper;
use Illuminate\Http\Request;
use App\Models\Estudiante;


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
        return GradoHelper::normalizar($grado);
    }

    public function index(Request $request)
    {
        $secciones = Seccion::orderBy('grado')->orderBy('nombre')->get();

        $grados = Grado::where('activo', true)->orderBy('numero')->get()->pluck('numero')->unique()
            ->map(fn($n) => GradoHelper::GRADOS[$n - 1] ?? "{$n}° Grado");

        $letras = Seccion::orderBy('nombre')->pluck('nombre')->unique()->values();

        $seccionesPorGrado = $secciones->groupBy(fn($s) =>
            GradoHelper::normalizar($s->grado)
        );

        $query = Matricula::with(['estudiante', 'seccion'])->whereHas('estudiante');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('estudiante', function ($q) use ($buscar) {
                $q->where('nombre1',    'like', "%{$buscar}%")
                  ->orWhere('apellido1', 'like', "%{$buscar}%")
                  ->orWhere('dni',       'like', "%{$buscar}%");
            });
        }

        if ($request->filled('grado')) {
            $query->whereHas('estudiante', fn($q) => $q->where('grado', $request->grado));
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
            ->orderBy('grado')
            ->orderBy('nombre')
            ->get()
            ->groupBy(fn($s) => GradoHelper::normalizar($s->grado));

        $matriculasSinSeccionPorGrado = Matricula::with('estudiante')
            ->whereNull('seccion_id')->get()
            ->groupBy(fn($m) => GradoHelper::normalizar($m->estudiante->grado ?? null));

        return view('secciones.index', compact(
            'matriculas', 'secciones', 'grados', 'letras',
            'gradosSecciones', 'matriculasSinSeccionPorGrado',
            'conSeccion', 'sinSeccion', 'seccionesPorGrado'
        ));
    }

    public function create()
    {
        $grados = self::GRADOS;
        return view('secciones.create', compact('grados'));
    }

    public function asignar(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'seccion_id'    => 'required|exists:seccion,id',
        ]);

        $matricula = Matricula::where('estudiante_id', $request->estudiante_id)
            ->where('estado', 'aprobada')
            ->first();

        if (!$matricula) {
            return back()->with('error', 'El estudiante no tiene una matrícula aprobada.');
        }

        $matricula->update(['seccion_id' => $request->seccion_id]);

        return redirect()->route('secciones.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Sección asignada correctamente.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
        ]);

        Seccion::create($validated);

        return redirect()->route('secciones.index')
            ->with('success', 'Sección creada correctamente.');
    }

    public function edit(Seccion $seccion)
    {
        return view('secciones.edit', compact('seccion'));
    }

    public function update(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
        ]);

        $seccion->update($validated);

        return redirect()->route('secciones.index')
            ->with('success', 'Sección actualizada correctamente.');
    }

    public function destroy(Request $request, Seccion $seccion)
    {
        if ($seccion->matriculas()->exists()) {
            return back()->with('error', 'No se puede eliminar una sección con alumnos inscritos.');
        }

        $seccion->delete();

        return redirect()->route('secciones.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Sección eliminada correctamente.');
    }
}