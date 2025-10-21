<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\SolicitudController;

Route::get('/', function () {
    return view('welcome'); // o tu vista principal
});

Route::get('/', function () {
    return view('plantilla'); // o tu vista principal
});
//muestra la vista de buscar estudiante
Route::get('/estudiantes/buscar', [EstudianteController::class, 'buscar'])->name('estudiantes.buscar');
//  muestra la vista de buscar solicitud de matricula
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('solicitud.verEstado');
// Ruta para procesar el formulario (POST)
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);




