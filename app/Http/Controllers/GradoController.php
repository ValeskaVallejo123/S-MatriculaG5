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
        $grados = Grado::with('materias')->orderBy('nivel')->orderBy('numero')->paginate(15);
        return view('grados.index', compact('grados'));
    }

    public function create()
    {
        return view('grados.create');
    }

    public function store(Request $request)
{
    // Validación de los campos
    $request->validate([
        'nivel' => 'required|string',
        'numero' => 'required|integer',
        'seccion' => 'required|string',
        'anio_lectivo' => 'required|integer',
    ]);

    // Verificar si ya existe el grado
    $existe = Grado::where('nivel', $request->nivel)
                    ->where('numero', $request->numero)
                    ->where('seccion', $request->seccion)
                    ->where('anio_lectivo', $request->anio_lectivo)
                    ->exists();

    if ($existe) {
        // Retornar mensaje de error
        return back()->withInput()->with('error', '¡El grado ya existe para este nivel, sección y año lectivo!');
    }

    // Crear el grado si no existe
    Grado::create([
        'nivel' => $request->nivel,
        'numero' => $request->numero,
        'seccion' => $request->seccion,
        'anio_lectivo' => $request->anio_lectivo,
        'activo' => $request->activo ?? 1,
    ]);

    return redirect()->route('grados.index')->with('success', 'Grado creado correctamente.');
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
        $request->validate([
            'nivel' => 'required|in:primaria,secundaria',
            'numero' => 'required|integer|min:1|max:9',
            'seccion' => 'nullable|string|max:1',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
        ]);

        $grado->update($request->all());

        return redirect()->route('grados.index')
                        ->with('success', 'Grado actualizado exitosamente');
    }

    public function destroy(Grado $grado)
    {
        $grado->delete();

        return redirect()->route('grados.index')
                        ->with('success', 'Grado eliminado exitosamente');
    }

    // Método para mostrar formulario de asignación de materias
    public function asignarMaterias(Grado $grado)
    {
        // Obtener materias del mismo nivel del grado
        $materias = Materia::where('nivel', $grado->nivel)
                          ->where('activo', true)
                          ->get();

        // Obtener profesores (usuarios con rol 'profesor')
        $profesores = User::where('role', 'profesor')->get();

        // Materias ya asignadas a este grado
        $materiasAsignadas = $grado->materias->pluck('id')->toArray();

        return view('grados.asignar-materias', compact('grado', 'materias', 'profesores', 'materiasAsignadas'));
    }

    // Método para guardar las materias asignadas
    public function guardarMaterias(Request $request, Grado $grado)
    {
        $request->validate([
            'materias' => 'required|array|min:1',
            'materias.*' => 'exists:materias,id',
            'profesores' => 'nullable|array',
            'profesores.*' => 'nullable|exists:users,id',
            'horas' => 'nullable|array',
            'horas.*' => 'nullable|integer|min:1|max:10',
        ]);

        // Preparar datos para sincronización
        $syncData = [];
        foreach ($request->materias as $materiaId) {
            $syncData[$materiaId] = [
                'profesor_id' => $request->profesores[$materiaId] ?? null,
                'horas_semanales' => $request->horas[$materiaId] ?? 0,
            ];
        }

        // Sincronizar materias (esto elimina las no seleccionadas y agrega las nuevas)
        $grado->materias()->sync($syncData);

        return redirect()->route('grados.show', $grado)
                        ->with('success', 'Materias asignadas exitosamente');
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
        ['nombre' => 'Primer Grado', 'nivel' => 'Primaria', 'orden' => 1],
        ['nombre' => 'Segundo Grado', 'nivel' => 'Primaria', 'orden' => 2],
        ['nombre' => 'Tercer Grado', 'nivel' => 'Primaria', 'orden' => 3],
        ['nombre' => 'Cuarto Grado', 'nivel' => 'Primaria', 'orden' => 4],
        ['nombre' => 'Quinto Grado', 'nivel' => 'Primaria', 'orden' => 5],
        ['nombre' => 'Sexto Grado', 'nivel' => 'Primaria', 'orden' => 6],
        ['nombre' => 'Séptimo Grado', 'nivel' => 'Básica', 'orden' => 7],
        ['nombre' => 'Octavo Grado', 'nivel' => 'Básica', 'orden' => 8],
        ['nombre' => 'Noveno Grado', 'nivel' => 'Básica', 'orden' => 9],
    ];

    $secciones = ['A', 'B', 'C', 'D'];
    $contador = 0;

    foreach ($grados as $gradoData) {
        foreach ($secciones as $seccion) {
            Grado::create([
                'nombre' => $gradoData['nombre'],
                'seccion' => $seccion,
                'nivel' => $gradoData['nivel'],
                'capacidad_maxima' => $validated['capacidad_maxima'],
                'activo' => $request->has('activo'),
                'descripcion' => $gradoData['nombre'] . ' - Sección ' . $seccion,
            ]);
            $contador++;
        }
    }

    return redirect()->route('grados.index')
        ->with('success', " Se han creado {$contador} grados exitosamente (9 grados × 4 secciones)");
}
}
