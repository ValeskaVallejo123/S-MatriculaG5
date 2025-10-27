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
use App\Models\User;

// Página principal
Route::get('/', function () {
    return view('plantilla');
});

// login
Route::get('/login', function () {
    return view('login');
})->name('login');

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

// 3️⃣ Mostrar formulario para restablecer contraseña (desde el enlace del correo)
Route::get('/restablecer/{token}', function ($token) {
    return view('recuperarcontrasenia.restablecer', ['token' => $token]);
})->name('password.reset');

// 4️⃣ Procesar el formulario POST de restablecimiento
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
