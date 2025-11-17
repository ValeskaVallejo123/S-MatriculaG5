<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificacionPreferencia;
use Illuminate\Support\Facades\Auth;

class NotificacionPreferenciaController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // Si no existen preferencias, generar una instancia vacía
        $preferencias = $user->notificacionPreferencias
            ?? new NotificacionPreferencia(['user_id' => $user->id]);

        return view('notificaciones.edit', compact('preferencias'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validación
        $request->validate([
            'correo' => 'nullable',
            'mensaje_interno' => 'nullable',
            'alerta_visual' => 'nullable',
            'notificacion_academica' => 'nullable',
            'notificacion_administrativa' => 'nullable',
            'recordatorios' => 'nullable',
        ]);

        // Convertir checkboxes a booleanos
        $data = [
            'correo'                     => $request->has('correo'),
            'mensaje_interno'            => $request->has('mensaje_interno'),
            'alerta_visual'              => $request->has('alerta_visual'),
            'notificacion_academica'     => $request->has('notificacion_academica'),
            'notificacion_administrativa'=> $request->has('notificacion_administrativa'),
            'recordatorios'              => $request->has('recordatorios'),
        ];

        // Guardar en la BD (crear o actualizar)
        $user->notificacionPreferencias()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->back()->with('success', 'Preferencias de notificación actualizadas correctamente.');
    }
}
