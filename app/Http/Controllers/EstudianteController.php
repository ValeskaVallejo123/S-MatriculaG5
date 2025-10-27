<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Estudiante;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::latest()->paginate(10);
        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
{
    $grados = Estudiante::grados();     // esto llama al método estático del modelo
    $secciones = Estudiante::secciones(); // igual aquí
    return view('estudiantes.create', compact('grados', 'secciones'));
}

    public function store(Request $request)
    {
        // Validación básica para que no falle
        $validated = $request->validate([
            'nombre' => 'required|string|min:2|max:50',
            'apellido' => 'required|string|min:2|max:50',
            'email' => 'nullable|email|max:100|unique:estudiantes,email',
            'telefono' => 'nullable|string|regex:/^[0-9]{8}$/',
            'dni' => 'required|string|regex:/^[0-9]{13}$/|unique:estudiantes,dni',
            'fecha_nacimiento' => 'required|date|before:today',
            'direccion' => 'nullable|string|max:200',
            'grado' => 'required|string',
            'seccion' => 'required|string|size:1',
            'estado' => 'required|in:activo,inactivo',
            'observaciones' => 'nullable|string|max:500',
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
            'nombre' => 'required|string|min:2|max:50',
            'apellido' => 'required|string|min:2|max:50',
            'email' => 'nullable|email|max:100|unique:estudiantes,email,' . $estudiante->id,
            'telefono' => 'nullable|string|regex:/^[0-9]{8}$/',
            'dni' => 'required|string|regex:/^[0-9]{13}$/|unique:estudiantes,dni,' . $estudiante->id,
            'fecha_nacimiento' => 'required|date|before:today',
            'direccion' => 'nullable|string|max:200',
            'grado' => 'required|string',
            'seccion' => 'required|string|size:1',
            'estado' => 'required|in:activo,inactivo',
            'observaciones' => 'nullable|string|max:500',
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
