@extends('layouts.app')

@section('title', 'Permisos por Rol')
@section('page-title', 'Gestión de Permisos')

@section('content')
<div class="container-fluid px-4">

    <!-- Header descriptivo -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.1) 100%);">
        <div class="card-body p-4">
            <div class="d-flex align-items-start gap-3">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-shield-alt" style="font-size: 1.4rem; color: white;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1" style="color: #003b73;">Sistema de Permisos y Roles</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
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
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border: 2px solid #fca5a5 !important; overflow: hidden;">
                <div class="card-header border-0 py-4 px-4" style="background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 50px; height: 50px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <i class="fas fa-user-shield" style="font-size: 1.4rem; color: #ef4444;"></i>
                            </div>
                            <div>
                                <h5 class="text-white fw-bold mb-0">Super Administrador</h5>
                                <small class="text-white" style="opacity: 0.85;">Acceso Total al Sistema</small>
                            </div>
                        </div>
                        <span class="badge bg-white text-danger fw-bold">MÁXIMO</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Capacidades -->
                    <div class="card border-0 mb-3" style="background: #f9fafb; border-radius: 10px;">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-3" style="color: #003b73;">
                                <i class="fas fa-bolt me-2 text-warning"></i>Capacidades Especiales
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Acceso completo a <strong>todas las funciones</strong> del sistema</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Puede <strong>crear, editar y eliminar administradores</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Asigna y modifica <strong>permisos de otros usuarios</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Acceso a <strong>configuración del sistema</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Gestiona <strong>periodos académicos y cupos</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-0">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Visualiza <strong>todas las estadísticas y reportes</strong></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Aviso -->
                    <div class="alert alert-danger border-0 mb-0" style="background: rgba(239,68,68,0.08); border-left: 4px solid #ef4444 !important; border-radius: 8px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-exclamation-triangle text-danger mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="fw-semibold text-danger mb-1" style="font-size: 0.85rem;">Importante</p>
                                <p class="text-danger mb-0" style="font-size: 0.8rem; opacity: 0.85;">Este rol debe ser asignado solo a usuarios de máxima confianza ya que tiene control total sobre el sistema.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADMIN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border: 2px solid #93c5fd !important; overflow: hidden;">
                <div class="card-header border-0 py-4 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 50px; height: 50px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <i class="fas fa-user-cog" style="font-size: 1.4rem; color: #00508f;"></i>
                            </div>
                            <div>
                                <h5 class="text-white fw-bold mb-0">Administrador</h5>
                                <small class="text-white" style="opacity: 0.85;">Permisos Personalizables</small>
                            </div>
                        </div>
                        <span class="badge bg-white fw-bold" style="color: #00508f;">LIMITADO</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Permisos disponibles -->
                    <div class="card border-0 mb-3" style="background: #f9fafb; border-radius: 10px;">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1" style="color: #003b73;">
                                <i class="fas fa-clipboard-list me-2" style="color: #4ec7d2;"></i>Permisos Disponibles
                            </h6>
                            <p class="text-muted mb-3" style="font-size: 0.8rem;">El Super Admin puede asignar los siguientes permisos:</p>
                            <div class="d-flex flex-column gap-2">
                                @foreach($permisos as $key => $nombre)
                                <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: white; border: 1px solid #e2e8f0;">
                                    <i class="fas fa-check-circle text-success flex-shrink-0"></i>
                                    <span style="font-size: 0.875rem; color: #374151;">{{ $nombre }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Restricciones -->
                    <div class="alert alert-warning border-0 mb-0" style="background: rgba(245,158,11,0.08); border-left: 4px solid #f59e0b !important; border-radius: 8px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-info-circle text-warning mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="fw-semibold text-warning mb-1" style="font-size: 0.85rem;">Restricciones</p>
                                <ul class="mb-0 ps-3" style="font-size: 0.8rem; color: #92400e;">
                                    <li>No puede gestionar otros administradores</li>
                                    <li>No tiene acceso a configuración del sistema</li>
                                    <li>Solo puede realizar acciones según permisos asignados</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabla Comparativa -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%);">
            <h5 class="text-white fw-bold mb-0">
                <i class="fas fa-table me-2"></i>Tabla Comparativa de Permisos
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Módulo / Función</th>
                            <th class="text-center px-4 py-3">Super Admin</th>
                            <th class="text-center px-4 py-3">Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dashboard -->
                        <tr>
                            <td class="px-4 py-3 fw-semibold">Dashboard</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                        </tr>

                        <!-- Gestionar Administradores -->
                        <tr style="background: rgba(239,68,68,0.04);">
                            <td class="px-4 py-3 fw-semibold">Gestionar Administradores</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-times-circle text-danger fs-5"></i></td>
                        </tr>

                        @foreach($permisos as $key => $nombre)
                        <tr>
                            <td class="px-4 py-3 fw-semibold">{{ $nombre }}</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center">
                                <span class="badge" style="background: rgba(0,80,143,0.1); color: #00508f; font-size: 0.75rem;">Configurable</span>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Configuración del Sistema -->
                        <tr style="background: rgba(239,68,68,0.04);">
                            <td class="px-4 py-3 fw-semibold">Configuración del Sistema</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-times-circle text-danger fs-5"></i></td>
                        </tr>

                        <!-- Cambiar Contraseña -->
                        <tr>
                            <td class="px-4 py-3 fw-semibold">Cambiar Contraseña (propia)</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botón volver -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('admins.index') }}" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
            <i class="fas fa-users me-2"></i>Gestionar Administradores
        </a>
    </div>

</div>
@endsection
