@extends('layouts.app')

@section('title', 'Editar Estudiante')
@section('page-title', 'Editar Estudiante')

@section('topbar-actions')
    <a href="{{ route('estudiantes.index') }}" class="btn-back"
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px;
              text-decoration: none; font-weight: 600; display: inline-flex; align-items: center;
              gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.edit-wrap { font-family: 'Inter', sans-serif; max-width: 900px; margin: 0 auto; }

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: #fff; color: #00508f; border: 1.5px solid #00508f;
    text-decoration: none; transition: all .15s;
}
.adm-btn-outline:hover { background: #eff6ff; }

.edit-header {
    background: linear-gradient(135deg, #00508f, #003b73);
    border-radius: 12px; padding: 1.25rem 1.5rem;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem;
}
.edit-header-left { display: flex; align-items: center; gap: .85rem; }
.edit-header-icon {
    width: 44px; height: 44px; border-radius: 10px;
    background: rgba(78,199,210,.25);
    display: flex; align-items: center; justify-content: center;
}
.edit-header-icon i { color: #fff; font-size: 1.2rem; }
.edit-header-title { color: #fff; font-weight: 700; font-size: 1rem; margin: 0; }
.edit-header-sub   { color: rgba(255,255,255,.7); font-size: .78rem; margin: 0; }
.edit-header-id {
    background: rgba(78,199,210,.2); color: rgba(255,255,255,.9);
    padding: .3rem .75rem; border-radius: 6px; font-size: .78rem; font-weight: 600;
}

.edit-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); overflow: hidden;
    margin-bottom: 1rem;
}
.edit-card-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; }

.edit-section-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .82rem; font-weight: 700; color: #00508f;
    padding-bottom: .6rem; border-bottom: 1.5px solid #e8f8f9;
    margin-bottom: .85rem;
}
.edit-section-title i { color: #4ec7d2; }

.fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
@media(max-width:600px){ .fields-grid { grid-template-columns: 1fr; } }

.field-group { display: flex; flex-direction: column; gap: .3rem; }
.field-group.full { grid-column: 1 / -1; }

.field-label {
    font-size: .75rem; font-weight: 700; color: #003b73; letter-spacing: .02em;
}
.field-label span { color: #ef4444; margin-left: 2px; }

.field-input, .field-select, .field-textarea {
    width: 100%; padding: .48rem .75rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .83rem; font-family: 'Inter', sans-serif;
    color: #0f172a; outline: none;
    transition: border-color .2s, box-shadow .2s;
    background: #f8fafc;
}
.field-input:focus, .field-select:focus, .field-textarea:focus {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    background: #fff;
}
.field-input.is-invalid, .field-select.is-invalid, .field-textarea.is-invalid {
    border-color: #ef4444;
}
.field-textarea { resize: none; min-height: 70px; }
.field-hint  { font-size: .68rem; color: #94a3b8; margin-top: .15rem; }
.field-error { font-size: .72rem; color: #ef4444; margin-top: .2rem; }

.edit-footer { display: flex; gap: .6rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9; }
.footer-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    flex: 1; padding: .6rem .75rem; border-radius: 8px;
    font-size: .83rem; font-weight: 600; cursor: pointer;
    text-decoration: none; border: none; transition: all .15s;
}
.footer-btn:hover { transform: translateY(-1px); }
.btn-save   { background: linear-gradient(135deg,#4ec7d2,#00508f); color:#fff; box-shadow:0 2px 8px rgba(78,199,210,.3); }
.btn-save:hover { color:#fff; }
.btn-cancel { background:#fff; color:#64748b; border:1.5px solid #e2e8f0; }

.edit-note {
    display: flex; align-items: flex-start; gap: .5rem;
    background: rgba(78,199,210,.08); border-left: 3px solid #4ec7d2;
    border-radius: 8px; padding: .75rem 1rem;
    font-size: .8rem; color: #475569;
}
.edit-note i { color: #4ec7d2; margin-top: 1px; flex-shrink: 0; }
.edit-note strong { color: #00508f; }
</style>
@endpush

@section('content')
<div class="container" style="max-width: 1200px;">

    <!-- Header -->
    <div class="card border-0 shadow-sm mb-3"
         style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3"
                         style="width: 45px; height: 45px; background: rgba(78,199,210,0.3);
                                border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-edit text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Editar Estudiante</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Actualice la información necesaria</p>
                    </div>
                </div>
                <div style="background: rgba(78,199,210,0.2); padding: 0.4rem 0.8rem; border-radius: 6px;">
                    <p class="text-white mb-0 small fw-semibold" style="font-size: 0.8rem;">
                        ID: #{{ $estudiante->id }}
                    </p>
                </div>
            </div>
        </div>
        <span class="edit-header-id">ID: #{{ $estudiante->id }}</span>
    </div>

    <!-- Formulario -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-3">
            <form action="{{ route('estudiantes.update', $estudiante) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- INFORMACIÓN PERSONAL -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                        style="color:#00508f; font-weight:600; font-size:0.95rem;">
                        <i class="fas fa-user me-2" style="font-size:0.9rem;"></i>
                        Información Personal
                    </h6>

                    <div class="row g-2">

                        <!-- Primer Nombre -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Primer Nombre <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="nombre1"
                                value="{{ old('nombre1', $estudiante->nombre1) }}"
                                class="form-control form-control-sm @error('nombre1') is-invalid @enderror"
                                placeholder="Ej: Juan"
                                required
                                minlength="2"
                                maxlength="50"
                            >
                            @error('nombre1')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Segundo Nombre -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Segundo Nombre <span class="text-muted">(Opcional)</span>
                            </label>
                            <input
                                type="text"
                                name="nombre2"
                                value="{{ old('nombre2', $estudiante->nombre2) }}"
                                class="form-control form-control-sm @error('nombre2') is-invalid @enderror"
                                placeholder="Ej: Carlos"
                                maxlength="50"
                            >
                            @error('nombre2')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Primer Apellido -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Primer Apellido <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="apellido1"
                                value="{{ old('apellido1', $estudiante->apellido1) }}"
                                class="form-control form-control-sm @error('apellido1') is-invalid @enderror"
                                placeholder="Ej: Pérez"
                                required
                                minlength="2"
                                maxlength="50"
                            >
                            @error('apellido1')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Segundo Apellido -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Segundo Apellido <span class="text-muted">(Opcional)</span>
                            </label>
                            <input
                                type="text"
                                name="apellido2"
                                value="{{ old('apellido2', $estudiante->apellido2) }}"
                                class="form-control form-control-sm @error('apellido2') is-invalid @enderror"
                                placeholder="Ej: García"
                                maxlength="50"
                            >
                            @error('apellido2')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- DNI -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Número de Identidad <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="dni"
                                value="{{ old('dni', $estudiante->dni) }}"
                                class="form-control form-control-sm @error('dni') is-invalid @enderror"
                                placeholder="0000000000000"
                                required
                                pattern="[0-9]{13}"
                                maxlength="13"
                            >
                            @error('dni')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" style="font-size: 0.7rem;">13 dígitos</small>
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Fecha de Nacimiento <span class="text-danger">*</span>
                            </label>
                            <input
                                type="date"
                                name="fecha_nacimiento"
                                value="{{ old('fecha_nacimiento', optional($estudiante->fecha_nacimiento)->format('Y-m-d')) }}"
                                class="form-control form-control-sm @error('fecha_nacimiento') is-invalid @enderror"
                                required
                            >
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Género (sexo) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Género <span class="text-danger">*</span>
                            </label>
                            <select
                                name="sexo"
                                class="form-select form-select-sm @error('sexo') is-invalid @enderror"
                                required
                            >
                                <option value="">Seleccione...</option>
                                <option value="masculino" {{ old('sexo', $estudiante->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino"  {{ old('sexo', $estudiante->sexo) == 'femenino'  ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('sexo')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- INFORMACIÓN DE CONTACTO -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                        style="color:#00508f; font-weight:600; font-size:0.95rem;">
                        <i class="fas fa-address-book me-2" style="font-size:0.9rem;"></i>
                        Información de Contacto
                    </h6>

                    <div class="row g-2">

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">Correo Electrónico</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $estudiante->email) }}"
                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                placeholder="estudiante@correo.com"
                                maxlength="100"
                            >
                            @error('email')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">Teléfono</label>
                            <input
                                type="text"
                                name="telefono"
                                value="{{ old('telefono', $estudiante->telefono) }}"
                                class="form-control form-control-sm @error('telefono') is-invalid @enderror"
                                placeholder="00000000"
                                pattern="[0-9]{8}"
                                maxlength="8"
                            >
                            @error('telefono')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" style="font-size: 0.7rem;">8 dígitos</small>
                        </div>

                        <!-- Dirección -->
                        <div class="col-12">
                            <label class="form-label fw-semibold small mb-1">Dirección</label>
                            <textarea
                                name="direccion"
                                rows="2"
                                maxlength="200"
                                class="form-control form-control-sm @error('direccion') is-invalid @enderror"
                                placeholder="Dirección completa del estudiante"
                                style="resize: none;"
                            >{{ old('direccion', $estudiante->direccion) }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
                                <!-- INFORMACIÓN ACADÉMICA -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                        style="color:#00508f; font-weight:600; font-size:0.95rem;">
                        <i class="fas fa-graduation-cap me-2" style="font-size:0.9rem;"></i>
                        Información Académica
                    </h6>

                    <div class="row g-2">

                        <!-- Grado -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small mb-1">
                                Grado <span class="text-danger">*</span>
                            </label>
                            <select
                                name="grado"
                                class="form-select form-select-sm @error('grado') is-invalid @enderror"
                                required
                            >
                                <option value="">Seleccione</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado }}"
                                        {{ old('grado', $estudiante->grado) == $grado ? 'selected' : '' }}>
                                        {{ $grado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grado')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <!-- Sección -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small mb-1">
                                Sección <span class="text-danger">*</span>
                            </label>
                            <select
                                name="seccion"
                                class="form-select form-select-sm @error('seccion') is-invalid @enderror"
                                required
                            >
                                <option value="">Seleccione</option>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion }}"
                                        {{ old('seccion', $estudiante->seccion) == $seccion ? 'selected' : '' }}>
                                        {{ $seccion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('seccion')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <!-- Estado -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small mb-1">
                                Estado <span class="text-danger">*</span>
                            </label>
                            <select
                                name="estado"
                                class="form-select form-select-sm @error('estado') is-invalid @enderror"
                                required
                            >
                                <option value="activo"      {{ old('estado', $estudiante->estado) == 'activo'      ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo"    {{ old('estado', $estudiante->estado) == 'inactivo'    ? 'selected' : '' }}>Inactivo</option>
                                <option value="retirado"    {{ old('estado', $estudiante->estado) == 'retirado'    ? 'selected' : '' }}>Retirado</option>
                                <option value="suspendido"  {{ old('estado', $estudiante->estado) == 'suspendido'  ? 'selected' : '' }}>Suspendido</option>
                            </select>
                            @error('estado')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>

                <!-- INFORMACIÓN ADICIONAL -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                        style="color:#00508f; font-weight:600; font-size:0.95rem;">
                        <i class="fas fa-clipboard me-2" style="font-size:0.9rem;"></i>
                        Información Adicional
                    </h6>

                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label fw-semibold small mb-1">Observaciones</label>
                            <textarea
                                name="observaciones"
                                rows="2"
                                maxlength="500"
                                class="form-control form-control-sm @error('observaciones') is-invalid @enderror"
                                placeholder="Información adicional (alergias, condiciones médicas, notas especiales)"
                                style="resize: none;"
                            >{{ old('observaciones', $estudiante->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- BOTONES -->
                <div class="d-flex gap-2 pt-2 border-top">
                    <button type="submit"
                            class="btn btn-sm fw-semibold flex-fill"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                                   color: white; border: none; box-shadow: 0 2px 8px rgba(78,199,210,0.3);
                                   padding: 0.6rem; border-radius: 8px;">
                        <i class="fas fa-save me-1"></i> Actualizar Estudiante
                    </button>

                    <a href="{{ route('estudiantes.index') }}"
                       class="btn btn-sm fw-semibold flex-fill"
                       style="border: 2px solid #00508f; color:#00508f; background:white;
                              padding: 0.6rem; border-radius: 8px;">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Nota Final -->
    <div class="alert border-0 mt-2 py-2 px-3"
         style="border-radius: 8px; background: rgba(78,199,210,0.1);
                border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle me-2 mt-1"
               style="font-size: 0.9rem; color:#00508f;"></i>
            <div>
                <strong style="color:#00508f;">Importante:</strong>
                <span class="text-muted">Los cambios se aplicarán inmediatamente al guardar.</span>
            </div>
        </div>
    </div>

</div> <!-- cierre container -->

@push('styles')
<style>
    .form-control-sm, .form-select-sm {
        border-radius: 6px;
        border: 1.5px solid #e2e8f0;
        padding: 0.5rem 0.75rem;
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }

    .form-control-sm:focus, .form-select-sm:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.15);
    }

    .form-label {
        color: #003b73;
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }

    small.text-muted {
        font-size: 0.7rem;
        display: block;
        margin-top: 0.15rem;
    }

    .btn:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
        transform: translateY(-2px);
    }

    button[type="submit"]:hover {
        box-shadow: 0 4px 12px rgba(78,199,210,0.4) !important;
    }

    .border-bottom {
        border-color: rgba(0,80,143,0.15) !important;
    }

    textarea {
        min-height: 60px !important;
    }
</style>
@endpush

@endsection

