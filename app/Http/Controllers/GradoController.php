<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Materia;
use App\Models\User;
use App\Models\Seccion;
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
        'numero'       => 'required|integer|min:1|max:12',
        'seccion'      => 'required|in:A,B,C,D',
        'anio_lectivo' => 'required|integer|min:2020|max:2100',
        'activo'       => 'nullable|boolean',
        'capacidad'    => 'required|integer|min:1|max:60',
    ]);

    // ── 1. Verificar duplicado de grado ─────────────────────────────────────
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

    // ── 2. Crear el Grado ────────────────────────────────────────────────────
    $grado = Grado::create([
        'nivel'        => $validated['nivel'],
        'numero'       => $validated['numero'],
        'seccion'      => $validated['seccion'],
        'anio_lectivo' => $validated['anio_lectivo'],
        'activo'       => $request->boolean('activo', true),
    ]);

    // ── 3. Construir el nombre del grado para la tabla seccion ───────────────
    $nombresGrado = [
        1 => '1er Grado', 2 => '2do Grado', 3 => '3er Grado',
        4 => '4to Grado', 5 => '5to Grado', 6 => '6to Grado',
        7 => '7mo Grado', 8 => '8vo Grado', 9 => '9no Grado',
    ];

    $nombreGradoTexto = $nombresGrado[$validated['numero']]
                        ?? $validated['numero'] . '° Grado';

    // ── 4. Crear la Sección (columna "nombre", NO "letra") ───────────────────
    //       "letra" es solo un accessor del modelo, no existe en BD
    Seccion::firstOrCreate(
        [
            'grado'  => $nombreGradoTexto,   // ej. "1er Grado"
            'nombre' => $validated['seccion'], // ej. "A"  ← columna real en BD
        ],
        [
            'capacidad' => $validated['capacidad'],
        ]
    );

    // ── 5. Materias por defecto solo para Primaria ───────────────────────────
    if ($grado->nivel === 'primaria') {
        $this->asignarMateriasPorDefecto($grado);
    }

    return redirect()
        ->route('grados.index')
        ->with('success', 'Grado y sección creados correctamente.');
}

    public function update(Request $request, Grado $grado)
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:primaria,secundaria',
            'numero'       => 'required|integer|min:1|max:12',
            'seccion'      => 'required|in:A,B,C,D',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'activo'       => 'nullable|boolean',
            // Si el update también permite editar capacidad, deberías agregarlo aquí y actualizar la Sección vinculada
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

    public function generarMasivo(Request $request)
    {
        $validated = $request->validate([
            'capacidad_maxima' => 'required|integer|min:1|max:60', // Actualizado a 60 para coincidir
            'activo'           => 'nullable|boolean',
        ]);

        $gradosData = [
            ['nivel' => 'primaria',  'numero' => 1],
            ['nivel' => 'primaria',  'numero' => 2],
            ['nivel' => 'primaria',  'numero' => 3],
            ['nivel' => 'primaria',  'numero' => 4],
            ['nivel' => 'primaria',  'numero' => 5],
            ['nivel' => 'primaria',  'numero' => 6],
            ['nivel' => 'secundaria', 'numero' => 7],
            ['nivel' => 'secundaria', 'numero' => 8],
            ['nivel' => 'secundaria', 'numero' => 9],
        ];

        $nombresGrado = [
            1 => '1er Grado', 2 => '2do Grado', 3 => '3er Grado',
            4 => '4to Grado', 5 => '5to Grado', 6 => '6to Grado',
            7 => '7mo Grado', 8 => '8vo Grado', 9 => '9no Grado',
        ];

        $secciones = ['A', 'B', 'C', 'D'];
        $contador  = 0;

        foreach ($gradosData as $data) {
            foreach ($secciones as $letra) {
                // Crear/Actualizar Grado
                $grado = Grado::updateOrCreate(
                    [
                        'nivel'        => $data['nivel'],
                        'numero'       => $data['numero'],
                        'seccion'      => $letra,
                        'anio_lectivo' => 2026,
                    ],
                    ['activo' => $request->boolean('activo', true)]);

                // Crear/Asegurar Sección para el proceso masivo
                Seccion::firstOrCreate(
    ['grado' => $nombresGrado[$data['numero']], 'nombre' => $letra], // ← 'nombre'
    ['capacidad' => $validated['capacidad_maxima']]
);

                if ($data['nivel'] === 'primaria' && $grado->wasRecentlyCreated) {
                    $this->asignarMateriasPorDefecto($grado);
                }
                $contador++;
            }
        }

        return redirect()->route('grados.index')->with('success', "Se han procesado {$contador} grados y sus respectivas secciones.");
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
 *
 * @param Grado $grado Grado a eliminar
 * @return RedirectResponse
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
    $materiasAsignadas = $grado->materias->pluck('id')->toArray(); // ← IDs como array

    return view('grados.asignar-materias', compact('grado', 'materias', 'materiasAsignadas'));
}

public function guardarMaterias(Request $request, Grado $grado)
{
    $validated = $request->validate([
        'materias'                => 'nullable|array',
        'materias.*'              => 'exists:materias,id',
        'horas.*'                 => 'nullable|integer|min:1|max:40',
        'profesor.*'              => 'nullable|exists:users,id',
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

// Los demás métodos (show, edit, destroy, asignarMaterias, guardarMaterias, crearMasivo) permanecen igual.
    // Los demás métodos (show, edit, destroy, asignarMaterias, guardarMaterias, crearMasivo) permanecen igual.
}