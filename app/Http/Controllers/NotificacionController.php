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
        // Requiere autenticación en todas las acciones
        $this->middleware('auth');
    }

    /**
     * Mostrar notificaciones según el rol del usuario
     */
    public function index()
    {
        $user = Auth::user();

        // Cargar todas las notificaciones del usuario autenticado
        $notificaciones = Notificacion::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        // Redirigir a la vista correspondiente según rol
        return match ($user->id_rol) {
            4 => view('estudiante.notificaciones.index', compact('notificaciones')), // Estudiante
            3 => view('profesor.notificaciones.index', compact('notificaciones')),   // Profesor
            5 => view('padre.notificaciones.index', compact('notificaciones')),      // Padre
            1 => view('superadmin.notificaciones.index', compact('notificaciones')), // SuperAdmin
            2 => view('admin.notificaciones.index', compact('notificaciones')),      // Admin
            default => abort(403, 'Rol no autorizado'),
        };
    }

    /**
     * Marcar notificación como leída (solo el dueño)
     */
    public function marcarLeida(Notificacion $notificacion)
    {
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
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tipo' => 'required|string',
        ]);

        Notificacion::create([
            'user_id' => $request->user_id,
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'tipo' => $request->tipo,
            'leida' => false,
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
            'rol_id' => 'required|integer',
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tipo' => 'required|string',
        ]);

        $usuarios = User::where('id_rol', $request->rol_id)->get();

        foreach ($usuarios as $u) {
            Notificacion::create([
                'user_id' => $u->id,
                'titulo' => $request->titulo,
                'mensaje' => $request->mensaje,
                'tipo' => $request->tipo,
                'leida' => false,
            ]);
        }

        return back()->with('success', 'Notificación enviada a todos los usuarios del rol seleccionado.');
    }

    /**
     * Validar que solo SuperAdmin o Admin puedan enviar o eliminar notificaciones
     */
    private function autorizarAdmin()
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && !$user->isAdmin()) {
            abort(403, 'Solo administradores pueden realizar esta acción');
        }
    }
}
