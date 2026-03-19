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
        'grado_id',
        'estado',
        'observaciones',
        'nombre_padre',
        'telefono_padre',
        'email_padre',
        'foto',
        'dni_doc',
        'curso_id',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESORES
    |--------------------------------------------------------------------------
    */

    public function getNombreCompletoAttribute()
    {
        $nombre   = trim("{$this->nombre1} {$this->nombre2}");
        $apellido = trim("{$this->apellido1} {$this->apellido2}");
        return trim("{$nombre} {$apellido}");
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    /**
     * Estudiante pertenece a un curso
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    /**
     * Documentos del estudiante
     */
    public function documentos()
    {
        return $this->hasOne(Documento::class, 'estudiante_id');
    }

    /**
     * Calificaciones
     */
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'estudiante_id');
    }

    /**
     * Matrículas del estudiante ← AGREGADA
     */
    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'estudiante_id');
    }

    /**
     * Grado asignado (relación con tabla grados)
     */
    public function gradoAsignado()
    {
        return $this->belongsTo(Grado::class, 'grado_id');
    }

    /**
     * Usuario del sistema
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Permisos individuales de padres
     */
    public function permisosPadres()
    {
        return $this->hasMany(PadrePermiso::class, 'estudiante_id');
    }

    /**
     * Padres con permisos
     */
    public function padresConPermisos()
    {
        return $this->belongsToMany(
            Padre::class,
            'padre_permisos',
            'estudiante_id',
            'padre_id'
        )->withPivot([
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
        ])->withTimestamps();
    }

    /**
     * Padres vía matrícula
     */
    public function padres()
    {
        return $this->belongsToMany(
            Padre::class,
            'matriculas',
            'estudiante_id',
            'padre_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LISTAS ESTÁTICAS
    |--------------------------------------------------------------------------
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

    public static function secciones()
    {
        return ['A', 'B', 'C'];
    }
}
