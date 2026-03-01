@extends('layouts.app')

@section('title', 'Detalles del Administrador')
@section('page-title', 'Información del Administrador')

@section('topbar-actions')
    <a href="{{ route('superadmin.administradores.index') }}" 
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
    @if(!$administrador->is_protected)
    <a href="{{ route('superadmin.administradores.edit', $administrador->id) }}" 
       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-edit"></i>
        Editar
    </a>
    @endif
@endsection

@section('content')
<div class="container" style="max-width: 900px;">
    
    <!-- Card Principal -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-user-circle" style="font-size: 1.25rem;"></i>
                    <h5 class="mb-0 fw-bold">Detalles del Administrador</h5>
                </div>
                @if($administrador->is_protected)
                <span class="badge" style="background: rgba(255,255,255,0.2); padding: 0.4rem 0.85rem; font-size: 0.75rem;">
                    <i class="fas fa-lock me-1"></i>PROTEGIDO
                </span>
                @endif
            </div>
        </div>

        <div class="card-body p-4">
            
            <!-- Avatar y Nombre -->
            <div class="text-center mb-4 pb-4 border-bottom">
                <div class="d-flex justify-content-center mb-3">
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #4ec7d2, #00508f); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: 0 4px 15px rgba(78, 199, 210, 0.3);">
                        {{ strtoupper(substr($administrador->name, 0, 2)) }}
                    </div>
                </div>
                <h4 class="mb-2 fw-bold" style="color: #003b73;">{{ $administrador->name }}</h4>
                <p class="text-muted mb-2">{{ $administrador->email }}</p>
                
                @if($administrador->is_super_admin)
                <span class="badge" style="background: linear-gradient(135deg, #a855f7, #ec4899); padding: 0.5rem 1rem; font-size: 0.85rem;">
                    <i class="fas fa-crown me-1"></i>SUPER ADMINISTRADOR
                </span>
                @else
                <span class="badge" style="background: linear-gradient(135deg, #3b82f6, #06b6d4); padding: 0.5rem 1rem; font-size: 0.85rem;">
                    <i class="fas fa-user-shield me-1"></i>ADMINISTRADOR
                </span>
                @endif
            </div>

            <!-- Información Personal -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3" style="color: #003b73;">
                    <i class="fas fa-user me-2" style="color: #4ec7d2;"></i>Información Personal
                </h6>

                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <div class="p-3 border rounded" style="border: 2px solid #bfd9ea; border-radius: 10px; background: #f8fafc;">
                            <label class="small fw-semibold d-block mb-1" style="color: #64748b;">Nombre Completo</label>
                            <p class="mb-0 fw-semibold" style="color: #003b73;">{{ $administrador->name }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="p-3 border rounded" style="border: 2px solid #bfd9ea; border-radius: 10px; background: #f8fafc;">
                            <label class="small fw-semibold d-block mb-1" style="color: #64748b;">Correo Electrónico</label>
                            <p class="mb-0 fw-semibold" style="color: #003b73;">{{ $administrador->email }}</p>
                        </div>
                    </div>

                    <!-- Fecha Registro -->
                    <div class="col-md-6">
                        <div class="p-3 border rounded" style="border: 2px solid #bfd9ea; border-radius: 10px; background: #f8fafc;">
                            <label class="small fw-semibold d-block mb-1" style="color: #64748b;">Fecha de Registro</label>
                            <p class="mb-0 fw-semibold" style="color: #003b73;">
                                <i class="fas fa-calendar-alt me-1" style="color: #4ec7d2;"></i>
                                {{ $administrador->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Último Acceso -->
                    <div class="col-md-6">
                        <div class="p-3 border rounded" style="border: 2px solid #bfd9ea; border-radius: 10px; background: #f8fafc;">
                            <label class="small fw-semibold d-block mb-1" style="color: #64748b;">Última Actualización</label>
                            <p class="mb-0 fw-semibold" style="color: #003b73;">
                                <i class="fas fa-clock me-1" style="color: #4ec7d2;"></i>
                                {{ $administrador->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rol y Permisos -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3" style="color: #003b73;">
                    <i class="fas fa-shield-alt me-2" style="color: #4ec7d2;"></i>Rol y Permisos
                </h6>

                @if($administrador->is_super_admin)
                <!-- Super Admin Info -->
                <div class="p-4 border rounded" style="border: 2px solid #c084fc; border-radius: 15px; background: linear-gradient(135deg, rgba(168, 85, 247, 0.05) 0%, rgba(236, 72, 153, 0.05) 100%);">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #a855f7, #ec4899); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-crown" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-2" style="color: #6b21a8;">Super Administrador</h6>
                            <p class="mb-3 small" style="color: #6b21a8;">Control total del sistema educativo</p>
                            
                            <ul class="list-unstyled mb-0 small">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: #10b981;"></i>
                                    <span style="color: #6b21a8;">Acceso completo a todas las funciones</span>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: #10b981;"></i>
                                    <span style="color: #6b21a8;">Gestionar otros administradores</span>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: #10b981;"></i>
                                    <span style="color: #6b21a8;">Asignar y modificar permisos</span>
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-check-circle me-2" style="color: #10b981;"></i>
                                    <span style="color: #6b21a8;">Configuración completa del sistema</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @else
                <!-- Admin Regular Info -->
                <div class="p-4 border rounded" style="border: 2px solid #60a5fa; border-radius: 15px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(6, 182, 212, 0.05) 100%);">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #3b82f6, #06b6d4); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-shield" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-2" style="color: #1e3a8a;">Administrador</h6>
                            <p class="mb-3 small" style="color: #1e3a8a;">Permisos personalizables según funciones asignadas</p>
                            
                            @php
                                $permisos = is_array($administrador->permissions) 
                                    ? $administrador->permissions 
                                    : (is_string($administrador->permissions) 
                                        ? json_decode($administrador->permissions, true) 
                                        : []);
                                $permisos = $permisos ?? [];
                            @endphp

                            @if(count($permisos) > 0)
                            <div class="mb-3">
                                <label class="small fw-semibold mb-2 d-block" style="color: #1e3a8a;">
                                    <i class="fas fa-tasks me-1"></i>Permisos Asignados ({{ count($permisos) }})
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($permisos as $permiso)
                                    <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #1e3a8a; padding: 0.4rem 0.75rem; font-size: 0.75rem; font-weight: 600;">
                                        <i class="fas fa-check me-1" style="font-size: 0.65rem;"></i>
                                        {{ ucfirst(str_replace('_', ' ', $permiso)) }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="alert mb-0" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px;">
                                <small style="color: #991b1b;">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    <strong>Sin permisos asignados.</strong> Asigna permisos en la sección "Permisos y Roles".
                                </small>
                            </div>
                            @endif

                            <div class="mt-3 pt-3 border-top">
                                <p class="mb-2 small" style="color: #1e3a8a;"><strong>Restricciones:</strong></p>
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-1">
                                        <i class="fas fa-times-circle me-2" style="color: #ef4444;"></i>
                                        <span style="color: #64748b;">No puede gestionar otros administradores</span>
                                    </li>
                                    <li class="mb-0">
                                        <i class="fas fa-times-circle me-2" style="color: #ef4444;"></i>
                                        <span style="color: #64748b;">No puede modificar configuración del sistema</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Estado de Protección -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3" style="color: #003b73;">
                    <i class="fas fa-lock me-2" style="color: #4ec7d2;"></i>Estado de Seguridad
                </h6>

                @if($administrador->is_protected)
                <div class="alert mb-0" style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.1) 0%, rgba(245, 158, 11, 0.1) 100%); border: 2px solid #fbbf24; border-radius: 10px;">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fas fa-shield-alt" style="color: #f59e0b; font-size: 1.2rem; margin-top: 2px;"></i>
                        <div>
                            <strong class="d-block mb-1" style="color: #92400e; font-size: 0.9rem;">Usuario Protegido</strong>
                            <small style="color: #78350f;">
                                Esta cuenta está protegida y no puede ser editada ni eliminada. Esta configuración protege cuentas críticas del sistema.
                            </small>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert mb-0" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%); border: 2px solid #10b981; border-radius: 10px;">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.2rem; margin-top: 2px;"></i>
                        <div>
                            <strong class="d-block mb-1" style="color: #065f46; font-size: 0.9rem;">Usuario Editable</strong>
                            <small style="color: #047857;">
                                Esta cuenta puede ser editada o eliminada por otros Super Administradores.
                            </small>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-between gap-2 pt-3 border-top">
                <div>
                    @if(!$administrador->is_protected && !$administrador->is_super_admin)
                    <form action="{{ route('superadmin.administradores.destroy', $administrador->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('¿Estás seguro de eliminar este administrador? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn" 
                                style="background: #ef4444; color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3); transition: all 0.3s ease;">
                            <i class="fas fa-trash-alt me-1"></i>Eliminar
                        </button>
                    </form>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('superadmin.administradores.index') }}" 
                       class="btn" 
                       style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                    @if(!$administrador->is_protected)
                    <a href="{{ route('superadmin.administradores.edit', $administrador->id) }}" 
                       class="btn" 
                       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); transition: all 0.3s ease;">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

@push('styles')
<style>
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .badge {
        border-radius: 999px;
    }
</style>
@endpush
@endsection