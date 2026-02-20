<?php

namespace App\Http\Controllers;

// app/Http/Controllers/CicloController.php

use App\Models\Ciclo;
use Illuminate\Http\Request;

class CicloController extends Controller
{
    public function index()
    {
        $ciclos = Ciclo::orderBy('created_at', 'desc')->paginate(10);
        return view('ciclos.index', compact('ciclos'));
    }

    public function create()
    {
        return view('ciclos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'seccion' => 'required|string|max:100',
            'jornada' => 'required|string|max:50',
        ]);

        Ciclo::create($validated);

        return redirect()->route('ciclos.index')
            ->with('success', 'Ciclo creado exitosamente.');
    }

    public function show(Ciclo $ciclo)
    {
        return view('ciclos.show', compact('ciclo'));
    }

    public function edit(Ciclo $ciclo)
    {
        return view('ciclos.edit', compact('ciclo'));
    }

    public function update(Request $request, Ciclo $ciclo)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'seccion' => 'required|string|max:100',
            'jornada' => 'required|string|max:50',
        ]);

        $ciclo->update($validated);

        return redirect()->route('ciclos.index')
            ->with('success', 'Ciclo actualizado exitosamente.');
    }

    public function destroy(Ciclo $ciclo)
    {
        $ciclo->delete();

        return redirect()->route('ciclos.index')
            ->with('success', 'Ciclo eliminado exitosamente.');
    }
}