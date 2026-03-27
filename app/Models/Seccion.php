<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Http\Controllers\SeccionController;
use App\Helpers\GradoHelper;

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

    /**
     * Filtra secciones que aún tienen cupo disponible.
     * ✅ CORRECCIÓN: Se utiliza 'secciones.id' para coincidir con el nombre de la tabla.
     */
    public function scopeConEspacio($query)
    {
        return $query->whereRaw(
            'capacidad > (SELECT COUNT(*) FROM matriculas WHERE matriculas.seccion_id = secciones.id)'
        );
    }

    // ── Accessors & Mutators ─────────────────────────────────────────────────

    /**
     * Normaliza el grado al leerlo (ej: "1" -> "1er Grado").
     */
    public function getGradoAttribute($value): string
    {
        return  GradoHelper::normalizar($value);
    }

    /**
     * Normaliza el grado ANTES de guardarlo en la BD para mantener consistencia.
     */
    public function setGradoAttribute($value): void
    {
       $this->attributes['grado'] = GradoHelper::normalizar($value);
    }

    /**
     * Alias para el nombre de la sección (ej: "A", "B").
     */
    public function getLetraAttribute(): string
    {
        return $this->nombre ?? '';
    }

    /**
     * Calcula cupos disponibles dinámicamente.
     * Optimizado para usar Eager Loading si la relación ya está cargada.
     */
    public function getCupoDisponibleAttribute(): int
    {
        if ($this->relationLoaded('matriculas')) {
            return max(0, $this->capacidad - $this->matriculas->count());
        }

        return max(0, $this->capacidad - $this->matriculas()->count());
    }
}