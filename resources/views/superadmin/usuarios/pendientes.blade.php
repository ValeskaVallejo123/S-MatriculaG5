@extends('layouts.app')

@section('title', 'Usuarios pendientes')

@section('content')
<div class="container">
    <h2 class="mb-4">Usuarios pendientes de aprobación</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('password_temp'))
<div class="alert alert-info">
    <strong>Contraseña temporal generada:</strong>
    <span class="text-danger">{{ session('password_temp') }}</span>
</div>
@endif

    @if($usuariosPendientes->isEmpty())
        <div class="alert alert-info">
            No hay usuarios pendientes por aprobar.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuariosPendientes as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->rol->nombre ?? 'Sin rol' }}</td>
                        <td>{{ $u->created_at }}</td>
                        <td class="d-flex gap-2">

                            {{-- Aprobar --}}
                            <form action="{{ route('superadmin.usuarios.aprobar', $u->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    Aprobar
                                </button>
                            </form>

                            {{-- Rechazar / eliminar --}}
                            <form action="{{ route('superadmin.usuarios.rechazar', $u->id) }}" method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Rechazar
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
