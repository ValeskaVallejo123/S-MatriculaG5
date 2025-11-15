<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Padre;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    /**
     * Listado de matrículas
     */
    public function index()
    {
        $matriculas = Matricula::with(['estudiante', 'padre'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $counts = [
            'total' => Matricula::count(),
            'pendiente' => Matricula::where('estado', 'pendiente')->count(),
            'aprobada' => Matricula::where('estado', 'aprobada')->count(),
            'rechazada' => Matricula::where('estado', 'rechazada')->count(),
        ];

        return view('matriculas.index', compact('matriculas', 'counts'));
    }

    /**
     * Formulario para crear matrícula
     */
    public function create()
    {
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();

        $parentescos = [
            'madre' => 'Madre',
            'padre' => 'Padre',
            'tutor' => 'Tutor Legal',
            'abuelo' => 'Abuelo(a)',
            'tio' => 'Tio(a)',
            'hermano' => 'Hermano(a)',
            'otro' => 'Otro'
        ];

        return view('matriculas.create', compact('grados', 'secciones', 'parentescos'));
    }

    /**
     * Guardar nueva matrícula
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Padre / Tutor
            'padre_nombre' => 'required|string|min:2|max:50',
            'padre_apellido' => 'required|string|min:2|max:50',
            'padre_dni' => 'required|string|size:13|unique:padres,dni',
            'padre_parentesco' => 'required|string|in:padre,madre,tutor,abuelo,otro',
            'padre_parentesco_otro' => 'nullable|required_if:padre_parentesco,otro|string|max:50',
            'padre_email' => 'nullable|email|max:100',
            'padre_telefono' => 'required|string|min:8|max:15',
            'padre_direccion' => 'required|string|max:255',

            // Estudiante
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
        ]);

        try {
            DB::beginTransaction();

            // Crear Padre
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
                ->withErrors(['error' => 'Error al guardar la matrícula: ' . $e->getMessage()]);
        }
    }

    /**
     * Mostrar detalles de matrícula
     */
    public function show(Matricula $matricula)
    {
        $matricula->load(['estudiante', 'padre']);
        return view('matriculas.show', compact('matricula'));
    }

    /**
     * Formulario para editar
     */
    public function edit(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();

        return view('matriculas.edit', compact('matricula', 'grados', 'secciones'));
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
                ->withErrors(['error' => 'Error al actualizar matrícula: ' . $e->getMessage()]);
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
                ->withErrors(['error' => 'Error al eliminar matrícula: ' . $e->getMessage()]);
        }
    }

    /**
     * Aprobar matrícula
     */
    public function confirmar(Matricula $matricula)
    {
        if ($matricula->estado !== 'pendiente') {
            return back()->withErrors(['error' => 'Estado no válido para aprobar.']);
        }

        $matricula->update(['estado' => 'aprobada']);

        return back()->with('success', 'Matrícula aprobada.');
    }

    /**
     * Rechazar matrícula
     */
    public function rechazar(Request $request, Matricula $matricula)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500'
        ]);

        if ($matricula->estado !== 'pendiente') {
            return back()->withErrors(['error' => 'Estado no válido para rechazar.']);
        }

        $matricula->update([
            'estado' => 'rechazada',
            'observaciones' => $request->motivo_rechazo
        ]);

        return back()->with('success', 'Matrícula rechazada.');
    }

    /**
     * Cancelar matrícula
     */
    public function cancelar(Matricula $matricula)
    {
        $matricula->update(['estado' => 'cancelada']);

        return back()->with('success', 'Matrícula cancelada.');
    }
}
