<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\CursoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 🔹 RUTA PRINCIPAL
Route::get('/', function () {
    return view('plantilla'); // Vista principal
});

// 🔹 REGISTRO
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// 🔹 LOGIN
Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// 🔹 LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔹 RUTAS PRINCIPALES CON MIDDLEWARE AUTH
Route::middleware('auth')->group(function () {
    Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');


    // CRUDs principales
    Route::resource('admins', AdminController::class);
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);
    Route::resource('matriculas', MatriculaController::class);

    // Confirmación de matrícula
    Route::post('/matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');

    // Cambio de contraseña
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    // Observaciones
    Route::resource('observaciones', ObservacionController::class)->except(['show']);

    // Buscar estudiante
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');

    // Estado de solicitud de matrícula
    Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('solicitud.verEstado');
    Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

    // Periodos académicos
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    // Cupos máximos
    Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
        Route::get('/', [CursoController::class, 'index'])->name('index');
        Route::get('/create', [CursoController::class, 'create'])->name('create');
        Route::post('/', [CursoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CursoController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
    });

    // Estudiantes: crear
    Route::get('/estudiantes/create', [EstudianteController::class, 'create'])->name('estudiantes.create');

    // Documentos
    Route::resource('documentos', DocumentoController::class);
});

// 🔐 RECUPERACIÓN DE CONTRASEÑA
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');

// (Opcional) Vista informativa de recuperación de contraseña
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');
