<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'id_rol'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function tienePermiso($nombrePermiso)
    {
        if (!$this->rol) return false;
        return $this->rol->tienePermiso($nombrePermiso);
    }

    public function tieneRol($nombreRol)
    {
        if (!$this->rol) return false;
        return $this->rol->nombre === $nombreRol;
    }

    public function obtenerPermisos()
    {
        if (!$this->rol) return collect([]);
        return $this->rol->permisos;
    }
}
