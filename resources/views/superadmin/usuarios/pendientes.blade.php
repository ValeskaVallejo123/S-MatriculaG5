@extends('layouts.app')

@section('title', 'Usuarios pendientes')

@section('page-title', 'Usuarios Pendientes')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Usuarios pendientes de aprobación</h2>
            <p class="text-muted mb-0">Cuentas que esperan ser aprobadas o rechazadas</p>
        </div>
        <i class="fas fa-user-clock fa-2x text-warning"></i>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    @if(session('password_temp'))
        <div class="alert alert-info shadow-sm">
            <strong>Contraseña temporal generada:</strong>
            <span class="text-danger">{{ session('password_temp') }}</span>
        </div>
    @endif

    @if($usuariosPendientes->isEmpty())
        <div class="alert alert-info shadow-sm">
            <i class="fas fa-check-circle me-2"></i>
            No hay usuarios pendientes por aprobar.
        </div>
    @else
        <div class="card shadow-sm border-0">

            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="fas fa-user-clock me-2"></i>Pendientes de aprobación</span>
                <span class="badge bg-dark text-white">Total: {{ $usuariosPendientes->count() }}</span>
            </div>

            <div class="card-body p-0">
                {{-- table-responsive evita desbordamiento en móvil --}}
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha registro</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuariosPendientes as $u)
                                <tr>
                                    <td class="fw-semibold">{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $u->rol->nombre ?? 'Sin rol' }}
                                        </span>
                                    </td>
                                    {{-- Fecha con formato legible --}}
                                    <td>{{ $u->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">

                                            {{-- Aprobar --}}
                                            <form action="{{ route('superadmin.usuarios.aprobar', $u->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check me-1"></i> Aprobar
                                                </button>
                                            </form>

                                            {{-- Rechazar — usa el modal del layout --}}
                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="mostrarModalDelete(
                                                        '{{ route('superadmin.usuarios.rechazar', $u->id) }}',
                                                        '¿Estás seguro de que deseas rechazar y eliminar este usuario? Esta acción no se puede deshacer.',
                                                        '{{ $u->name }}'
                                                    )">
                                                <i class="fas fa-times me-1"></i> Rechazar
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
