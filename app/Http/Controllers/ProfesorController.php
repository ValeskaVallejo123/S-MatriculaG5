<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function __construct()
    {
        // Solo admin y super_admin pueden manejar profesores
        $this->middleware(['auth', 'rol:admin,super_admin']);
    }

    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda');

        $profesores = Profesor::query()
            ->when($busqueda, function ($query, $busqueda) {
                return $query->where(function ($q) use ($busqueda) {
                    $q->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('apellido', 'like', "%{$busqueda}%")
                    ->orWhere('dni', 'like', "%{$busqueda}%")
                    ->orWhere('email', 'like', "%{$busqueda}%")
                    ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ["%{$busqueda}%"]);
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['busqueda' => $busqueda]);

        return view('profesores.index', compact('profesores'));
    }

    public function dashboard()
    {
        return view('profesor.dashboard');
    }

    public function create()
    {
        return view('profesores.create');
    }

    public function store(Request $request)
{

    $validated = $request->validate([
    'nombre' => 'required|string|max:50',
    'apellido' => 'required|string|max:50',
    'dni' => 'required|string|unique:profesores,dni|max:13',
    'fecha_nacimiento' => 'nullable|date',
    'genero' => 'nullable|in:masculino,femenino,otro',
    'telefono' => 'nullable|string|max:20',
    'email' => 'required|email|unique:profesores,email',
    'direccion' => 'nullable|string',
    'especialidad' => 'required|string|max:255',
    'nivel_academico' => 'nullable|in:bachillerato,licenciatura,maestria,doctorado',
    'fecha_contratacion' => 'nullable|date',
    'tipo_contrato' => 'nullable|in:tiempo_completo,medio_tiempo,por_horas',
    'estado' => 'required|in:activo,inactivo,licencia',


    ], [
        'nombre1.required' => 'El primer nombre es obligatorio',
        'apellido1.required' => 'El primer apellido es obligatorio',
        'dni.required' => 'El DNI es obligatorio',
        'dni.unique' => 'Este DNI ya está registrado',
        'email.required' => 'El email es obligatorio',
        'email.email' => 'El email debe ser válido',
        'email.unique' => 'Este email ya está registrado',
        'especialidad.required' => 'La especialidad es obligatoria',
        'estado.required' => 'El estado es obligatorio',
    ]);

    Profesor::create($validated);

    return redirect()->route('profesores.index')
        ->with('success', ' Profesor creado exitosamente');
}

    public function show(Profesor $profesor)
    {
        return view('profesores.show', compact('profesor'));
    }

    public function edit(Profesor $profesor)
    {
        return view('profesores.edit', compact('profesor'));
    }

    public function update(Request $request, Profesor $profesor)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:profesores,dni,' . $profesor->id . '|max:13',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|in:masculino,femenino,otro',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|unique:profesores,email,' . $profesor->id,
            'direccion' => 'nullable|string',
            'especialidad' => 'required|string|max:255',
            'nivel_academico' => 'nullable|in:bachillerato,licenciatura,maestria,doctorado',
            'fecha_contratacion' => 'nullable|date',
            'tipo_contrato' => 'nullable|in:tiempo_completo,medio_tiempo,por_horas',
            'estado' => 'required|in:activo,inactivo,licencia',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'apellido.required' => 'El apellido es obligatorio',
            'dni.required' => 'El DNI es obligatorio',
            'dni.unique' => 'Este DNI ya está registrado',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'especialidad.required' => 'La especialidad es obligatoria',
            'estado.required' => 'El estado es obligatorio',
        ]);

        $profesor->update($validated);

        return redirect()->route('profesores.index')
            ->with('success', ' Profesor actualizado exitosamente');
    }

    public function destroy(Profesor $profesor)
    {
        $profesor->delete();

        return redirect()->route('profesores.index')
            ->with('success', ' Profesor eliminado exitosamente');
    }
}
