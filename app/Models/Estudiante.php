<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'direccion',
        'padre_id', // Relación con el padre
    ];

    // 🔁 Relación inversa: un estudiante pertenece a un padre
    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }

    // 📁 Un estudiante puede tener muchos documentos
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'estudiante_id');
    }
}

