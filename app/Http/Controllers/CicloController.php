<?php

namespace App\Http\Controllers;

// app/Http/Controllers/CicloController.php

use App\Models\Ciclo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CicloController extends Controller
{
    public function index()
    {
        $ciclos = Ciclo::orderBy('created_at', 'desc')->paginate(10);

        return view('ciclos.index', compact('ciclos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('ciclos.create');
    }

    /**
     * Guardar un nuevo ciclo
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre'  => 'required|string|max:50|unique:ciclos,nombre',
            'seccion' => 'required|string|max:100',
            'jornada' => 'required|string|in:matutina,vespertina,nocturna,fin de semana',
        ]);

        Ciclo::create($validated);

        return redirect()->route('ciclos.index')
            ->with('success', 'Ciclo creado exitosamente.');
    }

    /**
     * Mostrar detalle de un ciclo
     */
    public function show(Ciclo $ciclo)
    {
        return view('ciclos.show', compact('ciclo'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Ciclo $ciclo)
    {
        return view('ciclos.edit', compact('ciclo'));
    }

    /**
     * Actualizar un ciclo existente
     */
    public function update(Request $request, Ciclo $ciclo): RedirectResponse
    {
        $validated = $request->validate([
            'nombre'  => 'required|string|max:50|unique:ciclos,nombre,' . $ciclo->id,
            'seccion' => 'required|string|max:100',
            'jornada' => 'required|string|in:matutina,vespertina,nocturna,fin de semana',
        ]);

        $ciclo->update($validated);

        return redirect()->route('ciclos.index')
            ->with('success', 'Ciclo actualizado exitosamente.');
    }

    /**
     * Eliminar un ciclo
     */
    public function destroy(Ciclo $ciclo): RedirectResponse
    {
        // Verificar si el ciclo tiene relaciones antes de eliminar
        // Si tu modelo Ciclo tiene relaciones (ej: estudiantes, materias),
        // descomenta el bloque siguiente:
        // if ($ciclo->estudiantes()->count() > 0) {
        //     return redirect()->route('ciclos.index')
        //         ->with('error', 'No se puede eliminar el ciclo porque tiene estudiantes asignados.');
        // }

        $ciclo->delete();

        return redirect()->route('ciclos.index')
            ->with('success', 'Ciclo eliminado exitosamente.');
    }
}