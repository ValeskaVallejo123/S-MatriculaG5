<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_rol', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con Rol
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    /**
     * Verificar si el usuario tiene un permiso específico
     * 
     * @param string $nombrePermiso
     * @return bool
     */
    public function tienePermiso($nombrePermiso)
    {
        // Si no tiene rol asignado, no tiene permisos
        if (!$this->rol) {
            return false;
        }

        // Verificar si el rol tiene el permiso
        return $this->rol->tienePermiso($nombrePermiso);
    }

    /**
     * Verificar si el usuario tiene alguno de los permisos especificados
     * 
     * @param array $permisos
     * @return bool
     */
    public function tieneAlgunPermiso(array $permisos)
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($permiso)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verificar si el usuario tiene todos los permisos especificados
     * 
     * @param array $permisos
     * @return bool
     */
    public function tieneTodosLosPermisos(array $permisos)
    {
        foreach ($permisos as $permiso) {
            if (!$this->tienePermiso($permiso)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Verificar si el usuario tiene un rol específico
     * 
     * @param string $nombreRol
     * @return bool
     */
    public function tieneRol($nombreRol)
    {
        return $this->rol && $this->rol->nombre === $nombreRol;
    }

    /**
     * Obtener todos los permisos del usuario
     * 
     * @return \Illuminate\Support\Collection
     */
    public function obtenerPermisos()
    {
        if (!$this->rol) {
            return collect([]);
        }

        return $this->rol->permisos;
    }

    /**
     * Verificar si el usuario es Super Administrador
     * 
     * @return bool
     */
    public function esSuperAdmin()
    {
        return $this->tieneRol('Super Administrador');
    }

    /**
     * Verificar si el usuario es Administrador
     * 
     * @return bool
     */
    public function esAdmin()
    {
        return $this->tieneRol('Administrador');
    }

    /**
     * Verificar si el usuario es Profesor
     * 
     * @return bool
     */
    public function esProfesor()
    {
        return $this->tieneRol('Profesor');
    }

    /**
     * Verificar si el usuario es Estudiante
     * 
     * @return bool
     */
    public function esEstudiante()
    {
        return $this->tieneRol('Estudiante');
    }

    /**
     * Verificar si el usuario es Padre/Tutor
     * 
     * @return bool
     */
    public function esPadre()
    {
        return $this->tieneRol('Padre');
    }
}