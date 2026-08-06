<?php

namespace App\Http\Controllers\Admin; // Namespace corregido

use App\Http\Controllers\Controller;
use App\Models\CupoMaximo;
use Illuminate\Http\Request;

// Nombre de clase corregido para que NO choque con CupoMaximoController
class SolicitudAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Si este controlador no se usa para cupos, aquí irá la lógica de solicitudes
        $cursos = CupoMaximo::orderBy('nombre')->get();
        return view('cupos_maximos.index', compact('cursos'));
    }

    // He mantenido los métodos para que no falle si alguna ruta los llama,
    // pero ahora bajo el nombre de SolicitudAdminController.

    public function store(Request $request)
    {
        return redirect()->route('superadmin.cupos_maximos.index');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('superadmin.cupos_maximos.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('superadmin.cupos_maximos.index');
    }
}
