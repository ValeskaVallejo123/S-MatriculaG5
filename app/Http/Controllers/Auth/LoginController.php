<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        Log::info('=== INICIO LOGIN ===');
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $usuario = User::where('email', $request->email)->first();

        if (!$usuario) {
            Log::info('Usuario no encontrado: ' . $request->email);
            return back()->withErrors(['email' => 'Usuario no encontrado.'])->onlyInput('email');
        }

        Log::info('Usuario encontrado', ['email' => $usuario->email, 'id' => $usuario->id]);

        if (!$usuario->rol_id && !$usuario->id_rol) {
            Log::error('Sin rol asignado');
            return back()->withErrors(['email' => 'Sin rol asignado.'])->onlyInput('email');
        }

        if (!Auth::attempt($credentials, $request->filled('remember'))) {
            Log::error('Credenciales incorrectas');
            return back()->withErrors(['email' => 'Credenciales incorrectas.'])->onlyInput('email');
        }

        Log::info('Autenticación exitosa');

        $request->session()->regenerate();
        $usuario = Auth::user();

        Log::info('Verificando activo', [
            'activo' => $usuario->activo,
            'user_type' => $usuario->user_type,
        ]);

        if (isset($usuario->activo) && !$usuario->activo) {
            
            $esPadre = ($usuario->user_type === 'padre') || 
                       ($usuario->rol && strtolower($usuario->rol->nombre) === 'padre');

            Log::info('Usuario inactivo, esPadre: ' . ($esPadre ? 'SI' : 'NO'));

            if ($esPadre) {
                Log::info('Activando padre');
                DB::table('users')->where('id', $usuario->id)->update(['activo' => 1]);
                Log::info('Padre activado');
            } else {
                Log::warning('Usuario bloqueado');
                Auth::logout();
                return back()->withErrors(['email' => 'Cuenta pendiente de aprobación.'])->onlyInput('email');
            }
        }

        Log::info('Redirigiendo');
        return $this->redirectBasedOnRole($usuario);
    }

    private function redirectBasedOnRole($usuario)
    {
        if ($usuario->rol) {
            switch ($usuario->rol->nombre) {
                case 'Super Administrador':
                    return redirect()->route('superadmin.dashboard');
                case 'Administrador':
                    return redirect()->route('admin.dashboard');
                case 'Profesor':
                    return redirect()->route('profesor.dashboard');
                case 'Estudiante':
                    return redirect()->route('estudiante.dashboard');
                case 'Padre':
                    return redirect()->route('padre.dashboard');
            }
        }

        Auth::logout();
        return back()->withErrors(['email' => 'Rol no reconocido.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}