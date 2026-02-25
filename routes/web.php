<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\AccionesImportantesController;
use App\Http\Controllers\SuperAdmin\UsuarioController;

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

Route::get('/inicio',    fn () => view('plantilla'))->name('inicio');
Route::get('/plantilla', fn () => view('plantilla'))->name('plantilla');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

/*
|--------------------------------------------------------------------------
| MATRÍCULA PÚBLICA
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
| RUTAS PRIVADAS (REQUIEREN AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | NOTIFICACIONES (todos los roles)
    |----------------------------------------------------------------------
    */
    Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
        Route::get('/',                       [NotificacionController::class,           'index'])->name('index');
        Route::patch('/{notificacion}/leer',  [NotificacionController::class,           'marcarLeida'])->name('marcarLeida');
        Route::get('/preferencias',           [NotificacionPreferenciaController::class,'edit'])->name('preferencias');
        Route::put('/preferencias',           [NotificacionPreferenciaController::class,'update'])->name('preferencias.update');
    });

    /*
    |----------------------------------------------------------------------
    | ACCIONES IMPORTANTES (todos los roles)
    |----------------------------------------------------------------------
    */
    Route::resource('acciones-importantes', AccionesImportantesController::class)
        ->names('acciones_importantes');

    /*
    |----------------------------------------------------------------------
    | OBSERVACIONES
    | CORRECCIÓN CRÍTICA: estaban dentro del grupo role:admin,superadmin.
    | El middleware de rol bloqueaba a docentes y estudiantes ANTES de
    | que el controlador pudiera ejecutarse, devolviendo una respuesta
    | vacía / abort(403). Como auth()->user() nunca llegaba a evaluarse,
    | PHP lanzaba "Call to undefined method" (null->user()).
    | El ObservacionController ya maneja los permisos internamente,
    | así que solo necesita el middleware 'auth'.
    |----------------------------------------------------------------------
    */
    Route::resource('observaciones', ObservacionController::class);

    /*
    |======================================================================
    | SUPER ADMINISTRADOR
    |======================================================================
    */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {

        Route::get('/dashboard', fn () => view('superadmin.dashboard'))->name('dashboard');

        // Cambiar contraseña
        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        // Perfil
        Route::get('/perfil',          [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil',          [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        // ── Administradores: estáticas ANTES de {administrador} ───────────
        Route::get('/administradores/permisos',         [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos');
        Route::get('/administradores/permisos-roles',   [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos-roles');
        Route::put('/administradores/permisos/guardar', [SuperAdminController::class, 'actualizarPermisos'])->name('administradores.permisos.update');
        Route::get('/administradores/crear',            [SuperAdminController::class, 'create'])->name('administradores.create');
        Route::post('/administradores',                 [SuperAdminController::class, 'store'])->name('administradores.store');
        Route::get('/administradores',                  [SuperAdminController::class, 'index'])->name('administradores.index');

        // ── Administradores: dinámicas al final ───────────────────────────
        Route::get('/administradores/{administrador}',        [SuperAdminController::class, 'show'])->name('administradores.show');
        Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
        Route::put('/administradores/{administrador}',        [SuperAdminController::class, 'update'])->name('administradores.update');
        Route::delete('/administradores/{administrador}',     [SuperAdminController::class, 'destroy'])->name('administradores.destroy');

        // ── Usuarios: estáticas ANTES del resource ────────────────────────
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

        // ── Grados: estáticas ANTES del resource ──────────────────────────
        Route::get('grados/crear-masivo',    [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class)->names([
            'index'   => 'superadmin.grados.index',
            'create'  => 'superadmin.grados.create',
            'store'   => 'superadmin.grados.store',
            'show'    => 'superadmin.grados.show',
            'edit'    => 'superadmin.grados.edit',
            'update'  => 'superadmin.grados.update',
            'destroy' => 'superadmin.grados.destroy',
        ]);
        Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        // ── Materias ──────────────────────────────────────────────────────
        Route::resource('materias', MateriaController::class)->names([
            'index'   => 'superadmin.materias.index',
            'create'  => 'superadmin.materias.create',
            'store'   => 'superadmin.materias.store',
            'show'    => 'superadmin.materias.show',
            'edit'    => 'superadmin.materias.edit',
            'update'  => 'superadmin.materias.update',
            'destroy' => 'superadmin.materias.destroy',
        ]);

        // ── Horarios de grado ─────────────────────────────────────────────
        Route::resource('horarios_grado', HorarioGradoController::class)->names([
            'index'   => 'horarios_grado.index',
            'create'  => 'horarios_grado.create',
            'store'   => 'horarios_grado.store',
            'show'    => 'horarios_grado.show',
            'edit'    => 'horarios_grado.edit',
            'update'  => 'horarios_grado.update',
            'destroy' => 'horarios_grado.destroy',
        ]);

        // ── Profesor-Materia ──────────────────────────────────────────────
        Route::prefix('profesor-materia')->name('superadmin.profesor_materia.')->group(function () {
            Route::get('/',                [ProfesorMateriaController::class, 'index'])->name('index');
            Route::get('/create',          [ProfesorMateriaController::class, 'create'])->name('create');
            Route::post('/',               [ProfesorMateriaController::class, 'store'])->name('store');
            Route::get('/{profesor}/edit', [ProfesorMateriaController::class, 'edit'])->name('edit');
            Route::put('/{profesor}',      [ProfesorMateriaController::class, 'update'])->name('update');
            Route::delete('/{profesor}',   [ProfesorMateriaController::class, 'destroy'])->name('destroy');
        });
    });

    /*
    |======================================================================
    | ADMINISTRADOR
    |======================================================================
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('/',              [SolicitudController::class, 'index'])->name('index');
            Route::get('/{id}',          [SolicitudController::class, 'show'])->name('show');
            Route::post('/{id}/aprobar', [SolicitudController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar',[SolicitudController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/pendiente',[SolicitudController::class,'pendiente'])->name('pendiente');
        });
    });

    /*
    |======================================================================
    | PANEL ADMINS (admin + superadmin compartido)
    |======================================================================
    */
    Route::prefix('admins')->name('admins.')->middleware('role:admin,superadmin')->group(function () {

        Route::get('/roles-permisos',         [SuperAdminController::class, 'permisosRoles'])->name('roles-permisos');
        Route::put('/roles-permisos/guardar', [SuperAdminController::class, 'actualizarPermisos'])->name('asignar-permisos');

        Route::get('/permisos',                                    [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar',                 [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar',                   [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto',       [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}',            [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle',       [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');

        // Estáticas ANTES de {admin}
        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::post('/',     [AdminController::class, 'store'])->name('store');
        Route::get('/',      [AdminController::class, 'index'])->name('index');

        // Dinámicas al final
        Route::get('/{admin}',        [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}',        [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}',     [AdminController::class, 'destroy'])->name('destroy');
    });

    /*
    |======================================================================
    | CRUDs PRINCIPALES (admin + superadmin)
    |======================================================================
    */
    Route::middleware('role:admin,superadmin')->group(function () {

        // Estudiantes
        Route::resource('estudiantes', EstudianteController::class);

        // Profesores
        Route::resource('profesores', ProfesorController::class)
            ->parameters(['profesores' => 'profesor']);

        // Padres: estáticas ANTES del resource
        Route::get('/padres/buscar',            [PadreController::class, 'buscar'])->name('padres.buscar');
        Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
        Route::post('/padres/desvincular',      [PadreController::class, 'desvincular'])->name('padres.desvincular');
        Route::resource('padres', PadreController::class);

        // Matrículas: estáticas ANTES de /{matricula}
        Route::prefix('matriculas')->name('matriculas.')->group(function () {
            Route::get('/',                       [MatriculaController::class, 'index'])->name('index');
            Route::get('/crear',                  [MatriculaController::class, 'create'])->name('create');
            Route::post('/',                      [MatriculaController::class, 'store'])->name('store');
            Route::get('/{matricula}/detalles',   [MatriculaController::class, 'detalles'])->name('detalles');
            Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
            Route::post('/{matricula}/rechazar',  [MatriculaController::class, 'rechazar'])->name('rechazar');
            Route::post('/{matricula}/cancelar',  [MatriculaController::class, 'cancelar'])->name('cancelar');
            Route::get('/{matricula}/editar',     [MatriculaController::class, 'edit'])->name('edit');
            Route::put('/{matricula}',            [MatriculaController::class, 'update'])->name('update');
            Route::delete('/{matricula}',         [MatriculaController::class, 'destroy'])->name('destroy');
            Route::get('/{matricula}',            [MatriculaController::class, 'show'])->name('show');
        });

        // Períodos académicos
        Route::resource('periodos-academicos', PeriodoAcademicoController::class);

        // Cupos máximos
        Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
            Route::get('/',          [CursoController::class, 'index'])->name('index');
            Route::get('/create',    [CursoController::class, 'create'])->name('create');
            Route::post('/',         [CursoController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
            Route::put('/{id}',      [CursoController::class, 'update'])->name('update');
            Route::delete('/{id}',   [CursoController::class, 'destroy'])->name('destroy');
        });

        // Documentos
        Route::resource('documentos', DocumentoController::class);

        // Materias
        Route::resource('materias', MateriaController::class);

        // Grados: estáticas ANTES del resource
        Route::get('grados/crear-masivo',    [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class);
        Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        // Asignación Profesor-Materia
        Route::prefix('profesor-materia')->name('profesor_materia.')->group(function () {
            Route::get('/',                [ProfesorMateriaController::class, 'index'])->name('index');
            Route::get('/create',          [ProfesorMateriaController::class, 'create'])->name('create');
            Route::post('/',               [ProfesorMateriaController::class, 'store'])->name('store');
            Route::get('/{profesor}/edit', [ProfesorMateriaController::class, 'edit'])->name('edit');
            Route::put('/{profesor}',      [ProfesorMateriaController::class, 'update'])->name('update');
            Route::delete('/{profesor}',   [ProfesorMateriaController::class, 'destroy'])->name('destroy');
        });

        // Cambiar contraseña (panel compartido)
        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        // Horarios de grado
        Route::resource('horarios_grado', HorarioGradoController::class);

        // Dashboard general
        Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');

        // Buscar registro de estudiante
        Route::get('/buscar-registro', [EstudianteController::class, 'buscarRegistro'])->name('buscarregistro');
    });

    /*
    |======================================================================
    | ESTUDIANTE
    |======================================================================
    */
    Route::prefix('estudiante')->name('estudiante.')->middleware('role:estudiante')->group(function () {
        Route::get('/dashboard',      fn () => view('estudiante.dashboard.index'))->name('dashboard');
        Route::get('/mi-horario',     [HorarioController::class,              'miHorario'])->name('miHorario');
        Route::get('/horario',        [HorarioController::class,              'horarioEstudiante'])->name('horario');
        Route::get('/calificaciones', [EstudianteController::class,           'misNotas'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
    });

    /*
    |======================================================================
    | PROFESOR
    |======================================================================
    */
    Route::prefix('profesor')->name('profesor.')->middleware('role:profesor')->group(function () {
        Route::get('/dashboard',      fn () => view('profesor.dashboard.index'))->name('dashboard');
        Route::get('/mi-horario',     [HorarioController::class,              'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
    });

    /*
    |======================================================================
    | PADRE
    |======================================================================
    */
    Route::prefix('padre')->name('padre.')->middleware('role:padre')->group(function () {
        Route::get('/dashboard', fn () => view('padre.dashboard.index'))->name('dashboard');
    });

});
