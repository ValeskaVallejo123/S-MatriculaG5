<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    protected $fillable = [
        'estudiante_id',
        'padre_id',
        'nombre',
        'tipo',
        'tamano',
        'ruta',
        'fecha_carga',
        'estado',
    ];

    // 📎 Cada documento pertenece a un estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    // 👨‍👧 Cada documento pertenece a un padre
    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }
}


