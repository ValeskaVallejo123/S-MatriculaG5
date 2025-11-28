@extends('layouts.app')

@section('title', 'Permisos y Roles')
@section('page-title', 'Gestión de Permisos y Roles')

@section('topbar-actions')
    <a href="{{ route('superadmin.administradores.index') }}"
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver a Administradores
    </a>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Header con descripción -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-start gap-3">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
                    <i class="fas fa-shield-alt" style="color: white; font-size: 1.5rem;"></i>
                </div>
                <div class="flex-grow-1">
                    <h4 class="fw-bold mb-2" style="color: #003b73;">Sistema de Permisos y Roles</h4>
                    <p class="mb-0" style="color: #64748b; font-size: 0.938rem;">
                        Este sistema utiliza un modelo de permisos basado en roles. Cada usuario tiene asignado un rol que determina sus capacidades dentro del sistema.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Roles -->
    <div class="row g-4 mb-4">

        <!-- SUPER ADMIN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #ef4444 !important;">
                <!-- Header -->
                <div class="card-header text-white" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white rounded-3 p-2" style="box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                                <i class="fas fa-crown" style="color: #ef4444; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Super Administrador</h5>
                                <small class="opacity-90">Acceso Total al Sistema</small>
                            </div>
                        </div>
                        <span class="badge bg-white fw-bold" style="color: #ef4444; padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.75rem; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">MÁXIMO</span>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-3" style="color: #ef4444;">
                            <i class="fas fa-bolt me-2"></i>Capacidades Especiales
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Acceso completo a <strong style="color: #1e293b;">todas las funciones</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Puede <strong style="color: #1e293b;">crear, editar y eliminar administradores</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Asigna y modifica <strong style="color: #1e293b;">permisos de otros usuarios</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Acceso a <strong style="color: #1e293b;">configuración del sistema</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Gestiona <strong style="color: #1e293b;">periodos académicos y cupos</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Visualiza <strong style="color: #1e293b;">todas las estadísticas y reportes</strong></span>
                            </li>
                        </ul>
                    </div>

                    <div class="alert mb-0" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 10px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-exclamation-triangle mt-1" style="color: #ef4444;"></i>
                            <div>
                                <strong class="d-block mb-1" style="color: #1e293b; font-size: 0.875rem;">Importante</strong>
                                <small style="color: #64748b;">Este rol debe ser asignado solo a usuarios de máxima confianza.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADMIN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #4ec7d2 !important;">
                <!-- Header -->
                <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white rounded-3 p-2" style="box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                                <i class="fas fa-user-shield" style="color: #00508f; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Administrador</h5>
                                <small class="opacity-90">Permisos Personalizables</small>
                            </div>
                        </div>
                        <span class="badge bg-white fw-bold" style="color: #00508f; padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.75rem; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">LIMITADO</span>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-3" style="color: #00508f;">
                            <i class="fas fa-list-check me-2"></i>Permisos Disponibles
                        </h6>
                        <p class="mb-3" style="color: #64748b; font-size: 0.875rem;">El Super Admin puede asignar los siguientes permisos:</p>

                        <div class="d-flex flex-column gap-2" style="max-height: 300px; overflow-y: auto;">
                            @foreach($permisos as $key => $nombre)
                            <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 0.875rem;"></i>
                                <span style="color: #1e293b; font-size: 0.875rem; font-weight: 500;">{{ $nombre }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="alert mb-0" style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.1) 0%, rgba(245, 158, 11, 0.1) 100%); border: 1px solid rgba(251, 191, 36, 0.2); border-radius: 10px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-info-circle mt-1" style="color: #f59e0b;"></i>
                            <div>
                                <strong class="d-block mb-1" style="color: #1e293b; font-size: 0.875rem;">Restricciones</strong>
                                <ul class="mb-0 ps-3" style="font-size: 0.813rem; color: #64748b;">
                                    <li>No puede gestionar otros administradores</li>
                                    <li>No tiene acceso a configuración del sistema</li>
                                    <li>Solo acciones según permisos asignados</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Lista de Usuarios con Permisos Configurables -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-users-cog me-2"></i>Gestionar Permisos de Administradores
            </h5>
        </div>

        <div class="card-body p-4">
            <div class="mb-4">
                <p class="mb-3" style="color: #64748b;">
                    <i class="fas fa-info-circle me-2" style="color: #4ec7d2;"></i>
                    Selecciona un administrador para configurar sus permisos individuales
                </p>

                <!-- Filtros -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small" style="color: #003b73;">Buscar Usuario</label>
                        <input type="text"
                               class="form-control"
                               id="searchUser"
                               placeholder="Buscar por nombre o email..."
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem; transition: all 0.3s ease;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small" style="color: #003b73;">Filtrar por Rol</label>
                        <select class="form-select"
                                id="filterRole"
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem; transition: all 0.3s ease;">
                            <option value="">Todos los roles</option>
                            <option value="admin">Administrador</option>
                            <option value="super_admin">Super Administrador</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small" style="color: #003b73;">Acciones</label>
                        <button type="button"
                                class="btn w-100"
                                onclick="limpiarFiltros()"
                                style="background: white; color: #00508f; border: 2px solid #4ec7d2; padding: 0.6rem 1rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
                            <i class="fas fa-redo me-2"></i>Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>

            <!-- Lista de Usuarios -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="usersTable" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-user me-2" style="color: #4ec7d2;"></i>Usuario
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
                                <i class="fas fa-cog me-2" style="color: #4ec7d2;"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                        <tr data-role="{{ $usuario->role }}" data-name="{{ strtolower($usuario->name) }}" data-email="{{ strtolower($usuario->email) }}" style="border-bottom: 1px solid #e2e8f0; transition: all 0.2s ease;">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                                        <strong style="color: white; font-size: 1rem;">{{ substr($usuario->name, 0, 1) }}</strong>
                                    </div>
                                    <div>
                                        <strong class="d-block" style="color: #1e293b; font-size: 0.938rem;">{{ $usuario->name }}</strong>
                                        @if($usuario->is_protected)
                                        <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); font-size: 0.7rem; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                            <i class="fas fa-lock me-1"></i>Protegido
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3" style="color: #64748b; font-size: 0.875rem;">
                                {{ $usuario->email }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($usuario->role === 'super_admin' || $usuario->is_super_admin)
                                    <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);">
                                        <i class="fas fa-crown me-1"></i>Super Admin
                                    </span>
                                @elseif($usuario->role === 'admin')
                                    <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);">
                                        <i class="fas fa-user-shield me-1"></i>Administrador
                                    </span>
                                @else
                                    <span class="badge" style="background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(148, 163, 184, 0.3);">
                                        {{ ucfirst($usuario->role) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $permisosActivos = is_array($usuario->permissions) ? count($usuario->permissions) : 0;
                                @endphp
                                @if($permisosActivos > 0)
    <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);">
        {{ $permisosActivos }} / {{ count($permisos) }}
    </span>
@else
    <span class="badge" style="background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(148, 163, 184, 0.3);">
        {{ $permisosActivos }} / {{ count($permisos) }}
    </span>
@endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if(!$usuario->is_super_admin && !$usuario->is_protected)
                                <button type="button"
                                        class="btn btn-sm"
                                        style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);"
                                        data-user-id="{{ $usuario->id }}"
                                        data-user-name="{{ $usuario->name }}"
                                        data-user-permissions='@json($usuario->permissions ?? [])'
                                        onclick="abrirModalPermisosData(this)">
                                    <i class="fas fa-edit me-1"></i>Configurar
                                </button>
                                @else
                                <span style="color: #94a3b8; font-size: 0.875rem; font-weight: 600;">
                                    <i class="fas fa-lock me-1"></i>No configurable
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div style="padding: 3rem 1rem;">
                                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.1) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                        <i class="fas fa-users-cog" style="font-size: 2rem; color: #4ec7d2;"></i>
                                    </div>
                                    <h6 style="color: #64748b; font-weight: 600; margin-bottom: 0.5rem;">No hay administradores registrados</h6>
                                    <p style="color: #94a3b8; font-size: 0.875rem; margin: 0;">Crea un administrador desde la sección de Administradores</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabla Comparativa -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-table me-2"></i>Tabla Comparativa de Permisos
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="px-4 py-3 fw-semibold" style="color: #003b73; font-size: 0.875rem; border: none;">Módulo / Función</th>
                            <th class="px-4 py-3 text-center fw-semibold" style="color: #003b73; font-size: 0.875rem; border: none;">Super Admin</th>
                            <th class="px-4 py-3 text-center fw-semibold" style="color: #003b73; font-size: 0.875rem; border: none;">Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dashboard -->
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">Dashboard</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                        </tr>

                        <!-- Gestionar Administradores -->
                        <tr style="background: rgba(239, 68, 68, 0.05); border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">Gestionar Administradores</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-times-circle" style="color: #ef4444; font-size: 1.25rem;"></i>
                            </td>
                        </tr>

                        @foreach($permisos as $key => $nombre)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">{{ $nombre }}</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); padding: 0.4rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">Configurable</span>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Configuración del Sistema -->
                        <tr style="background: rgba(239, 68, 68, 0.05); border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">Configuración del Sistema</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-times-circle" style="color: #ef4444; font-size: 1.25rem;"></i>
                            </td>
                        </tr>

                        <!-- Cambiar Contraseña -->
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">Cambiar Contraseña (propia)</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal de Configuración de Permisos -->
<div class="modal fade" id="modalPermisos" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-shield-alt me-2"></i>
                    Configurar Permisos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formPermisos" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="alert mb-4" style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.1) 100%); border: 1px solid rgba(78, 199, 210, 0.2); border-radius: 10px;">
                        <i class="fas fa-info-circle me-2" style="color: #4ec7d2;"></i>
                        Configurando permisos para: <strong id="nombreUsuario" style="color: #003b73;"></strong>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold" style="color: #003b73;">Permisos Disponibles</h6>
                            <div class="btn-group btn-group-sm">
                                <button type="button"
                                        class="btn"
                                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 0.4rem 0.875rem; border-radius: 6px 0 0 6px; font-weight: 600; transition: all 0.3s ease;"
                                        onclick="seleccionarTodos()">
                                    <i class="fas fa-check-double me-1"></i>Todos
                                </button>
                                <button type="button"
                                        class="btn"
                                        style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; padding: 0.4rem 0.875rem; border-radius: 0 6px 6px 0; font-weight: 600; transition: all 0.3s ease;"
                                        onclick="deseleccionarTodos()">
                                    <i class="fas fa-times me-1"></i>Ninguno
                                </button>
                            </div>
                        </div>

                        <div class="row g-3">
                            @foreach($permisos as $key => $nombre)
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded hover-shadow" style="border: 2px solid #e2e8f0; border-radius: 10px; transition: all 0.3s ease;">
                                    <input class="form-check-input permiso-checkbox"
                                           type="checkbox"
                                           name="permisos[]"
                                           value="{{ $key }}"
                                           id="permiso_{{ $key }}"
                                           style="width: 40px; height: 20px; cursor: pointer;">
                                    <label class="form-check-label fw-medium ms-2" for="permiso_{{ $key }}" style="color: #1e293b; cursor: pointer;">
                                        {{ $nombre }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
                    <button type="button"
                            class="btn"
                            style="background: white; color: #64748b; border: 2px solid #e2e8f0; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;"
                            data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit"
                            class="btn"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>

    .hover-shadow:hover {
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.2);
        background: linear-gradient(135deg, rgba(78, 199, 210, 0.05) 0%, rgba(0, 80, 143, 0.05) 100%);
        border-color: #4ec7d2 !important;
    }

    .form-check-input:checked {
        background-color: #4ec7d2;
        border-color: #4ec7d2;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush

@push('scripts')
<script>
let modalPermisos;

document.addEventListener('DOMContentLoaded', function() {
    modalPermisos = new bootstrap.Modal(document.getElementById('modalPermisos'));
});

function abrirModalPermisosData(button) {
    const userId = button.dataset.userId;
    const userName = button.dataset.userName;
    const userPermissions = JSON.parse(button.dataset.userPermissions);

    abrirModalPermisos(userId, userName, userPermissions);
}

function abrirModalPermisos(userId, userName, userPermissions) {
    document.getElementById('nombreUsuario').textContent = userName;
    document.getElementById('formPermisos').action = `/superadmin/administradores/${userId}/permisos`;

    document.querySelectorAll('.permiso-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });

    if (Array.isArray(userPermissions)) {
        userPermissions.forEach(permiso => {
            const checkbox = document.getElementById(`permiso_${permiso}`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }

    modalPermisos.show();
}

function seleccionarTodos() {
    document.querySelectorAll('.permiso-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deseleccionarTodos() {
    document.querySelectorAll('.permiso-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
}

function limpiarFiltros() {
    document.getElementById('searchUser').value = '';
    document.getElementById('filterRole').value = '';
    filtrarUsuarios();
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchUser');
    const filterRole = document.getElementById('filterRole');

    if (searchInput) {
        searchInput.addEventListener('input', filtrarUsuarios);
    }

    if (filterRole) {
        filterRole.addEventListener('change', filtrarUsuarios);
    }
});

function filtrarUsuarios() {
    const searchTerm = document.getElementById('searchUser').value.toLowerCase();
    const roleFilter = document.getElementById('filterRole').value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');

    rows.forEach(row => {
        const name = row.dataset.name || '';
        const email = row.dataset.email || '';
        const role = row.dataset.role || '';

        const matchSearch = name.includes(searchTerm) || email.includes(searchTerm);
        const matchRole = !roleFilter || role === roleFilter;

        if (matchSearch && matchRole) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection
