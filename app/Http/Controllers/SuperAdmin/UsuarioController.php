<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsuarioController extends Controller
{
    /**
     * Aprobar un usuario pendiente
     */
    public function aprobar($id)
    {
        try {
            $usuario = User::findOrFail($id);

            // No aprobar Super Administrador
            if ($usuario->id_rol == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede aprobar un Super Administrador'
                ], 403);
            }

            $usuario->activo = 1; // Asegurarse que sea compatible con DB
            $usuario->save();

            return response()->json([
                'success' => true,
                'message' => 'Usuario aprobado exitosamente'
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rechazar y eliminar un usuario pendiente
     */
    public function rechazar($id)
    {
        try {
            $usuario = User::findOrFail($id);

            // No eliminar Super Administrador
            if ($usuario->id_rol == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar un Super Administrador'
                ], 403);
            }

            $usuario->delete();

            return response()->json([
                'success' => true,
                'message' => 'Usuario rechazado y eliminado'
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}
