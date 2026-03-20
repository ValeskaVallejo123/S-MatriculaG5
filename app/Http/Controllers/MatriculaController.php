<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;


class MatriculaController extends Controller
{
    // ── Grados disponibles ───────────────────────────────────────────────────
    private const GRADOS = [
        '1er Grado', '2do Grado', '3er Grado',
        '4to Grado', '5to Grado', '6to Grado',
        'I curso',   'II curso',  'III curso',
    ];

    private const PARENTESCOS = [
        'padre' => 'Padre',
        'madre' => 'Madre',
        'otro'  => 'Otro',
    ];

    // ────────────────────────────────────────────────────────────────────────
    // INDEX
    // ────────────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Matricula::with(['estudiante', 'padre']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('estudiante', function ($q) use ($buscar) {
                $q->where('nombre1',    'like', "%{$buscar}%")
                    ->orWhere('apellido1','like', "%{$buscar}%")
                    ->orWhere('dni',      'like', "%{$buscar}%");
            });
        }

        if ($request->filled('grado')) {
            $query->whereHas('estudiante', function ($q) use ($request) {
                $q->where('grado', $request->grado);
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('anio')) {
            $query->where('anio_lectivo', $request->anio);
        }

        $matriculas = $query->latest()->paginate(15);

        $estadisticas = Matricula::selectRaw("
            SUM(estado = 'aprobada')  as aprobadas,
            SUM(estado = 'pendiente') as pendientes,
            SUM(estado = 'rechazada') as rechazadas
        ")->first();

        $aprobadas  = $estadisticas->aprobadas  ?? 0;
        $pendientes = $estadisticas->pendientes ?? 0;
        $rechazadas = $estadisticas->rechazadas ?? 0;

        return view('matriculas.index', compact(
            'matriculas', 'aprobadas', 'pendientes', 'rechazadas'
        ));
    }

    // ────────────────────────────────────────────────────────────────────────
    // CREATE
    // ────────────────────────────────────────────────────────────────────────

    public function create()
    {
        $grados = [
            'Primero', 'Segundo', 'Tercero',
            'Cuarto',  'Quinto',  'Sexto',
        ];

        $secciones = ['A', 'B', 'C', 'D'];

        $parentescos = [
            'padre'   => 'Padre',
            'madre'   => 'Madre',
            'abuelo'  => 'Abuelo/a',
            'hermano' => 'Hermano/a',
            'tio'     => 'Tío/a',
            'tutor'   => 'Tutor/a',
            'otro'    => 'Otro',
        ];

        return view('matriculas.create', compact('grados', 'secciones', 'parentescos'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // STORE
    // ────────────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $esPublico = $request->is('matricula-publica') || $request->boolean('publico');

        $validated = $request->validate([
            // Padre/Tutor
            'padre_nombre'                => 'required|string|min:2|max:50',
            'padre_apellido'              => 'required|string|min:2|max:50',
            'padre_dni'                   => 'required|string|max:13',
            'padre_parentesco'            => 'required|in:padre,madre,otro',
            'padre_parentesco_otro'       => 'nullable|required_if:padre_parentesco,otro|string|max:50',
            'padre_email'                 => 'nullable|email|max:100|unique:users,email',
            'padre_telefono'              => 'required|string|min:8|max:15',
            'padre_direccion'             => 'required|string|max:255',
            // Estudiante
            'estudiante_nombre'           => 'required|string|min:2|max:100',
            'estudiante_apellido'         => 'required|string|min:2|max:100',
            'estudiante_dni'              => 'required|string|max:13|unique:estudiantes,dni',
            'estudiante_fecha_nacimiento' => 'required|date|before:today',
            'estudiante_sexo'             => 'required|in:masculino,femenino',
            'estudiante_email'            => 'nullable|email|max:100',
            'estudiante_telefono'         => 'nullable|string|max:15',
            'estudiante_direccion'        => 'nullable|string|max:255',
            'estudiante_grado'            => 'required|string|max:20',
            // Matrícula
            'anio_lectivo'                => 'required|digits:4|integer|min:2020|max:2100',
            'estado'                      => 'nullable|in:pendiente,aprobada,rechazada,cancelada',
            'observaciones'               => 'nullable|string|max:500',
            // Documentos
            'foto_perfil'                 => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'calificaciones'              => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'acta_nacimiento'             => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // ── Padre ────────────────────────────────────────────────────
            $padre = Padre::where('dni', $validated['padre_dni'])->first();

            if ($padre && !$esPublico) {
                DB::rollBack();
                return back()->withInput()->withErrors([
                    'padre_dni' => 'Ya existe un padre/tutor con este DNI.',
                ]);
            }

            if (!$padre) {
                $padre = Padre::create([
                    'nombre'     => $validated['padre_nombre'],
                    'apellido'   => $validated['padre_apellido'],
                    'dni'        => $validated['padre_dni'],
                    'parentesco' => $validated['padre_parentesco'] === 'otro'
                        ? ($validated['padre_parentesco_otro'] ?? 'otro')
                        : $validated['padre_parentesco'],
                    'correo'     => $validated['padre_email']    ?? null,
                    'telefono'   => $validated['padre_telefono'],
                    'direccion'  => $validated['padre_direccion'],
                    'estado'     => 1,
                ]);
            }

            // ── Usuario padre (matrícula pública con email) ──────────────
            // NOTA: el usuario se crea INACTIVO aquí.
            // Se activará automáticamente cuando el admin apruebe la matrícula.
            if ($esPublico && !empty($validated['padre_email'])) {
                $usuarioExistente = User::where('email', $validated['padre_email'])->first();

                if ($usuarioExistente) {
                    DB::table('users')
                        ->where('id', $usuarioExistente->id)
                        ->update(['user_type' => 'padre', 'activo' => 0, 'id_rol' => 5]);

                    if (!$padre->user_id) {
                        $padre->update(['user_id' => $usuarioExistente->id]);
                    }
                } else {
                    $rolPadre = Rol::firstOrCreate(
                        ['nombre' => 'Padre'],
                        ['descripcion' => 'Rol para padres de familia']
                    );

                    $nuevoUser = User::create([
                        'name'              => $validated['padre_nombre'] . ' ' . $validated['padre_apellido'],
                        'email'             => $validated['padre_email'],
                        'password'          => Hash::make($validated['padre_dni']),
                        'id_rol'            => $rolPadre->id,
                        'user_type'         => 'padre',
                        'activo'            => 0, // inactivo hasta aprobación
                        'email_verified_at' => now(),
                        'permissions'       => json_encode([
                            'ver_calificaciones' => true,
                            'ver_asistencias'    => true,
                        ]),
                    ]);

                    $padre->update(['user_id' => $nuevoUser->id]);
                }
            }

            // ── Estudiante ───────────────────────────────────────────────
            $nombrePartes   = explode(' ', trim($validated['estudiante_nombre']),   2);
            $apellidoPartes = explode(' ', trim($validated['estudiante_apellido']), 2);

            $estudiante = Estudiante::create([
                'nombre1'          => $nombrePartes[0]   ?? 'Sin nombre',
                'nombre2'          => $nombrePartes[1]   ?? null,
                'apellido1'        => $apellidoPartes[0] ?? 'Sin apellido',
                'apellido2'        => $apellidoPartes[1] ?? null,
                'apellido'         => $validated['estudiante_apellido'],
                'dni'              => $validated['estudiante_dni'],
                'fecha_nacimiento' => $validated['estudiante_fecha_nacimiento'],
                'sexo'             => ucfirst($validated['estudiante_sexo']),
                'genero'           => ucfirst($validated['estudiante_sexo']),
                'email'            => $validated['estudiante_email']     ?? null,
                'telefono'         => $validated['estudiante_telefono']  ?? null,
                'direccion'        => $validated['estudiante_direccion'] ?? null,
                'grado'            => $validated['estudiante_grado'],
                'seccion'          => 'X',
                'estado'           => 'activo',
                'padre_id'         => $padre->id,
            ]);

            // ── Código de matrícula ──────────────────────────────────────
            $conteo          = Matricula::where('anio_lectivo', $validated['anio_lectivo'])->count();
            $codigoMatricula = 'MAT-' . $validated['anio_lectivo'] . '-' . str_pad($conteo + 1, 4, '0', STR_PAD_LEFT);

            // ── Matrícula ────────────────────────────────────────────────
            $estadoInicial = $esPublico ? 'pendiente' : ($validated['estado'] ?? 'pendiente');

            $matricula = Matricula::create([
                'padre_id'         => $padre->id,
                'estudiante_id'    => $estudiante->id,
                'codigo_matricula' => $codigoMatricula,
                'anio_lectivo'     => $validated['anio_lectivo'],
                'fecha_matricula'  => now()->format('Y-m-d'),
                'estado'           => $estadoInicial,
                'observaciones'    => $esPublico
                    ? 'Matrícula registrada desde el portal público'
                    : ($validated['observaciones'] ?? null),
            ]);

            // ── Documentos ───────────────────────────────────────────────
            $documentosRutas = [];
            $archivosDoc = [
                'foto_perfil'     => 'documentos_matriculas/fotos',
                'calificaciones'  => 'documentos_matriculas/calificaciones',
                'acta_nacimiento' => 'documentos_matriculas/actas',
            ];

            foreach ($archivosDoc as $campo => $carpeta) {
                if ($request->hasFile($campo)) {
                    $archivo    = $request->file($campo);
                    $nombreArch = $campo . '_' . $estudiante->id . '_' . time()
                        . '.' . $archivo->getClientOriginalExtension();
                    $documentosRutas[$campo] = $archivo->storeAs($carpeta, $nombreArch, 'public');
                }
            }

            if (!empty($documentosRutas)) {
                $matricula->update($documentosRutas);
            }

            // ── Si se crea directamente como aprobada (desde admin) ──────
            if ($estadoInicial === 'aprobada') {
                $matricula->update(['fecha_confirmacion' => now()]);
                $this->procesarAprobacion($matricula->fresh(['padre', 'estudiante']));
            }

            DB::commit();

            if ($esPublico) {
                return redirect()->route('matriculas.success')
                    ->with('success',   '¡Matrícula registrada exitosamente!')
                    ->with('codigo',    $codigoMatricula)
                    ->with('email',     $validated['padre_email'] ?? null)
                    ->with('identidad', $validated['padre_dni'])
                    ->with('estado',    'pendiente');
            }

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula registrada exitosamente con código: ' . $codigoMatricula);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([
                'error' => 'Ocurrió un error al registrar la matrícula: ' . $e->getMessage(),
            ]);
        }
    }

    // ────────────────────────────────────────────────────────────────────────
    // SUCCESS (matrícula pública)
    // ────────────────────────────────────────────────────────────────────────

    public function success()
    {
        if (!session('codigo')) {
            return redirect()->route('matricula-publica')
                ->with('error', 'No hay ninguna matrícula reciente para mostrar.');
        }

        return view('matriculas.success');
    }

    // ────────────────────────────────────────────────────────────────────────
    // DETALLES (JSON para modal)
    // ────────────────────────────────────────────────────────────────────────

    public function detalles(Matricula $matricula)
    {
        $matricula->load(['estudiante', 'padre']);

        if (!$matricula->estudiante || !$matricula->padre) {
            return response()->json([
                'error' => 'Esta matrícula tiene datos incompletos.',
            ], 422);
        }

        $est = $matricula->estudiante;
        $pad = $matricula->padre;

        return response()->json([
            'estudiante' => [
                'nombre_completo' => trim(implode(' ', array_filter([
                    $est->nombre1, $est->nombre2, $est->apellido1, $est->apellido2,
                ]))),
                'dni'              => $est->dni,
                'fecha_nacimiento' => Carbon::parse($est->fecha_nacimiento)->format('d/m/Y'),
                'sexo'             => ucfirst($est->sexo ?? ''),
                'grado'            => $est->grado,
                'seccion'          => $est->seccion ?? 'Sin asignar',
                'email'            => $est->email,
                'telefono'         => $est->telefono,
                'direccion'        => $est->direccion,
            ],
            'padre' => [
                'nombre_completo' => trim($pad->nombre . ' ' . $pad->apellido),
                'dni'             => $pad->dni,
                'parentesco'      => ucfirst($pad->parentesco ?? ''),
                'correo'          => $pad->correo,
                'telefono'        => $pad->telefono,
                'direccion'       => $pad->direccion,
            ],
            'matricula' => [
                'codigo'          => $matricula->codigo_matricula,
                'anio_lectivo'    => $matricula->anio_lectivo,
                'fecha_matricula' => Carbon::parse($matricula->fecha_matricula)->format('d/m/Y'),
                'estado'          => $matricula->estado,
                'observaciones'   => $matricula->observaciones,
            ],
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────
    // SHOW
    // ────────────────────────────────────────────────────────────────────────

    public function show(Matricula $matricula)
    {
        $matricula->load(['padre', 'padre.user', 'estudiante']);
        return view('matriculas.show', compact('matricula'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // EDIT
    // ────────────────────────────────────────────────────────────────────────

    public function edit(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);

        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $padres      = Padre::orderBy('nombre')->get();
        $grados      = self::GRADOS;
        $parentescos = self::PARENTESCOS;

        return view('matriculas.edit', compact(
            'matricula', 'estudiantes', 'padres', 'parentescos', 'grados'
        ));
    }

    // ────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ────────────────────────────────────────────────────────────────────────

    public function update(Request $request, Matricula $matricula)
    {
        $request->validate([
            'anio_lectivo'         => 'required|digits:4|integer|min:2020|max:2100',
            'fecha_matricula'      => 'required|date',
            'estado'               => 'required|in:pendiente,aprobada,rechazada,cancelada',
            'motivo_rechazo'       => 'nullable|string|max:500',
            'observaciones'        => 'nullable|string|max:1000',
            'foto_estudiante'      => 'nullable|image|max:2048',
            'acta_nacimiento'      => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'certificado_estudios' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'constancia_conducta'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto_dni_estudiante'  => 'nullable|image|max:2048',
            'foto_dni_padre'       => 'nullable|image|max:2048',
        ]);

        $estadoAnterior = $matricula->estado;
        $estadoNuevo    = $request->estado;

        $documentos = [
            'foto_estudiante', 'acta_nacimiento', 'certificado_estudios',
            'constancia_conducta', 'foto_dni_estudiante', 'foto_dni_padre',
        ];

        $datosActualizar = [
            'anio_lectivo'       => $request->anio_lectivo,
            'fecha_matricula'    => $request->fecha_matricula,
            'estado'             => $estadoNuevo,
            'observaciones'      => $request->observaciones,
            'motivo_rechazo'     => $estadoNuevo === 'rechazada'
                ? $request->motivo_rechazo
                : null,
            'fecha_confirmacion' => in_array($estadoNuevo, ['aprobada', 'rechazada']) && $estadoAnterior === 'pendiente'
                ? now()
                : $matricula->fecha_confirmacion,
        ];

        foreach ($documentos as $campo) {
            if ($request->hasFile($campo)) {
                if ($matricula->$campo) {
                    Storage::disk('public')->delete($matricula->$campo);
                }
                $datosActualizar[$campo] = $request->file($campo)->store('matriculas', 'public');
            }
        }

        $matricula->update($datosActualizar);

        if ($estadoNuevo === 'aprobada' && $estadoAnterior !== 'aprobada') {
            $this->procesarAprobacion($matricula->fresh(['padre', 'estudiante']));
        }

        return redirect()
            ->route('matriculas.show', $matricula->id)
            ->with('success', 'Matrícula actualizada correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // DESTROY
    // ────────────────────────────────────────────────────────────────────────

    public function destroy(Matricula $matricula)
    {
        $matricula->delete();

        return redirect()->route('matriculas.index')
            ->with('success', 'Matrícula eliminada correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // CAMBIOS DE ESTADO
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Aprobar matrícula (botón rápido desde index o show).
     */
    public function confirmar(Matricula $matricula)
    {
        if ($matricula->estado !== 'pendiente') {
            if (request()->ajax()) {
                return response()->json([
                    'error' => "No se puede aprobar una matrícula con estado '{$matricula->estado}'."
                ], 422);
            }
            return back()->withErrors(['error' => "No se puede aprobar una matrícula con estado '{$matricula->estado}'."]);
        }

        $matricula->update([
            'estado'             => 'aprobada',
            'fecha_confirmacion' => now(),
            'motivo_rechazo'     => null,
        ]);

        $this->procesarAprobacion($matricula->fresh(['padre', 'estudiante']));

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Matrícula aprobada correctamente.']);
        }

        return back()->with('success', 'Matrícula aprobada y acceso creado para el padre/tutor.');
    }

    /**
     * Rechazar matrícula.
     */
    public function rechazar(Request $request, Matricula $matricula)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|min:10|max:500',
        ]);

        if ($matricula->estado !== 'pendiente') {
            if ($request->ajax()) {
                return response()->json([
                    'error' => "No se puede rechazar una matrícula con estado '{$matricula->estado}'."
                ], 422);
            }
            return back()->withErrors(['error' => "No se puede rechazar una matrícula con estado '{$matricula->estado}'."]);
        }

        $matricula->update([
            'estado'             => 'rechazada',
            'motivo_rechazo'     => $request->motivo_rechazo,
            'fecha_confirmacion' => now(),
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Matrícula rechazada correctamente.']);
        }

        return back()->with('success', 'Matrícula rechazada correctamente.');
    }

    /**
     * Cancelar matrícula.
     */
    public function cancelar(Matricula $matricula): RedirectResponse
    {
        if (in_array($matricula->estado, ['cancelada', 'rechazada'])) {
            return back()->withErrors([
                'error' => "No se puede cancelar una matrícula con estado '{$matricula->estado}'.",
            ]);
        }

        $matricula->update(['estado' => 'cancelada']);

        return back()->with('success', 'Matrícula cancelada correctamente.');
    }

    /**
     * Aprobar rápido (patch desde index).
     */
    public function aprobar(Matricula $matricula)
    {
        $matricula->update(['estado' => 'aprobada']);

        return back()->with('success', 'Matrícula aprobada correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // APROBACIÓN — crear/activar usuario del padre
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Cuando una matrícula se aprueba por primera vez:
     *  1. Si el padre no tiene user_id → se crea un User con rol "padre"
     *  2. Si ya tiene user_id          → solo se activa el usuario
     *  3. Se activa el padre   (estado = activo)
     *  4. Se activa el estudiante (estado = activo)
     *
     * Contraseña inicial = DNI del padre.
     */
    private function procesarAprobacion(Matricula $matricula): void
    {
        $padre      = $matricula->padre;
        $estudiante = $matricula->estudiante;

        if (!$padre || !$estudiante) {
            return;
        }

        // ── Crear o activar usuario del padre ─────────────────────────────
        if (!$padre->user_id) {

            $rolPadre = Rol::where('nombre', 'like', '%adre%')   // Padre
            ->orWhere('nombre', 'like', '%utor%')  // Tutor
            ->first();

            // Usar correo del padre si está disponible y no está en uso
            if ($padre->correo && !User::where('email', $padre->correo)->exists()) {
                $email = $padre->correo;
            } else {
                // Generar email automático con unicidad garantizada
                $base  = Str::slug($padre->nombre . '.' . $padre->apellido) . '.' . $padre->id;
                $email = $base . '@escuela.edu';

                if (User::where('email', $email)->exists()) {
                    $email = 'padre.' . $padre->id . '.' . time() . '@escuela.edu';
                }
            }

            $user = User::create([
                'name'              => $padre->nombre . ' ' . $padre->apellido,
                'email'             => $email,
                'password'          => Hash::make($padre->dni), // contraseña = DNI
                'user_type'         => 'padre',
                'id_rol'            => $rolPadre?->id ?? 5,
                'activo'            => true,
                'email_verified_at' => now(),
                'permissions'       => json_encode([
                    'ver_calificaciones' => true,
                    'ver_asistencias'    => true,
                ]),
            ]);

            $padre->update(['user_id' => $user->id]);

        } else {
            // Ya tiene usuario → solo activarlo
            User::where('id', $padre->user_id)->update(['activo' => true]);
        }

        // ── Activar padre y estudiante ────────────────────────────────────
        $padre->update(['estado' => 'activo']);
        $estudiante->update(['estado' => 'activo']);
    }
}
