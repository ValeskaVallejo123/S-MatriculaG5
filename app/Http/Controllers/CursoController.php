<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los valores de los filtros del request
        $searchNombre = $request->input('searchNombre');
        $filterJornada = $request->input('filterJornada');
        $filterSeccion = $request->input('filterSeccion');

        // Construir la consulta
        $query = Curso::query();

        if ($searchNombre) {
            $query->where('nombre', 'LIKE', '%' . $searchNombre . '%');
        }

        if ($filterJornada) {
            $query->where('jornada', $filterJornada);
        }

        if ($filterSeccion) {
            $query->where('seccion', $filterSeccion);
        }

        // Ejecutar la consulta
        $cursos = $query->get();

        // Pasar los cursos a la vista
        return view('cupos_maximos.index', compact('cursos'));
    }


    public function create()
    {
        return view('cupos_maximos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'cupo_maximo' => 'required|integer|min:30|max:35',
            'jornada' => 'required',
            'seccion' => 'required',
        ], [
            'cupo_maximo.min' => 'El campo Cupo máximo debe ser al menos 30.',
            'cupo_maximo.max' => 'El campo Cupo máximo no puede ser mayor a 35.',
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
            'nombre' => 'required',
            'cupo_maximo' => 'required|integer|min:30|max:35',
            'jornada' => 'required',
            'seccion' => 'required',
        ], [
            'cupo_maximo.min' => 'El campo cupo estudiante debe ser al menos 30.',
            'cupo_maximo.max' => 'El campo cupo estudiante no puede ser mayor a 35.',
        ]);

        // Verificar si hay cambios
        $cambios = false;
        foreach ($validatedData as $campo => $valor) {
            if ($curso->$campo != $valor) {
                $cambios = true;
                break;
            }
        }

        if (!$cambios) {
            return redirect()->route('cupos_maximos.index')
                ->with('info', 'No se realizaron cambios en el cupo.');
        }

        $curso->update($validatedData);

        return redirect()->route('cupos_maximos.index')
            ->with('success', 'Cupo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return redirect()->route('cupos_maximos.index')->with('success','Cupo eliminado correctamente.');
    }
}
