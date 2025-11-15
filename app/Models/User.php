<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos asignables en masa
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        // Campos de HEAD
        'user_type',
        'is_super_admin',
        'permissions',
        'is_protected',

        // Campo de origin/main
        'rol',
    ];

    /**
     * Atributos ocultos para serialización
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts para atributos
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_super_admin' => 'boolean',
        'is_protected' => 'boolean',
        'permissions' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE ROLES (origin/main)
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->rol === 'admin' || in_array($this->user_type, ['admin', 'super_admin']);
    }

    public function isEstudiante(): bool
    {
        return $this->rol === 'estudiante' || $this->user_type === 'estudiante';
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE ROLES (HEAD)
    |--------------------------------------------------------------------------
    */

    /**
     * Verificar si es Super Administrador
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true && $this->user_type === 'super_admin';
    }

    /**
     * Verificar si es Administrador (incluye Super Admin)
     */
    public function isAdministrador(): bool
    {
        return in_array($this->user_type, ['admin', 'super_admin']);
    }

    /**
     * Verificar si es Profesor
     */
    public function isProfesor(): bool
    {
        return $this->user_type === 'profesor';
    }

    /**
     * Obtener el nombre del rol en español
     */
    public function getRoleName(): string
    {
        return match ($this->user_type) {
            'super_admin' => 'Super Administrador',
            'admin' => 'Administrador',
            'profesor' => 'Profesor',
            'estudiante' => 'Estudiante',
            default => 'Usuario',
        };
    }

    /**
     * Verificar si el usuario tiene un permiso
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return is_array($this->permissions)
            ? in_array($permission, $this->permissions)
            : false;
    }

    /**
     * Verificar si el usuario está protegido
     */
    public function isProtected(): bool
    {
        return $this->is_protected === true;
    }
}
