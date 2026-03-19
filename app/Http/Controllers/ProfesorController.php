<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProfesorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,super_admin']);
    }

    /**
     * Listar profesores con búsqueda
     */
    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda');

        $profesores = Profesor::query()
            ->when($busqueda, function ($query, $busqueda) {
                $query->where(function ($q) use ($busqueda) {
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

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('profesores.create');
    }

    /**
     * Guardar nuevo profesor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'             => 'required|string|max:50',
            'apellido'           => 'required|string|max:50',
            'dni'                => 'required|string|unique:profesores,dni|max:13',
            'fecha_nacimiento'   => 'nullable|date',
            'genero'             => 'nullable|in:masculino,femenino,otro',
            'telefono'           => 'nullable|string|max:20',
            'email'              => 'required|email|unique:profesores,email',
            'direccion'          => 'nullable|string',
            'especialidad'       => 'required|string|max:255',
            'nivel_academico'    => 'nullable|in:bachillerato,licenciatura,maestria,doctorado',
            'fecha_contratacion' => 'nullable|date',
            'tipo_contrato'      => 'nullable|in:tiempo_completo,medio_tiempo,por_horas',
            'estado'             => 'required|in:activo,inactivo,licencia',
        ], [
            'nombre.required'       => 'El nombre es obligatorio',
            'apellido.required'     => 'El apellido es obligatorio',
            'dni.required'          => 'El DNI es obligatorio',
            'dni.unique'            => 'Este DNI ya está registrado',
            'email.required'        => 'El email es obligatorio',
            'email.email'           => 'El email debe ser válido',
            'email.unique'          => 'Este email ya está registrado',
            'especialidad.required' => 'La especialidad es obligatoria',
            'estado.required'       => 'El estado es obligatorio',
        ]);

        $validated = array_filter($validated, fn($v) => $v !== null && $v !== '');

        Profesor::create($validated);

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor creado exitosamente.');
    }

    /**
     * Mostrar detalle de un profesor
     */
    public function show(Profesor $profesor)
    {
        return view('profesores.show', compact('profesor'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Profesor $profesor)
    {
        return view('profesores.edit', compact('profesor'));
    }

    /**
     * Actualizar profesor existente
     */
    public function update(Request $request, Profesor $profesor): RedirectResponse
    {
        $validated = $request->validate([
            'nombre'             => 'required|string|max:255',
            'apellido'           => 'required|string|max:255',
            'dni'                => 'required|string|max:13|unique:profesores,dni,' . $profesor->id,
            'fecha_nacimiento'   => 'nullable|date',
            'genero'             => 'nullable|in:masculino,femenino,otro',
            'telefono'           => 'nullable|string|max:20',
            'email'              => 'required|email|unique:profesores,email,' . $profesor->id,
            'direccion'          => 'nullable|string',
            'especialidad'       => 'required|string|max:255',
            'nivel_academico'    => 'nullable|in:bachillerato,licenciatura,maestria,doctorado',
            'fecha_contratacion' => 'nullable|date',
            'tipo_contrato'      => 'nullable|in:tiempo_completo,medio_tiempo,por_horas',
            'estado'             => 'required|in:activo,inactivo,licencia',
        ], [
            'nombre.required'       => 'El nombre es obligatorio',
            'apellido.required'     => 'El apellido es obligatorio',
            'dni.required'          => 'El DNI es obligatorio',
            'dni.unique'            => 'Este DNI ya está registrado',
            'email.required'        => 'El email es obligatorio',
            'email.email'           => 'El email debe ser válido',
            'email.unique'          => 'Este email ya está registrado',
            'especialidad.required' => 'La especialidad es obligatoria',
            'estado.required'       => 'El estado es obligatorio',
        ]);

        $validated = array_filter($validated, fn($v) => $v !== null && $v !== '');

        $profesor->update($validated);

        return redirect()->route('profesores.index')
            ->with('success', 'Profesor actualizado exitosamente.');
    }

    /**
     * Eliminar profesor
     */
    public function destroy(Request $request, Profesor $profesor): RedirectResponse
    {
        $profesor->delete();

        return redirect()->route('profesores.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Profesor eliminado exitosamente.');
    }

    public function listarPublico()
    {
        $profesores = Profesor::where('estado', 'activo')
            ->orderBy('apellido')
            ->get();

        return view('portal.profesores', compact('profesores'));
    }
}