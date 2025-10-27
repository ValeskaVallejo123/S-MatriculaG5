<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PeriodoAcademicoController;

Route::get('/', function () {
    return view('welcome'); // o tu vista principal
});

Route::get('/', function () {
    return view('plantilla'); // o tu vista principal
});
//muestra la vista de buscar estudiante
Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
//  muestra la vista de buscar solicitud de matricula
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('solicitud.verEstado');
// Ruta para procesar el formulario (POST)
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);
// definir periodos academicos
Route::resource('periodos-academicos', PeriodoAcademicoController::class);



