<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Aprobar un usuario pendiente
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
    }
    
    /**
     * Rechazar y eliminar un usuario pendiente
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
    }
}