<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Documento;
use App\Models\Estudiante;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EstudianteController extends Controller
{
    /* ============================================================
       MIDDLEWARE DE PERMISOS
    ============================================================ */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->routeIs('estudiante.historial')) {
                return $next($request);
            }

            if (!Auth::check() || !in_array(Auth::user()->id_rol, [1, 2])) {
                abort(403, 'No tienes permisos para gestionar estudiantes.');
            }

            return $next($request);
        });
    }

    /* ============================================================
       HELPERS PRIVADOS
    ============================================================ */

    /**
     * Normaliza texto para generar emails institucionales.
     */
    private function normalizarTexto(string $texto): string
    {
        $texto  = mb_strtolower($texto, 'UTF-8');
        $buscar = ['á','é','í','ó','ú','ñ','ü'];
        $reempl = ['a','e','i','o','u','n','u'];
        $texto  = str_replace($buscar, $reempl, $texto);
        return preg_replace('/[^a-z]/', '', $texto);
    }

    /**
     * Genera un nombre de archivo seguro (UUID + extensión validada).
     */
    private function nombreSeguro(\Illuminate\Http\UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $ext = in_array($ext, ['jpg', 'jpeg', 'png', 'pdf']) ? $ext : 'bin';
        return Str::uuid() . '.' . $ext;
    }

    /**
     * Genera email institucional único para el estudiante.
     */
    private function generarEmailUnico(string $nombre1, string $apellido1): string
    {
        $n     = $this->normalizarTexto($nombre1);
        $a     = $this->normalizarTexto($apellido1);
        $base  = $n . '.' . $a;
        $email = $base . '@egm.edu.hn';
        $count = 1;

        while (
            Estudiante::where('email', $email)->exists() ||
            User::where('email', $email)->exists()
        ) {
            $email = $base . $count . '@egm.edu.hn';
            $count++;
        }

        return $email;
    }

    /**
     * Reglas de validación para store y update.
     * En update se excluye el propio ID del unique de DNI/email.
     */
    private function reglasValidacion(?int $estudianteId = null): array
    {
        $dniUnique   = 'unique:estudiantes,dni'   . ($estudianteId ? ",{$estudianteId}" : '');
        $emailUnique = 'unique:estudiantes,email' . ($estudianteId ? ",{$estudianteId}" : '');

        return [
            'nombre1'          => ['required', 'string', 'min:2', 'max:50',
                                   'regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/u'],
            'nombre2'          => ['nullable', 'string', 'min:2', 'max:50',
                                   'regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/u'],
            'apellido1'        => ['required', 'string', 'min:2', 'max:50',
                                   'regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/u'],
            'apellido2'        => ['nullable', 'string', 'min:2', 'max:50',
                                   'regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/u'],
            'dni'              => ['required', 'string',
                                   'size:13',
                                   'regex:/^\d{13}$/',
                                   $dniUnique],
            'fecha_nacimiento' => ['required', 'date',
                                   'before:' . now()->subYears(4)->toDateString(),
                                   'after:'  . now()->subYears(20)->toDateString()],
            'sexo'             => ['required', 'in:masculino,femenino'],
            'email'            => ['nullable', 'email:rfc', 'max:100',
                                   $emailUnique,
                                   'unique:users,email' . ($estudianteId ? ",{$estudianteId},user_id" : '')],
            'telefono'         => ['nullable', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'direccion'        => ['nullable', 'string', 'max:200'],
            'grado'            => ['required', 'string', 'in:' . implode(',', Estudiante::grados())],
            'seccion'          => ['required', 'string', 'in:' . implode(',', Estudiante::secciones())],
            'estado'           => ['required', 'in:activo,inactivo,retirado,suspendido'],
            'observaciones'    => ['nullable', 'string', 'max:500'],
            'foto'             => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    private function mensajesValidacion(): array
    {
        return [
            'nombre1.required'          => 'El primer nombre es obligatorio.',
            'nombre1.regex'             => 'El primer nombre solo puede contener letras.',
            'nombre2.regex'             => 'El segundo nombre solo puede contener letras.',
            'apellido1.required'        => 'El primer apellido es obligatorio.',
            'apellido1.regex'           => 'El primer apellido solo puede contener letras.',
            'apellido2.regex'           => 'El segundo apellido solo puede contener letras.',
            'dni.required'              => 'El DNI es obligatorio.',
            'dni.size'                  => 'El DNI debe tener exactamente 13 dígitos.',
            'dni.regex'                 => 'El DNI solo puede contener números (13 dígitos).',
            'dni.unique'                => 'Este DNI ya está registrado en el sistema.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before'   => 'El estudiante debe tener al menos 4 años.',
            'fecha_nacimiento.after'    => 'El estudiante no puede tener más de 20 años.',
            'sexo.required'             => 'El género es obligatorio.',
            'sexo.in'                   => 'El género seleccionado no es válido.',
            'email.email'               => 'El correo electrónico no tiene un formato válido.',
            'email.unique'              => 'Este correo ya está registrado en el sistema.',
            'telefono.regex'            => 'El teléfono debe tener el formato 9999-9999.',
            'grado.required'            => 'El grado es obligatorio.',
            'grado.in'                  => 'El grado seleccionado no es válido.',
            'seccion.required'          => 'La sección es obligatoria.',
            'seccion.in'                => 'La sección seleccionada no es válida.',
            'estado.required'           => 'El estado es obligatorio.',
            'estado.in'                 => 'El estado seleccionado no es válido.',
            'observaciones.max'         => 'Las observaciones no pueden superar los 500 caracteres.',
            'foto.image'                => 'La foto debe ser una imagen (JPG o PNG).',
            'foto.max'                  => 'La foto no puede superar los 2 MB.',
        ];
    }

    /* ============================================================
       LISTAR ESTUDIANTES
    ============================================================ */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50]) ? $perPage : 10;

        $estudiantes = Estudiante::orderBy('apellido1')
            ->orderBy('apellido2')
            ->orderBy('nombre1')
            ->orderBy('nombre2')
            ->paginate($perPage)
            ->withQueryString();

        $totalEstudiantes = Estudiante::count();
        $totalActivos     = Estudiante::where('estado', 'activo')->count();
        $totalInactivos   = Estudiante::where('estado', '!=', 'activo')->count();
        $nuevosHoy        = Estudiante::whereDate('created_at', today())->count();

        return view('estudiantes.index', compact(
            'estudiantes',
            'totalEstudiantes',
            'totalActivos',
            'totalInactivos',
            'nuevosHoy'
        ));
    }

    /* ============================================================
       BUSCAR ESTUDIANTES
    ============================================================ */
    public function buscar(Request $request)
    {
        $nombre  = strip_tags(trim($request->input('nombre', '')));
        $dni     = strip_tags(trim($request->input('dni', '')));
        $grado   = $request->input('grado');
        $estado  = $request->input('estado');

        $estadosPermitidos = ['activo', 'inactivo', 'retirado', 'suspendido'];
        if ($estado && !in_array($estado, $estadosPermitidos)) {
            $estado = null;
        }

        $busquedaRealizada = $nombre || $dni || $grado || $estado;

        $estudiantes = Estudiante::when($nombre, function ($q) use ($nombre) {
                $q->where(function ($sub) use ($nombre) {
                    $sub->where('nombre1',   'like', "%{$nombre}%")
                        ->orWhere('nombre2',   'like', "%{$nombre}%")
                        ->orWhere('apellido1', 'like', "%{$nombre}%")
                        ->orWhere('apellido2', 'like', "%{$nombre}%")
                        ->orWhereRaw("CONCAT(nombre1, ' ', apellido1) LIKE ?", ["%{$nombre}%"])
                        ->orWhereRaw("CONCAT(nombre1, ' ', nombre2, ' ', apellido1, ' ', apellido2) LIKE ?", ["%{$nombre}%"]);
                });
            })
            ->when($dni,    fn($q) => $q->where('dni',    'like', "%{$dni}%"))
            ->when($grado,  fn($q) => $q->where('grado',  'like', "%{$grado}%"))
            ->when($estado, fn($q) => $q->where('estado', $estado))
            ->orderBy('apellido1')
            ->orderBy('nombre1')
            ->paginate(15)
            ->appends($request->only(['nombre', 'dni', 'grado', 'estado']));

        return view('estudiantes.buscar', compact('estudiantes', 'busquedaRealizada'));
    }

    /* ============================================================
       CONSULTA PÚBLICA
    ============================================================ */
    public function consultarPublico(Request $request)
    {
        $dni = strip_tags(trim($request->input('dni', '')));

        $estudiante = null;
        if (preg_match('/^\d{4}-\d{4}-\d{5}$/', $dni)) {
            $estudiante = Estudiante::where('dni', $dni)->first();
        }

        return view('publico.consultar-estudiante', compact('estudiante', 'dni'));
    }

    /* ============================================================
       FORMULARIO DE CREACIÓN
    ============================================================ */
    public function create()
    {
        $grados    = Estudiante::grados();
        $secciones = Estudiante::secciones();

        return view('estudiantes.create', compact('grados', 'secciones'));
    }

    /* ============================================================
       GUARDAR ESTUDIANTE
    ============================================================ */
    public function store(Request $request)
    {
        $reglas = array_merge($this->reglasValidacion(), [
            'acta_nacimiento' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'calificaciones'  => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $mensajes = array_merge($this->mensajesValidacion(), [
            'acta_nacimiento.required' => 'El acta de nacimiento es obligatoria.',
            'acta_nacimiento.max'      => 'El acta de nacimiento no puede superar los 5 MB.',
            'calificaciones.required'  => 'Las calificaciones anteriores son obligatorias.',
            'calificaciones.max'       => 'Las calificaciones no pueden superar los 5 MB.',
        ]);

        $validated = $request->validate($reglas, $mensajes);

        $nombre1       = strip_tags(trim($validated['nombre1']));
        $nombre2       = isset($validated['nombre2'])       ? strip_tags(trim($validated['nombre2']))       : null;
        $apellido1     = strip_tags(trim($validated['apellido1']));
        $apellido2     = isset($validated['apellido2'])     ? strip_tags(trim($validated['apellido2']))     : null;
        $direccion     = isset($validated['direccion'])     ? strip_tags(trim($validated['direccion']))     : null;
        $observaciones = isset($validated['observaciones']) ? strip_tags(trim($validated['observaciones'])) : null;
        $estado        = $validated['estado'] ?? 'activo';

        $email = !empty($validated['email'])
            ? strtolower(trim($validated['email']))
            : $this->generarEmailUnico($nombre1, $apellido1);

        $fotoPath           = null;
        $actaPath           = null;
        $calificacionesPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')
                ->storeAs('estudiantes/fotos', $this->nombreSeguro($request->file('foto')), 'public');
        }

        if ($request->hasFile('acta_nacimiento')) {
            $actaPath = $request->file('acta_nacimiento')
                ->storeAs('documentos/actas', $this->nombreSeguro($request->file('acta_nacimiento')), 'public');
        }

        if ($request->hasFile('calificaciones')) {
            $calificacionesPath = $request->file('calificaciones')
                ->storeAs('documentos/calificaciones', $this->nombreSeguro($request->file('calificaciones')), 'public');
        }

        $estudiante = Estudiante::create([
            'nombre1'          => $nombre1,
            'nombre2'          => $nombre2,
            'apellido1'        => $apellido1,
            'apellido2'        => $apellido2,
            'dni'              => $validated['dni'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'sexo'             => $validated['sexo'],
            'email'            => $email,
            'telefono'         => $validated['telefono'] ?? null,
            'direccion'        => $direccion,
            'grado'            => $validated['grado'],
            'seccion'          => $validated['seccion'],
            'estado'           => $estado,
            'observaciones'    => $observaciones,
            'foto'             => $fotoPath,
        ]);

        Documento::create([
            'estudiante_id'   => $estudiante->id,
            'foto'            => $fotoPath,
            'acta_nacimiento' => $actaPath,
            'calificaciones'  => $calificacionesPath,
        ]);

        $passwordPlain = 'egm2025';

        $rolEstudiante = DB::table('roles')
            ->whereIn('nombre', ['Estudiante', 'estudiante', 'student'])
            ->first();

        $usuario = User::updateOrCreate(
            ['email' => $email],
            [
                'name'      => trim("{$nombre1} {$apellido1}"),
                'password'  => Hash::make($passwordPlain),
                'id_rol'    => $rolEstudiante?->id ?? 5,
                'user_type' => 'estudiante',
                'activo'    => 1,
            ]
        );

        $estudiante->update(['user_id' => $usuario->id]);

        return redirect()
            ->route('estudiantes.show', $estudiante->id)
            ->with('success', 'Estudiante "' . e("{$nombre1} {$apellido1}") . '" registrado correctamente. Correo: ' . e($email) . ' | Contraseña inicial: egm2025');
    }

    /* ============================================================
       VER DETALLE DE ESTUDIANTE
    ============================================================ */
    public function show(Estudiante $estudiante)
    {
        $estudiante->load('padre');
        return view('estudiantes.show', compact('estudiante'));
    }

    /* ============================================================
       FORMULARIO DE EDICIÓN
    ============================================================ */
    public function edit(Estudiante $estudiante)
    {
        $grados    = Estudiante::grados();
        $secciones = Estudiante::secciones();

        return view('estudiantes.edit', compact('estudiante', 'grados', 'secciones'));
    }

    /* ============================================================
       ACTUALIZAR ESTUDIANTE
    ============================================================ */
    public function update(Request $request, Estudiante $estudiante)
    {
        $validated = $request->validate(
            $this->reglasValidacion($estudiante->id),
            $this->mensajesValidacion()
        );

        $data = [
            'nombre1'          => strip_tags(trim($validated['nombre1'])),
            'nombre2'          => isset($validated['nombre2'])       ? strip_tags(trim($validated['nombre2']))       : null,
            'apellido1'        => strip_tags(trim($validated['apellido1'])),
            'apellido2'        => isset($validated['apellido2'])     ? strip_tags(trim($validated['apellido2']))     : null,
            'dni'              => $validated['dni'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'sexo'             => $validated['sexo'],
            'email'            => isset($validated['email']) ? strtolower(trim($validated['email'])) : $estudiante->email,
            'telefono'         => $validated['telefono'] ?? null,
            'direccion'        => isset($validated['direccion'])     ? strip_tags(trim($validated['direccion']))     : null,
            'grado'            => $validated['grado'],
            'seccion'          => $validated['seccion'],
            'estado'           => $validated['estado'],
            'observaciones'    => isset($validated['observaciones']) ? strip_tags(trim($validated['observaciones'])) : null,
        ];

        if ($request->hasFile('foto')) {
            if ($estudiante->foto && Storage::disk('public')->exists($estudiante->foto)) {
                Storage::disk('public')->delete($estudiante->foto);
            }
            $data['foto'] = $request->file('foto')
                ->storeAs('estudiantes/fotos', $this->nombreSeguro($request->file('foto')), 'public');
        }

        $estudiante->update($data);

        return redirect()
            ->route('estudiantes.show', $estudiante->id)
            ->with('success', 'Estudiante actualizado correctamente.');
    }

    /* ============================================================
       ELIMINAR ESTUDIANTE
    ============================================================ */
    public function destroy(Estudiante $estudiante)
    {
        if ($estudiante->foto && Storage::disk('public')->exists($estudiante->foto)) {
            Storage::disk('public')->delete($estudiante->foto);
        }

        if ($estudiante->documentos) {
            $docs = $estudiante->documentos;

            foreach (['foto','acta_nacimiento','calificaciones','tarjeta_identidad_padre','constancia_medica'] as $campo) {
                if ($docs->$campo && Storage::disk('public')->exists($docs->$campo)) {
                    Storage::disk('public')->delete($docs->$campo);
                }
            }

            $docs->delete();
        }

        $estudiante->delete();

        return redirect()
            ->route('estudiantes.index')
            ->with('success', 'Estudiante eliminado correctamente.');
    }

    /* ============================================================
       NOTIFICACIONES DEL ESTUDIANTE
    ============================================================ */
    public function notificaciones($id)
    {
        $estudiante     = Estudiante::findOrFail($id);
        $notificaciones = Notificacion::where('estudiante_id', $estudiante->id)
            ->orderByDesc('created_at')
            ->get();

        return view('estudiantes.notificaciones', compact('estudiante', 'notificaciones'));
    }

    /* ============================================================
       MARCAR NOTIFICACIÓN COMO LEÍDA
    ============================================================ */
    public function marcarLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update(['leida' => true]);

        return back()->with('success', 'Notificación marcada como leída.');
    }
    /* ============================================================
       HISTORIAL — VISTA ESTUDIANTE (Solo Lectura)
    ============================================================ */
    public function historial()
    {
        $user = auth()->user();

        $estudiante = Estudiante::with(['calificaciones.materia', 'calificaciones.periodo'])
            ->where('email', $user->email)
            ->first();

        if (!$estudiante) {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'No se encontró tu perfil de estudiante.');
        }

        $promedio          = $estudiante->calificaciones->avg('nota_final') ?? 0;
        $historialAgrupado = $estudiante->calificaciones
            ->groupBy(fn($n) => $n->periodo->anio_lectivo ?? 'Ciclo Actual');

        return view('historial.show', compact('estudiante', 'historialAgrupado', 'promedio'))
            ->with('readonly', true);
    }

    /* ============================================================
       HISTORIAL — VISTA ADMIN (Lectura)
    ============================================================ */
    public function verHistorialAdmin($id)
    {
        $estudiante = Estudiante::with(['calificaciones.materia', 'calificaciones.periodo'])
            ->findOrFail($id);

        $promedio          = $estudiante->calificaciones->avg('nota_final') ?? 0;
        $historialAgrupado = $estudiante->calificaciones
            ->groupBy(fn($n) => $n->periodo->anio_lectivo ?? 'Ciclo Actual');

        return view('historial.show', compact('estudiante', 'historialAgrupado', 'promedio'))
            ->with('readonly', false);
    }

    /* ============================================================
       HISTORIAL — FORMULARIO DE EDICIÓN (Admin)
    ============================================================ */
    public function editHistorialAdmin($id)
    {
        $estudiante = Estudiante::with([
            'calificaciones.materia',
            'calificaciones.periodo',
        ])->findOrFail($id);

        return view('historial.edit', compact('estudiante'));
    }

    /* ============================================================
       HISTORIAL — GUARDAR CAMBIOS (Admin)
    ============================================================ */
    public function updateHistorialAdmin(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        // Validar estructura anidada: notas[calificacion_id][p1|p2|p3]
        $request->validate([
            'notas'      => ['required', 'array'],
            'notas.*.p1' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'notas.*.p2' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'notas.*.p3' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ], [
            'notas.required'     => 'Debes enviar al menos una nota.',
            'notas.*.p1.numeric' => 'El 1er parcial debe ser un número.',
            'notas.*.p2.numeric' => 'El 2do parcial debe ser un número.',
            'notas.*.p3.numeric' => 'El 3er parcial debe ser un número.',
            'notas.*.p1.min'     => 'Las notas no pueden ser menores a 0.',
            'notas.*.p1.max'     => 'Las notas no pueden ser mayores a 100.',
            'notas.*.p2.min'     => 'Las notas no pueden ser menores a 0.',
            'notas.*.p2.max'     => 'Las notas no pueden ser mayores a 100.',
            'notas.*.p3.min'     => 'Las notas no pueden ser menores a 0.',
            'notas.*.p3.max'     => 'Las notas no pueden ser mayores a 100.',
        ]);

        $cambiosRealizados = false;

        foreach ($request->notas as $calificacionId => $parciales) {
            // Validar que el ID sea un entero real (evitar manipulación)
            if (!ctype_digit((string) $calificacionId)) {
                continue;
            }

            $calificacion = Calificacion::find((int) $calificacionId);

            // Verificar que la calificación pertenece al estudiante correcto
            if (!$calificacion || $calificacion->estudiante_id != $estudiante->id) {
                continue;
            }

            $p1 = isset($parciales['p1']) && $parciales['p1'] !== '' ? (float) $parciales['p1'] : null;
            $p2 = isset($parciales['p2']) && $parciales['p2'] !== '' ? (float) $parciales['p2'] : null;
            $p3 = isset($parciales['p3']) && $parciales['p3'] !== '' ? (float) $parciales['p3'] : null;

            // Calcular nota final como promedio de los parciales con valor
            $conValor  = array_filter([$p1, $p2, $p3], fn($v) => !is_null($v));
            $notaFinal = count($conValor) > 0
                ? round(array_sum($conValor) / count($conValor), 2)
                : $calificacion->nota_final;

            // Solo guardar si hubo cambios reales
            if (
                $calificacion->primer_parcial  != $p1 ||
                $calificacion->segundo_parcial != $p2 ||
                $calificacion->tercer_parcial  != $p3
            ) {
                $calificacion->update([
                    'primer_parcial'  => $p1,
                    'segundo_parcial' => $p2,
                    'tercer_parcial'  => $p3,
                    'nota_final'      => $notaFinal,
                ]);
                $cambiosRealizados = true;
            }
        }

        if ($cambiosRealizados) {
            return redirect()
                ->route('superadmin.estudiantes.historial.show', $id)
                ->with('success', 'Calificaciones actualizadas correctamente.');
        }

        return redirect()
            ->route('superadmin.estudiantes.historial.show', $id)
            ->with('info', 'No se realizaron cambios en el historial académico.');
    }
}