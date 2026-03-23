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
    private const GRADOS = [
        'Primer Grado', 'Segundo Grado', 'Tercer Grado',
        'Cuarto Grado', 'Quinto Grado',  'Sexto Grado',
        'Séptimo Grado', 'Octavo Grado', 'Noveno Grado',
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
    // CREATE — Formulario del ADMIN (privado, requiere auth)
    // ────────────────────────────────────────────────────────────────────────

    public function create()
    {
        $grados = [
            'Primer Grado',  'Segundo Grado', 'Tercer Grado',
            'Cuarto Grado',  'Quinto Grado',  'Sexto Grado',
            'Séptimo Grado', 'Octavo Grado',  'Noveno Grado',
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
    // CREATE PÚBLICO — Formulario para el público (sin login)
    // Ruta: GET /matricula-publica  →  name('matriculas.public.create')
    // ────────────────────────────────────────────────────────────────────────

    public function createPublico()
    {
        return view('matriculas.create-public');
    }

    // ────────────────────────────────────────────────────────────────────────
    // STORE — Maneja tanto el formulario admin como el público
    // El campo hidden "publico=1" activa la rama pública dentro de este método
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

            // ── Padre ─────────────────────────────────────────────────────
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

            // ── Usuario padre (matrícula pública con email) ───────────────
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
                        'activo'            => 0,
                        'email_verified_at' => now(),
                        'permissions'       => json_encode([
                            'ver_calificaciones' => true,
                            'ver_asistencias'    => true,
                        ]),
                    ]);

                    $padre->update(['user_id' => $nuevoUser->id]);
                }
            }

            // ── Estudiante ────────────────────────────────────────────────
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

            // ── Código de matrícula ───────────────────────────────────────
            $conteo          = Matricula::where('anio_lectivo', $validated['anio_lectivo'])->count();
            $codigoMatricula = 'MAT-' . $validated['anio_lectivo'] . '-' . str_pad($conteo + 1, 4, '0', STR_PAD_LEFT);

            // ── Matrícula ─────────────────────────────────────────────────
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

            // ── Documentos ────────────────────────────────────────────────
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

            if ($estadoInicial === 'aprobada') {
                $matricula->update(['fecha_confirmacion' => now()]);
                $this->procesarAprobacion($matricula->fresh(['padre', 'estudiante']));
            }

            DB::commit();

            if ($esPublico) {
                return redirect()->route('matriculas.success')
                    ->with('success',           '¡Matrícula registrada exitosamente!')
                    ->with('codigo',            $codigoMatricula)
                    ->with('nombre_estudiante', trim($validated['estudiante_nombre'] . ' ' . $validated['estudiante_apellido']))
                    ->with('email',             $validated['padre_email'] ?? null)
                    ->with('identidad',         $validated['padre_dni'])
                    ->with('estado',            'pendiente');
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
    // SUCCESS
    // ────────────────────────────────────────────────────────────────────────

    public function success()
    {
        if (!session('codigo')) {
            return redirect()->route('matriculas.public.create')
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

    public function aprobar(Matricula $matricula)
    {
        $estadoAnterior = $matricula->estado;

        $matricula->update([
            'estado'             => 'aprobada',
            'fecha_confirmacion' => now(),
            'motivo_rechazo'     => null,
        ]);

        if ($estadoAnterior !== 'aprobada') {
            $this->procesarAprobacion($matricula->fresh(['padre', 'estudiante']));
        }

        return back()->with('success', 'Matrícula aprobada y acceso creado para el padre/tutor.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // APROBACIÓN — crear/activar usuario del padre
    // ────────────────────────────────────────────────────────────────────────

    private function procesarAprobacion(Matricula $matricula): void
    {
        $padre      = $matricula->padre;
        $estudiante = $matricula->estudiante;

        if (!$padre || !$estudiante) {
            return;
        }

        // ── Usuario del Padre ─────────────────────────────────────────────
        if (!$padre->user_id) {

            $rolPadre = Rol::where('nombre', 'like', '%adre%')
                           ->orWhere('nombre', 'like', '%utor%')
                           ->first();

            if ($padre->correo && !User::where('email', $padre->correo)->exists()) {
                $emailPadre = $padre->correo;
            } else {
                $base       = Str::slug($padre->nombre . '.' . $padre->apellido) . '.' . $padre->id;
                $emailPadre = $base . '@escuela.edu';

                if (User::where('email', $emailPadre)->exists()) {
                    $emailPadre = 'padre.' . $padre->id . '.' . time() . '@escuela.edu';
                }
            }

            $userPadre = User::create([
                'name'              => $padre->nombre . ' ' . $padre->apellido,
                'email'             => $emailPadre,
                'password'          => Hash::make($padre->dni),
                'user_type'         => 'padre',
                'id_rol'            => $rolPadre?->id ?? 5,
                'activo'            => true,
                'email_verified_at' => now(),
                'permissions'       => json_encode([
                    'ver_calificaciones' => true,
                    'ver_asistencias'    => true,
                ]),
            ]);

            $padre->update(['user_id' => $userPadre->id]);

        } else {
            User::where('id', $padre->user_id)->update(['activo' => true]);
        }

        // ── Usuario del Estudiante ────────────────────────────────────────
        if (!$estudiante->user_id) {

            $rolEstudiante = Rol::where('nombre', 'like', '%studiante%')
                               ->orWhere('nombre', 'like', '%lumno%')
                               ->first();

            // Email: usar el del estudiante si existe y no está tomado
            if ($estudiante->email && !User::where('email', $estudiante->email)->exists()) {
                $emailEst = $estudiante->email;
            } else {
                $base     = Str::slug($estudiante->nombre1 . '.' . $estudiante->apellido1) . '.' . $estudiante->id;
                $emailEst = $base . '@escuela.edu';

                if (User::where('email', $emailEst)->exists()) {
                    $emailEst = 'estudiante.' . $estudiante->id . '.' . time() . '@escuela.edu';
                }
            }

            $userEstudiante = User::create([
                'name'              => trim("{$estudiante->nombre1} {$estudiante->nombre2} {$estudiante->apellido1} {$estudiante->apellido2}"),
                'email'             => $emailEst,
                'password'          => Hash::make($estudiante->dni),
                'user_type'         => 'estudiante',
                'id_rol'            => $rolEstudiante?->id ?? 4,
                'activo'            => true,
                'email_verified_at' => now(),
                'permissions'       => json_encode([
                    'ver_calificaciones' => true,
                    'ver_asistencias'    => true,
                ]),
            ]);

            $estudiante->update(['user_id' => $userEstudiante->id]);

        } else {
            User::where('id', $estudiante->user_id)->update(['activo' => true]);
        }

        $padre->update(['estado' => 1]);
        $estudiante->update(['estado' => 'activo']);

        // Asignar grado_id al estudiante si aún no tiene uno
        if (!$estudiante->grado_id) {
            $this->asignarGradoAlEstudiante($estudiante);
        }
    }

    /**
     * Mapa de string grado → [numero, nivel] para buscar en tabla grados.
     */
    private static function mapaGrados(): array
    {
        return [
            'Primer Grado'   => [1, 'primaria'],
            'Segundo Grado'  => [2, 'primaria'],
            'Tercer Grado'   => [3, 'primaria'],
            'Cuarto Grado'   => [4, 'primaria'],
            'Quinto Grado'   => [5, 'primaria'],
            'Sexto Grado'    => [6, 'primaria'],
            'Séptimo Grado'  => [7, 'secundaria'],
            'Octavo Grado'   => [8, 'secundaria'],
            'Noveno Grado'   => [9, 'secundaria'],
        ];
    }

    /**
     * Asigna al estudiante la sección con menos alumnos del grado que corresponde.
     */
    private function asignarGradoAlEstudiante(\App\Models\Estudiante $estudiante): void
    {
        $mapa = self::mapaGrados();
        $gradoStr = trim($estudiante->grado ?? '');

        if (!isset($mapa[$gradoStr])) {
            return;
        }

        [$numero, $nivel] = $mapa[$gradoStr];

        // Buscar grado con menos estudiantes para ese nivel+numero
        $gradoElegido = \App\Models\Grado::where('nivel', $nivel)
            ->where('numero', $numero)
            ->where('activo', true)
            ->withCount('estudiantes')
            ->orderBy('estudiantes_count')
            ->first();

        if (!$gradoElegido) {
            return;
        }

        $estudiante->update([
            'grado_id' => $gradoElegido->id,
            'seccion'  => $gradoElegido->seccion,
        ]);
    }
}
