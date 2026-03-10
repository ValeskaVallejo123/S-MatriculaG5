<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;

    protected $table = 'ciclos';

    protected $fillable = [
        'grado',
        'seccion',
        'jornada',
    ];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | SCOPES ÚTILES
    |--------------------------------------------------------------------------
    */

    // Filtrar por jornada
    public function scopeJornada($query, $jornada)
    {
        return $query->where('jornada', strtolower($jornada));
    }

    // Filtrar por grado
    public function scopeGrado($query, $grado)
    {
        return $query->where('grado', $grado);
    }

    // Secciones disponibles automáticamente según grado y jornada
    public static function seccionesDisponibles($grado, $jornada)
    {
        $jornada = strtolower($jornada);

        if ($grado >= 1 && $grado <= 6) {
            return $jornada === 'mañana'
                ? ['A', 'B', 'C']      // 3 secciones mañana
                : ['A', 'B'];         // 2 secciones tarde
        }

        if ($grado >= 9 && $grado <= 12) {
            return ['A', 'B'];        // 2 secciones por jornada
        }

        return [];
    }
}
