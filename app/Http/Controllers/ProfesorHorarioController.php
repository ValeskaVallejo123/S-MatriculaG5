<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use Barryvdh\DomPDF\Facade\Pdf; // Para PDF
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfesorHorarioController extends Controller
{
    public function index()
    {
        // Funciona si no importas Auth
        $profesor = Auth::user()->docente;

        if (!$profesor) {
            Session::flash('error', 'No tienes perfil de profesor asignado.');
            return redirect()->route('dashboard');
        }

        $horarios = Horario::where('profesor_id', $profesor->id)
                            ->orderBy('dia')
                            ->orderBy('hora_inicio')
                            ->get();

        if ($horarios->isEmpty()) {
            Session::flash('info', 'No tienes horarios asignados aún.');
        }

        return view('profesor.horarios.index', compact('horarios', 'profesor'));
    }

    public function exportPDF()
    {
        $profesor = Auth::user()->docente;

        if (!$profesor) {
            Session::flash('error', 'No tienes perfil de profesor asignado.');
            return redirect()->route('dashboard');
        }

        $horarios = Horario::where('profesor_id', $profesor->id)
                            ->orderBy('dia')
                            ->orderBy('hora_inicio')
                            ->get();

        if ($horarios->isEmpty()) {
            Session::flash('error', 'No hay horarios para generar el PDF.');
            return redirect()->route('profesor.horarios.index');
        }

        try {
            $pdf = Pdf::loadView('profesor.horarios.pdf', compact('horarios', 'profesor'));
            return $pdf->download('horario_profesor.pdf');
        } catch (\Exception $e) {
            Session::flash('error', 'Ocurrió un error al generar el PDF.');
            return redirect()->route('profesor.horarios.index');
        }
    }
}
