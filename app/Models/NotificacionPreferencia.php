<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class NotificacionPreferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'correo',
        'mensaje_interno',
        'alerta_visual',
        'notificacion_academica',
        'notificacion_administrativa',
        'recordatorios',
    ];

    protected $casts = [
        'correo' => 'boolean',
        'mensaje_interno' => 'boolean',
        'alerta_visual' => 'boolean',
        'notificacion_academica' => 'boolean',
        'notificacion_administrativa' => 'boolean',
        'recordatorios' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
