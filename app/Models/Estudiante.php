<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
    'nombre1',
    'nombre2',
    'apellido1',
    'apellido2',
    'apellido',
    'dni',
    'fecha_nacimiento',
    'sexo',
    'genero',
    'email',
    'telefono',
    'direccion',
    'grado',
    'seccion',
    'estado',
    'padre_id',
    'observaciones',
    'foto',
];
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    // Opciones de grados
    public static function grados()
{
    return [
        '1ro Primaria',
        '2do Primaria',
        '3ro Primaria',
        '4to Primaria',
        '5to Primaria',
        '6to Primaria',
        '1ro Secundaria',
        '2do Secundaria',
        '3ro Secundaria',
    ];
}

public static function secciones()
{
    return ['A', 'B', 'C'];
}

/**
 * Relación con permisos de padres
 */
public function permisospadres()
{
    return $this->hasMany(PadrePermiso::class);
}

/**
 * Obtener padres con permisos configurados
 */
public function padresConPermisos()
{
    return $this->belongsToMany(Padre::class, 'padre_permisos')
                ->withPivot([
                    'ver_calificaciones',
                    'ver_asistencias',
                    'comunicarse_profesores',
                    'autorizar_salidas',
                    'modificar_datos_contacto',
                    'ver_comportamiento',
                    'descargar_boletas',
                    'ver_tareas',
                    'recibir_notificaciones'
                ])
                ->withTimestamps();
}

}
