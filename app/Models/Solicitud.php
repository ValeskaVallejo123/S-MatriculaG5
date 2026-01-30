<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'estudiante_id',
        'estado',
        'notificar',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}

