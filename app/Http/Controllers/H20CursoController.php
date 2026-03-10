<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\H20Curso;

class H20CursoController extends Controller
{
    public function index()
    {
        $cursos = H20Curso::paginate(15);
        return view('h20cursos.index', compact('cursos'));
    }

    public function create()
    {
        // Muestra el formulario de creación
        return view('h20cursos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:h20_cursos,nombre',
            'cupo_maximo' => 'required|integer|min:1',
            'seccion' => 'required|string',
        ]);

        H20Curso::create($request->all());
        return redirect()->route('h20cursos.index')->with('success', 'Curso creado correctamente');
    }

    public function edit(H20Curso $h20curso)
    {
        // Muestra el formulario de edición
        return view('h20cursos.edit', compact('h20curso'));
    }

    public function update(Request $request, H20Curso $h20curso)
    {
        $request->validate([
            'nombre' => 'required|unique:h20_cursos,nombre,' . $h20curso->id,
            'cupo_maximo' => 'required|integer|min:1',
            'seccion' => 'required|string',
        ]);

        $h20curso->update($request->all());
        return redirect()->route('h20cursos.index')->with('success', 'Curso actualizado correctamente');
    }

    public function destroy(H20Curso $h20curso)
    {
        $h20curso->delete();
        return redirect()->route('h20cursos.index')->with('success', 'Curso eliminado correctamente');
    }
}
