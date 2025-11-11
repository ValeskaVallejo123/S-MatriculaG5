<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HorarioController extends Controller
{
    public function index()
    {
        $profesorId = Auth::user()->id; // El docente logueado
        $horarios = Horario::where('profesor_id', $profesorId)
                            ->orderBy('dia')
                            ->orderBy('hora_inicio')
                            ->get();

        return view('horarios.index', compact('horarios'));
    }

    public function exportPDF()
    {
        $profesorId = Auth::user()->id;
        $horarios = Horario::where('profesor_id', $profesorId)->get();

        $pdf = Pdf::loadView('horarios.pdf', compact('horarios'));

        return $pdf->download('horario.pdf');
    }
}
