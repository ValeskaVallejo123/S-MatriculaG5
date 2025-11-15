<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    // Unión de ambos fillable (sin duplicados)
    protected $fillable = [
        'estudiante_id',
        'materia_id',
        'periodo_id',
        'nota',
        'observacion',
        'nombre_alumno',
        'primer_parcial',
        'segundo_parcial',
        'tercer_parcial',
        'cuarto_parcial',
        'recuperacion',
        'nota_final',
    ];

    // Relaciones de la versión HEAD
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function periodo()
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_id');
    }

    /**
     * Calcular automáticamente la nota final
     */
    public function calcularNotaFinal()
    {
        $parciales = [
            $this->primer_parcial ?? 0,
            $this->segundo_parcial ?? 0,
            $this->tercer_parcial ?? 0,
            $this->cuarto_parcial ?? 0,
        ];

        // Promedio de los 4 parciales
        $promedio = array_sum($parciales) / 4;

        // Si tiene recuperación y el promedio es menor a 60, usar recuperación
        if ($this->recuperacion !== null && $promedio < 60) {
            $this->nota_final = max($promedio, $this->recuperacion);
        } else {
            $this->nota_final = $promedio;
        }

        return $this->nota_final;
    }

    /**
     * Verificar si el alumno aprobó (nota >= 60)
     */
    public function aprobo()
    {
        return $this->nota_final >= 60;
    }

    /**
     * Obtener el estado del alumno
     */
    public function getEstadoAttribute()
    {
        if ($this->nota_final === null) {
            return 'Pendiente';
        }
        return $this->nota_final >= 60 ? 'Aprobado' : 'Reprobado';
    }

    /**
     * Obtener clase CSS según el estado
     */
    public function getEstadoColorAttribute()
    {
        if ($this->nota_final === null) {
            return 'bg-gray-100 text-gray-800';
        }
        return $this->nota_final >= 60 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    }
}
