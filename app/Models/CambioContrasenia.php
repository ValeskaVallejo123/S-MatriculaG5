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
        'old_password',
        'new_password',
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
