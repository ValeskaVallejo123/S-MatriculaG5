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
     * Listar observaciones según rol
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $info = $user->infoParaObservaciones();

        $query = Observacion::with(['estudiante', 'profesor'])->latest();

        if ($user->isSuperAdmin()) {
            // Superadmin: ve todas
        } elseif ($user->isDocente()) {
            // Profesor: solo las que creó o le corresponden
            $query->where('profesor_id', $info['profesor_id'])
                  ->orWhereHas('estudiante', function ($q) use ($info) {
                      $q->whereHas('profesor', function ($q2) use ($info) {
                          $q2->where('id', $info['profesor_id']);
                      });
                  });
        } elseif ($user->isEstudiante()) {
            // Estudiante: solo las propias
            $query->where('estudiante_id', $info['estudiante_id']);
        } else {
            abort(403, 'No autorizado');
        }

        // Filtros opcionales
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $observaciones = $query->paginate(10)->withQueryString();

        return view('observaciones.indexObservacion', compact('observaciones'))
            ->with('filtros', $request->only(['tipo','fecha_desde','fecha_hasta']));
    }

    /**
     * Crear observación
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

        $observacion->update($request->only(['estudiante_id','profesor_id','descripcion','tipo']));

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
        $user = auth()->user();
        if (!$user->isSuperAdmin() && $user->id !== $observacion->profesor_id) {
            abort(403, 'No autorizado');
        }

        $observacion->delete();

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación eliminada correctamente.');
    }
}

