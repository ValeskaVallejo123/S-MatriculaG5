<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    protected $table = 'profesores';

   protected $fillable = [
    'nombre',
    'apellido',
    'dni',
    'fecha_nacimiento',
    'genero',
    'telefono',
    'email',
    'direccion',
    'especialidad',
    'nivel_academico',
    'fecha_contratacion',
    'tipo_contrato',
    'estado',
];


    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'salario' => 'decimal:2'
    ];

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    // Especialidades disponibles
    public static function especialidades()
    {
        return [
            'Matemáticas',
            'Lenguaje y Literatura',
            'Ciencias Naturales',
            'Ciencias Sociales',
            'Inglés',
            'Educación Física',
            'Arte',
            'Música',
            'Computación',
            'Química',
            'Física',
            'Biología',
            'Historia',
            'Geografía'
        ];
    }

    // Tipos de contrato
    public static function tiposContrato()
    {
        return [
            'tiempo_completo' => 'Tiempo Completo',
            'medio_tiempo' => 'Medio Tiempo',
            'por_horas' => 'Por Horas'
        ];
    }
}