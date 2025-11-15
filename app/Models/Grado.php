<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    // En app/Models/Grado.php o Ciclo.php
protected $fillable = [
    'nombre',
    'seccion',
    'maestro',
    'jornada',
];
}