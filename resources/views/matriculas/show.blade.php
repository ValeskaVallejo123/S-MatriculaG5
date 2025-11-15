@extends('layouts.app')

@section('title', 'Detalles de Matrícula')

@section('content')
<div class="container-fluid" style="max-width: 1200px;">
    
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #003b73; font-weight: 700;">
                <i class="fas fa-id-card"></i> Detalles de Matrícula
            </h2>
            <p class="text-muted mb-0">Código: <strong>{{ $matricula->codigo_matricula }}</strong></p>
        </div>
        <div>
            <a href="{{ route('matriculas.edit', $matricula->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('matriculas.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Estado de la Matrícula -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-2">
                        <i class="fas fa-clipboard-check"></i> Estado de la Matrícula
                    </h5>
                    <p class="mb-0 text-muted">Registrada el {{ $matricula->fecha_matricula ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') : 'N/A' }}</p>
                </div>
                <div class="col-md-4 text-end">
                    @if($matricula->estado === 'aprobada')
                        <span class="badge bg-success" style="font-size: 1.1rem; padding: 0.5rem 1rem;">
                            <i class="fas fa-check-circle"></i> APROBADA
                        </span>
                    @elseif($matricula->estado === 'pendiente')
                        <span class="badge bg-warning" style="font-size: 1.1rem; padding: 0.5rem 1rem;">
                            <i class="fas fa-clock"></i> PENDIENTE
                        </span>
                    @elseif($matricula->estado === 'rechazada')
                        <span class="badge bg-danger" style="font-size: 1.1rem; padding: 0.5rem 1rem;">
                            <i class="fas fa-times-circle"></i> RECHAZADA
                        </span>
                    @else
                        <span class="badge bg-secondary" style="font-size: 1.1rem; padding: 0.5rem 1rem;">
                            <i class="fas fa-question-circle"></i> {{ strtoupper($matricula->estado) }}
                        </span>
                    @endif
                </div>
            </div>
            
            @if($matricula->estado === 'rechazada' && $matricula->motivo_rechazo)
            <div class="alert alert-danger mt-3 mb-0">
                <strong><i class="fas fa-exclamation-triangle"></i> Motivo del rechazo:</strong><br>
                {{ $matricula->motivo_rechazo }}
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Información del Estudiante -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-user-graduate"></i> Información del Estudiante
                    </h5>
                </div>
                <div class="card-body">
                    @if($matricula->estudiante)
                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-user"></i> Nombre Completo:
                        </label>
                        <p class="mb-0">{{ $matricula->estudiante->nombre }} {{ $matricula->estudiante->apellido }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-id-card"></i> DNI:
                        </label>
                        <p class="mb-0">{{ $matricula->estudiante->dni ?? 'No registrado' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-birthday-cake"></i> Fecha de Nacimiento:
                        </label>
                        <p class="mb-0">
                            {{ $matricula->estudiante->fecha_nacimiento ? \Carbon\Carbon::parse($matricula->estudiante->fecha_nacimiento)->format('d/m/Y') : 'No registrada' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-venus-mars"></i> Sexo:
                        </label>
                        <p class="mb-0">{{ ucfirst($matricula->estudiante->sexo ?? 'No especificado') }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-graduation-cap"></i> Grado y Sección:
                        </label>
                        <p class="mb-0">{{ $matricula->estudiante->grado ?? 'N/A' }} - Sección {{ $matricula->estudiante->seccion ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-map-marker-alt"></i> Dirección:
                        </label>
                        <p class="mb-0">{{ $matricula->estudiante->direccion ?? 'No registrada' }}</p>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-phone"></i> Teléfono:
                        </label>
                        <p class="mb-0">{{ $matricula->estudiante->telefono ?? 'No registrado' }}</p>
                    </div>
                    @else
                    <p class="text-muted mb-0">
                        <i class="fas fa-exclamation-circle"></i> No hay información del estudiante disponible
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información del Padre/Tutor -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-user-friends"></i> Información del Padre/Tutor
                    </h5>
                </div>
                <div class="card-body">
                    @if($matricula->padre)
                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-user"></i> Nombre Completo:
                        </label>
                        <p class="mb-0">{{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-id-card"></i> DNI:
                        </label>
                        <p class="mb-0">{{ $matricula->padre->dni ?? 'No registrado' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-users"></i> Parentesco:
                        </label>
                        <p class="mb-0">{{ $matricula->padre->parentesco_formateado ?? ucfirst($matricula->padre->parentesco) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-envelope"></i> Correo:
                        </label>
                        <p class="mb-0">{{ $matricula->padre->correo ?? 'No registrado' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-phone"></i> Teléfono:
                        </label>
                        <p class="mb-0">{{ $matricula->padre->telefono ?? 'No registrado' }}</p>
                    </div>

                    @if($matricula->padre->telefono_secundario)
                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-phone-alt"></i> Teléfono Secundario:
                        </label>
                        <p class="mb-0">{{ $matricula->padre->telefono_secundario }}</p>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-map-marker-alt"></i> Dirección:
                        </label>
                        <p class="mb-0">{{ $matricula->padre->direccion ?? 'No registrada' }}</p>
                    </div>

                    @if($matricula->padre->ocupacion)
                    <div class="mb-0">
                        <label class="form-label fw-bold text-primary">
                            <i class="fas fa-briefcase"></i> Ocupación:
                        </label>
                        <p class="mb-0">{{ $matricula->padre->ocupacion }}</p>
                    </div>
                    @endif
                    @else
                    <p class="text-muted mb-0">
                        <i class="fas fa-exclamation-circle"></i> No hay información del padre/tutor disponible
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Documentos Adjuntos -->
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background-color: #e8f4f8;">
            <h5 class="mb-0" style="color: #003b73;">
                <i class="fas fa-paperclip"></i> Documentos Adjuntos
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-camera fa-2x mb-2" style="color: #003b73;"></i>
                        <h6 class="mb-2">Foto del Estudiante</h6>
                        @if($matricula->foto_estudiante)
                            <a href="{{ asset('storage/' . $matricula->foto_estudiante) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            <span class="text-muted">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-file-alt fa-2x mb-2" style="color: #003b73;"></i>
                        <h6 class="mb-2">Acta de Nacimiento</h6>
                        @if($matricula->acta_nacimiento)
                            <a href="{{ asset('storage/' . $matricula->acta_nacimiento) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        @else
                            <span class="text-muted">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-certificate fa-2x mb-2" style="color: #003b73;"></i>
                        <h6 class="mb-2">Certificado de Estudios</h6>
                        @if($matricula->certificado_estudios)
                            <a href="{{ asset('storage/' . $matricula->certificado_estudios) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        @else
                            <span class="text-muted">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-award fa-2x mb-2" style="color: #003b73;"></i>
                        <h6 class="mb-2">Constancia de Conducta</h6>
                        @if($matricula->constancia_conducta)
                            <a href="{{ asset('storage/' . $matricula->constancia_conducta) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        @else
                            <span class="text-muted">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-id-card fa-2x mb-2" style="color: #003b73;"></i>
                        <h6 class="mb-2">DNI del Estudiante</h6>
                        @if($matricula->foto_dni_estudiante)
                            <a href="{{ asset('storage/' . $matricula->foto_dni_estudiante) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            <span class="text-muted">No adjuntado</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3 text-center">
                        <i class="fas fa-id-card-alt fa-2x mb-2" style="color: #003b73;"></i>
                        <h6 class="mb-2">DNI del Padre/Tutor</h6>
                        @if($matricula->foto_dni_padre)
                            <a href="{{ asset('storage/' . $matricula->foto_dni_padre) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            <span class="text-muted">No adjuntado</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Adicional -->
    @if($matricula->observaciones)
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background-color: #fff3cd;">
            <h5 class="mb-0" style="color: #856404;">
                <i class="fas fa-sticky-note"></i> Observaciones
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-0">{{ $matricula->observaciones }}</p>
        </div>
    </div>
    @endif

    <!-- Información del Sistema -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row text-muted small">
                <div class="col-md-6">
                    <i class="fas fa-calendar-plus"></i> 
                    <strong>Creado:</strong> {{ $matricula->created_at ? $matricula->created_at->format('d/m/Y H:i') : 'N/A' }}
                </div>
                <div class="col-md-6 text-end">
                    <i class="fas fa-calendar-check"></i> 
                    <strong>Última actualización:</strong> {{ $matricula->updated_at ? $matricula->updated_at->format('d/m/Y H:i') : 'N/A' }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
    }
    
    .card-header {
        border-bottom: 2px solid rgba(0, 59, 115, 0.1);
    }
    
    .border.rounded {
        transition: all 0.3s ease;
    }
    
    .border.rounded:hover {
        box-shadow: 0 2px 8px rgba(0, 59, 115, 0.1);
        border-color: #4ec7d2 !important;
    }
</style>
@endsection