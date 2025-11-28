<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AdminAsignacionProfesorGuiaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\EstudianteDashboardController;
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
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\SuperAdmin\UsuarioController;
use App\Http\Controllers\RegistrarCalificacionController;
use App\Http\Controllers\AccionesImportantesController;


/*
|--------------------------------------------------------------------------
| RUTAS PUBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('plantilla');
})->name('home');

Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');


// Páginas institucionales
Route::get('/nosotros', fn() => view('nosotros'))->name('nosotros');
Route::get('/contacto', fn() => view('contacto'))->name('contacto');

// Portal público (SE MANTIENE TAL CUAL)
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', fn() => view('portal.inicio'))->name('inicio');
    Route::get('/acerca-de', fn() => view('portal.acerca-de'))->name('acerca-de');
    Route::get('/contacto', fn() => view('portal.contacto'))->name('contacto');
    Route::get('/horarios-publicos', [HorarioController::class, 'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');
});

// Matrícula pública
Route::get('/matricula-publica', [MatriculaController::class, 'create'])->name('matriculas.public.create');
Route::post('/matricula-publica', [MatriculaController::class, 'store'])->name('matriculas.public.store');
Route::get('/matricula-exitosa', [MatriculaController::class, 'success'])->name('matriculas.success');

// Consulta de solicitudes (Público)
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('estado-solicitud.consultar');

// Consulta estudiante público
Route::get('/consultar-estudiante', fn() => view('publico.consultar-estudiante'))->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

// Autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Recuperación de contraseña
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');



/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Redirección de dashboard según rol
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');

    // Dashboards por rol
    Route::get('/superadmin/dashboard', fn() => view('superadmin.dashboard'))->name('superadmin.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/profesor/dashboard', fn() => view('profesor.dashboard.index'))->name('profesor.dashboard');
    Route::get('/estudiante/dashboard', [EstudianteDashboardController::class, 'index'])->name('estudiante.dashboard');
    Route::get('/padre/dashboard', fn() => view('padre.dashboard.index'))->name('padre.dashboard');



    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('superadmin')->name('superadmin.')->group(function () {

        Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        // Permisos & roles
        Route::get('/administradores/permisos-roles', [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos');
        Route::put('/administradores/{usuario}/permisos', [SuperAdminController::class, 'actualizarPermisos'])->name('administradores.permisos.update');

        // Gestión de administradores
        Route::get('/administradores', [SuperAdminController::class, 'index'])->name('administradores.index');
        Route::get('/administradores/crear', [SuperAdminController::class, 'create'])->name('administradores.create');
        Route::post('/administradores', [SuperAdminController::class, 'store'])->name('administradores.store');
        Route::get('/administradores/{administrador}', [SuperAdminController::class, 'show'])->name('administradores.show');
        Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
        Route::put('/administradores/{administrador}', [SuperAdminController::class, 'update'])->name('administradores.update');
        Route::delete('/administradores/{administrador}', [SuperAdminController::class, 'destroy'])->name('administradores.destroy');

        // Aprobar/Rechazar usuarios
        Route::post('/usuarios/{id}/aprobar', [UsuarioController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::delete('/usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])->name('usuarios.rechazar');
    });



    /*
    |--------------------------------------------------------------------------
    | ADMINISTRADORES
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    });

    // Permisos padres
    Route::get('/permisos', [PadrePermisoController::class, 'index'])->name('permisos.index');
    Route::get('/permisos/{padre}/configurar', [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
    Route::post('/permisos/{padre}/guardar', [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
    Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
    Route::delete('/permisos/{padre}/{estudiante}', [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
    Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');



    /*
    |--------------------------------------------------------------------------
    | ESTUDIANTES
    |--------------------------------------------------------------------------
    */
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);



    /*
    |--------------------------------------------------------------------------
    | PROFESORES
    |--------------------------------------------------------------------------
    */
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);



    /*
    |--------------------------------------------------------------------------
    | PADRES
    |--------------------------------------------------------------------------
    */
    Route::resource('padres', PadreController::class);
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular', [PadreController::class, 'desvincular'])->name('padres.desvincular');



    /*
    |--------------------------------------------------------------------------
    | MATRÍCULAS (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::prefix('matriculas')->name('matriculas.')->group(function () {
        Route::get('/', [MatriculaController::class, 'index'])->name('index');
        Route::get('/crear', [MatriculaController::class, 'create'])->name('create');
        Route::post('/', [MatriculaController::class, 'store'])->name('store');
        Route::get('/{matricula}', [MatriculaController::class, 'show'])->name('show');
        Route::get('/{matricula}/editar', [MatriculaController::class, 'edit'])->name('edit');
        Route::put('/{matricula}', [MatriculaController::class, 'update'])->name('update');
        Route::delete('/{matricula}', [MatriculaController::class, 'destroy'])->name('destroy');

        Route::get('/{matricula}/detalles', [MatriculaController::class, 'detalles'])->name('detalles');
        Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
        Route::post('/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('rechazar');
        Route::post('/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])->name('cancelar');
    });



    /*
    |--------------------------------------------------------------------------
    | PERIODOS ACADEMICOS
    |--------------------------------------------------------------------------
    */
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);



    /*
    |--------------------------------------------------------------------------
    | CUPOS MAXIMOS (CURSOS)
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
    | OBSERVACIONES
    |--------------------------------------------------------------------------
    */
    Route::resource('observaciones', ObservacionController::class)->except(['show']);



    /*
    |--------------------------------------------------------------------------
    | DOCUMENTOS
    |--------------------------------------------------------------------------
    */
    Route::resource('documentos', DocumentoController::class);



    /*
    |--------------------------------------------------------------------------
    | MATERIAS & GRADOS
    |--------------------------------------------------------------------------
    */
    Route::resource('materias', MateriaController::class);
    Route::resource('grados', GradoController::class);

    Route::get('grados/{grado}/asignar-materias', [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
    Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');



    /*
    |--------------------------------------------------------------------------
    | HORARIOS
    |--------------------------------------------------------------------------
    */
    Route::resource('horarios', HorarioController::class);
    Route::get('horarios/exportar-pdf', [HorarioController::class, 'exportPDF'])->name('horarios.exportPDF');



    /*
    |--------------------------------------------------------------------------
    | ESTUDIANTE – EXCLUSIVO
    |--------------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorario'])->name('miHorario');
        Route::get('/matricula', [MatriculaController::class, 'create'])->name('matricula');
        Route::post('/matricula', [MatriculaController::class, 'store'])->name('matricula.store');
        Route::get('/horario', [HorarioController::class, 'horarioEstudiante'])->name('horario');
        Route::get('/calificaciones', [EstudianteController::class, 'misNotas'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
    });



    /*
    |--------------------------------------------------------------------------
    | PROFESOR – EXCLUSIVO
    |--------------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
    });



    /*
    |--------------------------------------------------------------------------
    | NOTIFICACIONES
    |--------------------------------------------------------------------------
    */
    Route::get('notificaciones/preferencias', [NotificacionPreferenciaController::class, 'edit'])->name('notificaciones.edit');
    Route::put('notificaciones/preferencias', [NotificacionPreferenciaController::class, 'update'])->name('notificaciones.update');



    /*
    |--------------------------------------------------------------------------
    | CALIFICACIONES PROFESOR
    |--------------------------------------------------------------------------
    */
    Route::get('registrar-calificaciones', [RegistrarCalificacionController::class, 'create'])->name('registrarcalificaciones.create');
    Route::post('registrar-calificaciones', [RegistrarCalificacionController::class, 'store'])->name('registrarcalificaciones.store');
    Route::get('calificaciones', [RegistrarCalificacionController::class, 'index'])->name('registrarcalificaciones.index');
    Route::get('registrar-calificaciones/estudiantes/{curso}', [RegistrarCalificacionController::class, 'obtenerEstudiantes'])
        ->name('registrarcalificaciones.estudiantes');



    /*
    |--------------------------------------------------------------------------
    | CAMBIAR CONTRASEÑA
    |--------------------------------------------------------------------------
    */
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

});

