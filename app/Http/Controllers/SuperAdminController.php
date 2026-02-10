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
        // Asegúrate de tener 'role' => RoleMiddleware::class en Kernel.php
        $this->middleware(['auth', 'role:super_admin']);
    }

    /**
     * Dashboard principal
     */
    public function dashboard()
    {
        // Obtener las últimas 10 matrículas pendientes
        $matriculasPendientes = Matricula::with(['estudiante', 'padre'])
            ->where('estado', 'pendiente')
            ->latest()
            ->take(10)
            ->get();

            //Contar todas las matriculas por estador
            $totalPendientes = Matricula::where('estado', 'pendiente')->count();
            $totalAprobadas = Matricula::where('estado', 'aprobada')->count();
            $totalRechazadas = Matricula::where('estado', 'rechazada')->count();

        return view('superadmin.dashboard', [
            'matriculasPendientes',
            'totalPendientes',
            'totalAprobadas',
            'totalRechazadas'
        ]);
    }

    /**
     * Listado de administradores (super admin + admin)
     */
    public function index()
    {
        // Obtener administradores (unificado)
        $administradores = User::where(function($query) {
                $query->where('user_type', 'admin')
                      ->orWhere('user_type', 'super_admin')
                      ->orWhere('role', 'admin')
                      ->orWhere('role', 'super_admin')
                      ->orWhere('is_super_admin', true);
            })
            ->orderBy('is_super_admin', 'desc')
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.index', compact('administradores'));
        //Obtener administradores (unificados)
        /*$administradores = User::where('id_rol', [1, 2]) // 1 = superadmin, 2 = admin
            ->orderByRaw("CASE WHEN id_rol = 1 THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.index', compact('administradores'));*/
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
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'permissions' => 'nullable|array',
            'id_rol'      => 'required|in:2', // Solo ADMIN (super admin no se crea por aquí)
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
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           =>'admin',
            'user_type'      =>'admin',
            'id_rol'         => $request->id_rol,
            'permissions'    => $request->permissions ?? [],
            'is_super_admin' => false,
            'is_protected'   => false,
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
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'Este usuario no puede ser editado');
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
                ->with('error', 'Este usuario no puede ser modificado');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($administrador->id)],
            'permissions' => 'nullable|array',
        ]);

        $administrador->name = $request->name;
        $administrador->email = $request->email;
        $administrador->permissions = $request->permissions ?? [];
        $administrador->save();

        // Si se envía contraseña nueva, actualizarla
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);

            $administrador->password = Hash::make($request->password);
            $administrador->save();
        }

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador actualizado exitosamente.');
    }

    /**
     * Eliminar admin
     */
    public function destroy(User $administrador)
    {
        // Verificar si está protegido
        if ($administrador->is_protected) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'Este usuario no puede ser eliminado (está protegido)');
        }

        // No permitir que se elimine a sí mismo
        if ($administrador->id === Auth::id()) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'No puedes eliminarte a ti mismo');
        }

        $administrador->delete();

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador eliminado exitosamente');
    }

    /**
     * Perfil super admin
     */
    public function perfil()
    {
        /*$user = Auth::user();
        return view('superadmin.perfil.index', compact('user'));*/
        $user = User::findOrFail(Auth::id());
        return view('superadmin.perfil.index', compact('user'));
    }

    /**
     * Actualizar perfil
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

        return back()->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Cambiar contraseña
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

        return back()->with('success', 'Contraseña actualizada correctamente');
    }

    /**
     * Vista de permisos para administradores
     */
    public function permisosRoles()
    {
         // Solo obtener usuarios del sistema (tabla users) que sean configurables
        $usuarios = User::where(function($query) {
                // Solo administradores regulares
                $query->where('role', 'admin')
                      ->orWhere('user_type', 'admin')
                      // O super admins no protegidos
                      ->orWhere(function($q) {
                          $q->where(function($q2) {
                              $q2->where('role', 'super_admin')
                                 ->orWhere('user_type', 'super_admin');
                          })
                          ->where('is_protected', 0);
                      });
            })
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.permisos', compact('permisos', 'usuarios'));
    }

    /**
     * Actualizar permisos de un administrador
     */
    public function actualizarPermisos(Request $request, $userId)
    {
        $usuario = User::findOrFail($userId);

        //Proteger al superadmin principal
        if ($usuario->is_protected) {
            return back()->with('error', 'Este usuario no puede modificarse.');
        }

        // Ojo: aquí el formulario debe enviar 'permisos[]'
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
            'gestionar_matriculas'      => 'Gestionar Matrículas',
            'gestionar_estudiantes'     => 'Gestionar Estudiantes',
            'gestionar_profesores'      => 'Gestionar Profesores',
            'gestionar_secciones'       => 'Gestionar Secciones',
            'gestionar_grados'          => 'Gestionar Grados',
            'ver_reportes'              => 'Ver Reportes',
            'gestionar_pagos'           => 'Gestionar Pagos',
            'gestionar_calificaciones'  => 'Gestionar Calificaciones',
            'gestionar_asistencias'     => 'Gestionar Asistencias',
            'gestionar_observaciones'   => 'Gestionar Observaciones',
            'gestionar_documentos'      => 'Gestionar Documentos',
            'gestionar_mensajes'        => 'Gestionar Mensajes',
            'gestionar_avisos'          => 'Gestionar Avisos y Comunicados',
            'configurar_sistema'        => 'Configurar Sistema',
            'administrar_usuarios'      => 'Administrar Usuarios',
            'asignar_roles'             => 'Asignar Roles y Permisos',
            'auditar_actividades'       => 'Auditar Actividades del Sistema',
            'personalizar_perfil'       => 'Personalizar Perfil',
            'cambiar_contraseña'        => 'Cambiar Contraseña',
            'ver_notificaciones'        => 'Ver Notificaciones',
            'gestionar_eventos'         => 'Gestionar Eventos y Calendario',
            'exportar_datos'            => 'Exportar Datos',
            'importar_datos'            => 'Importar Datos',
            'realizar_backup'           => 'Realizar Backup del Sistema',
            'restaurar_backup'          => 'Restaurar Backup del Sistema',
            'monitorizar_rendimiento'   => 'Monitorizar Rendimiento del Sistema',
            'configurar_notificaciones' => 'Configurar Notificaciones',
            'gestionar_roles'           => 'Gestionar Roles',
            'asignar_permisos'          => 'Asignar Permisos',
            'ver_auditorias'            => 'Ver Auditorías',
            'configurar_seguridad'      => 'Configurar Seguridad',
        ];
    }
}
