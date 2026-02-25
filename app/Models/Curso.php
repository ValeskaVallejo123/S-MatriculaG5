<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'cursos';

    // Columnas que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'cupo_maximo',
        'jornada',
        'seccion',
    ];

    /**
     * Relación: un curso tiene muchos estudiantes
     */
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'curso_id');
    }

}
