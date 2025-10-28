<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'matriculas';

    protected $fillable = [
        'codigo',
        'estudiante_id',
        'padre_id',
        'anio_lectivo',
        'fecha_matricula',
        'estado', // pendiente, aprobada, rechazada
    ];

    protected $casts = [
        'fecha_matricula' => 'datetime',
    ];

    // Relación con estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    // Relación con padre/tutor
    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }

    // Método para confirmar matrícula
    public function confirmar()
    {
        if ($this->estado === 'pendiente') {
            $this->estado = 'aprobada';
            $this->save();
        }
    }

    // Nombre completo del estudiante
    public function getNombreCompletoAttribute()
    {
        if ($this->estudiante) {
            return $this->estudiante->nombre . ' ' . $this->estudiante->apellido;
        }
        return 'N/A';
    }
}
