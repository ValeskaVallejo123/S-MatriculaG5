<?php
// app/Models/Ciclo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'seccion',
        'jornada',
    ];

    // Relaciones (ajusta según tu sistema)
    // public function estudiantes()
    // {
    //     return $this->hasMany(Estudiante::class);
    // }
}