<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Padre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PadreDashboardController extends Controller
{
    public function index()
    {
        // Usuario logueado
        $usuario = Auth::user();

        // Obtener el registro de "Padre" asociado a este usuario
        $padre = Padre::where('user_id', $usuario->id)->first();

        if (!$padre) {
            // En caso de que el usuario no tenga un perfil de padre
            return redirect()->route('home')->with('error', 'No se encontró un perfil de padre asociado.');
        }

        // Obtener hijos reales del padre (asumiendo que Estudiante tiene padre_id)
        $misHijos = Estudiante::where('padre_id', $padre->id)
            ->where('estado', 'activo')
            ->get();

        $totalHijos = $misHijos->count();

        // Estos valores quedan como "placeholder" hasta tener lógica real
        $citasPendientes = 0;
        $pagosVencidos = 0;

        // Resumen por hijo (placeholder hasta tener calificaciones reales)
        $resumenHijos = [];
        foreach ($misHijos as $hijo) {
            $resumenHijos[] = [
                'nombre' => $hijo->nombre_completo,
                'grado' => $hijo->grado,
                'seccion' => $hijo->seccion,
                'promedio' => null,
                'asistencia' => null,
                'comportamiento' => null,
            ];
        }

        // Próximos eventos (placeholder)
        $proximosEventos = [];

        // Notificaciones (placeholder)
        $notificaciones = [];

        return view('padre.dashboard.index', compact(
            'usuario',
            'padre',
            'misHijos',
            'totalHijos',
            'citasPendientes',
            'pagosVencidos',
            'resumenHijos',
            'proximosEventos',
            'notificaciones'
        ));
    }
}
