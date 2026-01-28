<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    /**
     * Mostrar todos los usuarios del sistema
     */
    public function index()
    {
        $usuarios = User::with('rol')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('superadmin.usuarios.lista', compact('usuarios'));
    }

    /**
     * Mostrar información detallada de un usuario
     */
    public function show($id)
    {
        $usuario = User::with('rol')->findOrFail($id);

        return view('superadmin.usuarios.show', compact('usuario'));
    }

    /**
     * Mostrar usuarios pendientes de aprobación
     */
    public function usuariosPendientes()
    {
        $usuariosPendientes = User::with('rol')
            ->where('activo', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('superadmin.usuarios.pendientes', compact('usuariosPendientes'));
    }

    /**
     * Aprobar un usuario: activar + generar contraseña temporal
     */
    public function aprobar($id)
    {
        $usuario = User::findOrFail($id);

        // No permitir aprobar superadmin
        if ($usuario->id_rol == 1) {
            return back()->with('error', 'No se puede aprobar un Super Administrador.');
        }

        // No permitir aprobar usuarios ya aprobados
        if ($usuario->activo == 1) {
            return back()->with('error', 'Este usuario ya está aprobado.');
        }

        // Generar contraseña temporal segura
        $passwordTemp = strtoupper(Str::random(8));

        // Actualizar usuario
        $usuario->update([
            'activo'   => 1,
            'password' => Hash::make($passwordTemp),
        ]);

        // Mostrar contraseña temporal solo 1 vez
        session()->flash('password_temp', $passwordTemp);

        return back()->with('success', 'Usuario aprobado exitosamente.');
    }

    /**
     * Rechazar / eliminar un usuario
     */
    public function rechazar($id)
    {
        $usuario = User::findOrFail($id);

        // No eliminar superadmin
        if ($usuario->id_rol == 1) {
            return back()->with('error', 'No se puede eliminar un Super Administrador');
        }

        $usuario->delete();

        return back()->with('success', 'Usuario rechazado y eliminado exitosamente');
    }

    /**
     * Activar usuario manualmente
     */
    public function activarUsuario($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->id_rol == 1) {
            return back()->with('error', 'No puedes activar manualmente a un SuperAdmin.');
        }

        $usuario->activo = 1;
        $usuario->save();

        return back()->with('success', 'Usuario activado correctamente.');
    }

    /**
     * Desactivar usuario
     */
    public function desactivarUsuario($id)
{
    $usuario = User::findOrFail($id);

    // No permitir desactivar SuperAdmin
    if ($usuario->id_rol == 1) {
        return back()->with('error', 'No puedes desactivar al SuperAdmin.');
    }

    // No permitir que se desactive a sí mismo
    if (Auth::check() && Auth::id() == $usuario->id) {
        return back()->with('error', 'No puedes desactivar tu propia cuenta.');
    }

    $usuario->activo = 0;
    $usuario->save();

    return back()->with('success', 'Usuario desactivado correctamente.');
}

}
