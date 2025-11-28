<?php

namespace App\Http\Controllers;

use App\Models\Padre;
use App\Models\Estudiante;
use App\Models\PadrePermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PadrePermisoController extends Controller
{
    public function __construct()
    {
        // Solo ADMIN y SUPERADMIN pueden manejar permisos
        $this->middleware(['auth', 'rol:admin,super_admin']);
    }

    /**
     * Mostrar lista de padres con sus permisos
     */
    public function index(Request $request)
    {
        $query = Padre::with('estudiantes');

        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellido', 'like', "%{$buscar}%")
                  ->orWhere('dni', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        $padres = $query->paginate(15);

        return view('admin.permisos.index', compact('padres'));
    }

    /**
     * Formulario de configuración de permisos para un padre
     */
    public function configurar($padreId)
    {
        $padre = Padre::with('estudiantes')->findOrFail($padreId);

        // Cargar permisos existentes por estudiante
        $permisosExistentes = [];
        foreach ($padre->estudiantes as $estudiante) {
            $permiso = PadrePermiso::where('padre_id', $padreId)
                                   ->where('estudiante_id', $estudiante->id)
                                   ->first();

            $permisosExistentes[$estudiante->id] = $permiso;
        }

        return view('admin.permisos.configurar', compact('padre', 'permisosExistentes'));
    }

    /**
     * Guardar o actualizar permisos
     */
    public function guardar(Request $request, $padreId)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'ver_calificaciones' => 'boolean',
            'ver_asistencias' => 'boolean',
            'comunicarse_profesores' => 'boolean',
            'autorizar_salidas' => 'boolean',
            'modificar_datos_contacto' => 'boolean',
            'ver_comportamiento' => 'boolean',
            'descargar_boletas' => 'boolean',
            'ver_tareas' => 'boolean',
            'recibir_notificaciones' => 'boolean',
            'notas_adicionales' => 'nullable|string|max:500',
        ]);

        // Verificar que el estudiante realmente pertenece a este padre
        if (!Estudiante::where('id', $request->estudiante_id)
                       ->where('padre_id', $padreId)
                       ->exists())
        {
            return back()->with('error', 'Este estudiante no pertenece a este padre.');
        }

        try {
            DB::beginTransaction();

            PadrePermiso::updateOrCreate(
                [
                    'padre_id' => $padreId,
                    'estudiante_id' => $request->estudiante_id,
                ],
                [
                    'ver_calificaciones' => $request->boolean('ver_calificaciones'),
                    'ver_asistencias' => $request->boolean('ver_asistencias'),
                    'comunicarse_profesores' => $request->boolean('comunicarse_profesores'),
                    'autorizar_salidas' => $request->boolean('autorizar_salidas'),
                    'modificar_datos_contacto' => $request->boolean('modificar_datos_contacto'),
                    'ver_comportamiento' => $request->boolean('ver_comportamiento'),
                    'descargar_boletas' => $request->boolean('descargar_boletas'),
                    'ver_tareas' => $request->boolean('ver_tareas'),
                    'recibir_notificaciones' => $request->boolean('recibir_notificaciones'),
                    'notas_adicionales' => $request->notas_adicionales,
                ]
            );

            DB::commit();

            return redirect()
                ->route('admin.permisos.configurar', $padreId)
                ->with('success', 'Permisos actualizados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar los permisos: ' . $e->getMessage());
        }
    }

    /**
     * Establecer permisos por defecto
     */
    public function establecerDefecto($padreId, $estudianteId)
    {
        if (!Estudiante::where('id', $estudianteId)->where('padre_id', $padreId)->exists()) {
            return back()->with('error', 'Este estudiante no pertenece al padre.');
        }

        PadrePermiso::updateOrCreate(
            [
                'padre_id' => $padreId,
                'estudiante_id' => $estudianteId,
            ],
            [
                'ver_calificaciones' => true,
                'ver_asistencias' => true,
                'comunicarse_profesores' => true,
                'autorizar_salidas' => false,
                'modificar_datos_contacto' => false,
                'ver_comportamiento' => true,
                'descargar_boletas' => true,
                'ver_tareas' => true,
                'recibir_notificaciones' => true,
            ]
        );

        return back()->with('success', 'Permisos por defecto establecidos correctamente.');
    }

    /**
     * Eliminar permisos del estudiante
     */
    public function eliminar($padreId, $estudianteId)
    {
        PadrePermiso::where('padre_id', $padreId)
                    ->where('estudiante_id', $estudianteId)
                    ->delete();

        return back()->with('success', 'Configuración eliminada.');
    }

    /**
     * Activar o desactivar todos los permisos
     */
    public function toggleTodos(Request $request, $padreId, $estudianteId)
    {
        $activar = $request->boolean('activar');

        PadrePermiso::updateOrCreate(
            [
                'padre_id' => $padreId,
                'estudiante_id' => $estudianteId,
            ],
            [
                'ver_calificaciones' => $activar,
                'ver_asistencias' => $activar,
                'comunicarse_profesores' => $activar,
                'autorizar_salidas' => $activar,
                'modificar_datos_contacto' => $activar,
                'ver_comportamiento' => $activar,
                'descargar_boletas' => $activar,
                'ver_tareas' => $activar,
                'recibir_notificaciones' => $activar,
            ]
        );

        return back()->with(
            'success',
            $activar ? 'Todos los permisos activados.' : 'Todos los permisos desactivados.'
        );
    }
}
