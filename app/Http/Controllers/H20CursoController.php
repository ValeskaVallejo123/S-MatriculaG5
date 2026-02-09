<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class H20CursoController extends Controller
{
    public function index()
    {
        $cursos = H20Curso::paginate(15);
        return view('h20cursos.index', compact('cursos'));
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
