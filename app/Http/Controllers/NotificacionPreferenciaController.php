<?php

namespace App\Http\Controllers;

use App\Models\NotificacionPreferencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionPreferenciaController extends Controller
{
    public function edit()
    {
        $preferencias = Auth::user()->notificacionPreferencias;

        // Crear preferencias por defecto si no existen
        if (!$preferencias) {
            $preferencias = NotificacionPreferencia::create([
                'user_id' => Auth::id()
            ]);
        }

        return view('notificaciones.preferencias', compact('preferencias'));
    }

    public function update(Request $request)
    {
        $preferencias = Auth::user()->notificacionPreferencias;

        $preferencias->update([
            'correo'                     => $request->has('correo'),
            'mensaje_interno'            => $request->has('mensaje_interno'),
            'alerta_visual'              => $request->has('alerta_visual'),
            'notificacion_academica'     => $request->has('notificacion_academica'),
            'notificacion_administrativa'=> $request->has('notificacion_administrativa'),
            'recordatorios'              => $request->has('recordatorios'),
        ]);

        return back()->with('success', 'Tus preferencias han sido actualizadas correctamente.');
    }
}
