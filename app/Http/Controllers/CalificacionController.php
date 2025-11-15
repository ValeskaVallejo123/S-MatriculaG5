<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calificaciones = Calificacion::orderBy('nombre_alumno')->get();
        return view('calificaciones.index', compact('calificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('calificaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_alumno' => 'required|string|max:255',
            'primer_parcial' => 'nullable|numeric|min:0|max:100',
            'segundo_parcial' => 'nullable|numeric|min:0|max:100',
            'tercer_parcial' => 'nullable|numeric|min:0|max:100',
            'cuarto_parcial' => 'nullable|numeric|min:0|max:100',
            'recuperacion' => 'nullable|numeric|min:0|max:100',
        ]);

        $calificacion = Calificacion::create($request->all());
        
        // Calcular nota final automáticamente
        $calificacion->calcularNotaFinal();
        $calificacion->save();

        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Calificacion $calificacion)
    {
        return view('calificaciones.show', compact('calificacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calificacion $calificacion)
    {
        return view('calificaciones.edit', compact('calificacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Calificacion $calificacion)
    {
        $request->validate([
            'nombre_alumno' => 'required|string|max:255',
            'primer_parcial' => 'nullable|numeric|min:0|max:100',
            'segundo_parcial' => 'nullable|numeric|min:0|max:100',
            'tercer_parcial' => 'nullable|numeric|min:0|max:100',
            'cuarto_parcial' => 'nullable|numeric|min:0|max:100',
            'recuperacion' => 'nullable|numeric|min:0|max:100',
        ]);

        $calificacion->update($request->all());
        
        // Recalcular nota final
        $calificacion->calcularNotaFinal();
        $calificacion->save();

        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calificacion $calificacion)
    {
        $calificacion->delete();

        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación eliminada exitosamente.');
    }
}