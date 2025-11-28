<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'profesor_id',
        'materia_id',
        'curso_id',
        'dia',
        'hora_inicio',
        'hora_fin',
        'aula',
        'observaciones',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin'    => 'datetime:H:i',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Profesor asignado a este horario
    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    // Materia asignada al horario
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    // Curso (grado + sección) asignado
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function getRangoHorarioAttribute()
    {
        return $this->hora_inicio->format('H:i') . ' - ' . $this->hora_fin->format('H:i');
    }

    public static function dias()
    {
        return [
            'lunes',
            'martes',
            'miercoles',
            'jueves',
            'viernes',
        ];
    }
}
