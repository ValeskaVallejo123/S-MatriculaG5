<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // ⚠ Asegura que no falle si roles no tiene created_at/updated_at
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion'];

    // =============================
    // RELACIONES
    // =============================

    public function permisos()
    {
        return $this->belongsToMany(
            Permiso::class,
            'permiso_rol',
            'id_rol',
            'permiso_id'
        );
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol', 'id');
    }

    // =============================
    // PERMISOS
    // =============================

    public function tienePermiso($nombrePermiso)
    {
        if (!$nombrePermiso) {
            return false;
        }

        // Normalizar nombre
        $nombrePermiso = strtolower(trim($nombrePermiso));

        // ✔ Si ya está cargado (eager loaded) → usar colección
        if ($this->relationLoaded('permisos')) {
            return $this->permisos
                ->contains(fn($permiso) => strtolower($permiso->nombre) === $nombrePermiso);
        }

        // ✔ Si NO está cargado → consulta directa (mejor rendimiento)
        return $this->permisos()
            ->whereRaw('LOWER(nombre) = ?', [$nombrePermiso])
            ->exists();
    }

    public function tienePermisos(array $permisos)
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($permiso)) {
                return true; // basta con uno
            }
        }
        return false;
    }
}
