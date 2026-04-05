<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\Grado;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAsignacionProfesorGuiaController extends Controller
{
    public function __construct()
    {
        // Solo SUPERADMIN y ADMIN pueden usar este controlador
        $this->middleware(['auth', 'rol:admin,super_admin']);
    }

    /**
     * Mostrar lista de profesores para asignar grado guía
     */
    public function index()
    {
        $profesores = Profesor::with('gradoGuia')->paginate(15);

        return view('admin.profesorGuia.index', compact('profesores'));
    }

    /**
     * Formulario para asignar grado y sección a un profesor
     */
    public function edit($id)
    {
        $profesor = Profesor::findOrFail($id);

        // Grados disponibles (tabla grados)
        $grados = Grado::orderBy('nombre')->get();

        // Secciones disponibles — puedes personalizarlo
        $secciones = ['A', 'B', 'C', 'D'];

        return view('admin.profesorGuia.edit', compact(
            'profesor',
            'grados',
            'secciones'
        ));
    }

    /**
     * Guardar cambios del profesor guía
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'grado_guia_id' => 'nullable|exists:grados,id',
            'seccion_guia' => 'nullable|string|max:10',
        ]);

        $profesor = Profesor::findOrFail($id);

        // Guardar cambios
        $profesor->grado_guia_id = $request->grado_guia_id;
        $profesor->seccion_guia = $request->seccion_guia;
        $profesor->save();

        // Notificar al profesor (si quieres notificaciones activas)
        if ($profesor->usuario) {
            Notificacion::create([
                'user_id' => $profesor->usuario->id,
                'remitente_id' => Auth::id(),
                'titulo' => 'Nueva asignación de grado guía',
                'mensaje' => 'Se te ha asignado como profesor guía de '
                            . optional($profesor->gradoGuia)->nombre
                            . ' sección ' . $profesor->seccion_guia,
                'tipo' => 'asignacion_guia'
            ]);
        }

        return redirect()->route('admin.profesorGuia.index')
            ->with('success', 'Asignación de profesor guía actualizada correctamente.');
    }
}
