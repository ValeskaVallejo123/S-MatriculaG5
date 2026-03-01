<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

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
            'id' => $evento->id,
            'title' => $evento->titulo,
            'start' => $evento->fecha_inicio,
            'end' => $evento->fecha_fin,
            'color' => $evento->color,
            'extendedProps' => [
                'description' => $evento->descripcion,
                'type' => $evento->tipo
            ]
        ];
    }));
}


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
            $eventos = EventoAcademico::all()->map(function($evento) {
                // CORRECCIÓN: No usar addDay() directamente sobre el objeto
                // Crear una copia para no modificar el original
                $fechaFin = $evento->fecha_fin ? $evento->fecha_fin->copy()->addDay() : $evento->fecha_inicio->copy()->addDay();
                
                return [
                    'id' => $evento->id,
                    'title' => $evento->titulo,
                    'start' => $evento->fecha_inicio->format('Y-m-d'),
                    'end' => $fechaFin->format('Y-m-d'),
                    'backgroundColor' => $evento->color,
                    'borderColor' => $evento->color,
                    'allDay' => $evento->todo_el_dia,
                    'extendedProps' => [
                        'description' => $evento->descripcion,
                        'type' => $evento->tipo
                    ]
                ];
            });
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
        } catch (\Exception $e) {
            return response()->json([
                'exito' => false,
                'mensaje' => 'Error al obtener eventos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guarda un nuevo evento
     */
    public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'tipo' => 'required|string',
        'descripcion' => 'nullable|string',
        'color' => 'nullable|string',
        'todo_el_dia' => 'nullable|boolean',
    ]);

    $evento = EventoAcademico::create([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'tipo' => $request->tipo,
        'color' => $request->color,
        'todo_el_dia' => $request->todo_el_dia ?? 1,
    ]);

    return response()->json([
        'mensaje' => 'Evento creado correctamente',
        'evento' => $evento
    ]);
}

    /**
     * Actualiza un evento existente
     */
    public function actualizar(Request $request,  $id)
    {
        // Verificar permisos
        // En el método actualizar y eliminar, cambia esto:
if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) { // Usar 'role' y 'super_admin'
    return response()->json([
        'exito' => false,
        'mensaje' => 'No tienes permisos'
    ], 403);
}

        try {
            $validado = $request->validate([
                'titulo' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'tipo' => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
                'color' => 'required|string',
                'todo_el_dia' => 'boolean'
            ]);

            // Forzar valor booleano
            if ($request->has('todo_el_dia')) {
                $validado['todo_el_dia'] = $request->boolean('todo_el_dia');
            }

            $eventoAcademico = EventoAcademico::findOrFail($id);

            return response()->json([
                'exito' => true,
                'mensaje' => 'Evento actualizado con éxito',
                'evento' => $eventoAcademico->update($validado) // CORRECCIÓN: Actualizar el evento después de encontrarlo
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'exito' => false,
                'errores' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'exito' => false,
                'mensaje' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un evento
     */
    public function eliminar(EventoAcademico $evento)
    {
        // Verificar permisos
        // En el método actualizar y eliminar, cambia esto:
if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) { // Usar 'role' y 'super_admin'
    return response()->json([
        'exito' => false,
        'mensaje' => 'No tienes permisos'
    ], 403);
}

        try {
            $evento->delete();

            return response()->json([
                'exito' => true,
                'mensaje' => 'Evento eliminado con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'exito' => false,
                'mensaje' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
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
