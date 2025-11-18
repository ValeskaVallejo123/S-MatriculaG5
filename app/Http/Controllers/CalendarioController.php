<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventoAcademico;

class CalendarioController extends Controller
{
    // Vista pública (solo lectura)
    public function vistaPublica()
    {
        return view('calendario', [
            'soloLectura' => true
        ]);
    }

    // Vista privada (editable)
    public function index()
    {
        return view('calendario', [
            'soloLectura' => false
        ]);
    }

    // Obtener todos los eventos (público)
    public function obtenerEventos()
    {
        $eventos = EventoAcademico::all()->map(function ($evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->fecha_inicio,
                'end' => $evento->fecha_fin,
                'color' => $evento->color,
                'type' => $evento->tipo,
                'description' => $evento->descripcion,
                'allDay' => $evento->todo_el_dia
            ];
        });

        return response()->json($eventos);
    }

    // Crear evento (solo autenticados)
    public function store(Request $request)
    {
        $validado = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'color' => 'required|string',
            'todo_el_dia' => 'boolean'
        ]);

        $evento = EventoAcademico::create($validado);

        return response()->json($evento, 201);
    }

    // Actualizar evento (solo autenticados)
    public function update(Request $request, $id)
    {
        $evento = EventoAcademico::findOrFail($id);

        $validado = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'color' => 'required|string'
        ]);

        $evento->update($validado);

        return response()->json($evento);
    }

    // Eliminar evento (solo autenticados)
    public function destroy($id)
    {
        $evento = EventoAcademico::findOrFail($id);
        $evento->delete();

        return response()->json(['message' => 'Evento eliminado correctamente']);
    }
}