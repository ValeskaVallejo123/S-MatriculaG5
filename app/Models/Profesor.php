<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    protected $table = 'profesores';

    protected $fillable = [
        'user_id',           // ← agregado
        'grado_guia_id',     // ← agregado
        'seccion_guia',      // ← agregado
        'nombre',
        'apellido',
        'dni',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'email',
        'direccion',
        'especialidad',
        'nivel_academico',
        'fecha_contratacion',
        'fecha_ingreso',     // ← agregado
        'salario',           // ← agregado
        'tipo_contrato',
        'estado',
        'observaciones',     // ← agregado
    ];

    protected $casts = [
        'fecha_nacimiento'   => 'date',
        'fecha_ingreso'      => 'date',
        'fecha_contratacion' => 'date',
        'salario'            => 'decimal:2',
    ];

    /**
     * Nombre completo del profesor
     */
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido}");
    }

    /**
     * Especialidades disponibles
     */
    public static function especialidades()
    {
        return [
            'Matemáticas',
            'Lenguaje y Literatura',
            'Ciencias Naturales',
            'Ciencias Sociales',
            'Inglés',
            'Educación Física',
            'Arte',
            'Música',
            'Computación',
            'Química',
            'Física',
            'Biología',
            'Historia',
            'Geografía',
            'General',          // ← agregado
        ];
    }

    /**
     * Tipos de contrato
     */
    public static function tiposContrato()
    {
        return [
            'tiempo_completo' => 'Tiempo Completo',
            'medio_tiempo'    => 'Medio Tiempo',
            'por_horas'       => 'Por Horas',
        ];
    }

    /**
     * Relación con el usuario del sistema
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: Grado del cual es guía
     */
    public function gradoGuia()
    {
        return $this->belongsTo(Grado::class, 'grado_guia_id');
    }

    /**
     * Relación: Asignaciones a grados/secciones
     */
    public function gradosAsignados()
    {
        return $this->hasMany(ProfesorGradoSeccion::class, 'profesor_id');
    }

    /**
     * Relación: Materias que imparte por grado y sección
     */
    public function materiasGrupos()
    {
        return $this->hasMany(ProfesorMateriaGrado::class, 'profesor_id');
    }
}