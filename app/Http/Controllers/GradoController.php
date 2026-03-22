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

    /* ============================================================
       LISTAR GRADOS
       ============================================================ */
    public function index()
    {
        $grados = Grado::with('materias')
            ->orderBy('nivel')
            ->orderBy('numero')
            ->paginate(request('per_page', 15));

        return view('grados.index', compact('grados'));
    }

    /* ============================================================
       FORMULARIO DE CREACIÓN
       ============================================================ */
    public function create()
    {
        return view('grados.create');
    }

    /* ============================================================
       GUARDAR GRADO
       ============================================================ */
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

        $grado = Grado::create([
            'nivel'        => $validated['nivel'],
            'numero'       => $validated['numero'],
            'seccion'      => $validated['seccion'],
            'anio_lectivo' => $validated['anio_lectivo'],
            'activo'       => $request->boolean('activo', true),
        ]);

        $nombresGrado = [
            1 => '1er Grado', 2 => '2do Grado', 3 => '3er Grado',
            4 => '4to Grado', 5 => '5to Grado', 6 => '6to Grado',
            7 => '7mo Grado', 8 => '8vo Grado', 9 => '9no Grado',
        ];
        $nombreGradoTexto = $nombresGrado[$validated['numero']]
                            ?? $validated['numero'] . '° Grado';

        Seccion::firstOrCreate(
            [
                'grado'  => $nombreGradoTexto,
                'nombre' => $validated['seccion'],
            ],
            [
                'capacidad' => $validated['capacidad'],
            ]
        );

        if ($grado->nivel === 'primaria') {
            $this->asignarMateriasPorDefecto($grado);
        }

        return redirect()
            ->route('grados.index')
            ->with('success', 'Grado y sección creados correctamente.');
    }

    /* ============================================================
       VER DETALLE DE GRADO
       ============================================================ */
    public function show(Grado $grado)
    {
        $grado->load('materias');
        return view('grados.show', compact('grado'));
    }

    /* ============================================================
       FORMULARIO DE EDICIÓN
       ============================================================ */
    public function edit(Grado $grado)
    {
        return view('grados.edit', compact('grado'));
    }

    /* ============================================================
       ACTUALIZAR GRADO
       ============================================================ */
    public function update(Request $request, Grado $grado)
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:primaria,secundaria',
            'numero'       => 'required|integer|min:1|max:12',
            'seccion'      => 'required|in:A,B,C,D',
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

    /* ============================================================
       ELIMINAR GRADO
       ============================================================ */
    public function destroy(Grado $grado): RedirectResponse
    {
        $grado->materias()->detach();
        $grado->delete();

        return redirect()
            ->route('grados.index')
            ->with('success', 'Grado eliminado correctamente.');
    }

    /* ============================================================
       FORMULARIO ASIGNAR MATERIAS
       ============================================================ */
    public function asignarMaterias(Grado $grado)
    {
        $materiasAsignadas = $grado->materias;
        $materias          = Materia::where('activo', 1)->orderBy('nombre')->get();
        $profesores        = \App\Models\Profesor::orderBy('apellido')->orderBy('nombre')->get();

        return view('grados.asignar-materias', compact(
            'grado',
            'materiasAsignadas',
            'materias',
            'profesores'
        ));
    }

    /* ============================================================
       GUARDAR MATERIAS ASIGNADAS
       ============================================================ */
    public function guardarMaterias(Request $request, Grado $grado): RedirectResponse
    {
        $request->validate([
            'materias.*'   => 'exists:materias,id',
            'horas.*'      => 'nullable|integer|min:1|max:40',
            'profesores.*' => 'nullable|exists:profesores,id',
        ]);


        $syncData = [];
        foreach ($request->input('materias', []) as $materiaId) {
            $syncData[$materiaId] = [
                'horas_semanales' => $request->input("horas.{$materiaId}", 4),
                'profesor_id'     => $request->input("profesores.{$materiaId}") ?: null,
            ];
        }

        $grado->materias()->sync($syncData);

        return redirect()
            ->route('grados.show', $grado)
            ->with('success', 'Materias actualizadas correctamente.');
    }

    /* ============================================================
       FORMULARIO CREACIÓN MASIVA
       ============================================================ */
    public function crearMasivo()
    {
        return view('grados.crear-masivo');
    }

    /* ============================================================
       GENERAR GRADOS MASIVAMENTE
       ============================================================ */
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

        $nombresGrado = [
            1 => '1er Grado', 2 => '2do Grado', 3 => '3er Grado',
            4 => '4to Grado', 5 => '5to Grado', 6 => '6to Grado',
            7 => '7mo Grado', 8 => '8vo Grado', 9 => '9no Grado',
        ];

        $secciones = ['A', 'B', 'C', 'D'];
        $contador  = 0;

        foreach ($gradosData as $data) {
            foreach ($secciones as $letra) {
                $grado = Grado::updateOrCreate(
                    [
                        'nivel'        => $data['nivel'],
                        'numero'       => $data['numero'],
                        'seccion'      => $letra,
                        'anio_lectivo' => 2026,
                    ],
                    ['activo' => $request->boolean('activo', true)]
                );

                Seccion::firstOrCreate(
                    ['grado' => $nombresGrado[$data['numero']], 'nombre' => $letra],
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
}