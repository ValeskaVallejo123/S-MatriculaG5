<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocumentoController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admins.index');
});

Route::resource('admins', AdminController::class);
Route::resource('estudiantes', EstudianteController::class);

// O si prefieres definirlas manualmente:
/*
Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
Route::get('/admins/{admin}', [AdminController::class, 'show'])->name('admins.show');
Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
*/

//Rutas subir documentos
Route::resource('documentos', DocumentoController::class);
