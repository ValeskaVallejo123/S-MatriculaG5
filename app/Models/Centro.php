<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    use HasFactory;

    protected $table = 'centros';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'codigo',
    ];

    /**
     * Relación: Un centro tiene muchos planes de estudio
     */
    public function planEstudios()
    {
        return $this->hasMany(PlanEstudio::class);
    }
}