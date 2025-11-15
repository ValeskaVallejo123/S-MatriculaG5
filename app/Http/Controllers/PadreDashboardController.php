<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Padre;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PadreDashboardController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        
        // Aquí deberías buscar el padre y sus hijos asociados
        // Por ahora, datos de ejemplo
        
        $padre = Padre::first(); // Reemplazar con el padre real del usuario
        
        // Obtener los hijos del padre
        $misHijos = Estudiante::where('estado', 'activo')
            ->limit(3)
            ->get();
        
        $totalHijos = $misHijos->count();
        $citasPendientes = 2; // Citas con profesores pendientes
        $pagosVencidos = 1; // Pagos de matrícula vencidos
        
        // Resumen por hijo
        $resumenHijos = [];
        foreach ($misHijos as $hijo) {
            $resumenHijos[] = [
                'nombre' => $hijo->nombre_completo,
                'grado' => $hijo->grado,
                'seccion' => $hijo->seccion,
                'promedio' => rand(80, 95),
                'asistencia' => rand(90, 100),
                'comportamiento' => 'Excelente'
            ];
        }
        
        // Próximos eventos (datos de ejemplo)
        $proximosEventos = [
            [
                'titulo' => 'Reunión de Padres',
                'fecha' => '2025-11-20',
                'hora' => '3:00 PM',
                'tipo' => 'reunion'
            ],
            [
                'titulo' => 'Entrega de Notas',
                'fecha' => '2025-11-25',
                'hora' => '2:00 PM',
                'tipo' => 'academico'
            ],
            [
                'titulo' => 'Festival Cultural',
                'fecha' => '2025-12-01',
                'hora' => '10:00 AM',
                'tipo' => 'evento'
            ]
        ];
        
        // Notificaciones recientes
        $notificaciones = [
            [
                'titulo' => 'Recordatorio de Pago',
                'mensaje' => 'El pago de la mensualidad vence el 15 de noviembre',
                'fecha' => '2025-11-10',
                'leido' => false
            ],
            [
                'titulo' => 'Citación con Profesor',
                'mensaje' => 'El profesor de matemáticas solicita una reunión',
                'fecha' => '2025-11-09',
                'leido' => false
            ]
        ];
        
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