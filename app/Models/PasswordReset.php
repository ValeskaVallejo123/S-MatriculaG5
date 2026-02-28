<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    // Laravel no usa updated_at en esta tabla
    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at',
        'expires_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Genera un nuevo token de recuperación y lo guarda
     */
    public static function generateToken($email)
    {
        // Eliminar registros previos del mismo email para seguridad
        self::where('email', $email)->delete();

        return self::create([
            'email' => $email,
            'token' => Str::random(64),
            'created_at' => now(),
            'expires_at' => now()->addMinutes(30), // expira en 30 minutos
        ]);
    }

    /**
     * Verifica si un token es válido y no ha expirado
     */
    public static function validateToken($email, $token)
    {
        $reset = self::where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$reset) {
            return false;
        }

        // Validar expiración
        if ($reset->expires_at < now()) {
            // Token expirado: eliminarlo
            $reset->delete();
            return false;
        }

        return true;
    }

    /**
     * Borra el token después de usarlo
     */
    public static function consumeToken($email)
    {
        self::where('email', $email)->delete();
    }
}
