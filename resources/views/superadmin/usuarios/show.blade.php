@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('page-title', 'Detalles del Usuario')

@section('content')
<div class="container">

    <a href="{{ url()->previous() }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detalles del Usuario</h4>
        </div>

        <div class="card-body">

            {{-- Mensajes --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">

                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">ID del Usuario:</h6>
                    <p>{{ $usuario->id }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">Nombre completo:</h6>
                    <p>{{ $usuario->name }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">Correo electrónico:</h6>
                    <p>{{ $usuario->email }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">Rol asignado:</h6>
                    <p>
                        <span class="badge bg-info text-dark">{{ $usuario->rol->nombre ?? 'Sin rol asignado' }}</span>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">Estado del usuario:</h6>
                    <p>
                        @if($usuario->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">Fecha de creación:</h6>
                    <p>{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">Última actualización:</h6>
                    <p>{{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                </div>

            </div>

            <hr>

            {{-- Acciones --}}
            <div class="d-flex gap-2">

                @if(!$usuario->activo)
                    {{-- Aprobar --}}
                    <form action="{{ route('superadmin.usuarios.aprobar', $usuario->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success">
                            <i class="fas fa-check me-1"></i> Aprobar usuario
                        </button>
                    </form>
                @endif

                {{-- Eliminar — usa el modal del layout --}}
                <button type="button"
                        class="btn btn-danger"
                        onclick="mostrarModalDelete(
                            '{{ route('superadmin.usuarios.rechazar', $usuario->id) }}',
                            '¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.',
                            '{{ $usuario->name }}'
                        )">
                    <i class="fas fa-trash me-1"></i> Eliminar usuario
                </button>

            </div>

        </div>
    </div>
</div>
@endsection
