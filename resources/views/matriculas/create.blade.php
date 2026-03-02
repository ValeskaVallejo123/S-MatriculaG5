@extends('layouts.app')

@section('title', 'Registrar Matrícula')

@section('content')

<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #4ec7d2 !important;
        box-shadow: 0 0 0 0.25rem rgba(78, 199, 210, 0.25) !important;
    }

    .section-header {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .field-icon {
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #00508f;
        font-size: 0.85rem;
        z-index: 10;
    }

    .field-icon-top {
        left: 12px; top: 18px;
        color: #00508f;
        font-size: 0.85rem;
    }

    .custom-input {
        border: 2px solid #bfd9ea;
        border-radius: 8px;
        padding: 0.6rem 1rem 0.6rem 2.8rem;
        transition: all 0.3s ease;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        color: white;
        padding: 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);
    }

    .btn-primary-custom:hover {
        opacity: 0.92;
        box-shadow: 0 6px 18px rgba(78, 199, 210, 0.4);
        color: white;
    }

    .btn-cancel-custom {
        background: white;
        color: #003b73;
        padding: 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        border: 2px solid #bfd9ea;
        transition: all 0.3s ease;
    }

    .btn-cancel-custom:hover {
        background: #f0f8ff;
        color: #003b73;
    }

    .info-box {
        background: linear-gradient(135deg, rgba(78,199,210,.1) 0%, rgba(0,80,143,.05) 100%);
        border-left: 4px solid #4ec7d2;
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }
</style>

<div class="container" style="max-width: 960px;">

    {{-- Encabezado de página --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="section-header" style="width:48px;height:48px;border-radius:12px;">
            <i class="fas fa-clipboard-check" style="color:white;font-size:1.1rem;"></i>
        </div>
        <div>
            <h4 class="mb-0 fw-bold" style="color:#003b73;">Registrar Matrícula</h4>
            <small class="text-muted">Complete todos los datos requeridos</small>
        </div>
    </div>

    {{-- Errores globales --}}
    @if ($errors->any())
        <div class="alert alert-danger d-flex gap-2 align-items-start mb-4" style="border-radius:10px;">
            <i class="fas fa-exclamation-circle mt-1"></i>
            <div>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('matriculas.store') }}" method="POST" enctype="multipart/form-data" id="formMatricula">
        @csrf

        {{-- ══════════════════════════════════════
             SECCIÓN 1 — Datos de la Matrícula
        ══════════════════════════════════════ --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="section-header">
                        <i class="fas fa-clipboard-list" style="color:white;font-size:0.9rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-bold" style="color:#003b73;font-size:1rem;">Datos de la Matrícula</h6>
                </div>

                <div class="row g-3">

                    {{-- Código de Matrícula --}}
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            <i class="fas fa-barcode me-1"></i> Código de Matrícula
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-barcode position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('codigo_matricula') is-invalid @enderror"
                                   name="codigo_matricula"
                                   value="{{ old('codigo_matricula', $matricula->codigo_matricula ?? '') }}"
                                   placeholder="Auto-generado"
                                   readonly
                                   style="background:#f8f9fa;">
                            @error('codigo_matricula')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Año Lectivo --}}
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Año Lectivo <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-calendar-alt position-absolute field-icon"></i>
                            <input type="number"
                                   class="form-control ps-5 custom-input @error('anio_lectivo') is-invalid @enderror"
                                   name="anio_lectivo"
                                   value="{{ old('anio_lectivo', date('Y')) }}"
                                   placeholder="{{ date('Y') }}"
                                   min="2020" max="2099"
                                   required>
                            @error('anio_lectivo')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Fecha de Matrícula --}}
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Fecha de Matrícula <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-calendar position-absolute field-icon"></i>
                            <input type="date"
                                   class="form-control ps-5 custom-input @error('fecha_matricula') is-invalid @enderror"
                                   name="fecha_matricula"
                                   value="{{ old('fecha_matricula', isset($matricula) ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('Y-m-d') : date('Y-m-d')) }}"
                                   required>
                            @error('fecha_matricula')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Estado <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-info-circle position-absolute field-icon"></i>
                            <select class="form-select ps-5 custom-input @error('estado') is-invalid @enderror"
                                    name="estado" id="estadoSelect" required>
                                <option value="pendiente"  {{ old('estado', $matricula->estado ?? 'pendiente') == 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobada"   {{ old('estado', $matricula->estado ?? '') == 'aprobada'   ? 'selected' : '' }}>Aprobada</option>
                                <option value="rechazada"  {{ old('estado', $matricula->estado ?? '') == 'rechazada'  ? 'selected' : '' }}>Rechazada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Motivo de rechazo (se muestra solo si estado = rechazada) --}}
                    <div class="col-md-6" id="motivoRechazoContainer"
                         style="{{ old('estado', $matricula->estado ?? '') == 'rechazada' ? '' : 'display:none;' }}">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            <i class="fas fa-exclamation-triangle me-1 text-warning"></i>
                            Motivo del Rechazo
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-comment-alt position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('motivo_rechazo') is-invalid @enderror"
                                   name="motivo_rechazo"
                                   value="{{ old('motivo_rechazo', $matricula->motivo_rechazo ?? '') }}"
                                   placeholder="Describa el motivo del rechazo">
                            @error('motivo_rechazo')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-12">
                        <label class="form-label small fw-semibold" style="color:#003b73;">Observaciones</label>
                        <div class="position-relative">
                            <i class="fas fa-comment-alt position-absolute field-icon-top"></i>
                            <textarea class="form-control ps-5 custom-input @error('observaciones') is-invalid @enderror"
                                      name="observaciones" rows="2"
                                      placeholder="Notas adicionales sobre la matrícula...">{{ old('observaciones', $matricula->observaciones ?? '') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             SECCIÓN 2 — Datos del Estudiante
        ══════════════════════════════════════ --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="section-header">
                        <i class="fas fa-user-graduate" style="color:white;font-size:0.9rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-bold" style="color:#003b73;font-size:1rem;">Datos del Estudiante</h6>
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Nombres <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('estudiante_nombre') is-invalid @enderror"
                                   name="estudiante_nombre"
                                   value="{{ old('estudiante_nombre') }}"
                                   placeholder="Ej: María José"
                                   required>
                            @error('estudiante_nombre')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Apellidos <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('estudiante_apellido') is-invalid @enderror"
                                   name="estudiante_apellido"
                                   value="{{ old('estudiante_apellido') }}"
                                   placeholder="Ej: López Martínez"
                                   required>
                            @error('estudiante_apellido')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            DNI <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('estudiante_dni') is-invalid @enderror"
                                   name="estudiante_dni"
                                   value="{{ old('estudiante_dni') }}"
                                   placeholder="0801201012345"
                                   maxlength="13" pattern="[0-9]{13}"
                                   required>
                            @error('estudiante_dni')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted" style="font-size:.75rem;"><i class="fas fa-info-circle me-1"></i>13 dígitos</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Fecha de Nacimiento <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-calendar position-absolute field-icon"></i>
                            <input type="date"
                                   class="form-control ps-5 custom-input @error('estudiante_fecha_nacimiento') is-invalid @enderror"
                                   name="estudiante_fecha_nacimiento"
                                   value="{{ old('estudiante_fecha_nacimiento') }}"
                                   required>
                            @error('estudiante_fecha_nacimiento')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Sexo <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-venus-mars position-absolute field-icon"></i>
                            <select class="form-select ps-5 custom-input @error('estudiante_sexo') is-invalid @enderror"
                                    name="estudiante_sexo" required>
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('estudiante_sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino"  {{ old('estudiante_sexo') == 'femenino'  ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('estudiante_sexo')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Grado <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-graduation-cap position-absolute field-icon"></i>
                            <select class="form-select ps-5 custom-input @error('estudiante_grado') is-invalid @enderror"
                                    name="estudiante_grado" required>
                                <option value="">Seleccionar...</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado }}" {{ old('estudiante_grado') == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                                @endforeach
                            </select>
                            @error('estudiante_grado')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Sección <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-door-open position-absolute field-icon"></i>
                            <select class="form-select ps-5 custom-input @error('estudiante_seccion') is-invalid @enderror"
                                    name="estudiante_seccion" required>
                                <option value="">Seleccionar...</option>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion }}" {{ old('estudiante_seccion') == $seccion ? 'selected' : '' }}>{{ $seccion }}</option>
                                @endforeach
                            </select>
                            @error('estudiante_seccion')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">Teléfono</label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('estudiante_telefono') is-invalid @enderror"
                                   name="estudiante_telefono"
                                   value="{{ old('estudiante_telefono') }}"
                                   placeholder="98765432"
                                   maxlength="8">
                            @error('estudiante_telefono')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">Correo Electrónico</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute field-icon"></i>
                            <input type="email"
                                   class="form-control ps-5 custom-input @error('estudiante_email') is-invalid @enderror"
                                   name="estudiante_email"
                                   value="{{ old('estudiante_email') }}"
                                   placeholder="estudiante@ejemplo.com">
                            @error('estudiante_email')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-semibold" style="color:#003b73;">Dirección</label>
                        <div class="position-relative">
                            <i class="fas fa-map-marker-alt position-absolute field-icon-top"></i>
                            <textarea class="form-control ps-5 custom-input @error('estudiante_direccion') is-invalid @enderror"
                                      name="estudiante_direccion" rows="2"
                                      placeholder="Dirección del estudiante">{{ old('estudiante_direccion') }}</textarea>
                            @error('estudiante_direccion')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             SECCIÓN 3 — Datos del Padre / Tutor
        ══════════════════════════════════════ --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="section-header">
                        <i class="fas fa-user-shield" style="color:white;font-size:0.9rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-bold" style="color:#003b73;font-size:1rem;">Datos del Padre / Tutor</h6>
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Nombres <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('padre_nombre') is-invalid @enderror"
                                   name="padre_nombre"
                                   value="{{ old('padre_nombre') }}"
                                   placeholder="Ej: Juan Carlos"
                                   required>
                            @error('padre_nombre')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Apellidos <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('padre_apellido') is-invalid @enderror"
                                   name="padre_apellido"
                                   value="{{ old('padre_apellido') }}"
                                   placeholder="Ej: Pérez García"
                                   required>
                            @error('padre_apellido')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            DNI <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('padre_dni') is-invalid @enderror"
                                   name="padre_dni"
                                   value="{{ old('padre_dni') }}"
                                   placeholder="0801199512345"
                                   maxlength="13" pattern="[0-9]{13}"
                                   required>
                            @error('padre_dni')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted" style="font-size:.75rem;"><i class="fas fa-info-circle me-1"></i>13 dígitos</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Parentesco <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-users position-absolute field-icon"></i>
                            <select class="form-select ps-5 custom-input @error('padre_parentesco') is-invalid @enderror"
                                    name="padre_parentesco" id="parentescoSelect"
                                    onchange="toggleOtroParentesco()" required>
                                <option value="">Seleccionar...</option>
                                @foreach($parentescos as $key => $value)
                                    <option value="{{ $key }}" {{ old('padre_parentesco') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('padre_parentesco')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Otro parentesco --}}
                    <div class="col-md-4" id="otroParentescoDiv"
                         style="{{ old('padre_parentesco') == 'otro' ? '' : 'display:none;' }}">
                        <label class="form-label small fw-semibold" style="color:#003b73;">Especificar Parentesco</label>
                        <div class="position-relative">
                            <i class="fas fa-pen position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('padre_parentesco_otro') is-invalid @enderror"
                                   name="padre_parentesco_otro"
                                   value="{{ old('padre_parentesco_otro') }}"
                                   placeholder="Ej: Tío, Hermano">
                            @error('padre_parentesco_otro')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Teléfono <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control ps-5 custom-input @error('padre_telefono') is-invalid @enderror"
                                   name="padre_telefono"
                                   value="{{ old('padre_telefono') }}"
                                   placeholder="98765432"
                                   maxlength="8" pattern="[0-9]{8}"
                                   required>
                            @error('padre_telefono')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold" style="color:#003b73;">Correo Electrónico</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute field-icon"></i>
                            <input type="email"
                                   class="form-control ps-5 custom-input @error('padre_email') is-invalid @enderror"
                                   name="padre_email"
                                   value="{{ old('padre_email') }}"
                                   placeholder="padre@ejemplo.com">
                            @error('padre_email')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            Dirección <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-map-marker-alt position-absolute field-icon-top"></i>
                            <textarea class="form-control ps-5 custom-input @error('padre_direccion') is-invalid @enderror"
                                      name="padre_direccion" rows="2"
                                      placeholder="Dirección completa del padre/tutor"
                                      required>{{ old('padre_direccion') }}</textarea>
                            @error('padre_direccion')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             SECCIÓN 4 — Documentos Adjuntos
        ══════════════════════════════════════ --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="section-header">
                        <i class="fas fa-folder-open" style="color:white;font-size:0.9rem;"></i>
                    </div>
                    <h6 class="mb-0 fw-bold" style="color:#003b73;font-size:1rem;">Documentos Adjuntos</h6>
                </div>

                <div class="info-box mb-3">
                    <p class="small fw-semibold mb-1" style="color:#003b73;">
                        <i class="fas fa-clipboard-check me-2" style="color:#4ec7d2;"></i>
                        Documentos requeridos:
                    </p>
                    <ul class="small mb-0" style="color:#003b73;line-height:1.9;list-style:none;padding-left:0;">
                        <li><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>Foto del estudiante (JPG/PNG)</li>
                        <li><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>Acta de nacimiento</li>
                        <li><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>Certificado de estudios del año anterior</li>
                        <li><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>Constancia de conducta</li>
                        <li><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>DNI del estudiante y del padre/tutor</li>
                    </ul>
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            <i class="fas fa-camera me-1"></i> Foto del Estudiante
                        </label>
                        <input type="file"
                               class="form-control custom-input @error('foto_estudiante') is-invalid @enderror"
                               name="foto_estudiante" accept="image/*">
                        <small class="text-muted">JPG, PNG — Máx. 2MB</small>
                        @error('foto_estudiante')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            <i class="fas fa-file-alt me-1"></i> Acta de Nacimiento
                        </label>
                        <input type="file"
                               class="form-control custom-input @error('acta_nacimiento') is-invalid @enderror"
                               name="acta_nacimiento" accept=".pdf,image/*">
                        <small class="text-muted">PDF, JPG, PNG — Máx. 5MB</small>
                        @error('acta_nacimiento')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            <i class="fas fa-certificate me-1"></i> Certificado de Estudios
                        </label>
                        <input type="file"
                               class="form-control custom-input @error('certificado_estudios') is-invalid @enderror"
                               name="certificado_estudios" accept=".pdf,image/*">
                        <small class="text-muted">PDF, JPG, PNG — Máx. 5MB</small>
                        @error('certificado_estudios')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            <i class="fas fa-award me-1"></i> Constancia de Conducta
                        </label>
                        <input type="file"
                               class="form-control custom-input @error('constancia_conducta') is-invalid @enderror"
                               name="constancia_conducta" accept=".pdf,image/*">
                        <small class="text-muted">PDF, JPG, PNG — Máx. 5MB</small>
                        @error('constancia_conducta')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            <i class="fas fa-id-card me-1"></i> DNI del Estudiante (foto)
                        </label>
                        <input type="file"
                               class="form-control custom-input @error('foto_dni_estudiante') is-invalid @enderror"
                               name="foto_dni_estudiante" accept="image/*">
                        <small class="text-muted">JPG, PNG — Máx. 2MB</small>
                        @error('foto_dni_estudiante')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" style="color:#003b73;">
                            <i class="fas fa-id-card-alt me-1"></i> DNI del Padre / Tutor (foto)
                        </label>
                        <input type="file"
                               class="form-control custom-input @error('foto_dni_padre') is-invalid @enderror"
                               name="foto_dni_padre" accept="image/*">
                        <small class="text-muted">JPG, PNG — Máx. 2MB</small>
                        @error('foto_dni_padre')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             Botones de Acción
        ══════════════════════════════════════ --}}
        <div class="d-flex gap-2 mb-5">
            <button type="submit" class="btn btn-primary-custom flex-fill">
                <i class="fas fa-save me-2"></i>Registrar Matrícula
            </button>
            <a href="{{ route('matriculas.index') }}" class="btn btn-cancel-custom flex-fill text-center">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
        </div>

    </form>
</div>

@push('scripts')
<script>
    // Mostrar/ocultar motivo de rechazo según estado
    document.getElementById('estadoSelect').addEventListener('change', function () {
        const container = document.getElementById('motivoRechazoContainer');
        if (this.value === 'rechazada') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
            container.querySelector('input').value = '';
        }
    });

    // Mostrar/ocultar campo "otro parentesco"
    function toggleOtroParentesco() {
        const select = document.getElementById('parentescoSelect');
        const div    = document.getElementById('otroParentescoDiv');
        div.style.display = select.value === 'otro' ? 'block' : 'none';
    }
</script>
@endpush

@endsection