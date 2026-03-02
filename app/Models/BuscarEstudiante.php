<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuscarEstudiante extends Model
{
    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre1', 'nombre2', 'apellido1', 'apellido2',
        'dni', 'fecha_nacimiento', 'nacionalidad',
        'sexo', 'direccion', 'telefono'
    ];

    /*
    |--------------------------------------------------------------------------
    | SCOPES DE BÚSQUEDA
    |--------------------------------------------------------------------------
    */

    // Buscar por DNI exacto
    public function scopeDni($query, $dni)
    {
        return $query->where('dni', $dni);
    }

    // Buscar por nombre (uno o varios)
    public function scopeNombre($query, $nombre)
    {
        $nombre = trim(strtolower($nombre));

        return $query->where(function ($q) use ($nombre) {
            $q->whereRaw('LOWER(nombre1) LIKE ?', ["%{$nombre}%"])
              ->orWhereRaw('LOWER(nombre2) LIKE ?', ["%{$nombre}%"])
              ->orWhereRaw('LOWER(apellido1) LIKE ?', ["%{$nombre}%"])
              ->orWhereRaw('LOWER(apellido2) LIKE ?', ["%{$nombre}%"]);
        });
    }

    // Búsqueda general: nombre o DNI
    public function scopeSearch($query, $texto)
    {
        $texto = trim(strtolower($texto));

        return $query->where(function ($q) use ($texto) {
            $q->where('dni', 'LIKE', "%{$texto}%")
              ->orWhereRaw('LOWER(nombre1) LIKE ?', ["%{$texto}%"])
              ->orWhereRaw('LOWER(nombre2) LIKE ?', ["%{$texto}%"])
              ->orWhereRaw('LOWER(apellido1) LIKE ?', ["%{$texto}%"])
              ->orWhereRaw('LOWER(apellido2) LIKE ?', ["%{$texto}%"]);
        });
    }
}
