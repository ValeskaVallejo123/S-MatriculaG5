<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Rol;

/**
 * @method static \App\Models\User|null find($id)
 * @method static \Illuminate\Database\Eloquent\Builder with($relations)
 *
 * Estas anotaciones le indican al IDE que auth()->user() retorna este modelo.
 * Sin esto, el IDE marca "Undefined method 'user'" aunque el código funcione.
 *
 * @property int         $id
 * @property string      $name
 * @property string      $email
 * @property int|null    $id_rol
 * @property bool        $activo
 * @property string|null $user_type
 * @property bool        $is_super_admin
 * @property bool        $is_protected
 * @property array|null  $permissions
 * @property string|null $email_verified_at
 *
 * @property-read \App\Models\Rol|null                     $rol
 * @property-read \App\Models\Padre|null                   $padre
 * @property-read \App\Models\Estudiante|null              $estudiante
 * @property-read \App\Models\Profesor|null                $docente
 * @property-read \Illuminate\Support\Collection           $notificaciones
 * @property-read \App\Models\NotificacionPreferencia|null $notificacionPreferencias
 */
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
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'permissions'       => 'array',
            'activo'            => 'boolean',
            'fecha_registro'    => 'datetime',
            'is_super_admin'    => 'boolean',
            'is_protected'      => 'boolean',
        ];
    }

    // =========================================================================
    // RELACIONES
    // =========================================================================

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id');
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

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'user_id');
    }

    public function notificacionPreferencias()
    {
        return $this->hasOne(NotificacionPreferencia::class, 'user_id');
    }

    // =========================================================================
    // ROLES
    // =========================================================================

    public function tieneRol(string $nombreRol): bool
    {
        return $this->rol &&
            strtolower(trim($this->rol->nombre)) === strtolower(trim($nombreRol));
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true || $this->id_rol == 1;
    }

    public function isAdmin(): bool
    {
        return $this->isSuperAdmin()
            || $this->id_rol == 2
            || $this->tieneRol('Administrador')
            || $this->tieneRol('Admin');
    }

    public function isDocente(): bool
    {
        return $this->id_rol == 3
            || $this->tieneRol('Profesor')
            || $this->tieneRol('Docente');
    }

    public function isEstudiante(): bool
    {
        return $this->id_rol == 4
            || $this->tieneRol('Estudiante')
            || $this->tieneRol('Alumno');
    }

    public function isPadre(): bool
    {
        return $this->id_rol == 5
            || $this->user_type === 'padre'
            || $this->tieneRol('Padre')
            || $this->tieneRol('Tutor');
    }

    // =========================================================================
    // ESTADOS
    // =========================================================================

    public function estaActivo(): bool
    {
        return $this->activo === true;
    }

    public function activar(): void
    {
        $this->update(['activo' => true]);
    }

    public function desactivar(): void
    {
        $this->update(['activo' => false]);
    }

    // =========================================================================
    // INFO PARA OBSERVACIONES
    // =========================================================================

    public function infoParaObservaciones(): array
    {
        return [
            'profesor_id'   => $this->docente?->id,
            'estudiante_id' => $this->estudiante?->id,
            'padre_id'      => $this->padre?->id,
        ];
    }

    // =========================================================================
    // INFO PARA SISTEMA
    // =========================================================================

    public function infoParaSistema(): array
    {
        return [
            'id'            => $this->id,
            'nombre'        => $this->name,
            'email'         => $this->email,
            'rol'           => $this->rol?->nombre,
            'es_superadmin' => $this->isSuperAdmin(),
            'es_admin'      => $this->isAdmin(),
            'es_docente'    => $this->isDocente(),
            'es_estudiante' => $this->isEstudiante(),
            'es_padre'      => $this->isPadre(),
            'profesor_id'   => $this->docente?->id,
            'estudiante_id' => $this->estudiante?->id,
            'padre_id'      => $this->padre?->id,
        ];
    }

    // =========================================================================
    // PERMISOS
    // =========================================================================

    public function tienePermiso(string $permiso): bool
    {
        $permiso   = strtolower(trim($permiso));
        $jsonPerms = $this->permissions ?? [];

        if (is_array($jsonPerms)) {
            $keys = array_map('strtolower', array_keys($jsonPerms));
            $idx  = array_search($permiso, $keys);
            if ($idx !== false && $jsonPerms[array_keys($jsonPerms)[$idx]] === true) {
                return true;
            }
        }

        if ($this->rol && method_exists($this->rol, 'tienePermiso')) {
            return $this->rol->tienePermiso($permiso);
        }

        return false;
    }

    public function tieneAlgunPermiso(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($permiso)) return true;
        }
        return false;
    }

    public function tieneTodosLosPermisos(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if (!$this->tienePermiso($permiso)) return false;
        }
        return true;
    }

    public function hasPermission(string $permission): bool
    {
        return $this->tienePermiso($permission);
    }

    // =========================================================================
    // SEGURIDAD
    // =========================================================================

    public function canBeDeleted(): bool
    {
        if ($this->is_protected) {
            return false;
        }

        if ($this->isSuperAdmin()) {
            $totalSuperAdmins = User::where('is_super_admin', true)
                ->where('activo', true)
                ->count();
            if ($totalSuperAdmins <= 1) {
                return false;
            }
        }

        return true;
    }

    // =========================================================================
    // QUERIES POR ROL
    // =========================================================================

    public function observacionesPermitidas()
    {
        if ($this->isSuperAdmin() || $this->isAdmin()) {
            return Observacion::query();
        }

        if ($this->isDocente() && $this->docente) {
            $profesorId = $this->docente->id;
            return Observacion::where(function ($q) use ($profesorId) {
                $q->where('profesor_id', $profesorId)
                  ->orWhereHas('estudiante.user', function ($q2) {
                      $q2->where('id', $this->id);
                  });
            });
        }

        if ($this->isEstudiante() && $this->estudiante) {
            return Observacion::where('estudiante_id', $this->estudiante->id);
        }

        return Observacion::whereRaw('0 = 1');
    }

    public function padresPermitidos()
    {
        if ($this->isSuperAdmin() || $this->isAdmin() || $this->isDocente()) {
            return Padre::query();
        }

        if ($this->isPadre() && $this->padre) {
            return Padre::where('id', $this->padre->id);
        }

        return Padre::whereRaw('0 = 1');
    }

    // =========================================================================
    // NOTIFICACIONES
    // =========================================================================

    public function notificacionesPermitidas()
    {
        return $this->notificaciones()->latest();
    }

    public function notificacionesNoLeidas()
    {
        return $this->notificaciones()->where('leida', false);
    }

    public function getTotalNotificacionesNoLeidasAttribute()
    {
        return $this->notificaciones()->where('leida', false)->count();
    }

    public function notificacionesRecientes(int $limite = 5)
    {
        return $this->notificacionesPermitidas()->take($limite)->get();
    }

    // =========================================================================
    // OBTENER TODOS LOS PERMISOS
    // =========================================================================

    public function obtenerPermisos(): array
    {
        $lista = [];

        if (is_array($this->permissions)) {
            foreach ($this->permissions as $key => $value) {
                if ($value === true) {
                    $lista[] = strtolower($key);
                }
            }
        }

        if ($this->rol && $this->rol->permisos instanceof \Illuminate\Support\Collection) {
            $lista = array_merge(
                $lista,
                $this->rol->permisos
                    ->pluck('nombre')
                    ->map(fn($n) => strtolower($n))
                    ->toArray()
            );
        }

        return array_values(array_unique(array_filter($lista)));
    }
}
