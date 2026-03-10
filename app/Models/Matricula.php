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
    public function seccion()                          // ← ESTA FALTABA
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }

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

    /**
 * Cancela la matrícula si su estado lo permite.
 *
 * @param  string|null  $motivo  Razón opcional de la cancelación.
 * @return $this
 *
 * @throws \LogicException  Si la matrícula ya fue cancelada o rechazada.
 */
public function cancelar(?string $motivo = null): static
{
    if (in_array($this->estado, ['cancelada', 'rechazada'])) {
        throw new \LogicException(
            "No se puede cancelar una matrícula con estado '{$this->estado}'."
        );
    }

    $this->update([
        'estado'           => 'cancelada',
        'motivo_cancelacion' => $motivo,   // campo propio, separado de motivo_rechazo
    ]);

    return $this;
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