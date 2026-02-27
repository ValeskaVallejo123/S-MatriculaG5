<?php

namespace App\Traits;

use App\Models\PadrePermiso;

trait VerificaPermisosPadre
{
    /**
     * Cache interno por request para evitar múltiples queries
     */
    protected $cachePermisosPadre = [];

    /**
     * Obtener configuración de permisos de un padre sobre un estudiante
     */
    protected function obtenerConfig($padreId, $estudianteId)
    {
        $key = "{$padreId}_{$estudianteId}";

        if (!isset($this->cachePermisosPadre[$key])) {
            $this->cachePermisosPadre[$key] = PadrePermiso::where('padre_id', $padreId)
                ->where('estudiante_id', $estudianteId)
                ->first();
        }

        return $this->cachePermisosPadre[$key];
    }

    /**
     * Verificar un permiso específico
     */
    protected function tienePermiso($padreId, $estudianteId, $permiso)
    {
        $config = $this->obtenerConfig($padreId, $estudianteId);

        if (!$config) {
            return false;
        }

        // Validar si el permiso existe en el modelo
        return $config->{$permiso} ?? false;
    }

    /**
     * Obtener todos los permisos
     */
    protected function obtenerPermisos($padreId, $estudianteId)
    {
        $config = $this->obtenerConfig($padreId, $estudianteId);

        if (!$config) {
            return null;
        }

        return $config->getPermisosArray();
    }

    /**
     * Permisos individuales
     */
    protected function puedeVerCalificaciones($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'ver_calificaciones');
    }

    protected function puedeVerAsistencias($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'ver_asistencias');
    }

    protected function puedeComunicarseConProfesores($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'comunicarse_profesores');
    }

    protected function puedeAutorizarSalidas($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'autorizar_salidas');
    }

    protected function puedeModificarDatosContacto($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'modificar_datos_contacto');
    }

    protected function puedeVerComportamiento($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'ver_comportamiento');
    }

    protected function puedeDescargarBoletas($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'descargar_boletas');
    }

    protected function puedeVerTareas($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'ver_tareas');
    }

    /**
     * Verificar múltiples permisos
     */
    protected function tieneMultiplesPermisos($padreId, $estudianteId, array $permisos)
    {
        foreach ($permisos as $permiso) {
            if (!$this->tienePermiso($padreId, $estudianteId, $permiso)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Verificar si tiene al menos un permiso
     */
    protected function tieneAlgunoDeEstosPermisos($padreId, $estudianteId, array $permisos)
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($padreId, $estudianteId, $permiso)) {
                return true;
            }
        }
        return false;
    }
}
