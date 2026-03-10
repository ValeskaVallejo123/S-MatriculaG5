<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
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
use App\Http\Controllers\SuperAdmin\UsuarioController;
use App\Http\Controllers\CargaDocenteController;
use App\Http\Controllers\PadreDashboardController;
use App\Http\Controllers\AccionesImportantesController;
use App\Http\Controllers\Admin\SolicitudAdminController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\CupoMaximoController;
use App\Http\Controllers\PublicoPlanEstudiosController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\RegistrarCalificacionController;
use App\Http\Controllers\H20CursoController;
use App\Http\Controllers\ConsultaestudiantexcursoController;


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Ruta raíz - Redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// PLANTILLA PRINCIPAL (PÚBLICA) - Para el botón del login
Route::get('/inicio', function () {
    return view('plantilla');
})->name('inicio');

Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS DE MATRÍCULA (SIN AUTH)
|--------------------------------------------------------------------------
*/

// Plan de estudios
Route::get('/plan-estudios',         [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');
Route::get('/plan-estudios/{grado}', [PublicoPlanEstudiosController::class, 'show'])->name('plan-estudios.show');

// Calendario público
Route::get('/calendario-publico',        fn () => view('calendario-publico'))->name('calendario.publico');
Route::get('/calendario/eventos/public', [CalendarioController::class, 'eventosPublicos'])->name('calendario.eventos.public');

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS DE MATRÍCULA
|--------------------------------------------------------------------------
*/
Route::get('/matricula-publica',  [MatriculaController::class, 'create'])->name('matriculas.public.create');
Route::post('/matricula-publica', [MatriculaController::class, 'store'])->name('matriculas.public.store');
Route::get('/matricula-exitosa',  [MatriculaController::class, 'success'])->name('matriculas.success');

/*
|--------------------------------------------------------------------------
| CONSULTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/estado-solicitud',  [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('estado-solicitud.consultar');
Route::view('/consultar-estudiante', 'publico.consultar-estudiante')->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

/*
|--------------------------------------------------------------------------
| PORTAL PÚBLICO
|--------------------------------------------------------------------------
*/
Route::prefix('portal')->name('portal.')->group(function () {
    Route::view('/',          'portal.inicio')->name('inicio');
    Route::view('/acerca-de', 'portal.acerca-de')->name('acerca-de');
    Route::view('/contacto',  'portal.contacto')->name('contacto');
    Route::get('/horarios-publicos',   [HorarioController::class,  'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login',   [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',  [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA (PÚBLICA)
|--------------------------------------------------------------------------
*/
Route::get('/password/solicitar',           [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar',          [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer',        [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar',          'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard con redirección por rol
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $roleRouteMap = [
            1 => 'superadmin.dashboard',
            2 => 'admin.dashboard',
            3 => 'profesor.dashboard',
            4 => 'estudiante.dashboard',
            5 => 'padre.dashboard',
        ];
        return redirect()->route($roleRouteMap[$user->id_rol] ?? 'inicio');
    })->name('dashboard');

    // Calendario (auth, todos los roles)
    Route::get('/calendario/eventos',             [CalendarioController::class, 'obtenerEventos']);
    Route::post('/calendario/eventos',            [CalendarioController::class, 'store']);
    Route::put('/calendario/eventos/{id}',        [CalendarioController::class, 'actualizar']);
    Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar']);

    // Notificaciones (todos los roles)
    Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
        Route::get('/',                      [NotificacionController::class,            'index'])->name('index');
        Route::patch('/{notificacion}/leer', [NotificacionController::class,            'marcarLeida'])->name('marcarLeida');
        Route::get('/preferencias',          [NotificacionPreferenciaController::class, 'edit'])->name('preferencias');
        Route::put('/preferencias',          [NotificacionPreferenciaController::class, 'update'])->name('preferencias.update');
    });

    // Acciones importantes
    Route::resource('acciones-importantes', AccionesImportantesController::class)
        ->names('acciones_importantes');

    /*
    |----------------------------------------------------------------------
    | SUPER ADMINISTRADOR
    |----------------------------------------------------------------------
    */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

        // Perfil
        Route::get('/perfil',          [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil',          [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        // Cambiar contraseña
        Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        // Permisos y roles (ESTÁTICAS — antes de {administrador})
        Route::get('/administradores/permisos',           [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos');
        Route::get('/administradores/permisos-roles',     [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos-roles');
        Route::put('/administradores/permisos/guardar',   [SuperAdminController::class, 'actualizarPermisos'])->name('administradores.permisos.update');

        // Crear (ESTÁTICA — antes de {administrador})
        Route::get('/administradores/crear', [SuperAdminController::class, 'create'])->name('administradores.create');
        Route::post('/administradores',      [SuperAdminController::class, 'store'])->name('administradores.store');

        // Listado
        Route::get('/administradores', [SuperAdminController::class, 'index'])->name('administradores.index');

        // Rutas dinámicas {administrador} (SIEMPRE al final)
        Route::get('/administradores/{administrador}',         [SuperAdminController::class, 'show'])->name('administradores.show');
        Route::get('/administradores/{administrador}/editar',  [SuperAdminController::class, 'edit'])->name('administradores.edit');
        Route::put('/administradores/{administrador}',         [SuperAdminController::class, 'update'])->name('administradores.update');
        Route::delete('/administradores/{administrador}',      [SuperAdminController::class, 'destroy'])->name('administradores.destroy');

        // Grados
        Route::get('grados/crear-masivo',    [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class);
        Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        // Materias
        Route::resource('materias', MateriaController::class);

        // Horarios de grado
        Route::resource('horarios_grado', HorarioGradoController::class);

        // Profesor-Materia
        Route::prefix('profesor-materia')->name('profesor_materia.')->group(function () {
            Route::get('/',                [ProfesorMateriaController::class, 'index'])->name('index');
            Route::get('/create',          [ProfesorMateriaController::class, 'create'])->name('create');
            Route::post('/',               [ProfesorMateriaController::class, 'store'])->name('store');
            Route::get('/{profesor}/edit', [ProfesorMateriaController::class, 'edit'])->name('edit');
            Route::put('/{profesor}',      [ProfesorMateriaController::class, 'update'])->name('update');
            Route::delete('/{profesor}',   [ProfesorMateriaController::class, 'destroy'])->name('destroy');
        });

        // Usuarios pendientes y activar/desactivar
        Route::get('usuarios/pendientes',       [UsuarioController::class, 'pendientes'])->name('usuarios.pendientes');
        Route::post('usuarios/{id}/aprobar',    [UsuarioController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::delete('usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])->name('usuarios.rechazar');
        Route::put('usuarios/{id}/activar',     [UsuarioController::class, 'activar'])->name('usuarios.activar');
        Route::put('usuarios/{id}/desactivar',  [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');
        Route::resource('usuarios', UsuarioController::class);

    }); // fin superadmin

    /*
    |----------------------------------------------------------------------
    | ADMINISTRADOR
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('/',               [SolicitudController::class, 'index'])->name('index');
            Route::get('/{id}',           [SolicitudController::class, 'show'])->name('show');
            Route::post('/{id}/aprobar',  [SolicitudController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar', [SolicitudController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/pendiente',[SolicitudController::class, 'pendiente'])->name('pendiente');
        });
    }); // fin admin

    /*
    |----------------------------------------------------------------------
    | PROFESOR
    |----------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->group(function () {
        Route::get('/dashboard', function () {
            return view('profesor.dashboard.index');
        })->name('dashboard');

        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
        Route::get('/mi-horario',          [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones',      [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');

        // Solicitudes del profesor
        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('/',               [SolicitudAdminController::class, 'index'])->name('index');
            Route::get('/{id}',           [SolicitudAdminController::class, 'show'])->name('show');
            Route::post('/{id}/aprobar',  [SolicitudAdminController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar', [SolicitudAdminController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/pendiente',[SolicitudAdminController::class, 'pendiente'])->name('pendiente');
        });
    });

    /*
    |----------------------------------------------------------------------
    | ESTUDIANTE
    |----------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/dashboard', function () {
            return view('estudiante.dashboard.index');
        })->name('dashboard');
    });

    /*
    |----------------------------------------------------------------------
    | PADRE / TUTOR — Portal familiar
    |----------------------------------------------------------------------
    */
    Route::prefix('padre')->name('padre.')->middleware('es.padre')->group(function () {
        Route::get('/dashboard', [PadreDashboardController::class, 'index'])->name('dashboard');
        Route::get('/hijo/{estudianteId}', [PadreDashboardController::class, 'verHijo'])->name('hijo');
    });

    /*
    |----------------------------------------------------------------------
    | PANEL ADMINS
    |----------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admins.')->group(function () {

        // Roles y permisos de administradores
        Route::get('/roles-permisos',           [SuperAdminController::class, 'permisosRoles'])->name('roles-permisos');
        Route::put('/roles-permisos/guardar',   [SuperAdminController::class, 'actualizarPermisos'])->name('asignar-permisos');

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Crear (ESTÁTICA — antes de {admin})
        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::post('/',     [AdminController::class, 'store'])->name('store');

        // Permisos de padres
        Route::get('/permisos',                                    [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar',                 [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar',                   [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto',       [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}',            [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle',       [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');

        // Listado
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Rutas dinámicas {admin} (SIEMPRE al final)
        Route::get('/{admin}',        [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}',        [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}',     [AdminController::class, 'destroy'])->name('destroy');

    }); // fin admins

    /*
    |----------------------------------------------------------------------
    | RUTAS COMPARTIDAS (admin y superadmin)
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin,superadmin')->group(function () {

        Route::get('/carga-docente', [CargaDocenteController::class, 'index'])->name('carga-docente.index');

        // Estudiantes
        Route::resource('estudiantes', EstudianteController::class);

        // Profesores
        Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

        // Padres / Tutores
        Route::get('/padres/buscar',            [PadreController::class, 'buscar'])->name('padres.buscar');
        Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
        Route::post('/padres/desvincular',      [PadreController::class, 'desvincular'])->name('padres.desvincular');
        Route::resource('padres', PadreController::class);

        // Matrículas
        Route::prefix('matriculas')->name('matriculas.')->group(function () {
            Route::get('/',                       [MatriculaController::class, 'index'])->name('index');
            Route::get('/crear',                  [MatriculaController::class, 'create'])->name('create');
            Route::post('/',                      [MatriculaController::class, 'store'])->name('store');
            Route::get('/{matricula}',            [MatriculaController::class, 'show'])->name('show');
            Route::get('/{matricula}/editar',     [MatriculaController::class, 'edit'])->name('edit');
            Route::put('/{matricula}',            [MatriculaController::class, 'update'])->name('update');
            Route::delete('/{matricula}',         [MatriculaController::class, 'destroy'])->name('destroy');
            Route::get('/{matricula}/detalles',   [MatriculaController::class, 'detalles'])->name('detalles');
            Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
            Route::post('/{matricula}/rechazar',  [MatriculaController::class, 'rechazar'])->name('rechazar');
            Route::post('/{matricula}/cancelar',  [MatriculaController::class, 'cancelar'])->name('cancelar');
        });

        // Periodos académicos
        Route::resource('periodos-academicos', PeriodoAcademicoController::class);

        // Ciclos (NUEVO del main)
        Route::resource('ciclos', CicloController::class);

        // Secciones (NUEVO del main)
        Route::post('secciones/asignar', [SeccionController::class, 'asignar'])->name('secciones.asignar');
        Route::resource('seccion', SeccionController::class)->names([
            'index'   => 'secciones.index',
            'create'  => 'secciones.create',
            'store'   => 'secciones.store',
            'edit'    => 'secciones.edit',
            'update'  => 'secciones.update',
            'destroy' => 'secciones.destroy',
        ]);

        // Cupos máximos (NUEVO del main)
        Route::resource('cupos_maximos', CupoMaximoController::class);

        // Observaciones
        Route::resource('observaciones', ObservacionController::class)->except(['show']);

        // Documentos
        Route::resource('documentos', DocumentoController::class);

        // Materias y Grados
        Route::resource('materias', MateriaController::class);
        Route::get('grados/crear-masivo',    [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class);
        Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        // Asignación Profesor-Materia
        Route::resource('profesor_materia', ProfesorMateriaController::class);

        // Calendario (Admin)
        Route::get('/calendario', function () {
            return view('calendario-admin');
        })->name('calendario');

        // Cambiar contraseña
        Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        // Consultas de estudiantes por cursos (NUEVO del main)
        Route::get('/consultaestudiantesxcurso',               [ConsultaestudiantexcursoController::class, 'index'])->name('consultaestudiantesxcurso.index');
        Route::get('/consultaestudiantesxcurso/{grado}/{seccion}', [ConsultaestudiantexcursoController::class, 'show'])->name('consultaestudiantesxcurso.show');

        // Cursos para secundaria (NUEVO del main)
        Route::resource('h20cursos', H20CursoController::class);

    }); // fin role:admin,superadmin

    /*
    |----------------------------------------------------------------------
    | CALIFICACIONES (NUEVO del main)
    |----------------------------------------------------------------------
    */
    Route::get('registrar-calificaciones',                         [RegistrarCalificacionController::class, 'create'])->name('registrarcalificaciones.create');
    Route::post('registrar-calificaciones',                        [RegistrarCalificacionController::class, 'store'])->name('registrarcalificaciones.store');
    Route::get('calificaciones',                                   [RegistrarCalificacionController::class, 'index'])->name('registrarcalificaciones.index');
    Route::get('registrar-calificaciones/estudiantes/{curso}',     [RegistrarCalificacionController::class, 'obtenerEstudiantes'])->name('registrarcalificaciones.estudiantes');
    Route::get('registrar-calificaciones/ver',                     [RegistrarCalificacionController::class, 'ver'])->name('registrarcalificaciones.ver');

}); // fin middleware auth