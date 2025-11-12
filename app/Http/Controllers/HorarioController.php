<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HorarioController extends Controller
{
    /**
     * Mostrar horarios según el rol del usuario
     */
   public function index()
{
    $user = Auth::user();

    if ($user && $user->isProfesor()) {
        // Profesor ve solo su horario
        $horarios = Horario::where('profesor_id', $user->id)
                            ->orderBy('dia')
                            ->orderBy('hora_inicio')
                            ->get();
    } elseif ($user && ($user->isAdmin() || $user->isSuperAdmin())) {
        // Admin ve todos los horarios
        $horarios = Horario::orderBy('dia')
                            ->orderBy('hora_inicio')
                            ->get();
    } else {
        // Visitante no autenticado ve todos los horarios públicos
        $horarios = Horario::orderBy('dia')
                            ->orderBy('hora_inicio')
                            ->get();
    }

    return view('horarios.index', compact('horarios'));
}

    /**
     * Exportar horarios a PDF según el rol
     */
    public function exportPDF()
{
    $user = Auth::user();

    if ($user && $user->isProfesor()) {
        $horarios = Horario::where('profesor_id', $user->id)
                            ->orderBy('dia')
                            ->orderBy('hora_inicio')
                            ->get();
    } elseif ($user && ($user->isAdmin() || $user->isSuperAdmin())) {
        $horarios = Horario::orderBy('dia')
                            ->orderBy('hora_inicio')
                            ->get();
    } else {
        // Visitante no autenticado: ve todos los horarios
        $horarios = Horario::orderBy('dia')
                            ->orderBy('hora_inicio')
                            ->get();
    }

    $pdf = PDF::loadView('horarios.pdf', compact('horarios', 'user'));

    return $pdf->download('horarios.pdf');
}
}
