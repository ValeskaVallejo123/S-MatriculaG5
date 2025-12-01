<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioGrado extends Model
{
    protected $table = 'horarios_grado';

    protected $fillable = [
        'grado_id',
        'jornada',
        'horario',
    ];

    protected $casts = [
        'horario' => 'array',
    ];

    public function grado()
    {
        return $this->belongsTo(\App\Models\Grado::class);
    }

    
    // Generar estructura según jornada
    public static function estructuraPorJornada(string $jornada)
    {
        if ($jornada === 'matutina') {
            $horas = [
                '07:00-08:00',
                '08:00-09:00',
                '09:00-10:00',
                '10:00-11:00',
                '11:00-12:00',
            ];
        } else {
            $horas = [
                '13:00-14:00',
                '14:00-15:00',
                '15:00-16:00',
                '16:00-17:00',
            ];
        }

        $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes'];

        $estructura = [];
        foreach ($dias as $dia) {
            $estructura[$dia] = [];
            foreach ($horas as $h) {
                $estructura[$dia][$h] = null;
            }
        }

        return $estructura;
    }
}
