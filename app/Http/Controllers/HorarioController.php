<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HorarioController extends Controller
{
    public function __construct()
    {
        // CRUD solo disponible para ADMIN y SUPERADMIN
        $this->middleware(['auth', 'rol:admin,super_admin'])
            ->only(['create', 'store', 'edit', 'update', 'destroy']);

        // index, PDF y miHorario accesibles para todos los roles permitidos
        $this->middleware('auth');
    }

    /**
     * Mostrar horarios (según el rol)
     */
    public function index()
    {
        $user = Auth::user();

        $query = Horario::with('profesor')
            ->orderBy('dia')
            ->orderBy('hora_inicio');

        // PROFESOR: solo ve sus horarios
        if ($user->role === 'profesor') {
            $query->where('profesor_id', $user->id);
        }

        // ESTUDIANTE: ve su horario por grado & sección
        if ($user->role === 'estudiante') {
            $query->where('grado', $user->grado)
                  ->where('seccion', $user->seccion);
        }

        // ADMIN y SUPERADMIN ven todos
        $horarios = $query->paginate(10);

        return view('horarios.index', compact('horarios'));
    }

    /**
     * Descargar PDF del horario (Profesor / Estudiante)
     */
    public function exportPDF()
    {
        $user = Auth::user();

        if ($user->role === 'profesor') {
            $horarios = Horario::with('profesor')
                ->where('profesor_id', $user->id)
                ->orderBy('dia')
                ->orderBy('hora_inicio')
                ->get();

            return Pdf::loadView('horarios.pdf', [
                'horarios' => $horarios,
                'usuario' => $user
            ])->download('horario_profesor.pdf');
        }

        if ($user->role === 'estudiante') {
            $horarios = Horario::with('profesor')
                ->where('grado', $user->grado)
                ->where('seccion', $user->seccion)
                ->orderBy('dia')
                ->orderBy('hora_inicio')
                ->get();

            return Pdf::loadView('horarios.pdf', [
                'horarios' => $horarios,
                'usuario' => $user
            ])->download('horario_estudiante.pdf');
        }

        abort(403, 'No tienes permisos para descargar PDF.');
    }

    /**
     * Crear horario (solo ADMIN / SUPERADMIN)
     */
    public function create()
    {
        return view('horarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:users,id',
            'dia' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'aula' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        Horario::create($request->only([
            'profesor_id', 'dia', 'hora_inicio', 'hora_fin',
            'grado', 'seccion', 'aula', 'observaciones'
        ]));

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
            'profesor_id' => 'required|exists:users,id',
            'dia' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'aula' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $horario->update($request->only([
            'profesor_id', 'dia', 'hora_inicio', 'hora_fin',
            'grado', 'seccion', 'aula', 'observaciones'
        ]));

        return redirect()->route('horarios.index')
            ->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }

    /**
     * Horario del estudiante (solo rol estudiante)
     */
    public function miHorario()
    {
        $user = Auth::user();

        if ($user->role !== 'estudiante') {
            abort(403, 'No tienes permisos para ver este horario.');
        }

        $horario = Horario::with('profesor')
            ->where('grado', $user->grado)
            ->where('seccion', $user->seccion)
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        return view('estudiante.miHorario', compact('horario'));
    }
}
