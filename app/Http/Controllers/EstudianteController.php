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
            'unique:estudiantes,email',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
        ],
        'telefono' => [
            'nullable',
            'string',
            'regex:/^[0-9]{8}$/' // 8 dígitos para Honduras
        ],
        'dni' => [
            'required',
            'string',
            'regex:/^[0-9]{13}$/', // 13 dígitos para Honduras
            'unique:estudiantes,dni'
        ],
        'fecha_nacimiento' => [
            'required',
            'date',
            'before:today',
            'after:' . now()->subYears(25)->format('Y-m-d') // Máximo 25 años
        ],
        'direccion' => 'nullable|string|max:200',
        'grado' => 'required|string',
        'seccion' => 'required|string|size:1', // Una letra
        'estado' => 'required|in:activo,inactivo',
        'observaciones' => 'nullable|string|max:500',
    ], [
        // Nombre
        'nombre.required' => 'El nombre es obligatorio',
        'nombre.min' => 'El nombre debe tener al menos 2 caracteres',
        'nombre.max' => 'El nombre no puede exceder 50 caracteres',
        'nombre.regex' => 'El nombre solo puede contener letras y espacios',
        
        // Apellido
        'apellido.required' => 'El apellido es obligatorio',
        'apellido.min' => 'El apellido debe tener al menos 2 caracteres',
        'apellido.max' => 'El apellido no puede exceder 50 caracteres',
        'apellido.regex' => 'El apellido solo puede contener letras y espacios',
        
        // Email
        'email.email' => 'Debe ser un email válido',
        'email.unique' => 'Este email ya está registrado',
        'email.max' => 'El email no puede exceder 100 caracteres',
        
        // Teléfono
        'telefono.regex' => 'El teléfono debe tener exactamente 8 dígitos',
        
        // DNI
        'dni.required' => 'El DNI es obligatorio',
        'dni.regex' => 'El DNI debe tener exactamente 13 dígitos',
        'dni.unique' => 'Este DNI ya está registrado',
        
        // Fecha de nacimiento
        'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
        'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',
        'fecha_nacimiento.after' => 'El estudiante no puede tener más de 25 años',
        
        // Dirección
        'direccion.max' => 'La dirección no puede exceder 200 caracteres',
        
        // Grado
        'grado.required' => 'El grado es obligatorio',
        
        // Sección
        'seccion.required' => 'La sección es obligatoria',
        'seccion.size' => 'La sección debe ser una sola letra',
        
        // Estado
        'estado.required' => 'El estado es obligatorio',
        'estado.in' => 'El estado debe ser activo o inactivo',
        
        // Observaciones
        'observaciones.max' => 'Las observaciones no pueden exceder 500 caracteres',
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
    $grados = ['1° Grado', '2° Grado', '3° Grado', '4° Grado', '5° Grado', '6° Grado', '7° Grado', '8° Grado', '9° Grado'];
    $secciones = ['A', 'B', 'C', 'D'];
    
    return view('estudiantes.edit', compact('estudiante', 'grados', 'secciones'));
}

   public function update(Request $request, Estudiante $estudiante)
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
            'unique:estudiantes,email,' . $estudiante->id,
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
            'unique:estudiantes,dni,' . $estudiante->id
        ],
        'fecha_nacimiento' => [
            'required',
            'date',
            'before:today',
            'after:' . now()->subYears(25)->format('Y-m-d')
        ],
        'direccion' => 'nullable|string|max:200',
        'grado' => 'required|string',
        'seccion' => 'required|string|size:1',
        'estado' => 'required|in:activo,inactivo',
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
        'fecha_nacimiento.after' => 'El estudiante no puede tener más de 25 años',
        
        'direccion.max' => 'La dirección no puede exceder 200 caracteres',
        
        'grado.required' => 'El grado es obligatorio',
        
        'seccion.required' => 'La sección es obligatoria',
        'seccion.size' => 'La sección debe ser una sola letra',
        
        'estado.required' => 'El estado es obligatorio',
        'estado.in' => 'El estado debe ser activo o inactivo',
        
        'observaciones.max' => 'Las observaciones no pueden exceder 500 caracteres',
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