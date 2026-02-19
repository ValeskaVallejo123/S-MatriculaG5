@extends('layouts.app')

@section('title', 'Administradores')
@section('page-title', 'Gestión de Administradores')

@section('topbar-actions')
    <a href="{{ route('superadmin.administradores.permisos') }}"
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem; margin-right: 0.5rem;">
        <i class="fas fa-shield-alt"></i>
        Permisos y Roles
    </a>
    <a href="{{ route('superadmin.administradores.create') }}"
       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo Administrador
    </a>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Estadísticas en Cards -->
    <div class="row g-4 mb-4">
        <!-- Total -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
                            <i class="fas fa-users" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1" style="color: #64748b; font-size: 0.875rem; font-weight: 600;">Total Administradores</p>
                            <h3 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1.875rem;">{{ $administradores->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Super Admins -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">
                            <i class="fas fa-crown" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1" style="color: #64748b; font-size: 0.875rem; font-weight: 600;">Super Administradores</p>
                            <h3 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1.875rem;">{{ $administradores->where('is_super_admin', true)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admins Regulares -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-user-shield" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1" style="color: #64748b; font-size: 0.875rem; font-weight: 600;">Administradores</p>
                            <h3 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1.875rem;">{{ $administradores->where('is_super_admin', false)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Administradores -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-user-shield" style="font-size: 1.25rem;"></i>
                <h5 class="mb-0 fw-bold">Lista de Administradores</h5>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-user me-2" style="color: #4ec7d2;"></i>Administrador
                            </th>
                            <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-envelope me-2" style="color: #4ec7d2;"></i>Email
                            </th>
                            <th class="px-4 py-3 text-center" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-shield-alt me-2" style="color: #4ec7d2;"></i>Rol
                            </th>
                            <th class="px-4 py-3 text-center" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-check-circle me-2" style="color: #4ec7d2;"></i>Permisos
                            </th>
                            <th class="px-4 py-3 text-center" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-toggle-on me-2" style="color: #4ec7d2;"></i>Estado
                            </th>
                            <th class="px-4 py-3 text-center" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-cog me-2" style="color: #4ec7d2;"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($administradores as $admin)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: all 0.2s ease;">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                                        <strong style="color: white; font-size: 1.125rem;">{{ substr($admin->name, 0, 1) }}</strong>
                                    </div>
                                    <div>
                                        <strong class="d-block" style="color: #1e293b; font-size: 0.938rem;">{{ $admin->name }}</strong>
                                        @if($admin->is_protected)
                                        <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); font-size: 0.7rem; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                            <i class="fas fa-lock me-1"></i>Protegido
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3" style="color: #64748b; font-size: 0.875rem;">
                                <i class="fas fa-envelope me-2" style="color: #4ec7d2;"></i>{{ $admin->email }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($admin->is_super_admin)
                                    <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);">
                                        <i class="fas fa-crown me-1"></i>Super Admin
                                    </span>
                                @else
                                    <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);">
                                        <i class="fas fa-user-shield me-1"></i>Administrador
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $permisosActivos = is_array($admin->permissions) ? count($admin->permissions) : 0;
                                @endphp
                                @if($admin->is_super_admin)
                                    <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);">
                                        <i class="fas fa-infinity me-1"></i>Todos
                                    </span>
                                @else
                                    <span class="badge" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);">
                                        <i class="fas fa-list-check me-1"></i>{{ $permisosActivos }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);">
                                    <i class="fas fa-check-circle me-1"></i>Activo
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if(!$admin->is_protected)
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('superadmin.administradores.edit', $admin->id) }}"
                                       class="btn btn-sm"
                                       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.5rem 0.875rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm"
                                            style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; padding: 0.5rem 0.875rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);"
                                            data-route="{{ route('superadmin.administradores.destroy', $admin->id) }}"
                                            data-message="¿Estás seguro de eliminar a este administrador?"
                                            data-name="{{ $admin->name }}"
                                            onclick="mostrarModalDeleteData(this)"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @else
                                <span style="color: #94a3b8; font-size: 0.875rem; font-weight: 600;">
                                    <i class="fas fa-lock me-1"></i>Protegido
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div style="padding: 3rem 1rem;">
                                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.1) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                        <i class="fas fa-users" style="font-size: 2rem; color: #4ec7d2;"></i>
                                    </div>
                                    <h6 style="color: #64748b; font-weight: 600; margin-bottom: 0.5rem;">No hay administradores registrados</h6>
                                    <p style="color: #94a3b8; font-size: 0.875rem; margin: 0;">Comienza agregando tu primer administrador</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .table tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.001);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    @media (max-width: 768px) {
        .table {
            font-size: 0.875rem;
        }

        .card-body {
            padding: 1rem !important;
        }
    }
</style>
@endpush
@endsection
