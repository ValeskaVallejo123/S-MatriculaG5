<?php

use App\Http\Controllers\BuscarEstudianteController;
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
use App\Http\Controllers\AccionesImportantesController;
use App\Http\Controllers\Admin\SolicitudAdminController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\CupoMaximoController;
use App\Http\Controllers\PublicoPlanEstudiosController;
use App\Http\Controllers\SuperAdmin\UsuarioController;
use App\Http\Controllers\CargaDocenteController;
use App\Http\Controllers\PadreDashboardController;

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

Route::get('/inicio', function () {
    return view('plantilla');
})->name('inicio');

Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

Route::get('/plan-estudios', [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');

Route::get('/plan-estudios/{grado}', [PublicoPlanEstudiosController::class, 'show'])
    ->name('plan-estudios.show');

Route::get('/calendario-publico', function () {
    return view('calendario-publico');
})->name('calendario.publico');

Route::get('/calendario/eventos/public', [CalendarioController::class, 'eventosPublicos'])->name('calendario.eventos.public');

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS DE MATRÍCULA
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
Route::get('/estado-solicitud',  [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('estado-solicitud.consultar');

Route::view('/consultar-estudiante', 'publico.consultar-estudiante')->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

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
| RUTAS PRIVADAS (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/buscar-registro', [BuscarEstudianteController::class, 'index'])->name('buscarregistro');

    Route::middleware('role:admin,superadmin')->group(function () {

        Route::get('/calendario/eventos', [CalendarioController::class, 'obtenerEventos']);
        Route::post('/calendario/eventos', [CalendarioController::class, 'store']);
        Route::put('/calendario/eventos/{id}', [CalendarioController::class, 'actualizar']);
        Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar']);

    });

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

    Route::resource('acciones-importantes', AccionesImportantesController::class)->names('acciones_importantes');

    /* --- SUPER ADMINISTRADOR --- */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {
        Route::get('/dashboard', fn () => view('superadmin.dashboard'))->name('dashboard');

        Route::resource('periodos-academicos', PeriodoAcademicoController::class)
            ->names('periodos-academicos');

        Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
        Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

        Route::get('/administradores/permisos', [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos');
        Route::put('/administradores/permisos/guardar', [SuperAdminController::class, 'actualizarPermisos'])->name('administradores.permisos.update');

        Route::get('/administradores/crear', [SuperAdminController::class, 'create'])->name('administradores.create');
        Route::get('/administradores', [SuperAdminController::class, 'index'])->name('administradores.index');
        Route::post('/administradores', [SuperAdminController::class, 'store'])->name('administradores.store');
        Route::get('/administradores/{administrador}', [SuperAdminController::class, 'show'])->name('administradores.show');
        Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
        Route::put('/administradores/{administrador}', [SuperAdminController::class, 'update'])->name('administradores.update');
        Route::delete('/administradores/{administrador}', [SuperAdminController::class, 'destroy'])->name('administradores.destroy');

        Route::resource('grados', GradoController::class);

        Route::get('grados/{grado}/asignar-materias', [GradoController::class, 'asignarMaterias'])
            ->name('grados.asignar-materias');
        Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])
            ->name('grados.guardar-materias');

        Route::resource('materias', MateriaController::class);
        Route::resource('horarios_grado', HorarioGradoController::class);
        Route::resource('documentos', DocumentoController::class);

        Route::prefix('profesor-materia')->name('profesor_materia.')->group(function () {
            Route::get('/', [ProfesorMateriaController::class, 'index'])->name('index');
            Route::get('/create', [ProfesorMateriaController::class, 'create'])->name('create');
            Route::post('/', [ProfesorMateriaController::class, 'store'])->name('store');
            Route::get('/{profesor}/edit', [ProfesorMateriaController::class, 'edit'])->name('edit');
            Route::put('/{profesor}', [ProfesorMateriaController::class, 'update'])->name('update');
            Route::delete('/{profesor}', [ProfesorMateriaController::class, 'destroy'])->name('destroy');
        });

        Route::get('usuarios/pendientes', [UsuarioController::class, 'pendientes'])->name('usuarios.pendientes');
        Route::post('usuarios/{id}/aprobar', [UsuarioController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::delete('usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])->name('usuarios.rechazar');
        Route::put('usuarios/{id}/activar', [UsuarioController::class, 'activar'])->name('usuarios.activar');
        Route::put('usuarios/{id}/desactivar', [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');
        Route::resource('usuarios', UsuarioController::class);
    });

    /* --- ADMINISTRADOR --- */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
            Route::get('/', [SolicitudController::class, 'index'])->name('index');
            Route::get('/{id}', [SolicitudController::class, 'show'])->name('show');
            Route::post('/{id}/aprobar', [SolicitudController::class, 'aprobar'])->name('aprobar');
            Route::post('/{id}/rechazar', [SolicitudController::class, 'rechazar'])->name('rechazar');
            Route::post('/{id}/pendiente', [SolicitudController::class, 'pendiente'])->name('pendiente');
        });
    });

    /* --- PROFESOR --- */
    Route::prefix('profesor')->name('profesor.')->group(function () {
        Route::get('/dashboard', fn() => view('profesor.dashboard.index'))->name('dashboard');
    });

    /* --- ESTUDIANTE --- */
    Route::prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/dashboard', fn() => view('estudiante.dashboard.index'))->name('dashboard');
    });

    /* --- PADRE --- */
    Route::prefix('padre')->name('padre.')->middleware('es.padre')->group(function () {
        Route::get('/dashboard', [PadreDashboardController::class, 'index'])->name('dashboard');
        Route::get('/hijo/{estudianteId}', [PadreDashboardController::class, 'verHijo'])->name('hijo');
    });

    /* --- PANEL ADMINS --- */
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/permisos', [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
    });

    /* --- RUTAS COMPARTIDAS (admin + superadmin) --- */
    Route::middleware('role:admin,superadmin')->group(function () {
        //Route::get('/carga-docente', [CargaDocenteController::class, 'index'])->name('carga-docente.index');
        Route::resource('estudiantes', EstudianteController::class);
        Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);
        Route::resource('padres', PadreController::class);

        Route::prefix('matriculas')->name('matriculas.')->group(function () {
            Route::get('/', [MatriculaController::class, 'index'])->name('index');
            Route::get('/crear', [MatriculaController::class, 'create'])->name('create');
            Route::post('/', [MatriculaController::class, 'store'])->name('store');
            Route::get('/{matricula}', [MatriculaController::class, 'show'])->name('show');
            Route::put('/{matricula}', [MatriculaController::class, 'update'])->name('update');
            Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
        });

        // ── Rutas de Sección (bloque único consolidado) ──────────────────────
        Route::prefix('secciones')->name('secciones.')->group(function () {
            Route::get('/',                 [SeccionController::class, 'index'])->name('index');
            // ⚠️ Rutas con segmento fijo ANTES de las rutas con {parámetro}
            Route::get('/create',            [SeccionController::class, 'create'])->name('secciones.create');
            Route::post('/',                [SeccionController::class, 'store'])->name('store');
            Route::get('/{seccion}/editar', [SeccionController::class, 'edit'])->name('edit');
            Route::put('/{seccion}',        [SeccionController::class, 'update'])->name('update');
            Route::delete('/{seccion}',     [SeccionController::class, 'destroy'])->name('destroy');
            // ⚠️ Rutas con segmento fijo ANTES de las rutas con {parámetro}
            Route::post('/asignar',         [SeccionController::class, 'asignar'])->name('asignar');
            Route::patch('/quitar',         [SeccionController::class, 'quitar'])->name('quitar');
        });

        Route::resource('ciclos', CicloController::class);
        Route::resource('cupos_maximos', CupoMaximoController::class);
        Route::resource('observaciones', ObservacionController::class)->except(['show']);
        Route::get('/calendario_admin', fn() => view('calendario-admin'))->name('calendario');
    });

}); // FIN AUTH