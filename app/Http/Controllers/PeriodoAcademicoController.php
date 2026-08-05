<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodoAcademico;

class PeriodoAcademicoController extends Controller
{
    public function __construct()
    {
        // SOLO admin y super_admin pueden hacer CRUD
        $this->middleware(['auth', 'role:admin,super_admin'])
            ->except(['index']); // index es visible para todos
    }

    /**
     * Mostrar la lista de períodos académicos (visible para todos los roles)
     */
    public function index()
    {
        $periodos  = PeriodoAcademico::orderBy('fecha_inicio')->get();
        $enCurso   = $periodos->filter(fn($p) => $p->estaActivo())->count();
        $proximos  = $periodos->filter(fn($p) => $p->fecha_inicio->isFuture())->count();
        $finalizados = $periodos->filter(fn($p) => $p->fecha_fin->isPast())->count();

        return view('definirperiodosacademicos.index', compact(
            'periodos', 'enCurso', 'proximos', 'finalizados'
        ));
    }

    /**
     * Mostrar formulario de creación (solo admin y super_admin)
     */
    public function create()
    {
        return view('definirperiodosacademicos.create');
    }

    /**
     * Guardar nuevo período académico (solo admin y super_admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_periodo' => 'required|string|max:100',
            'tipo' => 'required|in:clases,vacaciones,examenes',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        PeriodoAcademico::create(
            $request->only(['nombre_periodo', 'tipo', 'fecha_inicio', 'fecha_fin'])
        );

        return redirect()->route('periodos-academicos.index')
            ->with('success', 'Período académico creado correctamente.');
    }

    /**
     * Mostrar formulario de edición (solo admin y super_admin)
     */
    public function edit($id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        return view('definirperiodosacademicos.edit', compact('periodo'));
    }

    /**
     * Actualizar período académico (solo admin y super_admin)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_periodo' => 'required|string|max:100',
            'tipo' => 'required|in:clases,vacaciones,examenes',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $periodo = PeriodoAcademico::findOrFail($id);

        $periodo->update(
            $request->only(['nombre_periodo', 'tipo', 'fecha_inicio', 'fecha_fin'])
        );

        return redirect()->route('periodos-academicos.index')
            ->with('success', 'Período académico actualizado correctamente.');
    }

    /**
     * Eliminar período académico (solo admin y super_admin)
     */
    public function destroy($id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        $periodo->delete();

        return redirect()->route('periodos-academicos.index')
            ->with('success', 'Período académico eliminado correctamente.');
    }
}