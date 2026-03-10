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
        'nivel',
        'area',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Una materia pertenece a muchos grados
    public function grados()
    {
        return $this->belongsToMany(Grado::class, 'profesor_materia_grados')
                    ->withPivot('profesor_id', 'seccion')
                    ->withTimestamps();
    }

    // Una materia puede estar en muchos cursos
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_materia')
                    ->withPivot('profesor_id', 'horas_semanales')
                    ->withTimestamps();
    }

    // Horarios de la materia
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    // Calificaciones
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
            'primaria'   => 'Primaria (1° - 6°)',
            'secundaria' => 'Secundaria (7° - 9°)',
            default      => 'Desconocido',
        };
    }
}
