<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ObservacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Observacion::with(['estudiante', 'profesor'])->latest();

        // Filtro por nombre del estudiante (concatenando nombre1 y apellido1)
        if ($request->filled('nombre')) {
            $query->whereHas('estudiante', function ($q) use ($request) {
                $q->whereRaw("CONCAT(nombre1, ' ', apellido1) LIKE ?", ['%' . $request->nombre . '%']);
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

    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre1')->get(); // usar nombre1
        $profesores = Profesor::orderBy('nombre')->get();     // asegúrate que exista esta columna

        return view('observaciones.createObservacion', compact('estudiantes', 'profesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'profesor_id' => 'required|exists:profesores,id',
            'descripcion' => 'required|string|max:1000',
            'tipo' => 'required|in:positivo,negativo',
        ]);

        Observacion::create($request->only(['estudiante_id', 'profesor_id', 'descripcion', 'tipo']));

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación registrada correctamente.');
    }

    public function edit(Observacion $observacion)
    {
        $estudiantes = Estudiante::orderBy('nombre1')->get(); // usar nombre1
        $profesores = Profesor::orderBy('nombre')->get();

        return view('observaciones.editObservacion', compact('observacion', 'estudiantes', 'profesores'));
    }

    public function update(Request $request, Observacion $observacion)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'profesor_id' => 'required|exists:profesores,id',
            'descripcion' => 'required|string|max:1000',
            'tipo' => 'required|in:positivo,negativo',
        ]);

        $observacion->update($request->only(['estudiante_id', 'profesor_id', 'descripcion', 'tipo']));

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación actualizada correctamente.');
    }

    public function destroy(Observacion $observacion)
    {
        $observacion->delete();

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación eliminada correctamente.');
    }
}




