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
     */
    public function index()
    {
        // CORRECCIÓN: ->get() carga TODOS los usuarios en memoria.
        // Se usa paginación para evitar problemas de rendimiento.
        $usuarios = User::with('rol')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('superadmin.usuarios.lista', compact('usuarios'));
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
     */
    public function destroy($id)
    {
        // CORRECCIÓN: evitar que el superadmin se elimine a sí mismo
        if ((int) $id === Auth::id()) {
            return redirect()->route('superadmin.usuarios.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('superadmin.usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
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
     *
     * CORRECCIÓN CRÍTICA: el original tenía código MUERTO (unreachable code).
     * Después del return dentro del try{}, el código de verificación
     * "if ($usuario->activo == 1)" y la generación de contraseña temporal
     * NUNCA se ejecutaban porque el return ya había salido de la función.
     * Se reestructuró completamente: primero validar, luego actuar.
     */
    public function aprobar($id)
    {
        $usuario = User::findOrFail($id);

        // Verificar que no esté ya aprobado
        if ($usuario->activo == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Este usuario ya está aprobado.',
            ], 422);
        }

        try {
            // Generar contraseña temporal segura
            $passwordTemp = strtoupper(Str::random(4)) . rand(100, 999) . '!';

            $usuario->update([
                'activo'   => 1,
                'password' => Hash::make($passwordTemp),
            ]);

            return response()->json([
                'success'       => true,
                'message'       => 'Usuario aprobado exitosamente.',
                'password_temp' => $passwordTemp,
                'email'         => $usuario->email,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar el usuario: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Rechazar / eliminar un usuario pendiente.
     *
     * CORRECCIÓN: el original tenía código MUERTO después del return
     * dentro del try{}. La segunda llamada a $usuario->delete() y el
     * segundo return nunca se ejecutaban.
     */
    public function rechazar($id)
    {
        // CORRECCIÓN: evitar rechazarse a sí mismo
        if ((int) $id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes rechazar tu propio usuario.',
            ], 422);
        }

        try {
            $usuario = User::findOrFail($id);
            $usuario->delete();

            return response()->json([
                'success' => true,
                'message' => 'Usuario rechazado y eliminado correctamente.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar el usuario: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Activar un usuario existente.
     */
    public function activar($id)
    {
        // CORRECCIÓN: este método existía en web.php pero no en el controlador original
        if ((int) $id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes modificar tu propio estado.',
            ], 422);
        }

        $usuario = User::findOrFail($id);
        $usuario->update(['activo' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario activado correctamente.',
        ]);
    }

    /**
     * Desactivar un usuario existente.
     */
    public function desactivar($id)
    {
        // CORRECCIÓN: este método existía en web.php pero no en el controlador original
        if ((int) $id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes desactivar tu propia cuenta.',
            ], 422);
        }

        $usuario = User::findOrFail($id);
        $usuario->update(['activo' => 0]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario desactivado correctamente.',
        ]);
    }
}
