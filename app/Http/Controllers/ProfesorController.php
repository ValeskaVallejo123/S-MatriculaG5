<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    // 🔹 Mostrar todos los profesores
    public function index()
    {
        $profesores = Profesor::latest()->paginate(10);
        return view('profesores.index', compact('profesores'));
    }

    // 🔹 Mostrar formulario de creación
    public function create()
    {
        $especialidades = Profesor::especialidades();
        $tiposContrato = Profesor::tiposContrato();
        return view('profesores.create', compact('especialidades', 'tiposContrato'));
    }

    // 🔹 Guardar nuevo profesor
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

    // 🔹 Mostrar un profesor específico
    public function show(Profesor $profesor)
    {
        return view('profesores.show', compact('profesor'));
    }

    // 🔹 Mostrar formulario de edición
    public function edit(Profesor $profesor)
    {
        $especialidades = [
            'Matemáticas',
            'Español',
            'Ciencias Naturales',
            'Ciencias Sociales',
            'Inglés',
            'Educación Física',
            'Arte',
            'Música',
            'Computación'
        ];

        $tiposContrato = [
            'tiempo_completo' => 'Tiempo Completo',
            'medio_tiempo' => 'Medio Tiempo',
            'por_horas' => 'Por Horas'
        ];

        return view('profesores.edit', compact('profesor', 'especialidades', 'tiposContrato'));
    }

    // 🔹 Actualizar profesor existente
    public function update(Request $request, Profesor $profesor)
    {
        $validated = $request->validate([
            'nombre' => [
                'required', 'string', 'min:2', 'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'apellido' => [
                'required', 'string', 'min:2', 'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'email' => [
                'nullable', 'email', 'max:100',
                'unique:profesores,email,' . $profesor->id
            ],
            'telefono' => ['nullable', 'string', 'regex:/^[0-9]{8}$/'],
            'dni' => [
                'required', 'string', 'regex:/^[0-9]{13}$/',
                'unique:profesores,dni,' . $profesor->id
            ],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'direccion' => 'nullable|string|max:200',
            'especialidad' => 'required|string|max:100',
            'salario' => 'nullable|numeric|min:0|max:999999.99',
            'tipo_contrato' => 'required|in:tiempo_completo,medio_tiempo,por_horas',
            'fecha_ingreso' => ['required', 'date', 'before_or_equal:today'],
            'estado' => 'required|in:activo,inactivo,licencia',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $profesor->update($validated);

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor actualizado exitosamente');
    }

    // 🔹 Eliminar profesor
    public function destroy(Profesor $profesor)
    {
        $profesor->delete();

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor eliminado exitosamente');
    }
}
