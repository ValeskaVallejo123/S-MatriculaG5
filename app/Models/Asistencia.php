<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'grado_id',
        'materia_id',
        'profesor_id',
        'fecha',
        'estado',
        'observacion',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // ── Relaciones ──────────────────────────────────────────────
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    // ── Scopes ──────────────────────────────────────────────────
    public function scopePresentes($query)
    {
        return $query->where('estado', 'presente');
    }

    public function scopeAusentes($query)
    {
        return $query->where('estado', 'ausente');
    }

    public function scopePorFecha($query, $fecha)
    {
        return $query->where('fecha', $fecha);
    }

    public function scopePorGrado($query, $gradoId)
    {
        return $query->where('grado_id', $gradoId);
    }

    public function scopePorMateria($query, $materiaId)
    {
        return $query->where('materia_id', $materiaId);
    }

    // ── Helpers ──────────────────────────────────────────────────
    public static function estadoColor(string $estado): string
    {
        return match($estado) {
            'presente'    => 'success',
            'ausente'     => 'danger',
            'tardanza'    => 'warning',
            'justificado' => 'info',
            default       => 'secondary',
        };
    }

    public static function estadoIcono(string $estado): string
    {
        return match($estado) {
            'presente'    => 'fa-check-circle',
            'ausente'     => 'fa-times-circle',
            'tardanza'    => 'fa-clock',
            'justificado' => 'fa-file-alt',
            default       => 'fa-question-circle',
        };
    }

    public static function estadoLabel(string $estado): string
    {
        return match($estado) {
            'presente'    => 'Presente',
            'ausente'     => 'Ausente',
            'tardanza'    => 'Tardanza',
            'justificado' => 'Justificado',
            default       => ucfirst($estado),
        };
    }
}