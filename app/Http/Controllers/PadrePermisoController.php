<?php

namespace App\Http\Controllers;

use App\Models\Padre;
use App\Models\Estudiante;
use App\Models\PadrePermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PadrePermisoController extends Controller
{
    /**
     * Mostrar lista de padres con sus permisos
     */
    public function index(Request $request)
    {
        $query = Padre::with(['estudiantes']);
        
        // Búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
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
     * Mostrar formulario de configuración de permisos para un padre
     */
    public function configurar($padreId)
    {
        $padre = Padre::with(['estudiantes'])->findOrFail($padreId);
        
        // Obtener permisos existentes para cada estudiante
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
     * Guardar configuración de permisos
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

        try {
            DB::beginTransaction();

            // Actualizar o crear permisos
            PadrePermiso::updateOrCreate(
                [
                    'padre_id' => $padreId,
                    'estudiante_id' => $request->estudiante_id
                ],
                [
                    'ver_calificaciones' => $request->has('ver_calificaciones'),
                    'ver_asistencias' => $request->has('ver_asistencias'),
                    'comunicarse_profesores' => $request->has('comunicarse_profesores'),
                    'autorizar_salidas' => $request->has('autorizar_salidas'),
                    'modificar_datos_contacto' => $request->has('modificar_datos_contacto'),
                    'ver_comportamiento' => $request->has('ver_comportamiento'),
                    'descargar_boletas' => $request->has('descargar_boletas'),
                    'ver_tareas' => $request->has('ver_tareas'),
                    'recibir_notificaciones' => $request->has('recibir_notificaciones'),
                    'notas_adicionales' => $request->notas_adicionales,
                ]
            );

            DB::commit();

            return redirect()
                ->route('admin.permisos.configurar', $padreId)
                ->with('success', 'Permisos actualizados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Error al guardar los permisos: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Establecer permisos por defecto para un padre y estudiante
     */
    public function establecerDefecto($padreId, $estudianteId)
    {
        try {
            PadrePermiso::updateOrCreate(
                [
                    'padre_id' => $padreId,
                    'estudiante_id' => $estudianteId
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

            return redirect()
                ->back()
                ->with('success', 'Permisos por defecto establecidos correctamente.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al establecer permisos: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar configuración de permisos
     */
    public function eliminar($padreId, $estudianteId)
    {
        try {
            PadrePermiso::where('padre_id', $padreId)
                       ->where('estudiante_id', $estudianteId)
                       ->delete();

            return redirect()
                ->back()
                ->with('success', 'Configuración de permisos eliminada.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar permisos: ' . $e->getMessage());
        }
    }

    /**
     * Activar/Desactivar todos los permisos
     */
    public function toggleTodos(Request $request, $padreId, $estudianteId)
    {
        $activar = $request->input('activar', true);
        
        try {
            PadrePermiso::updateOrCreate(
                [
                    'padre_id' => $padreId,
                    'estudiante_id' => $estudianteId
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

            $mensaje = $activar ? 'Todos los permisos activados.' : 'Todos los permisos desactivados.';
            
            return redirect()
                ->back()
                ->with('success', $mensaje);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al modificar permisos: ' . $e->getMessage());
        }
    }
}