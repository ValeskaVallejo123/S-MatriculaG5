<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     */
    public function create()
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

        return view('matriculas.create', compact('estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
    }

    /**
     * Guardar nueva matrícula
     */
  public function store(Request $request)
{
    // Validar los datos
    $validated = $request->validate([
        // Validación del Padre/Tutor
        'padre_nombre' => 'required|string|min:2|max:50',
        'padre_apellido' => 'required|string|min:2|max:50',
        'padre_dni' => 'nullable|string|max:13',
        'padre_parentesco' => 'required|string|in:padre,madre,tutor_legal,abuelo,abuela,tio,tia,otro',
        'padre_parentesco_otro' => 'nullable|required_if:padre_parentesco,otro|string|max:50',
        'padre_email' => 'nullable|email|max:100',
        'padre_telefono' => 'required|string|min:8|max:15',
        'padre_direccion' => 'required|string|max:255',

        // Validación del Estudiante
        'estudiante_nombre' => 'required|string|min:2|max:100',
        'estudiante_apellido' => 'required|string|min:2|max:100',
        'estudiante_dni' => 'nullable|string|max:13',
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
    ]);

    try {
        DB::beginTransaction();

        // Verificar si el padre ya existe por DNI
        if (!empty($validated['padre_dni'])) {
            $padreExistente = Padre::where('dni', $validated['padre_dni'])->first();
            if ($padreExistente) {
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

        // Crear Padre/Tutor
        $padre = Padre::create([
            'nombre' => $validated['padre_nombre'],
            'apellido' => $validated['padre_apellido'],
            'dni' => $validated['padre_dni'] ?? null,
            'parentesco' => $validated['padre_parentesco'] === 'otro'
                ? ($validated['padre_parentesco_otro'] ?? 'otro')
                : $validated['padre_parentesco'],
            'correo' => $validated['padre_email'] ?? null,
            'telefono' => $validated['padre_telefono'],
            'direccion' => $validated['padre_direccion'],
            'estado' => 1,
        ]);

        // Separar nombre y apellido del estudiante
$nombreCompleto = explode(' ', trim($validated['estudiante_nombre']), 2);
$apellidoCompleto = explode(' ', trim($validated['estudiante_apellido']), 2);

// Asegurar que siempre haya valores
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
    'dni' => $validated['estudiante_dni'] ?? null,
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
            'estado' => $validated['estado'] ?? 'pendiente',
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        DB::commit();

        return redirect()->route('matriculas.index')
            ->with('success', 'Matrícula registrada exitosamente con código: ' . $codigoMatricula);

   } catch (\Illuminate\Database\QueryException $e) {
    DB::rollBack();

    dd([
        'TIPO' => 'Error de Base de Datos',
        'MENSAJE' => $e->getMessage(),
        'SQL' => $e->getSql(),
        'LINEA' => $e->getLine(),
    ]);

} catch (\Exception $e) {
    DB::rollBack();

    dd([
        'TIPO' => 'Error General',
        'MENSAJE' => $e->getMessage(),
        'ARCHIVO' => $e->getFile(),
        'LINEA' => $e->getLine(),
        'TRACE' => $e->getTraceAsString(),
    ]);
}
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
        ], [
            'anio_lectivo.digits' => 'El año lectivo debe tener 4 dígitos.',
            'anio_lectivo.min' => 'El año lectivo debe ser 2020 o posterior.',
            'anio_lectivo.max' => 'El año lectivo no puede ser mayor a 2100.',
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

