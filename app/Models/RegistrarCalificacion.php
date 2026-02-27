<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrarCalificacion extends Model
{
    use HasFactory;

    protected $table = 'registrarcalificaciones';

    protected $fillable = [
        'profesor_id',
        'curso_id',
        'materia_id',
        'estudiante_id',
        'periodo_academico_id',
        'nota',
        'observacion',
    ];

    protected $casts = [
        'nota' => 'decimal:2',
    ];

    /**
     * ========================
     *  RELACIONES
     * ========================
     */

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function periodoAcademico()
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_academico_id');
    }

    /**
     * ========================
     *  VALIDACIONES DE DUPLICADO
     * ========================
     * Verifica si ya existe una calificación para:
     * Profesor + Curso + Materia + Estudiante + Periodo
     */
    public static function existeCalificacion($profesorId, $cursoId, $materiaId, $estudianteId, $periodoId)
    {
        return self::where('profesor_id', $profesorId)
            ->where('curso_id', $cursoId)
            ->where('materia_id', $materiaId)
            ->where('estudiante_id', $estudianteId)
            ->where('periodo_academico_id', $periodoId)
            ->exists();
    }

    /**
     * ========================
     *   SCOPES PROFESIONALES
     * ========================
     */

    public function scopeDeProfesor($query, $profesorId)
    {
        return $query->where('profesor_id', $profesorId);
    }

    public function scopeDeCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId);
    }

    public function scopeDeMateria($query, $materiaId)
    {
        return $query->where('materia_id', $materiaId);
    }

    public function scopeDeEstudiante($query, $estudianteId)
    {
        return $query->where('estudiante_id', $estudianteId);
    }

    public function scopeDePeriodo($query, $periodoId)
    {
        return $query->where('periodo_academico_id', $periodoId);
    }

    /**
     * ========================
     *   ACCESOR DE COLOR PARA LA NOTA
     * ========================
     */
    public function getColorEstadoAttribute()
    {
        if ($this->nota === null) {
            return 'bg-gray-200 text-gray-800';  // pendiente
        }

        return $this->nota >= 60
            ? 'bg-green-200 text-green-800'     // aprobado
            : 'bg-red-200 text-red-800';        // reprobado
    }

    /**
     * ========================
     *   ACCESOR - ESTADO TEXTO
     * ========================
     */
    public function getEstadoAttribute()
    {
        if ($this->nota === null) {
            return 'Pendiente';
        }

        return $this->nota >= 60 ? 'Aprobado' : 'Reprobado';
    }
}
