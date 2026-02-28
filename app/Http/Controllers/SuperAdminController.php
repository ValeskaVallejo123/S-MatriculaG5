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
        return view('superadmin.administradores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'role'        => 'required|in:super_admin,admin',
            'permissions' => 'nullable|array',
            'is_protected' => 'nullable|boolean',
        ], [
            'name.required'      => 'El nombre es obligatorio',
            'email.required'     => 'El email es obligatorio',
            'email.email'        => 'El email debe ser válido',
            'email.unique'       => 'Este email ya está registrado',
            'password.required'  => 'La contraseña es obligatoria',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'role.required'      => 'Debes seleccionar un rol',
        ]);

        $isSuperAdmin = $request->role === 'super_admin';

        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => 'user',
            'user_type'      => $isSuperAdmin ? 'super_admin' : 'admin',
            'permissions'    => $isSuperAdmin ? [] : ($request->permissions ?? []),
            'is_super_admin' => $isSuperAdmin,
            'is_protected'   => $request->boolean('is_protected'),
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
                ->with('error', 'Este usuario está protegido y no puede ser editado');
        }

        return view('superadmin.administradores.edit', compact('administrador'));
    }

    public function update(Request $request, User $administrador)
    {
        if ($administrador->is_protected) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'Este usuario está protegido y no puede ser modificado');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($administrador->id)],
            'role'        => 'required|in:super_admin,admin',
            'permissions' => 'nullable|array',
            'password'    => 'nullable|min:8|confirmed',
            'is_protected' => 'nullable|boolean',
        ], [
            'name.required'      => 'El nombre es obligatorio',
            'email.required'     => 'El email es obligatorio',
            'email.email'        => 'El email debe ser válido',
            'email.unique'       => 'Este email ya está en uso',
            'role.required'      => 'Debes seleccionar un rol',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        $isSuperAdmin = $request->role === 'super_admin';

        // Actualizar datos básicos
        $administrador->name           = $request->name;
        $administrador->email          = $request->email;
        $administrador->user_type      = $isSuperAdmin ? 'super_admin' : 'admin';
        $administrador->is_super_admin = $isSuperAdmin;
        $administrador->is_protected   = $request->boolean('is_protected');
        
        // Permisos (solo para admin regular)
        $administrador->permissions = $isSuperAdmin ? [] : ($request->permissions ?? []);

        // Actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $administrador->password = Hash::make($request->password);
        }

        $administrador->save();

        return redirect()->route('superadmin.administradores.index')
            ->with('success', 'Administrador actualizado exitosamente');
    }

    public function destroy(User $administrador)
    {
        if ($administrador->is_protected) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'Este usuario está protegido y no puede ser eliminado');
        }

        if ($administrador->id === Auth::id()) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'No puedes eliminarte a ti mismo');
        }

        if ($administrador->is_super_admin) {
            return redirect()->route('superadmin.administradores.index')
                ->with('error', 'No se puede eliminar a un Super Administrador');
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

    public function permisosRoles()
    {
        $usuarios = User::whereIn('user_type', ['admin', 'super_admin'])
            ->orderBy('is_super_admin', 'desc')
            ->orderBy('name')
            ->get();

        return view('superadmin.administradores.permisos', compact('usuarios'));
    }

    public function actualizarPermisos(Request $request)
    {
        $request->validate([
            'usuario_id'  => 'required|exists:users,id',
            'permissions' => 'nullable|array',
        ]);

        $usuario = User::findOrFail($request->usuario_id);

        if ($usuario->is_protected) {
            return back()->with('error', 'Este usuario está protegido y no puede ser modificado');
        }

        if ($usuario->is_super_admin) {
            return back()->with('error', 'No se pueden modificar los permisos de un Super Administrador');
        }

        if ($usuario->id === Auth::id()) {
            return back()->with('error', 'No puedes modificar tus propios permisos');
        }

        $usuario->permissions = $request->permissions ?? [];
        $usuario->save();

        return back()->with('success', "Permisos actualizados correctamente para {$usuario->name}");
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    private function getAvailablePermissions(): array
    {
        return [
            // Estudiantes
            'ver_estudiantes'       => 'Ver Estudiantes',
            'crear_estudiantes'     => 'Crear Estudiantes',
            'editar_estudiantes'    => 'Editar Estudiantes',
            'eliminar_estudiantes'  => 'Eliminar Estudiantes',
            
            // Profesores
            'ver_profesores'        => 'Ver Profesores',
            'crear_profesores'      => 'Crear Profesores',
            'editar_profesores'     => 'Editar Profesores',
            'eliminar_profesores'   => 'Eliminar Profesores',
            
            // Matrículas
            'ver_matriculas'        => 'Ver Matrículas',
            'crear_matriculas'      => 'Crear Matrículas',
            'aprobar_matriculas'    => 'Aprobar Matrículas',
            'rechazar_matriculas'   => 'Rechazar Matrículas',
            
            // Académico
            'ver_grados'            => 'Ver Grados',
            'gestionar_grados'      => 'Gestionar Grados',
            'ver_secciones'         => 'Ver Secciones',
            'gestionar_secciones'   => 'Gestionar Secciones',
            'ver_materias'          => 'Ver Materias',
            'gestionar_materias'    => 'Gestionar Materias',
            
            // Períodos
            'ver_periodos'          => 'Ver Períodos',
            'crear_periodos'        => 'Crear Períodos',
            'editar_periodos'       => 'Editar Períodos',
            'cerrar_periodos'       => 'Cerrar Períodos',
            
            // Padres
            'ver_padres'            => 'Ver Padres',
            'crear_padres'          => 'Crear Padres',
            'editar_padres'         => 'Editar Padres',
            'gestionar_accesos_padres' => 'Gestionar Accesos de Padres',
            
            // Reportes
            'ver_reportes'          => 'Ver Reportes',
            'generar_reportes'      => 'Generar Reportes',
            'exportar_datos'        => 'Exportar Datos',
            'ver_estadisticas'      => 'Ver Estadísticas',
            
            // Sistema
            'configurar_sistema'    => 'Configurar Sistema',
            'gestionar_cupos'       => 'Gestionar Cupos',
            'ver_logs'              => 'Ver Logs',
            'realizar_backups'      => 'Realizar Backups',
        ];
    }
}