<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\CalendarioController;


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('plantilla');
})->name('home');

Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

// Estado de solicitud
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA
|--------------------------------------------------------------------------
*/
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');

/*
|--------------------------------------------------------------------------
| RUTAS SUPER ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {

    Route::resource('administradores', SuperAdminController::class)->parameters([
        'administradores' => 'administrador'
    ]);

    Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admins
    Route::resource('admins', AdminController::class)->parameters([
        'admins' => 'admin'
    ]);

    // Estudiantes
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);

    // Profesores
    Route::resource('profesores', ProfesorController::class)->parameters([
        'profesores' => 'profesor'
    ]);

    // Matrículas
    Route::resource('matriculas', MatriculaController::class);
    Route::post('matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');
    Route::post('matriculas/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('matriculas.rechazar');
    Route::post('matriculas/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])->name('matriculas.cancelar');

    // Periodos Académicos
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    // Cupos (Cursos)
    Route::resource('cupos_maximos', CursoController::class)->parameters([
        'cupos_maximos' => 'id'
    ]);

    // Observaciones
    Route::resource('observaciones', ObservacionController::class)->except(['show']);

    // Documentos
    Route::resource('documentos', DocumentoController::class);

    // Cambiar contraseña
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
});

Route::middleware(['auth', 'role:profesor'])->group(function() {
    Route::get('/horario', [HorarioController::class, 'index'])->name('horario.index');
    Route::get('/horario/export-pdf', [HorarioController::class, 'exportPDF'])->name('horario.exportPDF');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('calificaciones', CalificacionController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('grados', GradoController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('ciclos', CicloController::class);
});

Route::middleware(['auth'])->group(function () {
    // Vista principal del calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');

    // CRUD de eventos
    Route::get('/calendario/eventos', [CalendarioController::class, 'obtenerEventos'])->name('calendario.eventos');
    Route::post('/calendario/eventos', [CalendarioController::class, 'guardar'])->name('calendario.guardar');
    Route::put('/calendario/eventos/{evento}', [CalendarioController::class, 'actualizar'])->name('calendario.actualizar');
    Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar'])->name('calendario.eliminar');
});
