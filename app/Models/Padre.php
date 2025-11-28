<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    use HasFactory;

    protected $table = 'padres';

    protected $fillable = [
        'user_id',
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
        'observaciones',
    ];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | ACCESORES
    |--------------------------------------------------------------------------
    */

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function getParentescoFormateadoAttribute()
    {
        if ($this->parentesco === 'otro' && $this->parentesco_otro) {
            return ucfirst($this->parentesco_otro);
        }

        return match ($this->parentesco) {
            'padre' => 'Padre',
            'madre' => 'Madre',
            'tutor_legal' => 'Tutor Legal',
            'otro' => 'Otro',
            default => 'No especificado',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'padre_id', 'id');
    }

    // Padre → Estudiantes a través de matrículas
    public function estudiantes()
    {
        return $this->belongsToMany(
            Estudiante::class,
            'matriculas',
            'padre_id',
            'estudiante_id'
        );
    }

    // Permisos por estudiante
    public function permisos()
    {
        return $this->hasMany(PadrePermiso::class, 'padre_id');
    }

    public function permisosParaEstudiante($estudianteId)
    {
        return $this->permisos()
            ->where('estudiante_id', $estudianteId)
            ->first();
    }

    public function tienePermiso($estudianteId, $permiso)
    {
        $config = $this->permisosParaEstudiante($estudianteId);
        return $config ? $config->tienePermiso($permiso) : false;
    }
}
