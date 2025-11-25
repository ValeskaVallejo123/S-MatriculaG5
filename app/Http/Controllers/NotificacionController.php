<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;

class NotificacionController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Validar usuario logueado
    if (!$user) {
        abort(403, 'No hay usuario autenticado');
    }

    // Validar que el método notificaciones exista
    if (!method_exists($user, 'notificaciones')) {
        abort(500, 'El método notificaciones() no existe en el modelo User');
    }

    // Cargar todas las notificaciones ordenadas
    $notificaciones = $user->notificaciones->sortByDesc('created_at'); // Collection

    // Validar rol
    if (!$user->rol) {
        abort(403, 'El usuario no tiene rol asignado');
    }

    // Retornar la vista según el rol
    if (strtolower($user->rol->nombre) === 'estudiante') {
        return view('estudiante.notificaciones.index', compact('notificaciones'));
    } elseif (strtolower($user->rol->nombre) === 'profesor') {
        return view('profesor.notificaciones.index', compact('notificaciones'));
    }

    return abort(403, 'No autorizado');
}


    public function marcarLeida(Notificacion $notificacion)
    {
        $notificacion->leida = true;
        $notificacion->save();

        return back()->with('success', 'Notificación marcada como leída');
    }
}
