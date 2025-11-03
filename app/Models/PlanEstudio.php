<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
    use HasFactory;

    protected $table = 'plan_estudios';

    protected $fillable = [
        'nombre',
        'nivel_educativo',
        'grado',
        'anio',
        'duracion',
        'jornada',
        'fecha_aprobacion',
        'descripcion',
        'centro_id',
    ];

    protected $casts = [
        'fecha_aprobacion' => 'date',
        'anio' => 'integer',
        'duracion' => 'integer',
    ];

    /**
     * Relación: Un plan de estudio tiene muchas clases
     */
    public function clases()
    {
        return $this->hasMany(Clase::class);
    }

    /**
     * Relación: Un plan de estudio pertenece a un centro
     */
    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}