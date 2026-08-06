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
        'profesor_id',
        'grado_id',
        'grado_nombre',
        'seccion',
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
        'primer_parcial'  => 'float',
        'segundo_parcial' => 'float',
        'tercer_parcial'  => 'float',
        'recuperacion'    => 'float',
        'nota_final'      => 'float',
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

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeDeProfesor($query, $profesorId)
    {
        return $query->where('profesor_id', $profesorId);
    }

    public function scopeDeGradoSeccion($query, $gradoId, $seccion)
    {
        return $query->where('grado_id', $gradoId)->where('seccion', $seccion);
    }

    /*
    |--------------------------------------------------------------------------
    | Cálculo de notas
    |--------------------------------------------------------------------------
    */

    public function calcularNotaFinal(): ?float
    {
        $parciales = array_filter([
            $this->primer_parcial,
            $this->segundo_parcial,
            $this->tercer_parcial,
        ], fn($p) => $p !== null);

        $promedio = count($parciales) > 0
            ? array_sum($parciales) / count($parciales)
            : null;

        if ($promedio !== null && $promedio < 60 && $this->recuperacion !== null) {
            $this->nota_final = max($promedio, $this->recuperacion);
        } else {
            $this->nota_final = $promedio;
        }

        return $this->nota_final;
    }

    public function aprobo(): bool
    {
        return $this->nota_final !== null && $this->nota_final >= 60;
    }

    /*
    |--------------------------------------------------------------------------
    | Atributos
    |--------------------------------------------------------------------------
    */

    public function getEstadoAttribute(): string
    {
        if ($this->nota_final === null) return 'Pendiente';
        return $this->nota_final >= 60 ? 'Aprobado' : 'Reprobado';
    }

    public function getEstadoColorAttribute(): string
    {
        if ($this->nota_final === null) return 'bg-gray-100 text-gray-800';
        return $this->nota_final >= 60
            ? 'bg-green-100 text-green-800'
            : 'bg-red-100 text-red-800';
    }
}
