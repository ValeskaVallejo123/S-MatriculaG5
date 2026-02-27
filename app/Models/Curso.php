<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'grado',
        'cupo_maximo',
        'jornada',
        'seccion',
    ];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function estudiantes()
    {
        // Si en tu tabla matriculas tienes curso_id → úsalo
        return $this->hasMany(Estudiante::class, 'curso_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (filtros)
    |--------------------------------------------------------------------------
    */

    public function scopeJornada($query, $jornada)
    {
        return $query->where('jornada', strtolower($jornada));
    }

    public function scopeSeccion($query, $seccion)
    {
        return $query->where('seccion', strtoupper($seccion));
    }

    public function scopeGrado($query, $grado)
    {
        return $query->where('grado', $grado);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // Determina secciones válidas según grado y jornada
    public static function seccionesDisponibles($grado, $jornada)
    {
        $jornada = strtolower($jornada);

        if ($grado >= 1 && $grado <= 6) {
            return $jornada === 'mañana'
                ? ['A', 'B', 'C']   // 3 secciones mañana
                : ['A', 'B'];      // 2 secciones tarde
        }

        if ($grado >= 9 && $grado <= 12) {
            return ['A', 'B'];    // 2 secciones por jornada
        }

        return [];
    }

    // Devuelve el nombre completo del curso
    public function getNombreCompletoAttribute()
    {
        return "{$this->grado}° {$this->seccion} - " . ucfirst($this->jornada);
    }
}
