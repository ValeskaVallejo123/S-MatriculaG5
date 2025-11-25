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
        $request->validate([
            'nivel' => 'required|in:primaria,secundaria',
            'numero' => 'required|integer|min:1|max:9',
            'seccion' => 'nullable|string|max:1',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
        ]);

        // Validar que el número sea correcto según el nivel
        if ($request->nivel == 'primaria' && ($request->numero < 1 || $request->numero > 6)) {
            return back()->withErrors(['numero' => 'Para primaria, el grado debe ser entre 1° y 6°'])->withInput();
        }

        if ($request->nivel == 'secundaria' && ($request->numero < 7 || $request->numero > 9)) {
            return back()->withErrors(['numero' => 'Para secundaria, el grado debe ser entre 7° y 9°'])->withInput();
        }

        Grado::create($request->all());

        return redirect()->route('grados.index')
                        ->with('success', 'Grado creado exitosamente');
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
}
