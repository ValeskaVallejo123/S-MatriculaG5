<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id', // ¡Importante para la relación!
        'foto',
        'acta_nacimiento',
        'calificaciones'
    ];

    // Relación con el estudiante (según la historia de usuario)
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}







