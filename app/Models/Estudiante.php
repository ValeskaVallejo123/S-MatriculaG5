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
        'dni',
        'fecha_nacimiento',
        'sexo',
        'email',
        'telefono',
        'direccion',
        'grado',
        'seccion',
        'estado',
        'observaciones',
        'nombre_padre',
        'telefono_padre',
        'email_padre',
        'foto',
        'dni_doc',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // Accessor para nombre completo corregido
    public function getNombreCompletoAttribute()
    {
        $nombre = trim("{$this->nombre1} {$this->nombre2}");
        $apellido = trim("{$this->apellido1} {$this->apellido2}");
        return trim("{$nombre} {$apellido}");
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
