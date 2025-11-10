<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
    ];

    /**
     * Una materia tiene muchas calificaciones.
     */
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'materia_id');
    }
}

