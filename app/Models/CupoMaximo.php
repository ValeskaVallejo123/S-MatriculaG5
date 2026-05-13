<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CupoMaximo extends Model
{
    protected $table = 'cupos_maximos';

    protected $fillable = [
        'nombre',
        'cupo_maximo',
        'jornada',
        'seccion',
    ];
}
