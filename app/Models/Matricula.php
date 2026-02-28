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
        'fecha_confirmacion',
    ];

    protected $casts = [
        'fecha_matricula' => 'datetime',
        'fecha_confirmacion' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE ESTADO
    |--------------------------------------------------------------------------
    */

    public function confirmar()
    {
        if ($this->estado !== 'pendiente') {
            return false;
        }

        $this->update([
            'estado' => 'aprobada',
            'fecha_confirmacion' => now(),
            'motivo_rechazo' => null,
        ]);

        return true;
    }

    public function rechazar(string $motivo)
    {
        if ($this->estado === 'aprobada') {
            return false; // No puedes rechazar algo ya aprobado
        }

        $this->update([
            'estado' => 'rechazada',
            'motivo_rechazo' => $motivo,
        ]);

        return true;
    }

    public function cancelar(string $motivo = null)
    {
        $this->update([
            'estado' => 'cancelada',
            'motivo_rechazo' => $motivo,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getEstadoColorAttribute()
    {
        return match ($this->estado) {
            'pendiente' => 'bg-yellow-200 text-yellow-800',
            'aprobada'  => 'bg-green-200 text-green-800',
            'rechazada' => 'bg-red-200 text-red-800',
            'cancelada' => 'bg-gray-300 text-gray-900',
            default     => 'bg-gray-200'
        };
    }

    public function getNombreCompletoAttribute()
    {
        return $this->estudiante
            ? $this->estudiante->nombre_completo
            : 'N/A';
    }
}