<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Profesor;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HorarioController extends Controller
{
    /**
     * Mostrar todos los horarios según el rol con paginación
     */
    public function index()
    {
        $user = Auth::user();

        $query = Horario::with('profesor')
            ->orderBy('dia')
            ->orderBy('hora_inicio');

        // Si es profesor, solo sus horarios
        if ($user && $user->user_type === 'profesor') {
            $query->where('profesor_id', $user->id);
        }

        $horarios = $query->paginate(10);

        return view('horarios.index', compact('horarios'));
    }

    /**
     * Exportar horarios a PDF
     * Cada profesor descarga solo su horario
     */
    public function exportPDF()
    {
        $user = Auth::user();

        if (!$user || $user->user_type !== 'profesor') {
            abort(403, 'No tienes permisos para descargar este PDF.');
        }

        $horarios = Horario::with('profesor')
            ->where('profesor_id', $user->id)
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        return Pdf::loadView('horarios.pdf', [
            'horarios' => $horarios,
            'profesor' => $user
        ])->download('horario.pdf');
    }

    /**
     * Crear
     */
    public function create()
    {
        return view('horarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'dia' => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'grado' => 'required',
            'seccion' => 'required',
            'aula' => 'nullable',
            'observaciones' => 'nullable',
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')
            ->with('success', 'Horario creado correctamente.');
    }

    public function show(Horario $horario)
    {
        return view('horarios.show', compact('horario'));
    }

    public function edit(Horario $horario)
    {
        return view('horarios.edit', compact('horario'));
    }

    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'dia' => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'grado' => 'required',
            'seccion' => 'required',
            'aula' => 'nullable',
            'observaciones' => 'nullable',
        ]);

        $horario->update($request->all());

        return redirect()->route('horarios.index')
            ->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }

    public function miHorario()
{
    $user = Auth::user();

    // Solo estudiantes
    if (!$user || $user->user_type !== 'estudiante') {
        abort(403, 'No tienes permisos para ver este horario.');
    }

    // Obtener el horario según el grado y sección del estudiante
    $horario = Horario::with( 'profesor')
                ->where('seccion', $user->seccion)
                ->orderBy('dia')
                ->orderBy('hora_inicio')
                ->get();

    return view('estudiante.miHorario', compact('horario'));
}

}
