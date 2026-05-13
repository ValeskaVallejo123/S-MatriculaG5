<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfesorHorarioController extends Controller
{
    public function __construct()
    {
        // Solo PROFESORES pueden acceder
        $this->middleware(['auth', 'rol:profesor']);
    }

    /**
     * Mostrar el horario del profesor autenticado
     */
    public function index()
    {
        $profesor = Auth::user()->docente;

        if (!$profesor) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes perfil de profesor asignado.');
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

    /**
     * Exportar el horario del profesor a PDF
     */
    public function exportPDF()
    {
        $profesor = Auth::user()->docente;

        if (!$profesor) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes perfil de profesor asignado.');
        }

        $horarios = Horario::where('profesor_id', $profesor->id)
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        if ($horarios->isEmpty()) {
            return redirect()->route('profesor.horarios.index')
                ->with('error', 'No hay horarios para generar el PDF.');
        }

        try {
            $pdf = Pdf::loadView('profesor.horarios.pdf', [
                'horarios' => $horarios,
                'profesor' => $profesor
            ]);

            return $pdf->download('horario_profesor.pdf');

        } catch (\Exception $e) {
            return redirect()->route('profesor.horarios.index')
                ->with('error', 'Ocurrió un error al generar el PDF.');
        }
    }
}
