<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        // Obtener matrículas pendientes (más recientes primero)
        $matriculasPendientes = Matricula::with(['estudiante', 'padre'])
            ->where('estado', 'pendiente')
            ->latest()
            ->take(10)
            ->get();

        // Contar todas las matrículas por estado
        $totalPendientes = Matricula::where('estado', 'pendiente')->count();
        $totalAprobadas = Matricula::where('estado', 'aprobada')->count();
        $totalRechazadas = Matricula::where('estado', 'rechazada')->count();

        return view('superadmin.dashboard', compact(
            'matriculasPendientes',
            'totalPendientes',
            'totalAprobadas',
            'totalRechazadas'
        ));
    }

    public function index()
    {
        $administradores = User::whereIn('rol', ['admin', 'super_admin'])
            ->orderBy('is_super_admin', 'desc')
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.index', compact('administradores'));
    }

    /**
     * Mostrar formulario para crear nuevo administrador
     */
    public function create()
    {
        $permisos = $this->getAvailablePermissions();
        return view('superadmin.administradores.create', compact('permisos'));
    }

    /**
     * Guardar nuevo administrador
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'permissions' => 'nullable|array',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'admin',
            'permissions' => $request->permissions ?? [],
            'is_super_admin' => false,
            'is_protected' => false,
        ]);

        return redirect()->route('superadmin.administradores.index')
            ->with('success', ' Administrador creado exitosamente');
    }

    /**
     * Mostrar formulario para editar administrador
     */
    public function edit(User $administrador)
    {
        // Proteger al super admin de ser editado
        if ($administrador->is_protected) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', ' Este usuario no puede ser editado');
        }

        $permisos = $this->getAvailablePermissions();
        return view('superadmin.administradores.edit', compact('administrador', 'permisos'));
    }

    /**
     * Actualizar administrador
     */
    public function update(Request $request, User $administrador)
    {
        if ($administrador->is_protected) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', ' Este usuario no puede ser modificado');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($administrador->id)],
            'permissions' => 'nullable|array',
        ]);

        $administrador->name = $request->name;
        $administrador->email = $request->email;
        $administrador->permissions = $request->permissions ?? [];
        $administrador->save();

        // Si se proporciona una nueva contraseña
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);

            $administrador->password = Hash::make($request->password);
            $administrador->save();
        }

        return redirect()->route('superadmin.administradores.index')
            ->with('success', ' Administrador actualizado exitosamente');
    }

    /**
     * Eliminar administrador
     */
    public function destroy(User $administrador)
    {
        if (!$administrador->canBeDeleted()) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', '⚠️ Este usuario no puede ser eliminado');
        }

        $administrador->delete();

        return redirect()->route('superadmin.administradores.index')
            ->with('success', ' Administrador eliminado exitosamente');
    }

    /**
     * Mostrar perfil del Super Admin
     */
    public function perfil()
    {
        $user = User::findOrFail(Auth::id());
        return view('superadmin.perfil.index', compact('user'));
    }

    /**
     * Actualizar información del perfil
     */
    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::id())],
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está en uso',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', ' Perfil actualizado correctamente');
    }

    /**
     * Cambiar contraseña del Super Admin
     */
    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'password.required' => 'La nueva contraseña es obligatoria',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        $user = User::findOrFail(Auth::id());

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', ' Contraseña actualizada correctamente');
    }

    /**
     * Permisos disponibles en el sistema
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
        ];
    }
}
