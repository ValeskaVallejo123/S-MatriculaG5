<?php

namespace App\Http\Controllers;

use App\Models\ProfesorMateriaGrado;
use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Grado;
use Illuminate\Http\Request;

class ProfesorMateriaGradoController extends Controller
{
    /* ============================================================
       LISTAR — agrupado por profesor
    ============================================================ */
    public function index()
    {
        $registros = ProfesorMateriaGrado::with(['profesor', 'materia', 'grado'])
            ->orderBy('profesor_id')
            ->get();

        $asignaciones      = $registros->groupBy('profesor_id');
        $totalProfesores   = $asignaciones->count();
        $totalAsignaciones = $registros->count();

        return view('profesor_materia_grado.index', compact(
            'asignaciones',
            'totalProfesores',
            'totalAsignaciones'
        ));
    }

    /* ============================================================
       FORMULARIO DE CREACIÓN
    ============================================================ */
    public function create()
    {
        $profesores = Profesor::orderBy('apellido')->orderBy('nombre')->get();
        $materias   = Materia::where('activo', true)->orderBy('nombre')->get();
        $grados     = Grado::where('activo', true)
                        ->orderBy('nivel')
                        ->orderBy('numero')
                        ->orderBy('seccion')
                        ->get();
        $secciones  = ['A', 'B', 'C', 'D'];

        return view('profesor_materia_grado.create', compact(
            'profesores', 'materias', 'grados', 'secciones'
        ));
    }

    /* ============================================================
       GUARDAR NUEVA ASIGNACIÓN
    ============================================================ */
    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => ['required', 'exists:profesores,id'],
            'materia_id'  => ['required', 'exists:materias,id'],
            'grado_id'    => ['required', 'exists:grados,id'],
            'seccion'     => ['required', 'string', 'max:5'],
        ], [
            'profesor_id.required' => 'Debes seleccionar un profesor.',
            'profesor_id.exists'   => 'El profesor seleccionado no es válido.',
            'materia_id.required'  => 'Debes seleccionar una materia.',
            'materia_id.exists'    => 'La materia seleccionada no es válida.',
            'grado_id.required'    => 'Debes seleccionar un grado.',
            'grado_id.exists'      => 'El grado seleccionado no es válido.',
            'seccion.required'     => 'Debes seleccionar una sección.',
        ]);

        // Evitar duplicados exactos
        $existe = ProfesorMateriaGrado::where([
            'profesor_id' => $request->profesor_id,
            'materia_id'  => $request->materia_id,
            'grado_id'    => $request->grado_id,
            'seccion'     => $request->seccion,
        ])->exists();

        if ($existe) {
            return back()->withInput()
                ->withErrors(['duplicado' => 'Esta asignación ya existe en el sistema.']);
        }

        ProfesorMateriaGrado::create([
            'profesor_id' => $request->profesor_id,
            'materia_id'  => $request->materia_id,
            'grado_id'    => $request->grado_id,
            'seccion'     => $request->seccion,
        ]);

        return redirect()->route('profesor_materia_grado.index')
            ->with('success', 'Asignación creada correctamente.');
    }

    /* ============================================================
       VER DETALLE (no se usa en la vista actual, redirige al index)
    ============================================================ */
    public function show(string $id)
    {
        return redirect()->route('profesor_materia_grado.index');
    }

    /* ============================================================
       FORMULARIO DE EDICIÓN
    ============================================================ */
    public function edit(string $id)
    {
        $asignacion = ProfesorMateriaGrado::with(['profesor', 'materia', 'grado'])
            ->findOrFail($id);

        $profesores = Profesor::orderBy('apellido')->orderBy('nombre')->get();
        $materias   = Materia::where('activo', true)->orderBy('nombre')->get();
        $grados     = Grado::where('activo', true)
                        ->orderBy('nivel')
                        ->orderBy('numero')
                        ->orderBy('seccion')
                        ->get();
        $secciones  = ['A', 'B', 'C', 'D'];

        return view('profesor_materia_grado.edit', compact(
            'asignacion', 'profesores', 'materias', 'grados', 'secciones'
        ));
    }

    /* ============================================================
       ACTUALIZAR ASIGNACIÓN
    ============================================================ */
    public function update(Request $request, string $id)
    {
        $asignacion = ProfesorMateriaGrado::findOrFail($id);

        $request->validate([
            'profesor_id' => ['required', 'exists:profesores,id'],
            'materia_id'  => ['required', 'exists:materias,id'],
            'grado_id'    => ['required', 'exists:grados,id'],
            'seccion'     => ['required', 'string', 'max:5'],
        ], [
            'profesor_id.required' => 'Debes seleccionar un profesor.',
            'materia_id.required'  => 'Debes seleccionar una materia.',
            'grado_id.required'    => 'Debes seleccionar un grado.',
            'seccion.required'     => 'Debes seleccionar una sección.',
        ]);

        // Evitar duplicados excluyendo el registro actual
        $existe = ProfesorMateriaGrado::where([
            'profesor_id' => $request->profesor_id,
            'materia_id'  => $request->materia_id,
            'grado_id'    => $request->grado_id,
            'seccion'     => $request->seccion,
        ])->where('id', '!=', $id)->exists();

        if ($existe) {
            return back()->withInput()
                ->withErrors(['duplicado' => 'Ya existe otra asignación con estos mismos datos.']);
        }

        $asignacion->update([
            'profesor_id' => $request->profesor_id,
            'materia_id'  => $request->materia_id,
            'grado_id'    => $request->grado_id,
            'seccion'     => $request->seccion,
        ]);

        return redirect()->route('profesor_materia_grado.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    /* ============================================================
       ELIMINAR ASIGNACIÓN
    ============================================================ */
    public function destroy(string $id)
    {
        $asignacion = ProfesorMateriaGrado::findOrFail($id);
        $asignacion->delete();

        return redirect()->route('profesor_materia_grado.index')
            ->with('success', 'Asignación eliminada correctamente.');
    }
}