<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;

Route::get('/', function () {
    return redirect()->route('admins.index');
});

Route::get('/', function () {
    return view('plantilla');
});

Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])
    ->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])
    ->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')
    ->name('password.recuperar');

Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
    Route::get('/', [CursoController::class, 'index'])->name('index');       // Lista de cupos máximos
    Route::get('/create', [CursoController::class, 'create'])->name('create'); // Formulario para crear cupo
    Route::post('/', [CursoController::class, 'store'])->name('store');        // Guardar cupo máximo
    Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');  // Editar cupo
    Route::put('/{id}', [CursoController::class, 'update'])->name('update');   // Actualizar cupo
    Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy'); // Eliminar cupo
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

