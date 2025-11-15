<?php

namespace App\Http\Controllers;

use App\Models\EventoAcademico;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
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
                'end' => $evento->fecha_fin->addDay()->format('Y-m-d'),
                'backgroundColor' => $evento->color,
                'borderColor' => $evento->color,
                'allDay' => $evento->todo_el_dia,
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
        $validado = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'color' => 'required|string'
        ]);

        $evento = EventoAcademico::create($validado);

        return response()->json([
            'exito' => true,
            'evento' => $evento
        ]);
    }

    public function actualizar(Request $request, EventoAcademico $evento)
    {
        $validado = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'color' => 'required|string'
        ]);

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
}