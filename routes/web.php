<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfesorController;


Route::get('/', function () {
    return view('plantilla');
});


Route::get('/login', function () {
    return view('login');
})->name('login');





Route::get('/', function () {
    return redirect()->route('admins.index');
});

Route::resource('admins', AdminController::class);
Route::resource('estudiantes', EstudianteController::class);
Route::resource('profesores', ProfesorController::class)->parameters([
    'profesores' => 'profesor'
]);


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
