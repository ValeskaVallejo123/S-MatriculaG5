<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObservacionController extends Controller
{
    // ────────────────────────────────────────────────────────────────────────
    // INDEX
    // ────────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $user  = Auth::user();
        $info  = $user->infoParaObservaciones();

        $query = Observacion::with(['estudiante', 'profesor'])->latest();

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            // Ve todas — sin restricción

        } elseif ($user->isDocente()) {
            $profesorId = $info['profesor_id'] ?? null;
            $query->where(function ($q) use ($profesorId) {
                $q->where('profesor_id', $profesorId)
                    ->orWhereHas('estudiante', function ($q2) use ($profesorId) {
                        $q2->whereHas('profesor', function ($q3) use ($profesorId) {
                            $q3->where('id', $profesorId);
                        });
                    });
            });

        } elseif ($user->isEstudiante()) {
            $estudianteId = $info['estudiante_id'] ?? null;
            $query->where('estudiante_id', $estudianteId);

        } else {
            abort(403, 'No tienes permiso para ver observaciones.');
        }

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
        $filtros       = $request->only(['tipo', 'fecha_desde', 'fecha_hasta']);

        return view('observaciones.indexObservacion', compact('observaciones', 'filtros'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // CREATE
    // ────────────────────────────────────────────────────────────────────────
   public function create()
{
    $estudiantes = Estudiante::orderBy('apellido1')->orderBy('nombre1')->get();
    $profesores  = Profesor::orderBy('nombre')->get();

    $estudiantesJS = $estudiantes->map(function ($e) {
        return [
            'id'      => $e->id,
            'nombre'  => $e->nombreCompleto ?? ($e->nombre1 . ' ' . $e->apellido1),
            'grado'   => $e->grado   ?? '',
            'seccion' => $e->seccion ?? '',
            'dni'     => $e->dni     ?? '',
            'foto'    => $e->foto    ? '/storage/' . $e->foto : null,
        ];
    });

    return view('observaciones.createObservacion', compact('estudiantes', 'profesores', 'estudiantesJS'));
}

    // ────────────────────────────────────────────────────────────────────────
    // STORE
    // ────────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'descripcion'   => 'required|string|min:5|max:1000',
            'tipo'          => 'required|string|in:academica,conductual,salud,otro',
            'profesor_id'   => 'nullable|exists:profesores,id',
        ]);

        // Docente: se asigna automáticamente su profesor_id
        if ($user->isDocente()) {
            $info = $user->infoParaObservaciones();
            $validated['profesor_id'] = $info['profesor_id'] ?? null;
        } else {
            $validated['profesor_id'] = $request->input('profesor_id') ?: null;
        }

        Observacion::create($validated);

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación guardada correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // SHOW
    // ────────────────────────────────────────────────────────────────────────
    public function show(Observacion $observacion)
    {
        $this->autorizarModificacion($observacion);
        return view('observaciones.showObservacion', compact('observacion'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // EDIT
    // ────────────────────────────────────────────────────────────────────────
   public function edit(Observacion $observacion)
{
    $this->autorizarModificacion($observacion);

    $estudiantes = Estudiante::orderBy('apellido1')->orderBy('nombre1')->get();
    $profesores  = Profesor::orderBy('nombre')->get();

    $estudiantesJS = $estudiantes->map(function ($e) {
        return [
            'id'      => $e->id,
            'nombre'  => $e->nombreCompleto ?? ($e->nombre1 . ' ' . $e->apellido1),
            'grado'   => $e->grado   ?? '',
            'seccion' => $e->seccion ?? '',
            'dni'     => $e->dni     ?? '',
            'foto'    => $e->foto    ? '/storage/' . $e->foto : null,
        ];
    });

    return view('observaciones.editObservacion', compact('observacion', 'estudiantes', 'profesores', 'estudiantesJS'));
}
    // ────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ────────────────────────────────────────────────────────────────────────
    public function update(Request $request, Observacion $observacion)
    {
        $this->autorizarModificacion($observacion);

        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'profesor_id'   => 'nullable|exists:profesores,id',
            'descripcion'   => 'required|string|min:5|max:1000',
            'tipo'          => 'required|string|in:academica,conductual,salud,otro',
        ]);

        $observacion->update($validated);

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación actualizada correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // DESTROY
    // ────────────────────────────────────────────────────────────────────────
    public function destroy(Observacion $observacion)
    {
        $this->autorizarModificacion($observacion);
        $observacion->delete();

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación eliminada correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // HELPER PRIVADO
    // ────────────────────────────────────────────────────────────────────────
    private function autorizarModificacion(Observacion $observacion): void
    {
        $user = Auth::user();

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return;
        }

        if ($user->isDocente()) {
            $info       = $user->infoParaObservaciones();
            $profesorId = $info['profesor_id'] ?? null;

            if ($profesorId && $observacion->profesor_id == $profesorId) {
                return;
            }
        }

        abort(403, 'No tienes permiso para modificar esta observación.');
    }
}