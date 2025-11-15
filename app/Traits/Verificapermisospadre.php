<?php

namespace App\Traits;

use App\Models\PadrePermiso;

trait VerificaPermisosPadre
{
    /**
     * Verificar si un padre tiene permiso para un estudiante
     *
     * @param int $padreId
     * @param int $estudianteId
     * @param string $permiso
     * @return bool
     */
    protected function tienePermiso($padreId, $estudianteId, $permiso)
    {
        $permisoConfig = PadrePermiso::where('padre_id', $padreId)
                                    ->where('estudiante_id', $estudianteId)
                                    ->first();
        
        if (!$permisoConfig) {
            return false;
        }
        
        return $permisoConfig->{$permiso} ?? false;
    }
    
    /**
     * Obtener todos los permisos de un padre para un estudiante
     *
     * @param int $padreId
     * @param int $estudianteId
     * @return array|null
     */
    protected function obtenerPermisos($padreId, $estudianteId)
    {
        $permisoConfig = PadrePermiso::where('padre_id', $padreId)
                                    ->where('estudiante_id', $estudianteId)
                                    ->first();
        
        if (!$permisoConfig) {
            return null;
        }
        
        return $permisoConfig->getPermisosArray();
    }
    
    /**
     * Verificar si un padre puede ver calificaciones
     *
     * @param int $padreId
     * @param int $estudianteId
     * @return bool
     */
    protected function puedeVerCalificaciones($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'ver_calificaciones');
    }
    
    /**
     * Verificar si un padre puede ver asistencias
     *
     * @param int $padreId
     * @param int $estudianteId
     * @return bool
     */
    protected function puedeVerAsistencias($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'ver_asistencias');
    }
    
    /**
     * Verificar si un padre puede comunicarse con profesores
     *
     * @param int $padreId
     * @param int $estudianteId
     * @return bool
     */
    protected function puedeComunicarseConProfesores($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'comunicarse_profesores');
    }
    
    /**
     * Verificar si un padre puede autorizar salidas
     *
     * @param int $padreId
     * @param int $estudianteId
     * @return bool
     */
    protected function puedeAutorizarSalidas($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'autorizar_salidas');
    }
    
    /**
     * Verificar si un padre puede modificar datos de contacto
     *
     * @param int $padreId
     * @param int $estudianteId
     * @return bool
     */
    protected function puedeModificarDatosContacto($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'modificar_datos_contacto');
    }
    
    /**
     * Verificar si un padre puede ver comportamiento
     *
     * @param int $padreId
     * @param int $estudianteId
     * @return bool
     */
    protected function puedeVerComportamiento($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'ver_comportamiento');
    }
    
    /**
     * Verificar si un padre puede descargar boletas
     *
     * @param int $padreId
     * @param int $estudianteId
     * @return bool
     */
    protected function puedeDescargarBoletas($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'descargar_boletas');
    }
    
    /**
     * Verificar si un padre puede ver tareas
     *
     * @param int $padreId
     * @param int $estudianteId
     * @return bool
     */
    protected function puedeVerTareas($padreId, $estudianteId)
    {
        return $this->tienePermiso($padreId, $estudianteId, 'ver_tareas');
    }
    
    /**
     * Verificar múltiples permisos a la vez
     *
     * @param int $padreId
     * @param int $estudianteId
     * @param array $permisos
     * @return bool
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
     * Verificar al menos un permiso de una lista
     *
     * @param int $padreId
     * @param int $estudianteId
     * @param array $permisos
     * @return bool
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