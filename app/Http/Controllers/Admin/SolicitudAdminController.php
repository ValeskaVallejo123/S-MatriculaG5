<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use Illuminate\Http\Request;

class SolicitudAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    $matriculas = Matricula::with(['estudiante', 'padre'])
        ->whereIn('estado', ['pendiente', 'aprobada', 'rechazada', 'cancelada'])
        ->latest()
        ->paginate(15);

    return view('matriculas.index', compact('matriculas'));
}

    public function show($id)
    {
        $matricula = Matricula::with(['estudiante', 'padre'])->findOrFail($id);
        return view('matriculas.show', compact('matricula'));
    }

    public function aprobar($id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->update(['estado' => 'aprobada']);
        return back()->with('success', 'Solicitud aprobada correctamente.');
    }

    public function rechazar($id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->update(['estado' => 'rechazada']);
        return back()->with('success', 'Solicitud rechazada.');
    }

    public function pendiente($id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->update(['estado' => 'pendiente']);
        return back()->with('success', 'Solicitud marcada como pendiente.');
    }
}