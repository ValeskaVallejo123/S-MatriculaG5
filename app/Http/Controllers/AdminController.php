<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
private function getAvailablePermissions()
{
    return [
        'gestionar_matriculas' => 'Gestionar Matrículas',
        'gestionar_estudiantes' => 'Gestionar Estudiantes',
        'gestionar_profesores' => 'Gestionar Profesores',
        'gestionar_secciones' => 'Gestionar Secciones',
        'gestionar_grados' => 'Gestionar Grados',
        'ver_reportes' => 'Ver Reportes',
        'gestionar_pagos' => 'Gestionar Pagos',
        'gestionar_calificaciones' => 'Gestionar Calificaciones',
        'gestionar_asistencias' => 'Gestionar Asistencias',
        'gestionar_observaciones' => 'Gestionar Observaciones',
        'gestionar_documentos' => 'Gestionar Documentos',
        'gestionar_mensajes' => 'Gestionar Mensajes',
        'gestionar_avisos' => 'Gestionar Avisos y Comunicados',
    ];
}

public function index(Request $request)
{
    $query = User::whereIn('role', ['admin', 'super_admin']);

    if ($request->filled('busqueda')) {
        $busqueda = $request->input('busqueda');
        
        $query->where(function($q) use ($busqueda) {
            $q->where('name', 'LIKE', "%{$busqueda}%")
              ->orWhere('email', 'LIKE', "%{$busqueda}%");
        });
    }

    $admins = $query->orderBy('is_super_admin', 'desc')
                   ->orderBy('name', 'asc')
                   ->paginate(10)
                   ->appends($request->all());

    $permisos = $this->getAvailablePermissions();

    return view('admins.index', compact('admins', 'permisos'));
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
            'role' => 'required|in:admin,super_admin',
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

        $admin = User::create([
            'name' => $validated['nombre'] . ' ' . $validated['apellido'],
            'email' => $email,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'admin',
            'is_super_admin' => ($validated['role'] ?? 'admin') === 'super_admin',
            'permissions' => $validated['permisos'] ?? [],
        ]);

        // Guardar credenciales en sesión para mostrarlas después
        return redirect()->route('admins.index')
            ->with([
                'success' => 'Administrador creado exitosamente',
                'credentials' => [
                    'nombre' => $admin->name,
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
        while (User::where('email', $correo)->exists()) {
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

    public function show($id)
    {
        $admin = User::where('role', 'admin')
                    ->orWhere('role', 'super_admin')
                    ->findOrFail($id);
        
        return view('admins.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = User::where('role', 'admin')
                    ->orWhere('role', 'super_admin')
                    ->findOrFail($id);
        
        $permisos = [
            'usuarios' => 'Gestionar Usuarios',
            'estudiantes' => 'Gestionar Estudiantes',
            'profesores' => 'Gestionar Profesores',
            'cursos' => 'Gestionar Cursos',
            'calificaciones' => 'Gestionar Calificaciones',
            'reportes' => 'Generar Reportes',
            'configuracion' => 'Configuración del Sistema',
            'crear' => 'Crear usuarios',
            'editar' => 'Editar usuarios',
            'eliminar' => 'Eliminar usuarios',
        ];
        
        return view('admins.edit', compact('admin', 'permisos'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')
                    ->orWhere('role', 'super_admin')
                    ->findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email,' . $admin->id,
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
            'role' => 'required|in:admin,super_admin',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'name.max' => 'El nombre no puede exceder 100 caracteres',
            'name.regex' => 'El nombre solo puede contener letras y espacios',
            
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
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'is_super_admin' => $validated['role'] === 'super_admin',
            'permissions' => $validated['permisos'] ?? [],
        ]);

        if (!empty($validated['password'])) {
            $admin->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        return redirect()->route('admins.index')
            ->with('success', 'Administrador actualizado exitosamente');
    }

    public function destroy($id)
    {
        $admin = User::where('role', 'admin')
                    ->orWhere('role', 'super_admin')
                    ->findOrFail($id);
        
        $admin->delete();

        return redirect()->route('admins.index')
            ->with('success', 'Administrador eliminado exitosamente');
    }

   public function permisosRoles()
{
    $permisos = $this->getAvailablePermissions();
    
    // Obtener usuarios configurables: admin, profesor, padre, y super_admin no protegidos
    $usuarios = User::where(function($query) {
            // Usuarios con rol admin, profesor o padre
            $query->whereIn('role', ['admin', 'profesor', 'padre'])
                  // O super admins que no estén protegidos
                  ->orWhere(function($q) {
                      $q->where('role', 'super_admin')
                        ->where('is_protected', 0);
                  });
        })
        ->orderBy('role')
        ->orderBy('name')
        ->get();
    
    return view('superadmin.administradores.permisos', compact('permisos', 'usuarios'));
}
}