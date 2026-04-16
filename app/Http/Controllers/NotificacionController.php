<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;
use App\Models\User;

class NotificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar notificaciones según el rol del usuario
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $notificaciones = Notificacion::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('notificaciones.index', compact('notificaciones'));
    }

    /**
     * Marcar notificación como leída (solo el dueño)
     */
    public function marcarLeida(Notificacion $notificacion)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($notificacion->user_id !== $user->id) {
            abort(403, 'No puedes modificar esta notificación');
        }

        $notificacion->update(['leida' => true]);

        return back()->with('success', 'Notificación marcada como leída');
    }

    /**
     * ADMIN / SUPERADMIN — crear una notificación para un usuario
     */
    public function store(Request $request)
    {
        $this->autorizarAdmin();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'titulo'  => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tipo'    => 'required|string',
        ]);

        Notificacion::create([
            'user_id' => $request->user_id,
            'titulo'  => $request->titulo,
            'mensaje' => $request->mensaje,
            'tipo'    => $request->tipo,
            'leida'   => false,
        ]);

        return back()->with('success', 'Notificación enviada correctamente.');
    }

    /**
     * ADMIN / SUPERADMIN — eliminar una notificación
     */
    public function destroy($id)
    {
        $this->autorizarAdmin();

        Notificacion::findOrFail($id)->delete();

        return back()->with('success', 'Notificación eliminada.');
    }

    /**
     * ADMIN / SUPERADMIN — enviar notificación a TODOS LOS USUARIOS de un rol
     */
    public function enviarPorRol(Request $request)
    {
        $this->autorizarAdmin();

        $request->validate([
            'rol_id'  => 'required|integer',
            'titulo'  => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tipo'    => 'required|string',
        ]);

        $usuarios = User::where('id_rol', $request->rol_id)->get();

        foreach ($usuarios as $u) {
            Notificacion::create([
                'user_id' => $u->id,
                'titulo'  => $request->titulo,
                'mensaje' => $request->mensaje,
                'tipo'    => $request->tipo,
                'leida'   => false,
            ]);
        }

        return back()->with('success', 'Notificación enviada a todos los usuarios del rol seleccionado.');
    }

    /**
     * Validar que solo SuperAdmin o Admin puedan enviar o eliminar notificaciones
     */
    private function autorizarAdmin(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

    if (!$user || (!$user->isSuperAdmin() && !$user->isAdmin())) {
        abort(403, 'Solo administradores pueden realizar esta acción');
    }
}
}
