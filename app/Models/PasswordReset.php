<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    public $timestamps = false; // porque solo manejamos created_at manualmente

    protected $fillable = [
        'email',
        'token',
        'created_at',
        'expires_at',
    ];

    // Generar token automáticamente si se necesita
    public static function generateToken($email)
    {
        return self::create([
            'email' => $email,
            'token' => Str::random(64),
            'created_at' => now(),
            'expires_at' => now()->addMinutes(30), // opcional: expira en 30 min
        ]);
    }
}
