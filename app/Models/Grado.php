<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;

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

    // Relación con materias a través de profesor_materia_grados
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'profesor_materia_grados')
                    ->withPivot('profesor_id', 'seccion')
                    ->withTimestamps();
    }

    // ── Mapa canónico número → nombre ──
    public static function nombrePorNumero(int $numero): string
    {
        return [
            1 => 'Primer Grado',
            2 => 'Segundo Grado',
            3 => 'Tercer Grado',
            4 => 'Cuarto Grado',
            5 => 'Quinto Grado',
            6 => 'Sexto Grado',
            7 => 'Séptimo Grado',
            8 => 'Octavo Grado',
            9 => 'Noveno Grado',
        ][$numero] ?? $numero . '° Grado';
    }

    // Accesor: "Primer Grado", "Segundo Grado"…
    public function getNombreAttribute(): string
    {
        return static::nombrePorNumero($this->numero);
    }

    // Accesor para nombre completo del grado
    public function getNombreCompletoAttribute(): string
    {
        $nombre = $this->nombre;
        if ($this->seccion) {
            $nombre .= ' — Sección ' . $this->seccion;
        }
        return $nombre;
    }

    // Scope para filtrar por nivel
    public function scopePrimaria($query)
    {
        return $query->where('nivel', 'primaria');
    }

    public function scopeSecundaria($query)
    {
        return $query->where('nivel', 'secundaria');
    }

    public function profesores()
    {
        return $this->hasMany(ProfesorGradoSeccion::class, 'grado_id');
    }

    public function profesoresMaterias()
    {
        return $this->hasMany(ProfesorMateriaGrado::class, 'grado_id');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'grado_id');
    }
}
