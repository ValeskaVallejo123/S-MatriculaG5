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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class MatriculaController extends Controller
{
    /**
     * Listado de matrículas con filtros
     */
    public function index(Request $request)
    {
        $query = Matricula::with(['estudiante', 'padre']);

        // Filtro de búsqueda por nombre, apellido o DNI
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('estudiante', function ($q) use ($buscar) {
                $q->where('nombre1', 'like', "%{$buscar}%")
                  ->orWhere('apellido1', 'like', "%{$buscar}%")
                  ->orWhere('dni', 'like', "%{$buscar}%");
            });
        }

        // Filtro por grado
        if ($request->filled('grado')) {
            $query->whereHas('estudiante', function ($q) use ($request) {
                $q->where('grado', $request->grado);
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por año lectivo
        if ($request->filled('anio')) {
            $query->where('anio_lectivo', $request->anio);
        }

        $matriculas = $query->latest()->paginate(15);

        // Estadísticas generales
        $aprobadas  = Matricula::where('estado', 'aprobada')->count();
        $pendientes = Matricula::where('estado', 'pendiente')->count();
        $rechazadas = Matricula::where('estado', 'rechazada')->count();

        return view('matriculas.index', compact('matriculas', 'aprobadas', 'pendientes', 'rechazadas'));
    }

    /**
     * Formulario de creación (admin o público según ruta)
     */
    public function create(Request $request)
    {
        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $padres      = Padre::orderBy('nombre')->get();

        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'otro'  => 'Otro',
        ];

        $grados = [
            '1er Grado', '2do Grado', '3er Grado',
            '4to Grado', '5to Grado', '6to Grado',
            'I curso',   'II curso',  'III curso',
        ];

        // Ruta pública → vista sin sidebar
        if ($request->route()->getName() === 'matriculas.public.create') {
            return view('matriculas.create-public', compact('estudiantes', 'padres', 'parentescos', 'grados'));
        }

        // Ruta admin → vista con sidebar
        return view('matriculas.create', compact('estudiantes', 'padres', 'parentescos', 'grados'));
    }

    /**
     * Guardar nueva matrícula (admin o pública)
     */
    public function store(Request $request): RedirectResponse
    {
        $esPublico = $request->is('matricula-publica') || $request->has('publico');

        $validated = $request->validate([
            // Padre / Tutor
            'padre_nombre'          => 'required|string|min:2|max:50',
            'padre_apellido'        => 'required|string|min:2|max:50',
            'padre_dni'             => 'required|string|max:13',
            'padre_parentesco'      => 'required|string|in:padre,madre,otro',
            'padre_parentesco_otro' => 'nullable|required_if:padre_parentesco,otro|string|max:50',
            'padre_email'           => 'nullable|email|max:100|unique:users,email',
            'padre_telefono'        => 'required|string|min:8|max:15',
            'padre_direccion'       => 'required|string|max:255',

            // Estudiante
            'estudiante_nombre'           => 'required|string|min:2|max:100',
            'estudiante_apellido'         => 'required|string|min:2|max:100',
            'estudiante_dni'              => 'required|string|max:13',
            'estudiante_fecha_nacimiento' => 'required|date|before:today',
            'estudiante_sexo'             => 'required|in:masculino,femenino',
            'estudiante_email'            => 'nullable|email|max:100',
            'estudiante_telefono'         => 'nullable|string|max:15',
            'estudiante_direccion'        => 'nullable|string|max:255',
            'estudiante_grado'            => 'required|string|max:20',

            // Matrícula
            'anio_lectivo'   => 'required|digits:4|integer|min:2020|max:2100',
            'estado'         => 'nullable|in:pendiente,aprobada,rechazada,cancelada',
            'observaciones'  => 'nullable|string|max:500',

            // Documentos
            'foto_perfil'    => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'calificaciones' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'acta_nacimiento'=> 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // Verificar si el padre ya existe por DNI
            $padreExistente = Padre::where('dni', $validated['padre_dni'])->first();

            if ($padreExistente && !$esPublico) {
                DB::rollBack();
                return back()->withInput()
                    ->withErrors(['padre_dni' => 'Ya existe un padre/tutor con este DNI.']);
            }

            // Verificar si el estudiante ya existe por DNI
            $estudianteExistente = Estudiante::where('dni', $validated['estudiante_dni'])->first();
            if ($estudianteExistente) {
                DB::rollBack();
                return back()->withInput()
                    ->withErrors(['estudiante_dni' => 'Ya existe un estudiante con este DNI.']);
            }

            // Crear o reutilizar padre
            $padre = $padreExistente ?? Padre::create([
                'nombre'     => $validated['padre_nombre'],
                'apellido'   => $validated['padre_apellido'],
                'dni'        => $validated['padre_dni'],
                'parentesco' => $validated['padre_parentesco'] === 'otro'
                    ? ($validated['padre_parentesco_otro'] ?? 'otro')
                    : $validated['padre_parentesco'],
                'correo'    => $validated['padre_email'] ?? null,
                'telefono'  => $validated['padre_telefono'],
                'direccion' => $validated['padre_direccion'],
                'estado'    => 1,
            ]);

            // Crear usuario para el padre si es matrícula pública y tiene email
            if ($esPublico && !empty($validated['padre_email'])) {
                $usuarioExistente = User::where('email', $validated['padre_email'])->first();

                if ($usuarioExistente) {
                    DB::table('users')->where('id', $usuarioExistente->id)->update([
                        'user_type' => 'padre',
                        'activo'    => 1,
                        'id_rol'    => 5,
                    ]);
                } else {
                    $rolPadre = Rol::firstOrCreate(
                        ['nombre' => 'Padre'],
                        ['descripcion' => 'Rol para padres de familia']
                    );

                    User::create([
                        'name'              => $validated['padre_nombre'] . ' ' . $validated['padre_apellido'],
                        'email'             => $validated['padre_email'],
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

            // Separar nombre y apellido del estudiante
            $nombreCompleto  = explode(' ', trim($validated['estudiante_nombre']), 2);
            $apellidoCompleto = explode(' ', trim($validated['estudiante_apellido']), 2);

            $estudiante = Estudiante::create([
                'nombre1'          => $nombreCompleto[0]  ?? 'Sin nombre',
                'nombre2'          => $nombreCompleto[1]  ?? null,
                'apellido1'        => $apellidoCompleto[0] ?? 'Sin apellido',
                'apellido2'        => $apellidoCompleto[1] ?? null,
                'apellido'         => $validated['estudiante_apellido'],
                'dni'              => $validated['estudiante_dni'],
                'fecha_nacimiento' => $validated['estudiante_fecha_nacimiento'],
                'sexo'             => ucfirst($validated['estudiante_sexo']),
                'genero'           => ucfirst($validated['estudiante_sexo']),
                'email'            => $validated['estudiante_email']    ?? null,
                'telefono'         => $validated['estudiante_telefono'] ?? null,
                'direccion'        => $validated['estudiante_direccion'] ?? null,
                'grado'            => $validated['estudiante_grado'],
                'seccion'          => 'X',
                'estado'           => 'activo',
                'padre_id'         => $padre->id,
            ]);

            // Generar código único de matrícula
            $ultimaMatricula = Matricula::whereYear('created_at', date('Y'))->count();
            $codigoMatricula = 'MAT-' . $validated['anio_lectivo'] . '-' . str_pad($ultimaMatricula + 1, 4, '0', STR_PAD_LEFT);

            $matricula = Matricula::create([
                'padre_id'         => $padre->id,
                'estudiante_id'    => $estudiante->id,
                'codigo_matricula' => $codigoMatricula,
                'anio_lectivo'     => $validated['anio_lectivo'],
                'fecha_matricula'  => now()->format('Y-m-d'),
                'estado'           => $esPublico ? 'pendiente' : ($validated['estado'] ?? 'pendiente'),
                'observaciones'    => $esPublico
                    ? 'Matrícula registrada desde el portal público'
                    : ($validated['observaciones'] ?? null),
            ]);

            // Guardar documentos adjuntos
            $documentosRutas = [];
            $archivos = [
                'foto_perfil'    => 'documentos_matriculas/fotos',
                'calificaciones' => 'documentos_matriculas/calificaciones',
                'acta_nacimiento'=> 'documentos_matriculas/actas',
            ];

            foreach ($archivos as $campo => $carpeta) {
                if ($request->hasFile($campo)) {
                    $archivo      = $request->file($campo);
                    $nombreArchivo = "{$campo}_{$estudiante->id}_" . time() . '.' . $archivo->getClientOriginalExtension();
                    $documentosRutas[$campo] = $archivo->storeAs($carpeta, $nombreArchivo, 'public');
                }
            }

            // Si tienes columnas en la tabla matriculas para los documentos:
            // if (!empty($documentosRutas)) {
            //     $matricula->update($documentosRutas);
            // }

            // O si tienes tabla separada de documentos:
            // foreach ($documentosRutas as $tipo => $ruta) {
            //     Documento::create(['matricula_id' => $matricula->id, 'tipo' => $tipo, 'ruta' => $ruta]);
            // }

            DB::commit();

            if ($esPublico) {
                return redirect()->route('matriculas.success')
                    ->with('success', '¡Matrícula registrada exitosamente!')
                    ->with('codigo', $codigoMatricula)
                    ->with('email', $validated['padre_email'] ?? null)
                    ->with('identidad', $validated['padre_dni'])
                    ->with('estado', 'pendiente');
            }

            return redirect()->route('matriculas.index')
                ->with('success', "Matrícula registrada exitosamente con código: {$codigoMatricula}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    /**
     * Página de éxito para matrícula pública
     */
    public function success()
    {
        return view('matriculas.success');
    }

    /**
     * Detalle de matrícula en JSON (para modales)
     */
    public function detalles(Matricula $matricula)
    {
        $matricula->load(['estudiante', 'padre']);

        return response()->json([
            'estudiante' => [
                'nombre_completo' => trim(
                    $matricula->estudiante->nombre1 . ' ' .
                    ($matricula->estudiante->nombre2  ?? '') . ' ' .
                    $matricula->estudiante->apellido1 . ' ' .
                    ($matricula->estudiante->apellido2 ?? '')
                ),
                'dni'             => $matricula->estudiante->dni,
                'fecha_nacimiento'=> Carbon::parse($matricula->estudiante->fecha_nacimiento)->format('d/m/Y'),
                'sexo'            => ucfirst($matricula->estudiante->sexo),
                'grado'           => $matricula->estudiante->grado,
                'seccion'         => $matricula->estudiante->seccion ?? 'Sin asignar',
                'email'           => $matricula->estudiante->email,
                'telefono'        => $matricula->estudiante->telefono,
                'direccion'       => $matricula->estudiante->direccion,
            ],
            'padre' => [
                'nombre_completo' => $matricula->padre->nombre . ' ' . $matricula->padre->apellido,
                'dni'             => $matricula->padre->dni,
                'parentesco'      => ucfirst($matricula->padre->parentesco),
                'correo'          => $matricula->padre->correo,
                'telefono'        => $matricula->padre->telefono,
                'direccion'       => $matricula->padre->direccion,
            ],
            'matricula' => [
                'codigo'          => $matricula->codigo_matricula,
                'anio_lectivo'    => $matricula->anio_lectivo,
                'fecha_matricula' => Carbon::parse($matricula->fecha_matricula)->format('d/m/Y'),
                'observaciones'   => $matricula->observaciones,
            ],
        ]);
    }

    /**
     * Vista de detalle de matrícula
     */
    public function show(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);

        return view('matriculas.show', compact('matricula'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);

        $estudiantes = Estudiante::orderBy('nombre1')->get();
        $padres      = Padre::orderBy('nombre')->get();

        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'otro'  => 'Otro',
        ];

        $grados = [
            '1er Grado', '2do Grado', '3er Grado',
            '4to Grado', '5to Grado', '6to Grado',
            'I curso',   'II curso',  'III curso',
        ];

        return view('matriculas.edit', compact('matricula', 'estudiantes', 'padres', 'parentescos', 'grados'));
    }

    /**
     * Actualizar matrícula
     */
    public function update(Request $request, Matricula $matricula): RedirectResponse
    {
        $validated = $request->validate([
            'anio_lectivo'    => 'required|digits:4|integer|min:2020|max:2100',
            'fecha_matricula' => 'required|date',
            'estado'          => 'required|in:pendiente,aprobada,rechazada,cancelada',
            'motivo_rechazo'  => 'nullable|string|max:500',
            'observaciones'   => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();
            $matricula->update($validated);
            DB::commit();

            return redirect()->route('matriculas.show', $matricula->id)
                ->with('success', 'Matrícula actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Error al actualizar la matrícula: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar matrícula
     */
    public function destroy(Matricula $matricula): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $matricula->delete();
            DB::commit();

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula eliminada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al eliminar la matrícula: ' . $e->getMessage()]);
        }
    }

    /**
     * Aprobar matrícula
     */
    public function confirmar(Matricula $matricula): RedirectResponse
    {
        if ($matricula->estado !== 'pendiente') {
            return back()->withErrors([
                'error' => 'Solo se pueden aprobar matrículas en estado pendiente. Estado actual: ' . $matricula->estado,
            ]);
        }

        try {
            $matricula->update(['estado' => 'aprobada']);

            return back()->with('success', 'La matrícula ha sido aprobada correctamente.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al aprobar la matrícula.']);
        }
    }

    /**
     * Rechazar matrícula
     */
    public function rechazar(Request $request, Matricula $matricula): RedirectResponse
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500',
        ]);

        if ($matricula->estado !== 'pendiente') {
            return back()->withErrors(['error' => 'Solo se pueden rechazar matrículas en estado pendiente.']);
        }

        try {
            $matricula->update([
                'estado'         => 'rechazada',
                'motivo_rechazo' => $request->motivo_rechazo,
            ]);

            return back()->with('success', 'La matrícula ha sido rechazada.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al rechazar la matrícula.']);
        }
    }

    /**
     * Cancelar matrícula
     */
    public function cancelar(Matricula $matricula): RedirectResponse
    {
        try {
            $matricula->update(['estado' => 'cancelada']);

            return back()->with('success', 'La matrícula ha sido cancelada.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cancelar la matrícula.']);
        }
    }

    /**
     * Generar comprobante de matrícula en PDF
     */
    public function generarPDF(Matricula $matricula)
    {
        $matricula->load(['estudiante', 'padre']);

        $pdf = Pdf::loadView('matriculas.pdf', compact('matricula'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("comprobante_matricula_{$matricula->codigo_matricula}.pdf");
    }
}
