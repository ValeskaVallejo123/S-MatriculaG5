<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ObservacionController extends Controller
{
    /**
     * Listar observaciones según rol del usuario autenticado
     */
    public function index(Request $request)
    {
        $user  = auth()->user();
        $info  = $user->infoParaObservaciones();

        $query = Observacion::with(['estudiante', 'profesor'])->latest();

        if ($user->isSuperAdmin()) {
            // Superadmin: ve todas las observaciones

        } elseif ($user->isDocente()) {
            // Profesor: solo las que creó o corresponden a sus estudiantes
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
            abort(403, 'No autorizado.');
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
            ->with('filtros', $request->only(['tipo', 'fecha_desde', 'fecha_hasta']));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $profesores  = Profesor::orderBy('nombre')->get();

        return view('observaciones.createObservacion', compact('estudiantes', 'profesores'));
    }

    /**
     * Guardar nueva observación
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'profesor_id'   => 'nullable|exists:profesores,id',
            'descripcion'   => 'required|string|min:5|max:1000',
            'tipo'          => 'required|string|max:50',
        ]);

        // Si no se envía profesor_id, asignar el profesor del usuario autenticado
        if (empty($validated['profesor_id']) && auth()->user()->isDocente()) {
            $info = auth()->user()->infoParaObservaciones();
            $validated['profesor_id'] = $info['profesor_id'] ?? null;
        }

        Observacion::create($validated);

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación registrada correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Observacion $observacion)
    {
        $user = auth()->user();

        if (!$user->isSuperAdmin() && $user->id !== $observacion->profesor_id) {
            abort(403, 'No autorizado.');
        }

        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $profesores  = Profesor::orderBy('nombre')->get();

        return view('observaciones.editObservacion', compact('observacion', 'estudiantes', 'profesores'));
    }

    /**
     * Actualizar observación existente
     */
    public function update(Request $request, Observacion $observacion): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->isSuperAdmin() && $user->id !== $observacion->profesor_id) {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'profesor_id'   => 'nullable|exists:profesores,id',
            'descripcion'   => 'required|string|min:5|max:1000',
            'tipo'          => 'required|string|max:50',
        ]);

        $observacion->update($validated);

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación actualizada correctamente.');
    }

    /**
     * Eliminar observación
     */
    public function destroy(Observacion $observacion): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->isSuperAdmin() && $user->docente?->id !== $observacion->profesor_id) {
            abort(403, 'No autorizado.');
        }

        $observacion->delete();

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación eliminada correctamente.');
    }
}
