<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';

    // Si tu tabla no maneja timestamps
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Un permiso pertenece a muchos roles
     */
    public function roles()
    {
        return $this->belongsToMany(
            Rol::class,
            'permiso_rol',   // tabla pivote
            'permiso_id',    // foreign key de este modelo
            'rol_id'         // foreign key del otro modelo
        );
    }

    /**
     * Verificar si un rol específico tiene este permiso
     */
    public function rolTienePermiso($roleId)
    {
        return $this->roles()->where('id', $roleId)->exists();
    }
}
