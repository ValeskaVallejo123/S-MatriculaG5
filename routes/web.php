<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Página principal
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CambiarContraseniaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ObservacionController;

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

Route::get('/', function () {
    return view('plantilla');
});

// ------------------------
// 🔑 LOGIN
// ------------------------
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// registro de usuarios
route::get('/register',function(){
    return view('register');
})->name('register');
route::get('/register',[RegisterController::class,'showRegistrationForm'])->name('register.form');
route::post('/register',[RegisterController::class,'register'])->name('register.post');
// ------------------------
// 🔐 Recuperación de contraseña
// ------------------------

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

// Mostrar formulario para restablecer contraseña
Route::get('/restablecer/{token}', function ($token) {
    return view('recuperarcontrasenia.restablecer', ['token' => $token]);
})->name('password.reset');

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

// ------------------------
// 📘 CRUDs principales
// ------------------------
Route::resource('admins', AdminController::class);
Route::resource('estudiantes', EstudianteController::class);
Route::get('/', function () {
    return view('plantilla'); // o tu vista principal
});


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
Route::resource('estudiantes', EstudianteController::class);


Route::resource('profesores', ProfesorController::class)->parameter('profesores', 'profesor');
Route::resource('matriculas', MatriculaController::class);

Route::resource('profesores', ProfesorController::class)->parameters([
    'profesores' => 'profesor'
]);

Route::resource('admins', AdminController::class);




// O si prefieres definirlas manualmente:
/*
Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
Route::get('/admins/{admin}', [AdminController::class, 'show'])->name('admins.show');
Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
*/
