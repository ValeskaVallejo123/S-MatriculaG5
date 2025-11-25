<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Procesa la solicitud de registro de un nuevo usuario.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Nombre: Alfanumérico, tildes y ñ. Mínimo 3, Máximo 50.
            'name' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => [
                'required',
                'max:100',
                'unique:users,email',
                // Validación de dominios usando el método de la clase
                function ($attribute, $value, $fail) {
                    $dominiosPermitidos = $this->getAcceptedDomains();
                    $dominio = substr(strrchr($value, "@"), 1);

                    if (!in_array($dominio, $dominiosPermitidos)) {
                        $fail('Solo se permiten correos institucionales (@egm.edu.hn, etc.) o correos públicos (Gmail, Yahoo, Hotmail, etc.).');
                    }
                },
            ],
            // Contraseña: Mínimo 8, confirmada, debe tener mayúscula, minúscula, número y carácter especial.
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.regex' => 'El nombre solo debe contener letras, tildes y espacios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
        ]);

        // 1. Determinar el rol basado en el dominio del correo
        $rol = $this->getRoleFromEmail($validated['email']);

        // 2. Crear usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol' => $rol, // Asegúrate de que el campo 'rol' exista en tu tabla 'users'
        ]);

        // 3. Autenticar el usuario recién registrado
        Auth::login($user);

        // 4. Redirigir al dashboard correspondiente
        return $this->redirectAfterRegistration($user->email, $user->name, $rol);
    }

    /**
     * Define los dominios de correo electrónico aceptados para el registro.
     */
    protected function getAcceptedDomains(): array
    {
        return [
            // Dominios institucionales (EGM)
            'egm.edu.hn',
            'admin.egm.edu.hn',
            'profesor.egm.edu.hn',
            'padre.egm.edu.hn',
            'estudiante.egm.edu.hn',

            // Correos públicos comunes
            'gmail.com',
            'yahoo.com',
            'yahoo.es',
            'yahoo.com.mx',
            'hotmail.com',
            'outlook.com',
            'outlook.es',
            'live.com',
        ];
    }

    /**
     * Determina el rol del usuario basándose en el dominio del correo electrónico.
     */
    protected function getRoleFromEmail(string $email): string
    {
        $domain = substr(strrchr($email, "@"), 1);

        switch ($domain) {
            case 'egm.edu.hn':
            case 'admin.egm.edu.hn':
                return 'admin'; // Incluye super_admin si no hay un dominio específico para SA
            case 'profesor.egm.edu.hn':
                return 'profesor';
            case 'padre.egm.edu.hn':
                return 'padre';
            case 'estudiante.egm.edu.hn':
                return 'estudiante';
            // Para correos públicos, se asigna el rol 'padre' por defecto (o el que decidas)
            default:
                return 'padre';
        }
    }

    /**
     * Redirige al usuario después del registro según su rol.
     */
    protected function redirectAfterRegistration(string $email, string $name, string $rol): RedirectResponse
    {
        $successMessage = '¡Registro exitoso! Bienvenido/a, ' . $name . '.';

        switch ($rol) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', $successMessage);

            case 'profesor':
                return redirect()->route('profesores.dashboard')->with('success', $successMessage);

            case 'padre':
                return redirect()->route('padres.dashboard')->with('success', $successMessage);

            case 'estudiante':
                return redirect()->route('estudiantes.dashboard')->with('success', $successMessage);

            default:
                // Fallback general para cualquier otro caso
                return redirect()->route('dashboard')->with('success', $successMessage);
        }
    }
}