<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
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
use App\Http\Controllers\ProfesorMateriaController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\HorarioGradoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NotificacionPreferenciaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\AccionesImportantesController;
use App\Http\Controllers\SuperAdmin\UsuarioController;

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

Route::view('/plantilla', 'plantilla')->name('plantilla');
Route::view('/inicio', 'plantilla')->name('inicio');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA (PÚBLICA)
|--------------------------------------------------------------------------
*/
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

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

    // Dashboard general
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');

    // Cambiar contraseña
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {

        Route::get('/dashboard', fn () => view('superadmin.dashboard'))->name('dashboard');

        // Perfil
        Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        // Grados
        Route::get('grados/crear-masivo', [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class)
             ->names([
                 'index'   => 'grados.index',
                 'create'  => 'grados.create',
                 'store'   => 'grados.store',
                 'show'    => 'grados.show',
                 'edit'    => 'grados.edit',
                 'update'  => 'grados.update',
                 'destroy' => 'grados.destroy',
             ]);
        Route::get('grados/{grado}/asignar-materias', [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        // Materias
        Route::resource('materias', MateriaController::class)
             ->names([
                 'index'   => 'materias.index',
                 'create'  => 'materias.create',
                 'store'   => 'materias.store',
                 'show'    => 'materias.show',
                 'edit'    => 'materias.edit',
                 'update'  => 'materias.update',
                 'destroy' => 'materias.destroy',
             ]);

        // Horarios de grado (IMPORTANTE: se corrige la ruta que faltaba)
        Route::resource('horarios_grado', HorarioGradoController::class)
             ->names([
                 'index'   => 'horarios_grado.index',
                 'create'  => 'horarios_grado.create',
                 'store'   => 'horarios_grado.store',
                 'show'    => 'horarios_grado.show',
                 'edit'    => 'horarios_grado.edit',
                 'update'  => 'horarios_grado.update',
                 'destroy' => 'horarios_grado.destroy',
             ]);

        // Profesor-Materia
        Route::prefix('profesor-materia')->name('profesor_materia.')->group(function () {
            Route::get('/', [ProfesorMateriaController::class, 'index'])->name('index');
            Route::get('/create', [ProfesorMateriaController::class, 'create'])->name('create');
            Route::post('/', [ProfesorMateriaController::class, 'store'])->name('store');
            Route::get('/{profesor}/edit', [ProfesorMateriaController::class, 'edit'])->name('edit');
            Route::put('/{profesor}', [ProfesorMateriaController::class, 'update'])->name('update');
            Route::delete('/{profesor}', [ProfesorMateriaController::class, 'destroy'])->name('destroy');
        });

        // Usuarios pendientes y activar/desactivar
        Route::get('usuarios/pendientes', [UsuarioController::class, 'pendientes'])->name('usuarios.pendientes');
        Route::post('usuarios/{id}/aprobar', [UsuarioController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::delete('usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])->name('usuarios.rechazar');
        Route::put('usuarios/{id}/activar', [UsuarioController::class, 'activar'])->name('usuarios.activar');
        Route::put('usuarios/{id}/desactivar', [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');

        // Usuarios (Resource)
        Route::resource('usuarios', UsuarioController::class)
             ->names([
                 'index'   => 'usuarios.index',
                 'create'  => 'usuarios.create',
                 'store'   => 'usuarios.store',
                 'show'    => 'usuarios.show',
                 'edit'    => 'usuarios.edit',
                 'update'  => 'usuarios.update',
                 'destroy' => 'usuarios.destroy',
             ]);

        // Administradores
        Route::resource('administradores', SuperAdminController::class)
             ->names([
                 'index'   => 'administradores.index',
                 'create'  => 'administradores.create',
                 'store'   => 'administradores.store',
                 'show'    => 'administradores.show',
                 'edit'    => 'administradores.edit',
                 'update'  => 'administradores.update',
                 'destroy' => 'administradores.destroy',
             ]);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // Permisos padres
        Route::get('/permisos', [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar', [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar', [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}', [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');
    });

    /*
    |--------------------------------------------------------------------------
    | CRUDS PRINCIPALES (admin + superadmin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,superadmin')->group(function () {

        // Resources
        Route::resource('estudiantes', EstudianteController::class);
        Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);
        Route::resource('padres', PadreController::class);
        Route::resource('matriculas', MatriculaController::class);
        Route::resource('periodos-academicos', PeriodoAcademicoController::class);
        Route::resource('cupos_maximos', CursoController::class);
        Route::resource('observaciones', ObservacionController::class)->except('show');
        Route::resource('documentos', DocumentoController::class);

        // Matrículas adicionales
        Route::prefix('matriculas')->name('matriculas.')->group(function () {
            Route::get('/{matricula}/detalles', [MatriculaController::class, 'detalles'])->name('detalles');
            Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
            Route::post('/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('rechazar');
            Route::post('/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])->name('cancelar');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Estudiante
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
    | Profesor
    |--------------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->middleware('role:profesor')->group(function () {
        Route::get('/dashboard', fn () => view('profesor.dashboard.index'))->name('dashboard');
        Route::get('/mi-horario', [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Padre
    |--------------------------------------------------------------------------
    */
    Route::prefix('padre')->name('padre.')->middleware('role:padre')->group(function () {
        Route::get('/dashboard', fn () => view('padre.dashboard.index'))->name('dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | Notificaciones
    |--------------------------------------------------------------------------
    */
    Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
        Route::get('/', [NotificacionController::class, 'index'])->name('index');
        Route::patch('/{notificacion}/leer', [NotificacionController::class, 'marcarLeida'])->name('marcarLeida');
        Route::get('/preferencias', [NotificacionPreferenciaController::class, 'edit'])->name('preferencias');
        Route::put('/preferencias', [NotificacionPreferenciaController::class, 'update'])->name('preferencias.update');
    });
});
