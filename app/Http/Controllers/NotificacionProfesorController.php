<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionProfesorController extends Controller
{
    public function __construct()
    {
        // Cualquier usuario autenticado puede ver sus notificaciones
        $this->middleware('auth');
    }

    /**
     * Mostrar notificaciones del profesor autenticado
     */
    public function index()
    {
        $usuario = Auth::user();

        if (!$usuario->isDocente()) {
            abort(403, 'Solo los profesores pueden ver esta sección.');
        }

        $notificaciones = $usuario->notificaciones()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('profesor.notificaciones.index', compact('notificaciones'));
    }

    /**
     * Marcar una notificación como leída
     */
    public function marcarLeida(Notificacion $notificacion)
    {
        $usuario = Auth::user();

        // Validar que sea su notificación
        if ($notificacion->user_id !== $usuario->id) {
            abort(403, 'No autorizado');
        }

        $notificacion->update(['leida' => true]);

        return back()->with('success', 'Notificación marcada como leída.');
    }

    /**
     * Profesor envía notificación a Administración (Admins y SuperAdmins)
     */
    public function enviarAAdministracion(Request $request)
    {
        $usuario = Auth::user();

        // Solo profesores
        if (!$usuario->isDocente()) {
            abort(403, 'Solo profesores pueden enviar mensajes a administración.');
        }

        $request->validate([
            'titulo'  => 'required|string|max:255',
            'mensaje' => 'required|string|max:2000',
        ]);

        // Buscar Admins y SuperAdmins
        $destinatarios = User::whereIn('id_rol', [1, 2])->get();

        foreach ($destinatarios as $admin) {
            Notificacion::create([
                'user_id'      => $admin->id,
                'remitente_id' => $usuario->id,
                'titulo'       => $request->titulo,
                'mensaje'      => $request->mensaje,
                'tipo'         => 'mensaje_profesor',
                'leida'        => false,
            ]);
        }

        return back()->with('success', 'Mensaje enviado correctamente a la administración.');
    }

    /**
     * Método estático para enviar notificaciones desde otros controladores
     */
    public static function crearAutomatica(
        int $destinatarioId,
        string $titulo,
        string $mensaje,
        ?int $remitenteId = null,
        string $tipo = 'general'
    ) {
        return Notificacion::create([
            'user_id'      => $destinatarioId,
            'remitente_id' => $remitenteId,
            'titulo'       => $titulo,
            'mensaje'      => $mensaje,
            'tipo'         => $tipo,
            'leida'        => false,
        ]);
    }
}
