<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    /**
     * Listar todos los usuarios del sistema.
     * Se usa paginación para evitar cargar todos los usuarios en memoria.
     */
    public function index(Request $request)
    {
        $rolFiltro = $request->input('rol');

        $query = User::with('rol')->orderBy('created_at', 'DESC');

        if ($rolFiltro) {
            // Mapeo de filtro URL → nombres reales de rol en la BD
            $mapaRoles = [
                'admin'     => ['admin', 'super_admin', 'Administrador'],
                'profesor'  => ['profesor', 'Maestro'],
                'Estudiante'=> ['Estudiante', 'estudiante'],
                'Padre'     => ['Padre', 'padre'],
            ];
            $nombres = $mapaRoles[$rolFiltro] ?? [$rolFiltro];
            $query->whereHas('rol', fn($q) => $q->whereIn('nombre', $nombres));
        }

        $usuarios = $query->paginate(20)->withQueryString();

        // Conteos por rol para las pestañas
        // Roles activos en el sistema: super_admin(1), admin(2), profesor(3), Estudiante(4), Padre(5)
        $conteos = [
            'total'         => User::count(),
            'admin'         => User::whereHas('rol', fn($q) => $q->whereIn('nombre', ['admin', 'super_admin', 'Administrador']))->count(),
            'profesor'      => User::whereHas('rol', fn($q) => $q->whereIn('nombre', ['profesor', 'Maestro']))->count(),
            'Estudiante'    => User::whereHas('rol', fn($q) => $q->whereIn('nombre', ['Estudiante', 'estudiante']))->count(),
            'Padre'         => User::whereHas('rol', fn($q) => $q->whereIn('nombre', ['Padre', 'padre']))->count(),
        ];

        return view('superadmin.usuarios.lista', compact('usuarios', 'rolFiltro', 'conteos'));
    }

    /**
     * Mostrar detalle de un usuario.
     */
    public function show($id)
    {
        $usuario = User::with('rol')->findOrFail($id);

        return view('superadmin.usuarios.show', compact('usuario'));
    }

    /**
     * Mostrar formulario de creación de usuario.
     */
    public function create()
    {
        return view('superadmin.usuarios.create');
    }

    /**
     * Guardar nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'rol_id'   => ['required', 'exists:roles,id'],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol_id'   => $request->rol_id,
            'activo'   => 1,
        ]);

        return redirect()->route('superadmin.usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $usuario = User::with('rol')->findOrFail($id);

        return view('superadmin.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualizar usuario.
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'unique:users,email,' . $usuario->id],
            'rol_id' => ['required', 'exists:roles,id'],
        ]);

        $datos = [
            'name'   => $request->name,
            'email'  => $request->email,
            'rol_id' => $request->rol_id,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['min:8', 'confirmed'],
            ]);
            $datos['password'] = Hash::make($request->password);
        }

        $usuario->update($datos);

        return redirect()->route('superadmin.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Eliminar usuario.
     * CORRECCIÓN: se muestra el nombre del usuario eliminado en el mensaje
     * y se previene que el superadmin se elimine a sí mismo.
     */
    public function destroy($id)
    {
        if ((int) $id === Auth::id()) {
            return redirect()->route('superadmin.usuarios.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $usuario = User::findOrFail($id);
        $nombre  = $usuario->name;
        $usuario->delete();

        return redirect()->route('superadmin.usuarios.index')
            ->with('success', "El usuario \"$nombre\" fue eliminado correctamente.");
    }

    /**
     * Usuarios pendientes de aprobación.
     */
    public function pendientes()
    {
        $usuariosPendientes = User::with('rol')
            ->where('activo', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('superadmin.usuarios.pendientes', compact('usuariosPendientes'));
    }

    /**
     * Aprobar un usuario: activar + generar contraseña temporal.
     */
    public function aprobar($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->activo == 1) {
            return redirect()->back()
                ->with('error', 'Este usuario ya está aprobado.');
        }

        $passwordTemp = strtoupper(Str::random(4)) . rand(100, 999) . '!';

        $usuario->update([
            'activo'   => 1,
            'password' => Hash::make($passwordTemp),
        ]);

        return redirect()->route('superadmin.usuarios.pendientes')
            ->with('success', "El usuario \"{$usuario->name}\" fue aprobado correctamente.")
            ->with('password_temp', $passwordTemp);
    }

    /**
     * Rechazar / eliminar un usuario pendiente.
     */
    public function rechazar($id)
    {
        if ((int) $id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'No puedes rechazar tu propio usuario.');
        }

        $usuario = User::findOrFail($id);
        $nombre  = $usuario->name;
        $usuario->delete();

        return redirect()->route('superadmin.usuarios.pendientes')
            ->with('success', "El usuario \"$nombre\" fue rechazado y eliminado correctamente.");
    }

    /**
     * Activar un usuario existente.
     * CORRECCIÓN: se previene modificar el propio estado.
     */
    public function activar($id)
    {
        if ((int) $id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'No puedes modificar tu propio estado.');
        }

        $usuario = User::findOrFail($id);
        $usuario->update(['activo' => 1]);

        return redirect()->back()
            ->with('success', "El usuario \"{$usuario->name}\" fue activado correctamente.");
    }

    /**
     * Desactivar un usuario existente.
     * CORRECCIÓN: se previene desactivar la propia cuenta.
     */
    public function desactivar($id)
    {
        if ((int) $id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $usuario = User::findOrFail($id);
        $usuario->update(['activo' => 0]);

        return redirect()->back()
            ->with('success', "El usuario \"{$usuario->name}\" fue desactivado correctamente.");
    }
}
