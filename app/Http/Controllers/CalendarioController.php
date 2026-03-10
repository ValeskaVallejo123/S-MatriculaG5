<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventoAcademico;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('calendario.index');
    }

    public function obtenerEventos(Request $request)
    {
        try {
            $query = EventoAcademico::query();

            if ($request->filled('start')) {
                $query->whereDate('fecha_fin', '>=', $request->start);
            }
            if ($request->filled('end')) {
                $query->whereDate('fecha_inicio', '<=', $request->end);
            }

            $eventos = $query->get()->map(function (EventoAcademico $evento) {
                return [
                    'id'              => $evento->id,
                    'title'           => $evento->titulo,
                    'start'           => $evento->fecha_inicio->format('Y-m-d'),
                    'end'             => $evento->fecha_fin
                        ? $evento->fecha_fin->copy()->addDay()->format('Y-m-d')
                        : $evento->fecha_inicio->copy()->addDay()->format('Y-m-d'),
                    'backgroundColor' => $evento->color_final,
                    'borderColor'     => $evento->color_final,
                    'allDay'          => (bool) $evento->todo_el_dia,
                    'extendedProps'   => [
                        'description' => $evento->descripcion,
                        'type'        => $evento->tipo,
                    ],
                ];
            });

            return response()->json($eventos);

        } catch (\Exception $e) {
            return response()->json(['exito' => false, 'mensaje' => $e->getMessage()], 500);
        }
    }

    public function eventosPublicos(Request $request)
    {
        $tiposPublicos = ['festivo', 'evento', 'vacaciones', 'prematricula', 'matricula'];

        $eventos = EventoAcademico::whereIn('tipo', $tiposPublicos)->get()
            ->map(function (EventoAcademico $evento) {
                return [
                    'id'              => $evento->id,
                    'title'           => $evento->titulo,
                    'start'           => $evento->fecha_inicio->format('Y-m-d'),
                    'end'             => $evento->fecha_fin
                        ? $evento->fecha_fin->copy()->addDay()->format('Y-m-d')
                        : $evento->fecha_inicio->copy()->addDay()->format('Y-m-d'),
                    'backgroundColor' => $evento->color_final,
                    'borderColor'     => $evento->color_final,
                    'allDay'          => (bool) $evento->todo_el_dia,
                    'extendedProps'   => [
                        'description' => $evento->descripcion,
                        'type'        => $evento->tipo,
                    ],
                ];
            });

        return response()->json($eventos);
    }

    public function store(Request $request)
    {
        if (!$this->esSuperAdmin()) {
            return response()->json(['exito' => false, 'mensaje' => 'No tienes permisos'], 403);
        }

        $request->validate([
            'titulo'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'tipo'         => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'color'        => 'nullable|string',
            'todo_el_dia'  => 'nullable|boolean',
        ]);

        $colores = EventoAcademico::obtenerColoresPorTipo();

        $evento = EventoAcademico::create([
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'tipo'         => $request->tipo,
            'color'        => $request->color ?: ($colores[$request->tipo] ?? '#3788d8'),
            'todo_el_dia'  => $request->todo_el_dia ?? true,
        ]);

        return response()->json(['exito' => true, 'mensaje' => 'Evento creado correctamente', 'evento' => $evento]);
    }

    public function actualizar(Request $request, $id)
    {
        if (!$this->esSuperAdmin()) {
            return response()->json(['exito' => false, 'mensaje' => 'No tienes permisos'], 403);
        }

        try {
            $validated = $request->validate([
                'titulo'       => 'required|string|max:150',
                'descripcion'  => 'nullable|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
                'tipo'         => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
                'color'        => 'nullable|string',
                'todo_el_dia'  => 'boolean',
            ]);

            $colores = EventoAcademico::obtenerColoresPorTipo();
            if (empty($validated['color'])) {
                $validated['color'] = $colores[$validated['tipo']] ?? '#3788d8';
            }
            $validated['todo_el_dia'] = $request->boolean('todo_el_dia');

            $evento = EventoAcademico::findOrFail($id);
            $evento->update($validated);

            return response()->json(['exito' => true, 'mensaje' => 'Evento actualizado', 'evento' => $evento]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['exito' => false, 'errores' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['exito' => false, 'mensaje' => $e->getMessage()], 500);
        }
    }

    public function eliminar(EventoAcademico $evento)
    {
        if (!$this->esSuperAdmin()) {
            return response()->json(['exito' => false, 'mensaje' => 'No tienes permisos'], 403);
        }

        try {
            $evento->delete();
            return response()->json(['exito' => true, 'mensaje' => 'Evento eliminado']);
        } catch (\Exception $e) {
            return response()->json(['exito' => false, 'mensaje' => $e->getMessage()], 500);
        }
    }

    /**
     * Usa user_type = 'super_admin' O is_super_admin = true
     */
    private function esSuperAdmin(): bool
    {
        $user = Auth::user();
        return $user && ($user->user_type === 'super_admin' || $user->is_super_admin == true);
    }
}
