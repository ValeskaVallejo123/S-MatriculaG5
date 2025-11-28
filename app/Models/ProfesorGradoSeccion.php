<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorGradoSeccion extends Model
{
    use HasFactory;

    protected $table = 'profesor_grado_seccion';

    protected $fillable = [
        'profesor_id',
        'grado_id',
        'seccion',
    ];

    protected $casts = [
        'seccion' => 'string',
    ];

    /**
     * Relación con el profesor
     */
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    /**
     * Relación con el grado
     */
    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id');
    }

    /**
     * Verificar si ya existe una asignación profesor-grado-sección
     */
    public static function yaAsignado($profesorId, $gradoId, $seccion)
    {
        return self::where('profesor_id', $profesorId)
                    ->where('grado_id', $gradoId)
                    ->where('seccion', $seccion)
                    ->exists();
    }

    /**
     * Scope: filtrar por profesor
     */
    public function scopeDeProfesor($query, $profesorId)
    {
        return $query->where('profesor_id', $profesorId);
    }

    /**
     * Scope: filtrar por grado
     */
    public function scopeDeGrado($query, $gradoId)
    {
        return $query->where('grado_id', $gradoId);
    }

    /**
     * Scope: filtrar por sección
     */
    public function scopeSeccion($query, $seccion)
    {
        return $query->where('seccion', $seccion);
    }
}
