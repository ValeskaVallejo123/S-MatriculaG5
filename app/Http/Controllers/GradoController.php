<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    // Mostrar todos los grados
   public function index()
{
$grados = Grado::orderBy('id')->get();

    return view('grados.index', compact('grados'));
}


    // Mostrar formulario de creación
    public function create()
    {
        return view('grados.create');
    }

    // Guardar nuevo grado
   public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:50|unique:grados',
        'seccion' => 'nullable|string|max:2',
        'jornada' => 'required|in:Matutina,Vespertina',
        'nombre_maestro' => 'required|string|max:255', // Cambio aquí
    ]);

    Grado::create($request->all());

    return redirect()->route('grados.index')
        ->with('success', 'Grado creado exitosamente.');
}

    // Mostrar un grado específico
    public function show(Grado $grado)
    {
        return view('grados.show', compact('grado'));
    }

    // Mostrar formulario de edición
    public function edit(Grado $grado)
    {
        return view('grados.edit', compact('grado'));
    }

    // Actualizar grado
    public function update(Request $request, Grado $grado)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:grados,nombre,' . $grado->id,
            'seccion' => 'nullable|string|max:255',
            'jornada' => 'required|in:Matutina,Vespertina',
            'nombre_maestro' => 'required|string|max:255', // Cambio aquí
        ]);

        $grado->update($request->all());

        return redirect()->route('grados.index')
            ->with('success', 'Grado actualizado exitosamente.');
    }

    // Eliminar grado
    public function destroy(Grado $grado)
    {
        $grado->delete();

        return redirect()->route('grados.index')
            ->with('success', 'Grado eliminado exitosamente.');
    }
}