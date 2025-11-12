<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'seccion',
        'maestro', // Foreign key or column name for the teacher
        'jornada',
    ];

    
     
    
   
}