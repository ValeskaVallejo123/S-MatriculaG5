<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Http\Request;

class PublicoPlanEstudiosController extends Controller
{
    public function index()
    {
        // Obtener grados de primaria activos con sus materias
        $gradosPrimaria = Grado::where('nivel', 'primaria')
            ->where('activo', true)
            ->with(['materias' => function($query) {
                $query->where('activo', true)->orderBy('nombre');
            }])
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get();

        // Obtener grados de secundaria activos con sus materias
        $gradosSecundaria = Grado::where('nivel', 'secundaria')
            ->where('activo', true)
            ->with(['materias' => function($query) {
                $query->where('activo', true)->orderBy('nombre');
            }])
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get();

        // Obtener grados de Básica activos con sus materias
        $gradosBasica = Grado::where('nivel', 'Básica')
            ->where('activo', true)
            ->with(['materias' => function($query) {
                $query->where('activo', true)->orderBy('nombre');
            }])
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get();

        return view('plan-estudios', compact('gradosPrimaria', 'gradosSecundaria', 'gradosBasica'));
    }
}