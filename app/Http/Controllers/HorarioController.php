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

        if ($user->id_rol == 3) {
            $query->where('profesor_id', $user->profesor_id);
        }

        if ($user->id_rol == 4) {
            $query->where('seccion', $user->seccion);
        }

        $horarios = $query->paginate(10);

        return view('horarios.index', compact('horarios'));
    }


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


    public function edit(Horario $horario)
    {
        if (!in_array(Auth::user()->id_rol, [1, 2])) {
            abort(403);
        }

        return view('horarios.edit', [
            'horario'    => $horario,
            'profesores' => Profesor::all(),
            'materias'   => Materia::all(),
        ]);
    }


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


    public function destroy(Horario $horario)
    {
        if (!in_array(Auth::user()->id_rol, [1, 2])) {
            abort(403);
        }

        $horario->delete();

        return redirect()->route('horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }


    /**
     * Horario del profesor autenticado.
     */
    public function miHorarioProfesor()
    {
        $user     = Auth::user();
        $profesor = \App\Models\Profesor::where('user_id', $user->id)->first();

        if (!$profesor) {
            return view('profesor.mi-horario', [
                'horarios' => collect(),
                'profesor' => null,
            ]);
        }

        $todosHorarios = \App\Models\HorarioGrado::with('grado')->get();

        $horarios = $todosHorarios->filter(function ($horarioGrado) use ($profesor) {
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
     */
    public function miHorarioEstudiante()
    {
        $user       = Auth::user();
        $estudiante = \App\Models\Estudiante::where('user_id', $user->id)->first();

        if (!$estudiante) {
            return view('estudiantes.mihorario', [
                'horarioGrado' => null,
                'estudiante'   => null,
            ]);
        }

        $horarioGrado = null;

        if ($estudiante->grado_id) {
            $horarioGrado = \App\Models\HorarioGrado::where('grado_id', $estudiante->grado_id)
                ->with('grado')
                ->first();
        }

        return view('estudiantes.mihorario', compact('horarioGrado', 'estudiante'));
    }


    /**
     * Método común — redirige según rol.
     */
    public function miHorario()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->id_rol == 3) {
            return $this->miHorarioProfesor();
        } elseif ($user->id_rol == 4) {
            return $this->miHorarioEstudiante();
        }

        abort(403);
    }
}
