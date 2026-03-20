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

        $totalAsignaciones = ProfesorMateriaGrado::count();
        $totalProfesores   = ProfesorMateriaGrado::distinct('profesor_id')->count();

        return view('profesor_materia.index', compact(
            'asignaciones', 'totalAsignaciones', 'totalProfesores'
        ));
    }

    public function create(): View
    {
        $profesores = Profesor::orderBy('nombre')->get();
        $materias   = Materia::orderBy('nombre')->get();
        $grados     = Grado::orderBy('nivel')->orderBy('numero')->get();
        $secciones  = ['A', 'B', 'C', 'D'];

        return view('profesor_materia.create', compact(
            'profesores', 'materias', 'grados', 'secciones'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'materia_id'  => 'required|exists:materias,id',
            'grado_id'    => 'required|exists:grados,id',
            'seccion'     => 'required|string|max:2',
        ]);

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
            ->route('profesor_materia.index')
            ->with('success', 'Asignación creada correctamente.');
    }

    /** Formulario de edición */
    public function edit(ProfesorMateriaGrado $profesor_materia_grado)
    {
        $profesores = Profesor::orderBy('nombre')->get();
        $materias   = Materia::orderBy('nombre')->get();
        $grados     = Grado::orderBy('nivel')->orderBy('numero')->get();
        $secciones  = ['A', 'B', 'C', 'D'];

        return view('profesor_materia.edit', compact(
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

        $existe = ProfesorMateriaGrado::where('profesor_id', $request->profesor_id)
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

        return redirect()
            ->route('profesor_materia.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    public function edit($id): View
    {
        $profesor = Profesor::with(['materiasGrupos.grado', 'materiasGrupos.materia'])
                            ->findOrFail($id);
        
        $materias  = Materia::all();
        $grados    = Grado::all();
        $secciones = ['A', 'B', 'C', 'D'];

        return redirect()
            ->route('profesor_materia.index')
            ->with('success', 'Asignación eliminada.');
    }
}