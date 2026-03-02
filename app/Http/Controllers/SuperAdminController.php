<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            if (auth()->user()->id_rol !== 1) {
                abort(403, 'Solo el Super Administrador puede acceder a esta sección.');
            }
            return $next($request);
        });
    }

    /**
     * Dashboard principal del SuperAdmin
     */
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

    /**
     * Listado de administradores (SuperAdmin + Admin)
     */
    public function index()
    {
        $administradores = User::whereIn('id_rol', [1, 2])
            ->orderByRaw("CASE WHEN id_rol = 1 THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.index', compact('administradores'));
    }

    /**
     * Formulario de creación de administrador
     */
    public function create()
    {
        $permisos = $this->getAvailablePermissions();

        return view('superadmin.administradores.create', compact('permisos'));
    }

    /**
     * Guardar nuevo administrador
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'permissions' => 'nullable|array',
            'id_rol'      => 'required|in:2', // Solo se puede crear Admin (id_rol=2)
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El email es obligatorio.',
            'email.email'        => 'El email debe ser válido.',
            'email.unique'       => 'Este email ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'id_rol'      => 2, // Admin
            'activo'      => 1,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador creado exitosamente.');
    }

    /**
     * Formulario de edición de administrador
     */
    public function edit(User $administrador)
    {
        // No editar SuperAdmin protegido
        if ($administrador->id_rol == 1 && $administrador->id !== Auth::id()) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'Este usuario no puede ser editado.');
        }

        $permisos = $this->getAvailablePermissions();

        return view('superadmin.administradores.edit', compact('administrador', 'permisos'));
    }

    /**
     * Actualizar administrador
     */
    public function update(Request $request, User $administrador): RedirectResponse
    {
        // No modificar otro SuperAdmin
        if ($administrador->id_rol == 1 && $administrador->id !== Auth::id()) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'Este usuario no puede ser modificado.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($administrador->id)],
            'permissions' => 'nullable|array',
        ], [
            'name.required'  => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email'    => 'El email debe ser válido.',
            'email.unique'   => 'Este email ya está en uso.',
        ]);

        $administrador->name        = $request->name;
        $administrador->email       = $request->email;
        $administrador->permissions = $request->permissions ?? [];

        // Actualizar contraseña solo si se envía una nueva
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ], [
                'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ]);

            $administrador->password = Hash::make($request->password);
        }

        $administrador->save();

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador actualizado exitosamente.');
    }

    /**
     * Eliminar administrador
     */
    public function destroy(User $administrador): RedirectResponse
    {
        // No eliminar SuperAdmin
        if ($administrador->id_rol == 1) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'No se puede eliminar un Super Administrador.');
        }

        // No eliminarse a sí mismo
        if ($administrador->id === Auth::id()) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $administrador->delete();

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador eliminado exitosamente.');
    }

    /**
     * Perfil del SuperAdmin
     */
    public function perfil()
    {
        $user = User::findOrFail(Auth::id());

        return view('superadmin.perfil.index', compact('user'));
    }

    /**
     * Actualizar perfil del SuperAdmin
     */
    public function actualizarPerfil(Request $request): RedirectResponse
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::id())],
        ], [
            'name.required'  => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email'    => 'El email debe ser válido.',
            'email.unique'   => 'Este email ya está en uso.',
        ]);

        $user        = User::findOrFail(Auth::id());
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Cambiar contraseña del SuperAdmin
     */
    public function cambiarPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'password.required'         => 'La nueva contraseña es obligatoria.',
            'password.min'              => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'        => 'Las contraseñas no coinciden.',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    /**
     * Vista de gestión de permisos por rol
     */
    public function permisosRoles()
    {
        $permisos = $this->getAvailablePermissions();

        // Solo administradores regulares son configurables (id_rol = 2)
        $usuarios = User::where('id_rol', 2)
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.permisos', compact('permisos', 'usuarios'));
    }

    /**
     * Actualizar permisos de un administrador
     */
    public function actualizarPermisos(Request $request, $userId): RedirectResponse
    {
        $usuario = User::findOrFail($userId);

        // No modificar SuperAdmin
        if ($usuario->id_rol == 1) {
            return back()->with('error', 'No se pueden modificar los permisos del Super Administrador.');
        }

        $usuario->permissions = $request->input('permisos', []);
        $usuario->save();

        return redirect()->route('superadmin.administradores.permisos')
            ->with('success', "Permisos actualizados para {$usuario->name}.");
    }

    /**
     * Lista de permisos disponibles en el sistema
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
