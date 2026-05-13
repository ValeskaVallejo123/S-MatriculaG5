<?php

namespace App\Http\Controllers;

use App\Models\EventoAcademico;
use Illuminate\Http\Request;

class EventoAcademicoController extends Controller
{
    // Tipos válidos — deben coincidir con el enum de la migración
    private array $tiposValidos = [
        'clase',
        'examen',
        'festivo',
        'evento',
        'vacaciones',
        'prematricula',
        'matricula',
    ];

    // ────────────────────────────────────────────────────────────────────────
    // INDEX
    // ────────────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = EventoAcademico::latest('fecha_inicio');

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por rango de fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_inicio', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_inicio', '<=', $request->fecha_hasta);
        }

        $eventos = $query->paginate(10)->withQueryString();
        $tipos   = $this->tiposValidos;
        $filtros = $request->only(['tipo', 'fecha_desde', 'fecha_hasta']);

        return view('eventos_academicos.index', compact('eventos', 'tipos', 'filtros'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // CREATE
    // ────────────────────────────────────────────────────────────────────────

    public function create()
    {
        $tipos   = $this->tiposValidos;
        $colores = EventoAcademico::obtenerColoresPorTipo();

        return view('eventos_academicos.create', compact('tipos', 'colores'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // STORE
    // ────────────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'tipo'         => 'required|string|in:' . implode(',', $this->tiposValidos),
            // color: tiene default en BD, si no se envía se usa el del tipo
            'color'        => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'todo_el_dia'  => 'boolean',
        ]);

        // Si no se elige color manual, usamos el color del tipo definido en el modelo
        if (empty($validated['color'])) {
            $colores = EventoAcademico::obtenerColoresPorTipo();
            $validated['color'] = $colores[$validated['tipo']] ?? '#3788d8';
        }

        $validated['todo_el_dia'] = $request->boolean('todo_el_dia', true);

        EventoAcademico::create($validated);

        return redirect()->route('eventos_academicos.index')
            ->with('success', 'Evento académico creado correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // SHOW
    // ────────────────────────────────────────────────────────────────────────

    public function show(EventoAcademico $eventos_academico)
    {
        return view('eventos_academicos.show', [
            'evento' => $eventos_academico,
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────
    // EDIT
    // ────────────────────────────────────────────────────────────────────────

    public function edit(EventoAcademico $eventos_academico)
    {
        $tipos   = $this->tiposValidos;
        $colores = EventoAcademico::obtenerColoresPorTipo();

        return view('eventos_academicos.edit', [
            'evento'  => $eventos_academico,
            'tipos'   => $tipos,
            'colores' => $colores,
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ────────────────────────────────────────────────────────────────────────

    public function update(Request $request, EventoAcademico $eventos_academico)
    {
        $validated = $request->validate([
            'titulo'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'tipo'         => 'required|string|in:' . implode(',', $this->tiposValidos),
            'color'        => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'todo_el_dia'  => 'boolean',
        ]);

        // Si no se elige color manual, usamos el color del tipo
        if (empty($validated['color'])) {
            $colores = EventoAcademico::obtenerColoresPorTipo();
            $validated['color'] = $colores[$validated['tipo']] ?? '#3788d8';
        }

        $validated['todo_el_dia'] = $request->boolean('todo_el_dia', true);

        $eventos_academico->update($validated);

        return redirect()->route('eventos_academicos.index')
            ->with('success', 'Evento académico actualizado correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // DESTROY
    // ────────────────────────────────────────────────────────────────────────

    public function destroy(EventoAcademico $eventos_academico)
    {
        $eventos_academico->delete();

        return redirect()->route('eventos_academicos.index')
            ->with('success', 'Evento académico eliminado correctamente.');
    }

    // ────────────────────────────────────────────────────────────────────────
    // API JSON — para FullCalendar
    // ────────────────────────────────────────────────────────────────────────

    public function calendario(Request $request)
    {
        $query = EventoAcademico::query();

        // FullCalendar envía start y end para el rango visible
        if ($request->filled('start')) {
            $query->whereDate('fecha_fin', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->whereDate('fecha_inicio', '<=', $request->end);
        }

        $eventos = $query->get()->map(function (EventoAcademico $evento) {
            return [
                'id'          => $evento->id,
                'title'       => $evento->titulo,
                'start'       => $evento->fecha_inicio,   // date — ya es string YYYY-MM-DD
                'end'         => $evento->fecha_fin,
                'color'       => $evento->color_final,    // accessor del modelo
                'allDay'      => $evento->todo_el_dia,
                'description' => $evento->descripcion,
                'tipo'        => $evento->tipo,
                'duracion'    => $evento->duracion,       // accessor del modelo
                'esDeUnDia'   => $evento->es_de_un_dia,   // accessor del modelo
            ];
        });

        return response()->json($eventos);
    }

    // ────────────────────────────────────────────────────────────────────────
    // EVENTOS PÚBLICOS — sin autenticación
    // ────────────────────────────────────────────────────────────────────────

    public function eventosPublicos(Request $request)
    {
        $tiposPublicos = ['festivo', 'evento', 'vacaciones', 'prematricula', 'matricula'];

        $query = EventoAcademico::whereIn('tipo', $tiposPublicos);

        if ($request->filled('start')) {
            $query->whereDate('fecha_fin', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->whereDate('fecha_inicio', '<=', $request->end);
        }

        $eventos = $query->get()->map(function (EventoAcademico $evento) {
            return [
                'id'          => $evento->id,
                'title'       => $evento->titulo,
                'start'       => $evento->fecha_inicio,
                'end'         => $evento->fecha_fin,
                'color'       => $evento->color_final,
                'allDay'      => $evento->todo_el_dia,
                'description' => $evento->descripcion,
                'tipo'        => $evento->tipo,
            ];
        });

        return response()->json($eventos);
    }
}
