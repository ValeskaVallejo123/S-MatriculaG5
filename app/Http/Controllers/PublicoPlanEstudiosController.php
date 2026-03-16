<?php

namespace App\Http\Controllers;

use App\Models\Grado;

class PublicoPlanEstudiosController extends Controller
{
    public function index()
{
    $grados = Grado::with('materias')->paginate(15);

    return view('plan-estudios', compact('grados'));
}
public function show(Grado $grado)
    {
        $grado->load('materias');
        return view('plan-estudios-detalle', compact('grado'));
    }

}