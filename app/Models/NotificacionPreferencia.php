<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class NotificacionPreferencia extends Model
{
    use HasFactory;

    protected $table = 'notificacion_preferencias';

    protected $fillable = [
        'user_id',

        // 1️⃣ Canales permitidos
        'correo',
        'mensaje_interno',
        'alerta_visual',

        // 2️⃣ Categorías generales de notificaciones
        'notificacion_horario',
        'notificacion_administrativa',

        // 3️⃣ Preferencias para estudiantes
        'notificacion_nueva_materia',
        'notificacion_calificaciones',
        'notificacion_observaciones',

        // 4️⃣ Preferencias para padres
        'notificacion_conducta',
        'notificacion_tareas',
        'notificacion_eventos',
        'notificacion_matricula',

        // 5️⃣ Preferencias para profesores
        'notificacion_estudiante_matricula',
        'notificacion_recordatorio_docente',
    ];

    protected $casts = [
        'correo' => 'boolean',
        'mensaje_interno' => 'boolean',
        'alerta_visual' => 'boolean',
        'notificacion_horario' => 'boolean',
        'notificacion_administrativa' => 'boolean',
        'notificacion_nueva_materia' => 'boolean',
        'notificacion_calificaciones' => 'boolean',
        'notificacion_observaciones' => 'boolean',
        'notificacion_conducta' => 'boolean',
        'notificacion_tareas' => 'boolean',
        'notificacion_eventos' => 'boolean',
        'notificacion_matricula' => 'boolean',
        'notificacion_estudiante_matricula' => 'boolean',
        'notificacion_recordatorio_docente' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN PRINCIPAL
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE CONSULTA (Ayudan al sistema)
    |--------------------------------------------------------------------------
    */

    /**
     * Verifica si el usuario permite un tipo de notificación.
     */
    public function permite(string $tipo): bool
    {
        return $this->{$tipo} ?? false;
    }

    /**
     * Verifica si el usuario recibe notificaciones por un canal.
     */
    public function canal(string $canal): bool
    {
        return $this->{$canal} ?? false;
    }

    /**
     * Devuelve una lista de todas las preferencias activas.
     */
    public function getNotificacionesActivasAttribute(): array
    {
        $activas = [];

        foreach ($this->casts as $campo => $tipo) {
            if ($tipo === 'boolean' && ($this->{$campo} ?? false)) {
                $activas[] = $campo;
            }
        }

        return $activas;
    }
}
