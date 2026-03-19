<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $table = 'secciones';

    protected $fillable = ['nombre', 'grado', 'capacidad'];

    // ── Relaciones ───────────────────────────────────────────────────────────

    /**
     * Matrículas asignadas a esta sección.
     */
    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'seccion_id');
    }

    public function scopeConEspacio($query)
{
    return $query->whereRaw(
        'capacidad > (SELECT COUNT(*) FROM matriculas WHERE matriculas.seccion_id = seccion.id)'
    );
}

    // ── Accessors ────────────────────────────────────────────────────────────

    /**
     * La vista usa $seccion->letra — es un alias de $seccion->nombre.
     */
    public function getLetraAttribute(): string
    {
        return $this->nombre ?? '';
    }

    /**
     * Cupos disponibles = capacidad − alumnos ya asignados.
     * La vista usa $seccion->cupo_disponible (también en los <option>).
     */
    public function getCupoDisponibleAttribute(): int
    {
        // Si las matrículas ya fueron cargadas (with eager loading), usamos la colección.
        // Si no, hacemos una query puntual.
        if ($this->relationLoaded('matriculas')) {
            return max(0, $this->capacidad - $this->matriculas->count());
        }

        return max(0, $this->capacidad - $this->matriculas()->count());
    }
}