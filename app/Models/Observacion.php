<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Calificacion;
use App\Models\Padre;
use App\Models\Rol;

class Observacion extends Model
{
    use HasFactory;

    protected $table = 'observaciones'; // 👈 Tu tabla real

    protected $fillable = [
        'estudiante_id',
        'profesor_id',
        'descripcion',
        'tipo',
    ];

    // Relación con Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    // Relación correcta con Profesor
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }
}
