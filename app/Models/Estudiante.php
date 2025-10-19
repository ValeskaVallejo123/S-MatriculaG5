<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
        'nombre1', 'nombre2', 'apellido1', 'apellido2',
        'dni', 'fecha_nacimiento', 'nacionalidad',
        'sexo', 'direccion', 'telefono'
    ];
}
