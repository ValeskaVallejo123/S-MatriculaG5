<?php

/*
|=============================================================================
| IMPORTACIONES DE CONTROLLERS
|=============================================================================
*/
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ProfesorEstudianteController;
use App\Http\Controllers\ProfesorGradosController;
use App\Http\Controllers\CargaDocenteController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\PadrePermisoController;
use App\Http\Controllers\PadreController;
use App\Http\Controllers\PadreDashboardController;
use App\Http\Controllers\ProfesorMateriaController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\HorarioGradoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NotificacionPreferenciaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\AccionesImportantesController;
use App\Http\Controllers\SuperAdmin\UsuarioController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\Admin\SolicitudAdminController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\CupoMaximoController;
use App\Http\Controllers\PublicoPlanEstudiosController;
use App\Http\Controllers\RegistrarCalificacionController;
use App\Http\Controllers\MisCalificacionesController;
use App\Http\Controllers\ConsultaestudiantexcursoController;
use App\Http\Controllers\H20CursoController;
use App\Http\Controllers\ProfesorDashboardController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
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

Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

Route::get('/calendario-publico',        fn () => view('calendario-publico'))->name('calendario.publico');
Route::get('/calendario/eventos/public', [CalendarioController::class, 'eventosPublicos'])->name('calendario.eventos.public');

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS DE MATRÍCULA
| ⚠️  FUERA del grupo auth — el público no tiene sesión iniciada.
|
| El formulario create-public.blade.php apunta a route('matriculas.store').
| El store() detecta que es pública gracias al campo hidden publico=1
| y ejecuta la rama correspondiente (estado=pendiente, sin sección, etc.)
|--------------------------------------------------------------------------
*/
Route::get('/matricula-publica',  [MatriculaController::class, 'createPublico'])->name('matriculas.public.create');
Route::post('/matricula-publica', [MatriculaController::class, 'store'])->name('matriculas.store');
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
|=============================================================================
| PORTAL PÚBLICO
|=============================================================================
*/
Route::prefix('portal')->name('portal.')->group(function () {
    Route::view('/',          'portal.inicio')->name('inicio');
    Route::view('/acerca-de', 'portal.acerca-de')->name('acerca-de');
    Route::view('/contacto',  'portal.contacto')->name('contacto');

    Route::get('/horarios-publicos',   [HorarioController::class,  'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');

    Route::get('/plan-estudios',         [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');
    Route::get('/plan-estudios/{grado}', [PublicoPlanEstudiosController::class, 'show'])->name('plan-estudios.show');

    // ⚠️  ELIMINADAS las 3 rutas de matrícula que estaban aquí duplicadas.
    //     Ya están definidas arriba (fuera del portal) con los nombres correctos.
    //     Si algún link usa route('portal.matriculas.public.create'), cámbialo
    //     a route('matriculas.public.create').
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $roleRouteMap = [
            'super_admin' => 'superadmin.dashboard',
            'admin'       => 'admin.dashboard',
            'profesor'    => 'profesor.dashboard',
            'estudiante'  => 'estudiante.dashboard',
            'padre'       => 'padre.dashboard',
            'user'        => 'admin.dashboard',
        ];
        return redirect()->route($roleRouteMap[$user->user_type] ?? 'inicio');
    })->name('dashboard');

    /*
    |-------------------------------------------------------------------------
    | CAMBIAR CONTRASEÑA — Disponible para todos los roles
    |-------------------------------------------------------------------------
    */
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    /*
    |-------------------------------------------------------------------------
    | CALENDARIO
    |-------------------------------------------------------------------------
    */
    Route::get('/calendario',                     [CalendarioController::class, 'index'])->name('calendario');
    Route::get('/calendario/eventos',             [CalendarioController::class, 'obtenerEventos']);
    Route::post('/calendario/eventos',            [CalendarioController::class, 'store']);
    Route::put('/calendario/eventos/{id}',        [CalendarioController::class, 'actualizar']);
    Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar']);

    /*
    |-------------------------------------------------------------------------
    | NOTIFICACIONES
    |-------------------------------------------------------------------------
    */
    Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
        Route::get('/',                      [NotificacionController::class,            'index'])->name('index');
        Route::patch('/{notificacion}/leer', [NotificacionController::class,            'marcarLeida'])->name('marcarLeida');
        Route::get('/preferencias',          [NotificacionPreferenciaController::class, 'edit'])->name('preferencias');
        Route::put('/preferencias',          [NotificacionPreferenciaController::class, 'update'])->name('preferencias.update');
    });

    Route::resource('acciones-importantes', AccionesImportantesController::class)
        ->names('acciones_importantes');

    /*
    |-------------------------------------------------------------------------
    | OBSERVACIONES
    |-------------------------------------------------------------------------
    */
    Route::resource('observaciones', ObservacionController::class)
        ->except(['show'])
        ->parameters(['observaciones' => 'observacion']);

    /*
    |-------------------------------------------------------------------------
    | ESTUDIANTES
    |-------------------------------------------------------------------------
    */
    Route::get('/buscarregistro',     [BuscarEstudianteController::class, 'buscarregistro'])->name('buscarregistro');
    Route::get('/estudiantes/buscar', [EstudianteController::class,       'buscar'])->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);

    /*
    |-------------------------------------------------------------------------
    | PROFESORES
    |-------------------------------------------------------------------------
    */
    Route::resource('profesores', ProfesorController::class)
        ->parameters(['profesores' => 'profesor']);

    /*
    |-------------------------------------------------------------------------
    | CARGA DOCENTE
    |-------------------------------------------------------------------------
    */
    Route::get('carga-docente', [CargaDocenteController::class, 'index'])->name('carga-docente.index');

    /*
    |-------------------------------------------------------------------------
    | PADRES / TUTORES
    |-------------------------------------------------------------------------
    */
    Route::get('/padres/buscar',            [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular',      [PadreController::class, 'desvincular'])->name('padres.desvincular');
    Route::resource('padres', PadreController::class);

    /*
    |-------------------------------------------------------------------------
    | MATRÍCULAS (panel admin)
    | ⚠️  El POST store ya NO está aquí — está fuera del auth (arriba).
    |     Eso permite que el público envíe el formulario sin login.
    |     El store() funciona igual para admin y público gracias al flag publico.
    |-------------------------------------------------------------------------
    */
    Route::prefix('matriculas')->name('matriculas.')->group(function () {
        Route::get('/',                       [MatriculaController::class, 'index'])->name('index');
        Route::get('/crear',                  [MatriculaController::class, 'create'])->name('create');
        // POST store eliminado de aquí — está fuera del grupo auth con nombre 'matriculas.store'
        Route::get('/{matricula}',            [MatriculaController::class, 'show'])->name('show');
        Route::get('/{matricula}/editar',     [MatriculaController::class, 'edit'])->name('edit');
        Route::put('/{matricula}',            [MatriculaController::class, 'update'])->name('update');
        Route::delete('/{matricula}',         [MatriculaController::class, 'destroy'])->name('destroy');
        Route::get('/{matricula}/detalles',   [MatriculaController::class, 'detalles'])->name('detalles');
        Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
        Route::post('/{matricula}/rechazar',  [MatriculaController::class, 'rechazar'])->name('rechazar');
        Route::post('/{matricula}/cancelar',  [MatriculaController::class, 'cancelar'])->name('cancelar');
        Route::post('/{matricula}/pdf',       [MatriculaController::class, 'exportarPdf'])->name('pdf');
        Route::patch('/{matricula}/aprobar',  [MatriculaController::class, 'aprobar'])->name('aprobar');
    });

    /*
    |-------------------------------------------------------------------------
    | PERIODOS ACADÉMICOS
    |-------------------------------------------------------------------------
    */
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    /*
    |-------------------------------------------------------------------------
    | CICLOS ESCOLARES
    |-------------------------------------------------------------------------
    */
    Route::resource('ciclos', CicloController::class);

    /*
    |-------------------------------------------------------------------------
    | SECCIONES
    |-------------------------------------------------------------------------
    */
    Route::post('secciones/asignar', [SeccionController::class, 'asignar'])->name('secciones.asignar');
    Route::resource('seccion', SeccionController::class)->names([
        'index'   => 'secciones.index',
        'create'  => 'secciones.create',
        'store'   => 'secciones.store',
        'edit'    => 'secciones.edit',
        'update'  => 'secciones.update',
        'destroy' => 'secciones.destroy',
    ]);

    /*
    |-------------------------------------------------------------------------
    | CUPOS MÁXIMOS
    |-------------------------------------------------------------------------
    */
    Route::resource('cupos_maximos', CupoMaximoController::class);

    /*
    |-------------------------------------------------------------------------
    | DOCUMENTOS
    |-------------------------------------------------------------------------
    */
    Route::resource('documentos', DocumentoController::class);

    /*
    |-------------------------------------------------------------------------
    | MATERIAS
    |-------------------------------------------------------------------------
    */
    Route::resource('materias', MateriaController::class);

    /*
    |-------------------------------------------------------------------------
    | GRADOS
    |-------------------------------------------------------------------------
    */
    Route::get('grados/crear-masivo',              [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
    Route::post('grados/generar-masivo',           [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
    Route::resource('grados', GradoController::class);
    Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
    Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

    /*
    |-------------------------------------------------------------------------
    | ASIGNACIÓN PROFESOR-MATERIA
    |-------------------------------------------------------------------------
    */
    Route::prefix('profesor-materia')->name('profesor_materia_grado.')->group(function () {
    Route::get('/',                                [ProfesorMateriaController::class, 'index'])->name('index');
    Route::get('/create',                          [ProfesorMateriaController::class, 'create'])->name('create');
    Route::post('/',                               [ProfesorMateriaController::class, 'store'])->name('store');
    Route::get('/{profesor_materia_grado}/edit',   [ProfesorMateriaController::class, 'edit'])->name('edit');
    Route::put('/{profesor_materia_grado}',        [ProfesorMateriaController::class, 'update'])->name('update');
    Route::delete('/{profesor_materia_grado}',     [ProfesorMateriaController::class, 'destroy'])->name('destroy');
});

    /*
    |-------------------------------------------------------------------------
    | HORARIOS DE GRADO
    |-------------------------------------------------------------------------
    */
    Route::get('horarios_grado/{grado}/{jornada}/pdf',    [HorarioGradoController::class, 'exportarPdf'])->name('horarios_grado.pdf');
    Route::get('horarios_grado/{grado}/{jornada}/editar', [HorarioGradoController::class, 'edit'])->name('horarios_grado.edit');
    Route::put('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'update'])->name('horarios_grado.update');
    Route::get('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'show'])->name('horarios_grado.show');
    Route::get('horarios_grado',                          [HorarioGradoController::class, 'index'])->name('horarios_grado.index');

    /*
    |-------------------------------------------------------------------------
    | CONSULTA DE ESTUDIANTES POR CURSO Y SECCIÓN
    |-------------------------------------------------------------------------
    */
    Route::get('/consultaestudiantesxcurso',                    [ConsultaestudiantexcursoController::class, 'index'])->name('consultaestudiantesxcurso.index');
Route::get('/consultaestudiantesxcurso/{grado}/{seccion}',  [ConsultaestudiantexcursoController::class, 'show'])->name('consultaestudiantesxcurso.show');

    /*
    |-------------------------------------------------------------------------
    | CURSOS DE SECUNDARIA (H2O)
    |-------------------------------------------------------------------------
    */
    Route::resource('h20cursos', H20CursoController::class);

    /*
    |-------------------------------------------------------------------------
    | CALIFICACIONES
    |-------------------------------------------------------------------------
    */
    Route::get('registrar-calificaciones',                     [RegistrarCalificacionController::class, 'create'])->name('registrarcalificaciones.create');
    Route::post('registrar-calificaciones',                    [RegistrarCalificacionController::class, 'store'])->name('registrarcalificaciones.store');
    Route::get('calificaciones',                               [RegistrarCalificacionController::class, 'index'])->name('registrarcalificaciones.index');
    Route::get('registrar-calificaciones/estudiantes/{curso}', [RegistrarCalificacionController::class, 'obtenerEstudiantes'])->name('registrarcalificaciones.estudiantes');
    Route::get('registrar-calificaciones/ver',                 [RegistrarCalificacionController::class, 'ver'])->name('registrarcalificaciones.ver');
    Route::get('registrar-calificaciones/notas-existentes',   [RegistrarCalificacionController::class, 'notasExistentes'])->name('registrarcalificaciones.notas-existentes');

    /*
    |-------------------------------------------------------------------------
    | PANEL GENERAL DE ADMINISTRADORES
    |-------------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admins.')->group(function () {

        Route::get('/roles-permisos',         [SuperAdminController::class, 'permisosRoles'])->name('roles-permisos');
        Route::put('/roles-permisos/guardar', [SuperAdminController::class, 'actualizarPermisos'])->name('asignar-permisos');

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/permisos',                              [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar',           [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar',             [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}',      [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');

        Route::get('/crear',          [AdminController::class, 'create'])->name('create');
        Route::post('/',              [AdminController::class, 'store'])->name('store');
        Route::get('/',               [AdminController::class, 'index'])->name('index');
        Route::get('/{admin}',        [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}',        [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}',     [AdminController::class, 'destroy'])->name('destroy');
    });

    /*
    |=========================================================================
    | SUPERADMIN
    |=========================================================================
    */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:super_admin')->group(function () {

        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/perfil',          [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil',          [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        Route::get('/cambiarcontrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiarcontrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        Route::get('/administradores/permisos',         [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos');
        Route::get('/administradores/permisos-roles',   [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos-roles');
        Route::put('/administradores/permisos/guardar', [SuperAdminController::class, 'actualizarPermisos'])->name('administradores.permisos.update');
        Route::get('/administradores/crear',            [SuperAdminController::class, 'create'])->name('administradores.create');
        Route::post('/administradores',                 [SuperAdminController::class, 'store'])->name('administradores.store');
        Route::get('/administradores',                  [SuperAdminController::class, 'index'])->name('administradores.index');
        Route::get('/administradores/{administrador}',        [SuperAdminController::class, 'show'])->name('administradores.show');
        Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
        Route::put('/administradores/{administrador}',        [SuperAdminController::class, 'update'])->name('administradores.update');
        Route::delete('/administradores/{administrador}',     [SuperAdminController::class, 'destroy'])->name('administradores.destroy');

        Route::get('usuarios/pendientes',       [UsuarioController::class, 'pendientes'])->name('usuarios.pendientes');
        Route::post('usuarios/{id}/aprobar',    [UsuarioController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::delete('usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])->name('usuarios.rechazar');
        Route::put('usuarios/{id}/activar',     [UsuarioController::class, 'activar'])->name('usuarios.activar');
        Route::put('usuarios/{id}/desactivar',  [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');
        Route::resource('usuarios', UsuarioController::class);

        Route::get('grados/crear-masivo',    [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class);
        Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        Route::resource('materias', MateriaController::class)->names([
            'index'   => 'materias.index',
            'create'  => 'materias.create',
            'store'   => 'materias.store',
            'show'    => 'materias.show',
            'edit'    => 'materias.edit',
            'update'  => 'materias.update',
            'destroy' => 'materias.destroy',
        ]);

        Route::get('horarios_grado/{grado}/{jornada}/pdf',    [HorarioGradoController::class, 'exportarPdf'])->name('horarios_grado.pdf');
        Route::get('horarios_grado/{grado}/{jornada}/editar', [HorarioGradoController::class, 'edit'])->name('horarios_grado.edit');
        Route::put('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'update'])->name('horarios_grado.update');
        Route::get('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'show'])->name('horarios_grado.show');
        Route::get('horarios_grado',                          [HorarioGradoController::class, 'index'])->name('horarios_grado.index');

        Route::resource('cupos_maximos', CupoMaximoController::class)->names([
            'index'   => 'cupos_maximos.index',
            'create'  => 'cupos_maximos.create',
            'store'   => 'cupos_maximos.store',
            'show'    => 'cupos_maximos.show',
            'edit'    => 'cupos_maximos.edit',
            'update'  => 'cupos_maximos.update',
            'destroy' => 'cupos_maximos.destroy',
        ]);

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

        Route::get('/permisos',                              [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar',           [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar',             [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}',      [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');

    }); // fin admin

    /*
    |----------------------------------------------------------------------
    | PROFESOR
    |----------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->group(function () {
        Route::get('/dashboard', [ProfesorDashboardController::class, 'index'])->name('dashboard');

        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
        Route::get('/mi-horario',          [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones',      [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');

        Route::get('/mis-cursos',                            [ProfesorGradosController::class,    'index'])->name('mis-cursos');
        Route::get('/mis-estudiantes/{grado}/{seccion}',     [ProfesorEstudianteController::class, 'index'])->name('mis-estudiantes');

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

        Route::get('/mi-horario',     [HorarioController::class,                 'miHorario'])->name('miHorario');
        Route::get('/calificaciones', [MisCalificacionesController::class,       'index'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
    });

    /*
    |----------------------------------------------------------------------
    | PADRE / TUTOR
    |----------------------------------------------------------------------
    */
    Route::prefix('padre')->name('padre.')->middleware('role:padre')->group(function () {
        Route::get('/dashboard',           [PadreDashboardController::class, 'index'])->name('dashboard');
        Route::get('/hijo/{estudianteId}', [PadreDashboardController::class, 'verHijo'])->name('hijo');
        // Dos nombres para la misma ruta: 'cambiarPassword' (original) y 'cambiar-password' (usado en el blade)
        Route::put('/password',            [PadreDashboardController::class, 'cambiarPassword'])->name('cambiarPassword');
        Route::put('/cambiar-password',    [PadreDashboardController::class, 'cambiarPassword'])->name('cambiar-password');
    });

    /*
    |----------------------------------------------------------------------
    | RUTAS COMPARTIDAS (admin y superadmin)
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/carga-docente', [CargaDocenteController::class, 'index'])->name('carga-docente.index');
    });

}); // fin middleware auth
