<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Grado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfesorMateriaController extends Controller
{
    public function __construct()
    {
        // Solo ADMIN y SUPERADMIN pueden administrar materias de profesores
        $this->middleware(['auth', 'rol:admin,super_admin']);
    }

    /**
     * Mostrar lista de profesores con sus asignaciones (materia + grado + sección)
     */
    public function index()
    {
        $asignaciones = Profesor::with(['materiasGrupos.grado', 'materiasGrupos.materia'])
            ->paginate(15);

        return view('profesor_materia.index', compact('asignaciones'));
    }

    /**
     * Formulario de creación de asignación
     */
    public function create()
    {
        $profesores = Profesor::all();
        $materias = Materia::all();
        $grados = Grado::all();
        $secciones = ['A', 'B', 'C', 'D'];

        return view('profesor_materia.create', compact(
            'profesores', 'materias', 'grados', 'secciones'
        ));
    }

    /**
     * Guardar asignación (materia + grado + sección)
     */
    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'materia_id' => 'required|exists:materias,id',
            'grado_id' => 'required|exists:grados,id',
            'seccion' => 'required|string|max:2',
        ]);

        $profesor = Profesor::findOrFail($request->profesor_id);

        $profesor->materiasGrupos()->create([
            'materia_id' => $request->materia_id,
            'grado_id' => $request->grado_id,
            'seccion' => $request->seccion,
        ]);

        return redirect()->route('profesor_materia.index')
            ->with('success', 'Asignación creada correctamente.');
    }

    /**
     * Eliminar una relación de materia + grado + sección
     */
    public function destroy($id)
    {
        DB::table('profesor_materia_grado')->where('id', $id)->delete();

        return redirect()->route('profesor_materia.index')
            ->with('success', 'Asignación eliminada.');
    }
}
