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
}
