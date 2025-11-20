<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CalificacionController extends BaseController
{
    // ============================================
    // MÉTODOS PRIVADOS (requieren autenticación)
    // ============================================
    
    public function __construct()
    {
        // Proteger todas las rutas excepto las públicas
        $this->middleware('auth')->except(['indexPublico', 'showPublico']);
    }

    // Vista privada con todas las funcionalidades
    public function index()
    {
        $calificaciones = Calificacion::paginate(15);
        return view('calificaciones.index', compact('calificaciones'));
    }

    public function create()
    {
        return view('calificaciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_alumno' => 'required|string|max:255',
            'primer_parcial' => 'nullable|numeric|min:0|max:100',
            'segundo_parcial' => 'nullable|numeric|min:0|max:100',
            'tercer_parcial' => 'nullable|numeric|min:0|max:100',
            'cuarto_parcial' => 'nullable|numeric|min:0|max:100',
            'recuperacion' => 'nullable|numeric|min:0|max:100',
        ]);

        Calificacion::create($validated);

        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación registrada exitosamente');
    }

    public function show($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        return view('calificaciones.show', compact('calificacion'));
    }

    public function edit($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        return view('calificaciones.edit', compact('calificacion'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_alumno' => 'required|string|max:255',
            'primer_parcial' => 'nullable|numeric|min:0|max:100',
            'segundo_parcial' => 'nullable|numeric|min:0|max:100',
            'tercer_parcial' => 'nullable|numeric|min:0|max:100',
            'cuarto_parcial' => 'nullable|numeric|min:0|max:100',
            'recuperacion' => 'nullable|numeric|min:0|max:100',
        ]);

        $calificacion = Calificacion::findOrFail($id);
        $calificacion->update($validated);

        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación actualizada exitosamente');
    }

    public function destroy($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $calificacion->delete();

        return redirect()->route('calificaciones.index')
            ->with('success', 'Calificación eliminada exitosamente');
    }

    // ============================================
    // MÉTODOS PÚBLICOS (sin autenticación)
    // ============================================

    // Vista pública - Solo lectura
    public function indexPublico()
    {
        $calificaciones = Calificacion::paginate(15);
        return view('calificaciones.index-publico', compact('calificaciones'));
    }

    // Detalle público - Solo lectura
    public function showPublico($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        return view('calificaciones.show-publico', compact('calificacion'));
    }
}