<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\EstudianteDashboardController;
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
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NotificacionPreferenciaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\SuperAdmin\UsuarioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\ProfesorMateriaController;
use App\Http\Controllers\RegistrarCalificacionController;
use App\Http\Controllers\AccionesImportantesController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// 🏠 Ruta raíz → Login
Route::get('/', fn() => redirect()->route('login'));

// Plantilla principal pública
Route::get('/inicio', fn() => view('plantilla'))->name('inicio');
Route::get('/plantilla', fn() => view('plantilla'))->name('plantilla');

// 🌐 Portal público
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', fn() => view('portal.inicio'))->name('inicio');
    Route::get('/acerca-de', fn() => view('portal.acerca-de'))->name('acerca-de');
    Route::get('/contacto', fn() => view('portal.contacto'))->name('contacto');
    Route::get('/horarios-publicos', [HorarioController::class, 'horarioPublico'])->name('horarios');
    Route::get('/profesores-publicos', [ProfesorController::class, 'listarPublico'])->name('profesores');
});

// Consulta de solicitudes (público)
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('estado-solicitud');
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI'])->name('solicitud.consultar');

// Consulta estudiante (público)
Route::get('/consultar-estudiante', fn() => view('publico.consultar-estudiante'))->name('consultar-estudiante');
Route::post('/consultar-estudiante', [EstudianteController::class, 'consultarPublico'])->name('estudiante.consultar');

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
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| RECUPERACIÓN DE CONTRASEÑA
|--------------------------------------------------------------------------
*/
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // DASHBOARDS PRINCIPALES
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');
    Route::get('/superadmin/dashboard', fn() => view('superadmin.dashboard'))->name('superadmin.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/profesor/dashboard', fn() => view('profesor.dashboard.index'))->name('profesor.dashboard');
    Route::get('/estudiante/dashboard', [EstudianteDashboardController::class, 'index'])->name('estudiante.dashboard');
    Route::get('/padre/dashboard', fn() => view('padre.dashboard.index'))->name('padre.dashboard');

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMINISTRADOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

        // Perfil
        Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
        Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');

        // CRUD administradores
        Route::resource('administradores', SuperAdminController::class);

        // Aprobación de usuarios
        Route::post('/usuarios/{id}/aprobar', [UsuarioController::class, 'aprobar'])->name('usuarios.aprobar');
        Route::delete('/usuarios/{id}/rechazar', [UsuarioController::class, 'rechazar'])->name('usuarios.rechazar');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMINISTRADORES REGULARES
    |--------------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::resource('/', AdminController::class);

        // Permisos para padres
        Route::get('/permisos', [PadrePermisoController::class, 'index'])->name('permisos.index');
        Route::get('/permisos/{padre}/configurar', [PadrePermisoController::class, 'configurar'])->name('permisos.configurar');
        Route::post('/permisos/{padre}/guardar', [PadrePermisoController::class, 'guardar'])->name('permisos.guardar');
        Route::get('/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])->name('permisos.defecto');
        Route::delete('/permisos/{padre}/{estudiante}', [PadrePermisoController::class, 'eliminar'])->name('permisos.eliminar');
        Route::post('/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])->name('permisos.toggle');
    });

    /*
    |--------------------------------------------------------------------------
    | ESTUDIANTES
    |--------------------------------------------------------------------------
    */
    Route::get('/buscarregistro', [BuscarEstudianteController::class, 'buscarregistro'])->name('buscarregistro');
    Route::resource('estudiantes', EstudianteController::class);
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');

    /*
    |--------------------------------------------------------------------------
    | PROFESORES
    |--------------------------------------------------------------------------
    */
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

    /*
    |--------------------------------------------------------------------------
    | PADRES
    |--------------------------------------------------------------------------
    */
    Route::resource('padres', PadreController::class);
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/{padre}/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular', [PadreController::class, 'desvincular'])->name('padres.desvincular');

    /*
    |--------------------------------------------------------------------------
    | MATRÍCULAS (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::prefix('matriculas')->name('matriculas.')->group(function () {
        Route::resource('/', MatriculaController::class);
        Route::get('/{matricula}/detalles', [MatriculaController::class, 'detalles'])->name('detalles');
        Route::post('/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('confirmar');
        Route::post('/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('rechazar');
        Route::post('/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])->name('cancelar');
    });

    /*
    |--------------------------------------------------------------------------
    | PERÍODOS ACADÉMICOS
    |--------------------------------------------------------------------------
    */
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    /*
    |--------------------------------------------------------------------------
    | CURSOS / CUPOS MÁXIMOS
    |--------------------------------------------------------------------------
    */
    Route::resource('cupos_maximos', CursoController::class);

    /*
    |--------------------------------------------------------------------------
    | OBSERVACIONES
    |--------------------------------------------------------------------------
    */
    Route::resource('observaciones', ObservacionController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | DOCUMENTOS
    |--------------------------------------------------------------------------
    */
    Route::resource('documentos', DocumentoController::class);

    /*
    |--------------------------------------------------------------------------
    | ACCIONES IMPORTANTES
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
    | MATERIAS Y GRADOS
    |--------------------------------------------------------------------------
    */
    Route::resource('materias', MateriaController::class);
    Route::resource('grados', GradoController::class);

    Route::get('grados/{grado}/asignar-materias', [GradoController::class, 'asignarMaterias'])->name('grados.asignar-materias');
    Route::post('grados/{grado}/guardar-materias', [GradoController::class, 'guardarMaterias'])->name('grados.guardar-materias');

    /*
    |--------------------------------------------------------------------------
    | HORARIOS
    |--------------------------------------------------------------------------
    */
    Route::resource('horarios', HorarioController::class);
    Route::get('horarios/exportar-pdf', [HorarioController::class, 'exportPDF'])->name('horarios.exportPDF');

    /*
    |--------------------------------------------------------------------------
    | ESTUDIANTES (EXCLUSIVO)
    |--------------------------------------------------------------------------
    */
    Route::prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorario'])->name('miHorario');
        Route::get('/matricula', [MatriculaController::class, 'create'])->name('matricula');
        Route::post('/matricula', [MatriculaController::class, 'store'])->name('matricula.store');
        Route::get('/horario', [HorarioController::class, 'horarioEstudiante'])->name('horario');
        Route::get('/calificaciones', [EstudianteController::class, 'misNotas'])->name('calificaciones');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'index'])->name('notificaciones.index');
    });

    /*
    |--------------------------------------------------------------------------
    | PROFESORES (EXCLUSIVO)
    |--------------------------------------------------------------------------
    */
    Route::prefix('profesor')->name('profesor.')->group(function () {
        Route::get('/mi-horario', [HorarioController::class, 'miHorarioProfesor'])->name('miHorario');
        Route::get('/notificaciones', [NotificacionPreferenciaController::class, 'indexProfesor'])->name('notificaciones.index');
    });

    /*
    |--------------------------------------------------------------------------
    | PREFERENCIAS GENERALES DE NOTIFICACIONES
    |--------------------------------------------------------------------------
    */
    Route::get('notificaciones/preferencias', [NotificacionPreferenciaController::class, 'edit'])->name('notificaciones.edit');
    Route::put('notificaciones/preferencias', [NotificacionPreferenciaController::class, 'update'])->name('notificaciones.update');

    /*
    |--------------------------------------------------------------------------
    | CALIFICACIONES DEL PROFESOR
    |--------------------------------------------------------------------------
    */
    Route::get('registrar-calificaciones', [RegistrarCalificacionController::class, 'create'])->name('registrarcalificaciones.create');
    Route::post('registrar-calificaciones', [RegistrarCalificacionController::class, 'store'])->name('registrarcalificaciones.store');
    Route::get('calificaciones', [RegistrarCalificacionController::class, 'index'])->name('registrarcalificaciones.index');
    Route::get('registrar-calificaciones/estudiantes/{curso}', [RegistrarCalificacionController::class, 'obtenerEstudiantes'])
        ->name('registrarcalificaciones.estudiantes');
});
