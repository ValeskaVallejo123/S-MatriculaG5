<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    private const MATERIAS_DEFAULT_PRIMARIA = [
        'Español (Lengua Materna)',
        'Matemáticas',
        'Ciencias Naturales',
        'Ciencias Sociales',
        'Educación Artística',
        'Educación Física',
        'Inglés',
        'Educación Cívica/Valores',
    ];

    private function asignarMateriasPorDefecto(Grado $grado): void
    {
        $ids = Materia::whereIn('nombre', self::MATERIAS_DEFAULT_PRIMARIA)
            ->where('activo', true)
            ->pluck('id')
            ->toArray();

        if (empty($ids)) {
            return;
        }

        $syncData = [];
        foreach ($ids as $id) {
            $syncData[$id] = ['horas_semanales' => 4, 'profesor_id' => null];
        }

        $grado->materias()->syncWithoutDetaching($syncData);
    }

    public function index()
    {
        $grados = Grado::with('materias')
            ->orderBy('nivel')
            ->orderBy('numero')
            ->paginate(request('per_page', 15));

        return view('grados.index', compact('grados'));
    }

    public function create()
    {
        return view('grados.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:primaria,secundaria',   // ← minúsculas
            'numero'       => 'required|integer|min:1|max:12',
            'seccion'      => 'required|in:A,B,C,D',              // ← enum de la BD
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'activo'       => 'nullable|boolean',
        ]);

        $existe = Grado::where('nivel', $validated['nivel'])
            ->where('numero', $validated['numero'])
            ->where('seccion', $validated['seccion'])
            ->where('anio_lectivo', $validated['anio_lectivo'])
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', '¡El grado ya existe para este nivel, sección y año lectivo!');
        }

        $grado = Grado::create([
            'nivel'        => $validated['nivel'],
            'numero'       => $validated['numero'],
            'seccion'      => $validated['seccion'],
            'anio_lectivo' => $validated['anio_lectivo'],
            'activo'       => $request->boolean('activo', true),
        ]);

        // Solo Primaria recibe materias por defecto
        if ($grado->nivel === 'primaria') {                        // ← minúsculas
            $this->asignarMateriasPorDefecto($grado);
        }

        return redirect()
            ->route('grados.index')
            ->with('success', 'Grado creado correctamente.');
    }

    public function show(Grado $grado)
{
    $grado->load('materias'); // ← sin .grados
    return view('grados.show', compact('grado'));
}

    public function edit(Grado $grado)
    {
        return view('grados.edit', compact('grado'));
    }

    public function update(Request $request, Grado $grado)
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:primaria,secundaria',   // ← minúsculas
            'numero'       => 'required|integer|min:1|max:12',
            'seccion'      => 'required|in:A,B,C,D',              // ← enum de la BD
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'activo'       => 'nullable|boolean',
        ]);

        $grado->update([
            'nivel'        => $validated['nivel'],
            'numero'       => $validated['numero'],
            'seccion'      => $validated['seccion'],
            'anio_lectivo' => $validated['anio_lectivo'],
            'activo'       => $request->boolean('activo', $grado->activo),
        ]);

        return redirect()
            ->route('grados.index')
            ->with('success', 'Grado actualizado exitosamente.');
    }

    public function destroy(Grado $grado)
    {
        $grado->delete();

        return redirect()
            ->route('grados.index')
            ->with('success', 'Grado eliminado exitosamente.');
    }

    public function asignarMaterias(Grado $grado)
    {
        $materias = Materia::where('nivel', $grado->nivel)
            ->where('activo', true)
            ->get();

        $profesores = User::where('role', 'profesor')->get();

        $materiasAsignadas = $grado->materias->pluck('id')->toArray();

        return view(
            'grados.asignar-materias',
            compact('grado', 'materias', 'profesores', 'materiasAsignadas')
        );
    }

    public function guardarMaterias(Request $request, Grado $grado)
    {
        $validated = $request->validate([
            'materias'   => 'required|array|min:1',
            'materias.*' => 'exists:materias,id',
            'profesores' => 'nullable|array',
            'horas'      => 'nullable|array',
        ]);

        $syncData = [];

        foreach ($validated['materias'] as $materiaId) {
            $syncData[$materiaId] = [
                'profesor_id'     => $request->profesores[$materiaId] ?? null,
                'horas_semanales' => $request->horas[$materiaId] ?? 0,
            ];
        }

        $grado->materias()->sync($syncData);

        return redirect()
            ->route('grados.show', $grado)
            ->with('success', 'Materias asignadas exitosamente.');
    }

    public function crearMasivo()
    {
        return view('grados.crear-masivo');
    }

    public function generarMasivo(Request $request)
    {
        $validated = $request->validate([
            'capacidad_maxima' => 'required|integer|min:1|max:50',
            'activo'           => 'nullable|boolean',
        ]);

        // Básica → secundaria para alinearse con el ENUM de la BD
        $gradosData = [
            ['nombre' => 'Primer Grado',   'nivel' => 'primaria',   'numero' => 1],
            ['nombre' => 'Segundo Grado',  'nivel' => 'primaria',   'numero' => 2],
            ['nombre' => 'Tercer Grado',   'nivel' => 'primaria',   'numero' => 3],
            ['nombre' => 'Cuarto Grado',   'nivel' => 'primaria',   'numero' => 4],
            ['nombre' => 'Quinto Grado',   'nivel' => 'primaria',   'numero' => 5],
            ['nombre' => 'Sexto Grado',    'nivel' => 'primaria',   'numero' => 6],
            ['nombre' => 'Séptimo Grado',  'nivel' => 'secundaria', 'numero' => 7],
            ['nombre' => 'Octavo Grado',   'nivel' => 'secundaria', 'numero' => 8],
            ['nombre' => 'Noveno Grado',   'nivel' => 'secundaria', 'numero' => 9],
        ];

        $secciones = ['A', 'B', 'C', 'D'];
        $contador  = 0;

        foreach ($gradosData as $gradoData) {
            foreach ($secciones as $seccion) {
                $grado = Grado::updateOrCreate(
                    [
                        'nivel'        => $gradoData['nivel'],
                        'numero'       => $gradoData['numero'],
                        'seccion'      => $seccion,
                        'anio_lectivo' => 2026,
                    ],
                    [
                        'activo' => $request->boolean('activo', true),
                    ]
                );

                if ($gradoData['nivel'] === 'primaria' && $grado->wasRecentlyCreated) {  // ← minúsculas
                    $this->asignarMateriasPorDefecto($grado);
                }

                $contador++;
            }
        }

        return redirect()
            ->route('grados.index')
            ->with('success', "Se han procesado {$contador} grados exitosamente.");
    }
}