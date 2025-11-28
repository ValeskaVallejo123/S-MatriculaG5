<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Permisos disponibles
     */
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

    /**
     * Listar administradores
     */
    public function index(Request $request)
    {
        // id_rol 1 = Super Administrador, 2 = Administrador
        $query = User::whereIn('id_rol', [1, 2]);

        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $query->where(function($q) use ($busqueda) {
                $q->where('user_type', 'LIKE', "%{$busqueda}%") // puedes usar user_type o name si existe
                  ->orWhere('id', 'LIKE', "%{$busqueda}%");
            });
        }

        $admins = $query->orderBy('id_rol', 'asc')
                        ->orderBy('user_type', 'asc') // o name si tienes
                        ->paginate(10)
                        ->appends($request->all());

        $permisos = $this->getAvailablePermissions();

        return view('admins.index', compact('admins', 'permisos'));
    }

    /**
     * Crear nuevo admin
     */
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
            'nombre' => 'required|string|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido' => 'required|string|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'password' => 'required|confirmed|min:8|max:50|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).+$/',
            'permisos' => 'nullable|array',
            'id_rol' => 'required|in:1,2', // 1=Super Admin, 2=Admin
        ]);

        // Generar correo automáticamente
        $email = $this->generarCorreoUnico($validated['nombre'], $validated['apellido']);

        $passwordPlain = $validated['password'];

        $admin = User::create([
            'user_type' => $validated['nombre'] . ' ' . $validated['apellido'],
            'email' => $email,
            'password' => Hash::make($validated['password']),
            'id_rol' => $validated['id_rol'],
            'is_super_admin' => $validated['id_rol'] == 1,
            'permissions' => $validated['permisos'] ?? [],
        ]);

        return redirect()->route('admins.index')->with([
            'success' => 'Administrador creado exitosamente',
            'credentials' => [
                'nombre' => $admin->user_type,
                'email' => $email,
                'password' => $passwordPlain
            ]
        ]);
    }

    public function show($id)
    {
        $admin = User::whereIn('id_rol', [1, 2])->findOrFail($id);
        return view('admins.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = User::whereIn('id_rol', [1, 2])->findOrFail($id);
        $permisos = $this->getAvailablePermissions();

        return view('admins.edit', compact('admin', 'permisos'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::whereIn('id_rol', [1, 2])->findOrFail($id);

        $validated = $request->validate([
            'user_type' => 'required|string|min:3|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'email' => 'required|email|max:100|unique:users,email,' . $admin->id,
            'password' => 'nullable|confirmed|min:8|max:50|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).+$/',
            'permisos' => 'nullable|array',
            'id_rol' => 'required|in:1,2',
        ]);

        $admin->update([
            'user_type' => $validated['user_type'],
            'email' => $validated['email'],
            'id_rol' => $validated['id_rol'],
            'is_super_admin' => $validated['id_rol'] == 1,
            'permissions' => $validated['permisos'] ?? [],
        ]);

        if (!empty($validated['password'])) {
            $admin->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('admins.index')->with('success', 'Administrador actualizado exitosamente');
    }

    public function destroy($id)
    {
        $admin = User::whereIn('id_rol', [1, 2])->findOrFail($id);
        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Administrador eliminado exitosamente');
    }

    // Métodos privados generarCorreoUnico() y limpiarTexto() se mantienen igual
}
