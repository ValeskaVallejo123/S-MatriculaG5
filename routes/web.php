<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\ProfesorController;


use Illuminate\Support\Facades\Route;




// Ruta principal - redirige a admins
Route::get('/', function () {
    return redirect()->route('admins.index');
});

// Ruta de login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Rutas de recuperación de contraseña
Route::prefix('password')->name('password.')->group(function () {
    // Mostrar formulario para solicitar el enlace de recuperación
    Route::get('/solicitar', [PasswordResetController::class, 'showForgotForm'])
        ->name('solicitar');

    // Procesar el envío del enlace al correo
    Route::post('/solicitar', [PasswordResetController::class, 'sendResetLink'])
        ->name('enviar');

    // Mostrar formulario para restablecer contraseña (con token)
    Route::get('/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])
        ->name('restablecer');

    // Guardar la nueva contraseña en la base de datos
    Route::post('/restablecer', [PasswordResetController::class, 'resetPassword'])
        ->name('actualizar');

    // Vista informativa o de confirmación general (opcional)
    Route::view('/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')
        ->name('recuperar');
});

// Rutas de recursos (CRUD completo)
Route::resource('admins', AdminController::class);
Route::resource('estudiantes', EstudianteController::class);

Route::resource('profesores', ProfesorController::class)->parameter('profesores', 'profesor');
// Rutas de Matrículas
Route::resource('matriculas', MatriculaController::class);

Route::resource('profesores', ProfesorController::class)->parameters([
    'profesores' => 'profesor'
]);


// Rutas adicionales para matrículas (si las necesitas)
Route::prefix('matriculas')->name('matriculas.')->group(function () {
    // Aprobar matrícula
    Route::patch('/{matricula}/aprobar', [MatriculaController::class, 'aprobar'])
        ->name('aprobar');

    // Rechazar matrícula
    Route::patch('/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])
        ->name('rechazar');

    // Cancelar matrícula
    Route::patch('/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])
        ->name('cancelar');

    // Descargar documento
    Route::get('/{matricula}/documento/{tipo}', [MatriculaController::class, 'descargarDocumento'])
        ->name('descargar-documento');
});
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
//Rutas Observaciones
Route::get('/observaciones', [ObservacionController::class, 'index'])->name('observaciones.index');
Route::get('/observaciones/create', [ObservacionController::class, 'create'])->name('observaciones.create');
Route::post('/observaciones', [ObservacionController::class, 'store'])->name('observaciones.store');
Route::get('/observaciones/{observacion}/edit', [ObservacionController::class, 'edit'])->name('observaciones.edit');
Route::put('/observaciones/{observacion}', [ObservacionController::class, 'update'])->name('observaciones.update');
Route::delete('/observaciones/{observacion}', [ObservacionController::class, 'destroy'])->name('observaciones.destroy');

//Rutas Cambiar contrasenia
// Mostrar formulario
Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])
    ->middleware('auth')
    ->name('cambiar_contrasenia.edit');
// Actualizar contraseña
Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])
    ->middleware('auth')
    ->name('cambiar_contrasenia.update');

