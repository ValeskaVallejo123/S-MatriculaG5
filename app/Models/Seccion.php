<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seccion extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'seccion';

    /**
     * Campos asignables en masa
     */
    protected $fillable = ['nombre', 'capacidad'];

    /**
     * Relación: una sección tiene muchas inscripciones
     */
    public function inscripciones(): HasMany
    {
        // Opción 1: Sin argumentos nombrados (recomendado)
        return $this->hasMany(Matricula::class, 'seccion_id');
        
        // Opción 2: Todos los argumentos nombrados
        // return $this->hasMany(related: Matricula::class, foreignKey: 'seccion_id');
    }

    /**
     * Cupos disponibles en la sección
     */
    public function capacidadRestante(): int
    {
        return $this->capacidad - $this->inscripciones()->count();
    }
}