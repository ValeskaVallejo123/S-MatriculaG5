<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'dni',
        'fecha_nacimiento',
        'direccion',
        'grado',
        'seccion',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    // Opciones de grados
    public static function grados()
    {
        return [
            '1ro Primaria',
            '2do Primaria',
            '3ro Primaria',
            '4to Primaria',
            '5to Primaria',
            '6to Primaria',
            '1ro Secundaria',
            '2do Secundaria',
            '3ro Secundaria',

        ];
    }

    // Opciones de secciones
    public static function secciones()
    {
        return ['A', 'B', 'C', 'D', 'E'];
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'estudiante_id');
    }

}
