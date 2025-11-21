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

    // Relaciones
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function padre()
    {
        return $this->hasOne(Padre::class, 'user_id');
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'user_id');
    }

    public function docente()
    {
        return $this->hasOne(Profesor::class, 'user_id');
    }

    // Permisos
    public function tienePermiso($nombrePermiso)
    {
        if (!$this->rol || !$this->rol->permisos) {
            return false;
        }
        return $this->rol->permisos->contains('nombre', $nombrePermiso);
    }

    public function tieneRol($nombreRol)
    {
        if (!$this->rol) {
            return false;
        }
        return strtolower($this->rol->nombre) === strtolower($nombreRol);
    }

    public function obtenerPermisos()
    {
        if (!$this->rol || !$this->rol->permisos) {
            return collect([]);
        }
        return $this->rol->permisos;
    }

    // Métodos de roles específicos
    public function isSuperAdmin()
    {
        return $this->tieneRol('Super Administrador')
            || $this->tieneRol('superadmin')
            || $this->tieneRol('Super Admin');
    }

    public function isAdministrador()
    {
        return $this->tieneRol('Administrador')
            || $this->tieneRol('administrador')
            || $this->tieneRol('admin');
    }

    public function isDocente()
    {
        return $this->tieneRol('Docente')
            || $this->tieneRol('docente')
            || $this->tieneRol('Profesor')
            || $this->tieneRol('profesor');
    }

    public function isEstudiante()
    {
        return $this->tieneRol('Estudiante')
            || $this->tieneRol('estudiante')
            || $this->tieneRol('Alumno')
            || $this->tieneRol('alumno');
    }

    public function isPadre()
    {
        return $this->tieneRol('Padre')
            || $this->tieneRol('padre')
            || $this->tieneRol('Tutor')
            || $this->tieneRol('tutor');
    }

    // Roles múltiples
    public function hasAnyRole(array $roles)
    {
        if (!$this->rol) {
            return false;
        }

        foreach ($roles as $role) {
            if ($this->tieneRol($role)) {
                return true;
            }
        }

        return false;
    }

    public function hasRole($role)
    {
        return $this->tieneRol($role);
    }

    // Permisos múltiples
    public function tieneAlgunPermiso(array $permisos)
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($permiso)) {
                return true;
            }
        }
        return false;
    }

    public function tieneTodosLosPermisos(array $permisos)
    {
        foreach ($permisos as $permiso) {
            if (!$this->tienePermiso($permiso)) {
                return false;
            }
        }
        return true;
    }
}
