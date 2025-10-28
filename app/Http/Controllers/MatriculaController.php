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
            ->paginate(15);

        return view('matriculas.index');
    }

    // Formulario para crear matrícula
    public function create()
    {
        return view('matriculas.create', $this->obtenerDatosRelacionados());
    }

    // Guardar matrícula
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'padre_id' => 'required|exists:padres,id',
            'grado' => 'required|string|max:10',
            'seccion' => 'required|string|max:2',
            'anio_lectivo' => 'required|date_format:Y',
            'estado' => 'required|in:pendiente,aprobada,rechazada,cancelada',
        ], [
            'estudiante_id.required' => 'Debe seleccionar un estudiante.',
            'padre_id.required' => 'Debe seleccionar un padre o tutor.',
            'grado.required' => 'El campo grado es obligatorio.',
            'seccion.required' => 'El campo sección es obligatorio.',
            'anio_lectivo.required' => 'Debe ingresar el año lectivo en formato válido.',
            'estado.required' => 'Debe seleccionar un estado.',
        ]);

        try {
            DB::beginTransaction();

            Matricula::create($validated);

            DB::commit();

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula creada correctamente.');
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
        return view('matriculas.edit', array_merge(['matricula' => $matricula], $this->obtenerDatosRelacionados()));
    }

    // Actualizar matrícula
    public function update(Request $request, Matricula $matricula)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'padre_id' => 'required|exists:padres,id',
            'grado' => 'required|string|max:10',
            'seccion' => 'required|string|max:2',
            'anio_lectivo' => 'required|date_format:Y',
            'estado' => 'required|in:pendiente,aprobada,rechazada,cancelada',
        ], [
            'estudiante_id.required' => 'Debe seleccionar un estudiante.',
            'padre_id.required' => 'Debe seleccionar un padre o tutor.',
            'grado.required' => 'El campo grado es obligatorio.',
            'seccion.required' => 'El campo sección es obligatorio.',
            'anio_lectivo.required' => 'Debe ingresar el año lectivo en formato válido.',
            'estado.required' => 'Debe seleccionar un estado.',
        ]);

        try {
            DB::beginTransaction();

            $matricula->update($validated);

            DB::commit();

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula actualizada correctamente.');
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

    // Función auxiliar para obtener estudiantes y padres
    private function obtenerDatosRelacionados()
    {
        $estudiantes = Estudiante::orderBy('nombre', 'asc')->get();
        $padres = Padre::orderBy('nombre', 'asc')->get();
        return compact('estudiantes', 'padres');
    }
}

