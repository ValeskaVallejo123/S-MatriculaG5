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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');



// --- 🌍 RUTAS PÚBLICAS ---
Route::controller(CalendarioController::class)->group(function () {
    // ⚠️ CORRECCIÓN: Ahora llama a la función que muestra la vista pública.
    Route::get('/calendario_publico', 'vistaPublica')->name('calendario.publico');
    
    // Obtener datos para mostrar (Generalmente es público, o puedes replicarlo si los datos difieren)
   // Ruta pública para obtener eventos (solo lectura)
Route::get('/calendario/eventos', [CalendarioController::class, 'obtenerEventos']);
});

// Rutas privadas (con autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/calendario', [CalendarioController::class, 'index'])
        ->name('calendario.index');
    
    // API para gestionar eventos (solo autenticados)
    Route::post('/calendario/eventos', [CalendarioController::class, 'store']);
    Route::put('/calendario/eventos/{id}', [CalendarioController::class, 'update']);
    Route::delete('/calendario/eventos/{id}', [CalendarioController::class, 'destroy']);
});

    Route::resource('calificaciones', CalificacionController::class)->parameters([
        'calificaciones' => 'calificacion',
    ]);

    Route::resource('ciclos', CicloController::class);
    Route::resource('grados', GradoController::class);

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
*/
Route::middleware(['auth', 'super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Perfil de super admin
    Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');
    
    // Gestión de administradores
    Route::resource('administradores', SuperAdminController::class)->names('administradores')->except(['create', 'edit']);
    Route::get('/administradores/crear', [SuperAdminController::class, 'create'])->name('administradores.create');
    Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
    // Rutas alternativas (redundantes pero mantenidas si son usadas en vistas)
    Route::get('/administradores/create', [SuperAdminController::class, 'create']); 
    Route::get('/administradores/{administrador}/edit', [SuperAdminController::class, 'edit']); 
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Autenticación)
|--------------------------------------------------------------------------
| Accesible para todos los usuarios autenticados
*/
Route::middleware(['auth'])->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS POR ROL
    |--------------------------------------------------------------------------
    | La ruta /dashboard redirige según la lógica en LoginController/AuthMiddleware
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Dashboards específicos
    Route::get('/padres/dashboard', function() {
        return view('padres.dashboard');
    })->name('padres.dashboard');
    
    Route::get('/estudiantes/dashboard', function() {
        return view('estudiantes.dashboard');
    })->name('estudiantes.dashboard');
    
    Route::get('/profesores/dashboard', [ProfesorController::class, 'dashboard'])->name('profesores.dashboard');
    
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    /*
    |--------------------------------------------------------------------------
    | PANEL DE ADMINISTRADORES REGULARES
    |--------------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admins.')->group(function () {
    // 💡 CORRECCIÓN: Quitamos ->names('index') para que use el prefijo 'admins.'
    Route::resource('/', AdminController::class)->except(['create', 'edit']);
    
    // ... mantener el resto de las rutas dentro del grupo

    // Rutas para crear y editar, que SÍ necesitan names
    Route::get('/crear', [AdminController::class, 'create'])->name('create');
    Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        
        // Rutas alternativas (redundantes pero mantenidas si son usadas en vistas)
        Route::get('/create', [AdminController::class, 'create']); 
        Route::get('/{admin}/edit', [AdminController::class, 'edit']); 
        
        // Gestión de permisos de padres
        Route::get('/permisos', [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar', [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar', [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}', [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');
    });

    /*
    |--------------------------------------------------------------------------
    | CRUD & GESTIÓN DE RECURSOS
    |--------------------------------------------------------------------------
    */

    // ESTUDIANTES
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);

    // PROFESORES
    Route::resource('profesores', ProfesorController::class);

    // PADRES/TUTORES
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular', [PadreController::class, 'desvincular'])->name('padres.desvincular');
    Route::resource('padres', PadreController::class);

    // MATRÍCULAS
    Route::resource('matriculas', MatriculaController::class);
    Route::post('matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');
    Route::post('matriculas/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('matriculas.rechazar');
    Route::post('matriculas/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])->name('matriculas.cancelar');

    // PERIODOS ACADÉMICOS
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    // CUPOS MÁXIMOS (CURSOS) - Usando CursoController
    Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
        Route::get('/', [CursoController::class, 'index'])->name('index');
        Route::get('/create', [CursoController::class, 'create'])->name('create');
        Route::post('/', [CursoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CursoController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
    });

    // OBSERVACIONES
    Route::resource('observaciones', ObservacionController::class)->except(['show']);

    // DOCUMENTOS
    Route::resource('documentos', DocumentoController::class);

    // CAMBIAR CONTRASEÑA
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
});