<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoAcademico extends Model
{
    use HasFactory;

    protected $table = 'eventos_academicos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'tipo',
        'color',
        'todo_el_dia'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'todo_el_dia' => 'boolean'
    ];

    public static function obtenerColoresPorTipo()
    {
        return [
            'clase' => '#3788d8',
            'examen' => '#dc3545',
            'festivo' => '#28a745',
            'evento' => '#ffc107',
            'vacaciones' => '#17a2b8',
            'prematricula' => '#9c27b0',
            'matricula' => '#ff5722'
        ];
    }
}