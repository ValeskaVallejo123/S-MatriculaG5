<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesorDashboardController extends Controller
{
    public function index()
    {
        $profesor = Auth::user();

        // Aquí puedes agregar lógica para obtener las clases del profesor
        // Por ahora, datos de ejemplo

        $totalClases = 5; // Total de clases que imparte
        $totalEstudiantes = 120; // Total de estudiantes en todas sus clases
        $clasesHoy = 3; // Clases programadas para hoy
        $tareasPendientes = 8; // Tareas por revisar
        // Clases del profesor (datos de ejemplo)
        $misClases = [
            [
                'nombre' => 'Matemáticas',
                'grado' => '1ro Primaria',
                'seccion' => 'A',
                'estudiantes' => 25,
                'horario' => '8:00 AM - 9:00 AM'
            ],
            [
                'nombre' => 'Matemáticas',
                'grado' => '2do Primaria',
                'seccion' => 'B',
                'estudiantes' => 28,
                'horario' => '9:00 AM - 10:00 AM'
            ],
            [
                'nombre' => 'Matemáticas',
                'grado' => '3ro Primaria',
                'seccion' => 'A',
                'estudiantes' => 30,
                'horario' => '10:00 AM - 11:00 AM'
            ]
        ];
        // Estudiantes destacados (datos de ejemplo)
        $estudiantesDestacados = Estudiante::where('estado', 'activo')
            ->limit(5)
            ->get();
        return view('profesores.dashboard.index', compact(
            'profesor',
            'totalClases',
            'totalEstudiantes',
            'clasesHoy',
            'tareasPendientes',
            'misClases',
            'estudiantesDestacados'
        ));
    }
}
