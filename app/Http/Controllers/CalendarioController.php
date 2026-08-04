<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventoAcademico;

class CalendarioController extends Controller
{
    /**
     * Vista del ADMIN — con CRUD completo.
     * URL: /calendario  (privada, requiere auth)
     */
    public function index()
    {
        return view('calendario-admin');
    }

    /**
     * Alias público de obtenerEventos — sin auth.
     * URL: GET /calendario/eventos/public
     */
    public function eventosPublicos()
    {
        return $this->obtenerEventos();
    }

    /**
     * Devuelve todos los eventos en JSON para FullCalendar.
     * extendedProps.tipo es la clave que usan los blades para colorear.
     */
    public function obtenerEventos()
    {
        try {
            $eventos = EventoAcademico::all()->map(function ($evento) {
                // FullCalendar necesita que end sea exclusivo (día siguiente)
                $fechaFin = $evento->fecha_fin
                    ? $evento->fecha_fin->copy()->addDay()
                    : $evento->fecha_inicio->copy()->addDay();

                return [
                    'id'    => $evento->id,
                    'title' => $evento->titulo,
                    'start' => $evento->fecha_inicio->format('Y-m-d'),
                    'end'   => $fechaFin->format('Y-m-d'),
                    'allDay'=> true,
                    'extendedProps' => [
                        'tipo'        => $evento->tipo,        // ← clave que usan los blades
                        'descripcion' => $evento->descripcion,
                        'grado'       => $evento->grado->nombre_grado
                                         ?? $evento->grado->nombre
                                         ?? null,
                    ],
                ];
            });

            return response()->json($eventos);

        } catch (\Exception $e) {
            return response()->json([
                'exito'   => false,
                'mensaje' => 'Error al obtener eventos: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Guarda un nuevo evento.
     * URL: POST /calendario/eventos
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo'         => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'descripcion'  => 'nullable|string',
            'hora_inicio'  => 'nullable|date_format:H:i',
            'hora_fin'     => 'nullable|date_format:H:i',
            'grado_id'     => 'nullable|exists:grados,id',
        ]);

        $evento = EventoAcademico::create([
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin ?? $request->fecha_inicio,
            'tipo'         => $request->tipo,
            'hora_inicio'  => $request->hora_inicio,
            'hora_fin'     => $request->hora_fin,
            'grado_id'     => $request->grado_id,
            'todo_el_dia'  => 1,
        ]);

        return response()->json([
            'exito'   => true,
            'mensaje' => 'Evento creado correctamente',
            'evento'  => $evento,
        ]);
    }

    /**
     * Devuelve datos de un evento en JSON para prellenar el form de edición.
     * URL: GET /calendario/eventos/{id}/edit
     */
    public function editJson($id)
    {
        $evento = EventoAcademico::findOrFail($id);

        return response()->json([
            'id'           => $evento->id,
            'titulo'       => $evento->titulo,
            'descripcion'  => $evento->descripcion,
            'fecha_inicio' => $evento->fecha_inicio?->format('Y-m-d'),
            'fecha_fin'    => $evento->fecha_fin?->format('Y-m-d'),
            'hora_inicio'  => $evento->hora_inicio,
            'hora_fin'     => $evento->hora_fin,
            'tipo'         => $evento->tipo,
            'grado_id'     => $evento->grado_id,
        ]);
    }

    /**
     * Actualiza un evento existente.
     * URL: PUT /calendario/eventos/{id}
     */
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo'         => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'descripcion'  => 'nullable|string',
            'hora_inicio'  => 'nullable|date_format:H:i',
            'hora_fin'     => 'nullable|date_format:H:i',
            'grado_id'     => 'nullable|exists:grados,id',
        ]);

        $evento = EventoAcademico::findOrFail($id);
        $evento->update([
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin ?? $request->fecha_inicio,
            'tipo'         => $request->tipo,
            'hora_inicio'  => $request->hora_inicio,
            'hora_fin'     => $request->hora_fin,
            'grado_id'     => $request->grado_id,
        ]);

        return response()->json([
            'exito'   => true,
            'mensaje' => 'Evento actualizado correctamente',
            'evento'  => $evento,
        ]);
    }

    /**
     * Elimina un evento.
     * URL: DELETE /calendario/eventos/{id}
     */
    public function eliminar($id)
    {
        $evento = EventoAcademico::findOrFail($id);
        $evento->delete();

        return response()->json([
            'exito'   => true,
            'mensaje' => 'Evento eliminado correctamente',
        ]);
    }
}