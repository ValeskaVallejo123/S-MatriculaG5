<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
    public function pendientes()
    {
        $usuariosPendientes = User::with('rol')
            ->where('activo', 0)
            ->whereNotNull('id_rol')         // Solo usuarios con rol asignado
            ->where('id_rol', '!=', 1)       // Excluir superadmin
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
        $passwordTemp = strtoupper(Str::random(4)) . rand(100, 999) . '!';

        // Actualizar usuario
        $usuario->update([
            'activo'   => 1,
            'password' => Hash::make($passwordTemp),
        ]);

        // Notificar al usuario que fue aprobado
        Notificacion::create([
            'user_id' => $usuario->id,
            'titulo'  => 'Cuenta aprobada',
            'mensaje' => 'Tu cuenta ha sido aprobada. Ya puedes iniciar sesión con tu contraseña temporal.',
            'tipo'    => 'administrativa',
            'leida'   => false,
        ]);

        // Mostrar contraseña temporal solo 1 vez via session flash
        session()->flash('password_temp', $passwordTemp);
        session()->flash('usuario_aprobado', $usuario->name);

        return back()->with('success', "Usuario {$usuario->name} aprobado exitosamente.");
    }

    /**
     * Rechazar / eliminar un usuario pendiente
     */
    public function rechazar($id)
    {
        $usuario = User::findOrFail($id);

        // No eliminar superadmin
        if ($usuario->id_rol == 1) {
            return back()->with('error', 'No se puede eliminar un Super Administrador.');
        }

        // No permitir rechazar usuarios ya activos
        if ($usuario->activo == 1) {
            return back()->with('error', 'No puedes rechazar un usuario que ya está activo. Desactívalo primero.');
        }

        // No permitir rechazarse a sí mismo
        if (Auth::id() == $usuario->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $nombreUsuario = $usuario->name;
        $usuario->delete();

        return back()->with('success', "Usuario {$nombreUsuario} rechazado y eliminado exitosamente.");
    }

    /**
     * Activar usuario manualmente
     */
    public function activarUsuario($id)
    {
        $usuario = User::findOrFail($id);

        // No activar superadmin manualmente
        if ($usuario->id_rol == 1) {
            return back()->with('error', 'No puedes activar manualmente a un Super Administrador.');
        }

        // Ya está activo
        if ($usuario->activo == 1) {
            return back()->with('error', 'Este usuario ya se encuentra activo.');
        }

        $usuario->activo = 1;
        $usuario->save();

        // Notificar al usuario
        Notificacion::create([
            'user_id' => $usuario->id,
            'titulo'  => 'Cuenta activada',
            'mensaje' => 'Tu cuenta ha sido activada por un administrador. Ya puedes iniciar sesión.',
            'tipo'    => 'administrativa',
            'leida'   => false,
        ]);

        return back()->with('success', "Usuario {$usuario->name} activado correctamente.");
    }

    /**
     * Desactivar usuario
     */
    public function desactivarUsuario($id)
    {
        $usuario = User::findOrFail($id);

        // No desactivar superadmin
        if ($usuario->id_rol == 1) {
            return back()->with('error', 'No puedes desactivar al Super Administrador.');
        }

        // No desactivarse a sí mismo
        if (Auth::id() == $usuario->id) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        // Ya está inactivo
        if ($usuario->activo == 0) {
            return back()->with('error', 'Este usuario ya se encuentra inactivo.');
        }

        $usuario->activo = 0;
        $usuario->save();

        // Notificar al usuario
        Notificacion::create([
            'user_id' => $usuario->id,
            'titulo'  => 'Cuenta desactivada',
            'mensaje' => 'Tu cuenta ha sido desactivada. Contacta al administrador para más información.',
            'tipo'    => 'administrativa',
            'leida'   => false,
        ]);

        return back()->with('success', "Usuario {$usuario->name} desactivado correctamente.");
    }

    /**
     * Eliminar usuario permanentemente (solo superadmin)
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        // No eliminar superadmin
        if ($usuario->id_rol == 1) {
            return back()->with('error', 'No se puede eliminar un Super Administrador.');
        }

        // No eliminarse a sí mismo
        if (Auth::id() == $usuario->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $nombreUsuario = $usuario->name;
        $usuario->delete();

        return back()->with('success', "Usuario {$nombreUsuario} eliminado permanentemente.");
    }
}
