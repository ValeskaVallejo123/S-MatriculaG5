<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;

    protected $table = 'grados';

    protected $fillable = [
        'nivel',
        'numero',
        'seccion',
        'anio_lectivo',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // --- Relaciones ---

    /**
     * Relación muchos a muchos con Materia.
     * Se integra la versión con llaves foráneas explícitas.
     */
    public function materias()
    {
        return $this->belongsToMany(
            Materia::class,
            'profesor_materia_grados', // Tabla pivot
            'grado_id',                // Llave foránea en pivot para este modelo
            'materia_id'               // Llave foránea en pivot para el modelo relacionado
        )
        ->withPivot(['profesor_id', 'seccion', 'horas_semanales'])
        ->withTimestamps();
    }

    public function profesores()
    {
        return $this->hasMany(ProfesorGradoSeccion::class, 'grado_id');
    }

    public function profesoresMaterias()
    {
        return $this->hasMany(ProfesorMateriaGrado::class, 'grado_id');
    }

    // --- Scopes ---

    public function scopePrimaria($query)
    {
        return $query->where('nivel', 'primaria');
    }

    public function scopeSecundaria($query)
    {
        return $query->where('nivel', 'secundaria');
    }

    // --- Accessors ---

    public function getNombreCompletoAttribute(): string
    {
        $nombre = $this->numero . '° Grado';
        if ($this->seccion) {
            $nombre .= ' Sección ' . $this->seccion;
        }
        return $nombre;
    }
}