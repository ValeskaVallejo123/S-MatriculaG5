<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'nivel',
        'area',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relación con grados
    public function grados()
    {
        return $this->belongsToMany(Grado::class, 'grado_materia')
                    ->withPivot('profesor_id', 'horas_semanales')
                    ->withTimestamps();
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

    // Accesor para mostrar el nivel
    public function getNivelNombreAttribute()
    {
        return $this->nivel === 'primaria' 
            ? 'Primaria (1° - 6°)' 
            : 'Secundaria (7° - 9°)';
    }
}