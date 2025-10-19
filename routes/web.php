<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;

Route::get('/', function () {
    return view('welcome'); // o tu vista principal
});

Route::get('/', function () {
    return view('plantilla'); // o tu vista principal
});
Route::get('/estudiantes/buscar', [EstudianteController::class, 'buscar'])->name('estudiantes.buscar');






