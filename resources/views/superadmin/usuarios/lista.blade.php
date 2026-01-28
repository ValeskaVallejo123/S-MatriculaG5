@extends('layouts.app')

@section('title', 'Lista de usuarios')

@section('content')
<div class="container">

    {{-- Título y descripción --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Usuarios del sistema</h2>
            <p class="text-muted mb-0">Administración general de cuentas registradas</p>
        </div>
        <i class="fas fa-users-cog fa-2x text-primary"></i>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    {{-- Mensajes --}}
    @if(session('password_temp'))
        <div class="alert alert-info shadow-sm">
            <strong>Contraseña temporal generada:</strong>
            <span class="text-danger">{{ session('password_temp') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    {{-- Tarjeta principal --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold"><i class="fas fa-list me-2"></i>Listado de Usuarios</span>
            <span class="badge bg-light text-primary">Total: {{ $usuarios->count() }}</span>
        </div>

        <div class="card-body p-0">

            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usuarios as $u)
                        <tr>
                            <td class="fw-bold">{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $u->rol->nombre ?? 'Sin rol' }}
                                </span>
                            </td>

                            <td>
                                @if($u->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @endif
                            </td>

                            <td>{{ $u->created_at->format('d/m/Y H:i') }}</td>

                            <td class="text-center">

                                {{-- Ver --}}
                                <a href="{{ route('superadmin.usuarios.show', $u->id) }}"
                                   class="btn btn-outline-primary btn-sm me-1">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Aprobar si está pendiente --}}
                                @if(!$u->activo)
                                    <form action="{{ route('superadmin.usuarios.aprobar', $u->id) }}"
                                          method="POST" class="d-inline-block">
                                        @csrf
                                        <button class="btn btn-outline-success btn-sm me-1">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Activar / Desactivar --}}
                                @if($u->activo)
                                    <form method="POST" action="{{ route('superadmin.usuarios.desactivar', $u->id) }}" class="d-inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-warning btn-sm">Desactivar</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('superadmin.usuarios.activar', $u->id) }}" class="d-inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-success btn-sm">Activar</button>
                                    </form>
                                @endif

                                {{-- Eliminar --}}
                                <form action="{{ route('superadmin.usuarios.rechazar', $u->id) }}"
                                      method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Eliminar este usuario?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>
@endsection
