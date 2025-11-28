<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    protected $table = 'profesores';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'dni',
        'fecha_nacimiento',
        'direccion',
        'especialidad',
        'salario',
        'tipo_contrato',
        'fecha_ingreso',
        'estado',
        'observaciones',
        'grado_guia_id',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso'    => 'date',
        'salario'          => 'decimal:2',
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
