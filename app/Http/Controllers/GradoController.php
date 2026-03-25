<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Materia;
use App\Models\User;
use App\Models\Seccion;
use App\Helpers\GradoHelper;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class GradoController extends Controller
{
    /**
     * Nombres de las materias que se asignan automáticamente a todo grado de Primaria.
     */
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

    /**
     * Listar todos los grados
     */
    public function index()
    {
        $grados = Grado::with('materias')
            ->orderBy('nivel')
            ->orderBy('numero')
            ->paginate(request('per_page', 15));

        return view('grados.index', compact('grados'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('grados.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:primaria,secundaria',
            'numero'       => 'required|integer|min:1|max:9',
            'seccion'      => 'required|in:A,B,C,D',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'capacidad'    => 'required|integer|min:1|max:60',
            'activo'       => 'nullable|boolean',
        ]);

        // ── 1. Verificar duplicado de grado ─────────────────────────────────
        $existe = Grado::where('nivel',        $validated['nivel'])
                       ->where('numero',       $validated['numero'])
                       ->where('seccion',      $validated['seccion'])
                       ->where('anio_lectivo', $validated['anio_lectivo'])
                       ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', '¡El grado ya existe para este nivel, sección y año lectivo!');
        }

        // ── 2. Crear el Grado ────────────────────────────────────────────────
        $grado = Grado::create([
            'nivel'        => $validated['nivel'],
            'numero'       => $validated['numero'],
            'seccion'      => $validated['seccion'],
            'anio_lectivo' => $validated['anio_lectivo'],
            'capacidad'    => $validated['capacidad'],
            'activo'       => $request->boolean('activo'),
        ]);

        // ── 3. Sincronizar con tabla secciones ───────────────────────────────
        $gradoNombre = GradoHelper::GRADOS[$validated['numero'] - 1]
                       ?? $validated['numero'] . '° Grado';

        Seccion::firstOrCreate(
            [
                'grado'  => $gradoNombre,
                'nombre' => $validated['seccion'],
            ],
            [
                'capacidad' => $validated['capacidad'],
            ]
        );

        // ── 4. Materias por defecto solo para Primaria ───────────────────────
        if ($grado->nivel === 'primaria') {
            $this->asignarMateriasPorDefecto($grado);
        }

        return redirect()
            ->route('superadmin.grados.index')
            ->with('success', 'Grado creado correctamente.');
    }

    public function update(Request $request, Grado $grado)
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:primaria,secundaria',
            'numero'       => 'required|integer|min:1|max:9',
            'seccion'      => 'required|in:A,B,C,D',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'capacidad'    => 'required|integer|min:1|max:60',
            'activo'       => 'nullable|boolean',
        ]);

        // ── 1. Actualizar el Grado ───────────────────────────────────────────
        $grado->update([
            'nivel'        => $validated['nivel'],
            'numero'       => $validated['numero'],
            'seccion'      => $validated['seccion'],
            'anio_lectivo' => $validated['anio_lectivo'],
            'capacidad'    => $validated['capacidad'],
            'activo'       => $request->boolean('activo'),
        ]);

        // ── 2. Actualizar capacidad en secciones si ya existe ────────────────
        $gradoNombre = GradoHelper::GRADOS[$validated['numero'] - 1]
                       ?? $validated['numero'] . '° Grado';

        Seccion::firstOrCreate(
            [
                'grado'  => $gradoNombre,
                'nombre' => $validated['seccion'],
            ],
            [
                'capacidad' => $validated['capacidad'],
            ]
        )->update(['capacidad' => $validated['capacidad']]);

        return redirect()
            ->route('superadmin.grados.index')
            ->with('success', 'Grado actualizado correctamente.');
    }

    public function generarMasivo(Request $request)
    {
        $validated = $request->validate([
            'capacidad_maxima' => 'required|integer|min:1|max:60',
            'activo'           => 'nullable|boolean',
        ]);

        $gradosData = [
            ['nivel' => 'primaria',   'numero' => 1],
            ['nivel' => 'primaria',   'numero' => 2],
            ['nivel' => 'primaria',   'numero' => 3],
            ['nivel' => 'primaria',   'numero' => 4],
            ['nivel' => 'primaria',   'numero' => 5],
            ['nivel' => 'primaria',   'numero' => 6],
            ['nivel' => 'secundaria', 'numero' => 7],
            ['nivel' => 'secundaria', 'numero' => 8],
            ['nivel' => 'secundaria', 'numero' => 9],
        ];

        $secciones = ['A', 'B', 'C', 'D'];
        $contador  = 0;

        foreach ($gradosData as $data) {
            foreach ($secciones as $letra) {
                // ── Crear/Actualizar Grado ───────────────────────────────────
                $grado = Grado::updateOrCreate(
                    [
                        'nivel'        => $data['nivel'],
                        'numero'       => $data['numero'],
                        'seccion'      => $letra,
                        'anio_lectivo' => 2026,
                    ],
                    ['activo' => $request->boolean('activo', true)]
                );

                // ── Crear/Asegurar Sección ───────────────────────────────────
                $gradoNombre = GradoHelper::GRADOS[$data['numero'] - 1]
                               ?? $data['numero'] . '° Grado';

                Seccion::firstOrCreate(
                    [
                        'grado'  => $gradoNombre,
                        'nombre' => $letra,
                    ],
                    ['capacidad' => $validated['capacidad_maxima']]
                );

                if ($data['nivel'] === 'primaria' && $grado->wasRecentlyCreated) {
                    $this->asignarMateriasPorDefecto($grado);
                }

                $contador++;
            }
        }

        return redirect()
            ->route('grados.index')
            ->with('success', "Se han procesado {$contador} grados y sus respectivas secciones.");
    }

    public function show(Grado $grado)
    {
        $grado->load('materias');
        return view('grados.show', compact('grado'));
    }

    public function edit(Grado $grado)
    {
        return view('grados.edit', compact('grado'));
    }

    /**
     * Eliminar un grado y sus materias asociadas
     */
    public function destroy(Grado $grado): RedirectResponse
    {
        $grado->materias()->detach();
        $grado->delete();

        return redirect()
            ->route('superadmin.grados.index')
            ->with('success', 'Grado eliminado correctamente.');
    }

    public function asignarMaterias(Grado $grado)
    {
        $grado->load('materias');
        $materias          = Materia::where('activo', true)->orderBy('nombre')->get();
        $materiasAsignadas = $grado->materias->pluck('id')->toArray();

        return view('grados.asignar-materias', compact('grado', 'materias', 'materiasAsignadas'));
    }

    public function guardarMaterias(Request $request, Grado $grado)
    {
        $validated = $request->validate([
            'materias'   => 'nullable|array',
            'materias.*' => 'exists:materias,id',
            'horas.*'    => 'nullable|integer|min:1|max:40',
            'profesor.*' => 'nullable|exists:users,id',
        ]);

        $syncData = [];
        foreach ($request->input('materias', []) as $materiaId) {
            $syncData[$materiaId] = [
                'horas_semanales' => $request->input("horas.{$materiaId}", 4),
                'profesor_id'     => $request->input("profesor.{$materiaId}") ?: null,
            ];
        }

        $grado->materias()->sync($syncData);

        return redirect()
            ->route('superadmin.grados.show', $grado)
            ->with('success', 'Materias actualizadas correctamente.');
    }
}