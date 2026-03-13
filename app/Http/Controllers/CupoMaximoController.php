<?php

namespace App\Http\Controllers;

use App\Models\CupoMaximo;
use Illuminate\Http\Request;

class CupoMaximoController extends Controller
{
    // Muestra la tabla con todos los cupos
    public function index()
    {
        $cursos = CupoMaximo::all();
        return view('cupos_maximos.index', compact('cursos'));
    }

    // Muestra el formulario para crear
    public function create()
    {
        return view('cupos_maximos.create');
    }

    // Guarda los datos en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required',
            'cupo_maximo' => 'required|numeric|max:35',
            'jornada'     => 'required',
            'seccion'     => 'required',
        ]);

        CupoMaximo::create($request->all());

        return redirect()->route('cupos_maximos.index')
            ->with('success', '¡Cupo registrado exitosamente!');
    }

    // Muestra el formulario para editar
    public function edit($id)
    {
        $curso = CupoMaximo::findOrFail($id);
        return view('cupos_maximos.edit', compact('curso'));
    }

    // Procesa la actualización
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'      => 'required',
            'cupo_maximo' => 'required|numeric|max:35',
            'jornada'     => 'required',
            'seccion'     => 'required',
        ]);

        $curso = CupoMaximo::findOrFail($id);
        $curso->update($request->all());

        return redirect()->route('cupos_maximos.index')
            ->with('success', 'Cupo actualizado correctamente');
    }

    // Elimina el cupo
    public function destroy($id)
    {
        $curso = CupoMaximo::findOrFail($id);
        $curso->delete();

        return redirect()->route('cupos_maximos.index')
            ->with('success', 'Cupo eliminado correctamente');
    }
}
