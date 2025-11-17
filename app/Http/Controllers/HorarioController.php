<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
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

        $query = Horario::with('profesor')->orderBy('dia')->orderBy('hora_inicio');

        if ($user && $user->user_type === 'profesor') {
            $query->where('profesor_id', $user->id);
        }

        // Paginación para administradores y profesores
        $horarios = $query->paginate(10);

        return view('horarios.index', compact('horarios'));
    }

    /**
     * Mostrar horarios públicos o del estudiante logueado
     */
    public function horarioPublico()
    {
        $user = Auth::user();

        $query = Horario::with('profesor')->orderBy('dia')->orderBy('hora_inicio');

        if ($user && $user->user_type === 'estudiante') {
            // Filtrar solo su grado y sección
            $query->where('grado', $user->grado)
                  ->where('seccion', $user->seccion);
        }

        $horarios = $query->paginate(10); // Paginación opcional
        return view('horarios.publicos', compact('horarios'));
    }

    /**
     * Exportar horarios a PDF
     * @param int|null $profesorId
     */
    public function exportPDF($profesorId = null)
    {
        $user = Auth::user();

        $query = Horario::with('profesor')->orderBy('dia')->orderBy('hora_inicio');

        if ($user && $user->user_type === 'profesor') {
            $query->where('profesor_id', $user->id);
        } elseif ($user && $user->user_type === 'estudiante') {
            // Solo sus horarios
            $query->where('grado', $user->grado)
                  ->where('seccion', $user->seccion);
        } elseif ($profesorId) {
            $query->where('profesor_id', $profesorId);
        }

        $horarios = $query->get(); // PDF no necesita paginación

        return Pdf::loadView('horarios.pdf', compact('horarios', 'user'))
                  ->download('horario.pdf');
    }

    /**
     * Mostrar formulario para crear un horario
     */
    public function create()
    {
        return view('horarios.create');
    }

    /**
     * Guardar un nuevo horario
     */
    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'dia' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'aula' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')
            ->with('success', 'Horario creado correctamente.');
    }

    /**
     * Mostrar un horario específico
     */
    public function show(Horario $horario)
    {
        return view('horarios.show', compact('horario'));
    }

    /**
     * Mostrar formulario para editar un horario
     */
    public function edit(Horario $horario)
    {
        return view('horarios.edit', compact('horario'));
    }

    /**
     * Actualizar un horario
     */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'dia' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'aula' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $horario->update($request->all());

        return redirect()->route('horarios.index')
            ->with('success', 'Horario actualizado correctamente.');
    }

    /**
     * Eliminar un horario
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }
}
