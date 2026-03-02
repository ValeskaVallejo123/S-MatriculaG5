<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Session;

class PadreAuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login-padres');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        // Validar entrada
        $request->validate([
            'identificador' => 'required',
            'password' => 'required',
        ], [
            'identificador.required' => 'Debe ingresar su correo o código de matrícula',
            'password.required' => 'Debe ingresar la contraseña (DNI del estudiante)',
        ]);

        $identificador = $request->identificador;
        $password = $request->password;

        // Buscar solicitud por email o código
        $solicitud = Solicitud::where('email', $identificador)
            ->orWhere('codigo', $identificador)
            ->first();

        // Verificar si existe la solicitud
        if (!$solicitud) {
            return back()->withErrors([
                'identificador' => 'No se encontró ninguna solicitud con ese correo o código.',
            ])->withInput();
        }

        // Verificar la contraseña (DNI del estudiante)
        if (!$solicitud->verificarPassword($password)) {
            return back()->withErrors([
                'password' => 'La contraseña (DNI del estudiante) es incorrecta.',
            ])->withInput();
        }

        // Crear sesión personalizada para el padre
        Session::put('padre_autenticado', true);
        Session::put('solicitud_id', $solicitud->id);
        Session::put('solicitud_codigo', $solicitud->codigo);
        Session::put('padre_email', $solicitud->email);

        // Regenerar sesión por seguridad
        $request->session()->regenerate();

        // Redirigir al dashboard de padres
        return redirect()->route('padres.dashboard')
            ->with('success', 'Bienvenido, puede consultar el estado de su solicitud');
    }

    /**
     * Cerrar sesión del padre
     */
    public function logout(Request $request)
    {
        // Limpiar sesión del padre
        Session::forget('padre_autenticado');
        Session::forget('solicitud_id');
        Session::forget('solicitud_codigo');
        Session::forget('padre_email');

        // Invalidar sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('padres.login')
            ->with('success', 'Sesión cerrada correctamente');
    }
}