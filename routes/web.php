<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PerfilController,
    Auth\ForgotPasswordController,
    Auth\ResetPasswordController,
    AdminAsignacionProfesorGuiaController,
    Auth\LoginController,
    Auth\RegisterController,
    PasswordResetController,
    SuperAdminController,
    AdminController,
    DashboardController,
    EstudianteController,
    EstudianteDashboardController,
    BuscarEstudianteController,
    ProfesorController,
    MatriculaController,
    PeriodoAcademicoController,
    CursoController,
    ObservacionController,
    DocumentoController,
    SolicitudController,
    CambiarContraseniaController,
    PadrePermisoController,
    PadreController,
    GradoController,
    MateriaController,
    HorarioGradoController,
    HorarioController,
    NotificacionPreferenciaController,
    NotificacionController,
    SuperAdmin\UsuarioController,
    RegistrarCalificacionController,
    AccionesImportantesController
};

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::view('/', 'plantilla')->name('home');
Route::view('/plantilla', 'plantilla')->name('plantilla');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| MATRÍCULA PÚBLICA
|--------------------------------------------------------------------------
*/
Route::get('/matricula-publica', [MatriculaController::class, 'create'])->name('matriculas.public.create');
Route::post('/matricula-publica', [MatriculaController::class, 'store'])->name('matriculas.public.store');
Route::get('/matricula-exitosa', [MatriculaController::class, 'success'])->name('matriculas.success');

/*
|--------------------------------------------------------------------------
| CONSULTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('estado-solicitud.consultar');

Route::view('/consultar-estudiante', 'publico.consultar-estudiante')->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

/*
|--------------------------------------------------------------------------
| PORTAL PÚBLICO
|--------------------------------------------------------------------------
*/
Route::prefix('portal')->name('portal.')->group(function () {
    Route::view('/', 'portal.inicio')->name('inicio');
    Route::view('/acerca-de', 'portal.acerca-de')->name('acerca-de');
    Route::view('/contacto', 'portal.contacto')->name('contacto');

    Route::get('/horarios-publicos', [HorarioController::class, 'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');
});

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD GENERAL (REDIRECCIONADOR)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS POR ROL
    |--------------------------------------------------------------------------
    */
    Route::get('/superadmin/dashboard', fn () => view('superadmin.dashboard'))
        ->middleware('role:superadmin')
        ->name('superadmin.dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::view('/profesor/dashboard', 'profesor.dashboard.index')
        ->middleware('role:profesor')
        ->name('profesor.dashboard');

    Route::view('/padre/dashboard', 'padre.dashboard.index')
        ->middleware('role:padre')
        ->name('padre.dashboard');

    Route::get('/estudiante/dashboard', [EstudianteDashboardController::class, 'index'])
        ->middleware('role:estudiante')
        ->name('estudiante.dashboard');

    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {
        Route::resource('administradores', SuperAdminController::class);
        Route::resource('usuarios', UsuarioController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | CRUD PRINCIPALES
    |--------------------------------------------------------------------------
    */
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class);
    Route::resource('padres', PadreController::class);
    Route::resource('matriculas', MatriculaController::class);
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);
    Route::resource('cupos_maximos', CursoController::class);
    Route::resource('observaciones', ObservacionController::class)->except('show');
    Route::resource('documentos', DocumentoController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('grados', GradoController::class);

    /*
    |--------------------------------------------------------------------------
    | ESTUDIANTE
    |--------------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->middleware('role:estudiante')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorario'])->name('miHorario');
        Route::get('/horario', [HorarioController::class, 'horarioEstudiante'])->name('horario');
        Route::get('/calificaciones', [EstudianteController::class, 'misNotas'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
    });

    /*
    |--------------------------------------------------------------------------
    | PROFESOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->middleware('role:profesor')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
    });
});
