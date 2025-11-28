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
    public function __construct()
    {
        // Solo super admin puede manejar administradores
        $this->middleware(['auth', 'rol:super_admin']);
    }

    /**
     * Dashboard principal
     */
    public function dashboard()
    {
        $matriculasPendientes = Matricula::with(['estudiante', 'padre'])
            ->where('estado', 'pendiente')
            ->latest()
            ->take(10)
            ->get();

        return view('superadmin.dashboard', [
            'matriculasPendientes' => $matriculasPendientes,
            'totalPendientes'      => Matricula::where('estado', 'pendiente')->count(),
            'totalAprobadas'       => Matricula::where('estado', 'aprobada')->count(),
            'totalRechazadas'      => Matricula::where('estado', 'rechazada')->count(),
        ]);
    }

    /**
     * Listado de administradores
     */
    public function index()
    {
        $administradores = User::whereIn('id_rol', [1, 2]) // 1 = superadmin, 2 = admin
            ->orderByRaw("CASE WHEN id_rol = 1 THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.index', compact('administradores'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $permisos = $this->getAvailablePermissions();
        return view('superadmin.administradores.create', compact('permisos'));
    }

    /**
     * Guardar un nuevo administrador
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8|confirmed',
            'permissions'=> 'nullable|array',
            'id_rol'     => 'required|in:2', // Solo ADMIN (super admin no se crea por aquí)
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'id_rol'        => $request->id_rol,
            'permissions'   => $request->permissions ?? [],
            'is_super_admin'=> false,
            'is_protected'  => false,
        ]);

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador creado exitosamente.');
    }

    /**
     * Editar administrador
     */
    public function edit(User $administrador)
    {
        if ($administrador->is_protected) {
            return back()->with('error', 'Este usuario no puede editarse.');
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
            return back()->with('error', 'Este usuario no puede modificarse.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => ['required','email', Rule::unique('users')->ignore($administrador->id)],
            'permissions' => 'nullable|array',
        ]);

        $administrador->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'permissions' => $request->permissions ?? [],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);

            $administrador->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador actualizado exitosamente.');
    }

    /**
     * Eliminar admin
     */
    public function destroy(User $administrador)
    {
        if ($administrador->is_protected || $administrador->id_rol == 1) {
            return back()->with('error', 'Este usuario no puede eliminarse.');
        }

        $administrador->delete();

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador eliminado.');
    }

    /**
     * Perfil super admin
     */
    public function perfil()
    {
        $user = Auth::user();
        return view('superadmin.perfil.index', compact('user'));
    }

    /**
     * Actualizar perfil
     */
    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required','email', Rule::unique('users')->ignore(Auth::id())],
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return back()->with('success', 'Perfil actualizado.');
    }

    /**
     * Cambiar contraseña
     */
    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'La contraseña actual es incorrecta'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Contraseña actualizada.');
    }

    /**
     * Vista de permisos para administradores
     */
    public function permisosRoles()
    {
        $permisos = $this->getAvailablePermissions();

        $usuarios = User::where('id_rol', 2)
            ->where('is_protected', 0)
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.permisos', compact('permisos', 'usuarios'));
    }

    /**
     * Actualizar permisos
     */
    public function actualizarPermisos(Request $request, $userId)
    {
        $usuario = User::findOrFail($userId);

        if ($usuario->is_protected) {
            return back()->with('error', 'Este usuario no puede modificarse.');
        }

        $usuario->permissions = $request->permisos ?? [];
        $usuario->save();

        return redirect()->route('superadmin.administradores.permisos')
            ->with('success', "Permisos actualizados para {$usuario->name}");
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
}
