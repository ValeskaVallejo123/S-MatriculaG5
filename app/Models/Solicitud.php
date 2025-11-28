<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'estudiante_id',
        'estado',      // pendiente, aprobada, rechazada
        'notificar',   // boolean: si se debe notificar al superadmin
    ];

    protected $casts = [
        'notificar' => 'boolean',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
