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

    // Relación con materias
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'grado_materia')
                    ->withPivot('profesor_id', 'horas_semanales')
                    ->withTimestamps();
    }

    // Accesor para nombre completo del grado
    public function getNombreCompletoAttribute()
    {
        $nombre = $this->numero . '° Grado';
        if ($this->seccion) {
            $nombre .= ' Sección ' . $this->seccion;
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
}
