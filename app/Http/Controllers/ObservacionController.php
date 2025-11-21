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
    public function index(Request $request)
    {
        $query = Observacion::with(['estudiante', 'profesor'])->latest();

        // Filtro por nombre del estudiante
        if ($request->filled('nombre')) {
            $query->whereHas('estudiante', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->nombre . '%');
            });
        }

        // Filtro por tipo de observación
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por fecha desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        // Filtro por fecha hasta
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $observaciones = $query->paginate(10)->withQueryString();

        return view('observaciones.indexObservacion', compact('observaciones'))
            ->with([
                'filtros' => [
                    'nombre' => $request->nombre,
                    'tipo' => $request->tipo,
                    'fecha_desde' => $request->fecha_desde,
                    'fecha_hasta' => $request->fecha_hasta,
                ]
            ]);
    }



    /**
     * Muestra el formulario para crear una nueva observación
     */
    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre1')->get();
$profesores = Profesor::orderBy('nombre')->get();

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



