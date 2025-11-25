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
    
    protected $fillable = ['nombre', 'descripcion'];

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'permiso_rol', 'id_rol', 'id_permiso');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol', 'id'); 
    }

    public function tienePermiso($nombrePermiso)
    {
        if (!$this->permisos) {
            return false;
        }

        return $this->permisos->contains('nombre', $nombrePermiso);
    }
}