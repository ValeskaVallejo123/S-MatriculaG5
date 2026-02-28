<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'titulo',
        'mensaje',
        'leida',
        'tipo'
    ];

    protected $casts = [
        'leida' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Métodos útiles
    |--------------------------------------------------------------------------
    */

    public function marcarComoLeida()
    {
        if (!$this->leida) {
            $this->update(['leida' => true]);
        }
    }

    public function esNueva()
    {
        return !$this->leida;
    }

    public function tipoColor()
    {
        return match ($this->tipo) {
            'aviso'       => 'bg-blue-100 text-blue-800',
            'urgente'     => 'bg-red-100 text-red-800',
            'evento'      => 'bg-green-100 text-green-800',
            'academico'   => 'bg-yellow-100 text-yellow-800',
            default       => 'bg-gray-100 text-gray-800',
        };
    }
}
