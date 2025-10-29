<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    protected $table = 'padres';
    
    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'parentesco',
        'parentesco_otro',
        'email',
        'telefono',
        'telefono_secundario',
        'direccion',
        'ocupacion',
        'lugar_trabajo',
        'telefono_trabajo',
        'estado',
        'observaciones'
    ];

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    // Accessor para parentesco formateado
    public function getParentescoFormateadoAttribute()
    {
        if ($this->parentesco === 'otro' && $this->parentesco_otro) {
            return ucfirst($this->parentesco_otro);
        }
        
        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'tutor_legal' => 'Tutor Legal',
            'abuelo' => 'Abuelo',
            'abuela' => 'Abuela',
            'tio' => 'Tío',
            'tia' => 'Tía',
            'otro' => 'Otro'
        ];
        
        return $parentescos[$this->parentesco] ?? 'No especificado';
    }

    // Relaciones
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'matriculas');
    }
}