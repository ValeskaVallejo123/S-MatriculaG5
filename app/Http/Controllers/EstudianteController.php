<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::latest()->paginate(10);
        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();
        return view('estudiantes.create', compact('grados', 'secciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
           'email' => 'nullable|email|unique:estudiantes,email',
            'telefono' => 'nullable|string|max:20',
            'dni' => 'required|string|unique:estudiantes,dni',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'nullable|string',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'estado' => 'required|in:activo,inactivo',
            'observaciones' => 'nullable|string',
        ]);

        Estudiante::create($validated);

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante creado exitosamente');
    }

    public function show(Estudiante $estudiante)
    {
        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante)
    {
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();
        return view('estudiantes.edit', compact('estudiante', 'grados', 'secciones'));
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'nullable|email|unique:estudiantes,email,' . $estudiante->id,
            'telefono' => 'nullable|string|max:20',
            'dni' => 'required|string|unique:estudiantes,dni,' . $estudiante->id,
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'nullable|string',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'estado' => 'required|in:activo,inactivo',
            'observaciones' => 'nullable|string',
        ]);

        $estudiante->update($validated);

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante actualizado exitosamente');
    }

    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante eliminado exitosamente');
    }
}