@extends('layouts.app')

@section('title', 'Detalle del Padre/Tutor')

@section('page-title', 'Información del Padre/Tutor')

@section('topbar-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('padres.edit', $padre->id) }}" class="btn-back" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3); font-size: 0.9rem;">
            <i class="fas fa-edit"></i>
            Editar
        </a>
        <a href="{{ route('padres.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.2); font-size: 0.9rem;">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
@endsection

@section('content')
<div class="container" style="max-width: 1200px;">

    <!-- Datos Personales -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #4ec7d2; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1rem;">
                <i class="fas fa-id-card me-2" style="color: #4ec7d2;"></i>
                Datos Personales
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Columna Izquierda -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Nombre Completo</label>
                        <div class="fw-semibold" style="color: #003b73; font-size: 1.1rem;">
                            <i class="fas fa-user-circle me-2" style="color: #4ec7d2;"></i>
                            {{ $padre->nombre }} {{ $padre->apellido }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">DNI</label>
                        <div class="font-monospace" style="color: #00508f; font-size: 1rem;">
                            {{ $padre->dni }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Parentesco</label>
                        <div>
                            <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.85rem;">
                                {{ ucfirst(str_replace('_', ' ', $padre->parentesco)) }}
                            </span>
                            @if($padre->parentesco === 'otro' && $padre->parentesco_otro)
                                <br><small class="text-muted mt-1 d-block">{{ $padre->parentesco_otro }}</small>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Estado</label>
                        <div>
                            @if($padre->estado)
                                <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.4rem 0.9rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.85rem;">
                                    <i class="fas fa-circle" style="font-size: 0.5rem; color: #4ec7d2;"></i> Activo
                                </span>
                            @else
                                <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.4rem 0.9rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.85rem;">
                                    <i class="fas fa-circle" style="font-size: 0.5rem;"></i> Inactivo
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Fecha de Registro</label>
                        <div style="color: #00508f; font-size: 0.9rem;">
                            <i class="fas fa-calendar-plus me-1" style="font-size: 0.8rem;"></i>
                            {{ $padre->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Última Actualización</label>
                        <div style="color: #00508f; font-size: 0.9rem;">
                            <i class="fas fa-calendar-check me-1" style="font-size: 0.8rem;"></i>
                            {{ $padre->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Datos de Contacto -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #4ec7d2; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1rem;">
                <i class="fas fa-phone me-2" style="color: #4ec7d2;"></i>
                Datos de Contacto
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Correo Electrónico</label>
                        <div>
                            @if($padre->correo)
                                <a href="mailto:{{ $padre->correo }}" style="color: #00508f; text-decoration: none; font-size: 0.95rem;">
                                    <i class="fas fa-envelope me-2" style="color: #4ec7d2;"></i>
                                    {{ $padre->correo }}
                                </a>
                            @else
                                <span class="text-muted">No registrado</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Teléfono Principal</label>
                        <div>
                            @if($padre->telefono)
                                <a href="tel:{{ $padre->telefono }}" style="color: #00508f; text-decoration: none; font-size: 0.95rem;">
                                    <i class="fas fa-phone me-2" style="color: #4ec7d2;"></i>
                                    {{ $padre->telefono }}
                                </a>
                            @else
                                <span class="text-muted">No registrado</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Teléfono Secundario</label>
                        <div>
                            @if($padre->telefono_secundario)
                                <a href="tel:{{ $padre->telefono_secundario }}" style="color: #00508f; text-decoration: none; font-size: 0.95rem;">
                                    <i class="fas fa-mobile-alt me-2" style="color: #4ec7d2;"></i>
                                    {{ $padre->telefono_secundario }}
                                </a>
                            @else
                                <span class="text-muted">No registrado</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Dirección</label>
                        <div style="color: #003b73; font-size: 0.95rem;">
                            <i class="fas fa-map-marker-alt me-2" style="color: #4ec7d2;"></i>
                            {{ $padre->direccion ?? 'No registrada' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Laboral -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #4ec7d2; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1rem;">
                <i class="fas fa-briefcase me-2" style="color: #4ec7d2;"></i>
                Información Laboral
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Ocupación</label>
                        <div style="color: #003b73; font-size: 0.95rem;">
                            {{ $padre->ocupacion ?? 'No registrada' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Lugar de Trabajo</label>
                        <div style="color: #003b73; font-size: 0.95rem;">
                            {{ $padre->lugar_trabajo ?? 'No registrado' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Teléfono de Trabajo</label>
                        <div>
                            @if($padre->telefono_trabajo)
                                <a href="tel:{{ $padre->telefono_trabajo }}" style="color: #00508f; text-decoration: none; font-size: 0.95rem;">
                                    <i class="fas fa-phone-office me-2" style="color: #4ec7d2;"></i>
                                    {{ $padre->telefono_trabajo }}
                                </a>
                            @else
                                <span class="text-muted">No registrado</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($padre->observaciones)
    <!-- Observaciones -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #4ec7d2; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1rem;">
                <i class="fas fa-clipboard me-2" style="color: #4ec7d2;"></i>
                Observaciones
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="alert mb-0" style="background: rgba(78, 199, 210, 0.1); border: 1px solid #4ec7d2; border-radius: 8px; color: #003b73;">
                {{ $padre->observaciones }}
            </div>
        </div>
    </div>
    @endif

    <!-- Estudiantes a su Cargo -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #4ec7d2; border-radius: 10px 10px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1rem;">
                    <i class="fas fa-graduation-cap me-2" style="color: #4ec7d2;"></i>
                    Estudiantes a su Cargo
                </h5>
                <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.4rem 0.9rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.85rem;">
                    {{ $padre->estudiantes->count() }} Estudiante(s)
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            @if($padre->estudiantes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                            <tr>
                                <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">#</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Nombre Completo</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">DNI</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Grado</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Sección</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Estado</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($padre->estudiantes as $index => $estudiante)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="px-3 py-2">{{ $index + 1 }}</td>
                                <td class="px-3 py-2">
                                    <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                        <i class="fas fa-user-graduate me-1" style="color: #4ec7d2;"></i>
                                        {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }} 
                                        {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                                    </div>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="font-monospace small" style="color: #00508f; font-size: 0.85rem;">{{ $estudiante->dni }}</span>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">{{ $estudiante->grado }}</span>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">{{ $estudiante->seccion }}</span>
                                </td>
                                <td class="px-3 py-2">
                                    @if($estudiante->estado === 'activo')
                                        <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                                            <i class="fas fa-circle" style="font-size: 0.4rem; color: #4ec7d2;"></i> Activo
                                        </span>
                                    @else
                                        <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.75rem;">
                                            <i class="fas fa-circle" style="font-size: 0.4rem;"></i> Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-end">
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}" 
                                       class="btn btn-sm" 
                                       style="border-radius: 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                       title="Ver detalles"
                                       onmouseover="this.style.background='#00508f'; this.style.color='white';"
                                       onmouseout="this.style.background='white'; this.style.color='#00508f';">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-graduate fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                    <h6 style="color: #003b73;">No hay estudiantes vinculados</h6>
                    <p class="text-muted small mb-0">Este padre/tutor no tiene estudiantes asignados</p>
                </div>
            @endif
        </div>
    </div>

</div>

@push('styles')
<style>
    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }

    .table tbody tr:hover {
        background-color: rgba(191, 217, 234, 0.08);
    }
</style>
@endpush
@endsection