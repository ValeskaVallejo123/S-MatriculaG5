<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\Grado;
use App\Models\ProfesorGradoSeccion;

class ProfesorGradoAsignacionController extends Controller
{
    public function __construct()
    {
        // Solo ADMIN y SUPERADMIN pueden acceder
        $this->middleware(['auth', 'rol:admin,super_admin']);
    }

    /**
     * Listar profesores con sus grados y secciones asignados
     */
    public function index()
    {
        $profesores = Profesor::with(['materia', 'gradosAsignados.grado'])
            ->orderBy('nombre')
            ->paginate(15);

        return view('admin.profesorGrados.index', compact('profesores'));
    }

    /**
     * Formulario para asignar grados y secciones a un profesor
     */
    public function edit($id)
    {
        $profesor = Profesor::with(['materia', 'gradosAsignados'])->findOrFail($id);
        $grados = Grado::all();
        $secciones = ['A', 'B', 'C', 'D'];

        return view('admin.profesorGrados.edit', compact(
            'profesor',
            'grados',
            'secciones'
        ));
    }

    /**
     * Guardar una nueva asignación grado + sección
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'grado_id' => 'required|exists:grados,id',
            'seccion' => 'required|string|max:5',
        ]);

        ProfesorGradoSeccion::create([
            'profesor_id' => $id,
            'grado_id' => $request->grado_id,
            'seccion' => $request->seccion,
        ]);

        return redirect()->back()
            ->with('success', 'Grado y sección asignados correctamente.');
    }

    /**
     * Eliminar una asignación de grado
     */
    public function destroy($asignacion_id)
    {
        ProfesorGradoSeccion::findOrFail($asignacion_id)->delete();

        return redirect()->back()
            ->with('success', 'Asignación eliminada correctamente.');
    }
}
