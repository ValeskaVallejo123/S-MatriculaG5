<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'matriculas';

    protected $fillable = [
        'codigo_matricula',
        'estudiante_id',
        'seccion_id',
        'padre_id',
        'anio_lectivo',
        'fecha_matricula',
        'foto_estudiante',
        'acta_nacimiento',
        'certificado_estudios',
        'constancia_conducta',
        'foto_dni_estudiante',
        'foto_dni_padre',
        'estado',
        'motivo_rechazo',
        'observaciones',
    ];

    protected $casts = [
        'fecha_matricula' => 'datetime',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }

    public function confirmar()
    {
        if ($this->estado === 'pendiente') {
            $this->estado = 'aprobada';
            $this->save();
        }
    }

    public function getNombreCompletoAttribute()
    {
        return $this->estudiante?->nombre . ' ' . $this->estudiante?->apellido ?? 'N/A';
    }
}