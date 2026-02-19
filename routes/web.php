<?php

use App\Http\Controllers\{
    Auth\LoginController,
    Auth\RegisterController,
    PasswordResetController,
    SuperAdminController,
    AdminController,
    DashboardController,
    EstudianteController,
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
    GradoController,
    MateriaController,
    PerfilController,
    CalificacionController,
    ProfesorMateriaController,
    RegistrarCalificacionController,
    AccionesImportantesController,
    CalendarioController,
    CicloController,
    SeccionController
};
use App\Http\Controllers\CupoMaximoController;
use App\Http\Controllers\PublicoPlanEstudiosController;
use App\Http\Controllers\SuperAdmin\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





// Ruta pública - Plan de Estudios (accesible sin login)
Route::get('/plan-estudios', [PublicoPlanEstudiosController::class, 'index'])->name('plan-estudios.index');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/inicio', function () {
    return view('plantilla');
})->name('inicio');

Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

// ==================== CALENDARIO PÚBLICO ====================
Route::get('/calendario-publico', function () {
    return view('calendario-publico');
})->name('calendario.publico');

// Esta es la ruta que el JS del calendario consultará públicamente
Route::get('/calendario/eventos/public', [CalendarioController::class, 'eventosPublicos'])->name('calendario.eventos.public');


// Obtener eventos del calendario (PÚBLICO - sin autenticación)

// Matrícula Pública (Nombres únicos para evitar conflicto con Admin)
Route::get('/matricula-publica', [MatriculaController::class, 'create'])->name('matriculas.public.create');
Route::post('/matricula-publica', [MatriculaController::class, 'store'])->name('matriculas.public.store');
Route::get('/matricula-exitosa', [MatriculaController::class, 'success'])->name('matriculas.public.success');

// Consulta de solicitudes
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (REQUIEREN AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Redirección inteligente de Dashboard
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
        $routeName = $roleRouteMap[$role] ?? 'inicio';
        return redirect()->route($routeName);
    })->name('dashboard');

    /* --- SUPER ADMIN --- */
    Route::prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        Route::get('/administradores/permisos-roles', [SuperAdminController::class, 'permisosRoles'])->name('administradores.permisos');
        Route::put('/administradores/{usuario}/permisos', [SuperAdminController::class, 'actualizarPermisos'])->name('administradores.permisos.update');
        
        Route::resource('administradores', SuperAdminController::class);
        Route::post('/usuarios/{id}/aprobar', [UsuarioController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::delete('/usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])->name('usuarios.rechazar');
    });

    /* --- ADMIN DASHBOARD --- */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        
        // Gestión de solicitudes (ADMIN)
        
    });

    /* --- ROLES ESPECÍFICOS --- */
    Route::get('/profesor/dashboard', fn() => view('profesor.dashboard.index'))->name('profesor.dashboard');
    Route::get('/estudiante/dashboard', fn() => view('estudiante.dashboard.index'))->name('estudiante.dashboard');
    Route::get('/padre/dashboard', fn() => view('padre.dashboard.index'))->name('padre.dashboard');

    /* --- GESTIÓN ACADÉMICA --- */
    Route::post('seccion/asignar', [SeccionController::class, 'asignar'])->name('secciones.asignar');

    // Resource con nombres plurales para coincidir con tus redirects
    Route::resource('seccion', SeccionController::class)->names([
        'index'   => 'secciones.index',
        'create'  => 'secciones.create',
        'store'   => 'secciones.store',
        'edit'    => 'secciones.edit',
        'update'  => 'secciones.update',
        'destroy' => 'secciones.destroy',
    ]);
    
    Route::resource('ciclos', CicloController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);
    Route::resource('profesor_materia', ProfesorMateriaController::class);
    Route::resource('acciones-importantes', AccionesImportantesController::class)->names('acciones_importantes');
    
    // Grados (Ordenado: rutas fijas antes que resource)
    Route::get('grados/crear-masivo', [GradoController::class, 'crearMasivo'])->name('grados.crear-masivo');
    Route::post('grados/generar-masivo', [GradoController::class, 'generarMasivo'])->name('grados.generar-masivo');
    Route::get('grados/{grado}/asignar-materias', [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
    Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');
    Route::resource('grados', GradoController::class);

    /* --- ESTUDIANTES Y PADRES --- */
    Route::get('/buscarregistro', [BuscarEstudianteController::class, 'buscarregistro'])->name('buscarregistro');
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);
    
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::resource('padres', PadreController::class);
    Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');

    Route::resource('cupos_maximos', CupoMaximoController::class);
    Route::resource('admins/permisos', PadrePermisoController::class)->names('admins.permisos');

    /* --- MATRÍCULAS (ADMIN) --- */
    Route::resource('matriculas', MatriculaController::class);
    // Rutas adicionales de matrícula que no cubre el resource
    Route::prefix('matriculas')->name('matriculas.')->group(function() {
        Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
        Route::post('/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('rechazar');
    });

    /* --- CALENDARIO ADMINISTRADOR --- */
    /* --- CALENDARIO ADMINISTRADOR --- */
    // Vista principal del calendario para admins
    
Route::get('/calendario', function () {
        return view('calendario-admin');
    })->name('calendario');
    // CRUD de eventos (index, store, update, destroy)
    // Esto genera automáticamente:
    // GET /calendario/eventos -> index
    // POST /calendario/eventos -> store
    // PUT /calendario/eventos/{evento} -> update
    // DELETE /calendario/eventos/{evento} -> destroy
   
    


    /* --- CONFIGURACIÓN --- */
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    Route::resource('documentos', DocumentoController::class);
    Route::resource('observaciones', ObservacionController::class)->except(['show']);
});