<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\BuscarEstudianteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

// ------------------------
// 🔹 LOGIN / REGISTRO
// ------------------------
Route::get('/', function () {
    return view('plantilla');
});

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ------------------------
// 🔹 RUTAS PROTEGIDAS (auth)
// ------------------------
Route::middleware('auth')->group(function () {

    // Paneles
    Route::get('/admin', function () {
        return "¡Accediste al panel de admin!";
    })->middleware('rol:admin');

    Route::get('/estudiante', function () {
        return "¡Accediste al panel de estudiante!";
    })->middleware('rol:estudiante');

    // ------------------------
    // 🔹 Administradores (solo admin)
    // ------------------------
    Route::middleware('rol:admin')->group(function () {
        Route::resource('admins', AdminController::class);
        Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
    });

    // ------------------------
    // 🔹 CRUD principales
    // ------------------------
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);
    Route::resource('observaciones', ObservacionController::class)->except(['show']);
    Route::resource('documentos', DocumentoController::class);
    Route::resource('periodos-academicos', PeriodoAcademicoController::class);

    // ------------------------
    // 🔹 Matriculas estudiantes
    // ------------------------
    Route::middleware('rol:estudiante')->group(function () {
        Route::resource('matriculas', MatriculaController::class)->except(['index']);
    });

    // Confirmación de matrícula
    Route::post('/matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');
    Route::patch('/matriculas/{matricula}/confirmar', [MatriculaController::class, 'confirm'])->name('matriculas.confirm');

    // matricula index y crear matricula
    Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index')->middleware('auth');
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index')->middleware('auth');

   // Rutas de ejemplo para redirección
   Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index')->middleware('auth');
   Route::get('/admins', [AdminController::class, 'index'])->name('admins.index')->middleware('auth');

    // Descargar comprobante
    Route::get('/matriculas/{matricula}/comprobante/descargar', [MatriculaController::class, 'descargarComprobante'])->name('matriculas.descargarComprobante');

    // Buscar estudiante
    Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');

    // Estado de solicitud
    Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('solicitud.verEstado');
    Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);

    // Cambiar contraseña
    Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])->name('cambiarcontrasenia.edit');
    Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])->name('cambiarcontrasenia.update');

    // CUPOS MÁXIMOS
    Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
        Route::get('/', [CursoController::class, 'index'])->name('index');
        Route::get('/create', [CursoController::class, 'create'])->name('create');
        Route::post('/', [CursoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CursoController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
    });
});

// ------------------------
// 🔹 Recuperación de contraseña
// ------------------------
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])->name('password.solicitar');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.enviar');
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.restablecer');
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])->name('password.actualizar');

// Opcional: vista de confirmación
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')->name('password.recuperar');

// ------------------------
// 🔹 Admins manual (opcional si quieres tener los métodos explícitos)
// ------------------------
Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
Route::get('/admins/{admin}', [AdminController::class, 'show'])->name('admins.show');
Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');


// Registro
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Login / Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas según rol
Route::get('/estudiante', function() { return view('matriculas.index'); })->name('matriculas.index');
Route::get('/admin', function() { return view('admins.index'); })->name('admins.index');

Route::middleware(['auth'])->group(function () {

    // ✅ RUTAS PARA ADMINISTRADORES
    Route::resource('admins', AdminController::class);

});

// Rutas de ejemplo para redirección
Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index')->middleware('auth');
Route::get('/admins', [AdminController::class, 'index'])->name('admins.index')->middleware('auth');

//RUTAS DOCUMENTOS
//Route::resource('documentos', DocumentoController::class);
//RUTAS CAMBIAR CONTRASENIA
// Mostrar formulario para cambiar contraseña
Route::get('cambiar-contrasenia', [CambiarContraseniaController::class, 'edit'])
    ->name('cambiarcontrasenia.edit')
    ->middleware('auth');
// Actualizar la contraseña
Route::put('cambiar-contrasenia', [CambiarContraseniaController::class, 'update'])
    ->name('cambiarcontrasenia.update')
    ->middleware('auth');
//rutas observaciones
Route::resource('observaciones', ObservacionController::class)->except(['show']);

//Confirmacion de Matrícula
// Confirmar matrícula
Route::post('/matriculas/{matricula}/confirmar', [App\Http\Controllers\MatriculaController::class, 'confirmar'])->name('matriculas.confirmar');


// 🔐 Recuperación de contraseña

//Mostrar formulario para solicitar enlace de restablecimiento
Route::get('/solicitar', function () {
    return view('recuperarcontrasenia.solicitar');
})->name('password.solicitar');

//Procesar el envío del enlace al correo
Route::post('/solicitar', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->name('password.enviar');

// 3️⃣ Mostrar formulario para restablecer contraseña (desde el enlace del correo)
// Mostrar formulario para restablecer contraseña
Route::get('/restablecer/{token}', function ($token) {
    return view('recuperarcontrasenia.restablecer', ['token' => $token]);
})->name('password.reset');

// 4️⃣ Procesar el formulario POST de restablecimiento
// Procesar el restablecimiento
Route::post('/restablecer', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', 'Tu contraseña ha sido restablecida con éxito.')
        : back()->withErrors(['email' => [__($status)]]);
})->name('password.actualizar');

Route::get('/estudiantes/create', [EstudianteController::class, 'create'])->name('estudiantes.create');


// ------------------------
// 📘 CRUDs principales
// ------------------------
Route::resource('admins', AdminController::class);
Route::resource('estudiantes', EstudianteController::class);
Route::resource('profesores', ProfesorController::class)->parameter('profesores', 'profesor');
Route::resource('matriculas', MatriculaController::class);
Route::get('/', function () {
    return view('plantilla'); // o tu vista principal
});
//muestra la vista de buscar estudiante
Route::get('/estudiantes/buscar', [BuscarEstudianteController::class, 'buscar'])->name('estudiantes.buscar');
//  muestra la vista de buscar solicitud de matricula
Route::get('/estado-solicitud', [SolicitudController::class, 'verEstado'])->name('solicitud.verEstado');
// Ruta para procesar el formulario (POST)
Route::post('/estado-solicitud', [SolicitudController::class, 'consultarPorDNI']);
// definir periodos academicos
Route::resource('periodos-academicos', PeriodoAcademicoController::class);


// Mostrar formulario para solicitar el enlace de recuperación
Route::get('/password/solicitar', [PasswordResetController::class, 'showForgotForm'])
    ->name('password.solicitar');

// Procesar el envío del enlace al correo
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.enviar');

// Mostrar formulario para restablecer contraseña (con token)
Route::get('/password/restablecer/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.restablecer');

// Guardar la nueva contraseña en la base de datos
Route::post('/password/restablecer', [PasswordResetController::class, 'resetPassword'])
    ->name('password.actualizar');

// (Opcional) Vista informativa o de confirmación general
Route::view('/password/recuperar', 'recuperarcontrasenia.recuperar_contrasenia')
    ->name('password.recuperar');

Route::prefix('cupos_maximos')->name('cupos_maximos.')->group(function () {
    Route::get('/', [CursoController::class, 'index'])->name('index');       // Lista de cupos máximos
    Route::get('/create', [CursoController::class, 'create'])->name('create'); // Formulario para crear cupo
    Route::post('/', [CursoController::class, 'store'])->name('store');        // Guardar cupo máximo
    Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');  // Editar cupo
    Route::put('/{id}', [CursoController::class, 'update'])->name('update');   // Actualizar cupo
    Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy'); // Eliminar cupo
});


Route::resource('admins', AdminController::class);
// Correcto si quieres que /admin muestre la lista
Route::get('/admin', [AdminController::class, 'index'])->name('admins.index');

// O si usas resource:
Route::resource('admins', AdminController::class);


Route::resource('admins', AdminController::class);
Route::resource('estudiantes', EstudianteController::class);


Route::resource('profesores', ProfesorController::class)->parameter('profesores', 'profesor');
Route::resource('matriculas', MatriculaController::class);

Route::resource('profesores', ProfesorController::class)->parameters([
    'profesores' => 'profesor'
]);

Route::resource('admins', AdminController::class);




// O si prefieres definirlas manualmente:

Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
Route::get('/admins/{admin}', [AdminController::class, 'show'])->name('admins.show');
Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
