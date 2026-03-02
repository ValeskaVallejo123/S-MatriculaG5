<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    protected $fillable = [
<<<<<<< HEAD
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

    /* ============================
       RELACIÓN
       ============================ */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    /* ============================
       HELPERS
       ============================ */

    public function tiene($campo)
    {
        return !empty($this->{$campo});
    }

    public function urlDe($campo)
    {
        return $this->{$campo}
            ? asset("storage/{$this->{$campo}}")
            : null;
=======
        'estudiante_id', // ¡Importante para la relación!
        'foto',
        'acta_nacimiento',
        'calificaciones'
    ];

    // Relación con el estudiante (según la historia de usuario)
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
>>>>>>> josue_matriculag5
    }
}
