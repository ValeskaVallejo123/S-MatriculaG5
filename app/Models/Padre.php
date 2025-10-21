<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    use HasFactory;

    protected $table = 'padres';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'direccion',
    ];

    // 👨‍👧 Un padre puede tener muchos estudiantes
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'padre_id');
    }

    // 📁 Un padre puede tener muchos documentos
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'padre_id');
    }
}





