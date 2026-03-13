<?php

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
use App\Http\Controllers\ProfesorDashboardController;
use App\Http\Controllers\CargaDocenteController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\PadrePermisoController;
use App\Http\Controllers\PadreController;
use App\Http\Controllers\ProfesorMateriaController;
use App\Http\Controllers\ProfesorGradosController;
use App\Http\Controllers\ProfesorEstudianteController;
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
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\ProfesorMateriaGradoController;

/*
|--------------------------------------------------------------------------
| RUTA RAÍZ
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS GENERALES
|--------------------------------------------------------------------------
*/
Route::get('/inicio',    fn () => view('plantilla'))->name('inicio');
Route::get('/plantilla', fn () => view('plantilla'))->name('plantilla');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

Route::get('/calendario-publico', fn () => view('calendario-publico'))->name('calendario.publico');
Route::get('/calendario/eventos/public', [CalendarioController::class, 'eventosPublicos'])->name('calendario.eventos.public');

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

    Route::get('/plan-estudios',         [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');
    Route::get('/plan-estudios/{grado}', [PublicoPlanEstudiosController::class, 'show'])->name('plan-estudios.show');

    Route::get('/matricula-publica',  [MatriculaController::class, 'create'])->name('matriculas.public.create');
    Route::post('/matricula-publica', [MatriculaController::class, 'store'])->name('matriculas.public.store');
    Route::get('/matricula-exitosa',  [MatriculaController::class, 'success'])->name('matriculas.success');
});

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
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login',   [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',  [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA
|--------------------------------------------------------------------------
*/
Route::get('/password/solicitar',           [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar',          [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer',        [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (requieren autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | DASHBOARD — redirección por rol
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $roleRouteMap = [
            'super_admin' => 'superadmin.dashboard',
            'admin'       => 'admin.dashboard',
            'profesor'    => 'profesor.dashboard',
            'estudiante'  => 'estudiante.dashboard',
            'padre'       => 'padre.dashboard',
            'user'        => 'admin.dashboard',
        ];
        return redirect()->route($roleRouteMap[Auth::user()->user_type] ?? 'inicio');
    })->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | CAMBIAR CONTRASEÑA
    |----------------------------------------------------------------------
    */
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    /*
    |----------------------------------------------------------------------
    | CALENDARIO
    |----------------------------------------------------------------------
    */
    Route::get('/calendario',                     [CalendarioController::class, 'index'])->name('calendario');
    Route::get('/calendario/eventos',             [CalendarioController::class, 'obtenerEventos']);
    Route::post('/calendario/eventos',            [CalendarioController::class, 'store']);
    Route::put('/calendario/eventos/{id}',        [CalendarioController::class, 'actualizar']);
    Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar']);

    /*
    |----------------------------------------------------------------------
    | NOTIFICACIONES
    |----------------------------------------------------------------------
    */
    Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
        Route::get('/',                      [NotificacionController::class,            'index'])->name('index');
        Route::patch('/{notificacion}/leer', [NotificacionController::class,            'marcarLeida'])->name('marcarLeida');
        Route::get('/preferencias',          [NotificacionPreferenciaController::class, 'edit'])->name('preferencias');
        Route::put('/preferencias',          [NotificacionPreferenciaController::class, 'update'])->name('preferencias.update');
    });

    /*
    |----------------------------------------------------------------------
    | ACCIONES IMPORTANTES
    |----------------------------------------------------------------------
    */
    Route::resource('acciones-importantes', AccionesImportantesController::class)
        ->names('acciones_importantes');

    /*
    |----------------------------------------------------------------------
    | ESTUDIANTES
    |----------------------------------------------------------------------
    */
    Route::get('/buscarregistro', [BuscarEstudianteController::class, 'buscarregistro'])->name('buscarregistro');
    Route::resource('estudiantes', EstudianteController::class);

    /*
    |----------------------------------------------------------------------
    | PROFESORES
    |----------------------------------------------------------------------
    */
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

    /*
    |----------------------------------------------------------------------
    | CARGA DOCENTE
    |----------------------------------------------------------------------
    */
    Route::get('carga-docente', [CargaDocenteController::class, 'index'])->name('carga-docente.index');

    /*
    |----------------------------------------------------------------------
    | PADRES / TUTORES
    |----------------------------------------------------------------------
    */
    Route::get('/padres/buscar',            [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular',      [PadreController::class, 'desvincular'])->name('padres.desvincular');
    Route::resource('padres', PadreController::class);

    /*
    |----------------------------------------------------------------------
    | MATRÍCULAS
    |----------------------------------------------------------------------
    */
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
        Route::post('/{matricula}/pdf',       [MatriculaController::class, 'exportarPdf'])->name('pdf');
        Route::patch('/{matricula}/aprobar',  [MatriculaController::class, 'aprobar'])->name('aprobar');
    });

    /*
    |----------------------------------------------------------------------
    | PERIODOS ACADÉMICOS
    |----------------------------------------------------------------------
    */
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    /*
    |----------------------------------------------------------------------
    | CICLOS
    |----------------------------------------------------------------------
    */
    Route::resource('ciclos', CicloController::class);

    /*
    |----------------------------------------------------------------------
    | SECCIONES
    |----------------------------------------------------------------------
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
    |----------------------------------------------------------------------
    | OBSERVACIONES  ← parámetro explícito para evitar 'observacione'
    |----------------------------------------------------------------------
    */
    Route::resource('observaciones', ObservacionController::class)
        ->except(['show'])
        ->parameters(['observaciones' => 'observacion']);

    /*
    |----------------------------------------------------------------------
    | DOCUMENTOS
    |----------------------------------------------------------------------
    */
    Route::resource('documentos', DocumentoController::class);

    /*
    |----------------------------------------------------------------------
    | MATERIAS
    |----------------------------------------------------------------------
    */
    Route::resource('materias', MateriaController::class);

    /*
    |----------------------------------------------------------------------
    | GRADOS
    |----------------------------------------------------------------------
    */
    Route::get('grados/crear-masivo',    [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
    Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
    Route::resource('grados', GradoController::class);
    Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
    Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

    /*
    |----------------------------------------------------------------------
    | ASIGNACIÓN PROFESOR-MATERIA (solo materias, sin grado/sección)
    |----------------------------------------------------------------------
    */
    Route::resource('profesor_materia', ProfesorMateriaController::class);

    /*
    |----------------------------------------------------------------------
    | ASIGNACIÓN PROFESOR-MATERIA-GRADO (completa, para calificaciones)
    |----------------------------------------------------------------------
    */
    Route::resource('profesor_materia_grado', ProfesorMateriaGradoController::class);

    /*
    |----------------------------------------------------------------------
    | CALIFICACIONES — superadmin (CRUD completo)
    |----------------------------------------------------------------------
    */
    Route::resource('calificaciones', CalificacionController::class)
        ->except(['index', 'create', 'store'])
        ->middleware('role:super_admin');

    Route::prefix('calificaciones')->name('calificaciones.')->middleware('role:super_admin')->group(function () {
        Route::get('/',      [CalificacionController::class, 'indexAdmin'])->name('index');
        Route::get('/crear', [CalificacionController::class, 'createAdmin'])->name('create');
        Route::post('/',     [CalificacionController::class, 'storeAdmin'])->name('store');
    });

    /*
    |----------------------------------------------------------------------
    | HORARIOS DE GRADO
    |----------------------------------------------------------------------
    */
    Route::get('horarios_grado/{grado}/{jornada}/pdf',    [HorarioGradoController::class, 'exportarPdf'])->name('horarios_grado.pdf');
    Route::get('horarios_grado/{grado}/{jornada}/editar', [HorarioGradoController::class, 'edit'])->name('horarios_grado.edit');
    Route::put('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'update'])->name('horarios_grado.update');
    Route::get('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'show'])->name('horarios_grado.show');
    Route::get('horarios_grado',                          [HorarioGradoController::class, 'index'])->name('horarios_grado.index');

    /*
    |----------------------------------------------------------------------
    | PANEL DE ADMINISTRADORES
    |----------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admins.')->group(function () {

        Route::get('/roles-permisos',         [SuperAdminController::class, 'permisosRoles'])->name('roles-permisos');
        Route::put('/roles-permisos/guardar', [SuperAdminController::class, 'actualizarPermisos'])->name('asignar-permisos');

        Route::get('/permisos',                              [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar',           [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar',             [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}',      [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');

        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::post('/',     [AdminController::class, 'store'])->name('store');
        Route::get('/',      [AdminController::class, 'index'])->name('index');

        Route::get('/{admin}',        [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}',        [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}',     [AdminController::class, 'destroy'])->name('destroy');
    });

    /*
    |----------------------------------------------------------------------
    | SUPER ADMINISTRADOR
    |----------------------------------------------------------------------
    */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:super_admin')->group(function () {

        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/perfil',    [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil',    [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        // Administradores
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

        // Usuarios
        Route::get('usuarios/pendientes',       [UsuarioController::class, 'pendientes'])->name('usuarios.pendientes');
        Route::post('usuarios/{id}/aprobar',    [UsuarioController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::delete('usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])->name('usuarios.rechazar');
        Route::put('usuarios/{id}/activar',     [UsuarioController::class, 'activar'])->name('usuarios.activar');
        Route::put('usuarios/{id}/desactivar',  [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');
        Route::resource('usuarios', UsuarioController::class)->names([
            'index'   => 'usuarios.index',
            'create'  => 'usuarios.create',
            'store'   => 'usuarios.store',
            'show'    => 'usuarios.show',
            'edit'    => 'usuarios.edit',
            'update'  => 'usuarios.update',
            'destroy' => 'usuarios.destroy',
        ]);

        // Grados
        Route::get('grados/crear-masivo',    [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class)->names([
            'index'   => 'grados.index',
            'create'  => 'grados.create',
            'store'   => 'grados.store',
            'show'    => 'grados.show',
            'edit'    => 'grados.edit',
            'update'  => 'grados.update',
            'destroy' => 'grados.destroy',
        ]);
        Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        // Materias
        Route::resource('materias', MateriaController::class)->names([
            'index'   => 'materias.index',
            'create'  => 'materias.create',
            'store'   => 'materias.store',
            'show'    => 'materias.show',
            'edit'    => 'materias.edit',
            'update'  => 'materias.update',
            'destroy' => 'materias.destroy',
        ]);

        // Horarios de Grado (superadmin)
        Route::get('horarios_grado/{grado}/{jornada}/pdf',    [HorarioGradoController::class, 'exportarPdf'])->name('horarios_grado.pdf');
        Route::get('horarios_grado/{grado}/{jornada}/editar', [HorarioGradoController::class, 'edit'])->name('horarios_grado.edit');
        Route::put('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'update'])->name('horarios_grado.update');
        Route::get('horarios_grado/{grado}/{jornada}',        [HorarioGradoController::class, 'show'])->name('horarios_grado.show');
        Route::get('horarios_grado',                          [HorarioGradoController::class, 'index'])->name('horarios_grado.index');

        // Profesor-Materia (solo materias)
        Route::prefix('profesor-materia')->name('profesor_materia.')->group(function () {
            Route::get('/',                [ProfesorMateriaController::class, 'index'])->name('index');
            Route::get('/create',          [ProfesorMateriaController::class, 'create'])->name('create');
            Route::post('/',               [ProfesorMateriaController::class, 'store'])->name('store');
            Route::get('/{profesor}/edit', [ProfesorMateriaController::class, 'edit'])->name('edit');
            Route::put('/{profesor}',      [ProfesorMateriaController::class, 'update'])->name('update');
            Route::delete('/{profesor}',   [ProfesorMateriaController::class, 'destroy'])->name('destroy');
        });

        // Cupos Máximos
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
    | ADMINISTRADOR (ROL)
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('/',                [SolicitudAdminController::class, 'index'])->name('index');
            Route::get('/{id}',            [SolicitudAdminController::class, 'show'])->name('show');
            Route::post('/{id}/aprobar',   [SolicitudAdminController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar',  [SolicitudAdminController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/pendiente', [SolicitudAdminController::class, 'pendiente'])->name('pendiente');
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
    | PROFESOR (ROL)
    |----------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->middleware('role:profesor')->group(function () {

        Route::get('/dashboard',      [ProfesorDashboardController::class,       'index'])->name('dashboard');
        Route::get('/mi-horario',     [HorarioController::class,                 'miHorario'])->name('miHorario');
        Route::get('/mis-cursos',     [ProfesorGradosController::class,          'index'])->name('mis-cursos');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
        Route::get('/mis-estudiantes/{grado}/{seccion}', [ProfesorEstudianteController::class, 'index'])->name('mis-estudiantes');

        Route::prefix('calificaciones')->name('calificaciones.')->group(function () {
            Route::get('/', [CalificacionController::class, 'index'])->name('index');
            Route::get('/{gradoId}/{seccion}/{materiaId}', [CalificacionController::class, 'listar'])->name('listar');
            Route::post('/{gradoId}/{seccion}/{materiaId}/guardar', [CalificacionController::class, 'guardarMasivo'])->name('guardar');
            Route::get('/{calificacion}/editar', [CalificacionController::class, 'edit'])->name('edit');
            Route::put('/{calificacion}',        [CalificacionController::class, 'update'])->name('update');
            Route::delete('/{calificacion}',     [CalificacionController::class, 'destroy'])->name('destroy');
        });

    }); // fin profesor

    /*
    |----------------------------------------------------------------------
    | ESTUDIANTE (ROL)
    |----------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->middleware('role:estudiante')->group(function () {
        Route::get('/dashboard',      fn () => view('estudiante.dashboard.index'))->name('dashboard');
        Route::get('/mi-horario',     [HorarioController::class,                 'miHorario'])->name('miHorario');
        Route::get('/calificaciones', [EstudianteController::class,              'misNotas'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
    });

    /*
    |----------------------------------------------------------------------
    | PADRE (ROL)
    |----------------------------------------------------------------------
    */
    Route::prefix('padre')->name('padre.')->middleware('role:padre')->group(function () {
        Route::get('/dashboard', fn () => view('padre.dashboard.index'))->name('dashboard');
    });

}); // fin middleware auth
