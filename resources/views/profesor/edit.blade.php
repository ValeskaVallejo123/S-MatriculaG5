@extends('layouts.app')

@section('title', 'Editar Profesor')

@section('page-title', 'Editar Profesor')

@section('topbar-actions')
    <a href="{{ route('profesores.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 900px;">

        <!-- Información del Profesor -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 3px solid #4ec7d2;">
                    <span class="text-white fw-bold" style="font-size: 1.2rem;">
                        {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
                    </span>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold" style="color: #003b73;">{{ $profesor->nombre_completo }}</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @if($profesor->email)
                                <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-envelope me-1"></i>{{ $profesor->email }}
                        </span>
                            @endif
                            @if($profesor->especialidad)
                                <span class="badge" style="background: rgba(0, 80, 143, 0.15); color: #003b73; border: 1px solid #00508f; font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-book me-1"></i>{{ $profesor->especialidad }}
                        </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de Edición -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">

                <form action="{{ route('profesores.update', $profesor) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Información Personal -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Información Personal</h6>
                        </div>

                        <div class="row g-3">
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
                                           value="{{ old('nombre', $profesor->nombre) }}"
                                           placeholder="Ej: Juan Carlos"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('nombre')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

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
                                           value="{{ old('apellido', $profesor->apellido) }}"
                                           placeholder="Ej: Pérez García"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('apellido')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- DNI -->
                            <div class="col-md-6">
                                <label for="dni" class="form-label small fw-semibold" style="color: #003b73;">
                                    DNI <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-id-card position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text"
                                           class="form-control ps-5 @error('dni') is-invalid @enderror"
                                           id="dni"
                                           name="dni"
                                           value="{{ old('dni', $profesor->dni) }}"
                                           placeholder="Ej: 0801199512345"
                                           maxlength="13"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('dni')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    <i class="fas fa-info-circle me-1"></i>Formato: 13 dígitos
                                </small>
                            </div>

                            <!-- Fecha de Nacimiento -->
                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label small fw-semibold" style="color: #003b73;">
                                    Fecha de Nacimiento
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-calendar position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="date"
                                           class="form-control ps-5 @error('fecha_nacimiento') is-invalid @enderror"
                                           id="fecha_nacimiento"
                                           name="fecha_nacimiento"
                                           value="{{ old('fecha_nacimiento', $profesor->fecha_nacimiento) }}"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('fecha_nacimiento')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Género -->
                            <div class="col-md-6">
                                <label for="genero" class="form-label small fw-semibold" style="color: #003b73;">
                                    Género
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-venus-mars position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select ps-5 @error('genero') is-invalid @enderror"
                                            id="genero"
                                            name="genero"
                                            style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                        <option value="">Seleccionar...</option>
                                        <option value="masculino" {{ old('genero', $profesor->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="femenino" {{ old('genero', $profesor->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="otro" {{ old('genero', $profesor->genero) == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('genero')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <label for="telefono" class="form-label small fw-semibold" style="color: #003b73;">
                                    Teléfono
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-phone position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text"
                                           class="form-control ps-5 @error('telefono') is-invalid @enderror"
                                           id="telefono"
                                           name="telefono"
                                           value="{{ old('telefono', $profesor->telefono) }}"
                                           placeholder="Ej: 9876-5432"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('telefono')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-envelope" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Información de Contacto</h6>
                        </div>

                        <div class="row g-3">
                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-semibold" style="color: #003b73;">
                                    Email <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-envelope position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="email"
                                           class="form-control ps-5 @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $profesor->email) }}"
                                           placeholder="profesor@ejemplo.com"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('email')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-6">
                                <label for="direccion" class="form-label small fw-semibold" style="color: #003b73;">
                                    Dirección
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-map-marker-alt position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text"
                                           class="form-control ps-5 @error('direccion') is-invalid @enderror"
                                           id="direccion"
                                           name="direccion"
                                           value="{{ old('direccion', $profesor->direccion) }}"
                                           placeholder="Ej: Barrio El Centro, Calle Principal"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('direccion')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Académica -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-graduation-cap" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Información Académica</h6>
                        </div>

                        <div class="row g-3">
                            <!-- Especialidad -->
                            <div class="col-md-6">
                                <label for="especialidad" class="form-label small fw-semibold" style="color: #003b73;">
                                    Especialidad <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-book position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text"
                                           class="form-control ps-5 @error('especialidad') is-invalid @enderror"
                                           id="especialidad"
                                           name="especialidad"
                                           value="{{ old('especialidad', $profesor->especialidad) }}"
                                           placeholder="Ej: Matemáticas, Español, Ciencias"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('especialidad')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nivel Académico -->
                            <div class="col-md-6">
                                <label for="nivel_academico" class="form-label small fw-semibold" style="color: #003b73;">
                                    Nivel Académico
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-certificate position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select ps-5 @error('nivel_academico') is-invalid @enderror"
                                            id="nivel_academico"
                                            name="nivel_academico"
                                            style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                        <option value="">Seleccionar...</option>
                                        <option value="bachillerato" {{ old('nivel_academico', $profesor->nivel_academico) == 'bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                                        <option value="licenciatura" {{ old('nivel_academico', $profesor->nivel_academico) == 'licenciatura' ? 'selected' : '' }}>Licenciatura</option>
                                        <option value="maestria" {{ old('nivel_academico', $profesor->nivel_academico) == 'maestria' ? 'selected' : '' }}>Maestría</option>
                                        <option value="doctorado" {{ old('nivel_academico', $profesor->nivel_academico) == 'doctorado' ? 'selected' : '' }}>Doctorado</option>
                                    </select>
                                    @error('nivel_academico')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Laboral -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-briefcase" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Información Laboral</h6>
                        </div>

                        <div class="row g-3">
                            <!-- Fecha de Contratación -->
                            <div class="col-md-6">
                                <label for="fecha_contratacion" class="form-label small fw-semibold" style="color: #003b73;">
                                    Fecha de Contratación
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-calendar-check position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="date"
                                           class="form-control ps-5 @error('fecha_contratacion') is-invalid @enderror"
                                           id="fecha_contratacion"
                                           name="fecha_contratacion"
                                           value="{{ old('fecha_contratacion', $profesor->fecha_contratacion) }}"
                                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('fecha_contratacion')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tipo de Contrato -->
                            <div class="col-md-6">
                                <label for="tipo_contrato" class="form-label small fw-semibold" style="color: #003b73;">
                                    Tipo de Contrato
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-file-contract position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select ps-5 @error('tipo_contrato') is-invalid @enderror"
                                            id="tipo_contrato"
                                            name="tipo_contrato"
                                            style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                        <option value="">Seleccionar...</option>
                                        <option value="tiempo_completo" {{ old('tipo_contrato', $profesor->tipo_contrato) == 'tiempo_completo' ? 'selected' : '' }}>Tiempo Completo</option>
                                        <option value="medio_tiempo" {{ old('tipo_contrato', $profesor->tipo_contrato) == 'medio_tiempo' ? 'selected' : '' }}>Medio Tiempo</option>
                                        <option value="por_horas" {{ old('tipo_contrato', $profesor->tipo_contrato) == 'por_horas' ? 'selected' : '' }}>Por Horas</option>
                                    </select>
                                    @error('tipo_contrato')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6">
                                <label for="estado" class="form-label small fw-semibold" style="color: #003b73;">
                                    Estado <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-toggle-on position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select ps-5 @error('estado') is-invalid @enderror"
                                            id="estado"
                                            name="estado"
                                            style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                        <option value="activo" {{ old('estado', $profesor->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ old('estado', $profesor->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="licencia" {{ old('estado', $profesor->estado) == 'licencia' ? 'selected' : '' }}>En Licencia</option>
                                    </select>
                                    @error('estado')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('profesores.index') }}" class="btn" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); transition: all 0.3s ease;">
                            <i class="fas fa-save me-1"></i>Actualizar Profesor
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .form-control:focus,
        .form-select:focus {
            border-color: #4ec7d2;
            box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
            outline: none;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #ef4444;
            background-image: none;
        }

        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.15);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .invalid-feedback {
            display: block;
            margin-top: 0.35rem;
        }
    </style>
@endpush
