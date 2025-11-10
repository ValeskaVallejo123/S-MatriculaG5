<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::query();

        //  Lógica de búsqueda
        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            
            $query->where(function($q) use ($busqueda) {
                $q->where('nombre', 'LIKE', "%{$busqueda}%")
                  ->orWhere('email', 'LIKE', "%{$busqueda}%");
            });
        }

        // Ordenar y paginar
        $admins = $query->latest()
                       ->paginate(10)
                       ->appends($request->all()); // Mantiene parámetros en paginación

        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        $permisos = [
            'usuarios' => 'Gestionar Usuarios',
            'estudiantes' => 'Gestionar Estudiantes',
            'profesores' => 'Gestionar Profesores',
            'cursos' => 'Gestionar Cursos',
            'calificaciones' => 'Gestionar Calificaciones',
            'reportes' => 'Generar Reportes',
            'configuracion' => 'Configuración del Sistema'
        ];
        
        return view('admins.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'apellido' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:50',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ],
            'permisos' => 'nullable|array',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre no puede exceder 50 caracteres',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            
            'apellido.required' => 'El apellido es obligatorio',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres',
            'apellido.max' => 'El apellido no puede exceder 50 caracteres',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios',
            
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.max' => 'La contraseña no puede exceder 50 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe contener al menos: una mayúscula, una minúscula, un número y un carácter especial (@$!%*?&#)',
        ]);

        // Generar correo automáticamente
        $email = $this->generarCorreoUnico($validated['nombre'], $validated['apellido']);

        // Guardar la contraseña en texto plano temporalmente para mostrarla
        $passwordPlain = $validated['password'];

        $admin = Admin::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $email,
            'password' => Hash::make($validated['password']),
            'permisos' => $validated['permisos'] ?? [],
        ]);

        // Guardar credenciales en sesión para mostrarlas después
        return redirect()->route('admins.index')
            ->with([
                'success' => 'Administrador creado exitosamente',
                'credentials' => [
                    'nombre' => $admin->nombre . ' ' . $admin->apellido,
                    'email' => $email,
                    'password' => $passwordPlain
                ]
            ]);
    }

    /**
     * Generar correo único en formato: primernombre.primerapellido@admin.edu
     * Si existe duplicado, agregar letra del segundo apellido
     */
    private function generarCorreoUnico($nombreCompleto, $apellidoCompleto)
    {
        // Separar nombres y apellidos
        $nombres = explode(' ', trim($nombreCompleto));
        $apellidos = explode(' ', trim($apellidoCompleto));

        // Tomar primer nombre y primer apellido
        $primerNombre = $this->limpiarTexto($nombres[0]);
        $primerApellido = $this->limpiarTexto($apellidos[0]);

        // Correo base
        $correoBase = strtolower("{$primerNombre}.{$primerApellido}");
        $correo = "{$correoBase}@admin.edu";

        // Verificar si existe
        $contador = 1;
        while (Admin::where('email', $correo)->exists()) {
            // Si hay segundo apellido, usar primera letra
            if (isset($apellidos[1]) && $contador == 1) {
                $segundaLetra = strtolower(substr($this->limpiarTexto($apellidos[1]), 0, 1));
                $correo = "{$correoBase}{$segundaLetra}@admin.edu";
                $contador++;
            } else {
                // Si sigue habiendo duplicados, agregar número
                $correo = "{$correoBase}{$contador}@admin.edu";
                $contador++;
            }
        }

        return $correo;
    }

    /**
     * Limpiar texto: quitar acentos y caracteres especiales
     */
    private function limpiarTexto($texto)
    {
        // Convertir a minúsculas
        $texto = strtolower($texto);
        
        // Quitar acentos
        $texto = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n', 'a', 'e', 'i', 'o', 'u', 'n'],
            $texto
        );
        
        // Quitar todo excepto letras y números
        $texto = preg_replace('/[^a-z0-9]/', '', $texto);
        
        return $texto;
    }

    public function show(Admin $admin)
    {
        return view('admins.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        $permisos = [
            'usuarios' => 'Gestionar Usuarios',
            'estudiantes' => 'Gestionar Estudiantes',
            'profesores' => 'Gestionar Profesores',
            'cursos' => 'Gestionar Cursos',
            'calificaciones' => 'Gestionar Calificaciones',
            'reportes' => 'Generar Reportes',
            'configuracion' => 'Configuración del Sistema'
        ];
        
        return view('admins.edit', compact('admin', 'permisos'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'apellido' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:admins,email,' . $admin->id,
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'nullable',
                'confirmed',
                'min:8',
                'max:50',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ],
            'permisos' => 'nullable|array',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre no puede exceder 50 caracteres',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            
            'apellido.required' => 'El apellido es obligatorio',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres',
            'apellido.max' => 'El apellido no puede exceder 50 caracteres',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios',
            
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Debe ser un email válido',
            'email.unique' => 'Este email ya está registrado',
            'email.max' => 'El email no puede exceder 100 caracteres',
            
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.max' => 'La contraseña no puede exceder 50 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe contener al menos: una mayúscula, una minúscula, un número y un carácter especial (@$!%*?&#)',
        ]);

        $admin->update([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'permisos' => $validated['permisos'] ?? [],
        ]);

        if (!empty($validated['password'])) {
            $admin->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        return redirect()->route('admins.index')
            ->with('success', 'Administrador actualizado exitosamente');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admins.index')
            ->with('success', 'Administrador eliminado exitosamente');
    }
}