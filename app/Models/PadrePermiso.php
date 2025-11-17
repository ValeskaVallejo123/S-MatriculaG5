<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PadrePermiso extends Model
{
    protected $table = 'padre_permisos';

    protected $fillable = [
        'padre_id',
        'estudiante_id',
        'ver_calificaciones',
        'ver_asistencias',
        'comunicarse_profesores',
        'autorizar_salidas',
        'modificar_datos_contacto',
        'ver_comportamiento',
        'descargar_boletas',
        'ver_tareas',
        'recibir_notificaciones',
        'notas_adicionales'
    ];

    protected $casts = [
        'ver_calificaciones' => 'boolean',
        'ver_asistencias' => 'boolean',
        'comunicarse_profesores' => 'boolean',
        'autorizar_salidas' => 'boolean',
        'modificar_datos_contacto' => 'boolean',
        'ver_comportamiento' => 'boolean',
        'descargar_boletas' => 'boolean',
        'ver_tareas' => 'boolean',
        'recibir_notificaciones' => 'boolean',
    ];

    /**
     * Relación con Padre
     */
    public function padre()
    {
        return $this->belongsTo(Padre::class);
    }

    /**
     * Relación con Estudiante
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Obtener todos los permisos como array
     */
    public function getPermisosArray()
    {
        return [
            'ver_calificaciones' => $this->ver_calificaciones,
            'ver_asistencias' => $this->ver_asistencias,
            'comunicarse_profesores' => $this->comunicarse_profesores,
            'autorizar_salidas' => $this->autorizar_salidas,
            'modificar_datos_contacto' => $this->modificar_datos_contacto,
            'ver_comportamiento' => $this->ver_comportamiento,
            'descargar_boletas' => $this->descargar_boletas,
            'ver_tareas' => $this->ver_tareas,
            'recibir_notificaciones' => $this->recibir_notificaciones,
        ];
    }

    /**
     * Verificar si tiene un permiso específico
     */
    public function tienePermiso($permiso)
    {
        return $this->{$permiso} ?? false;
    }

    /**
     * Obtener permisos activos
     */
    public function getPermisosActivosAttribute()
    {
        $permisos = $this->getPermisosArray();
        return array_keys(array_filter($permisos));
    }

    /**
     * Contar permisos activos
     */
    public function getCantidadPermisosActivosAttribute()
    {
        return count($this->permisos_activos);
    }
}
