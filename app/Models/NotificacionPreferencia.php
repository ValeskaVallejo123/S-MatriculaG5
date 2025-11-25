<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class NotificacionPreferencia extends Model
{
    use HasFactory;

    // 🔹 Nombre EXACTO de la tabla creada en tu migración
    protected $table = 'notificacion_preferencias';

    // 🔹 Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',

        // Canales
        'correo',
        'mensaje_interno',
        'alerta_visual',

        // Tipos de notificación generales
        'notificacion_horario',
        'notificacion_administrativa',

        // Notificaciones específicas para estudiantes
        'notificacion_nueva_materia',
        'notificacion_calificaciones',
        'notificacion_observaciones',

        // Notificaciones específicas para profesores
        'notificacion_estudiante_matricula',
        'notificacion_recordatorio_docente',
    ];

    // 🔹 Cast de booleanos
    protected $casts = [
        'correo' => 'boolean',
        'mensaje_interno' => 'boolean',
        'alerta_visual' => 'boolean',
        'notificacion_horario' => 'boolean',
        'notificacion_administrativa' => 'boolean',
        'notificacion_nueva_materia' => 'boolean',
        'notificacion_calificaciones' => 'boolean',
        'notificacion_observaciones' => 'boolean',
        'notificacion_estudiante_matricula' => 'boolean',
        'notificacion_recordatorio_docente' => 'boolean',
    ];

    // 🔹 Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
