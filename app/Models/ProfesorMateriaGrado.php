<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfesorMateriaGrado extends Model
{
    protected $table = 'profesor_materia_grados';

    protected $fillable = [
        'grado_id', 'materia_id', 'profesor_id', 'seccion', 'horas_semanales',
    ];

    public function grado()    { return $this->belongsTo(Grado::class); }
    public function materia()  { return $this->belongsTo(Materia::class); }
    public function profesor() { return $this->belongsTo(Profesor::class); }
}