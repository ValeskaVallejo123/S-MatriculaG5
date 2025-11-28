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

        return view('profesor.index', compact('profesores'));
    }

    public function dashboard()
    {
        return view('profesor.dashboard');
    }

    public function create()
    {
        $especialidades = Profesor::especialidades();
        $tiposContrato = Profesor::tiposContrato();
        return view('profesor.create', compact('especialidades', 'tiposContrato'));
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

        return redirect()->route('profesor.index')
            ->with('success', 'Profesor creado exitosamente');
    }

    public function show(Profesor $profesor)
    {
        return view('profesor.show', compact('profesor'));
    }

    public function edit(Profesor $profesor)
    {
        $especialidades = Profesor::especialidades();
        $tiposContrato = Profesor::tiposContrato();

        return view('profesor.edit', compact('profesor', 'especialidades', 'tiposContrato'));
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

        return redirect()->route('profesor.index')
            ->with('success', 'Profesor actualizado exitosamente');
    }

    public function destroy(Profesor $profesor)
    {
        $profesor->delete();

        return redirect()->route('profesor.index')
            ->with('success', 'Profesor eliminado exitosamente');
    }
}
