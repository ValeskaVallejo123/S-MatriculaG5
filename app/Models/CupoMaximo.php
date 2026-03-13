<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CupoMaximo extends Model
{
    use HasFactory;

    protected $table = 'cupos_maximos';

    protected $fillable = [
        'nombre',
        'cupo_maximo',
        'jornada',
        'seccion',
    ];
}
