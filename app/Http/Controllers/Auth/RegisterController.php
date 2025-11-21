<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','min:3','max:50','regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => [
                'required',
                'max:100',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    $dominiosPermitidos = [
                        // Dominios institucionales originales
                        'gm.hn',
                        'adm.hn',
                        // Subdominios por rol
                        'padre.gm.hn',
                        'estudiante.gm.hn',
                        'profesor.gm.hn',
                        'admin.gm.hn',
                        // Correos públicos
                        'gmail.com',
                        'yahoo.com',
                        'yahoo.es',
                        'yahoo.com.mx',
                        'hotmail.com',
                        'outlook.com',
                        'outlook.es',
                        'live.com',
                    ];

                    $dominio = substr(strrchr($value, "@"), 1);

                    if (!in_array($dominio, $dominiosPermitidos)) {
                        $fail('Solo se permiten correos institucionales (@gm.hn, @padre.gm.hn, etc.) o correos públicos (Gmail, Yahoo, Hotmail).');
                    }
                },
            ],
            'password' => ['required','confirmed','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Autologin
        Auth::login($user);

        // Redirigir según dominio del correo
        return $this->redirectByEmailDomain($user->email, $user->name);
    }

    /**
     * Redirigir según el dominio del correo electrónico
     */
    protected function redirectByEmailDomain($email, $name)
    {
        $domain = substr(strrchr($email, "@"), 1);

        switch ($domain) {
            case 'gm.hn':
            case 'adm.hn':
            case 'admin.gm.hn':
            case 'padre.gm.hn':
            case 'estudiante.gm.hn':
            case 'profesor.gm.hn':
            case 'gmail.com':
            case 'yahoo.com':
            case 'yahoo.es':
            case 'hotmail.com':
            case 'outlook.com':
            default:
                // Por ahora, todos van a matrículas
                return redirect()->route('matriculas.index')->with('success', '¡Bienvenido, '.$name.'!');
        }
    }
}
