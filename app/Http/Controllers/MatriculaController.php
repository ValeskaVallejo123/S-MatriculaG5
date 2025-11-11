<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Padre;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::with(['padre', 'estudiante'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $counts = [
            'total' => Matricula::count(),
            'pendiente' => Matricula::where('estado', 'pendiente')->count(),
            'aprobada' => Matricula::where('estado', 'aprobada')->count(),
            'rechazada' => Matricula::where('estado', 'rechazada')->count(),
        ];

        return view('matriculas.index', compact('matriculas', 'counts'));
    }

    public function create()
    {
        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'tutor' => 'Tutor/a',
            'abuelo' => 'Abuelo/a',
            'otro' => 'Otro'
        ];

        $grados = ['1er Grado','2do Grado','3er Grado','4to Grado','5to Grado','6to Grado'];
        $secciones = ['A','B','C','D'];

        return view('matriculas.create', compact('grados', 'secciones', 'parentescos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'padre_nombre' => 'required|string|min:2|max:50',
            'padre_apellido' => 'required|string|min:2|max:50',
            'padre_dni' => 'required|string|size:13|unique:padres,dni',
            'padre_parentesco' => 'required|string|in:padre,madre,tutor,abuelo,otro',
            'padre_parentesco_otro' => 'nullable|required_if:padre_parentesco,otro|string|max:50',
            'padre_email' => 'nullable|email|max:100',
            'padre_telefono' => 'required|string|min:8|max:15',
            'padre_direccion' => 'required|string|max:255',

            'estudiante_nombre' => 'required|string|min:2|max:50',
            'estudiante_apellido' => 'required|string|min:2|max:50',
            'estudiante_dni' => 'required|string|size:13|unique:estudiantes,dni',
            'estudiante_fecha_nacimiento' => 'required|date|before:today',
            'estudiante_sexo' => 'required|in:masculino,femenino',
            'estudiante_email' => 'nullable|email|max:100',
            'estudiante_telefono' => 'nullable|string|max:15',
            'estudiante_direccion' => 'nullable|string|max:255',
            'estudiante_grado' => 'required|string|max:20',
            'estudiante_seccion' => 'required|string|size:1',

            'anio_lectivo' => 'required|digits:4|min:2020|max:2099',
            'estado' => 'nullable|in:pendiente,aprobada,rechazada,cancelada',
            'observaciones' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $padre = Padre::create([
                'nombre' => $validated['padre_nombre'],
                'apellido' => $validated['padre_apellido'],
                'dni' => $validated['padre_dni'],
                'parentesco' => $validated['padre_parentesco'] === 'otro'
                    ? $validated['padre_parentesco_otro']
                    : $validated['padre_parentesco'],
                'email' => $validated['padre_email'] ?? null,
                'telefono' => $validated['padre_telefono'],
                'direccion' => $validated['padre_direccion'],
            ]);

            $estudiante = Estudiante::create([
                'nombre' => $validated['estudiante_nombre'],
                'apellido' => $validated['estudiante_apellido'],
                'dni' => $validated['estudiante_dni'],
                'fecha_nacimiento' => $validated['estudiante_fecha_nacimiento'],
                'sexo' => $validated['estudiante_sexo'],
                'email' => $validated['estudiante_email'] ?? null,
                'telefono' => $validated['estudiante_telefono'] ?? null,
                'direccion' => $validated['estudiante_direccion'] ?? null,
                'grado' => $validated['estudiante_grado'],
                'seccion' => $validated['estudiante_seccion'],
                'estado' => 'activo',
            ]);

            Matricula::create([
                'padre_id' => $padre->id,
                'estudiante_id' => $estudiante->id,
                'grado' => $validated['estudiante_grado'],
                'seccion' => $validated['estudiante_seccion'],
                'anio_lectivo' => $validated['anio_lectivo'],
                'estado' => $validated['estado'] ?? 'pendiente',
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('matriculas.index')->with('success', 'Matrícula creada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }
}
