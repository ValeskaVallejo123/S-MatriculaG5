<?php

use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\ProfesorGradoAsignacionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ProfesorDashboardController;
use App\Http\Controllers\ProfesorEstudianteController;
use App\Http\Controllers\ProfesorGradosController;
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
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\CupoMaximoController;
use App\Http\Controllers\PublicoPlanEstudiosController;
use App\Http\Controllers\RegistrarCalificacionController;
use App\Http\Controllers\H20CursoController;
use App\Http\Controllers\ConsultaestudiantexcursoController;

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Ruta raíz
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/inicio', function () {
    return view('plantilla');
})->name('inicio');

Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

// Páginas públicas adicionales
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

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
    Route::view('/',           'portal.inicio')->name('inicio');
    Route::view('/acerca-de', 'portal.acerca-de')->name('acerca-de');
    Route::view('/contacto',   'portal.contacto')->name('contacto');
    Route::get('/horarios-publicos',   [HorarioController::class,  'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA (PÚBLICA)
|--------------------------------------------------------------------------
*/
Route::get('/password/solicitar',            [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar',           [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}',  [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer',         [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

/*
|==========================================================================
| RUTAS PRIVADAS (AUTH)
|==========================================================================
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard con redirección por rol
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $roleRouteMap = [
            'super_admin' => 'superadmin.dashboard',
            'admin'       => 'admin.dashboard',
            'profesor'    => 'profesor.dashboard',
            'estudiante'  => 'estudiante.dashboard',
            'padre'       => 'padre.dashboard',
            'user'        => 'admin.dashboard',
            // compatibilidad numérica
            1 => 'superadmin.dashboard',
            2 => 'admin.dashboard',
            3 => 'profesor.dashboard',
            4 => 'estudiante.dashboard',
            5 => 'padre.dashboard',
        ];
        return redirect()->route($roleRouteMap[$user->id_rol] ?? 'inicio');
    })->name('dashboard');

    Route::get('/buscar-registro', [BuscarEstudianteController::class, 'index'])->name('buscarregistro');

    /*
    |--------------------------------------------------------------------------
    | CALENDARIO (admin + superadmin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/calendario',                     fn () => view('calendario-admin'))->name('calendario');
        Route::get('/calendario/eventos',             [CalendarioController::class, 'obtenerEventos']);
        Route::post('/calendario/eventos',            [CalendarioController::class, 'store']);
        Route::put('/calendario/eventos/{id}',        [CalendarioController::class, 'actualizar']);
        Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar']);
    });

    /*
    |--------------------------------------------------------------------------
    | RUTAS COMPARTIDAS (admin + superadmin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,superadmin')->group(function () {

        Route::get('/carga-docente', [CargaDocenteController::class, 'index'])->name('carga-docente.index');

        Route::resource('estudiantes', EstudianteController::class);
        Route::resource('profesores',  ProfesorController::class)->parameters(['profesores' => 'profesor']);
        Route::resource('padres',      PadreController::class);
        Route::get('/padres/buscar',   [PadreController::class, 'buscar'])->name('padres.buscar');

        Route::resource('acciones-importantes', AccionesImportantesController::class)->names('acciones_importantes');
        Route::resource('ciclos',       CicloController::class);
        Route::resource('cupos_maximos',CupoMaximoController::class);
        Route::resource('documentos',   DocumentoController::class);
        Route::resource('materias',     MateriaController::class);
        Route::resource('observaciones',ObservacionController::class)->except(['show']);

        // Matrículas
        Route::prefix('matriculas')->name('matriculas.')->group(function () {
            Route::get('/',                    [MatriculaController::class, 'index'])->name('index');
            Route::get('/crear',               [MatriculaController::class, 'create'])->name('create');
            Route::post('/',                   [MatriculaController::class, 'store'])->name('store');
            Route::get('/{matricula}',         [MatriculaController::class, 'show'])->name('show');
            Route::get('/{matricula}/editar',  [MatriculaController::class, 'edit'])->name('edit');
            Route::put('/{matricula}',         [MatriculaController::class, 'update'])->name('update');
            Route::post('/{matricula}/confirmar',[MatriculaController::class,'confirmar'])->name('confirmar');
        });

        // Secciones — rutas fijas ANTES de las dinámicas
        Route::prefix('secciones')->name('secciones.')->group(function () {
            Route::get('/',         [SeccionController::class, 'index'])->name('index');
            Route::get('/create',   [SeccionController::class, 'create'])->name('create');
            Route::post('/',        [SeccionController::class, 'store'])->name('store');
            Route::post('/asignar', [SeccionController::class, 'asignar'])->name('asignar');
            Route::patch('/quitar', [SeccionController::class, 'quitar'])->name('quitar');
            Route::get('/{seccion}/editar', [SeccionController::class, 'edit'])->name('edit');
            Route::put('/{seccion}',        [SeccionController::class, 'update'])->name('update');
            Route::delete('/{seccion}',     [SeccionController::class, 'destroy'])->name('destroy');
        });

        // Grados — rutas específicas ANTES del resource
        Route::get('grados/crear-masivo',              [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo',           [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class);
        Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        // Horarios de grado — específicas antes de index
        Route::get('horarios_grado/{grado}/{jornada}/pdf',    [HorarioGradoController::class, 'exportarPdf'])->name('horarios_grado.pdf');
        Route::get('horarios_grado/{grado}/{jornada}/editar', [HorarioGradoController::class, 'edit'])->name('horarios_grado.edit');
        Route::put('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'update'])->name('horarios_grado.update');
        Route::get('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'show'])->name('horarios_grado.show');
        Route::get('horarios_grado',                          [HorarioGradoController::class, 'index'])->name('horarios_grado.index');

        // Asignación profesor-materia
        Route::get   ('profesor-materia',              [ProfesorMateriaController::class, 'index'])->name('profesor_materia.index');
        Route::get   ('profesor-materia/create',       [ProfesorMateriaController::class, 'create'])->name('profesor_materia.create');
        Route::post  ('profesor-materia',              [ProfesorMateriaController::class, 'store'])->name('profesor_materia.store');
        Route::get   ('profesor-materia/{id}/edit',    [ProfesorMateriaController::class, 'edit'])->name('profesor_materia.edit');
        Route::put   ('profesor-materia/{id}',         [ProfesorMateriaController::class, 'update'])->name('profesor_materia.update');
        Route::delete('profesor-materia/{id}',         [ProfesorMateriaController::class, 'destroy'])->name('profesor_materia.destroy');
        Route::delete('profesor-materia/asignacion/{id}',[ProfesorMateriaController::class,'destroyAsignacion'])->name('profesor_materia.destroyAsignacion');

        // Asignación profesor-grado
        Route::get   ('/profesor-grado',                    [ProfesorGradoAsignacionController::class, 'index'])->name('profesor_grado.index');
        Route::get   ('/profesor-grado/{id}/edit',          [ProfesorGradoAsignacionController::class, 'edit'])->name('profesor_grado.edit');
        Route::post  ('/profesor-grado/{id}',               [ProfesorGradoAsignacionController::class, 'store'])->name('profesor_grado.store');
        Route::delete('/profesor-grado/asignacion/{id}',    [ProfesorGradoAsignacionController::class, 'destroy'])->name('profesor_grado.destroy');

        // Consulta estudiantes por curso
        Route::get('/consultaestudiantesxcurso',                   [ConsultaestudiantexcursoController::class, 'index'])->name('consultaestudiantesxcurso.index');
        Route::get('/consultaestudiantesxcurso/{grado}/{seccion}', [ConsultaestudiantexcursoController::class, 'show'])->name('consultaestudiantesxcurso.show');

        // Cursos de secundaria (H2O)
        Route::resource('h20cursos', H20CursoController::class);

        // Calificaciones
        Route::get('registrar-calificaciones',                      [RegistrarCalificacionController::class, 'create'])->name('registrarcalificaciones.create');
        Route::post('registrar-calificaciones',                     [RegistrarCalificacionController::class, 'store'])->name('registrarcalificaciones.store');
        Route::get('calificaciones',                                [RegistrarCalificacionController::class, 'index'])->name('registrarcalificaciones.index');
        Route::get('registrar-calificaciones/estudiantes/{curso}',  [RegistrarCalificacionController::class, 'obtenerEstudiantes'])->name('registrarcalificaciones.estudiantes');
        Route::get('registrar-calificaciones/ver',                  [RegistrarCalificacionController::class, 'ver'])->name('registrarcalificaciones.ver');

        // Permisos de padres
        Route::get('/permisos',                              [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar',           [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar',             [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}',      [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');

        Route::get('/calendario_admin', fn () => view('calendario-admin'))->name('calendario.admin');

    }); // fin role:admin,superadmin

    /*
    |--------------------------------------------------------------------------
    | PANEL DE ADMINS (admins.)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/roles-permisos',         [SuperAdminController::class, 'permisosRoles'])->name('roles-permisos');
        Route::put('/roles-permisos/guardar', [SuperAdminController::class, 'actualizarPermisos'])->name('asignar-permisos');
        Route::get('/dashboard',              [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/crear',                  [AdminController::class, 'create'])->name('create');
        Route::post('/',                      [AdminController::class, 'store'])->name('store');
        Route::get('/',                       [AdminController::class, 'index'])->name('index');
        Route::get('/{admin}',                [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar',         [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}',                [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}',             [AdminController::class, 'destroy'])->name('destroy');
    });

    /*
    |==========================================================================
    | SUPER ADMINISTRADOR
    |==========================================================================
    */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {

        Route::get('/dashboard', fn () => view('superadmin.dashboard'))->name('dashboard');

        // Perfil
        Route::get('/perfil',          [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil',          [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        // Periodos académicos
        Route::resource('periodos-academicos', PeriodoAcademicoController::class)->names('periodos-academicos');

        // Administradores — rutas fijas ANTES de {administrador}
        Route::get('/administradores/permisos',           [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos');
        Route::get('/administradores/permisos-roles',     [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos-roles');
        Route::put('/administradores/permisos/guardar',   [SuperAdminController::class, 'actualizarPermisos'])->name('administradores.permisos.update');
        Route::get('/administradores/crear',              [SuperAdminController::class, 'create'])->name('administradores.create');
        Route::post('/administradores',                   [SuperAdminController::class, 'store'])->name('administradores.store');
        Route::get('/administradores',                    [SuperAdminController::class, 'index'])->name('administradores.index');
        // Dinámicas SIEMPRE al final
        Route::get('/administradores/{administrador}',        [SuperAdminController::class, 'show'])->name('administradores.show');
        Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
        Route::put('/administradores/{administrador}',        [SuperAdminController::class, 'update'])->name('administradores.update');
        Route::delete('/administradores/{administrador}',     [SuperAdminController::class, 'destroy'])->name('administradores.destroy');

        // Usuarios
        Route::get('usuarios/pendientes',       [UsuarioController::class, 'pendientes'])->name('usuarios.pendientes');
        Route::post('usuarios/{id}/aprobar',    [UsuarioController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::delete('usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])->name('usuarios.rechazar');
        Route::put('usuarios/{id}/activar',     [UsuarioController::class, 'activar'])->name('usuarios.activar');
        Route::put('usuarios/{id}/desactivar',  [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');
        Route::resource('usuarios', UsuarioController::class);

        // Grados (superadmin) — específicas ANTES del resource
        Route::get('grados/crear-masivo',              [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo',           [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class);
        Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        // Materias (superadmin)
        Route::resource('materias', MateriaController::class);

        // Horarios de grado (superadmin)
        Route::get('horarios_grado/{grado}/{jornada}/pdf',    [HorarioGradoController::class, 'exportarPdf'])->name('horarios_grado.pdf');
        Route::get('horarios_grado/{grado}/{jornada}/editar', [HorarioGradoController::class, 'edit'])->name('horarios_grado.edit');
        Route::put('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'update'])->name('horarios_grado.update');
        Route::get('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'show'])->name('horarios_grado.show');
        Route::get('horarios_grado',                          [HorarioGradoController::class, 'index'])->name('horarios_grado.index');

        Route::resource('documentos', DocumentoController::class);

    }); // fin superadmin

    /*
    |--------------------------------------------------------------------------
    | ADMINISTRADOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('/',                [SolicitudController::class, 'index'])->name('index');
            Route::get('/{id}',            [SolicitudController::class, 'show'])->name('show');
            Route::post('/{id}/aprobar',   [SolicitudController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar',  [SolicitudController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/pendiente', [SolicitudController::class, 'pendiente'])->name('pendiente');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PROFESOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->group(function () {
        Route::get('/dashboard', fn () => view('profesor.dashboard.index'))->name('dashboard');

        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
        Route::get('/mi-horario',          [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones',      [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
        Route::get('/mis-cursos',                        [ProfesorGradosController::class,    'index'])->name('mis-cursos');
        Route::get('/mis-estudiantes/{grado}/{seccion}', [ProfesorEstudianteController::class, 'index'])->name('mis-estudiantes');

        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('/',                [SolicitudAdminController::class, 'index'])->name('index');
            Route::get('/{id}',            [SolicitudAdminController::class, 'show'])->name('show');
            Route::post('/{id}/aprobar',   [SolicitudAdminController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar',  [SolicitudAdminController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/pendiente', [SolicitudAdminController::class, 'pendiente'])->name('pendiente');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | ESTUDIANTE
    |--------------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/dashboard',      fn () => view('estudiante.dashboard.index'))->name('dashboard');
        Route::get('/mi-horario',     [HorarioController::class,                 'miHorario'])->name('miHorario');
        Route::get('/calificaciones', [EstudianteController::class,              'misNotas'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
    });

    /*
    |--------------------------------------------------------------------------
    | PADRE / TUTOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('padre')->name('padre.')->middleware('es.padre')->group(function () {
        Route::get('/dashboard',           [PadreDashboardController::class, 'index'])->name('dashboard');
        Route::get('/hijo/{estudianteId}', [PadreDashboardController::class, 'verHijo'])->name('hijo');
        Route::put('/password',            [PadreDashboardController::class, 'cambiarPassword'])->name('cambiarPassword');
    });

}); // fin middleware auth