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
        'fecha_registro',
        'permissions',
        'is_super_admin',
        'is_protected',
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
        return $this->hasOne(\App\Models\Estudiante::class);
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
        return $this->id_rol == 1 || $this->is_super_admin === true;
    }

    public function isAdmin()
    {
        return $this->id_rol == 2 || $this->tieneRol('Administrador');
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

    // =============================
    // PERMISOS (JSON + por Rol)
    // =============================

    public function tienePermiso($permiso)
    {
        $permiso = strtolower(trim($permiso));

        $jsonPerms = $this->permissions ?? [];
        if (is_array($jsonPerms) && in_array($permiso, array_map('strtolower', $jsonPerms))) {
            return true;
        }

        if ($this->rol && $this->rol->tienePermiso($permiso)) {
            return true;
        }

        return false;
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

    // =============================
    // SEGURIDAD
    // =============================

    public function canBeDeleted()
    {
        if ($this->isSuperAdmin() || $this->is_protected) {
            return false;
        }
        return true;
    }

    // =============================
    // INFO SISTEMA
    // =============================

    public function infoParaSistema()
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
    // OBSERVACIONES
    // =============================

    public function observacionesPermitidas()
    {
        if ($this->isSuperAdmin()) {
            return Observacion::query();
        }

        if ($this->isDocente() && $this->docente) {
            return Observacion::where('profesor_id', $this->docente->id)
                ->orWhereHas('estudiante.user', function ($q) {
                    $q->where('id', $this->id);
                });
        }

        if ($this->isEstudiante() && $this->estudiante) {
            return Observacion::where('estudiante_id', $this->estudiante->id);
        }

        return Observacion::whereRaw('0=1');
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
        if ($this->isSuperAdmin() || $this->isDocente()) {
            return Padre::query();
        }

        if ($this->isPadre() && $this->padre) {
            return Padre::where('id', $this->padre->id);
        }

        return Padre::whereRaw('0=1');
    }

    // =============================
    // OBTENER TODOS LOS PERMISOS
    // =============================

    public function obtenerPermisos()
    {
        $lista = [];

        if (is_array($this->permissions)) {
            $lista = array_merge($lista, $this->permissions);
        }

        if ($this->relationLoaded('rol') || $this->rol) {
            if ($this->rol->permisos instanceof \Illuminate\Support\Collection) {
                $lista = array_merge($lista, $this->rol->permisos->pluck('nombre')->toArray());
            }
        }

        $lista = array_filter($lista);
        $lista = array_unique($lista);
        sort($lista);

        return $lista;
    }

    // =============================
    // HELPERS DE PERMISOS
    // =============================

    public function hasPermission($permission)
    {
        return $this->tienePermiso($permission);
    }
}
