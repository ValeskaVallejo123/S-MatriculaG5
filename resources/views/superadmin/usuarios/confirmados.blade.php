@extends('layouts.app')

@section('title', 'Usuarios Confirmados')
@section('page-title', 'Usuarios Confirmados')

@section('content')
<div class="container-fluid px-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-user-check me-2"></i>Usuarios Confirmados
            </h5>
            <span class="badge bg-primary">Total: {{ $usuarios->count() }}</span>
        </div>

        <div class="card-body p-0">

            @if($usuarios->count() == 0)
                <div class="p-4 text-center text-muted">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <p class="mb-0">No hay usuarios confirmados.</p>
                </div>
            @else
                {{-- table-responsive evita desbordamiento en móvil --}}
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $u)
                            <tr>
                                <td class="fw-semibold">{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $u->rol->nombre ?? 'Sin rol' }}
                                    </span>
                                </td>
                                <td>{{ $u->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>{{-- ← div card-body que faltaba cerrar --}}
    </div>

</div>
@endsection
