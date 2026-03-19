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

    /**
     * Un curso tiene muchos estudiantes
     */
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'curso_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Filtros)
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

    /**
     * Determina secciones válidas según grado y jornada
     */
    public static function seccionesDisponibles($grado, $jornada)
    {
        $jornada = strtolower($jornada);

        if ($grado >= 1 && $grado <= 6) {
            return $jornada === 'mañana'
                ? ['A', 'B', 'C']
                : ['A', 'B'];
        }

        if ($grado >= 9 && $grado <= 12) {
            return ['A', 'B'];
        }

        return [];
    }

    /**
     * Nombre completo del curso
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->grado}° {$this->seccion} - " . ucfirst($this->jornada);
    }
}
