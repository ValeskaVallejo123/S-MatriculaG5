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

}