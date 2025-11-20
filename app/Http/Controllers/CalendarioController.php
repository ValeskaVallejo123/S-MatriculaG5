<?php

namespace App\Http\Controllers;

use App\Models\EventoAcademico;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    // ========== VISTAS ==========
    
    /**
     * Vista pública (Solo lectura)
     */
    public function vistaPublica()
    {
        return view('calendario.index', [
            'soloLectura' => true
        ]);
    }
    
    /**
     * Vista administrador (Edición completa)
     */
    public function vistaAdmin()
    {
        return view('calendario.index', [
            'soloLectura' => false
        ]);
    }
    
    // ========== API PÚBLICA ==========
    
    /**
     * Obtener eventos para vista pública
     */
    public function eventosPublicos()
    {
        $eventos = EventoAcademico::all()->map(function ($evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->fecha_inicio,
                'end' => $evento->fecha_fin,
                'color' => $evento->color,
                'allDay' => $evento->todo_el_dia,
                'type' => $evento->tipo,
                'description' => $evento->descripcion,
                'extendedProps' => [
                    'type' => $evento->tipo,
                    'description' => $evento->descripcion
                ]
            ];
        });
        
        return response()->json($eventos);
    }
    
    // ========== API ADMINISTRADOR ==========
    
    /**
     * Listar todos los eventos (Admin)
     */
    public function listarEventos()
    {
        $eventos = EventoAcademico::all()->map(function ($evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->fecha_inicio,
                'end' => $evento->fecha_fin,
                'color' => $evento->color,
                'allDay' => $evento->todo_el_dia,
                'type' => $evento->tipo,
                'description' => $evento->descripcion,
                'extendedProps' => [
                    'type' => $evento->tipo,
                    'description' => $evento->descripcion
                ]
            ];
        });
        
        return response()->json($eventos);
    }
    
    /**
     * Crear nuevo evento (Admin)
     */
    public function crearEvento(Request $request)
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
        
        return response()->json([
            'success' => true,
            'message' => 'Evento creado exitosamente',
            'evento' => $evento
        ], 201);
    }
    
    /**
     * Actualizar evento existente (Admin)
     */
    public function actualizarEvento(Request $request, $id)
    {
        $evento = EventoAcademico::findOrFail($id);
        
        $validado = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:clase,examen,festivo,evento,vacaciones,prematricula,matricula',
            'color' => 'required|string',
            'todo_el_dia' => 'boolean'
        ]);
        
        $evento->update($validado);
        
        return response()->json([
            'success' => true,
            'message' => 'Evento actualizado exitosamente',
            'evento' => $evento
        ]);
    }
    
    /**
     * Eliminar evento (Admin)
     */
    public function eliminarEvento($id)
    {
        $evento = EventoAcademico::findOrFail($id);
        $evento->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Evento eliminado exitosamente'
        ]);
    }
}