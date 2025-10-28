<?php

use Illuminate\Support\Facades\Route;
// web.php
use App\Http\Controllers\PlantillaController;

// Página principal → Mostrar fechas

Route::get('/', function () {
    // Si quieres usar la misma vista que plantilla/index
    return view('plantilla'); 
})->name('home');