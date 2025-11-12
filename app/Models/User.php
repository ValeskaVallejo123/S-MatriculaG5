<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
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
     * Los atributos que deben ocultarse al serializar.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben castear.
     *
     * @var array<string, string>
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

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE PERMISOS
    |--------------------------------------------------------------------------
    */

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
            //return in_array($permission, $this->permissions);
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
