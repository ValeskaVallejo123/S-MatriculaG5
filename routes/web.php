<?php

use App\Http\Controllers\AccionesImportantesController;
use App\Http\Controllers\Admin\SolicitudAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\CupoMaximoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\HorarioGradoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\NotificacionPreferenciaController;
use App\Http\Controllers\PadreController;
use App\Http\Controllers\PadrePermisoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ProfesorMateriaController;
use App\Http\Controllers\PublicoPlanEstudiosController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\SuperAdmin\UsuarioController;
use App\Http\Controllers\RegistrarCalificacionController;
use App\Http\Controllers\AccionesImportantesController;
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
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::get('/', fn () => redirect()->route('login'));
Route::get('/inicio',    fn () => view('plantilla'))->name('inicio');
Route::get('/plantilla', fn () => view('plantilla'))->name('plantilla');

// Plan de estudios (sin duplicado)
Route::get('/plan-estudios',        [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');
Route::get('/plan-estudios/{grado}', [PublicoPlanEstudiosController::class, 'show'])->name('plan-estudios.show');

// Calendario público
Route::get('/calendario-publico',          fn () => view('calendario-publico'))->name('calendario.publico');
Route::get('/calendario/eventos/public',   [CalendarioController::class, 'eventosPublicos'])->name('calendario.eventos.public');


// Matrícula pública
Route::get('/matricula-publica',  [MatriculaController::class, 'create'])->name('matriculas.public.create');
Route::post('/matricula-publica', [MatriculaController::class, 'store'])->name('matriculas.public.store');
Route::get('/matricula-exitosa',  [MatriculaController::class, 'success'])->name('matriculas.success');

// Consulta de solicitudes (PÚBLICA)
// estado de solicitud manuel padilla
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])
    ->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);
// Consultas públicas
Route::get('/estado-solicitud',  [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('estado-solicitud.consultar');
Route::view('/consultar-estudiante', 'publico.consultar-estudiante')->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

// Portal público
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

// Recuperación de contraseña
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

    // Dashboard con redirección por rol
    Route::get('/dashboard', function () {
        $roleRouteMap = [
            'super_admin' => 'superadmin.dashboard',
            'admin'       => 'admin.dashboard',
            'profesor'    => 'profesor.dashboard',
            'estudiante'  => 'estudiante.dashboard',
            'padre'       => 'padre.dashboard',
            'user'        => 'admin.dashboard',
        ];
        return redirect()->route($roleRouteMap[Auth::user()->role] ?? 'inicio');
    })->name('dashboard');

    // Calendario (auth, todos los roles)
    Route::get('/calendario/eventos',          [CalendarioController::class, 'obtenerEventos']);
    Route::post('/calendario/eventos',         [CalendarioController::class, 'store']);
    Route::put('/calendario/eventos/{id}',     [CalendarioController::class, 'actualizar']);
    Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar']);

    // Notificaciones (todos los roles)
    Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
        Route::get('/',                      [NotificacionController::class,            'index'])->name('index');
        Route::patch('/{notificacion}/leer', [NotificacionController::class,            'marcarLeida'])->name('marcarLeida');
        Route::get('/preferencias',          [NotificacionPreferenciaController::class, 'edit'])->name('preferencias');
        Route::put('/preferencias',          [NotificacionPreferenciaController::class, 'update'])->name('preferencias.update');
    });

    // Acciones importantes (todos los roles)
    Route::resource('acciones-importantes', AccionesImportantesController::class)
        ->names('acciones_importantes');

    /*
    |----------------------------------------------------------------------
    | SUPERADMIN
    |----------------------------------------------------------------------
    */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        // Gestión de usuarios
        Route::prefix('usuarios')->name('usuarios.')->group(function () {
            Route::get('/',                      [UsuarioController::class, 'index'])->name('index');
            Route::get('/crear',                 [UsuarioController::class, 'create'])->name('create');
            Route::post('/',                     [UsuarioController::class, 'store'])->name('store');
            Route::get('/pendientes',            [UsuarioController::class, 'pendientes'])->name('pendientes');
            Route::get('/{id}',                  [UsuarioController::class, 'show'])->name('show');
            Route::get('/{id}/editar',           [UsuarioController::class, 'edit'])->name('edit');
            Route::put('/{id}',                  [UsuarioController::class, 'update'])->name('update');
            Route::delete('/{id}',               [UsuarioController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/aprobar',         [UsuarioController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar',        [UsuarioController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/activar',         [UsuarioController::class, 'activar'])->name('activar');
            Route::post('/{id}/desactivar',      [UsuarioController::class, 'desactivar'])->name('desactivar');
        });
    });

    /*
    |----------------------------------------------------------------------
    | ADMIN
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    });
// consultas de los estudiantes por cursos
    Route::get('/consultaestudiantesxcurso', [ConsultaestudiantexcursoController::class, 'index'])
        ->name('consultaestudiantesxcurso.index');

    Route::get('/consultaestudiantesxcurso/{grado}/{seccion}', [ConsultaestudiantexcursoController::class, 'show'])
        ->name('consultaestudiantesxcurso.show');
    /*
    |--------------------------------------------------------------------------
    | RUTAS DE PROFESOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->group(function () {
        Route::get('/dashboard', function () {
            return view('profesor.dashboard.index');
        })->name('dashboard');
        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

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
    | ADMIN + SUPERADMIN (recursos compartidos)
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin,superadmin')->group(function () {

        Route::get('/dashboard',        [DashboardController::class, 'redirect'])->name('dashboard');
        Route::get('/buscar-registro',  [EstudianteController::class, 'buscarRegistro'])->name('buscarregistro');
        Route::get('/cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('/cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        // Admins CRUD
        Route::prefix('admins')->name('admins.')->group(function () {
            Route::get('/crear', [AdminController::class, 'create'])->name('create');
            Route::post('/',     [AdminController::class, 'store'])->name('store');
            Route::get('/',      [AdminController::class, 'index'])->name('index');
            Route::get('/{admin}',        [AdminController::class, 'show'])->name('show');
            Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
            Route::put('/{admin}',        [AdminController::class, 'update'])->name('update');
            Route::delete('/{admin}',     [AdminController::class, 'destroy'])->name('destroy');
        });

        // Permisos de padre
        Route::prefix('admins/permisos')->name('admins.permisos.')->group(function () {
            Route::get('/',                                    [PadrePermisoController::class, 'index'])->name('index');
            Route::get('/{padre}/configurar',                  [PadrePermisoController::class, 'configurar'])->name('configurar');
            Route::post('/{padre}/guardar',                    [PadrePermisoController::class, 'guardar'])->name('guardar');
            Route::get('/{padre}/{estudiante}/defecto',        [PadrePermisoController::class, 'establecerDefecto'])->name('defecto');
            Route::delete('/{padre}/{estudiante}',             [PadrePermisoController::class, 'eliminar'])->name('eliminar');
            Route::post('/{padre}/{estudiante}/toggle',        [PadrePermisoController::class, 'toggleTodos'])->name('toggle');
        });

        // Estudiantes
        Route::resource('estudiantes', EstudianteController::class);
    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ESTUDIANTES
    |--------------------------------------------------------------------------
    */

    Route::get('/buscarregistro', [BuscarEstudianteController::class, 'buscarregistro'])
        ->name('buscarregistro');
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);

        // Profesores
        Route::resource('profesores', ProfesorController::class)
            ->parameters(['profesores' => 'profesor']);

        // Padres
        Route::get('/padres/buscar',            [PadreController::class, 'buscar'])->name('padres.buscar');
        Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
        Route::post('/padres/desvincular',      [PadreController::class, 'desvincular'])->name('padres.desvincular');
        Route::resource('padres', PadreController::class);

        // Matrículas
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

        // Ciclos
        Route::resource('ciclos', CicloController::class);

        // Secciones
        Route::post('secciones/asignar', [SeccionController::class, 'asignar'])->name('secciones.asignar');
        Route::resource('seccion', SeccionController::class)->names([
            'index'   => 'secciones.index',
            'create'  => 'secciones.create',
            'store'   => 'secciones.store',
            'edit'    => 'secciones.edit',
            'update'  => 'secciones.update',
            'destroy' => 'secciones.destroy',
        ]);

        // Cupos máximos
        Route::resource('cupos_maximos', CupoMaximoController::class);

        // Documentos
        Route::resource('documentos', DocumentoController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ACCIONES IMPORTANTES
    |--------------------------------------------------------------------------
    */
    Route::get('/acciones_importantes', [AccionesImportantesController::class, 'index'])
        ->name('acciones_importantes.index');


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR CONTRASEÑA
    |--------------------------------------------------------------------------
    */
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE MATERIAS Y GRADOS
    |--------------------------------------------------------------------------
    */
    Route::resource('materias', MateriaController::class);
    Route::resource('grados', GradoController::class);
    Route::get('grados/{grado}/asignar-materias', [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
    Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');
    Route::get('grados/crear-masivo', [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
        // Materias
        Route::resource('materias', MateriaController::class);

        // Grados
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

        // Horarios de grado
        Route::resource('horarios_grado', HorarioGradoController::class);
    });

    /*
    |----------------------------------------------------------------------
    | PROFESOR
    |----------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->middleware('role:profesor')->group(function () {
        Route::get('/dashboard',      fn () => view('profesor.dashboard.index'))->name('dashboard');
        Route::get('/mi-horario',     [HorarioController::class,               'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class,'indexProfesor'])->name('notificaciones.index');
    });

    // Mostrar formulario / filtros
    Route::get('registrar-calificaciones', [RegistrarCalificacionController::class, 'create'])
        ->name('registrarcalificaciones.create');
    // Guardar notas
    Route::post('registrar-calificaciones', [RegistrarCalificacionController::class, 'store'])
        ->name('registrarcalificaciones.store');
    // Listado (index) de calificaciones del profesor
    Route::get('calificaciones', [RegistrarCalificacionController::class, 'index'])
        ->name('registrarcalificaciones.index');
    // AJAX: obtener estudiantes por curso
    Route::get('registrar-calificaciones/estudiantes/{curso}', [RegistrarCalificacionController::class, 'obtenerEstudiantes'])
        ->name('registrarcalificaciones.estudiantes');
    Route::get('registrar-calificaciones/ver', [RegistrarCalificacionController::class, 'ver'])
        ->name('registrarcalificaciones.ver');


});
Route::resource('observaciones', ObservacionController::class)->except(['show']);
    /*
    |----------------------------------------------------------------------
    | PADRE
    |----------------------------------------------------------------------
    */
    Route::prefix('padre')->name('padre.')->middleware('role:padre')->group(function () {
        Route::get('/dashboard', fn () => view('padre.dashboard.index'))->name('dashboard');
    });

    /*
    |----------------------------------------------------------------------
    | ESTUDIANTE
    |----------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->middleware('role:estudiante')->group(function () {
        Route::get('/dashboard', fn () => view('estudiante.dashboard.index'))->name('dashboard');
    });



// cursos para secundaria
Route::resource('h20cursos', H20CursoController::class);

}); // fin middleware auth
