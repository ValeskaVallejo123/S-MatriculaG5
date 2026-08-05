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

    // Orden canónico de horas (MySQL JSON reordena claves alfabéticamente)
    private static array $ordenHoras = [
        '07:00-07:40', '07:40-08:20', '08:20-09:00',
        'RECREO 09:00-09:20',
        '09:20-10:00', '10:00-10:40', '10:40-11:20', '11:20-12:00', '12:00-12:40',
        '13:00-13:40', '13:40-14:20', '14:20-15:00',
        'RECREO 15:00-15:20',
        '15:20-16:00', '16:00-16:40', '16:40-17:20',
    ];

    // ── Accessor: obtiene el horario ordenado por días y horas ──
    public function getHorarioAttribute($value)
    {
        $data = json_decode($value, true);
        if (!$data) return $data;

        $ordenDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $ordenado  = [];

        foreach ($ordenDias as $dia) {
            if (!isset($data[$dia])) continue;

            $horasData    = $data[$dia];
            $horasOrdenadas = [];

            // Insertar horas en el orden canónico
            foreach (self::$ordenHoras as $h) {
                if (array_key_exists($h, $horasData)) {
                    $horasOrdenadas[$h] = $horasData[$h];
                }
            }
            // Cualquier hora no contemplada va al final
            foreach ($horasData as $h => $v) {
                if (!isset($horasOrdenadas[$h])) {
                    $horasOrdenadas[$h] = $v;
                }
            }

            $ordenado[$dia] = $horasOrdenadas;
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
                '07:00-07:40',
                '07:40-08:20',
                '08:20-09:00',
                'RECREO 09:00-09:20',
                '09:20-10:00',
                '10:00-10:40',
                '10:40-11:20',
                '11:20-12:00',
                '12:00-12:40',
            ];
        } else {
            $horas = [
                '13:00-13:40',
                '13:40-14:20',
                '14:20-15:00',
                'RECREO 15:00-15:20',
                '15:20-16:00',
                '16:00-16:40',
                '16:40-17:20',
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
