<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Padre;
use Illuminate\Support\Str;

class MatriculaController extends Controller
{
    // Listado de matrículas
    public function index()
    {
        $matriculas = Matricula::with(['estudiante', 'padre'])->orderBy('id', 'desc')->paginate(10);

        $counts = [
            'total' => Matricula::count(),
            'pendiente' => Matricula::where('estado', 'pendiente')->count(),
            'aprobada' => Matricula::where('estado', 'aprobada')->count(),
            'rechazada' => Matricula::where('estado', 'rechazada')->count(),
        ];

        return view('matriculas.index', compact('matriculas', 'counts'));
    }

    // Formulario de nueva matrícula
    public function create()
    {
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();

        // ✅ Aquí agregamos parentescos
        $parentescos = [
            'madre' => 'Madre',
            'padre' => 'Padre',
            'tutor' => 'Tutor Legal',
            'abuelo' => 'Abuelo(a)',
            'tio' => 'Tio(a)',
            'hermano' => 'Hermano(a)',
            'otro' => 'Otro'
        ];

        return view('matriculas.create', compact('grados', 'secciones', 'parentescos'));
    }

    // Guardar nueva matrícula
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:500',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'estado' => 'nullable|string|in:pendiente,aprobada,rechazada',

            // ✅ Validamos parentesco para evitar errores
            'padre_parentesco' => 'required|string',

            'foto_estudiante' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'acta_nacimiento' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'certificado_estudios' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'constancia_conducta' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto_dni_estudiante' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'foto_dni_padre' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Crear estudiante
        $estudiante = Estudiante::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'direccion' => $request->direccion,
            'grado' => $request->grado,
            'seccion' => $request->seccion,
            'estado' => $request->estado ?? 'pendiente',
        ]);

        // Crear matrícula
        $matricula = Matricula::create([
            'codigo_matricula' => strtoupper(Str::random(8)),
            'estudiante_id' => $estudiante->id,
            'estado' => 'pendiente',
            'anio_lectivo' => now()->year,
            'fecha_matricula' => now(),
        ]);

        return redirect()->route('matriculas.index')->with('success', 'Matrícula registrada correctamente.');
    }

    // Mostrar detalle de matrícula
    public function show(Matricula $matricula)
    {
        $matricula->load(['estudiante', 'padre']);
        return view('matriculas.show', compact('matricula'));
    }

    // Formulario para editar matrícula
    public function edit(Matricula $matricula)
    {
        $matricula->load(['estudiante', 'padre']);
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();

        return view('matriculas.edit', compact('matricula', 'grados', 'secciones'));
    }

    // Actualizar matrícula
    public function update(Request $request, Matricula $matricula)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:500',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'estado' => 'nullable|string|in:pendiente,aprobada,rechazada',
        ]);

        // Actualizar estudiante
        $matricula->estudiante->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'direccion' => $request->direccion,
            'grado' => $request->grado,
            'seccion' => $request->seccion,
            'estado' => $request->estado ?? $matricula->estado,
        ]);

        // Actualizar matrícula
        $matricula->update([
            'estado' => $request->estado ?? $matricula->estado,
        ]);

        return redirect()->route('matriculas.index')->with('success', 'Matrícula actualizada correctamente.');
    }

    // Eliminar matrícula
    public function destroy(Matricula $matricula)
    {
        $matricula->delete();
        return redirect()->route('matriculas.index')->with('success', 'Matrícula eliminada correctamente.');
    }

    // Confirmar matrícula
    public function confirm(Matricula $matricula)
    {
        $matricula->confirmar();
        return redirect()->route('matriculas.index')->with('success', 'Matrícula confirmada correctamente.');
    }
}
