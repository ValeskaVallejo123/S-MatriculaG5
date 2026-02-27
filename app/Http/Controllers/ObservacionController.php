<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ObservacionController extends Controller
{
    // ────────────────────────────────────────────────────────────────────────
    // INDEX
    // ────────────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $user  = auth()->user();
        $info  = $user->infoParaObservaciones();

        $query = Observacion::with(['estudiante', 'profesor'])->latest();

        if ($user->isSuperAdmin()) {
            // Superadmin ve todas — sin restricción adicional

        } elseif ($user->isDocente()) {
            // CORRECCIÓN: el original combinaba ->where() y ->orWhereHas()
            // directamente sobre el query principal, lo que generaba una
            // condición SQL incorrecta cuando había más filtros activos:
            //   WHERE profesor_id = X OR (...) AND tipo = 'Y'
            // El AND tiene mayor precedencia que OR, así que el filtro de
            // tipo solo aplicaba al segundo bloque. Se agrupa con closure.
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
            $query->where('estudiante_id', $info['estudiante_id'] ?? null);

        } elseif ($user->isAdmin()) {
            // CORRECCIÓN: el original no tenía caso para Admin — caía en abort(403).
            // Los admins deben poder ver todas las observaciones.
            // (Sin restricción adicional)

        } else {
            abort(403, 'No tienes permiso para ver observaciones.');
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
        $filtros       = $request->only(['tipo', 'fecha_desde', 'fecha_hasta']);

        return view('observaciones.indexObservacion', compact('observaciones', 'filtros'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // CREATE
    // ────────────────────────────────────────────────────────────────────────

    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $profesores  = Profesor::orderBy('nombre')->get();

        return view('observaciones.createObservacion', compact('estudiantes', 'profesores'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // STORE
    // ────────────────────────────────────────────────────────────────────────

    /**
     * CORRECCIÓN CRÍTICA: el original eliminó TODAS las validaciones required
     * ("Quitamos todas las restricciones de 'required'") y además nunca
     * llamaba a Observacion::create(), por lo que el formulario no guardaba
     * NADA en la base de datos y solo redirigía con un mensaje de éxito falso.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'descripcion'   => 'required|string|min:5|max:1000',
            'tipo'          => 'required|string|in:academica,conductual,salud,otro',
            // profesor_id: opcional si el usuario autenticado es el profesor
            'profesor_id'   => 'nullable|exists:profesores,id',
        ]);

        $user = auth()->user();

        // CORRECCIÓN: el original forzaba profesor_id = null siempre.
        // Si el usuario es docente, se asigna automáticamente su profesor_id.
        // Si es admin/superadmin, puede asignar cualquier profesor del form.
        if ($user->isDocente()) {
            $info = $user->infoParaObservaciones();
            $validated['profesor_id'] = $info['profesor_id'] ?? null;
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
        // CORRECCIÓN: el original no tenía método show(), lo que causaba
        // error 500 si la ruta resource intentaba usarlo.
        $observacion->load(['estudiante', 'profesor']);

        return view('observaciones.showObservacion', compact('observacion'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // EDIT
    // ────────────────────────────────────────────────────────────────────────

    public function edit(Observacion $observacion)
    {
        // CORRECCIÓN: el original no verificaba si el usuario tiene permiso
        // para editar esta observación específica. Un profesor podía editar
        // observaciones de otros profesores.
        $this->autorizarModificacion($observacion);

        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $profesores  = Profesor::orderBy('nombre')->get();

        return view('observaciones.editObservacion', compact('observacion', 'estudiantes', 'profesores'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ────────────────────────────────────────────────────────────────────────

    public function update(Request $request, Observacion $observacion)
    {
        // CORRECCIÓN: el original permitía actualizar con todos los campos
        // en null (todo nullable sin required), lo que podía dejar una
        // observación completamente vacía.
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
        // CORRECCIÓN: el original comparaba $user->id con $observacion->profesor_id,
        // pero $user->id es el ID del usuario en la tabla users, mientras que
        // profesor_id es el ID en la tabla profesores — son tablas distintas.
        // Se usa el helper autorizarModificacion() que lo resuelve correctamente.
        $this->autorizarModificacion($observacion);

        $observacion->delete();

        return redirect()->route('observaciones.index')
            ->with('success', 'Observación eliminada correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // HELPER PRIVADO
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Verifica que el usuario autenticado pueda modificar/eliminar
     * la observación. Lanza 403 si no tiene permiso.
     *
     * Reglas:
     * - SuperAdmin y Admin: pueden modificar cualquier observación.
     * - Docente: solo las observaciones que él creó (su profesor_id).
     * - Otros roles: no pueden modificar.
     */
    private function autorizarModificacion(Observacion $observacion): void
    {
        $user = auth()->user();

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return; // Permitido
        }

        if ($user->isDocente()) {
            $info = $user->infoParaObservaciones();
            $profesorId = $info['profesor_id'] ?? null;

            if ($observacion->profesor_id && $observacion->profesor_id == $profesorId) {
                return; // Permitido
            }
        }

        abort(403, 'No tienes permiso para modificar esta observación.');
    }
}
