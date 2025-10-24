<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ObservacionController extends Controller
{
    /**
     * Muestra el listado de observaciones
     */
    public function index()
    {
        $observaciones = Observacion::with(['estudiante', 'profesor'])
            ->latest()
            ->paginate(10);

        return view('observaciones.indexObservacion', compact('observaciones'));
    }

    /**
     * Muestra el formulario para crear una nueva observación
     */
    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre')->get();
        $profesores = Profesor::orderBy('nombre')->get(); // si quieres que el profe se seleccione manualmente

        return view('observaciones.createObservacion', compact('estudiantes', 'profesores'));
    }

    /**
     * Guarda una nueva observación en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'profesor_id' => 'required|exists:profesores,id',
            'descripcion' => 'required|string|max:1000',
            'tipo' => 'required|in:positivo,negativo',
        ]);

        Observacion::create([
            'estudiante_id' => $request->estudiante_id,
            'profesor_id' => $request->profesor_id,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
        ]);

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación registrada correctamente.');
    }

    /**
     * Muestra el formulario para editar una observación existente
     */
    public function edit(Observacion $observacion)
    {
        $estudiantes = Estudiante::orderBy('nombre')->get();
        $profesores = Profesor::orderBy('nombre')->get();

        return view('observaciones.editObservacion', compact('observacion', 'estudiantes', 'profesores'));
    }

    /**
     * Actualiza una observación existente
     */
    public function update(Request $request, Observacion $observacion)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'profesor_id' => 'required|exists:profesores,id',
            'descripcion' => 'required|string|max:1000',
            'tipo' => 'required|in:positivo,negativo',
        ]);

        $observacion->update($request->only([
            'estudiante_id',
            'profesor_id',
            'descripcion',
            'tipo'
        ]));

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación actualizada correctamente.');
    }

    /**
     * Elimina una observación
     */
    public function destroy(Observacion $observacion)
    {
        $observacion->delete();

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación eliminada correctamente.');
    }
}



