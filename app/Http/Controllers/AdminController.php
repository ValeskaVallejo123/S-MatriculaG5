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

        // 🔍 Lógica de búsqueda
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
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/' // Solo letras y espacios
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:admins,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:50',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/' // Mayúscula, minúscula, número y carácter especial
            ],
            'permisos' => 'nullable|array',
        ], [
            // Mensajes personalizados
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre no puede exceder 50 caracteres',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Debe ser un email válido',
            'email.unique' => 'Este email ya está registrado',
            'email.max' => 'El email no puede exceder 100 caracteres',
            
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.max' => 'La contraseña no puede exceder 50 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe contener al menos: una mayúscula, una minúscula, un número y un carácter especial (@$!%*?&#)',
        ]);

        Admin::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'permisos' => $validated['permisos'] ?? [],
        ]);

        return redirect()->route('admins.index')
            ->with('success', 'Administrador creado exitosamente');
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