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
        'ver_comportamiento',
        'ver_tareas',
        'descargar_boletas',
        'recibir_notificaciones',
        'comunicarse_profesores',
        'autorizar_salidas',
        'subir_documentos_matricula',
        'notas_adicionales',
    ];

    protected $casts = [
        'ver_calificaciones' => 'boolean',
        'ver_asistencias' => 'boolean',
        'ver_comportamiento' => 'boolean',
        'ver_tareas' => 'boolean',
        'descargar_boletas' => 'boolean',
        'recibir_notificaciones' => 'boolean',
        'comunicarse_profesores' => 'boolean',
        'autorizar_salidas' => 'boolean',
        'subir_documentos_matricula' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE PERMISOS
    |--------------------------------------------------------------------------
    */

    // Devuelve array de permisos con su valor
    public function getPermisosArray()
    {
        return [
            'ver_calificaciones' => $this->ver_calificaciones,
            'ver_asistencias' => $this->ver_asistencias,
            'ver_comportamiento' => $this->ver_comportamiento,
            'ver_tareas' => $this->ver_tareas,
            'descargar_boletas' => $this->descargar_boletas,
            'recibir_notificaciones' => $this->recibir_notificaciones,
            'comunicarse_profesores' => $this->comunicarse_profesores,
            'autorizar_salidas' => $this->autorizar_salidas,
            'subir_documentos_matricula' => $this->subir_documentos_matricula,
        ];
    }

    // Verifica un permiso específico
    public function tienePermiso($permiso)
    {
        return isset($this->{$permiso}) && $this->{$permiso} === true;
    }

    // Lista de permisos activos
    public function getPermisosActivosAttribute()
    {
        return array_keys(array_filter($this->getPermisosArray()));
    }

    // Número de permisos activos
    public function getCantidadPermisosActivosAttribute()
    {
        return count($this->permisos_activos);
    }
}
