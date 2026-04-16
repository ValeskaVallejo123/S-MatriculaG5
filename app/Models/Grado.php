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

    /**
     * Busca el grado activo que coincide con el nombre de grado y sección del estudiante.
     * Ej: buscarPorNombreYSeccion('Primer Grado', 'A') → Grado con nivel=primaria, numero=1, seccion=A
     */
    public static function buscarPorNombreYSeccion(string $nombre, string $seccion): ?self
    {
        $mapa = [
            'Primer Grado'  => ['primaria',    1],
            'Segundo Grado' => ['primaria',    2],
            'Tercer Grado'  => ['primaria',    3],
            'Cuarto Grado'  => ['primaria',    4],
            'Quinto Grado'  => ['primaria',    5],
            'Sexto Grado'   => ['primaria',    6],
            'Séptimo Grado' => ['secundaria',  7],
            'Octavo Grado'  => ['secundaria',  8],
            'Noveno Grado'  => ['secundaria',  9],
        ];

        if (!isset($mapa[$nombre])) {
            return null;
        }

        [$nivel, $numero] = $mapa[$nombre];

        return static::where('activo', true)
            ->where('nivel', $nivel)
            ->where('numero', $numero)
            ->where('seccion', $seccion)
            ->first();
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
