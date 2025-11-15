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


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin autenticación requerida)
|--------------------------------------------------------------------------
*/

// Página principal - Plantilla pública
Route::get('/', function () {
    return view('plantilla');
})->name('home');

// Plantilla alternativa
Route::get('/plantilla', function () {
    return view('plantilla');
})->name('plantilla');

// Consulta de solicitudes (PÚBLICA - cualquiera puede consultar)
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])
    ->name('estado-solicitud');
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
| RECUPERACIÓN DE CONTRASEÑA
|--------------------------------------------------------------------------
*/
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])
    ->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])
    ->name('password.actualizar');
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')
    ->name('password.recuperar');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS - SUPER ADMINISTRADOR
|--------------------------------------------------------------------------
| ⚠️ IMPORTANTE: Estas rutas DEBEN ir ANTES de las rutas de admins
| para evitar conflictos de enrutamiento
*/
Route::middleware(['auth', 'super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Gestión de administradores
    Route::get('/administradores', [SuperAdminController::class, 'index'])->name('administradores.index');
    Route::get('/administradores/crear', [SuperAdminController::class, 'create'])->name('administradores.create');
    Route::get('/administradores/create', [SuperAdminController::class, 'create']); // Ruta alternativa
    Route::post('/administradores', [SuperAdminController::class, 'store'])->name('administradores.store');
    Route::get('/administradores/{administrador}', [SuperAdminController::class, 'show'])->name('administradores.show');
    Route::get('/administradores/{administrador}/editar', [SuperAdminController::class, 'edit'])->name('administradores.edit');
    Route::get('/administradores/{administrador}/edit', [SuperAdminController::class, 'edit']); // Ruta alternativa
    Route::put('/administradores/{administrador}', [SuperAdminController::class, 'update'])->name('administradores.update');
    Route::patch('/administradores/{administrador}', [SuperAdminController::class, 'update']);
    Route::delete('/administradores/{administrador}', [SuperAdminController::class, 'destroy'])->name('administradores.destroy');
    
    // Perfil de super admin
    Route::get('/perfil', [SuperAdminController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [SuperAdminController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::put('/perfil/password', [SuperAdminController::class, 'cambiarPassword'])->name('perfil.password');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Autenticación)
|--------------------------------------------------------------------------
| Accesible para admins regulares y super admins
*/
Route::middleware(['auth'])->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    /*
    |--------------------------------------------------------------------------
    | PANEL DE ADMINISTRADORES REGULARES
    |--------------------------------------------------------------------------
    */
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/crear', [AdminController::class, 'create'])->name('create');
        Route::get('/create', [AdminController::class, 'create']); // Ruta alternativa
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/editar', [AdminController::class, 'edit'])->name('edit');
        Route::get('/{admin}/edit', [AdminController::class, 'edit']); // Ruta alternativa
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::patch('/{admin}', [AdminController::class, 'update']);
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ESTUDIANTES
    |--------------------------------------------------------------------------
    */
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])
        ->name('estudiantes.buscar');
    Route::resource('estudiantes', EstudianteController::class);
    
    // Dashboard de estudiantes
    Route::get('/estudiantes-dashboard', function () {
        return view('estudiantes.dashboard');
    })->name('estudiantes.dashboard');

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE PROFESORES
    |--------------------------------------------------------------------------
    */
    Route::resource('profesores', ProfesorController::class)->parameter('profesores', 'profesor');

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE MATRÍCULAS
    |--------------------------------------------------------------------------
    */
    Route::resource('matriculas', MatriculaController::class);
    Route::post('/matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])
        ->name('matriculas.confirmar');

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
    | CAMBIAR CONTRASEÑA
    |--------------------------------------------------------------------------
    */
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])
        ->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])
        ->name('cambiarcontrasenia.update');
});

// Ruta para mostrar el formulario de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Ruta para procesar el login
Route::post('/login', [LoginController::class, 'login']);

// Ruta para logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Rutas del Super Admin (protegidas)
Route::middleware(['auth', 'super_admin'])->prefix('superadmin')->group(function () {
    
    // Perfil del Super Admin
    Route::get('/perfil', function() {
        return view('superadmin.perfil');
    })->name('superadmin.perfil');

    });

    // Rutas de Matrículas (protegidas por autenticación)
Route::middleware(['auth'])->group(function () {
    Route::resource('matriculas', MatriculaController::class);
});

Route::middleware(['auth'])->group(function () {
    
    // Rutas resource de matrículas
    Route::resource('matriculas', MatriculaController::class);
    
    // Rutas adicionales para cambiar estados
    Route::post('matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])
        ->name('matriculas.confirmar');
    
    Route::post('matriculas/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])
        ->name('matriculas.rechazar');
    
    Route::post('matriculas/{matricula}/cancelar', [MatriculaController::class, 'cancelar'])
        ->name('matriculas.cancelar');
});

Route::middleware(['auth'])->group(function () {
    // Ruta para crear matrícula
    Route::get('matriculas/create', [MatriculaController::class, 'create'])->name('matriculas.create');
});

Route::get('/dashboard', function () {
    return view('plantilla');
})->middleware('auth')->name('dashboard');

// Dashboard Super Admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Dashboard Super Administrador (requiere autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/superadmin/dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard');
});
Route::get('/profesores/dashboard', [ProfesorController::class, 'index'])->name('profesores.dashboard');


// Grupo de rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    
    // Índice de gestión de permisos
    Route::get('/admins/permisos', [PadrePermisoController::class, 'index'])
        ->name('admins.permisos.index');
    
    // Configurar permisos de un padre específico
    Route::get('/admins/permisos/{padre}/configurar', [PadrePermisoController::class, 'configurar'])
        ->name('admins.permisos.configurar');
    
    // Guardar configuración de permisos
    Route::post('/admins/permisos/{padre}/guardar', [PadrePermisoController::class, 'guardar'])
        ->name('admins.permisos.guardar');
    
    // Establecer permisos por defecto
    Route::get('/admins/permisos/{padre}/{estudiante}/defecto', [PadrePermisoController::class, 'establecerDefecto'])
        ->name('admins.permisos.defecto');
    
    // Eliminar configuración de permisos
    Route::delete('/admins/permisos/{padre}/{estudiante}', [PadrePermisoController::class, 'eliminar'])
        ->name('admins.permisos.eliminar');
    
    // Activar/Desactivar todos los permisos
    Route::post('/admins/permisos/{padre}/{estudiante}/toggle', [PadrePermisoController::class, 'toggleTodos'])
        ->name('admins.permisos.toggle');
});

// Dashboards por rol
Route::middleware(['auth'])->group(function () {
    
    // Dashboard de Padres
    Route::get('/padres/dashboard', function() {
        return view('padres.dashboard');
    })->name('padres.dashboard');
    
    // Dashboard de Estudiantes
    Route::get('/estudiantes/dashboard', function() {
        return view('estudiantes.dashboard');
    })->name('estudiantes.dashboard');
    
    // Dashboard de Profesores
    Route::get('/profesores/dashboard', function() {
        return view('profesores.dashboard');
    })->name('profesores.dashboard');
    
    // Dashboard de Admins (si no existe)
    Route::get('/admin/dashboard', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Home general (para correos públicos)
    Route::get('/home', function() {
        return redirect()->route('matriculas.index');
    })->name('home');
    
});

Route::middleware(['auth'])->group(function () {
    
    // Búsqueda y vinculación de padres
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    
   
Route::get('/padres/buscar', [PadreController::class, 'buscar']);
});

Route::middleware(['auth'])->group(function () {
    
    //  IMPORTANTE: Rutas personalizadas ANTES del resource
    Route::get('/padres/buscar', [PadreController::class, 'buscar'])->name('padres.buscar');
    Route::post('/padres/vincular', [PadreController::class, 'vincular'])->name('padres.vincular');
    Route::post('/padres/desvincular', [PadreController::class, 'desvincular'])->name('padres.desvincular');
    
    // CRUD de Padres (esto debe ir DESPUÉS de las rutas personalizadas)
    Route::resource('padres', PadreController::class);
    
});
