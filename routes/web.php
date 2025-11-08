<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarioController;

// 🔹 RUTA PRINCIPAL
Route::get('/', function () {
    return view('plantilla');
});

// 🔹 REGISTRO
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// 🔹 LOGIN / LOGOUT
Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔹 RUTAS PROTEGIDAS
Route::middleware('auth')->group(function () {

    // CRUDs principales
    Route::resource('admins', AdminController::class);
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);
    Route::resource('matriculas', MatriculaController::class);
    Route::resource('observaciones', ObservacionController::class)->except(['show']);
    Route::resource('documentos', DocumentoController::class);

    // Confirmación de matrícula
    Route::post('/matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');

    // Buscar estudiante
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');

    // Estado de solicitud de matrícula
    Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('solicitud.verEstado');
    Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

    // Periodos académicos
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    // CUPOS MÁXIMOS
    Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
        Route::get('/', [CursoController::class, 'index'])->name('index');
        Route::get('/create', [CursoController::class, 'create'])->name('create');
        Route::post('/', [CursoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CursoController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
    });

    // Cambiar contraseña
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');
});

// 🔐 RECUPERACIÓN DE CONTRASEÑA
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');

Route::get('/matriculas/create', [MatriculaController::class, 'create'])->name('matriculas.create');
Route::post('/matriculas', [MatriculaController::class, 'store'])->name('matriculas.store');
Route::get('/matriculas', [MatriculaController::class, 'index'])->middleware('rol:admin');


Route::middleware(['auth', 'rol:admin'])->group(function () {
    Route::resource('admins', AdminController::class);
});

Route::middleware(['auth', 'rol:estudiante'])->group(function () {
    Route::resource('matriculas', MatriculaController::class);
});

Route::get('/admin', function () {
    return "¡Accediste al panel de admin!";
})->middleware('rol:admin');
Route::get('/estudiante', function () {
    return "¡Accediste al panel de estudiante!";
})->middleware('rol:estudiante');

Route::get('/matriculas', function () {
    return "Bienvenido a matriculas";
})->middleware('rol:admin');

Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');// Agregar al final del archivo o dentro del grupo middleware auth
Route::resource('grados', GradoController::class);
Route::resource('ciclos', CicloController::class);use App\Http\Controllers\CalificacionController;

// routes/web.php

// Asegúrate de que el parámetro esperado por la ruta resource sea 'calificacion' (singular correcto),
// en lugar de la singularización incorrecta 'calificacione' que está usando.
Route::resource('calificaciones', CalificacionController::class)->parameters([
    'calificaciones' => 'calificacion', // <--- Usa 'calificacion' (singular)
]);


// Rutas del calendario académico
Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
Route::get('/calendario/eventos', [CalendarioController::class, 'obtenerEventos'])->name('calendario.eventos');
Route::post('/calendario/eventos', [CalendarioController::class, 'guardar'])->name('calendario.guardar');
Route::put('/calendario/eventos/{evento}', [CalendarioController::class, 'actualizar'])->name('calendario.actualizar');
Route::delete('/calendario/eventos/{evento}', [CalendarioController::class, 'eliminar'])->name('calendario.eliminar');




Route::get('/plantilla', function () {
    return view('plantilla'); // o la vista que necesites
})->name('plantilla');