<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObservacionController extends Controller
{
    /**
     * Listado con filtros
     */
    public function index(Request $request)
    {
        $query = Observacion::with(['estudiante', 'profesor'])->latest();

        // Filtro por nombre del estudiante (nombre1 o apellido1)
        if ($request->filled('nombre')) {
            $query->whereHas('estudiante', function ($q) use ($request) {
                $q->where('nombre1', 'like', '%' . $request->nombre . '%')
                    ->orWhere('apellido1', 'like', '%' . $request->nombre . '%');
            });
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por rangos de fecha
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

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
     * Formulario de creación
     */
    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $profesores = Profesor::orderBy('nombre')->get();

        return view('observaciones.createObservacion', compact('estudiantes', 'profesores'));
    }

    /**
     * Guardar observación
     */
    public function store(Request $request)
    {
        // Quitamos todas las restricciones de 'required'
        $request->validate([
            'estudiante_id' => 'nullable',
            'descripcion'   => 'nullable',
            'tipo'          => 'nullable',
        ]);

        // Solo tomamos los datos que nos interesan
        $data = $request->only(['estudiante_id', 'descripcion', 'tipo']);

        // Si quieres que el profesor_id sea totalmente ignorado o nulo:
        $data['profesor_id'] = null;



        return redirect()->route('observaciones.index')
            ->with('success', 'Observación guardada sin necesidad de profesor.');
    }

    /**
     * Actualizar observación
     */
    public function update(Request $request, Observacion $observacion)
    {
        // Mismo cambio aquí para permitir editar sin llenar todo obligatoriamente
        $request->validate([
            'estudiante_id' => 'nullable|exists:estudiantes,id',
            'profesor_id' => 'nullable|exists:profesores,id',
            'descripcion' => 'nullable|string|max:1000',
            'tipo' => 'nullable|string',
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

    // ... (método destroy se mantiene igual)


    /**
     * Formulario de edición
     */
    public function edit(Observacion $observacion)
    {
        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $profesores = Profesor::orderBy('nombre')->get();

        return view('observaciones.editObservacion', compact('observacion', 'estudiantes', 'profesores'));
    }

    public function destroy(Observacion $observacion)
    {
        $observacion->delete();

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación eliminada correctamente.');
    }
}

