<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

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

        'recuperacion',
        'nota_final',
    ];

    protected $casts = [
        'primer_parcial'    => 'float',
        'segundo_parcial'   => 'float',
        'tercer_parcial'    => 'float',
        'recuperacion'      => 'float',
        'nota_final'        => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function periodo()
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Cálculo de notas
    |--------------------------------------------------------------------------
    */

    /**
     * Calcula automáticamente la nota final.
     */
    public function calcularNotaFinal()
    {
        // Filtrar solo parciales suministrados
        $parciales = array_filter([
            $this->primer_parcial,
            $this->segundo_parcial,
            $this->tercer_parcial,
        ], fn ($p) => $p !== null);

        // Si hay parciales válidos, promediar
        $promedio = count($parciales) > 0
            ? array_sum($parciales) / count($parciales)
            : null;

        // Aplicar recuperación si aplica
        if ($promedio !== null && $promedio < 60 && $this->recuperacion !== null) {
            $this->nota_final = max($promedio, $this->recuperacion);
        } else {
            $this->nota_final = $promedio;
        }

        return $this->nota_final;
    }

    /**
     * True si el alumno aprobó
     */
    public function aprobo(): bool
    {
        return $this->nota_final !== null && $this->nota_final >= 60;
    }

    /*
    |--------------------------------------------------------------------------
    | Atributos personalizados
    |--------------------------------------------------------------------------
    */

    public function getEstadoAttribute()
    {
        if ($this->nota_final === null) {
            return 'Pendiente';
        }
        return $this->nota_final >= 60 ? 'Aprobado' : 'Reprobado';
    }

    public function getEstadoColorAttribute()
    {
        if ($this->nota_final === null) {
            return 'bg-gray-100 text-gray-800';
        }
        return $this->nota_final >= 60
            ? 'bg-green-100 text-green-800'
            : 'bg-red-100 text-red-800';
    }

    /*
    |--------------------------------------------------------------------------
    | Mutadores opcionales (si quieres recalcular automáticamente)
    |--------------------------------------------------------------------------
    */

    public function setPrimerParcialAttribute($value)
    {
        $this->attributes['primer_parcial'] = $value;
        $this->calcularNotaFinal();
    }

    public function setSegundoParcialAttribute($value)
    {
        $this->attributes['segundo_parcial'] = $value;
        $this->calcularNotaFinal();
    }

    public function setTercerParcialAttribute($value)
    {
        $this->attributes['tercer_parcial'] = $value;
        $this->calcularNotaFinal();
    }

    public function setRecuperacionAttribute($value)
    {
        $this->attributes['recuperacion'] = $value;
        $this->calcularNotaFinal();
    }
}
