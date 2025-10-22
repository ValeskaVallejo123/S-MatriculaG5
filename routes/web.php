<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\CambiarContraseniaController;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfesorController;


Route::get('/', function () {
    return redirect()->route('admins.index');
});

Route::get('/', function () {
    return view('plantilla'); // o tu vista principal
});


// Mostrar formulario para solicitar el enlace de recuperación
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])
    ->name('password.solicitar');

// Procesar el envío del enlace al correo
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.enviar');

// Mostrar formulario para restablecer contraseña (con token)
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.restablecer');

// Guardar la nueva contraseña en la base de datos
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])
    ->name('password.actualizar');

// (Opcional) Vista informativa o de confirmación general
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')
    ->name('password.recuperar');




Route::resource('admins', AdminController::class);
Route::resource('estudiantes', EstudianteController::class);
Route::resource('profesores', ProfesorController::class)->parameters([
    'profesores' => 'profesor'
]);


/*Route::get('/', function () {
    return view('welcome'); // o tu vista principal
});*/

Route::get('/', function () {
    return view('plantilla');
});

Route::get('/login', function () {
    return view('login');
})->name('login');



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

//Rutas Cambiar contrasenia
// Mostrar el formulario para cambiar la contraseña
Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])
    ->name('cambiar_contrasenia.edit');
// Procesar el cambio de contraseña
Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])
    ->name('cambiar_contrasenia.update');
