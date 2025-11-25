<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('nivel')->orderBy('nombre')->paginate(15);
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:20|unique:materias,codigo',
            'descripcion' => 'nullable|string',
            'nivel' => 'required|in:primaria,secundaria',
            'area' => 'required|in:Matemáticas,Español,Ciencias Naturales,Ciencias Sociales,Educación Física,Educación Artística,Inglés,Informática,Formación Ciudadana',
            'activo' => 'boolean',
        ]);

        Materia::create($request->all());

        return redirect()->route('materias.index')
                        ->with('success', 'Materia creada exitosamente');
    }

    public function show(Materia $materia)
    {
        $materia->load('grados');
        return view('materias.show', compact('materia'));
    }

    public function edit(Materia $materia)
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:20|unique:materias,codigo,' . $materia->id,
            'descripcion' => 'nullable|string',
            'nivel' => 'required|in:primaria,secundaria',
            'area' => 'required|in:Matemáticas,Español,Ciencias Naturales,Ciencias Sociales,Educación Física,Educación Artística,Inglés,Informática,Formación Ciudadana',
            'activo' => 'boolean',
        ]);

        $materia->update($request->all());

        return redirect()->route('materias.index')
                        ->with('success', 'Materia actualizada exitosamente');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();

        return redirect()->route('materias.index')
                        ->with('success', 'Materia eliminada exitosamente');
    }
}