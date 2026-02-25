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
        $matriculasPendientes = Matricula::with(['estudiante', 'padre'])
            ->where('estado', 'pendiente')
            ->latest()
            ->take(10)
            ->get();

        $totalPendientes  = Matricula::where('estado', 'pendiente')->count();
        $totalAprobadas   = Matricula::where('estado', 'aprobada')->count();
        $totalRechazadas  = Matricula::where('estado', 'rechazada')->count();

        return view('superadmin.dashboard', compact(
            'matriculasPendientes',
            'totalPendientes',
            'totalAprobadas',
            'totalRechazadas'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ADMINISTRADORES
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $administradores = User::whereIn('user_type', ['admin', 'super_admin'])
            ->orderBy('is_super_admin', 'desc')
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.index', compact('administradores'));
    }

    public function create()
    {
        $permisos = $this->getAvailablePermissions();
        return view('superadmin.administradores.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'permissions' => 'nullable|array',
        ], [
            'name.required'      => 'El nombre es obligatorio',
            'email.required'     => 'El email es obligatorio',
            'email.email'        => 'El email debe ser válido',
            'email.unique'       => 'Este email ya está registrado',
            'password.required'  => 'La contraseña es obligatoria',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => 'user',
            'user_type'      => 'admin',
            'permissions'    => $request->permissions ?? [],
            'is_super_admin' => false,
            'is_protected'   => false,
        ]);

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador creado exitosamente');
    }

    public function show(User $administrador)
    {
        return view('superadmin.administradores.show', compact('administrador'));
    }

    public function edit(User $administrador)
    {
        if ($administrador->is_protected) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'Este usuario no puede ser editado');
        }

        $permisos = $this->getAvailablePermissions();
        return view('superadmin.administradores.edit', compact('administrador', 'permisos'));
    }

    public function update(Request $request, User $administrador)
    {
        if ($administrador->is_protected) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'Este usuario no puede ser modificado');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($administrador->id)],
            'permissions' => 'nullable|array',
        ]);

        $administrador->name        = $request->name;
        $administrador->email       = $request->email;
        $administrador->permissions = $request->permissions ?? [];
        $administrador->save();

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $administrador->password = Hash::make($request->password);
            $administrador->save();
        }

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador actualizado exitosamente');
    }

    public function destroy(User $administrador)
    {
        if ($administrador->is_protected) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'Este usuario no puede ser eliminado (está protegido)');
        }

        if ($administrador->id === Auth::id()) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'No puedes eliminarte a ti mismo');
        }

        $administrador->delete();

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador eliminado exitosamente');
    }

    /*
    |--------------------------------------------------------------------------
    | PERFIL DEL SUPER ADMIN
    |--------------------------------------------------------------------------
    */

    public function perfil()
    {
        $user = User::findOrFail(Auth::id());
        return view('superadmin.perfil.index', compact('user'));
    }

    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::id())],
        ], [
            'name.required'  => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email'    => 'El email debe ser válido',
            'email.unique'   => 'Este email ya está en uso',
        ]);

        $user        = User::findOrFail(Auth::id());
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente');
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'password.required'         => 'La nueva contraseña es obligatoria',
            'password.min'              => 'La nueva contraseña debe tener al menos 8 caracteres',
            'password.confirmed'        => 'Las contraseñas no coinciden',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente');
    }

    /*
    |--------------------------------------------------------------------------
    | ROLES Y PERMISOS
    |--------------------------------------------------------------------------
    */

    /**
     * Vista de gestión de roles y permisos.
     * Filtra por user_type ya que la columna 'role' siempre es 'user' en la BD.
     */
    public function permisosRoles()
    {
        $permisos = $this->getAvailablePermissions();

        $usuarios = User::whereIn('user_type', ['admin', 'super_admin'])
            ->orderBy('is_super_admin', 'desc')
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.permisos', compact('permisos', 'usuarios'));
    }

    /**
     * Actualizar rol y permisos de un usuario.
     * Actualiza user_type e is_super_admin (no 'role', que siempre es 'user').
     */
    public function actualizarPermisos(Request $request, $userId)
    {
        $request->validate([
            'rol'      => 'required|in:admin,super_admin',
            'permisos' => 'nullable|array',
        ], [
            'rol.required' => 'Debes seleccionar un rol',
            'rol.in'       => 'El rol seleccionado no es válido',
        ]);

        $usuario = User::findOrFail($userId);

        if ($usuario->is_protected) {
            return back()->with('error', 'No se pueden modificar los permisos de este usuario');
        }

        if ($usuario->id === Auth::id()) {
            return back()->with('error', 'No puedes modificar tu propio rol');
        }

        $esSuperAdmin            = $request->rol === 'super_admin';
        $usuario->is_super_admin = $esSuperAdmin;
        $usuario->user_type      = $esSuperAdmin ? 'super_admin' : 'admin';
        $usuario->permissions    = $esSuperAdmin ? [] : ($request->permisos ?? []);
        $usuario->save();

        return back()->with('success', "Rol y permisos actualizados correctamente para {$usuario->name}");
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    private function getAvailablePermissions(): array
    {
        return [
            'gestionar_matriculas'     => 'Gestionar Matrículas',
            'gestionar_estudiantes'    => 'Gestionar Estudiantes',
            'gestionar_profesores'     => 'Gestionar Profesores',
            'gestionar_secciones'      => 'Gestionar Secciones',
            'gestionar_grados'         => 'Gestionar Grados',
            'gestionar_materias'       => 'Gestionar Materias',
            'ver_reportes'             => 'Ver Reportes',
            'gestionar_pagos'          => 'Gestionar Pagos',
            'gestionar_calificaciones' => 'Gestionar Calificaciones',
            'gestionar_asistencias'    => 'Gestionar Asistencias',
            'gestionar_observaciones'  => 'Gestionar Observaciones',
            'gestionar_documentos'     => 'Gestionar Documentos',
            'gestionar_mensajes'       => 'Gestionar Mensajes',
            'gestionar_avisos'         => 'Gestionar Avisos y Comunicados',
        ];
    }
}