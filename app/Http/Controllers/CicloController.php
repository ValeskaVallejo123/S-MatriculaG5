<?php

namespace App\Http\Controllers;

use App\Models\Ciclo;
use Illuminate\Http\Request;

class CicloController extends Controller
{
    // ============================================
    // MÉTODOS PARA ADMINISTRADOR
    // ============================================
    
    /**
     * Mostrar lista de ciclos (ADMIN - Con botones de acción)
     */
    public function index()
    {
        $ciclos = Ciclo::paginate(2);
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
     * Guardar nuevo ciclo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'seccion' => 'nullable|string|max:50',
            'maestro' => 'nullable|string|max:255',
            'jornada' => 'nullable|string|in:Matutina,Vespertina',
        ]);

        Ciclo::create($validated);

        return redirect()->route('ciclos.index')
            ->with('success', 'Ciclo creado exitosamente.');
    }

    /**
     * Mostrar detalle de un ciclo (ADMIN)
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
     * Actualizar ciclo existente
     */
    public function update(Request $request, Ciclo $ciclo)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'seccion' => 'nullable|string|max:50',
            'maestro' => 'nullable|string|max:255',
            'jornada' => 'nullable|string|in:Matutina,Vespertina',
        ]);

        $ciclo->update($validated);

        return redirect()->route('ciclos.index')
            ->with('success', 'Ciclo actualizado exitosamente.');
    }

    /**
     * Eliminar ciclo
     */
    public function destroy(Ciclo $ciclo)
    {
        $ciclo->delete();

        return redirect()->route('ciclos.index')
            ->with('success', 'Ciclo eliminado exitosamente.');
    }

    // ============================================
    // MÉTODOS PARA PÚBLICO
    // ============================================
    
    /**
     * Mostrar lista de ciclos (PÚBLICO - Solo lectura)
     */
    public function indexPublico()
    {
        $ciclos = Ciclo::paginate(2);
        return view('/ciclos.index', compact('ciclos'));
    }

    /**
     * Mostrar detalle de un ciclo (PÚBLICO - Solo lectura)
     */
    // app/Http/Controllers/CicloController.php

public function showPublico($id)
{
    // 1. Busca el ciclo por su ID. 
    //    Si no lo encuentra, Laravel lanzará automáticamente un 404.
    $ciclo = Ciclo::findOrFail($id); 

    // 2. Ahora que $ciclo está definido, puedes pasarlo a la vista.
    $ciclo = Ciclo::findOrFail($id);
    return view('ciclos.publico.show', compact('ciclo'));
}
}