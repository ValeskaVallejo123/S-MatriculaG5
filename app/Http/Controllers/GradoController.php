<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Materia;
use App\Models\User;
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

    /**
     * Busca los IDs de las materias por defecto de Primaria y las asigna al grado.
     * Solo asigna las que existan en la BD y que el grado aún no tenga asignadas.
     */
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

        // syncWithoutDetaching para no pisar asignaciones previas
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
            ->paginate(15);

        return view('grados.index', compact('grados'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('grados.create');
    }

    /**
     * Guardar un nuevo grado
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:Primaria,Básica,Secundaria',
            'numero'       => 'required|integer|min:1|max:12',
            'seccion'      => 'required|string|max:1',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'activo'       => 'nullable|boolean',
        ]);

        // Verificar duplicados
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

        // Asignar materias por defecto solo para Primaria
        if ($grado->nivel === 'Primaria') {
            $this->asignarMateriasPorDefecto($grado);
        }

        return redirect()
            ->route('grados.index')
            ->with('success', 'Grado creado correctamente.');
    }

    /**
     * Mostrar detalle de un grado
     */
    public function show(Grado $grado)
    {
        $grado->load('materias.grados');

        return view('grados.show', compact('grado'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Grado $grado)
    {
        return view('grados.edit', compact('grado'));
    }

    /**
     * Actualizar un grado existente
     */
    public function update(Request $request, Grado $grado): RedirectResponse
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:Primaria,Básica,Secundaria',
            'numero'       => 'required|integer|min:1|max:12',
            'seccion'      => 'required|string|max:1',
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

    /**
     * Eliminar un grado
     */
    public function destroy(Grado $grado): RedirectResponse
    {
        // Verificar si tiene estudiantes asignados antes de eliminar
        // if ($grado->estudiantes()->count() > 0) {
        //     return back()->with('error', 'No se puede eliminar el grado porque tiene estudiantes asignados.');
        // }

        $grado->delete();

        return redirect()
            ->route('grados.index')
            ->with('success', 'Grado eliminado exitosamente.');
    }

    /**
     * Mostrar formulario de asignación de materias
     */
    public function asignarMaterias(Grado $grado)
    {
        $materias = Materia::where('nivel', $grado->nivel)
            ->where('activo', true)
            ->get();

        // Usar id_rol consistente con el sistema de roles
        $profesores = User::where('id_rol', 3)->get();

        $materiasAsignadas = $grado->materias->pluck('id')->toArray();

        return view(
            'grados.asignar-materias',
            compact('grado', 'materias', 'profesores', 'materiasAsignadas')
        );
    }

    /**
     * Guardar materias asignadas a un grado
     */
    public function guardarMaterias(Request $request, Grado $grado): RedirectResponse
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

    /**
     * Mostrar formulario de creación masiva
     */
    public function crearMasivo()
    {
        return view('grados.crear-masivo');
    }

    /**
     * Generar grados masivamente (9 grados × 4 secciones)
     */
    public function generarMasivo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'capacidad_maxima' => 'required|integer|min:1|max:50',
            'activo'           => 'nullable|boolean',
        ]);

        $gradosData = [
            ['nombre' => 'Primer Grado',  'nivel' => 'Primaria', 'numero' => 1],
            ['nombre' => 'Segundo Grado', 'nivel' => 'Primaria', 'numero' => 2],
            ['nombre' => 'Tercer Grado',  'nivel' => 'Primaria', 'numero' => 3],
            ['nombre' => 'Cuarto Grado',  'nivel' => 'Primaria', 'numero' => 4],
            ['nombre' => 'Quinto Grado',  'nivel' => 'Primaria', 'numero' => 5],
            ['nombre' => 'Sexto Grado',   'nivel' => 'Primaria', 'numero' => 6],
            ['nombre' => 'Séptimo Grado', 'nivel' => 'Básica',   'numero' => 7],
            ['nombre' => 'Octavo Grado',  'nivel' => 'Básica',   'numero' => 8],
            ['nombre' => 'Noveno Grado',  'nivel' => 'Básica',   'numero' => 9],
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
                        'nombre'           => $gradoData['nombre'],
                        'capacidad_maxima' => $validated['capacidad_maxima'],
                        'activo'           => $request->boolean('activo', true),
                        'descripcion'      => $gradoData['nombre'] . ' - Sección ' . $seccion,
                    ]
                );

                // Asignar materias por defecto solo a grados de Primaria recién creados
                if ($gradoData['nivel'] === 'Primaria' && $grado->wasRecentlyCreated) {
                    $this->asignarMateriasPorDefecto($grado);
                }

                $contador++;
            }
        }

        return redirect()
            ->route('grados.index')
            ->with('success', "Se han procesado {$contador} grados exitosamente (9 grados × 4 secciones).");
    }
}
