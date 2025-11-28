<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesorDashboardController extends Controller
{
    public function __construct()
    {
        // Solo PROFESORES pueden acceder al dashboard
        $this->middleware(['auth', 'rol:profesor']);
    }

    public function index()
    {
        $profesor = Auth::user(); // Datos del profesor logueado

        // TODO: Reemplazar con datos reales cuando tengas la tabla de clases, horarios, tareas, etc.

        $totalClases = 5;
        $totalEstudiantes = 120;
        $clasesHoy = 3;
        $tareasPendientes = 8;

        // Clases simuladas (temporal)
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

        // Estudiantes destacados (esto sí es real)
        $estudiantesDestacados = Estudiante::where('estado', 'activo')
            ->limit(5)
            ->get();

        return view('profesor.dashboard.index', compact(
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
