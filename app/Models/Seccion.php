<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'seccion';

    protected $fillable = ['nombre', 'grado', 'letra', 'capacidad'];

    // ─── Relaciones ───────────────────────────────────────────────

    /**
     * Matrículas / inscripciones asignadas a esta sección
     */
    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class, 'seccion_id');
    }

    /**
     * Alias de matriculas() para compatibilidad con código existente
     */
    public function inscripciones(): HasMany
    {
        return $this->matriculas();
    }

    /**
     * Estudiantes matriculados en esta sección (a través de matriculas)
     */
    public function estudiantes()
    {
        return $this->hasManyThrough(
            Estudiante::class,
            Matricula::class,
            'seccion_id',   // FK en matriculas
            'id',           // PK en estudiantes
            'id',           // PK en secciones
            'estudiante_id' // FK en matriculas → estudiantes
        );
    }

    // ─── Accessors / Helpers ──────────────────────────────────────

    /**
     * Cuántos alumnos tiene actualmente la sección
     */
    public function totalAlumnos(): int
    {
        return $this->matriculas()->count();
    }

    /**
     * Cupos disponibles
     */
    public function capacidadRestante(): int
    {
        return max(0, $this->capacidad - $this->totalAlumnos());
    }

    /**
     * ¿Tiene espacio disponible?
     */
    public function tieneEspacio(): bool
    {
        return $this->capacidadRestante() > 0;
    }

    // ─── Scopes ───────────────────────────────────────────────────

    /**
     * Filtrar por grado: Seccion::grado('1°')->get()
     */
    public function scopeGrado($query, string $grado)
    {
        return $query->where('grado', $grado);
    }

    /**
     * Solo secciones con espacio disponible
     */
    public function scopeConEspacio($query)
    {
        return $query->whereRaw(
            'capacidad > (SELECT COUNT(*) FROM matriculas WHERE matriculas.seccion_id = secciones.id)'
        );
    }
}