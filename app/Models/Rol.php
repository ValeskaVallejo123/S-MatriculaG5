<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación muchos a muchos con Permisos
     */
    public function permisos()
    {
        return $this->belongsToMany(
            Permiso::class,
             'permiso_rol',
             'id_rol',
             'id_permiso');
    }

    /**
     * Relación uno a muchos con Users
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol');
    }

    /**
     * Verificar si el rol tiene un permiso específico
     */
    public function tienePermiso($nombrePermiso)
    {
        return $this->permisos()->where('nombre', $nombrePermiso)->exists();
    }
}
