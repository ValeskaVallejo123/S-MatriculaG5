<?php

use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome'); // o tu vista principal
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






