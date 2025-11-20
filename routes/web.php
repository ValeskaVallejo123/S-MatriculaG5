<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\GradoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\PadrePermisoController;
use App\Http\Controllers\PadreController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin autenticación requerida)
|--------------------------------------------------------------------------
*/

// Página principal
Route::get('/', function () {
    return view('plantilla');
})->name('home');

Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

// Consulta de solicitudes
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

// ==========================================
// CALENDARIO - RUTAS PÚBLICAS
// ==========================================
// Vista de solo lectura
Route::get('/calendario/publico', [CalendarioController::class, 'vistaPublica'])
    ->name('calendario.publico');

// API JSON para FullCalendar (Público)
Route::get('/calendario/eventos/publico', [CalendarioController::class, 'eventosPublicos'])
    ->name('calendario.eventos.publicos');

// ==========================================
// Agrupamos con prefijo 'admin' para coincidir con tus rutas JS (/admin/calendario...)
    Route::prefix('admin')->group(function () {
        
        // Vista Principal Admin
        Route::get('/calendario', [CalendarioController::class, 'vistaAdmin'])
            ->name('admin.calendario');
        
        // API CRUD Eventos
        Route::get('/calendario/eventos', [CalendarioController::class, 'listarEventos'])
            ->name('admin.calendario.eventos.listar');
        
        Route::post('/calendario/eventos', [CalendarioController::class, 'crearEvento'])
            ->name('admin.calendario.eventos.crear');
        
        Route::put('/calendario/eventos/{id}', [CalendarioController::class, 'actualizarEvento'])
            ->name('admin.calendario.eventos.actualizar');
        
        Route::delete('/calendario/eventos/{id}', [CalendarioController::class, 'eliminarEvento'])
            ->name('admin.calendario.eventos.eliminar');
    });
Route::prefix('publico')->name('publico.')->group(function () {
    Route::get('/calificaciones', [CalificacionController::class, 'indexPublico'])->name('calificaciones.index');
    Route::get('/calificaciones/{id}', [CalificacionController::class, 'showPublico'])->name('calificaciones.show');
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
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
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS - SUPER ADMINISTRADOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');
    
    Route::resource('administradores', SuperAdminController::class)->names('administradores')->except(['create', 'edit']);
    Route::get('/administradores/crear', [SuperAdminController::class, 'create'])->name('administradores.create');
    Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Autenticación General)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // --- DASHBOARDS ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/padres/dashboard', function() {
        return view('padres.dashboard');
    })->name('padres.dashboard');
    
    Route::get('/estudiantes/dashboard', function() {
        return view('estudiantes.dashboard');
    })->name('estudiantes.dashboard');
    
    Route::get('/profesores/dashboard', [ProfesorController::class, 'dashboard'])->name('profesores.dashboard');
    
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // ==========================================
    // CALENDARIO - GESTIÓN ADMINISTRATIVA
    // ==========================================
    // 

    // --- GESTIÓN DE ADMINISTRADORES (Perfil Admin) ---
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::resource('/', AdminController::class)->except(['create', 'edit']);
        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        
        // Gestión de permisos de padres
        Route::get('/permisos', [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar', [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar', [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}', [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');
    });

    // --- RECURSOS PRINCIPALES ---
    Route::resource('calificaciones', CalificacionController::class);
    Route::resource('ciclos', CicloController::class);
    Route::resource('grados', GradoController::class);
    
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class);

    // Padres
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular', [PadreController::class, 'desvincular'])->name('padres.desvincular');
    Route::resource('padres', PadreController::class);

    // Matriculas
    Route::resource('matriculas', MatriculaController::class);
    Route::post('matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');
    Route::post('matriculas/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('matriculas.rechazar');
    Route::post('matriculas/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])->name('matriculas.cancelar');

    // Académico
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
        Route::get('/', [CursoController::class, 'index'])->name('index');
        Route::get('/create', [CursoController::class, 'create'])->name('create');
        Route::post('/', [CursoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CursoController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
    });

    Route::resource('observaciones', ObservacionController::class)->except(['show']);
    Route::resource('documentos', DocumentoController::class);

    // Contraseña Usuario
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
});