<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre1',
        'nombre2',
        'apellido1',
        'apellido2',
        'dni',
        'fecha_nacimiento',
        'sexo',
        'email',
        'telefono',
        'direccion',
        'grado',
        'seccion',
        'estado',
        'observaciones',
        'foto',
        'padre_id', // Para la relación directa con la tabla padres
        'curso_id',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /*
    |----------------------------------------------------------------------
    | ACCESSORS (Atributos Calculados)
    |----------------------------------------------------------------------
    */

    // Nombre completo: {{ $estudiante->nombre_completo }}
    public function getNombreCompletoAttribute()
    {
        $nombre = trim("{$this->nombre1} {$this->nombre2}");
        $apellido = trim("{$this->apellido1} {$this->apellido2}");
        return trim("{$nombre} {$apellido}");
    }

    // URL de la foto: {{ $estudiante->url_foto }}
    // Sincronizado con la carpeta de expedientes que usas
    // Dentro de App\Models\Estudiante.php

    public function getUrlFotoAttribute()
    {
        if ($this->foto) {
            // basename limpia cualquier ruta antigua y deja solo el nombre del archivo
            $nombreArchivo = basename($this->foto);
            return asset('storage/expedientes/fotos/' . $nombreArchivo);
        }
        return null;
    }

    /*
    |----------------------------------------------------------------------
    | RELACIONES
    |----------------------------------------------------------------------
    */

    // Relación directa con el Padre principal (según tu migración)
    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }

    // Documentos del expediente (Muchos a Muchos o Uno a Muchos)
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'estudiante_id');
    }

    // Si quieres obtener específicamente el documento que es la foto de perfil
    public function documentoFoto()
    {
        return $this->hasOne(Documento::class, 'estudiante_id')->where('tipo', 'perfil');
    }

    // Relación con el curso/grado
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    // Relación con el usuario del sistema (si aplica)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |----------------------------------------------------------------------
    | MÉTODOS ESTÁTICOS PARA FORMULARIOS (SELECTS)
    |----------------------------------------------------------------------
    */

    public static function grados()
    {
        return [
            '1ro Primaria', '2do Primaria', '3ro Primaria',
            '4to Primaria', '5to Primaria', '6to Primaria',
            '1ro Secundaria', '2do Secundaria', '3ro Secundaria',
        ];
    }

    public static function secciones()
    {
        return ['A', 'B', 'C'];
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'estudiante_id');
    }


    public function getHistorialAcademicoAttribute()
    {
        return $this->calificaciones()
            ->with(['materia', 'periodo'])
            ->get()
            ->groupBy(function($calificacion) {
                // Agrupa por el año del periodo académico
                return $calificacion->periodo->anio ?? 'Sin Año';
            });
    }
}
