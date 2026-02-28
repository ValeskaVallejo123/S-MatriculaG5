<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Rol;
use App\Models\Padre;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'estudiante_id',
        'codigo',
        'email',
        'password',
        'estado',
        'notificar',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Relación con Estudiante
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Hash automático del password
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Generar código único de matrícula
     */
    public static function generarCodigo()
    {
        $anio = date('Y');
        $ultimaSolicitud = self::whereYear('created_at', $anio)
            ->orderBy('id', 'desc')
            ->first();

        $numero = $ultimaSolicitud ? intval(substr($ultimaSolicitud->codigo, -4)) + 1 : 1;
        
        return 'MAT-' . $anio . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Aprobar solicitud
     */
    public function aprobar()
    {
        $this->estado = 'aprobada';
        $this->notificar = true;
        $this->save();

        // Crear usuario padre si tiene email
        if ($this->email) {
            $this->crearUsuarioPadre();
        }

        // Crear registro en tabla padres
        $this->crearPadre();
    }

    /**
     * Rechazar solicitud
     */
    public function rechazar()
    {
        $this->estado = 'rechazada';
        $this->save();
    }

    /**
     * Crear usuario padre en tabla users
     */
    private function crearUsuarioPadre()
    {
        // Verificar si ya existe el usuario
        $usuarioExistente = User::where('email', $this->email)->first();
        
        if ($usuarioExistente) {
            // Si existe, actualizarlo a padre y activarlo
            DB::table('users')
                ->where('id', $usuarioExistente->id)
                ->update([
                    'user_type' => 'padre',
                    'activo' => 1,
                    'id_rol' => 5, // Asumiendo que 5 es el ID del rol Padre
                ]);
            return;
        }

        // Buscar o crear el rol "Padre"
        $rolPadre = Rol::firstOrCreate(
            ['nombre' => 'Padre'],
            ['descripcion' => 'Rol para padres de familia']
        );

        // Crear el nuevo usuario PADRE
        User::create([
            'name' => $this->estudiante->nombre1 . ' ' . $this->estudiante->apellido1,
            'email' => $this->email,
            'password' => Hash::make($this->estudiante->dni),
            'id_rol' => $rolPadre->id,
            'user_type' => 'padre',
            'activo' => true,
            'email_verified_at' => now(),
            'permissions' => json_encode([
                'ver_calificaciones' => true,
                'ver_asistencias' => true,
            ]),
        ]);
    }

    /**
     * Crear registro en tabla padres
     */
    private function crearPadre()
    {
        // Verificar si el estudiante ya tiene padre asignado
        if ($this->estudiante->padre_id) {
            return;
        }

        // Buscar el usuario padre recién creado
        $user = User::where('email', $this->email)->first();

        // Crear registro en tabla padres
        $padre = Padre::create([
            'nombre' => $this->estudiante->nombre1 ?? 'Padre',
            'apellido' => $this->estudiante->apellido1 ?? 'Desconocido',
            'dni' => $this->estudiante->dni ?? '0000000000',
            'telefono' => $this->estudiante->telefono ?? '00000000',
            'correo' => $this->email,
            'direccion' => $this->estudiante->direccion ?? '',
            'user_id' => $user ? $user->id : null,
        ]);

        // Vincular estudiante con padre
        $this->estudiante->padre_id = $padre->id;
        $this->estudiante->save();
    }
}
