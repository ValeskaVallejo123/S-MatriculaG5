<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';
    protected $fillable = ['estudiante_id', 'materia_id', 'periodo_id', 'nota', 'observacion'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function periodo()
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_id');
    }
}

