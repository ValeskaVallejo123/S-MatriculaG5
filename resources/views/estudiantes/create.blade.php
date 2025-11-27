@extends('layouts.app')

@section('title', 'Crear Estudiante')

@section('page-title', 'Nuevo Estudiante')

@section('topbar-actions')
    <a href="{{ route('estudiantes.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1200px;">

    <!-- Header compacto -->
    <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user-plus text-white" style="font-size: 1.3rem;"></i>
                </div>
                <div class="text-white">
                    <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Registro de Estudiante</h5>
                    <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Complete la información requerida</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario compacto -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-3">
            <form action="{{ route('estudiantes.store') }}" method="POST">
                @csrf

                <!-- Información Personal -->
<div class="mb-4">
    <div class="d-flex align-items-center gap-2 mb-3">
        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-user" style="color: white; font-size: 0.9rem;"></i>
        </div>
        <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Información Personal</h6>
    </div>

    <div class="row g-3">
<<<<<<< HEAD:resources/views/estudiante/create.blade.php
        <!-- Nombre -->
        <div class="col-md-6">
            <label for="nombre" class="form-label small fw-semibold" style="color: #003b73;">
                Nombre <span style="color: #ef4444;">*</span>
            </label>
            <div class="position-relative">
                <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                <input type="text"
                       class="form-control ps-5 @error('nombre') is-invalid @enderror"
                       id="nombre"
                       name="nombre"
                       value="{{ old('nombre') }}"
                       placeholder="Ej: Juan Carlos"
                       required
                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                @error('nombre')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
=======
       <!-- Primer Nombre -->
<div class="col-md-6">
    <label for="nombre1" class="form-label small fw-semibold" style="color: #003b73;">
        Primer Nombre <span style="color: #ef4444;">*</span>
    </label>
    <div class="position-relative">
        <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
        <input type="text" 
               class="form-control ps-5 @error('nombre1') is-invalid @enderror" 
               id="nombre1" 
               name="nombre1" 
               value="{{ old('nombre1') }}" 
               placeholder="Ej: Juan"
               required
               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
        @error('nombre1')
            <div class="invalid-feedback" style="font-size: 0.8rem;">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
>>>>>>> origin/main:resources/views/estudiantes/create.blade.php
            </div>
        @enderror
    </div>
</div>

<<<<<<< HEAD:resources/views/estudiante/create.blade.php
        <!-- Apellido -->
        <div class="col-md-6">
            <label for="apellido" class="form-label small fw-semibold" style="color: #003b73;">
                Apellido <span style="color: #ef4444;">*</span>
            </label>
            <div class="position-relative">
                <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                <input type="text"
                       class="form-control ps-5 @error('apellido') is-invalid @enderror"
                       id="apellido"
                       name="apellido"
                       value="{{ old('apellido') }}"
                       placeholder="Ej: Pérez García"
                       required
                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                @error('apellido')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
=======
<!-- Segundo Nombre -->
<div class="col-md-6">
    <label for="nombre2" class="form-label small fw-semibold" style="color: #003b73;">
        Segundo Nombre <span class="text-muted">(Opcional)</span>
    </label>
    <div class="position-relative">
        <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
        <input type="text" 
               class="form-control ps-5 @error('nombre2') is-invalid @enderror" 
               id="nombre2" 
               name="nombre2" 
               value="{{ old('nombre2') }}" 
               placeholder="Ej: Carlos"
               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
        @error('nombre2')
            <div class="invalid-feedback" style="font-size: 0.8rem;">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
>>>>>>> origin/main:resources/views/estudiantes/create.blade.php
            </div>
        @enderror
    </div>
</div>

<!-- Primer Apellido -->
<div class="col-md-6">
    <label for="apellido1" class="form-label small fw-semibold" style="color: #003b73;">
        Primer Apellido <span style="color: #ef4444;">*</span>
    </label>
    <div class="position-relative">
        <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
        <input type="text" 
               class="form-control ps-5 @error('apellido1') is-invalid @enderror" 
               id="apellido1" 
               name="apellido1" 
               value="{{ old('apellido1') }}" 
               placeholder="Ej: Pérez"
               required
               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
        @error('apellido1')
            <div class="invalid-feedback" style="font-size: 0.8rem;">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<!-- Segundo Apellido -->
<div class="col-md-6">
    <label for="apellido2" class="form-label small fw-semibold" style="color: #003b73;">
        Segundo Apellido <span class="text-muted">(Opcional)</span>
    </label>
    <div class="position-relative">
        <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
        <input type="text" 
               class="form-control ps-5 @error('apellido2') is-invalid @enderror" 
               id="apellido2" 
               name="apellido2" 
               value="{{ old('apellido2') }}" 
               placeholder="Ej: García"
               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
        @error('apellido2')
            <div class="invalid-feedback" style="font-size: 0.8rem;">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

        <!-- DNI -->
        <div class="col-md-6">
            <label for="dni" class="form-label small fw-semibold" style="color: #003b73;">
                DNI
            </label>
            <div class="position-relative">
                <i class="fas fa-id-card position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                <input type="text"
                       class="form-control ps-5 @error('dni') is-invalid @enderror"
                       id="dni"
                       name="dni"
                       value="{{ old('dni') }}"
                       placeholder="Ej: 0801199512345"
                       maxlength="13"
                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                @error('dni')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <!-- Fecha de Nacimiento -->
        <div class="col-md-6">
            <label for="fecha_nacimiento" class="form-label small fw-semibold" style="color: #003b73;">
                Fecha de Nacimiento <span style="color: #ef4444;">*</span>
            </label>
            <div class="position-relative">
                <i class="fas fa-calendar position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                <input type="date"
                       class="form-control ps-5 @error('fecha_nacimiento') is-invalid @enderror"
                       id="fecha_nacimiento"
                       name="fecha_nacimiento"
                       value="{{ old('fecha_nacimiento') }}"
                       required
                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                @error('fecha_nacimiento')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <!-- genero -->
        <div class="col-md-6">
            <label for="sexo" class="form-label small fw-semibold" style="color: #003b73;">
                Genero<span style="color: #ef4444;">*</span>
            </label>
            <div class="position-relative">
                <i class="fas fa-venus-mars position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                <select class="form-select ps-5 @error('sexo') is-invalid @enderror"
                        id="sexo"
                        name="sexo"
                        required
                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                    <option value="">Seleccionar...</option>
                    <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('sexo')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <!-- Email (si lo tienes) -->
        <div class="col-md-6">
            <label for="email" class="form-label small fw-semibold" style="color: #003b73;">
                Email
            </label>
            <div class="position-relative">
                <i class="fas fa-envelope position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                <input type="email"
                       class="form-control ps-5 @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="estudiante@ejemplo.com"
                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                @error('email')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>

                <!-- Información Académica -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-graduation-cap me-2" style="font-size: 0.9rem;"></i>Información Académica
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
                                    <option value="{{ $grado }}" {{ old('grado') == $grado ? 'selected' : '' }}>
                                        {{ $grado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grado')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
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
                                    <option value="{{ $seccion }}" {{ old('seccion') == $seccion ? 'selected' : '' }}>
                                        {{ $seccion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('seccion')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
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
                                <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-clipboard me-2" style="font-size: 0.9rem;"></i>Información Adicional
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
                            >{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones compactos -->
                <div class="d-flex gap-2 pt-2 border-top">
                    <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                        <i class="fas fa-save me-1"></i>Registrar Estudiante
                    </button>
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Nota compacta -->
    <div class="alert border-0 mt-2 py-2 px-3" style="border-radius: 8px; background: rgba(78, 199, 210, 0.1); border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle me-2 mt-1" style="font-size: 0.9rem; color: #00508f;"></i>
            <div>
                <strong style="color: #00508f;">Información importante:</strong>
                <span class="text-muted"> Verifique todos los datos. El DNI debe ser único.</span>
            </div>
        </div>
    </div>

</div>

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
        box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.15);
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
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }

    .border-bottom {
        border-color: rgba(0, 80, 143, 0.15) !important;
    }

    textarea {
        min-height: 60px !important;
    }
</style>
@endpush
@endsection
