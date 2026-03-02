<?php

namespace App\Http\Controllers;

use App\Models\EventoAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    /**
     * Muestra la vista del calendario
     */
    public function index()
    {
        $eventos = EventoAcademico::all();

        return response()->json($eventos->map(function ($evento) {
            return [
                'id'            => $evento->id,
                'title'         => $evento->titulo,
                'start'         => $evento->fecha_inicio,
                'end'           => $evento->fecha_fin,
                'color'         => $evento->color,
                'extendedProps' => [
                    'description' => $evento->descripcion,
                    'type'        => $evento->tipo,
                ],
            ];
        }));
    }

    /**
     * Alias público del index (eventos visibles sin autenticación)
     */
    public function eventosPublicos()
    {
        return $this->index();
    }

    /**
     * Obtiene todos los eventos en formato JSON para FullCalendar
     */
    public function obtenerEventos()
    {
        try {
            $eventos = EventoAcademico::all()->map(function ($evento) {
                // Crear copia para no mutar el objeto original
                $fechaFin = $evento->fecha_fin
                    ? $evento->fecha_fin->copy()->addDay()
                    : $evento->fecha_inicio->copy()->addDay();

                return [
                    'id'              => $evento->id,
                    'title'           => $evento->titulo,
                    'start'           => $evento->fecha_inicio->format('Y-m-d'),
                    'end'             => $fechaFin->format('Y-m-d'),
                    'backgroundColor' => $evento->color,
                    'borderColor'     => $evento->color,
                    'allDay'          => $evento->todo_el_dia,
                    'extendedProps'   => [
                        'description' => $evento->descripcion,
                        'type'        => $evento->tipo,
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
     * Guarda un nuevo evento
     */
    public function store(Request $request)
    {
        // Verificar permisos
        if (!$this->tienePermisos()) {
            return response()->json([
                'exito'   => false,
                'mensaje' => 'No tienes permisos para crear eventos.',
            ], 403);
        }

        $validado = $this->validarEvento($request);

        // Asignar valor por defecto a todo_el_dia
        $validado['todo_el_dia'] = $request->boolean('todo_el_dia', true);

        $evento = EventoAcademico::create($validado);

        return response()->json([
            'exito'   => true,
            'mensaje' => 'Evento creado correctamente.',
            'evento'  => $evento,
        ], 201);
    }

    /**
     * Actualiza un evento existente
     */
    public function actualizar(Request $request, $id)
    {
        // Verificar permisos
        if (!$this->tienePermisos()) {
            return response()->json([
                'exito'   => false,
                'mensaje' => 'No tienes permisos para actualizar eventos.',
            ], 403);
        }

        try {
            $validado = $this->validarEvento($request);

            // Forzar valor booleano en todo_el_dia
            $validado['todo_el_dia'] = $request->boolean('todo_el_dia');

            $evento = EventoAcademico::findOrFail($id);
            $evento->update($validado);

            return response()->json([
                'exito'   => true,
                'mensaje' => 'Evento actualizado con éxito.',
                'evento'  => $evento->fresh(), // Retornar el evento actualizado
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'exito'   => false,
                'errores' => $e->errors(),
            ], 422);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'exito'   => false,
                'mensaje' => 'Evento no encontrado.',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'exito'   => false,
                'mensaje' => 'Error al actualizar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Elimina un evento
     */
    public function eliminar($id)
    {
        // Verificar permisos
        if (!$this->tienePermisos()) {
            return response()->json([
                'exito'   => false,
                'mensaje' => 'No tienes permisos para eliminar eventos.',
            ], 403);
        }

        try {
            $evento = EventoAcademico::findOrFail($id);
            $evento->delete();

            return response()->json([
                'exito'   => true,
                'mensaje' => 'Evento eliminado con éxito.',
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'exito'   => false,
                'mensaje' => 'Evento no encontrado.',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'exito'   => false,
                'mensaje' => 'Error al eliminar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Valida los campos de un evento (reutilizable)
     */
    private function validarEvento(Request $request): array
    {
        return $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'   => 'required|date|after_or_equal:fecha_inicio',
            'tipo'        => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'color'       => 'required|string',
            'todo_el_dia' => 'nullable|boolean',
        ]);
    }

    /**
     * Verifica si el usuario autenticado tiene permisos de admin o superadmin
     */
    private function tienePermisos(): bool
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return false;
        }

        // Compatible con tu sistema de id_rol: 1 = superadmin, 2 = admin
        return in_array($usuario->id_rol, [1, 2]);
    }
}
