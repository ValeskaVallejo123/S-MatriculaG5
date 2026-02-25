<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class MatriculaController extends Controller
{
    // ── Grados disponibles (definidos una sola vez) ──────────────────────────
    // CORRECCIÓN: el original los repetía en create() y edit() por separado.
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
                $q->where('nombre1',   'like', "%{$buscar}%")
                  ->orWhere('apellido1', 'like', "%{$buscar}%")
                  ->orWhere('dni',       'like', "%{$buscar}%");
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

        // CORRECCIÓN: las estadísticas se calculan sobre TODA la tabla,
        // no sobre la página actual, así que son correctas. Se agrupan
        // en una sola consulta para evitar 3 queries separadas.
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

    public function create(Request $request)
    {
        // CORRECCIÓN: el original cargaba Estudiante::all() y Padre::all()
        // que en producción puede ser miles de registros. Solo se necesitan
        // si la vista tiene selects de esos modelos; se mantiene pero se
        // advierte que deberían cargarse con búsqueda AJAX en producción.
        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $padres      = Padre::orderBy('nombre')->get();
        $grados      = self::GRADOS;
        $parentescos = self::PARENTESCOS;

        // Ruta pública → vista sin sidebar
        if ($request->routeIs('matriculas.public.create')) {
            return view('matriculas.create-public', compact(
                'estudiantes', 'padres', 'parentescos', 'grados'
            ));
        }

        return view('matriculas.create', compact(
            'estudiantes', 'padres', 'parentescos', 'grados'
        ));
    }

    // ────────────────────────────────────────────────────────────────────────
    // STORE
    // ────────────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $esPublico = $request->is('matricula-publica') || $request->boolean('publico');

        $validated = $request->validate([
            // Padre/Tutor
            'padre_nombre'             => 'required|string|min:2|max:50',
            'padre_apellido'           => 'required|string|min:2|max:50',
            'padre_dni'                => 'required|string|max:13',
            'padre_parentesco'         => 'required|in:padre,madre,otro',
            'padre_parentesco_otro'    => 'nullable|required_if:padre_parentesco,otro|string|max:50',
            'padre_email'              => 'nullable|email|max:100|unique:users,email',
            'padre_telefono'           => 'required|string|min:8|max:15',
            'padre_direccion'          => 'required|string|max:255',
            // Estudiante
            'estudiante_nombre'        => 'required|string|min:2|max:100',
            'estudiante_apellido'      => 'required|string|min:2|max:100',
            'estudiante_dni'           => 'required|string|max:13|unique:estudiantes,dni',
            'estudiante_fecha_nacimiento' => 'required|date|before:today',
            'estudiante_sexo'          => 'required|in:masculino,femenino',
            'estudiante_email'         => 'nullable|email|max:100',
            'estudiante_telefono'      => 'nullable|string|max:15',
            'estudiante_direccion'     => 'nullable|string|max:255',
            'estudiante_grado'         => 'required|string|max:20',
            // Matrícula
            'anio_lectivo'             => 'required|digits:4|integer|min:2020|max:2100',
            'estado'                   => 'nullable|in:pendiente,aprobada,rechazada,cancelada',
            'observaciones'            => 'nullable|string|max:500',
            // Documentos
            'foto_perfil'              => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'calificaciones'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'acta_nacimiento'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // CORRECCIÓN: el original verificaba el DNI del estudiante dentro
        // del try/catch con una query manual, pero ya se puede hacer con
        // la regla unique en la validación de arriba. Se eliminó la
        // verificación duplicada que llamaba DB::rollBack() innecesariamente.

        try {
            DB::beginTransaction();

            // ── Padre ────────────────────────────────────────────────────
            $padre = Padre::where('dni', $validated['padre_dni'])->first();

            // Solo en matrícula admin: bloquear si ya existe el padre
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

            // ── Usuario padre (solo matrícula pública con email) ─────────
            if ($esPublico && !empty($validated['padre_email'])) {
                $usuarioExistente = User::where('email', $validated['padre_email'])->first();

                if ($usuarioExistente) {
                    DB::table('users')
                        ->where('id', $usuarioExistente->id)
                        ->update(['user_type' => 'padre', 'activo' => 1, 'id_rol' => 5]);
                } else {
                    $rolPadre = Rol::firstOrCreate(
                        ['nombre' => 'Padre'],
                        ['descripcion' => 'Rol para padres de familia']
                    );

                    User::create([
                        'name'              => $validated['padre_nombre'] . ' ' . $validated['padre_apellido'],
                        'email'             => $validated['padre_email'],
                        // CORRECCIÓN: usar el DNI como contraseña inicial es débil
                        // pero aceptable si se fuerza cambio en primer login.
                        // Se documenta explícitamente.
                        'password'          => Hash::make($validated['padre_dni']),
                        'id_rol'            => $rolPadre->id,
                        'user_type'         => 'padre',
                        'activo'            => 1,
                        'email_verified_at' => now(),
                        'permissions'       => json_encode([
                            'ver_calificaciones' => true,
                            'ver_asistencias'    => true,
                        ]),
                    ]);
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
            // CORRECCIÓN: el original contaba por año de created_at, lo que
            // generaba códigos incorrectos si se crea en diciembre para el
            // año lectivo siguiente. Se cuenta por anio_lectivo.
            $conteo          = Matricula::where('anio_lectivo', $validated['anio_lectivo'])->count();
            $codigoMatricula = 'MAT-' . $validated['anio_lectivo'] . '-' . str_pad($conteo + 1, 4, '0', STR_PAD_LEFT);

            // ── Matrícula ────────────────────────────────────────────────
            $matricula = Matricula::create([
                'padre_id'        => $padre->id,
                'estudiante_id'   => $estudiante->id,
                'codigo_matricula'=> $codigoMatricula,
                'anio_lectivo'    => $validated['anio_lectivo'],
                'fecha_matricula' => now()->format('Y-m-d'),
                'estado'          => $esPublico ? 'pendiente' : ($validated['estado'] ?? 'pendiente'),
                'observaciones'   => $esPublico
                    ? 'Matrícula registrada desde el portal público'
                    : ($validated['observaciones'] ?? null),
            ]);

            // ── Documentos ───────────────────────────────────────────────
            // CORRECCIÓN: el original guardaba rutas en $documentosRutas
            // pero el update estaba comentado — los archivos se subían al
            // storage pero las rutas NUNCA se guardaban en la BD.
            // Se descomenta y corrige la actualización.
            $documentosRutas = [];

            $archivosDoc = [
                'foto_perfil'    => 'documentos_matriculas/fotos',
                'calificaciones' => 'documentos_matriculas/calificaciones',
                'acta_nacimiento'=> 'documentos_matriculas/actas',
            ];

            foreach ($archivosDoc as $campo => $carpeta) {
                if ($request->hasFile($campo)) {
                    $archivo     = $request->file($campo);
                    $nombreArch  = $campo . '_' . $estudiante->id . '_' . time()
                                 . '.' . $archivo->getClientOriginalExtension();
                    $documentosRutas[$campo] = $archivo->storeAs($carpeta, $nombreArch, 'public');
                }
            }

            if (!empty($documentosRutas)) {
                $matricula->update($documentosRutas);
            }

            DB::commit();

            if ($esPublico) {
                return redirect()->route('matriculas.success')
                    ->with('success',  '¡Matrícula registrada exitosamente!')
                    ->with('codigo',   $codigoMatricula)
                    ->with('email',    $validated['padre_email'] ?? null)
                    ->with('identidad',$validated['padre_dni'])
                    ->with('estado',   'pendiente');
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
        // CORRECCIÓN: si el usuario entra directamente a /matriculas/exito
        // sin haber completado una matrícula, no hay datos en sesión.
        // Se redirige al portal en ese caso.
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

        // CORRECCIÓN: el original no verificaba si estudiante o padre eran null,
        // lo que lanzaba un error 500 si la relación estaba rota.
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
                'codigo'           => $matricula->codigo_matricula,
                'anio_lectivo'     => $matricula->anio_lectivo,
                'fecha_matricula'  => Carbon::parse($matricula->fecha_matricula)->format('d/m/Y'),
                'estado'           => $matricula->estado,
                'observaciones'    => $matricula->observaciones,
            ],
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────
    // SHOW
    // ────────────────────────────────────────────────────────────────────────

    public function show(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);
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
        $validated = $request->validate([
            'anio_lectivo'    => 'required|digits:4|integer|min:2020|max:2100',
            'fecha_matricula' => 'required|date',
            'estado'          => 'required|in:pendiente,aprobada,rechazada,cancelada',
            'motivo_rechazo'  => 'nullable|string|max:500',
            'observaciones'   => 'nullable|string|max:1000',
        ]);

        // CORRECCIÓN: el original envolvía un simple update() en
        // DB::beginTransaction() sin necesidad. Un update de un solo
        // modelo no necesita transacción.
        $matricula->update($validated);

        return redirect()->route('matriculas.show', $matricula->id)
            ->with('success', 'Matrícula actualizada correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // DESTROY
    // ────────────────────────────────────────────────────────────────────────

    public function destroy(Matricula $matricula)
    {
        // CORRECCIÓN: mismo problema, transacción innecesaria para
        // un solo delete. Se simplificó.
        $matricula->delete();

        return redirect()->route('matriculas.index')
            ->with('success', 'Matrícula eliminada correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // CAMBIOS DE ESTADO
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Aprobar matrícula.
     * CORRECCIÓN: el original solo permitía aprobar si estado era 'pendiente'.
     * Se mantiene esa restricción pero se agrega mensaje más claro.
     */
    public function confirmar(Matricula $matricula)
    {
        if ($matricula->estado !== 'pendiente') {
            return back()->withErrors([
                'error' => "No se puede aprobar una matrícula con estado '{$matricula->estado}'.",
            ]);
        }

        $matricula->update(['estado' => 'aprobada']);

        return back()->with('success', 'Matrícula aprobada correctamente.');
    }

    /**
     * Rechazar matrícula.
     */
    public function rechazar(Request $request, Matricula $matricula)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500',
        ]);

        if ($matricula->estado !== 'pendiente') {
            return back()->withErrors([
                'error' => "No se puede rechazar una matrícula con estado '{$matricula->estado}'.",
            ]);
        }

        $matricula->update([
            'estado'         => 'rechazada',
            'motivo_rechazo' => $request->motivo_rechazo,
        ]);

        return back()->with('success', 'Matrícula rechazada correctamente.');
    }

    /**
     * Cancelar matrícula.
     * CORRECCIÓN: el original no verificaba el estado actual antes de cancelar,
     * permitiendo cancelar matrículas ya rechazadas o ya canceladas.
     */
    public function cancelar(Matricula $matricula)
    {
        if (in_array($matricula->estado, ['cancelada', 'rechazada'])) {
            return back()->withErrors([
                'error' => "No se puede cancelar una matrícula con estado '{$matricula->estado}'.",
            ]);
        }

        $matricula->update(['estado' => 'cancelada']);

        return back()->with('success', 'Matrícula cancelada correctamente.');
    }
}
