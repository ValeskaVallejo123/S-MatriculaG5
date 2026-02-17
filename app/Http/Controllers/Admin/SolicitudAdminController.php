<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudAdminController extends Controller
{
    /**
     * Listar todas las solicitudes
     */
    public function index()
    {
        $solicitudes = Solicitud::with('estudiante')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.solicitudes.index', compact('solicitudes'));
    }

    /**
     * Mostrar detalle de una solicitud
     */
    public function show($id)
    {
        $solicitud = Solicitud::with('estudiante')->findOrFail($id);
        return view('admin.solicitudes.show', compact('solicitud'));
    }

    /**
     * Aprobar solicitud
     */
    public function aprobar($id)
    {
        try {
            $solicitud = Solicitud::with('estudiante')->findOrFail($id);
            $solicitud->aprobar();

            $mensaje = 'Solicitud aprobada exitosamente.';
            
            if ($solicitud->email) {
                $mensaje .= ' Se ha creado un usuario para el padre con email: ' . $solicitud->email . ' y contraseña: DNI del estudiante.';
            }

            return redirect()->back()->with('success', $mensaje);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al aprobar la solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Rechazar solicitud
     */
    public function rechazar(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->rechazar();

        return redirect()->back()->with('success', 'Solicitud rechazada');
    }

    /**
     * Cambiar estado a pendiente
     */
    public function pendiente($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estado = 'pendiente';
        $solicitud->save();

        return redirect()->back()->with('success', 'Solicitud marcada como pendiente');
    }
}