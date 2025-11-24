<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\PadreController;
use App\Http\Controllers\PadrePermisoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\VerGradoController;
use Illuminate\Support\Facades\Route; 

/*
|--------------------------------------------------------------------------
| 🌐 RUTAS PÚBLICAS (Sin autenticación requerida)
|--------------------------------------------------------------------------
*/

// Vistas base
Route::get('/', function () {
    return view('plantilla');
})->name('home');

Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

// Consulta de solicitudes (Usada en la plantilla para "Consultar Solicitud")
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

    
    // --- 🔎 CONSULTAS PÚBLICAS (Solo Lectura) ---
Route::prefix('publico')->name('publico.')->group(function () {
    
    // Lista de ciclos (público) - Accesible en: /publico/ciclos
    Route::get('/ciclos', [CicloController::class, 'indexPublico'])->name('ciclos.index'); 
    
    // Detalle de un ciclo (público) - Accesible en: /publico/ciclos/{id}
    Route::get('/ciclos/{id}', [CicloController::class, 'showPublico'])->name('ciclos.show');
});

// --- 📅 CALENDARIO PÚBLICO (Lectura) ---
Route::get('/calendario/publico', [CalendarioController::class, 'vistaPublica'])->name('calendario.publico');
Route::get('/calendario/eventos/publico', [CalendarioController::class, 'eventosPublicos'])->name('calendario.eventos.publicos');

// --- 🔎 CONSULTAS PÚBLICAS (Solo Lectura) ---
Route::prefix('publico')->name('publico.')->group(function () {


     Route::get('/grados', [VerGradoController::class, 'indexPublico'])->name('grados.index');
Route::get('/grados/{id}', [VerGradoController::class, 'showPublico'])->name('grados.showPublico'); // Para ver detalles del grado
Route::get('/grados/{id}/clases', [VerGradoController::class, 'verClasesPublico'])->name('grados.clases');

    Route::get('/calificaciones', [CalificacionController::class, 'indexPublico'])->name('calificaciones.index');
    Route::get('/calificaciones/{id}', [CalificacionController::class, 'showPublico'])->name('calificaciones.show');
});

/*
|--------------------------------------------------------------------------
| 🔑 AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| 🔒 RECUPERACIÓN DE CONTRASEÑA
|--------------------------------------------------------------------------
*/
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

/*
|--------------------------------------------------------------------------
| 👑 RUTAS PROTEGIDAS - SUPER ADMINISTRADOR
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
| ✅ RUTAS PROTEGIDAS (Requieren Autenticación General)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // --- DASHBOARDS ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/padres/dashboard', function() { return view('padres.dashboard'); })->name('padres.dashboard');
    Route::get('/estudiantes/dashboard', function() { return view('estudiantes.dashboard'); })->name('estudiantes.dashboard');
    Route::get('/profesores/dashboard', [ProfesorController::class, 'dashboard'])->name('profesores.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // --- 📅 CALENDARIO - GESTIÓN ADMINISTRATIVA ---
    Route::prefix('admin')->group(function () {
        Route::get('/calendario', [CalendarioController::class, 'vistaAdmin'])->name('admin.calendario');
        Route::get('/calendario/eventos', [CalendarioController::class, 'listarEventos'])->name('admin.calendario.eventos.listar');
        Route::post('/calendario/eventos', [CalendarioController::class, 'crearEvento'])->name('admin.calendario.eventos.crear');
        Route::put('/calendario/eventos/{id}', [CalendarioController::class, 'actualizarEvento'])->name('admin.calendario.eventos.actualizar');
        Route::delete('/calendario/eventos/{id}', [CalendarioController::class, 'eliminarEvento'])->name('admin.calendario.eventos.eliminar');
    });

    // --- ⚙️ GESTIÓN DE ADMINISTRADORES (Admin) ---
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
    
    
    // --- 🏫 GESTIÓN ACADÉMICA ---
    Route::resource('ciclos', CicloController::class);
    Route::resource('calificaciones', CalificacionController::class);
    
    // ✅ RUTAS ADMINISTRATIVAS DE GRADOS (CORREGIDAS)
    Route::resource('grados', VerGradoController::class);
    
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);
    
    // Cursos (cupos_maximos)
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

    // --- 📝 GESTIÓN DE MATRÍCULAS ---
    Route::resource('matriculas', MatriculaController::class);
    Route::post('matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');
    Route::post('matriculas/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('matriculas.rechazar');
    Route::post('matriculas/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])->name('matriculas.cancelar');

    // --- 🧑‍💻 GESTIÓN DE USUARIOS ---
    Route::resource('estudiantes', EstudianteController::class);
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
    Route::resource('profesores', ProfesorController::class);
    
    // Padres
    Route::resource('padres', PadreController::class);
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular', [PadreController::class, 'desvincular'])->name('padres.desvincular');

    // Contraseña Usuario (General)
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
});