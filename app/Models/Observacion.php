<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;


    protected $table = 'observaciones';

    protected $fillable = [
        'estudiante_id',
        'profesor_id',
        'descripcion',
        'tipo',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }
}


