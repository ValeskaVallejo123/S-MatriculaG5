<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegistrarCalificacion extends Model
{
    use HasFactory;

    protected $table = 'registro_calificaciones';

    protected $fillable = [
        'profesor_id',
        'grado_id',
        'materia_id',
        'estudiante_id',
        'periodo_academico_id',
        'nota',
        'primer_parcial',
        'segundo_parcial',
        'tercer_parcial',
        'recuperacion',
        'observacion',
    ];

    protected $casts = [
        'nota'           => 'float',
        'primer_parcial' => 'float',
        'segundo_parcial'=> 'float',
        'tercer_parcial' => 'float',
        'recuperacion'   => 'float',
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
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