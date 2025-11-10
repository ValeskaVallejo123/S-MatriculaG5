<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    // Listado de matrículas
    public function index()
    {
        $matriculas = Matricula::with(['padre', 'estudiante'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $counts = [
            'total' => Matricula::count(),
            'pendiente' => Matricula::where('estado', 'pendiente')->count(),
            'aprobada' => Matricula::where('estado', 'aprobada')->count(),
            'rechazada' => Matricula::where('estado', 'rechazada')->count(),
        ];

        return view('matriculas.index', compact('matriculas', 'counts'));
    }

    // Formulario para crear matrícula
    public function create()
    {
        // Evita errores si las tablas no existen o no hay registros
        try {
            $estudiantes = Estudiante::orderBy('nombre', 'asc')->get() ?? collect();
            $padres = Padre::orderBy('nombre', 'asc')->get() ?? collect();
        } catch (\Exception $e) {
            $estudiantes = collect();
            $padres = collect();
        }

        $parentescos = ['padre' => 'Padre', 'madre' => 'Madre', 'tutor' => 'Tutor', 'otro' => 'Otro'];
        $grados = ['1ro', '2do', '3ro', '4to', '5to', '6to'];
        $secciones = ['A', 'B', 'C', 'D'];

        return view('matriculas.create', compact('estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
    }

    // Guardar matrícula
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Padre/Tutor
            'padre_nombre' => 'required|string|max:50',
            'padre_apellido' => 'required|string|max:50',
            'padre_dni' => 'required|string|size:13',
            'padre_parentesco' => 'required|string|in:padre,madre,tutor,otro',
            'padre_parentesco_otro' => 'nullable|string|max:50',
            'padre_email' => 'nullable|email|max:100',
            'padre_telefono' => 'required|string|size:8',
            'padre_direccion' => 'required|string|max:255',

            // Estudiante
            'estudiante_nombre' => 'required|string|max:50',
            'estudiante_apellido' => 'required|string|max:50',
            'estudiante_dni' => 'required|string|size:13',
            'estudiante_fecha_nacimiento' => 'required|date',
            'estudiante_email' => 'nullable|email|max:100',
            'estudiante_telefono' => 'nullable|string|size:8',
            'estudiante_grado' => 'required|string|max:10',
            'estudiante_seccion' => 'required|string|max:2',

            // Matrícula
            'anio_lectivo' => 'required|date_format:Y',
            'estado' => 'required|in:pendiente,aprobada,rechazada,cancelada',

            // Archivos (opcional)
            'archivos.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Crear o actualizar padre
            $padre = Padre::updateOrCreate(
                ['dni' => $validated['padre_dni']],
                [
                    'nombre' => $validated['padre_nombre'],
                    'apellido' => $validated['padre_apellido'],
                    'parentesco' => $validated['padre_parentesco'] === 'otro' ? $validated['padre_parentesco_otro'] : $validated['padre_parentesco'],
                    'email' => $validated['padre_email'] ?? null,
                    'telefono' => $validated['padre_telefono'],
                    'direccion' => $validated['padre_direccion'],
                ]
            );

            // Crear o actualizar estudiante
            $estudiante = Estudiante::updateOrCreate(
                ['dni' => $validated['estudiante_dni']],
                [
                    'nombre' => $validated['estudiante_nombre'],
                    'apellido' => $validated['estudiante_apellido'],
                    'fecha_nacimiento' => $validated['estudiante_fecha_nacimiento'],
                    'email' => $validated['estudiante_email'] ?? null,
                    'telefono' => $validated['estudiante_telefono'] ?? null,
                    'grado' => $validated['estudiante_grado'],
                    'seccion' => $validated['estudiante_seccion'],
                ]
            );

            // Crear matrícula
            $matricula = Matricula::create([
                'padre_id' => $padre->id,
                'estudiante_id' => $estudiante->id,
                'grado' => $validated['estudiante_grado'],
                'seccion' => $validated['estudiante_seccion'],
                'anio_lectivo' => $validated['anio_lectivo'],
                'estado' => $validated['estado'],
            ]);

            // Guardar archivos (si existen)
            if ($request->hasFile('archivos')) {
                foreach ($request->file('archivos') as $archivo) {
                    $archivo->store('matriculas/'.$matricula->id);
                }
            }

            DB::commit();
            return redirect()->route('matriculas.index')->with('success', 'Matrícula creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar la matrícula: '.$e->getMessage()]);
        }
    }
}
