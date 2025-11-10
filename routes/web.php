<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CalificacionController;
use App\Http\Middleware\RolMiddleware;

// RUTA PRINCIPAL
Route::get('/', function () {
    return redirect()->route('admins.index');
});

// CUPOS MÁXIMOS
Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
    Route::get('/', [CursoController::class, 'index'])->name('index');
    Route::get('/create', [CursoController::class, 'create'])->name('create');
    Route::post('/', [CursoController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CursoController::class, 'update'])->name('update');
    Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
});

// RECUPERACIÓN DE CONTRASEÑA
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

// AUTH: registro / login / logout
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// RUTAS PROTEGIDAS (auth)
Route::middleware('auth')->group(function () {
        Route::resource('admins', AdminController::class);


    // Cambiar contraseña (autenticado)
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    // Matriculas (index accesible a admin según middleware rol)
    Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index')->middleware('rol:admin');
});

// RUTAS SEGÚN ROLE
Route::middleware('rol:admin')->group(function () {
    Route::resource('admins', AdminController::class);

    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);
    Route::resource('observaciones', ObservacionController::class)->except(['show']);
    Route::resource('documentos', DocumentoController::class);

    // Confirmación de matrícula
    Route::post('/matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');

    // Buscar estudiante
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');

    // Estado de solicitud de matrícula
    Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('solicitud.verEstado');
    Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

    // Periodos académicos
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    // Matriculas para estudiantes (creación y almacenamiento)
    Route::get('/matriculas/create', [MatriculaController::class, 'create'])->name('matriculas.create');
    Route::post('/matriculas', [MatriculaController::class, 'store'])->name('matriculas.store');
});

// Matriculas para usuarios con rol estudiante (si aplica)
Route::middleware('auth:admin')->group(function () { // Cambia 'rol:admin' por 'auth:admin'
    Route::resource('admins', AdminController::class);
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class);
    Route::resource('cursos', CursoController::class);
    Route::resource('calificaciones', CalificacionController::class);
});

// Recursos adicionales
Route::resource('grados', GradoController::class);
Route::resource('ciclos', CicloController::class);

// Calificaciones: asegurar parámetro singular correcto
Route::resource('calificaciones', CalificacionController::class)->parameters([
    'calificaciones' => 'calificacion',
]);

// Rutas del calendario académico
Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
Route::get('/calendario/eventos', [CalendarioController::class, 'obtenerEventos'])->name('calendario.eventos');
Route::post('/calendario/eventos', [CalendarioController::class, 'guardar'])->name('calendario.guardar');
Route::put('/calendario/eventos/{evento}', [CalendarioController::class, 'actualizar'])->name('calendario.actualizar');
Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar'])->name('calendario.eliminar');

// Plantilla de vista
Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');