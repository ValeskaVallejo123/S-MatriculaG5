<?php

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
<<<<<<< HEAD
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\CalificacionController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin autenticación requerida)
|--------------------------------------------------------------------------
*/

// Página principal - Plantilla pública
=======
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CalificacionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

// ------------------------
// 🔹 LOGIN / REGISTRO
// ------------------------
>>>>>>> origin/main
Route::get('/', function () {
    return view('plantilla');
})->name('home');

<<<<<<< HEAD
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


});

// Ruta para mostrar el formulario de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Ruta para procesar el login
Route::post('/login', [LoginController::class, 'login']);

// Ruta para logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Rutas del Super Admin (protegidas)
Route::middleware(['auth', 'super_admin'])->prefix('superadmin')->group(function () {

    // Perfil del Super Admin
    Route::get('/perfil', function() {
        return view('superadmin.perfil');
    })->name('superadmin.perfil');

    });

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
//Rutas de Calificaciones
Route::get('/indexCalificaciones', [CalificacionController::class, 'indexCalificaciones'])->name('calificaciones.index');

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

    // Rutas de Matrículas (protegidas por autenticación)
Route::middleware(['auth'])->group(function () {
    Route::resource('matriculas', MatriculaController::class);
});

Route::middleware(['auth'])->group(function () {

    // Rutas resource de matrículas
    Route::resource('matriculas', MatriculaController::class);

    // Rutas adicionales para cambiar estados
    Route::post('matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])
        ->name('matriculas.confirmar');

    Route::post('matriculas/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])
        ->name('matriculas.rechazar');

    Route::post('matriculas/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])
        ->name('matriculas.cancelar');
});

Route::middleware(['auth'])->group(function () {
    // Ruta para crear matrícula
    Route::get('matriculas/create', [MatriculaController::class, 'create'])->name('matriculas.create');
});

Route::get('/dashboard', function () {
    return view('plantilla');
})->middleware('auth')->name('dashboard');
=======
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ------------------------
// 🔹 RUTAS PROTEGIDAS
// ------------------------
Route::middleware('auth')->group(function () {

    // Paneles según rol
    Route::get('/admin', function () { return "¡Accediste al panel de admin!"; })->middleware('rol:admin');
    Route::get('/estudiante', function () { return "¡Accediste al panel de estudiante!"; })->middleware('rol:estudiante');

    // Admins
    Route::middleware('rol:admin')->group(function () {
        Route::resource('admins', AdminController::class);
        Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
    });

    // Estudiantes
    Route::middleware('rol:estudiante')->group(function () {
        Route::resource('matriculas', MatriculaController::class)->except(['index']);
    });

    // CRUD principales
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);
    Route::resource('observaciones', ObservacionController::class)->except(['show']);
    Route::resource('documentos', DocumentoController::class);
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    // Confirmación de matrícula
    Route::post('/matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');
    Route::patch('/matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirm'])->name('matriculas.confirm');

    // Descargar comprobante
    Route::get('/matriculas/{matricula}/comprobante/descargar', [MatriculaController::class, 'descargarComprobante'])->name('matriculas.descargarComprobante');

    // Buscar estudiante
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');

    // Estado de solicitud
    Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('solicitud.verEstado');
    Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

    // Cambiar contraseña
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    // Grados y ciclos
    Route::resource('grados', GradoController::class);
    Route::resource('ciclos', CicloController::class);

    // Calificaciones
    Route::resource('calificaciones', CalificacionController::class)->parameters(['calificaciones' => 'calificacion']);

    // Calendario académico
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::get('/calendario/eventos', [CalendarioController::class, 'obtenerEventos'])->name('calendario.eventos');
    Route::post('/calendario/eventos', [CalendarioController::class, 'guardar'])->name('calendario.guardar');
    Route::put('/calendario/eventos/{evento}', [CalendarioController::class, 'actualizar'])->name('calendario.actualizar');
    Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar'])->name('calendario.eliminar');
});

// ------------------------
// 🔹 CUPOS MÁXIMOS
// ------------------------
Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
    Route::get('/', [CursoController::class, 'index'])->name('index');
    Route::get('/create', [CursoController::class, 'create'])->name('create');
    Route::post('/', [CursoController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CursoController::class, 'update'])->name('update');
    Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
});

// ------------------------
// 🔹 RECUPERACIÓN DE CONTRASEÑA
// ------------------------
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

// Rutas adicionales
Route::get('/plantilla', function () { return view('plantilla'); })->name('plantilla');
>>>>>>> origin/main
