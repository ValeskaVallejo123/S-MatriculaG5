<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::all(); // 🔹 Esto funciona si la tabla existe
        return view('cupos_maximos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cupos_maximos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cupo_maximo' => 'required|integer|min:30|max:35',
            'jornada' => 'nullable|string|max:50',
            'seccion' => 'nullable|string|max:10',
        ]);

        Curso::create($request->only(['nombre','cupo_maximo','jornada','seccion']));

        return redirect()->route('cupos_maximos.index')->with('success','Cupo creado correctamente.');
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        return view('cupos_maximos.edit', compact('curso'));
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'cupo_maximo' => 'required|integer|min:30|max:35',
            'jornada' => 'nullable|string|max:50',
            'seccion' => 'nullable|string|max:10',
        ]);

        $curso->update($validatedData);

        return redirect()->route('cupos_maximos.index')->with('success','Cupo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return redirect()->route('cupos_maximos.index')->with('success','Cupo eliminado correctamente.');
    }
}
