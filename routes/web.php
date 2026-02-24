<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\BuscarEstudianteController;
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
use App\Http\Controllers\GradoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\SuperAdmin\UsuarioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\ProfesorMateriaController;
use App\Http\Controllers\RegistrarCalificacionController;
use App\Http\Controllers\AccionesImportantesController;
use App\Http\Controllers\Admin\SolicitudAdminController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\CupoMaximoController;
use App\Http\Controllers\PublicoPlanEstudiosController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
// Plan de estudios público
Route::get('/plan-estudios', [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');

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
| RUTAS PÚBLICAS DE MATRÍCULA (SIN AUTH)
|--------------------------------------------------------------------------
*/
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

// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

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
| RUTAS PROTEGIDAS (Requieren Autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

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
    | RUTAS DE SUPER ADMINISTRADOR
    |----------------------------------------------------------------------
    */
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
    |--------------------------------------------------------------------------
    | GESTIÓN DE OBSERVACIONES
    |--------------------------------------------------------------------------
    */
    Route::resource('observaciones', ObservacionController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE DOCUMENTOS
    |--------------------------------------------------------------------------
    */
    Route::resource('documentos', DocumentoController::class);

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

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ASIGNACIÓN PROFESOR-MATERIA
    |--------------------------------------------------------------------------
    */
    Route::resource('profesor_materia', ProfesorMateriaController::class);

    /*
    |--------------------------------------------------------------------------
    | CALENDARIO (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::get('/calendario', function () {
        return view('calendario-admin');
    })->name('calendario');

    /*
    |--------------------------------------------------------------------------
    | CAMBIAR CONTRASEÑA
    |--------------------------------------------------------------------------
    */
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
});