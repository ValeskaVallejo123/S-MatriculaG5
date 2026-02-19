<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    public function index()
    {
        $grados = Grado::with('materias')
            ->orderBy('nivel')
            ->orderBy('numero')
            ->paginate(15);

        return view('grados.index', compact('grados'));
    }

    public function create()
    {
        return view('grados.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nivel' => 'required|in:Primaria,Básica,Secundaria',
            'numero' => 'required|integer|min:1|max:12',
            'seccion' => 'required|string|max:1',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'activo' => 'nullable|boolean',
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

        Grado::create([
            'nivel' => $validated['nivel'],
            'numero' => $validated['numero'],
            'seccion' => $validated['seccion'],
            'anio_lectivo' => $validated['anio_lectivo'],
            'activo' => $request->boolean('activo', true),
        ]);

        return redirect()
            ->route('grados.index')
            ->with('success', 'Grado creado correctamente.');
    }

    public function show(Grado $grado)
    {
        $grado->load('materias.grados');

        return view('grados.show', compact('grado'));
    }

    public function edit(Grado $grado)
    {
        return view('grados.edit', compact('grado'));
    }

    public function update(Request $request, Grado $grado)
    {
        $validated = $request->validate([
            'nivel' => 'required|in:Primaria,Básica,Secundaria',
            'numero' => 'required|integer|min:1|max:12',
            'seccion' => 'required|string|max:1',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'activo' => 'nullable|boolean',
        ]);

        $grado->update([
            'nivel' => $validated['nivel'],
            'numero' => $validated['numero'],
            'seccion' => $validated['seccion'],
            'anio_lectivo' => $validated['anio_lectivo'],
            'activo' => $request->boolean('activo', $grado->activo),
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
            'materias' => 'required|array|min:1',
            'materias.*' => 'exists:materias,id',
            'profesores' => 'nullable|array',
            'horas' => 'nullable|array',
        ]);

        $syncData = [];

        foreach ($validated['materias'] as $materiaId) {
            $syncData[$materiaId] = [
                'profesor_id' => $request->profesores[$materiaId] ?? null,
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
            'activo' => 'nullable|boolean',
        ]);

        $grados = [
            ['nombre' => 'Primer Grado', 'nivel' => 'Primaria', 'numero' => 1],
            ['nombre' => 'Segundo Grado', 'nivel' => 'Primaria', 'numero' => 2],
            ['nombre' => 'Tercer Grado', 'nivel' => 'Primaria', 'numero' => 3],
            ['nombre' => 'Cuarto Grado', 'nivel' => 'Primaria', 'numero' => 4],
            ['nombre' => 'Quinto Grado', 'nivel' => 'Primaria', 'numero' => 5],
            ['nombre' => 'Sexto Grado', 'nivel' => 'Primaria', 'numero' => 6],
            ['nombre' => 'Séptimo Grado', 'nivel' => 'Básica', 'numero' => 7],
            ['nombre' => 'Octavo Grado', 'nivel' => 'Básica', 'numero' => 8],
            ['nombre' => 'Noveno Grado', 'nivel' => 'Básica', 'numero' => 9],
        ];

        $secciones = ['A', 'B', 'C', 'D'];
        $contador = 0;

        foreach ($grados as $gradoData) {
            foreach ($secciones as $seccion) {
                Grado::updateOrCreate(
                    [
                        'nivel' => $gradoData['nivel'],
                        'numero' => $gradoData['numero'],
                        'seccion' => $seccion,
                        'anio_lectivo' => 2026,
                    ],
                    [
                        'nombre' => $gradoData['nombre'],
                        'capacidad_maxima' => $validated['capacidad_maxima'],
                        'activo' => $request->boolean('activo', true),
                        'descripcion' => $gradoData['nombre'] . ' - Sección ' . $seccion,
                    ]
                );
                $contador++;
            }
        }

        return redirect()
            ->route('grados.index')
            ->with('success', "Se han procesado {$contador} grados exitosamente.");
    }
    public function ver(Grado $grado)
{
    $grado->load('materias');
    return view('grados.ver', compact('grado'));
}
}