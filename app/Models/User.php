<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   protected $fillable = [
    'name',
    'email',
    'password',
    'id_rol',
    'activo', 
    'user_type',
    'is_super_admin',
    'is_protected',
    'permissions',
    'email_verified_at',
];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
            'activo' => 'boolean',
            'fecha_registro' => 'datetime',
            'is_super_admin' => 'boolean',
            'is_protected' => 'boolean'
        ];
    }

    // ===================================
    // RELACIONES
    // ===================================

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id'); //  Usa 'id_rol' de users y 'id' de roles
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

    // ===================================
    // MÉTODOS DE PERMISOS
    // ===================================

    public function tienePermiso($nombrePermiso)
    {
        if (!$this->rol || !$this->rol->permisos) {
            return false;
        }

        return $this->rol->permisos->contains('nombre', $nombrePermiso);
    }

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

    public function obtenerPermisos()
    {
        if (!$this->rol || !$this->rol->permisos) {
            return collect([]);
        }

        return $this->rol->permisos;
    }

    // ===================================
    // MÉTODOS DE ROLES
    // ===================================

    public function tieneRol($nombreRol)
    {
        if (!$this->rol) {
            return false;
        }

        return strtolower($this->rol->nombre) === strtolower($nombreRol);
    }

    public function hasRole($role)
    {
        return $this->tieneRol($role);
    }

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

    // ===================================
    // MÉTODOS HELPER DE ROLES
    // ===================================

    public function isSuperAdmin()
    {
        return $this->tieneRol('Super Administrador')
            || $this->tieneRol('superadmin')
            || $this->tieneRol('Super Admin')
            || $this->is_super_admin == 1;
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

    // ===================================
    // MÉTODOS DE ESTADO
    // ===================================

    public function estaActivo()
    {
        return $this->activo === true;
    }

    public function estaPendiente()
    {
        return $this->activo === false;
    }

    public function activar()
    {
        $this->activo = true;
        $this->save();
    }

    public function desactivar()
    {
        $this->activo = false;
        $this->save();
    }

    // ===================================
    // SCOPES (Consultas frecuentes)
    // ===================================

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePendientes($query)
    {
        return $query->where('activo', false);
    }

    public function scopePorRol($query, $rolId)
    {
        return $query->where('id_rol', $rolId);
    }
    // Dentro de la clase User en app/Models/User.php

public function role()
{
    return $this->belongsTo(Role::class, 'id_rol');
}
}