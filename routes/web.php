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
use App\Http\Controllers\ProfesorMateriaGradoController;
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
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\ConsultaestudiantexcursoController;
use App\Http\Controllers\H20CursoController;
use App\Http\Controllers\ProfesorDashboardController;
use App\Http\Controllers\EstudianteDashboardController;
use App\Http\Controllers\AsistenciaController;

// ── PÚBLICAS ──────────────────────────────────────────────────────
Route::get('/', fn () => redirect()->route('login'));
Route::get('/inicio',    fn () => view('plantilla'))->name('inicio');
Route::get('/plantilla', fn () => view('plantilla'))->name('plantilla');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

// ── CALENDARIO PÚBLICO ────────────────────────────────────────────
Route::get('/calendario-publico',        fn () => view('calendario-publico'))->name('calendario.publico');
Route::get('/calendario/eventos/public', [CalendarioController::class, 'eventosPublicos'])->name('calendario.eventos.public');

// ── MATRÍCULA PÚBLICA ─────────────────────────────────────────────
Route::get('/matricula-publica',  [MatriculaController::class, 'createPublico'])->name('matriculas.public.create');
Route::post('/matricula-publica', [MatriculaController::class, 'store'])->name('matriculas.store');
Route::get('/matricula-exitosa',  [MatriculaController::class, 'success'])->name('matriculas.success');

Route::get('/estado-solicitud',  [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('estado-solicitud.consultar');
Route::view('/consultar-estudiante', 'publico.consultar-estudiante')->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

Route::prefix('portal')->name('portal.')->group(function () {
    Route::view('/',          'portal.inicio')->name('inicio');
    Route::view('/acerca-de', 'portal.acerca-de')->name('acerca-de');
    Route::view('/contacto',  'portal.contacto')->name('contacto');
    Route::get('/horarios-publicos',     [HorarioController::class,             'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos',   [ProfesorController::class,            'listarPublico'])->name('profesores');
    Route::get('/plan-estudios',         [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');
    Route::get('/plan-estudios/{grado}', [PublicoPlanEstudiosController::class, 'show'])->name('plan-estudios.show');
});

// ── AUTH ──────────────────────────────────────────────────────────
Route::get('/login',   [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',  [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/password/solicitar',           [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar',          [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer',        [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar',          'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

// ── PRIVADAS ──────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // ── CALENDARIO ADMIN ──────────────────────────────────────────
    Route::prefix('calendario')->name('calendario.')->group(function () {
        Route::get('/',              [CalendarioController::class, 'index'])->name('index');
        Route::post('/eventos',      [CalendarioController::class, 'store'])->name('eventos.store');
        Route::get('/eventos/{id}/edit', [CalendarioController::class, 'editJson'])->name('eventos.edit');
        Route::put('/eventos/{id}',  [CalendarioController::class, 'actualizar'])->name('eventos.update');
        Route::delete('/eventos/{id}', [CalendarioController::class, 'eliminar'])->name('eventos.destroy');
        Route::get('/eventos',       [CalendarioController::class, 'obtenerEventos']);
    });

    // ── NOTIFICACIONES ────────────────────────────────────────────
    Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
        Route::get('/',                      [NotificacionController::class,            'index'])->name('index');
        Route::patch('/{notificacion}/leer', [NotificacionController::class,            'marcarLeida'])->name('marcarLeida');
        Route::get('/preferencias',          [NotificacionPreferenciaController::class, 'edit'])->name('preferencias');
        Route::put('/preferencias',          [NotificacionPreferenciaController::class, 'update'])->name('preferencias.update');
    });

    Route::resource('acciones-importantes', AccionesImportantesController::class)->names('acciones_importantes');

    Route::resource('observaciones', ObservacionController::class)
        ->except(['show'])->parameters(['observaciones' => 'observacion']);

    Route::get('/buscarregistro',     [BuscarEstudianteController::class, 'buscarregistro'])->name('buscarregistro');
    Route::get('/estudiantes/buscar', [EstudianteController::class,       'buscar'])->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);

    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

    Route::get('carga-docente', [CargaDocenteController::class, 'index'])->name('carga-docente.index');

    Route::get('/padres/buscar',            [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular',      [PadreController::class, 'desvincular'])->name('padres.desvincular');
    Route::resource('padres', PadreController::class);

    Route::prefix('matriculas')->name('matriculas.')->group(function () {
        Route::get('/',      [MatriculaController::class, 'index'])->name('index');
        Route::get('/crear', [MatriculaController::class, 'create'])->name('create');
        Route::get('/{matricula}/detalles',   [MatriculaController::class, 'detalles'])->name('detalles');
        Route::get('/{matricula}/editar',     [MatriculaController::class, 'edit'])->name('edit');
        Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
        Route::post('/{matricula}/rechazar',  [MatriculaController::class, 'rechazar'])->name('rechazar');
        Route::post('/{matricula}/cancelar',  [MatriculaController::class, 'cancelar'])->name('cancelar');
        Route::post('/{matricula}/pdf',       [MatriculaController::class, 'exportarPdf'])->name('pdf');
        Route::patch('/{matricula}/aprobar',  [MatriculaController::class, 'aprobar'])->name('aprobar');
        Route::get('/{matricula}',    [MatriculaController::class, 'show'])->name('show');
        Route::put('/{matricula}',    [MatriculaController::class, 'update'])->name('update');
        Route::delete('/{matricula}', [MatriculaController::class, 'destroy'])->name('destroy');
    });

    Route::resource('periodos-academicos', PeriodoAcademicoController::class);
    Route::resource('ciclos', CicloController::class);

    Route::post('secciones/asignar', [SeccionController::class, 'asignar'])->name('secciones.asignar');
    Route::resource('seccion', SeccionController::class)->names([
        'index'   => 'secciones.index',  'create' => 'secciones.create',
        'store'   => 'secciones.store',  'edit'   => 'secciones.edit',
        'update'  => 'secciones.update', 'destroy' => 'secciones.destroy',
    ]);

    Route::resource('cupos_maximos', CupoMaximoController::class);
    Route::resource('documentos', DocumentoController::class);
    Route::resource('materias', MateriaController::class);

    Route::get('grados/crear-masivo',              [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
    Route::post('grados/generar-masivo',           [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
    Route::resource('grados', GradoController::class);
    Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
    Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

    // ── ASIGNACIÓN PROFESOR-MATERIA-GRADO ─────────────────────────
    Route::prefix('profesor-materia')->name('profesor_materia_grado.')->group(function () {
        Route::get('/',                              [ProfesorMateriaGradoController::class, 'index'])->name('index');
        Route::get('/create',                        [ProfesorMateriaGradoController::class, 'create'])->name('create');
        Route::post('/',                             [ProfesorMateriaGradoController::class, 'store'])->name('store');
        Route::get('/{profesor_materia_grado}/edit', [ProfesorMateriaGradoController::class, 'edit'])->name('edit');
        Route::put('/{profesor_materia_grado}',      [ProfesorMateriaGradoController::class, 'update'])->name('update');
        Route::delete('/{profesor_materia_grado}',   [ProfesorMateriaGradoController::class, 'destroy'])->name('destroy');
    });

    // ── HORARIOS ──────────────────────────────────────────────────
    Route::get('horarios/gestionar', [HorarioGradoController::class, 'gestionar'])->name('horarios_grado.gestionar');
    Route::get('api/horario-grado/{grado_id}/{jornada}', [HorarioGradoController::class, 'apiHorario']);
    Route::get('api/grado-materias/{grado_id}',          [HorarioGradoController::class, 'apiMaterias']);
    Route::get('api/grado-estudiantes/{grado_id}',       [HorarioGradoController::class, 'apiEstudiantes']);
    Route::get('horarios/{grado}/{jornada}/pdf',       [HorarioGradoController::class, 'exportarPdf'])->name('horarios_grado.pdf');
    Route::get('horarios/{grado}/{jornada}/editar',    [HorarioGradoController::class, 'edit'])->name('horarios_grado.edit');
    Route::get('horarios/{grado}/{jornada}/conflicto', [HorarioGradoController::class, 'verificarConflicto'])->name('horarios_grado.conflicto');
    Route::put('horarios/{grado}/{jornada}',           [HorarioGradoController::class, 'update'])->name('horarios_grado.update');
    Route::get('horarios/{grado}/{jornada}',           [HorarioGradoController::class, 'show'])->name('horarios_grado.show');
    Route::get('horarios',                             [HorarioGradoController::class, 'index'])->name('horarios_grado.index');
    Route::get('horarios_grado', fn () => redirect()->route('horarios_grado.index', [], 301));
    Route::get('horarios_grado/{grado}/{jornada}', fn ($g, $j) => redirect()->route('horarios_grado.show', [$g, $j], 301));

    // ── CURSOS ────────────────────────────────────────────────────
    Route::get('/cursos/estudiantes',                   [ConsultaestudiantexcursoController::class, 'index'])->name('consultaestudiantesxcurso.index');
    Route::get('/cursos/estudiantes/{grado}/{seccion}', [ConsultaestudiantexcursoController::class, 'show'])->name('consultaestudiantesxcurso.show');
    Route::get('/consultaestudiantesxcurso', fn () => redirect()->route('consultaestudiantesxcurso.index', [], 301));
    Route::get('/consultaestudiantesxcurso/{grado}/{seccion}', fn ($g, $s) => redirect()->route('consultaestudiantesxcurso.show', [$g, $s], 301));

    Route::get('/primaria', [H20CursoController::class, 'primaria'])->name('h20cursos.primaria');
    Route::resource('secundaria', H20CursoController::class)->names([
        'index'   => 'h20cursos.index',  'create' => 'h20cursos.create',
        'store'   => 'h20cursos.store',  'show'   => 'h20cursos.show',
        'edit'    => 'h20cursos.edit',   'update' => 'h20cursos.update',
        'destroy' => 'h20cursos.destroy',
    ]);
    Route::get('/h20cursos', fn () => redirect()->route('h20cursos.index', [], 301));

    // ── CALIFICACIONES ────────────────────────────────────────────
    Route::get('calificaciones',                               [RegistrarCalificacionController::class, 'index'])->name('registrarcalificaciones.index');
    Route::get('calificaciones/registrar',                     [RegistrarCalificacionController::class, 'create'])->name('registrarcalificaciones.create');
    Route::post('calificaciones/registrar',                    [RegistrarCalificacionController::class, 'store'])->name('registrarcalificaciones.store');
    Route::get('calificaciones/registrar/estudiantes/{curso}', [RegistrarCalificacionController::class, 'obtenerEstudiantes'])->name('registrarcalificaciones.estudiantes');
    Route::get('calificaciones/registrar/ver',                 [RegistrarCalificacionController::class, 'ver'])->name('registrarcalificaciones.ver');
    Route::get('calificaciones/notas-existentes',              [RegistrarCalificacionController::class, 'notasExistentes'])->name('registrarcalificaciones.notas-existentes');
    Route::get('registrar-calificaciones', fn () => redirect()->route('registrarcalificaciones.create', [], 301));

    // ── ASISTENCIAS ───────────────────────────────────────────────
    //
    // IMPORTANTE: el orden de las rutas dentro del prefix importa.
    // Las rutas más específicas (/crear, /ver, /reporte, /api/...)
    // deben ir ANTES del resource o de cualquier ruta con segmentos
    // dinámicos para evitar que Laravel las interprete como parámetros.
    //
    // La ruta 'show' usa query string: GET /asistencias/ver?grado_id=X&materia_id=Y&fecha=Z
    // NO usa parámetros de ruta — por eso el controlador lee $request->query(...)
    //
    Route::prefix('asistencias')->name('asistencias.')->group(function () {
        Route::get('/crear',   [AsistenciaController::class, 'create'])->name('create');
        Route::get('/ver',     [AsistenciaController::class, 'show'])->name('show');
        Route::get('/reporte', [AsistenciaController::class, 'reporte'])->name('reporte');
        Route::get('/api/materias/{gradoId}', [AsistenciaController::class, 'apiMaterias'])->name('api.materias');
        Route::post('/',       [AsistenciaController::class, 'store'])->name('store');
        Route::get('/',        [AsistenciaController::class, 'index'])->name('index');
    });

    // ── CAMBIAR CONTRASEÑA ────────────────────────────────────────
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    // ── ADMINS (permisos, roles) ───────────────────────────────────
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

    // ── SUPERADMIN ────────────────────────────────────────────────
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:super_admin')->group(function () {

        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/perfil',          [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil',          [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario');

        Route::get('estudiantes/{id}/historial-academico',        [EstudianteController::class, 'verHistorialAdmin'])->name('estudiantes.historial.show');
        Route::get('estudiantes/{id}/historial-academico/editar', [EstudianteController::class, 'editHistorialAdmin'])->name('estudiantes.historial.edit');
        Route::put('estudiantes/{id}/historial-academico',        [EstudianteController::class, 'updateHistorialAdmin'])->name('estudiantes.historial.update');
        Route::resource('estudiantes', EstudianteController::class);

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

        Route::get('grados/crear-masivo',              [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
        Route::post('grados/generar-masivo',           [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        Route::resource('grados', GradoController::class);
        Route::get('grados/{grado}/asignar-materias',  [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

        Route::resource('materias', MateriaController::class)->names([
            'index'   => 'materias.index',  'create' => 'materias.create',
            'store'   => 'materias.store',  'show'   => 'materias.show',
            'edit'    => 'materias.edit',   'update' => 'materias.update',
            'destroy' => 'materias.destroy',
        ]);

        Route::get('horarios/gestionar', [HorarioGradoController::class, 'gestionar'])->name('horarios_grado.gestionar');
        Route::get('api/horario-grado/{grado_id}/{jornada}', [HorarioGradoController::class, 'apiHorario']);
        Route::get('api/grado-materias/{grado_id}',          [HorarioGradoController::class, 'apiMaterias']);
        Route::get('api/grado-estudiantes/{grado_id}',       [HorarioGradoController::class, 'apiEstudiantes']);
        Route::get('horarios/{grado}/{jornada}/pdf',       [HorarioGradoController::class, 'exportarPdf'])->name('horarios_grado.pdf');
        Route::get('horarios/{grado}/{jornada}/editar',    [HorarioGradoController::class, 'edit'])->name('horarios_grado.edit');
        Route::get('horarios/{grado}/{jornada}/conflicto', [HorarioGradoController::class, 'verificarConflicto'])->name('horarios_grado.conflicto');
        Route::put('horarios/{grado}/{jornada}',           [HorarioGradoController::class, 'update'])->name('horarios_grado.update');
        Route::get('horarios/{grado}/{jornada}',           [HorarioGradoController::class, 'show'])->name('horarios_grado.show');
        Route::get('horarios',                             [HorarioGradoController::class, 'index'])->name('horarios_grado.index');

        Route::resource('cupos-maximos', CupoMaximoController::class)->names([
            'index'   => 'cupos_maximos.index',  'create' => 'cupos_maximos.create',
            'store'   => 'cupos_maximos.store',  'show'   => 'cupos_maximos.show',
            'edit'    => 'cupos_maximos.edit',   'update' => 'cupos_maximos.update',
            'destroy' => 'cupos_maximos.destroy',
        ]);
        Route::get('cupos_maximos', fn () => redirect()->route('superadmin.cupos_maximos.index', [], 301));

    }); // fin superadmin

    // ── ADMIN ─────────────────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('estudiantes/{id}/historial-academico', [EstudianteController::class, 'verHistorialAdmin'])->name('estudiantes.historial');
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

    // ── PROFESOR ──────────────────────────────────────────────────
    Route::prefix('profesor')->name('profesor.')->group(function () {
        Route::get('/dashboard', [ProfesorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
        Route::get('/mi-horario',          [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones',      [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
        Route::get('/mis-cursos',                        [ProfesorGradosController::class,     'index'])->name('mis-cursos');
        Route::get('/mis-estudiantes/{grado}/{seccion}', [ProfesorEstudianteController::class, 'index'])->name('mis-estudiantes');

        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('/',                [SolicitudAdminController::class, 'index'])->name('index');
            Route::get('/{id}',            [SolicitudAdminController::class, 'show'])->name('show');
            Route::post('/{id}/aprobar',   [SolicitudAdminController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar',  [SolicitudAdminController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/pendiente', [SolicitudAdminController::class, 'pendiente'])->name('pendiente');
        });

        Route::prefix('cuadro-calificaciones')->name('cuadro.')->group(function () {
            Route::get('/',             [CalificacionController::class, 'indexProfesor'])->name('index');
            Route::post('/guardar',     [CalificacionController::class, 'guardar'])->name('guardar');
            Route::post('/porcentajes', [CalificacionController::class, 'guardarPorcentajes'])->name('porcentajes');
        });
    }); // fin profesor

    // ── ESTUDIANTE ────────────────────────────────────────────────
    Route::prefix('estudiante')->name('estudiante.')->middleware('role:estudiante')->group(function () {
        Route::get('/dashboard',      [EstudianteDashboardController::class,     'index'])->name('dashboard');
        Route::get('/mi-historial',   [EstudianteController::class,              'historial'])->name('historial');
        Route::get('/mi-horario',     [HorarioController::class,                 'miHorario'])->name('miHorario');
        Route::get('/calificaciones', [MisCalificacionesController::class,       'index'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
        Route::get('/mis-notas',      [CalificacionController::class,            'indexAlumno'])->name('mis-notas');
    }); // fin estudiante

    // ── PADRE ─────────────────────────────────────────────────────
    Route::prefix('padre')->name('padre.')->middleware('role:padre')->group(function () {
        Route::get('/dashboard',           [PadreDashboardController::class, 'index'])->name('dashboard');
        Route::get('/hijo/{estudianteId}', [PadreDashboardController::class, 'verHijo'])->name('hijo');
        Route::put('/password',            [PadreDashboardController::class, 'cambiarPassword'])->name('cambiarPassword');
        Route::put('/cambiar-password',    [PadreDashboardController::class, 'cambiarPassword'])->name('cambiar-password');
        Route::get('/calificaciones-hijo', [CalificacionController::class,   'indexPadre'])->name('calificaciones-hijo');
    }); // fin padre

    // ── DASHBOARD REDIRECT ────────────────────────────────────────
    Route::get('/dashboard', function () {
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

    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/carga-docente', [CargaDocenteController::class, 'index'])->name('carga-docente.index');
    });

}); // fin auth