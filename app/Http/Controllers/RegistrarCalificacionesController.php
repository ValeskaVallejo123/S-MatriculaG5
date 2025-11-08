<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Curso;
use App\Models\PeriodoAcademico;
use App\Models\Matricula;

class RegistrarCalificacionesController extends Controller
{
    public function index(Request $request)
    {
        $cursos = collect([
            (object)['id' => 1, 'nombre' => 'Matemáticas'],
            (object)['id' => 2, 'nombre' => 'Lenguaje'],
        ]);

        $periodos = collect([
            (object)['id' => 1, 'nombre' => '2025 - Primer Trimestre'],
            (object)['id' => 2, 'nombre' => '2025 - Segundo Trimestre'],
        ]);

        $estudiantes = collect([
            (object)['id' => 101, 'nombre' => 'Ana López'],
            (object)['id' => 102, 'nombre' => 'Carlos Méndez'],
        ]);

        return view('registrarcalificaciones.registrarcalificaciones', compact('cursos', 'periodos', 'estudiantes'));
    }
}
