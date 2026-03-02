<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorMateriaGrado extends Model
{
    use HasFactory;

    protected $table = 'profesor_materia_grados';

    protected $fillable = [
        'profesor_id',
        'materia_id',
        'grado_id',
        'seccion',
    ];

    protected $casts = [
        'seccion' => 'string',
    ];

    /**
     * RELACIONES
     */
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id');
    }

    /**
     * Verifica si ya existe una asignación
     * Profesor - Materia - Grado - Sección
     */
    public static function yaAsignado($profesorId, $materiaId, $gradoId, $seccion)
    {
        return self::where('profesor_id', $profesorId)
                    ->where('materia_id', $materiaId)
                    ->where('grado_id', $gradoId)
                    ->where('seccion', $seccion)
                    ->exists();
    }

    /**
     * SCOPES
     */
    public function scopeDeProfesor($query, $profesorId)
    {
        return $query->where('profesor_id', $profesorId);
    }

    public function scopeDeGrado($query, $gradoId)
    {
        return $query->where('grado_id', $gradoId);
    }

    public function scopeDeMateria($query, $materiaId)
    {
        return $query->where('materia_id', $materiaId);
    }

    public function scopeSeccion($query, $seccion)
    {
        return $query->where('seccion', $seccion);
    }
}
