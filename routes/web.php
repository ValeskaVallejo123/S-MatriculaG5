<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Middleware\RolMiddleware;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin autenticación requerida)
|--------------------------------------------------------------------------
*/

// Página principal - Plantilla pública
Route::get('/', function () {
    return view('plantilla');
})->name('home');

// Plantilla alternativa
Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

// Consulta de solicitudes (PÚBLICA - cualquiera puede consultar)
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])
    ->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

// Login
// Login
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');

// Logout
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS - SUPER ADMINISTRADOR
|--------------------------------------------------------------------------
| ⚠️ IMPORTANTE: Estas rutas DEBEN ir ANTES de las rutas de admins
| para evitar conflictos de enrutamiento
*/
Route::middleware(['auth', 'super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Gestión de administradores
    Route::get('/administradores', [SuperAdminController::class, 'index'])->name('administradores.index');
    Route::get('/administradores/crear', [SuperAdminController::class, 'create'])->name('administradores.create');
    Route::get('/administradores/create', [SuperAdminController::class, 'create']); // Ruta alternativa
    Route::post('/administradores', [SuperAdminController::class, 'store'])->name('administradores.store');
    Route::get('/administradores/{administrador}', [SuperAdminController::class, 'show'])->name('administradores.show');
    Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
    Route::get('/administradores/{administrador}/edit', [SuperAdminController::class, 'edit']); // Ruta alternativa
    Route::put('/administradores/{administrador}', [SuperAdminController::class, 'update'])->name('administradores.update');
    Route::patch('/administradores/{administrador}', [SuperAdminController::class, 'update']);
    Route::delete('/administradores/{administrador}', [SuperAdminController::class, 'destroy'])->name('administradores.destroy');
    
    // Perfil de super admin
    Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Autenticación)
|--------------------------------------------------------------------------
| Accesible para admins regulares y super admins
*/
Route::middleware(['auth'])->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    /*
    |--------------------------------------------------------------------------
    | PANEL DE ADMINISTRADORES REGULARES
    |--------------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::get('/create', [AdminController::class, 'create']); // Ruta alternativa
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::get('/{admin}/edit', [AdminController::class, 'edit']); // Ruta alternativa
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::patch('/{admin}', [AdminController::class, 'update']);
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ESTUDIANTES
    |--------------------------------------------------------------------------
    */
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])
        ->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);
    
    // Dashboard de estudiantes
    Route::get('/estudiantes-dashboard', function () {
        return view('estudiantes.dashboard');
    })->name('estudiantes.dashboard');

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE PROFESORES
    |--------------------------------------------------------------------------
    */
    Route::resource('profesores', ProfesorController::class)->parameter('profesores', 'profesor');

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE MATRÍCULAS
    |--------------------------------------------------------------------------
    */
    Route::resource('matriculas', MatriculaController::class);
    Route::post('/matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])
        ->name('matriculas.confirmar');
    Route::post('/matriculas/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])
        ->name('matriculas.rechazar');
    Route::post('/matriculas/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])
        ->name('matriculas.cancelar');

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE PERIODOS ACADÉMICOS
    |--------------------------------------------------------------------------
    */
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE CUPOS MÁXIMOS (CURSOS)
    |--------------------------------------------------------------------------
    */
    Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
        Route::get('/', [CursoController::class, 'index'])->name('index');
        Route::get('/create', [CursoController::class, 'create'])->name('create');
        Route::post('/', [CursoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CursoController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE CURSOS
    |--------------------------------------------------------------------------
    */
    Route::resource('cursos', CursoController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE OBSERVACIONES
    |--------------------------------------------------------------------------
    */
    Route::resource('observaciones', ObservacionController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE DOCUMENTOS
    |--------------------------------------------------------------------------
    */
    Route::resource('documentos', DocumentoController::class);

    /*
    |--------------------------------------------------------------------------
    | CAMBIAR CONTRASEÑA
    |--------------------------------------------------------------------------
    */
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])
        ->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])
        ->name('cambiarcontrasenia.update');

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE GRADOS
    |--------------------------------------------------------------------------
    */
    Route::resource('grados', GradoController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE CICLOS
    |--------------------------------------------------------------------------
    */
    Route::resource('ciclos', CicloController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE CALIFICACIONES
    |--------------------------------------------------------------------------
    */
    Route::resource('calificaciones', CalificacionController::class)->parameters([
        'calificaciones' => 'calificacion',
    ]);

    /*
    |--------------------------------------------------------------------------
    | CALENDARIO ACADÉMICO
    |--------------------------------------------------------------------------
    */
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::get('/calendario/eventos', [CalendarioController::class, 'obtenerEventos'])->name('calendario.eventos');
    Route::post('/calendario/eventos', [CalendarioController::class, 'guardar'])->name('calendario.guardar');
    Route::put('/calendario/eventos/{evento}', [CalendarioController::class, 'actualizar'])->name('calendario.actualizar');
    Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar'])->name('calendario.eliminar');
});