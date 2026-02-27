<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

// CORRECCIÓN: el original importaba User, Rol y Padre con "use App\Models\X"
// dentro de un archivo que YA está en el namespace App\Models, por lo que
// esos imports son redundantes pero no causan error. Se eliminan por limpieza.
// Sin embargo SÍ se necesitan para que el IDE los reconozca, así que se dejan
// solo los que realmente se usan dentro del modelo.

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'estudiante_id',
        'estado',    // pendiente, aprobada, rechazada
        'notificar', // boolean
        // CORRECCIÓN: el original tenía $hidden = ['password'] y un setter
        // setPasswordAttribute(), pero 'password' NO está en $fillable ni
        // en la tabla solicitudes. Esto no causaba error pero era confuso
        // y podía llevar a guardar contraseñas en una tabla que no debería
        // tenerlas. Se elimina completamente.
    ];

    protected $casts = [
        'notificar' => 'boolean',
    ];

    // =========================================================================
    // RELACIONES
    // =========================================================================

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // =========================================================================
    // SCOPES útiles
    // =========================================================================

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }

    public function scopeRechazadas($query)
    {
        return $query->where('estado', 'rechazada');
    }

    // =========================================================================
    // GENERADOR DE CÓDIGO
    // =========================================================================

    /**
     * Genera un código único de matrícula para el año actual.
     *
     * CORRECCIÓN: el original hacía substr($ultimaSolicitud->codigo, -4) para
     * obtener el número, pero si el código era 'MAT-2024-0010', los últimos
     * 4 caracteres son '0010' lo que funciona. Sin embargo si no había ninguna
     * solicitud previa en el año, intval(substr(null, -4)) = 0, lo que es
     * correcto. La lógica era válida pero se hace más explícita y segura.
     */
    public static function generarCodigo(): string
    {
        $anio = date('Y');

        $ultima = self::whereYear('created_at', $anio)
            ->orderBy('id', 'desc')
            ->first();

        // Extraer el número del código anterior, o empezar desde 1
        $numero = 1;
        if ($ultima && $ultima->codigo) {
            $partes = explode('-', $ultima->codigo);
            $numero = (int) end($partes) + 1;
        }

        return 'MAT-' . $anio . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // =========================================================================
    // ACCIONES DE ESTADO
    // =========================================================================

    /**
     * Aprobar solicitud.
     *
     * CORRECCIÓN: el original accedía a $this->email directamente, pero
     * 'email' no está en $fillable ni en la tabla solicitudes según el modelo.
     * Si la tabla sí tiene esa columna, debe agregarse a $fillable.
     * Se agrega con comentario explicativo.
     *
     * CORRECCIÓN: el original no envolvía en transacción, por lo que si
     * crearUsuarioPadre() fallaba a mitad, el estado quedaba como 'aprobada'
     * pero sin el usuario/padre creado — estado inconsistente en BD.
     */
    public function aprobar(): void
    {
        // Verificar que solo se pueda aprobar si está pendiente
        if ($this->estado !== 'pendiente') {
            throw new \LogicException("Solo se pueden aprobar solicitudes en estado 'pendiente'. Estado actual: {$this->estado}");
        }

        DB::transaction(function () {
            $this->estado    = 'aprobada';
            $this->notificar = true;
            $this->save();

            // Crear usuario padre si la solicitud tiene email
            // NOTA: si tu tabla solicitudes NO tiene columna 'email',
            // obtén el email desde $this->estudiante->email en su lugar.
            $email = $this->email ?? $this->estudiante?->email ?? null;

            if ($email) {
                $this->crearUsuarioPadre($email);
            }

            $this->crearPadre($email);
        });
    }

    /**
     * Rechazar solicitud.
     *
     * CORRECCIÓN: igual que aprobar(), se verifica el estado previo
     * para evitar rechazar algo que ya fue aprobado o rechazado.
     */
    public function rechazar(): void
    {
        if ($this->estado !== 'pendiente') {
            throw new \LogicException("Solo se pueden rechazar solicitudes en estado 'pendiente'. Estado actual: {$this->estado}");
        }

        $this->estado = 'rechazada';
        $this->save();
    }

    // =========================================================================
    // HELPERS PRIVADOS
    // =========================================================================

    /**
     * Crear o actualizar el usuario padre en la tabla users.
     *
     * CORRECCIÓN: el original usaba $this->email directamente. Se recibe
     * como parámetro para mayor claridad y para evitar acceder a propiedades
     * que pueden no existir en la tabla.
     */
    private function crearUsuarioPadre(string $email): void
    {
        $usuarioExistente = User::where('email', $email)->first();

        if ($usuarioExistente) {
            DB::table('users')
                ->where('id', $usuarioExistente->id)
                ->update([
                    'user_type' => 'padre',
                    'activo'    => 1,
                    'id_rol'    => 5,
                ]);
            return;
        }

        $rolPadre = Rol::firstOrCreate(
            ['nombre'      => 'Padre'],
            ['descripcion' => 'Rol para padres de familia']
        );

        // CORRECCIÓN: el original usaba el nombre y apellido del ESTUDIANTE
        // para el nombre del usuario PADRE, lo cual es incorrecto.
        // Se construye el nombre del padre desde los campos de la solicitud
        // si existen, con fallback al estudiante.
        $nombrePadre = trim(
            ($this->padre_nombre ?? $this->estudiante?->nombre1 ?? 'Padre')
            . ' ' .
            ($this->padre_apellido ?? $this->estudiante?->apellido1 ?? '')
        );

        User::create([
            'name'              => $nombrePadre,
            'email'             => $email,
            // Contraseña inicial = DNI del estudiante (debe cambiarse en primer login)
            'password'          => Hash::make($this->estudiante?->dni ?? Str::random(10)),
            'id_rol'            => $rolPadre->id,
            'user_type'         => 'padre',
            'activo'            => true,
            'email_verified_at' => now(),
            'permissions'       => json_encode([
                'ver_calificaciones' => true,
                'ver_asistencias'    => true,
            ]),
        ]);
    }

    /**
     * Crear registro en tabla padres y vincular con el estudiante.
     *
     * CORRECCIÓN: el original no cargaba la relación estudiante antes de
     * acceder a sus propiedades, lo que podía causar N+1 queries o null
     * si la relación no estaba cargada. Se usa loadMissing().
     *
     * CORRECCIÓN: si crearUsuarioPadre() falló o no se llamó (sin email),
     * el $user podía ser null y se guardaba user_id = null sin advertencia.
     * Ahora se documenta explícitamente este caso.
     */
    private function crearPadre(?string $email): void
    {
        $this->loadMissing('estudiante');

        // Si el estudiante ya tiene padre asignado, no duplicar
        if ($this->estudiante?->padre_id) {
            return;
        }

        // Buscar el usuario padre recién creado (puede ser null si no hay email)
        $user = $email ? User::where('email', $email)->first() : null;

        $padre = Padre::create([
            'nombre'    => $this->padre_nombre
                        ?? $this->estudiante?->nombre1
                        ?? 'Padre',
            'apellido'  => $this->padre_apellido
                        ?? $this->estudiante?->apellido1
                        ?? 'Desconocido',
            // CORRECCIÓN: usar el DNI del padre desde la solicitud si existe,
            // no el DNI del estudiante (son personas diferentes).
            'dni'       => $this->padre_dni
                        ?? $this->estudiante?->dni
                        ?? '0000000000',
            'telefono'  => $this->padre_telefono
                        ?? $this->estudiante?->telefono
                        ?? '00000000',
            'correo'    => $email,
            'direccion' => $this->padre_direccion
                        ?? $this->estudiante?->direccion
                        ?? '',
            'user_id'   => $user?->id,
        ]);

        // Vincular estudiante con el padre recién creado
        if ($this->estudiante) {
            $this->estudiante->padre_id = $padre->id;
            $this->estudiante->save();
        }
    }
}
