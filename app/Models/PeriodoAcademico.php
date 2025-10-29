<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodoAcademico extends Model
{
    protected $table = 'periodos_academicos';

    protected $fillable = ['nombre_periodo', 'tipo', 'fecha_inicio', 'fecha_fin'];
}
