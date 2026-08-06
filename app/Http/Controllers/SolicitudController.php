<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Estudiante;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SolicitudController extends Controller
{
    /**
     * Mostrar formulario de solicitud
     */
    public function create()
    {
        return view('solicitudes.create');
    }

    /**
     * Guardar nueva solicitud
     */
    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            // Datos del estudiante
            'nombre1' => 'required|string|max:255',
            'nombre2' => 'nullable|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'nullable|string|max:255',
            'dni' => 'required|string|max:20|unique:estudiantes,dni',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:Masculino,Femenino',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            
            // Datos del padre (email opcional)
            'email' => 'nullable|email|max:255',
        ], [
            'nombre1.required' => 'El primer nombre es obligatorio',
            'apellido1.required' => 'El primer apellido es obligatorio',
            'dni.required' => 'El número de identidad es obligatorio',
            'dni.unique' => 'Este número de identidad ya está registrado',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'sexo.required' => 'El sexo es obligatorio',
            'grado.required' => 'El grado es obligatorio',
            'seccion.required' => 'La sección es obligatoria',
            'email.email' => 'El correo electrónico debe ser válido',
        ]);

        try {
            // 1. Crear el estudiante
            $estudiante = Estudiante::create([
                'nombre1' => $validated['nombre1'],
                'nombre2' => $validated['nombre2'] ?? null,
                'apellido1' => $validated['apellido1'],
                'apellido2' => $validated['apellido2'] ?? null,
                'dni' => $validated['dni'],
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
                'sexo' => $validated['sexo'],
                'genero' => $validated['sexo'],
                'grado' => $validated['grado'],
                'seccion' => $validated['seccion'],
                'direccion' => $validated['direccion'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
                'email' => $validated['email'] ?? null,
                'estado' => 'inactivo', // Inactivo hasta que se apruebe
            ]);

            // 2. Generar código único
            $codigo = Solicitud::generarCodigo();

            // 3. Crear la solicitud
            $solicitud = Solicitud::create([
                'estudiante_id' => $estudiante->id,
                'codigo' => $codigo,
                'email' => $validated['email'] ?? null,
                'password' => $validated['dni'], // Se hasheará automáticamente
                'estado' => 'pendiente',
                'notificar' => false,
            ]);

            // 4. Redirigir a página de confirmación
            return redirect()->route('solicitud.confirmacion', $solicitud->id)
                ->with('success', 'Solicitud creada exitosamente');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al crear la solicitud: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Mostrar confirmación de solicitud
     */
    public function confirmacion($id)
    {
        $solicitud = Solicitud::with('estudiante')->findOrFail($id);
        return view('solicitudes.confirmacion', compact('solicitud'));
    }

    /**
     * Ver estado de solicitud (método antiguo - mantener por compatibilidad)
     */
    public function verEstado()
    {
        return view('solicitudes.estado');
    }

    /**
     * Consultar por DNI del estudiante — busca en solicitudes y matrículas
     */
    public function consultarPorDNI(Request $request)
    {
        $request->validate([
            'dni' => 'required|string',
        ]);

        $dni = trim($request->dni);

        // 1. Buscar en solicitudes (flujo antiguo)
        $solicitud = Solicitud::with('estudiante')
            ->whereHas('estudiante', fn($q) => $q->where('dni', $dni))
            ->latest()
            ->first();

        // 2. Buscar en matrículas (flujo nuevo)
        $matricula = null;
        if (!$solicitud) {
            $matricula = Matricula::with(['estudiante', 'padre'])
                ->whereHas('estudiante', fn($q) => $q->where('dni', $dni))
                ->latest()
                ->first();
        }

        if (!$solicitud && !$matricula) {
            return back()->withInput()->with('sin_resultado', true);
        }

        return view('solicitudes.estado', compact('solicitud', 'matricula', 'dni'));
    }
}