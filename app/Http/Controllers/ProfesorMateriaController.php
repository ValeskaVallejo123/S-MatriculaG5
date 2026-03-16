<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Materia;
use App\Models\Profesor;
use App\Models\ProfesorMateriaGrado;
use Illuminate\Http\Request;

class ProfesorMateriaGradoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /** Lista todas las asignaciones agrupadas por profesor */
    public function index()
    {
        $asignaciones = ProfesorMateriaGrado::with(['profesor', 'materia', 'grado'])
            ->orderBy('profesor_id')
            ->orderBy('grado_id')
            ->orderBy('seccion')
            ->get()
            ->groupBy('profesor_id');

        $totalAsignaciones = ProfesorMateriaGrado::count();
        $totalProfesores   = ProfesorMateriaGrado::distinct('profesor_id')->count();

        return view('profesor_materia_grado.index', compact(
            'asignaciones', 'totalAsignaciones', 'totalProfesores'
        ));
    }

    /** Formulario para crear nueva asignación */
    public function create()
    {
        $profesores = Profesor::orderBy('nombre')->get();
        $materias   = Materia::orderBy('nombre')->get();
        $grados     = Grado::orderBy('nombre')->get();
        $secciones  = ['A', 'B', 'C', 'D'];

        return view('profesor_materia_grado.create', compact(
            'profesores', 'materias', 'grados', 'secciones'
        ));
    }

    /** Guardar nueva asignación */
    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'materia_id'  => 'required|exists:materias,id',
            'grado_id'    => 'required|exists:grados,id',
            'seccion'     => 'required|string|max:5',
        ]);

        // Verificar duplicado
        if (ProfesorMateriaGrado::yaAsignado(
            $request->profesor_id,
            $request->materia_id,
            $request->grado_id,
            $request->seccion
        )) {
            return back()
                ->withInput()
                ->withErrors(['duplicado' => 'Ya existe esa asignación (mismo profesor, materia, grado y sección).']);
        }

        ProfesorMateriaGrado::create($request->only([
            'profesor_id', 'materia_id', 'grado_id', 'seccion'
        ]));

        return redirect()
            ->route('profesor_materia_grado.index')
            ->with('success', 'Asignación creada correctamente.');
    }

    /** Formulario de edición */
    public function edit(ProfesorMateriaGrado $profesor_materia_grado)
    {
        $profesores = Profesor::orderBy('nombre')->get();
        $materias   = Materia::orderBy('nombre')->get();
        $grados     = Grado::orderBy('nombre')->get();
        $secciones  = ['A', 'B', 'C', 'D'];

        return view('profesor_materia_grado.edit', compact(
            'profesor_materia_grado', 'profesores', 'materias', 'grados', 'secciones'
        ));
    }

    /** Actualizar asignación */
    public function update(Request $request, ProfesorMateriaGrado $profesor_materia_grado)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'materia_id'  => 'required|exists:materias,id',
            'grado_id'    => 'required|exists:grados,id',
            'seccion'     => 'required|string|max:5',
        ]);

        // Verificar duplicado (excluyendo el actual)
        $existe = ProfesorMateriaGrado::where('profesor_id', $request->profesor_id)
            ->where('materia_id',  $request->materia_id)
            ->where('grado_id',    $request->grado_id)
            ->where('seccion',     $request->seccion)
            ->where('id', '!=',    $profesor_materia_grado->id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors(['duplicado' => 'Ya existe esa asignación.']);
        }

        $profesor_materia_grado->update($request->only([
            'profesor_id', 'materia_id', 'grado_id', 'seccion'
        ]));

        return redirect()
            ->route('profesor_materia_grado.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    /** Eliminar asignación */
    public function destroy(ProfesorMateriaGrado $profesor_materia_grado)
    {
        $profesor_materia_grado->delete();

        return redirect()
            ->route('profesor_materia_grado.index')
            ->with('success', 'Asignación eliminada.');
    }
}
