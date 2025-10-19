<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'permisos',
        'activo',
        'ultimo_acceso'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'permisos' => 'array',
        'activo' => 'boolean',
        'ultimo_acceso' => 'datetime',
    ];
}