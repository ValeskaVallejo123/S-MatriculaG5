<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MateriaPorcentaje extends Model
{
    protected $table = 'materia_porcentajes';

    protected $fillable = [
        'materia_id',
        'periodo_id',
        'profesor_id',
        'porcentaje_tarea',
        'porcentaje_parcial',
        'porcentaje_final',
    ];

    protected $casts = [
        'porcentaje_tarea'   => 'float',
        'porcentaje_parcial' => 'float',
        'porcentaje_final'   => 'float',
    ];

    // Validar que los porcentajes sumen 100
    public static function validarPorcentajes(float $tarea, float $parcial, float $final): bool
    {
        return ($tarea + $parcial + $final) === 100.0;
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class);
    }

    public function profesor(): BelongsTo
    {
        return $this->belongsTo(Profesor::class);
    }
}