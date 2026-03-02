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

        // Obtener permisos existentes de todos los hijos en UNA consulta
        $permisosExistentes = PadrePermiso::where('padre_id', $padreId)
            ->get()
            ->keyBy('estudiante_id');

        return view('admin.permisos.configurar', compact('padre', 'permisosExistentes'));
    }

    /**
     * Guardar configuración de permisos
     */
    public function guardar(Request $request, $padreId)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'notas_adicionales' => 'nullable|string|max:500',
        ]);

        // Lista de permisos disponibles
        $permisos = [
            'ver_calificaciones',
            'ver_asistencias',
            'comunicarse_profesores',
            'autorizar_salidas',
            'modificar_datos_contacto',
            'ver_comportamiento',
            'descargar_boletas',
            'ver_tareas',
            'recibir_notificaciones'
        ];

        try {
            DB::beginTransaction();

            $data = [];

            // Checkbox no enviado = false
            foreach ($permisos as $permiso) {
                $data[$permiso] = $request->has($permiso);
            }

            $data['notas_adicionales'] = $request->notas_adicionales;

            PadrePermiso::updateOrCreate(
                [
                    'padre_id' => $padreId,
                    'estudiante_id' => $request->estudiante_id
                ],
                $data
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

            return back()->with('success', 'Permisos por defecto establecidos correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al establecer permisos: ' . $e->getMessage());
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

            return back()->with('success', 'Configuración de permisos eliminada.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar permisos: ' . $e->getMessage());
        }
    }

    /**
     * Activar/Desactivar todos los permisos
     */
    public function toggleTodos(Request $request, $padreId, $estudianteId)
    {
        $activar = $request->input('activar', true);

        // Lista de permisos
        $permisos = [
            'ver_calificaciones',
            'ver_asistencias',
            'comunicarse_profesores',
            'autorizar_salidas',
            'modificar_datos_contacto',
            'ver_comportamiento',
            'descargar_boletas',
            'ver_tareas',
            'recibir_notificaciones'
        ];

        $data = [];
        foreach ($permisos as $permiso) {
            $data[$permiso] = $activar;
        }

        try {
            PadrePermiso::updateOrCreate(
                [
                    'padre_id' => $padreId,
                    'estudiante_id' => $estudianteId
                ],
                $data
            );

            return back()->with('success', $activar
                ? 'Todos los permisos activados.'
                : 'Todos los permisos desactivados.'
            );

        } catch (\Exception $e) {
            return back()->with('error', 'Error al modificar permisos: ' . $e->getMessage());
        }
    }
}
