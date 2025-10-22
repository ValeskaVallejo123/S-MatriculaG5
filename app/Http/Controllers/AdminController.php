<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->paginate(10);
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
            'nombre' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|min:8',
            'permisos' => 'nullable|array',
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
        'nombre' => 'required|string|max:255|min:3',
        'email' => 'required|email|unique:admins,email,' . $admin->id,
        'password' => 'nullable|confirmed|min:8',
        'permisos' => 'nullable|array',
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