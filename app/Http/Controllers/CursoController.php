<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::all();
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
        ], [
            'nombre.required' => 'El nombre del curso es obligatorio.',
            'cupo_maximo.required' => 'Debe ingresar la cantidad de cupos máximos.',
            'cupo_maximo.integer' => 'El campo cupo máximo debe ser 35.',
            'cupo_maximo.min' => 'El número de cupos debe ser al menos 30.',
        ]);

        Curso::create($request->only(['nombre', 'cupo_maximo', 'jornada', 'seccion']));

        return redirect()->route('cupos_maximos.index')->with('success', 'El cupo fue creado correctamente.');
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        return view('cupos_maximos.edit', compact('curso'));
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        // Validar los datos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'cupo_maximo' => 'required|integer|min:1|max:35',
            'jornada' => 'nullable|string|max:50',
            'seccion' => 'nullable|string|max:10',
        ], [
            'nombre.required' => 'El nombre del curso es obligatorio.',
            'cupo_maximo.required' => 'Debe ingresar la cantidad de cupos máximos.',
            'cupo_maximo.integer' => 'El campo cupo máximo debe ser 35.',
            'cupo_maximo.min' => 'El número de cupos debe ser al menos 30.',
        ]);

        // Verificar si hay cambios
        $sinCambios =
            $curso->nombre === $validatedData['nombre'] &&
            $curso->cupo_maximo == $validatedData['cupo_maximo'] &&
            $curso->jornada === ($validatedData['jornada'] ?? null) &&
            $curso->seccion === ($validatedData['seccion'] ?? null);

        if ($sinCambios) {
            return redirect()->route('cupos_maximos.index')
                ->with('success', 'No se realizaron cambios.');
        }

        $curso->update($validatedData);

        return redirect()->route('cupos_maximos.index')->with('success', 'El cupo fue actualizado correctamente.');
    }


    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return redirect()->route('cupos_maximos.index')->with('success', 'El cupo fue eliminado correctamente.');
    }
}
