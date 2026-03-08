<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Grado;
use App\Models\ProfesorMateriaGrado; // Tu modelo de la última consulta
use Illuminate\Http\Request;


class ProfesorMateriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,super_admin']);
    }

    /**
     * Muestra la lista de asignaciones usando tu modelo personalizado.
     */
    public function index()
    {
        // Cargamos los profesores con sus relaciones a través de tu modelo intermedio
        $asignaciones = Profesor::with(['materiasGrupos.materia', 'materiasGrupos.grado'])
            ->orderBy('nombre')
            ->paginate(15);

        return view('profesor_materia.index', compact('asignaciones'));
    }

    /**
     * Carga los datos para que el selector (Select) NO esté vacío.
     */
    public function create()
    {
        // 1. Cargamos profesores (temporalmente quitamos el filtro de 'activo' para probar)
        $profesores = Profesor::orderBy('nombre')->get();

        // 2. Cargamos materias y grados
        $materias = Materia::orderBy('nombre')->get();
        $grados = Grado::orderBy('numero')->get();

        // Debug rápido: Si al cargar la página ves una lista negra, es que hay datos.
        // Si ves [], la tabla en la base de datos está vacía.
        // dd($profesores);

        return view('profesor_materia.create', compact('profesores', 'materias', 'grados'));
    }

    /**
     * Guarda usando tu modelo ProfesorMateriaGrado.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'materia_ids' => 'required|array|min:1',
            'grado_id'    => 'required|exists:grados,id',
            'seccion'     => 'required|string|max:2',
        ]);

        foreach ($request->materia_ids as $materiaId) {
            // Usamos el método yaAsignado que tienes en tu modelo para evitar duplicados
            if (!ProfesorMateriaGrado::yaAsignado($request->profesor_id, $materiaId, $request->grado_id, $request->seccion)) {
                ProfesorMateriaGrado::create([
                    'profesor_id' => $request->profesor_id,
                    'materia_id'  => $materiaId,
                    'grado_id'    => $request->grado_id,
                    'seccion'     => $request->seccion,
                ]);
            }
        }

        return redirect()->route('profesor_materia.index')
            ->with('success', 'Asignaciones creadas correctamente.');
    }

    /**
     * Asignación desde la vista de GRADOS (La de tu imagen).
     */
    public function guardarAsignacion(Request $request, Grado $grado)
    {
        $request->validate([
            'materias'   => 'required|array',
            'profesores' => 'nullable|array',
            'seccion'    => 'required|string',
        ]);

        foreach ($request->materias as $materiaId) {
            $profesorId = $request->input("profesores.$materiaId");

            if ($profesorId) {
                // Actualizamos o creamos la asignación en tu tabla profesor_materia_grados
                ProfesorMateriaGrado::updateOrCreate(
                    [
                        'materia_id' => $materiaId,
                        'grado_id'   => $grado->id,
                        'seccion'    => $request->seccion,
                    ],
                    ['profesor_id' => $profesorId]
                );
            }
        }

        return redirect()->back()->with('success', 'Profesores asignados con éxito.');
    }
}
