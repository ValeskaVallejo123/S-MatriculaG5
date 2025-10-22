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
    // Define las opciones para los selects
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
    
    $tipos_contrato = [
        'permanente' => 'Permanente',
        'temporal' => 'Temporal',
        'por_horas' => 'Por Horas'
    ];
    
    return view('profesores.edit', compact('profesor', 'especialidades', 'tipos_contrato'));
}
   public function update(Request $request, Profesor $profesor)
{
    $validated = $request->validate([
        'nombre' => [
            'required',
            'string',
            'min:2',
            'max:50',
            'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
        ],
        'apellido' => [
            'required',
            'string',
            'min:2',
            'max:50',
            'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
        ],
        'email' => [
            'nullable',
            'email',
            'max:100',
            'unique:profesores,email,' . $profesor->id,
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
        ],
        'telefono' => [
            'nullable',
            'string',
            'regex:/^[0-9]{8}$/'
        ],
        'dni' => [
            'required',
            'string',
            'regex:/^[0-9]{13}$/',
            'unique:profesores,dni,' . $profesor->id
        ],
        'fecha_nacimiento' => [
            'required',
            'date',
            'before:today',
            'before:' . now()->subYears(18)->format('Y-m-d')
        ],
        'direccion' => 'nullable|string|max:200',
        'especialidad' => 'required|string|max:100',
        'salario' => 'nullable|numeric|min:0|max:999999.99',
        'tipo_contrato' => 'required|in:tiempo_completo,medio_tiempo,por_horas',
        'fecha_ingreso' => [
            'required',
            'date',
            'before_or_equal:today'
        ],
        'estado' => 'required|in:activo,inactivo,licencia',
        'observaciones' => 'nullable|string|max:500',
    ], [
        'nombre.required' => 'El nombre es obligatorio',
        'nombre.min' => 'El nombre debe tener al menos 2 caracteres',
        'nombre.max' => 'El nombre no puede exceder 50 caracteres',
        'nombre.regex' => 'El nombre solo puede contener letras y espacios',
        
        'apellido.required' => 'El apellido es obligatorio',
        'apellido.min' => 'El apellido debe tener al menos 2 caracteres',
        'apellido.max' => 'El apellido no puede exceder 50 caracteres',
        'apellido.regex' => 'El apellido solo puede contener letras y espacios',
        
        'email.email' => 'Debe ser un email válido',
        'email.unique' => 'Este email ya está registrado',
        'email.max' => 'El email no puede exceder 100 caracteres',
        
        'telefono.regex' => 'El teléfono debe tener exactamente 8 dígitos',
        
        'dni.required' => 'El DNI es obligatorio',
        'dni.regex' => 'El DNI debe tener exactamente 13 dígitos',
        'dni.unique' => 'Este DNI ya está registrado',
        
        'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
        'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',
        
        'direccion.max' => 'La dirección no puede exceder 200 caracteres',
        
        'especialidad.required' => 'La especialidad es obligatoria',
        'especialidad.max' => 'La especialidad no puede exceder 100 caracteres',
        
        'salario.numeric' => 'El salario debe ser un número',
        'salario.min' => 'El salario no puede ser negativo',
        'salario.max' => 'El salario no puede exceder 999,999.99',
        
        'tipo_contrato.required' => 'El tipo de contrato es obligatorio',
        'tipo_contrato.in' => 'Tipo de contrato inválido',
        
        'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria',
        'fecha_ingreso.before_or_equal' => 'La fecha de ingreso no puede ser futura',
        
        'estado.required' => 'El estado es obligatorio',
        'estado.in' => 'Estado inválido',
        
        'observaciones.max' => 'Las observaciones no pueden exceder 500 caracteres',
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