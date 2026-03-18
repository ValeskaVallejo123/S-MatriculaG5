<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Seccion;
use Illuminate\Http\Request;
use App\Models\Estudiante;

class SeccionController extends Controller
{
    public function index()
    {
        // $inscripciones = matrículas con sus relaciones
        // Solo mostramos las aprobadas que tienen estudiante
        $inscripciones = Matricula::with(['estudiante', 'seccion'])
            ->where('estado', 'aprobada')
            ->whereHas('estudiante')
            ->latest()
            ->get();

        // Lista de secciones disponibles para los modales
        $secciones = Seccion::all();

        // Alumnos sin sección asignada aún
        $alumnos = Estudiante::whereDoesntHave('matriculas', function ($q) {
            $q->whereNotNull('seccion_id');
        })->orderBy('nombre1')->get();

        return view('secciones.index', compact('inscripciones', 'secciones', 'alumnos'));
    }

    public function asignar(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'seccion_id'    => 'required|exists:seccion,id', // tabla correcta: 'seccion'
        ]);

        $matricula = Matricula::where('estudiante_id', $request->estudiante_id)
            ->where('estado', 'aprobada')
            ->first();

        if (!$matricula) {
            return back()->with('error', 'El estudiante no tiene una matrícula aprobada.');
        }

        $matricula->update(['seccion_id' => $request->seccion_id]);

        return redirect()->route('secciones.index')
            ->with('success', 'Sección asignada correctamente.');
    }

    public function create()
    {
        return view('secciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
        ]);

        Seccion::create($validated);

        return redirect()->route('secciones.index')
            ->with('success', 'Sección creada correctamente.');
    }

    public function edit(Seccion $seccion)
    {
        return view('secciones.edit', compact('seccion'));
    }

    public function update(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
        ]);

        $seccion->update($validated);

        return redirect()->route('secciones.index')
            ->with('success', 'Sección actualizada correctamente.');
    }

    public function destroy(Seccion $seccion)
    {
        if ($seccion->matriculas()->exists()) {
            return back()->with('error', 'No se puede eliminar una sección con alumnos inscritos.');
        }

        $seccion->delete();

        return redirect()->route('secciones.index')
            ->with('success', 'Sección eliminada correctamente.');
    }
}
