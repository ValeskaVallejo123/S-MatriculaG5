<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index()
    {
        $profesores = Profesor::latest()->paginate(10);
        return view('profesores.index', compact('profesores'));
    }

    public function create()
    {
        $especialidades = Profesor::especialidades();
        $tiposContrato = Profesor::tiposContrato();
        return view('profesores.create', compact('especialidades', 'tiposContrato'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'nullable|email|unique:profesores,email',
            'telefono' => 'nullable|string|max:20',
            'dni' => 'required|string|unique:profesores,dni',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'nullable|string',
            'especialidad' => 'required|string',
            'salario' => 'nullable|numeric|min:0',
            'tipo_contrato' => 'required|in:tiempo_completo,medio_tiempo,por_horas',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:activo,inactivo,licencia',
            'observaciones' => 'nullable|string',
        ]);

        Profesor::create($validated);

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor creado exitosamente');
    }

    public function show(Profesor $profesor)
    {
        return view('profesores.show', compact('profesor'));
    }

    public function edit(Profesor $profesor)
    {
        // Traemos las opciones para los selects
        $especialidades = Profesor::especialidades();
        $tiposContrato = Profesor::tiposContrato();

        return view('profesores.edit', compact('profesor', 'especialidades', 'tiposContrato'));
    }

    public function update(Request $request, Profesor $profesor)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'nullable|email|unique:profesores,email,' . $profesor->id,
            'telefono' => 'nullable|string|max:20',
            'dni' => 'required|string|unique:profesores,dni,' . $profesor->id,
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'nullable|string',
            'especialidad' => 'required|string',
            'salario' => 'nullable|numeric|min:0',
            'tipo_contrato' => 'required|in:tiempo_completo,medio_tiempo,por_horas',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:activo,inactivo,licencia',
            'observaciones' => 'nullable|string',
        ]);

        $profesor->update($validated);

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor actualizado exitosamente');
    }

    public function destroy(Profesor $profesor)
    {
        $profesor->delete();

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor eliminado exitosamente');
    }
}

