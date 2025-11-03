<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $table = 'clases';

    protected $fillable = [
        'nombre',
        'codigo',
        'creditos',
        'temario_resumen',
        'plan_estudio_id',
    ];

    protected $casts = [
        'creditos' => 'integer',
    ];

    /**
     * Relación: Una clase pertenece a un plan de estudio
     */
    public function planEstudio()
    {
        return $this->belongsTo(PlanEstudio::class);
    }
}