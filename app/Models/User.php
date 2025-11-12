<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',       // Rol principal
        'is_super_admin',  // Bool
        'permissions',     // Guardado como array json
        'is_protected',    // Bool
    ];

    /**
     * Campos ocultos al serializar.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión automática de tipos de datos.
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

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true && $this->user_type === 'super_admin';
    }

    public function isAdmin(): bool
    {
        // Incluye super admin
        return in_array($this->user_type, ['admin', 'super_admin']);
    }

    public function isProfesor(): bool
    {
        return $this->user_type === 'profesor';
    }

    public function isEstudiante(): bool
    {
        return $this->user_type === 'estudiante';
    }

    /**
     * Nombre legible del rol
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
     * Verificar permisos específicos
     */
    /*public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Evita errores si permissions es null
        //return in_array($permission, $this->permissions ?? []);
    }*/

    /**
     * Usuario protegido (no se puede eliminar)
     */
    public function isProtected(): bool
    {
        return $this->is_protected === true;
    }
}
