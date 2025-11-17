<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'profesor_id', 'materia', 'seccion', 'dia', 'hora_inicio', 'hora_fin', 'salon'
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }
}
