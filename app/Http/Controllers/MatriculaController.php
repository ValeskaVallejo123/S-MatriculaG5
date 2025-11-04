<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    // Listado de matrículas
    public function index()
    {
        $matriculas = Matricula::with(['padre', 'estudiante'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Estadísticas agrupadas en un arreglo
        $counts = [
            'total' => Matricula::count(),
            'pendiente' => Matricula::where('estado', 'pendiente')->count(),
            'aprobada' => Matricula::where('estado', 'aprobada')->count(),
            'rechazada' => Matricula::where('estado', 'rechazada')->count(),
        ];

        return view('matriculas.index', compact('matriculas'));
    }

    // Formulario para crear matrícula
    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre', 'asc')->get();
        $padres = Padre::orderBy('nombre', 'asc')->get();

        $parentescos = ['padre' => 'Padre', 'madre' => 'Madre', 'tutor' => 'Tutor', 'otro' => 'Otro'];
        $grados = ['1ro', '2do', '3ro', '4to', '5to', '6to'];
        $secciones = ['A', 'B', 'C', 'D'];

        return view('matriculas.create', compact('estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
    }

    // Guardar matrícula
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Validación del Padre/Tutor
            'padre_nombre' => 'required|string|max:50',
            'padre_apellido' => 'required|string|max:50',
            'padre_dni' => 'required|string|size:13',
            'padre_parentesco' => 'required|string|in:padre,madre,tutor,otro',
            'padre_parentesco_otro' => 'nullable|string|max:50',
            'padre_email' => 'nullable|email|max:100',
            'padre_telefono' => 'required|string|size:8',
            'padre_direccion' => 'required|string|max:255',

            // Validación del Estudiante
            'estudiante_nombre' => 'required|string|max:50',
            'estudiante_apellido' => 'required|string|max:50',
            'estudiante_dni' => 'required|string|size:13',
            'estudiante_fecha_nacimiento' => 'required|date',
            'estudiante_email' => 'nullable|email|max:100',
            'estudiante_telefono' => 'nullable|string|size:8',
            'estudiante_grado' => 'required|string|max:10',
            'estudiante_seccion' => 'required|string|max:2',

            // Matrícula
            'anio_lectivo' => 'required|date_format:Y',
            'estado' => 'required|in:pendiente,aprobada,rechazada,cancelada',
        ]);

        try {
            DB::beginTransaction();

            // Crear Padre/Tutor si no existe
            $padre = Padre::firstOrCreate(
                ['dni' => $validated['padre_dni']],
                [
                    'nombre' => $validated['padre_nombre'],
                    'apellido' => $validated['padre_apellido'],
                    'parentesco' => $validated['padre_parentesco'] === 'otro' ? $validated['padre_parentesco_otro'] : $validated['padre_parentesco'],
                    'email' => $validated['padre_email'] ?? null,
                    'telefono' => $validated['padre_telefono'],
                    'direccion' => $validated['padre_direccion'],
                ]
            );

            // Crear Estudiante si no existe
            $estudiante = Estudiante::firstOrCreate(
                ['dni' => $validated['estudiante_dni']],
                [
                    'nombre' => $validated['estudiante_nombre'],
                    'apellido' => $validated['estudiante_apellido'],
                    'fecha_nacimiento' => $validated['estudiante_fecha_nacimiento'],
                    'email' => $validated['estudiante_email'] ?? null,
                    'telefono' => $validated['estudiante_telefono'] ?? null,
                    'grado' => $validated['estudiante_grado'],
                    'seccion' => $validated['estudiante_seccion'],
                ]
            );

            // Crear matrícula
            Matricula::create([
                'padre_id' => $padre->id,
                'estudiante_id' => $estudiante->id,
                'grado' => $validated['estudiante_grado'],
                'seccion' => $validated['estudiante_seccion'],
                'anio_lectivo' => $validated['anio_lectivo'],
                'estado' => $validated['estado'],
            ]);

            DB::commit();
            return redirect()->route('matriculas.index')->with('success', 'Matrícula creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar la matrícula.']);
        }
    }

    // Mostrar matrícula
    public function show(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);
        return view('matriculas.show', compact('matricula'));
    }

    // Formulario para editar matrícula
    public function edit(Matricula $matricula)
    {
        $estudiantes = Estudiante::orderBy('nombre', 'asc')->get();
        $padres = Padre::orderBy('nombre', 'asc')->get();
        $parentescos = ['padre' => 'Padre', 'madre' => 'Madre', 'tutor' => 'Tutor', 'otro' => 'Otro'];
        $grados = ['1ro', '2do', '3ro', '4to', '5to', '6to'];
        $secciones = ['A', 'B', 'C', 'D'];

        return view('matriculas.edit', compact('matricula', 'estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
    }

    // Actualizar matrícula
    public function update(Request $request, Matricula $matricula)
    {
        $validated = $request->validate([
            'padre_id' => 'required|exists:padres,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'grado' => 'required|string|max:10',
            'seccion' => 'required|string|max:2',
            'anio_lectivo' => 'required|date_format:Y',
            'estado' => 'required|in:pendiente,aprobada,rechazada,cancelada',
        ]);

        try {
            DB::beginTransaction();
            $matricula->update($validated);
            DB::commit();
            return redirect()->route('matriculas.index')->with('success', 'Matrícula actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al actualizar la matrícula.']);
        }
    }

    // Eliminar matrícula
    public function destroy(Matricula $matricula)
    {
        try {
            $matricula->delete();
            return redirect()->route('matriculas.index')->with('success', 'Matrícula eliminada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Ocurrió un error al eliminar la matrícula.']);
        }
    }

    // Confirmar matrícula (Nueva funcionalidad)
    public function confirmar(Matricula $matricula)
    {
        if ($matricula->estado === 'pendiente') {
            $matricula->update(['estado' => 'aprobada']);
            return redirect()->back()->with('success', 'La matrícula se ha confirmado correctamente.');
        }

        return redirect()->back()->with('error', 'Esta matrícula no puede ser confirmada.');
    }
}
