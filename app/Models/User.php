<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'user_type',
        'is_super_admin',
        'permissions',
        'is_protected',
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
            'is_super_admin' => 'boolean',
            'is_protected' => 'boolean',
            'permissions' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE ROLES
    |--------------------------------------------------------------------------
    */

    /**
     * Verificar si el usuario es Super Administrador
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true && $this->user_type === 'super_admin';
    }

    /**
     * Verificar si el usuario es Administrador (incluye Super Admin)
     */
    public function isAdmin(): bool
    {
        return in_array($this->user_type, ['admin', 'super_admin']);
    }

    /**
     * Verificar si el usuario es Profesor
     */
    public function isProfesor(): bool
    {
        return $this->user_type === 'profesor';
    }

    /**
     * Verificar si el usuario es Estudiante
     */
    public function isEstudiante(): bool
    {
        return $this->user_type === 'estudiante';
    }

    /**
     * Obtener el nombre del rol en español
     */
    public function getRoleName(): string
    {
        return match($this->user_type) {
            'super_admin' => 'Super Administrador',
            'admin' => 'Administrador',
            'profesor' => 'Profesor',
            'estudiante' => 'Estudiante',
            default => 'Usuario',
        };
    }

    /**
     * Verificar si el usuario tiene un permiso específico
     */
    public function hasPermission(string $permission): bool
    {
        // Super admin tiene todos los permisos
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Verificar en el array de permisos
        if (is_array($this->permissions)) {
            return in_array($permission, $this->permissions);
        }

        return false;
    }

    /**
     * Verificar si el usuario está protegido (no se puede eliminar)
     */
    public function isProtected(): bool
    {
        return $this->is_protected === true;
    }
}