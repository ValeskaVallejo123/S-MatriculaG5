@extends('layouts.app')

@section('title', 'Editar Matrícula')

@section('content')
<div class="container-fluid" style="max-width: 1200px;">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #003b73; font-weight: 700;">
                <i class="fas fa-edit"></i> Editar Matrícula
            </h2>
            <p class="text-muted mb-0">Código: <strong>{{ $matricula->codigo_matricula }}</strong></p>
        </div>
        <div>
            <a href="{{ route('matriculas.show', $matricula->id) }}" class="btn btn-info me-2">
                <i class="fas fa-eye"></i> Ver Detalles
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

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        <strong>¡Error!</strong> Por favor corrige los siguientes errores:
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('matriculas.update', $matricula->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Información de la Matrícula -->
        <div class="card shadow-sm mb-4">
            <div class="card-header" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); color: white;">
                <h5 class="mb-0">
                    <i class="fas fa-clipboard-check"></i> Información de la Matrícula
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="codigo_matricula" class="form-label fw-bold">
                            <i class="fas fa-barcode"></i> Código de Matrícula
                        </label>
                        <input
                            type="text"
                            class="form-control @error('codigo_matricula') is-invalid @enderror"
                            id="codigo_matricula"
                            name="codigo_matricula"
                            value="{{ old('codigo_matricula', $matricula->codigo_matricula) }}"
                            readonly
                        >
                        @error('codigo_matricula')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="anio_lectivo" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt"></i> Año Lectivo <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('anio_lectivo') is-invalid @enderror"
                            id="anio_lectivo"
                            name="anio_lectivo"
                            value="{{ old('anio_lectivo', $matricula->anio_lectivo) }}"
                            placeholder="2025"
                        >
                        @error('anio_lectivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="fecha_matricula" class="form-label fw-bold">
                            <i class="fas fa-calendar"></i> Fecha de Matrícula <span class="text-danger">*</span>
                        </label>
                        <input
                            type="date"
                            class="form-control @error('fecha_matricula') is-invalid @enderror"
                            id="fecha_matricula"
                            name="fecha_matricula"
                            value="{{ old('fecha_matricula', $matricula->fecha_matricula ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('Y-m-d') : '') }}"
                        >
                        @error('fecha_matricula')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="estado" class="form-label fw-bold">
                            <i class="fas fa-flag"></i> Estado <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado">
                            <option value="pendiente" {{ old('estado', $matricula->estado) === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobada" {{ old('estado', $matricula->estado) === 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="rechazada" {{ old('estado', $matricula->estado) === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                            <option value="cancelada" {{ old('estado', $matricula->estado) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6" id="motivo-rechazo-container" @if(old('estado', $matricula->estado) !== 'rechazada') style="display: none;" @endif>
                        <label for="motivo_rechazo" class="form-label fw-bold">
                            <i class="fas fa-exclamation-triangle"></i> Motivo del Rechazo
                        </label>
                        <input
                            type="text"
                            class="form-control @error('motivo_rechazo') is-invalid @enderror"
                            id="motivo_rechazo"
                            name="motivo_rechazo"
                            value="{{ old('motivo_rechazo', $matricula->motivo_rechazo) }}"
                            placeholder="Especificar motivo del rechazo"
                        >
                        @error('motivo_rechazo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="observaciones" class="form-label fw-bold">
                            <i class="fas fa-sticky-note"></i> Observaciones
                        </label>
                        <textarea
                            class="form-control @error('observaciones') is-invalid @enderror"
                            id="observaciones"
                            name="observaciones"
                            rows="3"
                            placeholder="Agregar observaciones adicionales..."
                        >{{ old('observaciones', $matricula->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Nota:</strong> Solo sube nuevos archivos si deseas reemplazar los existentes. Los archivos actuales se mantendrán si no subes ninguno nuevo.
                </div>

                <div class="row g-3">
                    <!-- Foto del Estudiante -->
                    <div class="col-md-6">
                        <label for="foto_estudiante" class="form-label fw-bold">
                            <i class="fas fa-camera"></i> Foto del Estudiante
                        </label>
                        @if($matricula->foto_estudiante)
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-check-circle text-success"></i> Archivo actual:
                                <a href="{{ asset('storage/' . $matricula->foto_estudiante) }}" target="_blank">Ver foto</a>
                            </small>
                        </div>
                        @endif
                        <input
                            type="file"
                            class="form-control @error('foto_estudiante') is-invalid @enderror"
                            id="foto_estudiante"
                            name="foto_estudiante"
                            accept="image/*"
                        >
                        <small class="text-muted">Formatos: JPG, PNG (Max: 2MB)</small>
                        @error('foto_estudiante')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Acta de Nacimiento -->
                    <div class="col-md-6">
                        <label for="acta_nacimiento" class="form-label fw-bold">
                            <i class="fas fa-file-alt"></i> Acta de Nacimiento
                        </label>
                        @if($matricula->acta_nacimiento)
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-check-circle text-success"></i> Archivo actual:
                                <a href="{{ asset('storage/' . $matricula->acta_nacimiento) }}" target="_blank">Ver documento</a>
                            </small>
                        </div>
                        @endif
                        <input
                            type="file"
                            class="form-control @error('acta_nacimiento') is-invalid @enderror"
                            id="acta_nacimiento"
                            name="acta_nacimiento"
                            accept=".pdf,image/*"
                        >
                        <small class="text-muted">Formatos: PDF, JPG, PNG (Max: 5MB)</small>
                        @error('acta_nacimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Certificado de Estudios -->
                    <div class="col-md-6">
                        <label for="certificado_estudios" class="form-label fw-bold">
                            <i class="fas fa-certificate"></i> Certificado de Estudios
                        </label>
                        @if($matricula->certificado_estudios)
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-check-circle text-success"></i> Archivo actual:
                                <a href="{{ asset('storage/' . $matricula->certificado_estudios) }}" target="_blank">Ver documento</a>
                            </small>
                        </div>
                        @endif
                        <input
                            type="file"
                            class="form-control @error('certificado_estudios') is-invalid @enderror"
                            id="certificado_estudios"
                            name="certificado_estudios"
                            accept=".pdf,image/*"
                        >
                        <small class="text-muted">Formatos: PDF, JPG, PNG (Max: 5MB)</small>
                        @error('certificado_estudios')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Constancia de Conducta -->
                    <div class="col-md-6">
                        <label for="constancia_conducta" class="form-label fw-bold">
                            <i class="fas fa-award"></i> Constancia de Conducta
                        </label>
                        @if($matricula->constancia_conducta)
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-check-circle text-success"></i> Archivo actual:
                                <a href="{{ asset('storage/' . $matricula->constancia_conducta) }}" target="_blank">Ver documento</a>
                            </small>
                        </div>
                        @endif
                        <input
                            type="file"
                            class="form-control @error('constancia_conducta') is-invalid @enderror"
                            id="constancia_conducta"
                            name="constancia_conducta"
                            accept=".pdf,image/*"
                        >
                        <small class="text-muted">Formatos: PDF, JPG, PNG (Max: 5MB)</small>
                        @error('constancia_conducta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- DNI del Estudiante -->
                    <div class="col-md-6">
                        <label for="foto_dni_estudiante" class="form-label fw-bold">
                            <i class="fas fa-id-card"></i> DNI del Estudiante
                        </label>
                        @if($matricula->foto_dni_estudiante)
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-check-circle text-success"></i> Archivo actual:
                                <a href="{{ asset('storage/' . $matricula->foto_dni_estudiante) }}" target="_blank">Ver foto</a>
                            </small>
                        </div>
                        @endif
                        <input
                            type="file"
                            class="form-control @error('foto_dni_estudiante') is-invalid @enderror"
                            id="foto_dni_estudiante"
                            name="foto_dni_estudiante"
                            accept="image/*"
                        >
                        <small class="text-muted">Formatos: JPG, PNG (Max: 2MB)</small>
                        @error('foto_dni_estudiante')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- DNI del Padre -->
                    <div class="col-md-6">
                        <label for="foto_dni_padre" class="form-label fw-bold">
                            <i class="fas fa-id-card-alt"></i> DNI del Padre/Tutor
                        </label>
                        @if($matricula->foto_dni_padre)
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-check-circle text-success"></i> Archivo actual:
                                <a href="{{ asset('storage/' . $matricula->foto_dni_padre) }}" target="_blank">Ver foto</a>
                            </small>
                        </div>
                        @endif
                        <input
                            type="file"
                            class="form-control @error('foto_dni_padre') is-invalid @enderror"
                            id="foto_dni_padre"
                            name="foto_dni_padre"
                            accept="image/*"
                        >
                        <small class="text-muted">Formatos: JPG, PNG (Max: 2MB)</small>
                        @error('foto_dni_padre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('matriculas.show', $matricula->id) }}" class="btn btn-outline-secondary btn-lg w-100">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .form-label.fw-bold {
        color: #003b73;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.25rem rgba(78, 199, 210, 0.25);
    }

    .card {
        border: none;
    }

    .card-header {
        border-bottom: 2px solid rgba(0, 59, 115, 0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const estadoSelect = document.getElementById('estado');
    const motivoContainer = document.getElementById('motivo-rechazo-container');

    // Mostrar/ocultar campo de motivo según el estado
    estadoSelect.addEventListener('change', function() {
        if (this.value === 'rechazada') {
            motivoContainer.style.display = 'block';
        } else {
            motivoContainer.style.display = 'none';
            document.getElementById('motivo_rechazo').value = '';
        }
    });
});
</script>
@endsection
