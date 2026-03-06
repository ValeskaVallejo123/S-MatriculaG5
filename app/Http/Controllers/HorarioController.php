<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Profesor;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Horario::with(['profesor', 'materia'])
            ->orderBy('dia')
            ->orderBy('hora_inicio');

        // Profesor (rol 3)
        if ($user->id_rol == 3) {
            $query->where('profesor_id', $user->profesor_id);
        }

        // Estudiante (rol 4)
        if ($user->id_rol == 4) {
            $query->where('seccion', $user->seccion);
        }

        $horarios = $query->paginate(10);

        return view('horarios.index', compact('horarios'));
    }


    /** FORMULARIO CREAR */
   public function create()
{
    $profesores = \App\Models\Profesor::orderBy('nombre')->get();
    $materias   = \App\Models\Materia::orderBy('nombre')->get();
    $grados     = \App\Models\Grado::orderBy('nivel')
                    ->orderBy('numero')
                    ->orderBy('seccion')
                    ->get();

    return view('horarios.create', compact('profesores', 'materias', 'grados'));
}


    /** GUARDAR */
    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'materia_id'  => 'required|exists:materias,id',
            'seccion'     => 'required',
            'dia'         => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
            'salon'       => 'nullable|string|max:100',
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')
            ->with('success', 'Horario creado correctamente.');
    }


    /** EDITAR */
    public function edit(Horario $horario)
    {
        if (!in_array(Auth::user()->id_rol, [1,2])) {
            abort(403);
        }

        return view('horarios.edit', [
            'horario'    => $horario,
            'profesores' => Profesor::all(),
            'materias'   => Materia::all(),
        ]);
    }


    /** ACTUALIZAR */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'materia_id'  => 'required|exists:materias,id',
            'seccion'     => 'required',
            'dia'         => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
            'salon'       => 'nullable|string|max:100',
        ]);

        $horario->update($request->all());

        return redirect()->route('horarios.index')
            ->with('success', 'Horario actualizado correctamente.');
    }


    /** ELIMINAR */
    public function destroy(Horario $horario)
    {
        if (!in_array(Auth::user()->id_rol, [1,2])) {
            abort(403);
        }

        $horario->delete();

        return redirect()->route('horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }

    /**
 * Horario del profesor autenticado.
 * Agregar este método dentro de HorarioController
 */
public function miHorarioProfesor()
{
    $user     = auth()->user();
    $profesor = \App\Models\Profesor::where('user_id', $user->id)->first();

    if (!$profesor) {
        return view('profesor.mi-horario', [
            'horarios' => collect(),
            'profesor' => null,
        ]);
    }

    // El horario es JSON, buscamos todos los HorarioGrado
    // y filtramos las celdas donde aparece el profesor
    $todosHorarios = \App\Models\HorarioGrado::with('grado')->get();

    $horarios = $todosHorarios->filter(function ($horarioGrado) use ($profesor) {
        // Busca si el profesor aparece en alguna celda del JSON
        foreach ($horarioGrado->horario ?? [] as $dia => $horas) {
            foreach ($horas ?? [] as $hora => $celda) {
                if (!empty($celda) && isset($celda['profesor_id']) && $celda['profesor_id'] == $profesor->id) {
                    return true;
                }
            }
        }
        return false;
    });

    return view('profesor.mi-horario', compact('horarios', 'profesor'));
}

    /**
     * Horario del estudiante autenticado.
     * Agregar este método dentro de HorarioController
     */
    public function miHorarioEstudiante()
    {
        $user = auth()->user();

        $horarios = \App\Models\HorarioGrado::whereHas('entradas', function ($q) use ($user) {
                $q->where('seccion', $user->seccion);
            })
            ->with(['grado', 'entradas' => function ($q) use ($user) {
                $q->where('seccion', $user->seccion)->with('materia', 'profesor');
            }])
            ->get();

        return view('estudiante.mi-horario', compact('horarios'));
     }

     // Método común para ambos roles
    public function miHorario()
    {
        $user = auth()->user();

        if ($user->id_rol == 3) {
            return $this->miHorarioProfesor();
        } elseif ($user->id_rol == 4) {
            return $this->miHorarioEstudiante();
        } else {
            abort(403);
        }
    }
}
