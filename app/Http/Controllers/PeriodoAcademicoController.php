<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PeriodoAcademico;

class PeriodoAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodos = PeriodoAcademico::orderBy('fecha_inicio')->get();
        return view('definirperiodosacademicos.index', compact('periodos'));
    }

    public function create()
    {
        return view('definirperiodosacademicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_periodo' => 'required|string|max:100',
            'tipo' => 'required|in:clases,vacaciones,examenes',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        PeriodoAcademico::create($request->all());

        return redirect()->route('periodos-academicos.index')
            ->with('success', 'Período académico creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        return view('definirperiodosacademicos.edit', compact('periodo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_periodo' => 'required|string|max:100',
            'tipo' => 'required|in:clases,vacaciones,examenes',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $periodo = PeriodoAcademico::findOrFail($id);
        $periodo->update($request->all());

        return redirect()->route('periodos-academicos.index')
            ->with('success', 'Período académico actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $periodo = PeriodoAcademico::findOrFail($id);
        $periodo->delete();

        return redirect()->route('periodos-academicos.index')
            ->with('success', 'Período académico eliminado correctamente.');
    }
}
