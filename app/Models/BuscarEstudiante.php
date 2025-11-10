<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuscarEstudiante extends Model
{
    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre1', 'nombre2', 'apellido1', 'apellido2',
        'dni', 'fecha_nacimiento', 'nacionalidad',
        'sexo', 'direccion', 'telefono'
    ];
}
