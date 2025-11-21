<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    protected $table = 'padres';

    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'parentesco',
        'parentesco_otro',
         'correo',
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
         return $this->hasMany(Estudiante::class, 'padre_id');
    }

    /**
 * Relación con permisos
 */
public function permisos()
{
    return $this->hasMany(PadrePermiso::class);
}

/**
 * Obtener permisos para un estudiante específico
 */
public function permisosParaEstudiante($estudianteId)
{
    return $this->permisos()->where('estudiante_id', $estudianteId)->first();
}

/**
 * Verificar si tiene permiso para un estudiante
 */
public function tienePermiso($estudianteId, $permiso)
{
    $permisoConfig = $this->permisosParaEstudiante($estudianteId);
    return $permisoConfig ? $permisoConfig->tienePermiso($permiso) : false;
}
}
