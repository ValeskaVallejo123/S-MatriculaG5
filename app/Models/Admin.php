<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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
        'password' => 'hashed', // Encripta automáticamente
    ];

    public $timestamps = false; // Opcional según tu BD

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    // Garantiza que la contraseña siempre se guarde hasheada
    public function setPasswordAttribute($value)
    {
        if ($value !== null && !password_get_info($value)['algo']) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // Verificar si Admin tiene un permiso específico
    public function tienePermiso($permiso)
    {
        $permisos = $this->permisos ?? [];
        return in_array($permiso, $permisos);
    }

    // Activar/Desactivar
    public function activar()
    {
        $this->update(['activo' => true]);
    }

    public function desactivar()
    {
        $this->update(['activo' => false]);
    }
}
