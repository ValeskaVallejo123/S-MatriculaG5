<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Estudiante;
use App\Models\Padre;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function create(Request $request)
    {
        // Traer último documento subido
        $ultimoDocumento = Documento::latest()->first();
        return view('Documentos.createDocumento', compact('ultimoDocumento'));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:jpg,png,pdf|max:5120',
            'padre_email' => 'required|email',
            'estudiante_email' => 'required|email',
        ]);

        // Guardar temporalmente el archivo en storage/app/temp
        $archivoTemp = $request->file('archivo')->store('temp');

        // Guardar la ruta temporal y correos en la sesión
        $request->session()->put('archivo_temp_path', $archivoTemp);
        $request->session()->put('padre_email', $request->padre_email);
        $request->session()->put('estudiante_email', $request->estudiante_email);

        $nombreArchivo = $request->file('archivo')->getClientOriginalName();

        return view('Documentos.createDocumento', compact('nombreArchivo'));
    }


    public function store(Request $request)
    {
        $archivoTempPath = $request->session()->get('archivo_temp_path');
        $padre_email = $request->session()->get('padre_email');
        $estudiante_email = $request->session()->get('estudiante_email');

        // Crear registros de padre y estudiante si no existen
        $padre = Padre::firstOrCreate(['correo' => $padre_email], ['nombre' => 'Desconocido', 'apellido' => 'Desconocido']);
        $estudiante = Estudiante::firstOrCreate(['correo' => $estudiante_email], ['nombre' => 'Desconocido', 'apellido' => 'Desconocido']);

        // Mover el archivo de temp a storage/app/public/documentos
        $archivoNombre = basename($archivoTempPath);
        $rutaFinal = Storage::disk('public')->putFileAs('documentos', storage_path('app/' . $archivoTempPath), $archivoNombre);

        // Guardar en BD
        $documento = Documento::create([
            'estudiante_id' => $estudiante->id,
            'padre_id' => $padre->id,
            'nombre' => $archivoNombre,
            'tipo' => pathinfo($archivoNombre, PATHINFO_EXTENSION),
            'tamano' => Storage::disk('public')->size('documentos/' . $archivoNombre),
            'ruta' => 'documentos/' . $archivoNombre,
        ]);

        // Limpiar sesión y temp
        Storage::delete($archivoTempPath);
        $request->session()->forget(['archivo_temp_path','padre_email','estudiante_email']);

        return redirect()->route('documentos.create')->with('success', $documento->nombre);
    }

}



