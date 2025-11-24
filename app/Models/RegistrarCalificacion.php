<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegistrarCalificacion extends Model
{
    use HasFactory;

    protected $table = 'registrarcalificaciones';

    protected $fillable = [
        'profesor_id',
        'curso_id',
        'materia_id',
        'estudiante_id',
        'periodo_academico_id',
        'nota',
        'observacion',
    ];

    protected $casts = [
        'nota' => 'float',
    ];

    // Relaciones
    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function periodoAcademico()
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_academico_id');
    }
}
