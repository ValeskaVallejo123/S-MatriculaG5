<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambioContrasenia extends Model
{
    use HasFactory;

    protected $table = 'cambio_contrasenias';

    protected $fillable = [
        'user_id',
        'ip_address',
        'descripcion',   // opcional: “El usuario cambió su contraseña”
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
