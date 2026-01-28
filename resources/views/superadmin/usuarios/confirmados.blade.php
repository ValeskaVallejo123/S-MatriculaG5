@extends('layouts.app')

@section('title', 'Usuarios Pendientes')
@section('page-title', 'Usuarios Pendientes de Aprobación')

@section('content')
<div class="container-fluid px-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-user-clock me-2"></i>Usuarios Confirmados
            </h5>
        </div>
        <div class="card-body p-0">

            @if($usuarios->count() == 0)
                <div class="p-4 text-center text-muted">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <p class="mb-0">No hay usuarios confirmados.</p>
                </div>
            @else
            <table class="table table-hover mb-0">
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
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->rol->nombre ?? 'Sin rol' }}</td>
                        <td>{{ $u->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

    </div>
</div>

@endsection
