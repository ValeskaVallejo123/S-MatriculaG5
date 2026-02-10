<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PerfilController,
    Auth\ForgotPasswordController,
    Auth\ResetPasswordController,
    AdminAsignacionProfesorGuiaController,
    Auth\LoginController,
    Auth\RegisterController,
    PasswordResetController,
    SuperAdminController,
    AdminController,
    DashboardController,
    EstudianteController,
    EstudianteDashboardController,
    BuscarEstudianteController,
    ProfesorController,
    MatriculaController,
    PeriodoAcademicoController,
    CursoController,
    ObservacionController,
    DocumentoController,
    SolicitudController,
    CambiarContraseniaController,
    PadrePermisoController,
    PadreController,
    ProfesorMateriaController,
    GradoController,
    MateriaController,
    HorarioGradoController,
    HorarioController,
    NotificacionPreferenciaController,
    NotificacionController,
    SuperAdmin\UsuarioController,
    RegistrarCalificacionController,
    AccionesImportantesController
};

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
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

Route::get('/matricula-publica', [MatriculaController::class, 'create'])->name('matriculas.public.create');
Route::post('/matricula-publica', [MatriculaController::class, 'store'])->name('matriculas.public.store');
Route::get('/matricula-exitosa', [MatriculaController::class, 'success'])->name('matriculas.success');

// Consulta de solicitudes (PÚBLICA)
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);
/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA (PÚBLICAS)
|--------------------------------------------------------------------------
*/
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');


/*
|--------------------------------------------------------------------------
| CONSULTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::view('/consultar-estudiante', 'publico.consultar-estudiante')->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

/*
|--------------------------------------------------------------------------
| PORTAL PÚBLICO
|--------------------------------------------------------------------------
*/
Route::prefix('portal')->name('portal.')->group(function () {
    Route::view('/', 'portal.inicio')->name('inicio');
    Route::view('/acerca-de', 'portal.acerca-de')->name('acerca-de');
    Route::view('/contacto', 'portal.contacto')->name('contacto');

    Route::get('/horarios-publicos', [HorarioController::class, 'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');
});

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

  //RUTAS DE SUPERADMIN - PERMISOS
    Route::prefix('superadmin')->name('superadmin.')->group(function () {

        // Dashboard y perfil
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        // IMPORTANTE: Permisos ANTES de las rutas dinámicas
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
    | RUTAS DE ADMINISTRADOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
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
    Route::prefix('profesor')->name('profesor.')->group(function () {
        Route::get('/dashboard', function () {
            return view('profesor.dashboard.index');
        })->name('dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | RUTAS DE ESTUDIANTE
    |--------------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/dashboard', function () {
            return view('estudiante.dashboard.index');
        })->name('dashboard');
    });

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

    /*
    |--------------------------------------------------------------------------
    | PANEL DE ADMINISTRADORES REGULARES
    |--------------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admins.')->group(function () {
        // Permisos de padres
        Route::get('/permisos', [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar', [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar', [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}', [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');

        // CRUD de administradores
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ESTUDIANTES
    |--------------------------------------------------------------------------
    */
    Route::get('/buscarregistro', [BuscarEstudianteController::class, 'buscarregistro'])->name('buscarregistro');
    Route::resource('estudiantes', EstudianteController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE PROFESORES
    |--------------------------------------------------------------------------
    */
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE PADRES/TUTORES
    |--------------------------------------------------------------------------
    */
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular', [PadreController::class, 'desvincular'])->name('padres.desvincular');
    Route::resource('padres', PadreController::class);

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
    |--------------------------------------------------------------------------
    | GESTIÓN DE PERIODOS ACADÉMICOS
    |--------------------------------------------------------------------------
    */
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE CUPOS MÁXIMOS (CURSOS)
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
    | GESTIÓN DE ASIGNACIÓN PROFESOR-MATERIA
    |--------------------------------------------------------------------------
    */
    Route::prefix('profesor-materia')->name('profesor_materia.')->group(function () {
        Route::get('/', [ProfesorMateriaController::class, 'index'])->name('index');
        Route::get('/create', [ProfesorMateriaController::class, 'create'])->name('create');
        Route::post('/', [ProfesorMateriaController::class, 'store'])->name('store');
        Route::get('/{profesor}/edit', [ProfesorMateriaController::class, 'edit'])->name('edit');
        Route::put('/{profesor}', [ProfesorMateriaController::class, 'update'])->name('update');
        Route::delete('/{profesor}', [ProfesorMateriaController::class, 'destroy'])->name('destroy');
    });
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD GENERAL (REDIRECCIONADOR)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS POR ROL
    |--------------------------------------------------------------------------
    */
    Route::get('/superadmin/dashboard', fn () => view('superadmin.dashboard'))
        ->middleware('role:superadmin')
        ->name('superadmin.dashboard');

    Route::get('usuarios/pendientes', [UsuarioController::class, 'pendientes'])
    ->name('usuarios.pendientes');


    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::view('/profesor/dashboard', 'profesor.dashboard.index')
        ->middleware('role:profesor')
        ->name('profesor.dashboard');

    Route::view('/padre/dashboard', 'padre.dashboard.index')
        ->middleware('role:padre')
        ->name('padre.dashboard');

    Route::get('/estudiante/dashboard', [EstudianteDashboardController::class, 'index'])
        ->middleware('role:estudiante')
        ->name('estudiante.dashboard');

    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN
    |--------------------------------------------------------------------------
    */
    /*Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {
        Route::resource('administradores', SuperAdminController::class);
        Route::resource('usuarios', UsuarioController::class);
    });*/
    Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware('role:superadmin')
    ->group(function () {

        Route::resource('usuarios', UsuarioController::class);

        Route::get('usuarios/pendientes', [UsuarioController::class, 'pendientes'])
            ->name('usuarios.pendientes');

        Route::post('usuarios/{id}/aprobar', [UsuarioController::class, 'aprobar'])
            ->name('usuarios.aprobar');

        Route::delete('usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])
            ->name('usuarios.rechazar');

        Route::resource('horarios_grado', HorarioGradoController::class);

        //ADMINISTRADORES - PERMISOS
        Route::resource('administradores', SuperAdminController::class);

    });




    });

    /*
    |--------------------------------------------------------------------------
    | CRUD PRINCIPALES
    |--------------------------------------------------------------------------
    */
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class);
    Route::resource('padres', PadreController::class);
    Route::resource('matriculas', MatriculaController::class);
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);
    Route::resource('cupos_maximos', CursoController::class);
    Route::resource('observaciones', ObservacionController::class)->except('show');
    Route::resource('documentos', DocumentoController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('grados', GradoController::class);

    /*
    |--------------------------------------------------------------------------
    | ESTUDIANTE
    |--------------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->middleware('role:estudiante')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorario'])->name('miHorario');
        Route::get('/horario', [HorarioController::class, 'horarioEstudiante'])->name('horario');
        Route::get('/calificaciones', [EstudianteController::class, 'misNotas'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
    });

     // 🔍 BUSCAR ESTUDIANTE
            Route::get('estudiantes/buscar', [BuscarEstudianteController::class, 'index'])
                ->name('estudiantes.buscar');

            Route::post('estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])
                ->name('estudiantes.buscar.post');

        // BUSCAR PADRE
        Route::get('padres/buscar', [PadreController::class, 'buscar'])
            ->name('padres.buscar');

    /*
    |--------------------------------------------------------------------------
    | PROFESOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->middleware('role:profesor')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
    });


    /*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::view('/', 'plantilla')->name('home');
Route::view('/plantilla', 'plantilla')->name('plantilla');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| MATRÍCULA PÚBLICA
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
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('estado-solicitud.consultar');

Route::view('/consultar-estudiante', 'publico.consultar-estudiante')->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

/*
|--------------------------------------------------------------------------
| PORTAL PÚBLICO
|--------------------------------------------------------------------------
*/
Route::prefix('portal')->name('portal.')->group(function () {
    Route::view('/', 'portal.inicio')->name('inicio');
    Route::view('/acerca-de', 'portal.acerca-de')->name('acerca-de');
    Route::view('/contacto', 'portal.contacto')->name('contacto');

    Route::get('/horarios-publicos', [HorarioController::class, 'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');
});

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD GENERAL (REDIRECCIONADOR)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS POR ROL
    |--------------------------------------------------------------------------
    */
    Route::get('/superadmin/dashboard', fn () => view('superadmin.dashboard'))
        ->middleware('role:superadmin')
        ->name('superadmin.dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::view('/profesor/dashboard', 'profesor.dashboard.index')
        ->middleware('role:profesor')
        ->name('profesor.dashboard');

    Route::view('/padre/dashboard', 'padre.dashboard.index')
        ->middleware('role:padre')
        ->name('padre.dashboard');

    Route::get('/estudiante/dashboard', [EstudianteDashboardController::class, 'index'])
        ->middleware('role:estudiante')
        ->name('estudiante.dashboard');

    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {
        Route::resource('administradores', SuperAdminController::class);
        Route::resource('usuarios', UsuarioController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | CRUD PRINCIPALES
    |--------------------------------------------------------------------------
    */
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class);
    Route::resource('padres', PadreController::class);
    Route::resource('matriculas', MatriculaController::class);
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);
    Route::resource('cupos_maximos', CursoController::class);
    Route::resource('observaciones', ObservacionController::class)->except('show');
    Route::resource('documentos', DocumentoController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('grados', GradoController::class);

    /*
    |--------------------------------------------------------------------------
    | ESTUDIANTE
    |--------------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->middleware('role:estudiante')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorario'])->name('miHorario');
        Route::get('/horario', [HorarioController::class, 'horarioEstudiante'])->name('horario');
        Route::get('/calificaciones', [EstudianteController::class, 'misNotas'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
    });

    /*
    |--------------------------------------------------------------------------
    | PROFESOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->middleware('role:profesor')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
    });
});


