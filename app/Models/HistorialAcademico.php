<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialAcademico extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'historial_academicos';

    // Campos que se pueden llenar (Mass Assignment)
    protected $fillable = [
        'estudiante_id',
        'curso_id',
        'anio',
        'periodo',
        'nota',
        'resultado'
    ];

    /**
     * Relación con el Estudiante.
     * Un registro de historial pertenece a un estudiante.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    /**
     * Relación con el Curso.
     * Un registro de historial pertenece a un curso (clase).
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
