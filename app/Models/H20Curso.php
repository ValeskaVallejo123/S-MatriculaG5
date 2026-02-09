<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class H20Curso extends Model
{
    protected $table = 'h20_cursos';

    protected $fillable = [
        'nombre',
        'cupo_maximo',
        'seccion',
        'nivel',
        'anio_lectivo',
        'activo'
    ];

}
