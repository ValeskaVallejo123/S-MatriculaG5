<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'todo_el_dia' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | COLORES SEGÚN TIPO DE EVENTO
    |--------------------------------------------------------------------------
    */

    public static function obtenerColoresPorTipo()
    {
        return [
            'clase'       => '#3788d8',
            'examen'      => '#dc3545',
            'festivo'     => '#28a745',
            'evento'      => '#ffc107',
            'vacaciones'  => '#17a2b8',
            'prematricula'=> '#9c27b0',
            'matricula'   => '#ff5722',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS / MUTATORS
    |--------------------------------------------------------------------------
    */

    // Devuelve el color final del evento:
    // el manual si existe, sino el asignado por tipo
    public function getColorFinalAttribute()
    {
        if ($this->color) {
            return $this->color;
        }

        $colores = self::obtenerColoresPorTipo();

        return $colores[$this->tipo] ?? '#000000';
    }

    // Duración del evento en días
    public function getDuracionAttribute()
    {
        if (!$this->fecha_inicio || !$this->fecha_fin) {
            return 1;
        }

        return $this->fecha_inicio->diffInDays($this->fecha_fin) + 1;
    }

    // Saber si dura solo 1 día
    public function getEsDeUnDiaAttribute()
    {
        return $this->duracion === 1;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS PARA TIPOS DE EVENTO
    |--------------------------------------------------------------------------
    */

    public function esExamen()
    {
        return $this->tipo === 'examen';
    }

    public function esFestivo()
    {
        return $this->tipo === 'festivo';
    }

    public function esClase()
    {
        return $this->tipo === 'clase';
    }

    public function esVacaciones()
    {
        return $this->tipo === 'vacaciones';
    }

    public function esPrematricula()
    {
        return $this->tipo === 'prematricula';
    }

    public function esMatricula()
    {
        return $this->tipo === 'matricula';
    }
}
