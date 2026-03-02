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

    // =============================
    // RELACIONES
    // =============================

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

    // =============================
    // ROLES
    // =============================

    public function tieneRol($nombreRol)
    {
        return $this->rol &&
            strtolower(trim($this->rol->nombre)) === strtolower(trim($nombreRol));
    }

    public function isSuperAdmin()
    {
        return $this->is_super_admin === true || $this->id_rol ==1;
    }

    public function isAdmin(): bool
    {
        // CORRECCIÓN: el ObservacionController llamaba $user->isAdmin() pero
        // el modelo original no lo tenía correctamente enlazado con isSuperAdmin.
        // Un superadmin también es admin a efectos de permisos.
        return $this->isSuperAdmin()
            || $this->id_rol == 2
            || $this->tieneRol('Administrador')
            || $this->tieneRol('Admin');
    }

    public function isDocente()
    {
        return $this->id_rol == 3 ||
               $this->tieneRol('Profesor') ||
               $this->tieneRol('Docente');
    }

    public function isEstudiante()
    {
        return $this->id_rol == 4 ||
               $this->tieneRol('Estudiante') ||
               $this->tieneRol('Alumno');
    }

    public function isPadre()
    {
        return $this->id_rol == 5 ||
               $this->tieneRol('Padre') ||
               $this->tieneRol('Tutor');
    }

    // =============================
    // ESTADOS
    // =============================

    public function estaActivo()
    {
        return $this->activo === true;
    }

    public function activar()
    {
        $this->update(['activo' => true]);
    }

    public function desactivar()
    {
        $this->update(['activo' => false]);
    }

    public function infoParaObservaciones(): array
    {
        return [
            'profesor_id'   => $this->docente?->id,
            'estudiante_id' => $this->estudiante?->id,
            'padre_id'      => $this->padre?->id,
        ];
    }

    // =============================
    // INFO SISTEMA
    // =============================

    public function infoParaSistema(): array
    {
        return [
            'id'            => $this->id,
            'nombre'        => $this->name,
            'email'         => $this->email,
            'rol'           => $this->rol->nombre ?? null,
            'es_superadmin' => $this->isSuperAdmin(),
            'es_docente'    => $this->isDocente(),
            'es_estudiante' => $this->isEstudiante(),
            'es_padre'      => $this->isPadre(),
            'profesor_id'   => $this->docente->id ?? null,
            'estudiante_id' => $this->estudiante->id ?? null,
            'padre_id'      => $this->padre->id ?? null,
        ];
    }

    // =============================
    // PERMISOS (JSON + por Rol)
    // =============================

    public function tienePermiso(string $permiso): bool
    {
        $permiso = strtolower(trim($permiso));

        // Verificar en permisos JSON del usuario (array asociativo key => bool)
        $jsonPerms = $this->permissions ?? [];
        if (is_array($jsonPerms)) {
            $keys = array_map('strtolower', array_keys($jsonPerms));
            if (in_array($permiso, $keys) && $jsonPerms[array_search($permiso, $keys)] === true) {
                return true;
            }
        }

        // Verificar en permisos del rol
        if ($this->rol && method_exists($this->rol, 'tienePermiso')) {
            return $this->rol->tienePermiso($permiso);
        }

        return false;
    }

    public function tieneAlgunPermiso(array $permisos): bool
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

    /** Alias para compatibilidad con código que usa hasPermission() */
    public function hasPermission(string $permission): bool
    {
        return $this->tienePermiso($permission);
    }

    // =============================
    // SEGURIDAD
    // =============================

    public function canBeDeleted(): bool
    {
        // No se puede eliminar si es superadmin protegido
        if ($this->is_protected) {
            return false;
        }

        // No se puede eliminar si es el único superadmin activo
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



    // =============================
    // OBSERVACIONES
    // =============================

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

        // Sin acceso: query que no devuelve nada
        return Observacion::whereRaw('0 = 1');
    }

    // =============================
    // NOTIFICACIONES (CAMPANA 🔔)
    // =============================

    /**
     * Devuelve las notificaciones del usuario ordenadas por fecha desc.
     * Uso: $user->notificacionesPermitidas()->take(5)->get()
     */
    public function notificacionesPermitidas()
    {
        return $this->notificaciones()->latest();
    }

    /**
     * Relación de notificaciones no leídas (devuelve query builder).
     * Uso: $user->notificacionesNoLeidas()->get()
     */
    public function notificacionesNoLeidas()
    {
        return $this->notificaciones()->where('leida', false);
    }

    /**
     * Accessor: total de notificaciones no leídas como entero.
     * Uso en blade: $user->total_notificaciones_no_leidas
     */
    public function getTotalNotificacionesNoLeidasAttribute()
    {
        return $this->notificaciones()->where('leida', false)->count();
    }

    /**
     * Retorna las últimas N notificaciones del usuario.
     * Uso en blade: $user->notificacionesRecientes(5)
     */
    public function notificacionesRecientes(int $limite = 5)
    {
        return $this->notificacionesPermitidas()->take($limite)->get();
    }

    // =============================
    // PADRES
    // =============================

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

    // =============================
    // OBTENER TODOS LOS PERMISOS
    // =============================

    public function obtenerPermisos(): array
    {
        $lista = [];

        // Permisos JSON del usuario (solo los que tienen valor true)
        if (is_array($this->permissions)) {
            foreach ($this->permissions as $key => $value) {
                if ($value === true) {
                    $lista[] = strtolower($key);
                }
            }
        }

        // Permisos del rol
        if ($this->rol && $this->rol->permisos instanceof \Illuminate\Support\Collection) {
            $lista = array_merge($lista, $this->rol->permisos->pluck('nombre')->map(fn($n) => strtolower($n))->toArray());
        }

        return array_values(array_unique(array_filter($lista)));
    }

}
