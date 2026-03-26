<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventoAcademico;
use Illuminate\Contracts\View\View;

class CalendarioController extends Controller
{
    /**
     * Muestra todos los eventos en formato JSON simple (index básico).
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


    /**
     * Eventos públicos (sin auth) — usa obtenerEventos() con formato completo.
     */
    public function eventosPublicos()
    {
        return $this->obtenerEventos();
    }

    /**
     * Obtiene todos los eventos en formato JSON para FullCalendar.
     * CORRECCIÓN: usar ->copy()->addDay() para no mutar el objeto original.
     * CORRECCIÓN: manejo de fecha_fin nula usando fecha_inicio como fallback.
     */
    public function obtenerEventos()
    {
        try {
            $eventos = EventoAcademico::all()->map(function($evento) {
                // CORRECCIÓN: No usar addDay() directamente sobre el objeto
                // Crear una copia para no modificar el original
                $fechaFin = $evento->fecha_fin ? $evento->fecha_fin->copy()->addDay() : $evento->fecha_inicio->copy()->addDay();

                return [
                    'id'              => $evento->id,
                    'title'           => $evento->titulo,
                    'start'           => $evento->fecha_inicio->format('Y-m-d'),
                    'end'             => $fechaFin->format('Y-m-d'),
                    'backgroundColor' => $evento->color,
                    'borderColor'     => $evento->color,
                    'allDay'          => (bool) $evento->todo_el_dia,
                    'extendedProps'   => [
                        'description' => $evento->descripcion,
                        'type'        => $evento->tipo,
                    ],
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
                'exito'  => false,
                'mensaje' => 'Error al obtener eventos: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Guarda un nuevo evento.
     */
    public function store(Request $request)
{
    try {

        $validado = $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|string',
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string',
            'todo_el_dia' => 'nullable|boolean',
        ]);

        $evento = EventoAcademico::create($validado);

        return response()->json([
            'mensaje' => 'Evento creado correctamente',
            'evento' => $evento
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([
            'mensaje' => 'Error de validación',
            'errores' => $e->errors()
        ], 422);
    }
}

    /**
     * Actualiza un evento existente.
     * CORRECCIÓN: primero validar permisos, luego buscar el evento,
     * luego actualizar — en ese orden correcto.
     */
    public function actualizar(Request $request, $id)
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
            $validado = $this->validarEvento($request);

            // Forzar valor booleano
            if ($request->has('todo_el_dia')) {
                $validado['todo_el_dia'] = $request->boolean('todo_el_dia');
            }

            $evento = EventoAcademico::findOrFail($id);
            $evento->update($validado);

            return response()->json([
                'exito'  => true,
                'mensaje' => 'Evento actualizado con éxito',
                'evento'  => $evento,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'exito'   => false,
                'errores' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'exito'  => false,
                'mensaje' => 'Error al actualizar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Elimina un evento.
     */
    public function eliminar(EventoAcademico $evento)
    {
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            return response()->json([
                'exito'  => false,
                'mensaje' => 'No tienes permisos',
            ], 403);
        }

        try {
            $evento->delete();

            return response()->json([
                'exito'  => true,
                'mensaje' => 'Evento eliminado con éxito',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'exito'  => false,
                'mensaje' => 'Error al eliminar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validación compartida entre store() y actualizar().
     * Extraída del archivo 2 para evitar duplicar reglas.
     */
    private function validarEvento(Request $request): array
    {
        return $request->validate([
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'tipo'         => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'color'        => 'required|string',
        ]);
    }
}