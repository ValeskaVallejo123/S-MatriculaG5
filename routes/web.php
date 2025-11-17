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
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NotificacionPreferenciaController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Home y Plantilla
Route::get('/', function () { return view('plantilla'); })->name('home');
Route::get('/plantilla', function () { return view('plantilla'); })->name('plantilla');

// Portal de información (público)
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', function () { return view('portal.inicio'); })->name('inicio');
    Route::get('/acerca-de', function () { return view('portal.acerca-de'); })->name('acerca-de');
    Route::get('/contacto', function () { return view('portal.contacto'); })->name('contacto');
    Route::get('/horarios-publicos', [HorarioController::class, 'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');
});

// Estado de solicitud de matrícula (público)
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('solicitud.consultar');

// Consulta de estudiante (público)
Route::get('/consultar-estudiante', function () { return view('publico.consultar-estudiante'); })->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Dashboards según rol
Route::get('/dashboard', function () { return view('dashboard'); })->middleware('auth')->name('dashboard');
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->middleware('auth')->name('admin.dashboard');
Route::get('/profesor/dashboard', function () { return view('profesor.dashboard'); })->middleware('auth')->name('profesor.dashboard');

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

// Formulario y envío de link de recuperación
Route::get('/password/forgot', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/forgot', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

// Formulario de restablecimiento
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS - SUPER ADMINISTRADOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/administradores', [SuperAdminController::class, 'index'])->name('administradores.index');
    Route::get('/administradores/crear', [SuperAdminController::class, 'create'])->name('administradores.create');
    Route::post('/administradores', [SuperAdminController::class, 'store'])->name('administradores.store');
    Route::get('/administradores/{administrador}', [SuperAdminController::class, 'show'])->name('administradores.show');
    Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
    Route::put('/administradores/{administrador}', [SuperAdminController::class, 'update'])->name('administradores.update');
    Route::delete('/administradores/{administrador}', [SuperAdminController::class, 'destroy'])->name('administradores.destroy');
    Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (requieren autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Panel de administradores
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
    });

    // Gestión de estudiantes
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);

    // Gestión de profesores
    Route::resource('profesores', ProfesorController::class)->parameter('profesores', 'profesor');

    // Gestión de matrículas
    Route::prefix('matriculas')->name('matriculas.')->group(function () {
        Route::get('/', [MatriculaController::class, 'index'])->name('index');
        Route::get('/create', [MatriculaController::class, 'create'])->name('create');
        Route::post('/', [MatriculaController::class, 'store'])->name('store');
        Route::get('/{matricula}', [MatriculaController::class, 'show'])->name('show');
        Route::get('/{matricula}/edit', [MatriculaController::class, 'edit'])->name('edit');
        Route::put('/{matricula}', [MatriculaController::class, 'update'])->name('update');
        Route::delete('/{matricula}', [MatriculaController::class, 'destroy'])->name('destroy');
        Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
        Route::post('/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('rechazar');
        Route::post('/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])->name('cancelar');
        Route::get('/{matricula}/descargar-comprobante', [MatriculaController::class, 'descargarComprobante'])->name('descargarComprobante');
        Route::get('/{matricula}/ver-comprobante', [MatriculaController::class, 'verComprobante'])->name('verComprobante');
    });

    // Periodos académicos
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    // Cupos máximos (cursos)
    Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
        Route::get('/', [CursoController::class, 'index'])->name('index');
        Route::get('/create', [CursoController::class, 'create'])->name('create');
        Route::post('/', [CursoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CursoController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
    });

    // Observaciones
    Route::resource('observaciones', ObservacionController::class)->except(['show']);

    // Documentos
    Route::resource('documentos', DocumentoController::class);

    // Cambiar contraseña
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    // Notificaciones
    Route::get('notificaciones', [NotificacionPreferenciaController::class, 'edit'])->name('notificaciones.edit');
    Route::put('notificaciones', [NotificacionPreferenciaController::class, 'update'])->name('notificaciones.update');

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE HORARIOS
    |--------------------------------------------------------------------------
    */
    Route::prefix('horarios')->name('horarios.')->group(function () {
        // CRUD básico
        Route::get('/', [HorarioController::class, 'index'])->name('index');
        Route::get('/create', [HorarioController::class, 'create'])->name('create');
        Route::post('/', [HorarioController::class, 'store'])->name('store');
        Route::get('/{horario}', [HorarioController::class, 'show'])->name('show');
        Route::get('/{horario}/edit', [HorarioController::class, 'edit'])->name('edit');
        Route::put('/{horario}', [HorarioController::class, 'update'])->name('update');
        Route::delete('/{horario}', [HorarioController::class, 'destroy'])->name('destroy');

        // Exportar PDF
        Route::get('/pdf/{profesorId?}', [HorarioController::class, 'exportPDF'])->name('pdf');

        // Horario específico profesor
        Route::get('/profesor/mi-horario', [HorarioController::class, 'miHorario'])->name('profesor.mi-horario');
        Route::get('/profesor/{profesor}/horario', [HorarioController::class, 'horarioPorProfesor'])->name('profesor.horario');
    });

    // Horarios públicos (solo protegido)
    Route::get('/horarios-publicos', [HorarioController::class, 'horarioPublico'])->name('portal.horarios');
});

/*
|--------------------------------------------------------------------------
| PERMISOS DEL ESTUDIANTE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:estudiante'])->prefix('estudiante')->name('estudiante.')->group(function () {
    Route::get('/matricula', [MatriculaController::class, 'create'])->name('matricula');
    Route::post('/matricula', [MatriculaController::class, 'store'])->name('matricula.store');
    Route::get('/horario', [HorarioController::class, 'horarioEstudiante'])->name('horario');
    Route::get('/calificaciones', [EstudianteController::class, 'misNotas'])->name('calificaciones');
});

/*
|--------------------------------------------------------------------------
| SUPERADMIN CHECK
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'check.superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index']);
});
