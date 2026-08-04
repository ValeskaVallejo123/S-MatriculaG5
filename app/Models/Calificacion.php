<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'estudiante_id',
        'materia_id',
        'periodo_id',
        'profesor_id',
        'grado_id',
        'nota_tarea',
        'nota_parcial',
        'nota_final',
        'promedio',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'nota_tarea'   => 'float',
        'nota_parcial' => 'float',
        'nota_final'   => 'float',
        'promedio'     => 'float',
    ];

    protected static function booted(): void
    {
        static::saving(function (Calificacion $c) {
            $c->calcularPromedio();
        });
    }

    public function calcularPromedio(): void
    {
        if (is_null($this->nota_tarea) || is_null($this->nota_parcial) || is_null($this->nota_final)) {
            $this->promedio = null;
            $this->estado   = 'pendiente';
            return;
        }

        $porcentaje = MateriaPorcentaje::where('materia_id',  $this->materia_id)
            ->where('periodo_id',  $this->periodo_id)
            ->where('profesor_id', $this->profesor_id)
            ->first();

        $pT = $porcentaje?->porcentaje_tarea   ?? 20;
        $pP = $porcentaje?->porcentaje_parcial ?? 30;
        $pF = $porcentaje?->porcentaje_final   ?? 50;

        $this->promedio = round(
            ($this->nota_tarea * $pT / 100) +
            ($this->nota_parcial * $pP / 100) +
            ($this->nota_final * $pF / 100),
            2
        );

        $this->estado = $this->promedio >= 60 ? 'aprobado' : 'reprobado';
    }

    // Relaciones
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_id');
    }

    public function profesor(): BelongsTo
    {
        return $this->belongsTo(Profesor::class);
    }

    public function grado(): BelongsTo
    {
        return $this->belongsTo(Grado::class);
    }

    // Scopes
    public function scopeDelProfesor($q, int $id) { return $q->where('profesor_id', $id); }
    public function scopeDelEstudiante($q, int $id) { return $q->where('estudiante_id', $id); }
    public function scopeDelPeriodo($q, int $id) { return $q->where('periodo_id', $id); }
}