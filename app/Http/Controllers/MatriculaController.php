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
            $q->where('nombre', 'like', "%{$buscar}%")
              ->orWhere('apellido', 'like', "%{$buscar}%")
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
        $estudiantes = Estudiante::orderBy('nombre', 'asc')->get();
        $padres = Padre::orderBy('nombre', 'asc')->get();

        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'tutor' => 'Tutor/a',
            'abuelo' => 'Abuelo/a',
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
        $validated = $request->validate([
            // Validación del Padre/Tutor
            'padre_nombre' => 'required|string|min:2|max:50',
            'padre_apellido' => 'required|string|min:2|max:50',
            'padre_dni' => 'required|string|size:13|unique:padres,dni',
            'padre_parentesco' => 'required|string|in:padre,madre,tutor,abuelo,otro',
            'padre_parentesco_otro' => 'nullable|required_if:padre_parentesco,otro|string|max:50',
            'padre_email' => 'nullable|email|max:100',
            'padre_telefono' => 'required|string|min:8|max:15',
            'padre_direccion' => 'required|string|max:255',

            // Validación del Estudiante
            'estudiante_nombre' => 'required|string|min:2|max:50',
            'estudiante_apellido' => 'required|string|min:2|max:50',
            'estudiante_dni' => 'required|string|size:13|unique:estudiantes,dni',
            'estudiante_fecha_nacimiento' => 'required|date|before:today',
            'estudiante_sexo' => 'required|in:masculino,femenino',
            'estudiante_email' => 'nullable|email|max:100',
            'estudiante_telefono' => 'nullable|string|max:15',
            'estudiante_direccion' => 'nullable|string|max:255',
            'estudiante_grado' => 'required|string|max:20',
            'estudiante_seccion' => 'required|string|size:1',

            // Matrícula
            'anio_lectivo' => 'required|digits:4|min:2020|max:2099',
            'estado' => 'nullable|in:pendiente,aprobada,rechazada,cancelada',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'padre_dni.unique' => 'Ya existe un padre/tutor registrado con este DNI.',
            'estudiante_dni.unique' => 'Ya existe un estudiante registrado con este DNI.',
            'padre_parentesco_otro.required_if' => 'Especifique el tipo de parentesco.',
            'estudiante_fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
        ]);

        try {
            DB::beginTransaction();

            // Crear Padre/Tutor
            $padre = Padre::create([
                'nombre' => $validated['padre_nombre'],
                'apellido' => $validated['padre_apellido'],
                'dni' => $validated['padre_dni'],
                'parentesco' => $validated['padre_parentesco'] === 'otro'
                    ? $validated['padre_parentesco_otro']
                    : $validated['padre_parentesco'],
                'email' => $validated['padre_email'] ?? null,
                'telefono' => $validated['padre_telefono'],
                'direccion' => $validated['padre_direccion'],
            ]);

            // Crear Estudiante
            $estudiante = Estudiante::create([
                'nombre' => $validated['estudiante_nombre'],
                'apellido' => $validated['estudiante_apellido'],
                'dni' => $validated['estudiante_dni'],
                'fecha_nacimiento' => $validated['estudiante_fecha_nacimiento'],
                'sexo' => $validated['estudiante_sexo'],
                'email' => $validated['estudiante_email'] ?? null,
                'telefono' => $validated['estudiante_telefono'] ?? null,
                'direccion' => $validated['estudiante_direccion'] ?? null,
                'grado' => $validated['estudiante_grado'],
                'seccion' => $validated['estudiante_seccion'],
                'estado' => 'activo',
            ]);

            // Crear Matrícula
            Matricula::create([
                'padre_id' => $padre->id,
                'estudiante_id' => $estudiante->id,
                'grado' => $validated['estudiante_grado'],
                'seccion' => $validated['estudiante_seccion'],
                'anio_lectivo' => $validated['anio_lectivo'],
                'estado' => $validated['estado'] ?? 'pendiente',
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula creada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Ocurrió un error al guardar la matrícula: ' . $e->getMessage()]);
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

        $estudiantes = Estudiante::orderBy('nombre', 'asc')->get();
        $padres = Padre::orderBy('nombre', 'asc')->get();

        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'tutor' => 'Tutor/a',
            'abuelo' => 'Abuelo/a',
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

        return view('matriculas.edit', compact('matricula', 'estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
    }

    /**
     * Actualizar matrícula
     */
    public function update(Request $request, Matricula $matricula)
    {
        $validated = $request->validate([
            'padre_id' => 'required|exists:padres,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'grado' => 'required|string|max:20',
            'seccion' => 'required|string|size:1',
            'anio_lectivo' => 'required|digits:4|min:2020|max:2099',
            'estado' => 'required|in:pendiente,aprobada,rechazada,cancelada',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'anio_lectivo.digits' => 'El año lectivo debe tener 4 dígitos.',
            'anio_lectivo.min' => 'El año lectivo no puede ser menor a 2020.',
            'anio_lectivo.max' => 'El año lectivo no puede ser mayor a 2099.',
        ]);

        try {
            DB::beginTransaction();

            $matricula->update($validated);

            DB::commit();

            return redirect()->route('matriculas.index')
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
                    'observaciones' => $request->motivo_rechazo
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
