<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'nivel',   // primaria | secundaria
        'area',    // matemáticas, español, ciencias...
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES CORRECTAS
    |--------------------------------------------------------------------------
    */

    // Una materia puede estar en muchos cursos
    // Ej: Matemáticas → 1 A, 1 B, 2 A, etc.
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_materia')
                    ->withPivot('profesor_id', 'horas_semanales')
                    ->withTimestamps();
    }

    // Professor asignado a esta materia en un curso específico
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    // Calificaciones (materia -> muchas notas)
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'materia_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePrimaria($query)
    {
        return $query->where('nivel', 'primaria');
    }

    public function scopeSecundaria($query)
    {
        return $query->where('nivel', 'secundaria');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getNivelNombreAttribute()
    {
        return match ($this->nivel) {
            'primaria' => 'Primaria (1° - 6°)',
            'secundaria' => 'Secundaria (7° - 9°)',
            default => 'Desconocido',
        };
    }
}
