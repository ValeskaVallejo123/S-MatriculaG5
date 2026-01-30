<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\Materia;
use Illuminate\Http\Request;

class ProfesorMateriaController extends Controller
{
    public function index()
    {
        $asignaciones = Profesor::with('materias')->get();
        return view('profesor_materia.index', compact('asignaciones'));
    }

    public function create()
    {
        $profesores = Profesor::all();
        $materias = Materia::all();
        return view('profesor_materia.create', compact('profesores', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'materia_ids' => 'required|array',
            'materia_ids.*' => 'exists:materias,id'
        ]);

        $profesor = Profesor::find($request->profesor_id);
        $profesor->materias()->sync($request->materia_ids); // asigna materias

        return redirect()->route('profesor_materia.index')->with('success', 'Materias asignadas correctamente.');
    }

    public function edit(Profesor $profesor)
    {
        $materias = Materia::all();
        $selectedMaterias = $profesor->materias->pluck('id')->toArray();
        return view('profesor_materia.edit', compact('profesor', 'materias', 'selectedMaterias'));
    }

    public function update(Request $request, Profesor $profesor)
    {
        $request->validate([
            'materia_ids' => 'required|array',
            'materia_ids.*' => 'exists:materias,id'
        ]);

        $profesor->materias()->sync($request->materia_ids);
        return redirect()->route('profesor_materia.index')->with('success', 'Asignación actualizada.');
    }

    public function destroy(Profesor $profesor, $materiaId)
    {
        $profesor->materias()->detach($materiaId);
        return redirect()->route('profesor_materia.index')->with('success', 'Materia desasignada.');
    }
}
