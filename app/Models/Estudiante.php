<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

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
        'estado',          // 👈👉 IMPORTANTE: agregar esto
        'observaciones',
        'nombre_padre',
        'telefono_padre',
        'email_padre',
        'foto',
        'dni_doc',
        'curso_id', // recomendado
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /*
    |----------------------------------------------------------------------
    | ACCESOR: nombre completo
    |----------------------------------------------------------------------
    */
    public function getNombreCompletoAttribute()
    {
        $nombre = trim("{$this->nombre1} {$this->nombre2}");
        $apellido = trim("{$this->apellido1} {$this->apellido2}");
        return trim("{$nombre} {$apellido}");
    }

    /*
    |----------------------------------------------------------------------
    | RELACIONES
    |----------------------------------------------------------------------
    */

    public function permisosPadres()
    {
        return $this->hasMany(PadrePermiso::class, 'estudiante_id');
    }

    public function padresConPermisos()
    {
        return $this->belongsToMany(Padre::class, 'padre_permisos', 'estudiante_id', 'padre_id')
                    ->withPivot([
                        'ver_calificaciones',
                        'ver_asistencias',
                        'ver_comportamiento',
                        'ver_tareas',
                        'descargar_boletas',
                        'recibir_notificaciones',
                        'comunicarse_profesores',
                        'autorizar_salidas',
                        'subir_documentos_matricula',
                        'notas_adicionales'
                    ]);
    }

    public function documentos()
    {
        return $this->hasOne(Documento::class, 'estudiante_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'estudiante_id');
    }

    /*
    |----------------------------------------------------------------------
    | LISTAS ESTÁTICAS
    |----------------------------------------------------------------------
    */

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
    public function user()
    {
    return $this->belongsTo(\App\Models\User::class);
    }

    public static function secciones()
    {
        return ['A', 'B', 'C'];
    }
}
