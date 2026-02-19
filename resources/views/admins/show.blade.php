@extends('layouts.app')

@section('title', 'Detalles del Administrador')
@section('page-title', 'Detalles del Administrador')

@section('content')
<div class="container" style="max-width: 900px;">

    <a href="{{ route('admins.index') }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Volver a Administradores
    </a>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">

        {{-- Header con iniciales y estado --}}
        <div class="card-header border-0 py-4 px-4"
             style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div style="width:65px;height:65px;background:white;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid #4ec7d2;">
                    <span class="fw-bold" style="font-size:1.5rem;color:#00508f;">
                        {{ strtoupper(substr($admin->nombre ?? 'A', 0, 1) . substr($admin->apellido ?? 'D', 0, 1)) }}
                    </span>
                </div>
                <div class="flex-grow-1">
                    <h4 class="text-white fw-bold mb-0">{{ $admin->nombre_completo }}</h4>
                    <small class="text-white" style="opacity:0.85;">{{ $admin->rol ?? 'Administrador' }}</small>
                </div>
                <div>
                    @if($admin->estado === 'activo')
                        <span class="badge bg-success px-3 py-2" style="font-size:0.85rem;">
                            <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>Activo
                        </span>
                    @else
                        <span class="badge bg-danger px-3 py-2" style="font-size:0.85rem;">
                            <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>Inactivo
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-4">

            {{-- Información Personal --}}
            <h6 class="fw-bold mb-3 pb-2" style="color:#003b73; border-bottom: 2px solid rgba(0,80,143,0.2);">
                <i class="fas fa-user me-2" style="color:#4ec7d2;"></i>Información Personal
            </h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="text-muted mb-1" style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Nombre</p>
                        <p class="fw-semibold mb-0" style="color:#003b73;">{{ $admin->nombre ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="text-muted mb-1" style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Apellido</p>
                        <p class="fw-semibold mb-0" style="color:#003b73;">{{ $admin->apellido ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="text-muted mb-1" style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Identificación</p>
                        <p class="fw-semibold mb-0" style="color:#003b73;">{{ $admin->identificacion ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="text-muted mb-1" style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Fecha de Nacimiento</p>
                        <p class="fw-semibold mb-0" style="color:#003b73;">
                            {{ $admin->fecha_nacimiento ? \Carbon\Carbon::parse($admin->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Información de Contacto --}}
            <h6 class="fw-bold mb-3 pb-2" style="color:#003b73; border-bottom: 2px solid rgba(0,80,143,0.2);">
                <i class="fas fa-address-book me-2" style="color:#4ec7d2;"></i>Información de Contacto
            </h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="text-muted mb-1" style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Correo Electrónico</p>
                        <p class="fw-semibold mb-0" style="color:#003b73;word-break:break-all;">{{ $admin->correo ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="text-muted mb-1" style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Teléfono</p>
                        <p class="fw-semibold mb-0" style="color:#003b73;">{{ $admin->telefono ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="text-muted mb-1" style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Dirección</p>
                        <p class="fw-semibold mb-0" style="color:#003b73;">{{ $admin->direccion ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Permisos --}}
            @if(isset($admin->permisos) && count($admin->permisos) > 0)
            <h6 class="fw-bold mb-3 pb-2" style="color:#003b73; border-bottom: 2px solid rgba(0,80,143,0.2);">
                <i class="fas fa-key me-2" style="color:#4ec7d2;"></i>Permisos de Acceso
            </h6>
            <div class="card border-0 mb-4" style="background:#f8fafc; border-radius:10px;">
                <div class="card-body p-3">
                    <div class="row g-2">
                        @foreach($admin->permisos as $permiso)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 p-2 rounded"
                                     style="background:white; border:1px solid #e2e8f0;">
                                    <i class="fas fa-check-circle text-success" style="font-size:0.8rem;"></i>
                                    <span style="font-size:0.875rem;color:#374151;">
                                        {{ ucfirst(str_replace('_', ' ', $permiso)) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Observaciones --}}
            @if($admin->observaciones)
            <h6 class="fw-bold mb-3 pb-2" style="color:#003b73; border-bottom: 2px solid rgba(0,80,143,0.2);">
                <i class="fas fa-sticky-note me-2" style="color:#4ec7d2;"></i>Observaciones
            </h6>
            <div class="p-3 rounded mb-4" style="background:#f8fafc; border:1px solid #e2e8f0;">
                <p class="text-muted mb-0">{{ $admin->observaciones }}</p>
            </div>
            @endif

            {{-- Datos del Sistema --}}
            <h6 class="fw-bold mb-3 pb-2" style="color:#003b73; border-bottom: 2px solid rgba(0,80,143,0.2);">
                <i class="fas fa-info-circle me-2" style="color:#4ec7d2;"></i>Datos del Sistema
            </h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="text-muted mb-1" style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Fecha de Registro</p>
                        <p class="fw-semibold mb-0" style="color:#003b73;">
                            {{ $admin->created_at ? $admin->created_at->format('d/m/Y') : 'No disponible' }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="text-muted mb-1" style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Última Actualización</p>
                        <p class="fw-semibold mb-0" style="color:#003b73;">
                            {{ $admin->updated_at ? $admin->updated_at->format('d/m/Y') : 'No disponible' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="d-flex gap-3 pt-3" style="border-top: 1px solid #e2e8f0;">
                <a href="{{ route('admins.edit', $admin) }}"
                   class="btn btn-primary fw-semibold flex-fill" style="border-radius:8px;">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>

                <a href="{{ route('admins.index') }}"
                   class="btn btn-outline-secondary fw-semibold flex-fill" style="border-radius:8px;">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>

                {{-- Eliminar — usa mostrarModalDelete() del layout --}}
                <button type="button"
                        class="btn btn-danger fw-semibold flex-fill"
                        style="border-radius:8px;"
                        onclick="mostrarModalDelete(
                            '{{ route('admins.destroy', $admin) }}',
                            '¿Está seguro que desea eliminar este administrador? Se perderán todos sus datos de forma permanente.',
                            '{{ $admin->nombre_completo }}'
                        )">
                    <i class="fas fa-trash me-2"></i>Eliminar
                </button>
            </div>

        </div>
    </div>

</div>
@endsection
