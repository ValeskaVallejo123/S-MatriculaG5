<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventoAcademico;

class CalendarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('calendario');
    }

    public function obtenerEventos()
    {
        $eventos = EventoAcademico::all()->map(function($evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->fecha_inicio->format('Y-m-d'),
                'end' => $evento->fecha_fin->copy()->addDay()->format('Y-m-d'),
                'backgroundColor' => $evento->color,
                'borderColor' => $evento->color,
                'allDay' => (bool) $evento->todo_el_dia,
                'extendedProps' => [
                    'description' => $evento->descripcion,
                    'type' => $evento->tipo
                ]
            ];
        });

        return response()->json($eventos);
    }

    public function guardar(Request $request)
    {
        $validado = $this->validarEvento($request);

        $evento = EventoAcademico::create($validado);

        return response()->json([
            'exito' => true,
            'evento' => $evento
        ]);
    }

    public function actualizar(Request $request, EventoAcademico $evento)
    {
        $validado = $this->validarEvento($request);

        $evento->update($validado);

        return response()->json([
            'exito' => true,
            'evento' => $evento
        ]);
    }

    public function eliminar(EventoAcademico $evento)
    {
        $evento->delete();

        return response()->json([
            'exito' => true
        ]);
    }

    private function validarEvento(Request $request)
    {
        return $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'color' => 'required|string'
        ]);
    }
}
