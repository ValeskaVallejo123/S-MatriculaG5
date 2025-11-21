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
use App\Http\Controllers\PadrePermisoController;
use App\Http\Controllers\PadreController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NotificacionPreferenciaController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin autenticación requerida)
|--------------------------------------------------------------------------
*/


// Home y Plantilla
Route::get('/', function () {
    return view('plantilla');
})->name('home');

Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

// Portal público de horarios y profesores
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', function () { return view('portal.inicio'); })->name('inicio');
    Route::get('/acerca-de', function () { return view('portal.acerca-de'); })->name('acerca-de');
    Route::get('/contacto', function () { return view('portal.contacto'); })->name('contacto');
    Route::get('/horarios-publicos', [HorarioController::class, 'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');
});

// Consulta de solicitudes (público)
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('solicitud.consultar');

// Consulta de estudiante (público)
Route::get('/consultar-estudiante', function () {
    return view('publico.consultar-estudiante');
})->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
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

// Rutas alternativas (opcional duplicado, se mantiene)
Route::get('/password/forgot', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/forgot', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboards genéricos
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');
    Route::get('/superadmin/dashboard', function () { return view('superadmin.dashboard'); })->name('superadmin.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/profesor/dashboard', function () { return view('profesor.dashboard.index'); })->name('profesor.dashboard');
    Route::get('/estudiante/dashboard', function () { return view('estudiante.dashboard.index'); })->name('estudiante.dashboard');
    Route::get('/padre/dashboard', function () { return view('padre.dashboard.index'); })->name('padre.dashboard');

    // Super Administrador
    Route::prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        Route::get('/administradores', [SuperAdminController::class, 'index'])->name('administradores.index');
        Route::get('/administradores/crear', [SuperAdminController::class, 'create'])->name('administradores.create');
        Route::post('/administradores', [SuperAdminController::class, 'store'])->name('administradores.store');
        Route::get('/administradores/{administrador}', [SuperAdminController::class, 'show'])->name('administradores.show');
        Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
        Route::put('/administradores/{administrador}', [SuperAdminController::class, 'update'])->name('administradores.update');
        Route::delete('/administradores/{administrador}', [SuperAdminController::class, 'destroy'])->name('administradores.destroy');
    });

    // Administradores regulares
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');

        // Permisos padres
        Route::get('/permisos', [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar', [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar', [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}', [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');
    });

    // Estudiantes
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);

    // Profesores
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

    // Padres
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular', [PadreController::class, 'desvincular'])->name('padres.desvincular');
    Route::resource('padres', PadreController::class);

    // Matrículas
    Route::resource('matriculas', MatriculaController::class);
    Route::post('matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');
    Route::post('matriculas/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('matriculas.rechazar');
    Route::post('matriculas/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])->name('matriculas.cancelar');

    // Periodos académicos
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    // Cursos / Cupos máximos
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

    // Materias y Grados
    Route::resource('materias', MateriaController::class);
    Route::resource('grados', GradoController::class);
    Route::get('grados/{grado}/asignar-materias', [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
    Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

    // Cambiar contraseña
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    // Horarios
    Route::prefix('horarios')->name('horarios.')->group(function () {
        Route::get('/', [HorarioController::class, 'index'])->name('index');
        Route::get('/create', [HorarioController::class, 'create'])->name('create');
        Route::post('/', [HorarioController::class, 'store'])->name('store');
        Route::get('/{horario}', [HorarioController::class, 'show'])->name('show');
        Route::get('/{horario}/edit', [HorarioController::class, 'edit'])->name('edit');
        Route::put('/{horario}', [HorarioController::class, 'update'])->name('update');
        Route::delete('/{horario}', [HorarioController::class, 'destroy'])->name('destroy');

        Route::get('/profesor/mi-horario', [HorarioController::class, 'miHorario'])->name('profesor.mi-horario');
        Route::get('/profesor/{profesor}/horario', [HorarioController::class, 'horarioPorProfesor'])->name('profesor.horario');
        Route::get('/{profesor}/exportar-pdf', [HorarioController::class, 'exportPDF'])->name('exportPDF');
    });

    Route::middleware('auth')->group(function () {
        Route::get('notificaciones', [NotificacionPreferenciaController::class, 'edit'])->name('notificaciones.edit');
        Route::put('notificaciones', [NotificacionPreferenciaController::class, 'update'])->name('notificaciones.update');
    });

    // Estudiante - Permisos y rutas específicas
    Route::middleware(['auth', 'role:estudiante'])->prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/matricula', [MatriculaController::class, 'create'])->name('matricula');
        Route::post('/matricula', [MatriculaController::class, 'store'])->name('matricula.store');
        Route::get('/horario', [HorarioController::class, 'horarioEstudiante'])->name('horario');
        Route::get('/calificaciones', [EstudianteController::class, 'misNotas'])->name('calificaciones');
    });

});
