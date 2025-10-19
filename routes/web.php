<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentoController;


Route::get('/', function () {
    return view('welcome'); // o tu vista principal
});

Route::get('/', function () {
    return view('plantilla'); // o tu vista principal
});

Route::get('/documentos/create', [DocumentoController::class, 'create'])->name('documentos.create');
Route::post('/documentos/preview', [DocumentoController::class, 'preview'])->name('documentos.preview');
Route::post('/documentos/store', [DocumentoController::class, 'store'])->name('documentos.store');







