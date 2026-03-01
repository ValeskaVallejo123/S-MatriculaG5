@extends('layouts.app')

@section('title', 'Detalles de Matrícula')
@section('page-title', 'Detalles de Matrícula')

@section('topbar-actions')
    <a href="{{ route('matriculas.edit', $matricula->id) }}" 
       style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; font-size: 0.9rem; margin-right: 0.5rem;">
        <i class="fas fa-edit"></i>
        Editar
    </a>
    <a href="{{ route('matriculas.index') }}" 
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Header con código y estado -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
                            <i class="fas fa-id-card" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold" style="color: #003b73;">{{ $matricula->codigo_matricula }}</h5>
                            <p class="mb-0" style="color: #64748b; font-size: 0.875rem;">
                                <i class="fas fa-calendar me-1"></i>Registrada el {{ $matricula->fecha_matricula ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    @if($matricula->estado === 'aprobada')
                        <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 0.75rem 1.5rem; border-radius: 10px; font-size: 1rem; font-weight: 600; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-check-circle me-2"></i>APROBADA
                        </span>
                    @elseif($matricula->estado === 'pendiente')
                        <span class="badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 0.75rem 1.5rem; border-radius: 10px; font-size: 1rem; font-weight: 600; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-clock me-2"></i>PENDIENTE
                        </span>
                    @elseif($matricula->estado === 'rechazada')
                        <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 0.75rem 1.5rem; border-radius: 10px; font-size: 1rem; font-weight: 600; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">
                            <i class="fas fa-times-circle me-2"></i>RECHAZADA
                        </span>
                    @else
                        <span class="badge" style="background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%); padding: 0.75rem 1.5rem; border-radius: 10px; font-size: 1rem; font-weight: 600; box-shadow: 0 4px 12px rgba(148, 163, 184, 0.3);">
                            <i class="fas fa-question-circle me-2"></i>{{ strtoupper($matricula->estado) }}
                        </span>
                    @endif
                </div>
            </div>
            
            @if($matricula->estado === 'rechazada' && $matricula->motivo_rechazo)
            <div class="alert mt-3 mb-0" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 10px;">
                <div class="d-flex align-items-start gap-2">
                    <i class="fas fa-exclamation-triangle mt-1" style="color: #ef4444;"></i>
                    <div>
                        <strong style="color: #ef4444; font-size: 0.875rem;">Motivo del rechazo:</strong>
                        <p class="mb-0 mt-1" style="color: #64748b; font-size: 0.875rem;">{{ $matricula->motivo_rechazo }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Información del Estudiante -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-user-graduate" style="font-size: 1.25rem;"></i>
                        <h5 class="mb-0 fw-bold">Información del Estudiante</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($matricula->estudiante)
                    <div class="info-item">
                        <label><i class="fas fa-user"></i> Nombre Completo</label>
                        <p>{{ $matricula->estudiante->nombre }} {{ $matricula->estudiante->apellido }}</p>
                    </div>

                    <div class="info-item">
                        <label><i class="fas fa-id-card"></i> DNI</label>
                        <p>{{ $matricula->estudiante->dni ?? 'No registrado' }}</p>
                    </div>

                    <div class="info-item">
                        <label><i class="fas fa-birthday-cake"></i> Fecha de Nacimiento</label>
                        <p>{{ $matricula->estudiante->fecha_nacimiento ? \Carbon\Carbon::parse($matricula->estudiante->fecha_nacimiento)->format('d/m/Y') : 'No registrada' }}</p>
                    </div>

                    <div class="info-item">
                        <label><i class="fas fa-venus-mars"></i> Sexo</label>
                        <p>{{ ucfirst($matricula->estudiante->sexo ?? 'No especificado') }}</p>
                    </div>

                    <div class="info-item">
                        <label><i class="fas fa-graduation-cap"></i> Grado y Sección</label>
                        <p>{{ $matricula->estudiante->grado ?? 'N/A' }} - Sección {{ $matricula->estudiante->seccion ?? 'N/A' }}</p>
                    </div>

                    <div class="info-item">
                        <label><i class="fas fa-map-marker-alt"></i> Dirección</label>
                        <p>{{ $matricula->estudiante->direccion ?? 'No registrada' }}</p>
                    </div>

                    <div class="info-item mb-0">
                        <label><i class="fas fa-phone"></i> Teléfono</label>
                        <p>{{ $matricula->estudiante->telefono ?? 'No registrado' }}</p>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                        <p class="text-muted mb-0">No hay información del estudiante disponible</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información del Padre/Tutor -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-user-friends" style="font-size: 1.25rem;"></i>
                        <h5 class="mb-0 fw-bold">Información del Padre/Tutor</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($matricula->padre)
                    <div class="info-item">
                        <label><i class="fas fa-user"></i> Nombre Completo</label>
                        <p>{{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}</p>
                    </div>

                    <div class="info-item">
                        <label><i class="fas fa-id-card"></i> DNI</label>
                        <p>{{ $matricula->padre->dni ?? 'No registrado' }}</p>
                    </div>

                    <div class="info-item">
                        <label><i class="fas fa-users"></i> Parentesco</label>
                        <p>{{ $matricula->padre->parentesco_formateado ?? ucfirst($matricula->padre->parentesco) }}</p>
                    </div>

                    <div class="info-item">
                        <label><i class="fas fa-envelope"></i> Correo</label>
                        <p>{{ $matricula->padre->correo ?? 'No registrado' }}</p>
                    </div>

                    <div class="info-item">
                        <label><i class="fas fa-phone"></i> Teléfono</label>
                        <p>{{ $matricula->padre->telefono ?? 'No registrado' }}</p>
                    </div>

                    @if($matricula->padre->telefono_secundario)
                    <div class="info-item">
                        <label><i class="fas fa-phone-alt"></i> Teléfono Secundario</label>
                        <p>{{ $matricula->padre->telefono_secundario }}</p>
                    </div>
                    @endif

                    <div class="info-item">
                        <label><i class="fas fa-map-marker-alt"></i> Dirección</label>
                        <p>{{ $matricula->padre->direccion ?? 'No registrada' }}</p>
                    </div>

                    @if($matricula->padre->ocupacion)
                    <div class="info-item mb-0">
                        <label><i class="fas fa-briefcase"></i> Ocupación</label>
                        <p>{{ $matricula->padre->ocupacion }}</p>
                    </div>
                    @endif
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                        <p class="text-muted mb-0">No hay información del padre/tutor disponible</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Documentos Adjuntos -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-paperclip" style="font-size: 1.25rem;"></i>
                <h5 class="mb-0 fw-bold">Documentos Adjuntos</h5>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <!-- Foto del Estudiante -->
                <div class="col-md-4 col-lg-2">
                    <div class="documento-card">
                        <div class="documento-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        <h6>Foto del Estudiante</h6>
                        @if($matricula->foto_estudiante)
                            <a href="{{ asset('storage/' . $matricula->foto_estudiante) }}" target="_blank" class="btn-documento">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            <span class="documento-empty">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <!-- Acta de Nacimiento -->
                <div class="col-md-4 col-lg-2">
                    <div class="documento-card">
                        <div class="documento-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h6>Acta de Nacimiento</h6>
                        @if($matricula->acta_nacimiento)
                            <a href="{{ asset('storage/' . $matricula->acta_nacimiento) }}" target="_blank" class="btn-documento">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        @else
                            <span class="documento-empty">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <!-- Certificado de Estudios -->
                <div class="col-md-4 col-lg-2">
                    <div class="documento-card">
                        <div class="documento-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h6>Certificado de Estudios</h6>
                        @if($matricula->certificado_estudios)
                            <a href="{{ asset('storage/' . $matricula->certificado_estudios) }}" target="_blank" class="btn-documento">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        @else
                            <span class="documento-empty">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <!-- Constancia de Conducta -->
                <div class="col-md-4 col-lg-2">
                    <div class="documento-card">
                        <div class="documento-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h6>Constancia de Conducta</h6>
                        @if($matricula->constancia_conducta)
                            <a href="{{ asset('storage/' . $matricula->constancia_conducta) }}" target="_blank" class="btn-documento">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        @else
                            <span class="documento-empty">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <!-- DNI del Estudiante -->
                <div class="col-md-4 col-lg-2">
                    <div class="documento-card">
                        <div class="documento-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h6>DNI Estudiante</h6>
                        @if($matricula->foto_dni_estudiante)
                            <a href="{{ asset('storage/' . $matricula->foto_dni_estudiante) }}" target="_blank" class="btn-documento">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            <span class="documento-empty">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <!-- DNI del Padre/Tutor -->
                <div class="col-md-4 col-lg-2">
                    <div class="documento-card">
                        <div class="documento-icon">
                            <i class="fas fa-id-card-alt"></i>
                        </div>
                        <h6>DNI Padre/Tutor</h6>
                        @if($matricula->foto_dni_padre)
                            <a href="{{ asset('storage/' . $matricula->foto_dni_padre) }}" target="_blank" class="btn-documento">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            <span class="documento-empty">No adjuntado</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Observaciones -->
    @if($matricula->observaciones)
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-left: 4px solid #f59e0b !important;">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3" style="color: #f59e0b;">
                <i class="fas fa-sticky-note me-2"></i>Observaciones
            </h6>
            <p class="mb-0" style="color: #64748b;">{{ $matricula->observaciones }}</p>
        </div>
    </div>
    @endif

    <!-- Información del Sistema -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-3">
            <div class="row text-center">
                <div class="col-md-6" style="color: #64748b; font-size: 0.875rem;">
                    <i class="fas fa-calendar-plus me-2" style="color: #4ec7d2;"></i>
                    <strong>Creado:</strong> {{ $matricula->created_at ? $matricula->created_at->format('d/m/Y H:i') : 'N/A' }}
                </div>
                <div class="col-md-6" style="color: #64748b; font-size: 0.875rem;">
                    <i class="fas fa-calendar-check me-2" style="color: #4ec7d2;"></i>
                    <strong>Última actualización:</strong> {{ $matricula->updated_at ? $matricula->updated_at->format('d/m/Y H:i') : 'N/A' }}
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .info-item {
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .info-item label {
        display: block;
        color: #00508f;
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .info-item label i {
        color: #4ec7d2;
        margin-right: 0.5rem;
        width: 16px;
        text-align: center;
    }

    .info-item p {
        margin: 0;
        color: #1e293b;
        font-size: 0.938rem;
        padding-left: 1.75rem;
    }

    .documento-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem 1rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .documento-card:hover {
        border-color: #4ec7d2;
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.2);
        transform: translateY(-2px);
    }

    .documento-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);
    }

    .documento-icon i {
        color: white;
        font-size: 1.25rem;
    }

    .documento-card h6 {
        color: #003b73;
        font-size: 0.813rem;
        font-weight: 600;
        margin-bottom: 1rem;
        min-height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-documento {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.813rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);
    }

    .btn-documento:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4);
        color: white;
    }

    .documento-empty {
        color: #94a3b8;
        font-size: 0.813rem;
        font-style: italic;
    }
</style>
@endpush
@endsection