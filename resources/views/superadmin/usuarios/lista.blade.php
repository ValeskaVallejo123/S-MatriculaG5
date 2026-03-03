@extends('layouts.app')

@section('title', 'Lista de usuarios')

@section('page-title', 'Usuarios del Sistema')

@section('content')
<div class="container">

    {{-- Botón de regreso --}}
    <a href="{{ route('superadmin.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
    </a>


    <a href="{{ url()->previous() }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    {{-- Mensajes --}}
    @if(session('password_temp'))
        <div class="alert alert-info shadow-sm">
            <strong>Contraseña temporal generada:</strong>
            <span class="text-danger fw-bold">{{ session('password_temp') }}</span>
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
            <span class="fw-semibold">
                <i class="fas fa-list me-2"></i>Listado de Usuarios
            </span>
            <span class="badge bg-light text-primary">Total: {{ $usuarios->total() }}</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
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
                                    @php
                                        $coloresRol = [
                                            'super_admin'    => 'bg-dark',
                                            'Administrador'  => 'bg-secondary',
                                            'admin'          => 'bg-secondary',
                                            'Profesor'       => 'bg-info text-dark',
                                            'profesor'       => 'bg-info text-dark',
                                            'Estudiante'     => 'bg-primary',
                                            'estudiante'     => 'bg-primary',
                                            'Padre'          => 'bg-success',
                                            'padre'          => 'bg-success',
                                        ];
                                        $nombreRol  = $u->rol->nombre ?? 'Sin rol';
                                        $claseRol   = $coloresRol[$nombreRol] ?? 'bg-info text-dark';
                                    @endphp
                                    <span class="badge {{ $claseRol }}">
                                        {{ $nombreRol }}
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
                                    {{-- Solo icono de visualización --}}
                                    <a href="{{ route('superadmin.usuarios.show', $u->id) }}"
                                       class="btn btn-outline-primary btn-sm"
                                       title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
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

        {{-- Paginación --}}
        @if($usuarios->hasPages())
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Mostrando {{ $usuarios->firstItem() }}–{{ $usuarios->lastItem() }}
                    de {{ $usuarios->total() }} usuarios
                </small>
                {{ $usuarios->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
