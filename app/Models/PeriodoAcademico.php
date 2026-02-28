<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodoAcademico extends Model
{
    use HasFactory;

    protected $table = 'periodos_academicos';

    protected $fillable = [
        'nombre_periodo',
        'tipo',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    /**
     * Relación: Un periodo puede tener muchas calificaciones
     */
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'periodo_id');
    }

    /**
     * Accesor: Nombre formateado (Ej: "Primer Parcial - 2025")
     */
    public function getNombreCompletoAttribute()
    {
        $anio = $this->fecha_inicio ? $this->fecha_inicio->year : '';
        return "{$this->nombre_periodo} ({$anio})";
    }

    /**
     * Scope: Solo periodos actualmente activos (entre fechas)
     */
    public function scopeActivos($query)
    {
        return $query->whereDate('fecha_inicio', '<=', now())
                     ->whereDate('fecha_fin', '>=', now());
    }

    /**
     * Scope: Periodos finalizados
     */
    public function scopeFinalizados($query)
    {
        return $query->whereDate('fecha_fin', '<', now());
    }

    /**
     * Scope: Periodos futuros
     */
    public function scopeFuturos($query)
    {
        return $query->whereDate('fecha_inicio', '>', now());
    }

    /**
     * Saber si el periodo está activo
     */
    public function estaActivo()
    {
        return now()->between($this->fecha_inicio, $this->fecha_fin);
    }
}
