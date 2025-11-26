<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class MatriculaController extends Controller
{
    /**
     * Listado de matrículas
     */
    public function index(Request $request)
    {
        $query = Matricula::with(['estudiante', 'padre']);

        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('estudiante', function($q) use ($buscar) {
                $q->where('nombre1', 'like', "%{$buscar}%")
                  ->orWhere('apellido1', 'like', "%{$buscar}%")
                  ->orWhere('dni', 'like', "%{$buscar}%");
            });
        }

        // Filtro por grado
        if ($request->filled('grado')) {
            $query->whereHas('estudiante', function($q) use ($request) {
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

        // Obtener matrículas paginadas
        $matriculas = $query->latest()->paginate(15);

        // Estadísticas
        $aprobadas = Matricula::where('estado', 'aprobada')->count();
        $pendientes = Matricula::where('estado', 'pendiente')->count();
        $rechazadas = Matricula::where('estado', 'rechazada')->count();

        return view('matriculas.index', compact('matriculas', 'aprobadas', 'pendientes', 'rechazadas'));
    }

    /**
     * Formulario para crear matrícula
     * Puede ser accedido desde admin (con sidebar) o público (sin sidebar)
     */
   public function create(Request $request)
{
    $estudiantes = Estudiante::orderBy('nombre1', 'asc')->get();
    $padres = Padre::orderBy('nombre', 'asc')->get();

    $parentescos = [
        'padre' => 'Padre',
        'madre' => 'Madre',
        'tutor_legal' => 'Tutor Legal',
        'abuelo' => 'Abuelo',
        'abuela' => 'Abuela',
        'tio' => 'Tío',
        'tia' => 'Tía',
        'otro' => 'Otro'
    ];

    $grados = [
        '1er Grado',
        '2do Grado',
        '3er Grado',
        '4to Grado',
        '5to Grado',
        '6to Grado'
    ];

    $secciones = ['A', 'B', 'C', 'D'];

    // Si es ruta pública → Vista SIN sidebar
    if ($request->route()->getName() === 'matriculas.public.create') {
        return view('matriculas.create-public', compact('estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
    }

    // Si es ruta admin → Vista CON sidebar
    return view('matriculas.create', compact('estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
}
    /**
     * Guardar nueva matrícula
     * Maneja tanto matrículas admin como públicas
     */
    public function store(Request $request)
    {
        // Detectar si es matrícula pública
        $esPublico = $request->is('matricula-publica') || $request->has('publico');

        // Validar los datos
        $validated = $request->validate([
            // Validación del Padre/Tutor
            'padre_nombre' => 'required|string|min:2|max:50',
            'padre_apellido' => 'required|string|min:2|max:50',
            'padre_dni' => 'required|string|max:13',
            'padre_parentesco' => 'required|string|in:padre,madre,tutor_legal,abuelo,abuela,tio,tia,otro',
            'padre_parentesco_otro' => 'nullable|required_if:padre_parentesco,otro|string|max:50',
            'padre_email' => $esPublico ? 'required|email|max:100|unique:users,email' : 'nullable|email|max:100',
            'padre_telefono' => 'required|string|min:8|max:15',
            'padre_direccion' => 'required|string|max:255',

            // Validación del Estudiante
            'estudiante_nombre' => 'required|string|min:2|max:100',
            'estudiante_apellido' => 'required|string|min:2|max:100',
            'estudiante_dni' => 'required|string|max:13',
            'estudiante_fecha_nacimiento' => 'required|date|before:today',
            'estudiante_sexo' => 'required|in:masculino,femenino',
            'estudiante_email' => 'nullable|email|max:100',
            'estudiante_telefono' => 'nullable|string|max:15',
            'estudiante_direccion' => 'nullable|string|max:255',
            'estudiante_grado' => 'required|string|max:20',
            'estudiante_seccion' => 'required|string|max:1',

            // Matrícula
            'anio_lectivo' => 'required|digits:4|integer|min:2020|max:2100',
            'fecha_matricula' => 'nullable|date',
            'estado' => 'nullable|in:pendiente,aprobada,rechazada,cancelada',
            'observaciones' => 'nullable|string|max:500',

            // Documentos
            'documentos.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB máximo
        ]);

        try {
            DB::beginTransaction();

            // Verificar si el padre ya existe por DNI
            $padreExistente = null;
            if (!empty($validated['padre_dni'])) {
                $padreExistente = Padre::where('dni', $validated['padre_dni'])->first();

                // Si es matrícula admin y el padre ya existe, dar error
                if ($padreExistente && !$esPublico) {
                    DB::rollBack();
                    return back()
                        ->withInput()
                        ->withErrors(['padre_dni' => 'Ya existe un padre/tutor con este DNI.']);
                }
            }

            // Verificar si el estudiante ya existe por DNI
            if (!empty($validated['estudiante_dni'])) {
                $estudianteExistente = Estudiante::where('dni', $validated['estudiante_dni'])->first();
                if ($estudianteExistente) {
                    DB::rollBack();
                    return back()
                        ->withInput()
                        ->withErrors(['estudiante_dni' => 'Ya existe un estudiante con este DNI.']);
                }
            }

            // Crear o usar padre existente
            if ($padreExistente) {
                $padre = $padreExistente;
            } else {
                $padre = Padre::create([
                    'nombre' => $validated['padre_nombre'],
                    'apellido' => $validated['padre_apellido'],
                    'dni' => $validated['padre_dni'],
                    'parentesco' => $validated['padre_parentesco'] === 'otro'
                        ? ($validated['padre_parentesco_otro'] ?? 'otro')
                        : $validated['padre_parentesco'],
                    'correo' => $validated['padre_email'] ?? null,
                    'telefono' => $validated['padre_telefono'],
                    'direccion' => $validated['padre_direccion'],
                    'estado' => 1,
                ]);
            }

            // Si es matrícula pública, crear usuario padre
            if ($esPublico && !empty($validated['padre_email']) && !empty($validated['padre_dni'])) {
                // Verificar que no exista el usuario
                $usuarioExistente = User::where('email', $validated['padre_email'])->first();

                if (!$usuarioExistente) {
                    User::create([
                        'name' => $validated['padre_nombre'] . ' ' . $validated['padre_apellido'],
                        'email' => $validated['padre_email'],
                        'password' => Hash::make($validated['padre_dni']), // Contraseña = DNI
                        'id_rol' => 4, // Rol Padre
                        'email_verified_at' => now(),
                    ]);
                }
            }

            // Separar nombre y apellido del estudiante
            $nombreCompleto = explode(' ', trim($validated['estudiante_nombre']), 2);
            $apellidoCompleto = explode(' ', trim($validated['estudiante_apellido']), 2);

            $nombre1 = !empty($nombreCompleto[0]) ? $nombreCompleto[0] : 'Sin nombre';
            $nombre2 = !empty($nombreCompleto[1]) ? $nombreCompleto[1] : null;
            $apellido1 = !empty($apellidoCompleto[0]) ? $apellidoCompleto[0] : 'Sin apellido';
            $apellido2 = !empty($apellidoCompleto[1]) ? $apellidoCompleto[1] : null;

            // Crear Estudiante
            $estudiante = Estudiante::create([
                'nombre1' => $nombre1,
                'nombre2' => $nombre2,
                'apellido1' => $apellido1,
                'apellido2' => $apellido2,
                'apellido' => $validated['estudiante_apellido'],
                'dni' => $validated['estudiante_dni'],
                'fecha_nacimiento' => $validated['estudiante_fecha_nacimiento'],
                'sexo' => ucfirst($validated['estudiante_sexo']),
                'genero' => ucfirst($validated['estudiante_sexo']),
                'email' => $validated['estudiante_email'] ?? null,
                'telefono' => $validated['estudiante_telefono'] ?? null,
                'direccion' => $validated['estudiante_direccion'] ?? null,
                'grado' => $validated['estudiante_grado'],
                'seccion' => $validated['estudiante_seccion'],
                'estado' => 'activo',
                'padre_id' => $padre->id,
            ]);

            // Generar código de matrícula único
            $ultimaMatricula = Matricula::whereYear('created_at', date('Y'))->count();
            $codigoMatricula = 'MAT-' . $validated['anio_lectivo'] . '-' . str_pad($ultimaMatricula + 1, 4, '0', STR_PAD_LEFT);

            // Crear Matrícula
            $matricula = Matricula::create([
                'padre_id' => $padre->id,
                'estudiante_id' => $estudiante->id,
                'codigo_matricula' => $codigoMatricula,
                'anio_lectivo' => $validated['anio_lectivo'],
                'fecha_matricula' => $validated['fecha_matricula'] ?? now()->format('Y-m-d'),
                'estado' => $esPublico ? 'pendiente' : ($validated['estado'] ?? 'pendiente'),
                'observaciones' => $esPublico
                    ? 'Matrícula registrada desde el portal público'
                    : ($validated['observaciones'] ?? null),
            ]);

            // Manejar documentos si se subieron
            if ($request->hasFile('documentos')) {
                foreach ($request->file('documentos') as $documento) {
                    $nombreArchivo = time() . '_' . $documento->getClientOriginalName();
                    $ruta = $documento->storeAs('documentos_matriculas', $nombreArchivo, 'public');

                    // Aquí puedes guardar la ruta en una tabla de documentos si la tienes
                    // Documento::create([
                    //     'matricula_id' => $matricula->id,
                    //     'nombre' => $documento->getClientOriginalName(),
                    //     'ruta' => $ruta,
                    // ]);
                }
            }

            DB::commit();

            // Redirigir según el tipo de matrícula
            if ($esPublico) {
                return redirect()->route('matriculas.success')
                    ->with('success', '¡Matrícula registrada exitosamente!')
                    ->with('codigo', $codigoMatricula)
                    ->with('email', $validated['padre_email'])
                    ->with('identidad', $validated['padre_dni'])
                    ->with('estado', 'pendiente');
            } else {
                return redirect()->route('matriculas.index')
                    ->with('success', 'Matrícula registrada exitosamente con código: ' . $codigoMatricula);
            }

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
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

public function detalles(Matricula $matricula)
{
    $matricula->load(['estudiante', 'padre']);

    return response()->json([
        'estudiante' => [
            'nombre_completo' => trim($matricula->estudiante->nombre1 . ' ' .
                                ($matricula->estudiante->nombre2 ?? '') . ' ' .
                                $matricula->estudiante->apellido1 . ' ' .
                                ($matricula->estudiante->apellido2 ?? '')),
            'dni' => $matricula->estudiante->dni,
            'fecha_nacimiento' => \Carbon\Carbon::parse($matricula->estudiante->fecha_nacimiento)->format('d/m/Y'),
            'sexo' => ucfirst($matricula->estudiante->sexo),
            'grado' => $matricula->estudiante->grado,
            'seccion' => $matricula->estudiante->seccion,
            'email' => $matricula->estudiante->email,
            'telefono' => $matricula->estudiante->telefono,
            'direccion' => $matricula->estudiante->direccion,
        ],
        'padre' => [
            'nombre_completo' => $matricula->padre->nombre . ' ' . $matricula->padre->apellido,
            'dni' => $matricula->padre->dni,
            'parentesco' => ucfirst($matricula->padre->parentesco),
            'correo' => $matricula->padre->correo,
            'telefono' => $matricula->padre->telefono,
            'direccion' => $matricula->padre->direccion,
        ],
        'matricula' => [
            'codigo' => $matricula->codigo_matricula,
            'anio_lectivo' => $matricula->anio_lectivo,
            'fecha_matricula' => \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y'),
            'observaciones' => $matricula->observaciones,
        ]
    ]);
}

    /**
     * Mostrar detalles de la matrícula
     */
    public function show(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);
        return view('matriculas.show', compact('matricula'));
    }

    /**
     * Formulario para editar matrícula
     */
    public function edit(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);

        $estudiantes = Estudiante::orderBy('nombre1', 'asc')->get();
        $padres = Padre::orderBy('nombre', 'asc')->get();

        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'tutor_legal' => 'Tutor Legal',
            'abuelo' => 'Abuelo',
            'abuela' => 'Abuela',
            'tio' => 'Tío',
            'tia' => 'Tía',
            'otro' => 'Otro'
        ];

        $grados = [
            '1er Grado',
            '2do Grado',
            '3er Grado',
            '4to Grado',
            '5to Grado',
            '6to Grado',
            'I curso',
            'II curso',
            'III curso',
        ];


        $secciones = ['A', 'B', 'C', 'D'];

        return view('matriculas.edit', compact('matricula', 'estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
    }

    /**
     * Actualizar matrícula
     */
    public function update(Request $request, Matricula $matricula)
    {
        $validated = $request->validate([
            'anio_lectivo' => 'required|digits:4|integer|min:2020|max:2100',
            'fecha_matricula' => 'required|date',
            'estado' => 'required|in:pendiente,aprobada,rechazada,cancelada',
            'motivo_rechazo' => 'nullable|string|max:500',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $matricula->update($validated);

            DB::commit();

            return redirect()->route('matriculas.show', $matricula->id)
                ->with('success', 'Matrícula actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Ocurrió un error al actualizar la matrícula: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar matrícula
     */
    public function destroy(Matricula $matricula)
    {
        try {
            DB::beginTransaction();

            $matricula->delete();

            DB::commit();

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula eliminada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Ocurrió un error al eliminar la matrícula: ' . $e->getMessage()]);
        }
    }

    /**
     * Confirmar/Aprobar matrícula
     */
    public function confirmar(Matricula $matricula)
    {
        if ($matricula->estado === 'pendiente') {
            try {
                $matricula->update(['estado' => 'aprobada']);

                return redirect()->back()
                    ->with('success', 'La matrícula ha sido aprobada correctamente.');

            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['error' => 'Error al aprobar la matrícula.']);
            }
        }

        return redirect()->back()
            ->withErrors(['error' => 'Esta matrícula no puede ser confirmada. Estado actual: ' . $matricula->estado]);
    }

    /**
     * Rechazar matrícula
     */
    public function rechazar(Request $request, Matricula $matricula)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500'
        ]);

        if ($matricula->estado === 'pendiente') {
            try {
                $matricula->update([
                    'estado' => 'rechazada',
                    'motivo_rechazo' => $request->motivo_rechazo
                ]);

                return redirect()->back()
                    ->with('success', 'La matrícula ha sido rechazada.');

            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['error' => 'Error al rechazar la matrícula.']);
            }
        }

        return redirect()->back()
            ->withErrors(['error' => 'Esta matrícula no puede ser rechazada.']);
    }

    /**
     * Cancelar matrícula
     */
    public function cancelar(Matricula $matricula)
    {
        try {
            $matricula->update(['estado' => 'cancelada']);

            return redirect()->back()
                ->with('success', 'La matrícula ha sido cancelada.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al cancelar la matrícula.']);
        }
    }
}
