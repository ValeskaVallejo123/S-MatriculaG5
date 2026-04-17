<?php

namespace App\Http\Controllers;

use App\Models\Grado;

class PublicoPlanEstudiosController extends Controller
{
    public function index()
    {
        $grados = Grado::with('materias')
            ->where('activo', true)
            ->orderBy('nivel')
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get()
            ->groupBy('nivel');

        return view('plan-estudios', compact('grados'));
    }

    public function show(Grado $grado)
    {
        abort_unless($grado->activo, 404);
        $grado->load('materias');
        return view('plan-estudios-detalle', compact('grado'));
    }
}
