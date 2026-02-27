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
use App\Http\Controllers\Admin\SolicitudAdminController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\CupoMaximoController;
use App\Http\Controllers\PublicoPlanEstudiosController;

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/
// Plan de estudios público
Route::get('/plan-estudios', action: [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');

// AGREGAR ESTA LÍNEA:
Route::get('/plan-estudios/{grado}', [PublicoPlanEstudiosController::class, 'show'])->name('plan-estudios.show');
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

// Plan de estudios público
Route::get('/plan-estudios', [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');

// Calendario público
Route::get('/calendario-publico', function () {
    return view('calendario-publico');
})->name('calendario.publico');
Route::get('/calendario/eventos/public', [CalendarioController::class, 'eventosPublicos'])->name('calendario.eventos.public');

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
Route::get('/matricula-exitosa', [MatriculaController::class, 'success'])->name('matriculas.success');

// Consulta de solicitudes (PÚBLICA)
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

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

Route::get('/calendario/eventos', [CalendarioController::class, 'obtenerEventos']);

// Obtener eventos
//Route::get('/calendario/eventos', [CalendarioController::class, 'index']);

// Guardar evento
Route::post('/calendario/eventos', [CalendarioController::class, 'store']);

// Actualizar evento
Route::put('/calendario/eventos/{id}', [CalendarioController::class, 'actualizar']);

// Eliminar evento
Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar']);

    // Dashboard con redirección por rol
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        $roleRouteMap = [
            'super_admin' => 'superadmin.dashboard',
            'admin'       => 'admin.dashboard',
            'profesor'    => 'profesor.dashboard',
            'estudiante'  => 'estudiante.dashboard',
            'padre'       => 'padre.dashboard',
            'user'        => 'admin.dashboard',
        ];
        return redirect()->route($roleRouteMap[$role] ?? 'inicio');
    })->name('dashboard');

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
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // Gestión de solicitudes (ADMIN)
        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('/', [SolicitudAdminController::class, 'index'])->name('index');
            Route::get('/{id}', [SolicitudAdminController::class, 'show'])->name('show');
            Route::post('/{id}/aprobar', [SolicitudAdminController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar', [SolicitudAdminController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/pendiente', [SolicitudAdminController::class, 'pendiente'])->name('pendiente');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ACCIONES IMPORTANTES
    |--------------------------------------------------------------------------
    */
    Route::resource('acciones-importantes', AccionesImportantesController::class)
        ->names('acciones_importantes');

    /*
    |--------------------------------------------------------------------------
    | RUTAS DE PROFESOR
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    | RUTAS DE PADRE
    |--------------------------------------------------------------------------
    */
    Route::prefix('padre')->name('padre.')->group(function () {
        Route::get('/dashboard', function () {
            return view('padre.dashboard.index');
        })->name('dashboard');
    });

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
    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE MATRÍCULAS (ADMIN)
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
    |======================================================================
    | ESTUDIANTE
    |======================================================================
    */
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE CICLOS
    |--------------------------------------------------------------------------
    */
    Route::resource('ciclos', CicloController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE SECCIONES
    |--------------------------------------------------------------------------
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
    |--------------------------------------------------------------------------
    | GESTIÓN DE CUPOS MÁXIMOS
    |--------------------------------------------------------------------------
    */
    Route::resource('cupos_maximos', CupoMaximoController::class);

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