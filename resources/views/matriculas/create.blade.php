@extends('layouts.app')

@section('title', 'Editar Matrícula')

@section('content')
<div class="container" style="max-width: 1000px;">

    <form action="{{ route('matriculas.store') }}" method="POST" id="formMatricula">
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
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 @error('padre_nombre') is-invalid @enderror"
                                   id="padre_nombre"
                                   name="padre_nombre"
                                   value="{{ old('padre_nombre') }}"
                                   placeholder="Ej: Juan Carlos"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('padre_nombre')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6" id="motivo-rechazo-container" @if(old('estado', $matricula->estado) !== 'rechazada') style="display: none;" @endif>
                        <label for="motivo_rechazo" class="form-label fw-bold">
                            <i class="fas fa-exclamation-triangle"></i> Motivo del Rechazo
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 @error('padre_apellido') is-invalid @enderror"
                                   id="padre_apellido"
                                   name="padre_apellido"
                                   value="{{ old('padre_apellido') }}"
                                   placeholder="Ej: Pérez García"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('padre_apellido')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- DNI del Padre -->
                    <div class="col-md-6">
                        <label for="padre_dni" class="form-label small fw-semibold" style="color: #003b73;">
                            DNI <span style="color: #ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 @error('padre_dni') is-invalid @enderror"
                                   id="padre_dni"
                                   name="padre_dni"
                                   value="{{ old('padre_dni') }}"
                                   placeholder="0801199512345"
                                   maxlength="13"
                                   pattern="[0-9]{13}"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('padre_dni')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <small class="text-muted" style="font-size: 0.75rem;">
                            <i class="fas fa-info-circle me-1"></i>13 dígitos
                        </small>
                    </div>

                    <!-- Parentesco -->
                    <div class="col-md-6">
                        <label for="padre_parentesco" class="form-label small fw-semibold" style="color: #003b73;">
                            Parentesco <span style="color: #ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-users position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                            <select class="form-select ps-5 @error('padre_parentesco') is-invalid @enderror"
                                    id="padre_parentesco"
                                    name="padre_parentesco"
                                    required
                                    onchange="toggleOtroParentesco()"
                                    style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                <option value="">Seleccionar...</option>
                                @foreach($parentescos as $key => $value)
                                    <option value="{{ $key }}" {{ old('padre_parentesco') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('padre_parentesco')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Otro Parentesco -->
                    <div class="col-md-6" id="otro_parentesco_div" style="display: none;">
                        <label for="padre_parentesco_otro" class="form-label small fw-semibold" style="color: #003b73;">
                            Especificar Parentesco
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-pen position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 @error('padre_parentesco_otro') is-invalid @enderror"
                                   id="padre_parentesco_otro"
                                   name="padre_parentesco_otro"
                                   value="{{ old('padre_parentesco_otro') }}"
                                   placeholder="Ej: Tío, Hermano"
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('padre_parentesco_otro')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="padre_telefono" class="form-label small fw-semibold" style="color: #003b73;">
                            Teléfono <span style="color: #ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 @error('padre_telefono') is-invalid @enderror"
                                   id="padre_telefono"
                                   name="padre_telefono"
                                   value="{{ old('padre_telefono') }}"
                                   placeholder="98765432"
                                   maxlength="8"
                                   pattern="[0-9]{8}"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('padre_telefono')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="padre_email" class="form-label small fw-semibold" style="color: #003b73;">
                            Email
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="email"
                                   class="form-control ps-5 @error('padre_email') is-invalid @enderror"
                                   id="padre_email"
                                   name="padre_email"
                                   value="{{ old('padre_email') }}"
                                   placeholder="padre@ejemplo.com"
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('padre_email')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="col-12">
                        <label for="observaciones" class="form-label fw-bold">
                            <i class="fas fa-sticky-note"></i> Observaciones
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-map-marker-alt position-absolute" style="left: 12px; top: 18px; color: #00508f; font-size: 0.85rem;"></i>
                            <textarea class="form-control ps-5 @error('padre_direccion') is-invalid @enderror"
                                      id="padre_direccion"
                                      name="padre_direccion"
                                      rows="2"
                                      placeholder="Dirección completa"
                                      required
                                      style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">{{ old('padre_direccion') }}</textarea>
                            @error('padre_direccion')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
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
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 @error('estudiante_nombre') is-invalid @enderror"
                                   id="estudiante_nombre"
                                   name="estudiante_nombre"
                                   value="{{ old('estudiante_nombre') }}"
                                   placeholder="Ej: María José"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('estudiante_nombre')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
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
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 @error('estudiante_apellido') is-invalid @enderror"
                                   id="estudiante_apellido"
                                   name="estudiante_apellido"
                                   value="{{ old('estudiante_apellido') }}"
                                   placeholder="Ej: López Martínez"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('estudiante_apellido')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
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
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 @error('estudiante_dni') is-invalid @enderror"
                                   id="estudiante_dni"
                                   name="estudiante_dni"
                                   value="{{ old('estudiante_dni') }}"
                                   placeholder="0801201012345"
                                   maxlength="13"
                                   pattern="[0-9]{13}"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('estudiante_dni')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
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
                        <div class="position-relative">
                            <i class="fas fa-calendar position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="date"
                                   class="form-control ps-5 @error('estudiante_fecha_nacimiento') is-invalid @enderror"
                                   id="estudiante_fecha_nacimiento"
                                   name="estudiante_fecha_nacimiento"
                                   value="{{ old('estudiante_fecha_nacimiento') }}"
                                   required
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('estudiante_fecha_nacimiento')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
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
                        <div class="position-relative">
                            <i class="fas fa-venus-mars position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                            <select class="form-select ps-5 @error('estudiante_sexo') is-invalid @enderror"
                                    id="estudiante_sexo"
                                    name="estudiante_sexo"
                                    required
                                    style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('estudiante_sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('estudiante_sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('estudiante_sexo')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
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
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="email"
                                   class="form-control ps-5 @error('estudiante_email') is-invalid @enderror"
                                   id="estudiante_email"
                                   name="estudiante_email"
                                   value="{{ old('estudiante_email') }}"
                                   placeholder="estudiante@ejemplo.com"
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('estudiante_email')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
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
                        <label for="estudiante_telefono" class="form-label small fw-semibold" style="color: #003b73;">
                            Teléfono
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 @error('estudiante_telefono') is-invalid @enderror"
                                   id="estudiante_telefono"
                                   name="estudiante_telefono"
                                   value="{{ old('estudiante_telefono') }}"
                                   placeholder="98765432"
                                   maxlength="8"
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            @error('estudiante_telefono')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="col-12">
                        <label for="estudiante_direccion" class="form-label small fw-semibold" style="color: #003b73;">
                            Dirección
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-map-marker-alt position-absolute" style="left: 12px; top: 18px; color: #00508f; font-size: 0.85rem;"></i>
                            <textarea class="form-control ps-5 @error('estudiante_direccion') is-invalid @enderror"
                                      id="estudiante_direccion"
                                      name="estudiante_direccion"
                                      rows="2"
                                      placeholder="Dirección del estudiante"
                                      style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">{{ old('estudiante_direccion') }}</textarea>
                            @error('estudiante_direccion')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Grado -->
                    <div class="col-md-6">
                        <label for="estudiante_grado" class="form-label small fw-semibold" style="color: #003b73;">
                            Grado <span style="color: #ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-graduation-cap position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                            <select class="form-select ps-5 @error('estudiante_grado') is-invalid @enderror"
                                    id="estudiante_grado"
                                    name="estudiante_grado"
                                    required
                                    style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                <option value="">Seleccionar...</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado }}" {{ old('estudiante_grado') == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                                @endforeach
                            </select>
                            @error('estudiante_grado')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección -->
                    <div class="col-md-6">
                        <label for="estudiante_seccion" class="form-label small fw-semibold" style="color: #003b73;">
                            Sección <span style="color: #ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-door-open position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                            <select class="form-select ps-5 @error('estudiante_seccion') is-invalid @enderror"
                                    id="estudiante_seccion"
                                    name="estudiante_seccion"
                                    required
                                    style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                <option value="">Seleccionar...</option>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion }}" {{ old('estudiante_seccion') == $seccion ? 'selected' : '' }}>{{ $seccion }}</option>
                                @endforeach
                            </select>
                            @error('estudiante_seccion')
                                <div class="invalid-feedback" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Matrícula -->
<div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-clipboard-list" style="color: white; font-size: 0.9rem;"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Datos de Matrícula</h6>
        </div>

        <div class="row g-3">

        <!-- Fecha de Matrícula -->
<div class="col-md-6">
    <label for="fecha_matricula" class="form-label small fw-semibold" style="color: #003b73;">
        Fecha de Matrícula <span style="color: #ef4444;">*</span>
    </label>
    <div class="position-relative">
        <i class="fas fa-calendar position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
        <input type="date"
               class="form-control ps-5 @error('fecha_matricula') is-invalid @enderror"
               id="fecha_matricula"
               name="fecha_matricula"
               value="{{ old('fecha_matricula', date('Y-m-d')) }}"
               required
               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
        @error('fecha_matricula')
            <div class="invalid-feedback" style="font-size: 0.8rem;">
                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>
            <!-- Año Lectivo -->
            <div class="col-md-6">
                <label for="anio_lectivo" class="form-label small fw-semibold" style="color: #003b73;">
                    Año Lectivo <span style="color: #ef4444;">*</span>
                </label>
                <div class="position-relative">
                    <i class="fas fa-calendar-alt position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                    <input type="number"
                           class="form-control ps-5 @error('anio_lectivo') is-invalid @enderror"
                           id="anio_lectivo"
                           name="anio_lectivo"
                           value="{{ old('anio_lectivo', date('Y')) }}"
                           placeholder="2024"
                           min="2020"
                           max="2099"
                           required
                           style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                    @error('anio_lectivo')
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
                    <i class="fas fa-info-circle position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                    <select class="form-select ps-5 @error('estado') is-invalid @enderror"
                            id="estado"
                            name="estado"
                            style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                        <option value="pendiente" {{ old('estado', 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="aprobada" {{ old('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                        <option value="rechazada" {{ old('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Observaciones -->
            <div class="col-12">
                <label for="observaciones" class="form-label small fw-semibold" style="color: #003b73;">
                    Observaciones
                </label>
                <div class="position-relative">
                    <i class="fas fa-comment-alt position-absolute" style="left: 12px; top: 18px; color: #00508f; font-size: 0.85rem;"></i>
                    <textarea class="form-control ps-5 @error('observaciones') is-invalid @enderror"
                              id="observaciones"
                              name="observaciones"
                              rows="3"
                              placeholder="Notas adicionales sobre la matrícula"
                              style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Documentos -->
<div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-folder-open" style="color: white; font-size: 0.9rem;"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Documentos Requeridos</h6>
        </div>

        <!-- Lista de documentos -->
        <div class="mb-3 p-3" style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%); border-radius: 10px; border-left: 4px solid #4ec7d2;">
            <p class="small fw-semibold mb-2" style="color: #003b73;">
                <i class="fas fa-clipboard-check me-2" style="color: #4ec7d2;"></i>
                Documentos que deberá presentar:
            </p>
            <ul class="small mb-0" style="color: #003b73; line-height: 1.8; list-style: none; padding-left: 0;">
                <li class="mb-1">
                    <i class="fas fa-check-circle me-2" style="color: #4ec7d2;"></i>
                    Foto del estudiante (formato JPG/PNG)
                </li>
                <li class="mb-1">
                    <i class="fas fa-check-circle me-2" style="color: #4ec7d2;"></i>
                    Acta de nacimiento
                </li>
                <li class="mb-1">
                    <i class="fas fa-check-circle me-2" style="color: #4ec7d2;"></i>
                    Calificaciones del año anterior
                </li>
            </ul>
        </div>

        <!-- Botón para subir documentos -->
        <button type="button"
                class="btn w-100 d-flex align-items-center justify-content-center gap-2"
                onclick="alert('Funcionalidad de carga de documentos próximamente')"
                style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.8rem; border-radius: 8px; border: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
            <i class="fas fa-cloud-upload-alt" style="font-size: 1.1rem;"></i>
            <span>Subir Documentos</span>
        </button>

        <!-- Nota informativa -->
        <div class="mt-3 d-flex gap-2 align-items-start" style="background: rgba(78, 199, 210, 0.1); padding: 0.75rem; border-radius: 8px; border-left: 3px solid #4ec7d2;">
            <i class="fas fa-info-circle" style="color: #00508f; margin-top: 2px;"></i>
            <p class="small mb-0" style="color: #003b73;">
                Los documentos pueden ser cargados después de registrar la matrícula. Se aceptan formatos: PDF, JPG, PNG (máx. 5MB por archivo).
            </p>
        </div>
    </div>
</div>

        <!-- Botones de acción -->
        <div class="d-flex gap-2">
            <button type="submit"
                    class="btn flex-fill"
                    style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.8rem; border-radius: 8px; font-weight: 600; border: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
                <i class="fas fa-save me-2"></i>Registrar Matrícula
            </button>
            <a href="{{ route('matriculas.index') }}"
               class="btn flex-fill"
               style="background: white; color: #003b73; padding: 0.8rem; border-radius: 8px; font-weight: 600; border: 2px solid #bfd9ea; transition: all 0.3s ease;">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
        </div>

    </form>
</div>

@push('scripts')
<script>
function toggleOtroParentesco() {
    const select = document.getElementById('padre_parentesco');
    const otroDiv = document.getElementById('otro_parentesco_div');

    if (select.value === 'otro') {
        otroDiv.style.display = 'block';
    } else {
        otroDiv.style.display = 'none';
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
@endpush
