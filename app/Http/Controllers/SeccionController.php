<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Seccion;
use Illuminate\Http\Request;
use App\Models\Estudiante;

class SeccionController extends Controller
{
    public function index(Request $request)
    {
        $query = Matricula::with(['estudiante', 'seccion'])
            ->where('estado', 'aprobada')
            ->whereHas('estudiante');

        if ($request->filled('buscar')) {
            $b = $request->buscar;
            $query->whereHas('estudiante', fn($q) =>
                $q->where('nombre1', 'like', "%$b%")
                  ->orWhere('nombre2', 'like', "%$b%")
                  ->orWhere('apellido1', 'like', "%$b%")
                  ->orWhere('apellido2', 'like', "%$b%")
            );
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'asignada') {
                $query->whereNotNull('seccion_id');
            } elseif ($request->estado === 'sin_asignar') {
                $query->whereNull('seccion_id');
            }
        }

        $inscripciones = $query->latest()->paginate(15)->withQueryString();

        $secciones = Seccion::all();

        $alumnos = Estudiante::whereDoesntHave('matriculas', function ($q) {
            $q->whereNotNull('seccion_id');
        })->orderBy('nombre1')->get();

        return view('secciones.index', compact('inscripciones', 'secciones', 'alumnos'));
    }

    public function asignar(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'seccion_id'    => 'required|exists:seccion,id', // tabla correcta: 'seccion'
        ]);

        $matricula = Matricula::where('estudiante_id', $request->estudiante_id)
            ->where('estado', 'aprobada')
            ->first();

        if (!$matricula) {
            return back()->with('error', 'El estudiante no tiene una matrícula aprobada.');
        }

        $matricula->update(['seccion_id' => $request->seccion_id]);

        return redirect()->route('secciones.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Sección asignada correctamente.');
    }

    public function create()
    {
        return view('secciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
        ]);

        Seccion::create($validated);

        return redirect()->route('secciones.index')
            ->with('success', 'Sección creada correctamente.');
    }

    public function edit(Seccion $seccion)
    {
        return view('secciones.edit', compact('seccion'));
    }

    public function update(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
        ]);

        $seccion->update($validated);

        return redirect()->route('secciones.index')
            ->with('success', 'Sección actualizada correctamente.');
    }

    public function destroy(Request $request, Seccion $seccion)
    {
        if ($seccion->matriculas()->exists()) {
            return back()->with('error', 'No se puede eliminar una sección con alumnos inscritos.');
        }

        $seccion->delete();

        return redirect()->route('secciones.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Sección eliminada correctamente.');
    }
}
