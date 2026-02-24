<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Seccion;
use Illuminate\Http\Request;
use App\Models\Estudiante;

class SeccionController extends Controller
{
    /**
     * Mostrar listado de secciones
     */
   // ... dentro de SeccionController ...

public function index()
{
    // Cargamos relaciones en español: estudiante y seccion
    $inscripciones = Matricula::with(['estudiante', 'seccion'])->get();
    $secciones = Seccion::all();
    $alumnos = Estudiante::all();

    return view('secciones.index', compact('inscripciones', 'secciones', 'alumnos'));
}

/**
 * Método para procesar el formulario de la vista
 */
public function asignar(Request $request)
{
    $validated = $request->validate([
        'estudiante_id' => 'required|exists:estudiantes,id',
        'seccion_id' => 'required|exists:secciones,id',
    ]);

    // Buscamos la matrícula de ese estudiante (asumiendo que ya existe una)
    $matricula = Matricula::where('estudiante_id', $request->estudiante_id)->first();

    if (!$matricula) {
        return back()->with('error', 'El estudiante no tiene una matrícula activa.');
    }

    $matricula->update([
        'seccion_id' => $request->seccion_id
    ]);

    return redirect()->route('secciones.index')->with('success', 'Sección asignada correctamente.');
}

    /**
     * Mostrar formulario para crear una sección
     */
    public function create()
    {
        return view('secciones.create');
    }

    /**
     * Guardar una nueva sección
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
        ]);

        Seccion::create($validated);

        return redirect()
            ->route('secciones.index')
            ->with('success', 'La sección fue creada correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Seccion $seccion)
    {
        $secciones = Seccion::all();
        return view('secciones.edit', compact('seccion'));
    }

    /**
     * Actualizar una sección
     */
    public function update(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
        ]);

        $seccion->update($validated);

        return redirect()
            ->route('secciones.index')
            ->with('success', 'La sección fue actualizada correctamente.');
    }

    /**
     * Eliminar una sección
     */
    public function destroy(Seccion $seccion)
    {
        if ($seccion->matriculas()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar una sección con alumnos inscritos.');
        }

        $seccion->delete();

        return redirect()
            ->route('secciones.index')
            ->with('success', 'La sección fue eliminada correctamente.');
    }
}