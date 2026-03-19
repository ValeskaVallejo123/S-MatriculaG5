<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Grado;
use App\Models\ProfesorMateriaGrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfesorMateriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'rol:admin,super_admin']);
    }

    public function index()
    {
        $asignaciones = Profesor::with(['materiasGrupos.grado', 'materiasGrupos.materia'])
            ->paginate(10);

        return view('profesor_materia.index', compact('asignaciones'));
    }

    public function create(): View
    {
        $profesores = Profesor::all();
        $materias   = Materia::all();
        $grados     = Grado::all();
        $secciones  = ['A', 'B', 'C', 'D'];

        return view('profesor_materia.create', compact('profesores', 'materias', 'grados', 'secciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'materia_id'  => 'required|exists:materias,id',
            'grado_id'    => 'required|exists:grados,id',
            'seccion'     => 'required|string|max:2',
        ]);

        // Aplicando la corrección con "s" y validando duplicados
        $existe = DB::table('profesor_materia_grados')
            ->where('profesor_id', $request->profesor_id)
            ->where('materia_id',  $request->materia_id)
            ->where('grado_id',    $request->grado_id)
            ->where('seccion',     $request->seccion)
            ->exists();

        if ($existe) {
            return back()->withErrors(['duplicado' => 'Esta asignación ya existe.'])->withInput();
        }

        Profesor::findOrFail($request->profesor_id)->materiasGrupos()->create([
            'materia_id' => $request->materia_id,
            'grado_id'   => $request->grado_id,
            'seccion'    => $request->seccion,
        ]);

        return redirect()->route('profesor_materia.index')
            ->with('success', 'Asignación creada correctamente.');
    }

    public function edit($id): View
    {
        $profesor = Profesor::with(['materiasGrupos.grado', 'materiasGrupos.materia'])
                            ->findOrFail($id);
        
        $materias  = Materia::all();
        $grados    = Grado::all();
        $secciones = ['A', 'B', 'C', 'D'];

        return view('profesor_materia.edit', compact('profesor', 'materias', 'grados', 'secciones'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'grado_id'   => 'required|exists:grados,id',
            'seccion'    => 'required|string|max:2',
        ]);

        // Aplicando la corrección solicitada aquí también
        $existe = DB::table('profesor_materia_grados')
            ->where('profesor_id', $id)
            ->where('materia_id',  $request->materia_id)
            ->where('grado_id',    $request->grado_id)
            ->where('seccion',     $request->seccion)
            ->exists();

        if ($existe) {
            return back()->withErrors(['duplicado' => 'Esta asignación ya existe para este profesor.'])->withInput();
        }

        Profesor::findOrFail($id)->materiasGrupos()->create([
            'materia_id' => $request->materia_id,
            'grado_id'   => $request->grado_id,
            'seccion'    => $request->seccion,
        ]);

        return redirect()->route('profesor_materia.edit', $id)
            ->with('success', 'Asignación agregada correctamente.');
    }

    public function destroyAsignacion($id)
    {
        DB::table('profesor_materia_grados')->where('id', $id)->delete();

        return back()->with('success', 'Asignación eliminada.');
    }

    public function destroy($id)
    {
        DB::table('profesor_materia_grados')->where('profesor_id', $id)->delete();

        return redirect()->route('profesor_materia.index')
            ->with('success', 'Todas las asignaciones del profesor fueron eliminadas.');
    }
}