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
        'foto',
        'acta_nacimiento',
        'calificaciones',
        'tarjeta_identidad_padre',
        'constancia_medica',
    ];

    protected $casts = [
        'foto'                     => 'string',
        'acta_nacimiento'          => 'string',
        'calificaciones'           => 'string',
        'tarjeta_identidad_padre'  => 'string',
        'constancia_medica'        => 'string',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (Opcionales)
    |--------------------------------------------------------------------------
    */

    // Saber si un documento está cargado
    public function tiene($campo)
    {
        return !empty($this->{$campo});
    }

    // Devuelve la URL pública del archivo
    public function urlDe($campo)
    {
        return $this->{$campo}
            ? asset("storage/{$this->{$campo}}")
            : null;
    }
}
