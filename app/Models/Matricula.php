<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
<<<<<<< HEAD
    //
}
=======
    protected $fillable = [
        'padre_id',
        'estudiante_id',
        'codigo_matricula',
        'anio_lectivo',
        'fecha_matricula',
        'foto_estudiante',
        'acta_nacimiento',
        'certificado_estudios',
        'constancia_conducta',
        'foto_dni_estudiante',
        'foto_dni_padre',
        'estado',
        'motivo_rechazo',
        'observaciones'
    ];

    protected $casts = [
        'fecha_matricula' => 'date',
    ];

    // Relaciones
    public function padre()
    {
        return $this->belongsTo(Padre::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // Generar código único de matrícula
    public static function generarCodigoMatricula()
    {
        $anio = date('Y');
        $ultimo = self::whereYear('fecha_matricula', $anio)
            ->orderBy('id', 'desc')
            ->first();
        
        $numero = $ultimo ? intval(substr($ultimo->codigo_matricula, -4)) + 1 : 1;
        
        return 'MAT-' . $anio . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // Verificar si tiene todos los documentos
    public function tieneDocumentosCompletos()
    {
        return $this->foto_estudiante 
            && $this->acta_nacimiento 
            && $this->foto_dni_estudiante 
            && $this->foto_dni_padre;
    }
}
>>>>>>> origin/main
