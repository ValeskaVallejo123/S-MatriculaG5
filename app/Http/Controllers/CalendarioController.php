<?php

namespace App\Http\Controllers;

use App\Models\EventoAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    /**
     * Muestra la vista del calendario
     */
    public function index()
    {
        return view('calendario');
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
    public function guardar(Request $request) {
    $validado = $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'tipo' => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
        'color' => 'required|string',
        'todo_el_dia' => 'nullable|boolean' // <--- DEBES AGREGAR ESTO
    ]);

    // Forzar el valor booleano si no viene
    $validado['todo_el_dia'] = $request->todo_el_dia ?? true;

    $evento = EventoAcademico::create($validado);
    return response()->json(['exito' => true, 'evento' => $evento]);
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
}