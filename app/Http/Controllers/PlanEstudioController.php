<?php

namespace App\Http\Controllers;

use App\Models\PlanEstudio;
use App\Models\Centro;
use Illuminate\Http\Request;

class PlanEstudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planes = PlanEstudio::with(['centro', 'clases'])->paginate(10);
        return view('plan_estudio.index', compact('planes'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Cargar el plan con sus clases y centro
        $plan = PlanEstudio::with(['clases', 'centro'])->findOrFail($id);
        return view('plan_estudio.show', compact('plan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centros = Centro::all();
        return view('plan_estudio.create', compact('centros')); // ← CORREGIDO: 'crear' → 'create'
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'nivel_educativo' => 'required|string|max:50',
            'grado' => 'nullable|string|max:50',
            'anio' => 'nullable|integer',
            'duracion' => 'required|integer',
            'jornada' => 'required|string|max:50',
            'fecha_aprobacion' => 'required|date',
            'descripcion' => 'nullable|string',
            'centro_id' => 'required|exists:centros,id',
        ]);

        $plan = PlanEstudio::create($validated);

        return redirect()->route('plan_estudio.index') // ← CAMBIÉ A index para ver la lista
                        ->with('success', 'Plan de estudio creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $plan = PlanEstudio::findOrFail($id);
        $centros = Centro::all();
        return view('plan_estudio.edit', compact('plan', 'centros'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $plan = PlanEstudio::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'nivel_educativo' => 'required|string|max:50',
            'grado' => 'nullable|string|max:50',
            'anio' => 'nullable|integer',
            'duracion' => 'required|integer',
            'jornada' => 'required|string|max:50',
            'fecha_aprobacion' => 'required|date',
            'descripcion' => 'nullable|string',
            'centro_id' => 'required|exists:centros,id',
        ]);

        $plan->update($validated);

        return redirect()->route('plan_estudio.index')
                        ->with('success', 'Plan de estudio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan = PlanEstudio::findOrFail($id);
        $plan->delete();

        return redirect()->route('plan_estudio.index')
                        ->with('success', 'Plan de estudio eliminado exitosamente.');
    }
}