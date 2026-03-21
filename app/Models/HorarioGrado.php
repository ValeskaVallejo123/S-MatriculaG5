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

    // ← SIN el cast 'horario' => 'array' porque el accessor lo reemplaza
    protected $casts = [];

    public function grado()
    {
        return $this->belongsTo(\App\Models\Grado::class);
    }

    // ── Accessor: obtiene el horario ordenado por días ──
    public function getHorarioAttribute($value)
    {
        $data = json_decode($value, true);
        if (!$data) return $data;

        $ordenDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $ordenado  = [];

        foreach ($ordenDias as $dia) {
            if (isset($data[$dia])) {
                $ordenado[$dia] = $data[$dia];
            }
        }

        // Agregar días que no estén en el orden definido (por si acaso)
        foreach ($data as $dia => $horas) {
            if (!isset($ordenado[$dia])) {
                $ordenado[$dia] = $horas;
            }
        }

        return $ordenado;
    }

    // ── Mutator: guarda el horario como JSON ──
    public function setHorarioAttribute($value)
    {
        $this->attributes['horario'] = is_array($value) ? json_encode($value) : $value;
    }

    // ── Generar estructura según jornada ──
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

        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

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
