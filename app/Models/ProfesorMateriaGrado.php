<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorMateriaGrado extends Model
{
    use HasFactory;

    protected $table = 'profesor_materia_grados';

    protected $fillable = [
        'profesor_id',
        'materia_id',
        'grado_id',
        'seccion',
    ];

    // RELACIONES (Asegúrate de que no estén duplicadas abajo)
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id');
    }

    // MÉTODOS ESTÁTICOS
    public static function yaAsignado($profesorId, $materiaId, $gradoId, $seccion)
    {
        return self::where('profesor_id', $profesorId)
            ->where('materia_id', $materiaId)
            ->where('grado_id', $gradoId)
            ->where('seccion', $seccion)
            ->exists();
    }

}
