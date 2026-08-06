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
            'rol_id',       // ✔ CORRECTO según tu tabla pivote
            'permiso_id'
        );
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol', 'id');
    }

    // =============================
    // PERMISOS DEL ROL
    // =============================

    public function tienePermiso($permiso)
    {
        if (!$permiso) {
            return false;
        }

        $permiso = strtolower(trim($permiso));

        return $this->permisos()
            ->whereRaw('LOWER(nombre) = ?', [$permiso])
            ->exists();
    }

    public function tienePermisos(array $permisos)
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($permiso)) {
                return true;
            }
        }
        return false;
    }
}
