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
    public function pendientes()
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
        try {
            $usuario = User::findOrFail($id);

            // Activar el usuario
            $usuario->activo = true;
            $usuario->save();

            return response()->json([
                'success' => true,
                'message' => 'Usuario aprobado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar el usuario: ' . $e->getMessage()
            ], 500);
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
        try {
            $usuario = User::findOrFail($id);

            // Eliminar el usuario
            $usuario->delete();

            return response()->json([
                'success' => true,
                'message' => 'Usuario rechazado y eliminado'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar el usuario: ' . $e->getMessage()
            ], 500);
        }

        $usuario->delete();

        return back()->with('success', 'Usuario rechazado y eliminado exitosamente');
    }
}
