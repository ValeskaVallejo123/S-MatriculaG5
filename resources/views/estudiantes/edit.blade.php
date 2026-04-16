@extends('layouts.app')

@section('title', 'Editar Estudiante')
@section('page-title', 'Editar Estudiante')

@push('styles')
<style>
    /* ── Inputs y Selects ── */
    .form-control,
    .form-select {
        border: 2px solid #bfd9ea !important;
        border-radius: 10px;
        padding: 0.68rem 1rem 0.68rem 2.8rem !important;
        font-size: .88rem !important;
        transition: all 0.3s ease;
        height: auto !important;
    }

    /* Inputs/Selects SIN ícono */
    select[name="grado"],
    select[name="seccion"],
    select[name="estado"],
    textarea[name="observaciones"],
    input[name="foto"] {
        padding: 0.68rem 1rem !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4ec7d2 !important;
        box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.15);
    }

    /* ── Labels ── */
    .form-label {
        color: #003b73 !important;
        font-size: .63rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: .22rem;
    }

    /* ── Mensajes de error ── */
    .invalid-feedback { font-size: .7rem; }

    /* ── Textarea ── */
    textarea.form-control {
        padding-left: 1rem !important;
        resize: none;
        min-height: 80px;
    }

    /* ── Botón Guardar ── */
    .btn-primary-custom {
        background: linear-gradient(135deg, #4ec7d2, #00508f);
        color: white; border: none; border-radius: 9px;
        padding: .6rem .75rem; font-size: .83rem; font-weight: 600;
        box-shadow: 0 2px 10px rgba(78,199,210,.3); transition: all .2s;
    }
    .btn-primary-custom:hover {
        color: white; box-shadow: 0 4px 16px rgba(78,199,210,.4);
        transform: translateY(-2px);
    }

    /* ── Botón Cancelar ── */
    .btn-cancel-custom {
        border: 1.5px solid #00508f; color: #00508f; background: white;
        border-radius: 9px; padding: .6rem .75rem; font-size: .83rem;
        font-weight: 600; transition: all .2s;
    }
    .btn-cancel-custom:hover {
        background: #eff6ff; color: #00508f; transform: translateY(-2px);
    }

    .border-bottom { border-color: rgba(78,199,210,.1) !important; }

    /* ── Vista previa foto ── */
    .foto-preview-wrap {
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        margin-top: .5rem;
    }
    .foto-preview {
        width: 70px; height: 70px; border-radius: 12px; object-fit: cover;
        border: 2px solid #bfd9ea;
    }
    .foto-placeholder {
        width: 70px; height: 70px; border-radius: 12px;
        background: #f0f7ff; border: 2px dashed #bfd9ea;
        display: flex; align-items: center; justify-content: center;
    }
    .foto-placeholder i { color: #94a3b8; font-size: 1.5rem; }
</style>
@endpush

@section('content')

<div style="width:100%;">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
            background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
            padding:2rem; position:relative; overflow:hidden;">

        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <div style="display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
                <div style="width:80px;height:80px;border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                    <i class="fas fa-user-edit" style="color:white;font-size:2rem;"></i>
                </div>
                <div>
                    <h2 style="font-size:1.45rem;font-weight:800;color:white;
                           margin:0 0 .4rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                        Editar Estudiante
                    </h2>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;
                             padding:.2rem .65rem;border-radius:999px;
                             background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                             font-size:.72rem;font-weight:600;
                             border:1px solid rgba(255,255,255,.18);">
                        <i class="fas fa-pen"></i> Actualice la información del estudiante
                    </span>
                </div>
            </div>
            <div style="background:rgba(78,199,210,.2);padding:.4rem .9rem;border-radius:8px;">
                <span style="color:rgba(255,255,255,.9);font-size:.8rem;font-weight:700;">
                    ID: #{{ $estudiante->id }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── BODY DEL FORMULARIO ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
            border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <form action="{{ route('estudiantes.update', $estudiante) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ══ SECCIÓN 1 · INFORMACIÓN PERSONAL ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">

                <div style="display:flex;align-items:center;gap:.5rem;
                        font-size:.75rem;font-weight:700;color:#00508f;
                        text-transform:uppercase;letter-spacing:.08em;
                        margin-bottom:.95rem;padding-bottom:.55rem;
                        border-bottom:2px solid rgba(78,199,210,.1);">
                    <i class="fas fa-user" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Información Personal
                </div>

                <div class="row g-3">

                    {{-- Primer Nombre --}}
                    <div class="col-md-6">
                        <label class="form-label">Primer Nombre <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="nombre1"
                                   value="{{ old('nombre1', $estudiante->nombre1) }}"
                                   class="form-control @error('nombre1') is-invalid @enderror"
                                   placeholder="Ej: Juan" required maxlength="50">
                            @error('nombre1')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Segundo Nombre --}}
                    <div class="col-md-6">
                        <label class="form-label">Segundo Nombre
                            <span style="color:#6b7a90;font-weight:400;text-transform:none;font-size:.72rem;">(Opcional)</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="nombre2"
                                   value="{{ old('nombre2', $estudiante->nombre2) }}"
                                   class="form-control @error('nombre2') is-invalid @enderror"
                                   placeholder="Ej: Carlos" maxlength="50">
                            @error('nombre2')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Primer Apellido --}}
                    <div class="col-md-6">
                        <label class="form-label">Primer Apellido <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="apellido1"
                                   value="{{ old('apellido1', $estudiante->apellido1) }}"
                                   class="form-control @error('apellido1') is-invalid @enderror"
                                   placeholder="Ej: Pérez" required maxlength="50">
                            @error('apellido1')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Segundo Apellido --}}
                    <div class="col-md-6">
                        <label class="form-label">Segundo Apellido
                            <span style="color:#6b7a90;font-weight:400;text-transform:none;font-size:.72rem;">(Opcional)</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="apellido2"
                                   value="{{ old('apellido2', $estudiante->apellido2) }}"
                                   class="form-control @error('apellido2') is-invalid @enderror"
                                   placeholder="Ej: García" maxlength="50">
                            @error('apellido2')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- DNI --}}
                    <div class="col-md-6">
                        <label class="form-label">DNI <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="dni"
                                   value="{{ old('dni', $estudiante->dni) }}"
                                   class="form-control @error('dni') is-invalid @enderror"
                                   placeholder="0000000000000" required pattern="[0-9]{13}" maxlength="13">
                            @error('dni')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                            <small class="text-muted">13 dígitos sin guiones</small>
                        </div>
                    </div>

                    {{-- Fecha de Nacimiento --}}
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Nacimiento <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-calendar position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="date" name="fecha_nacimiento"
                                   value="{{ old('fecha_nacimiento', \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('Y-m-d')) }}"
                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                   required>
                            @error('fecha_nacimiento')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Sexo --}}
                    <div class="col-md-6">
                        <label class="form-label">Género <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-venus-mars position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;z-index:10;"></i>
                            <select name="sexo"
                                    class="form-select @error('sexo') is-invalid @enderror"
                                    required>
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('sexo', $estudiante->sexo) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino"  {{ old('sexo', $estudiante->sexo) == 'femenino'  ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('sexo')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label">Correo Electrónico</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="email" name="email"
                                   value="{{ old('email', $estudiante->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="estudiante@egm.edu.hn" maxlength="100">
                            @error('email')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Teléfono --}}
                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="telefono"
                                   value="{{ old('telefono', $estudiante->telefono) }}"
                                   class="form-control @error('telefono') is-invalid @enderror"
                                   placeholder="00000000" maxlength="15">
                            @error('telefono')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div class="col-12">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" rows="2" maxlength="200"
                                  class="form-control @error('direccion') is-invalid @enderror"
                                  placeholder="Dirección completa del estudiante"
                        >{{ old('direccion', $estudiante->direccion) }}</textarea>
                        @error('direccion')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="col-12">
                        <label class="form-label">Foto del Estudiante
                            <span style="color:#6b7a90;font-weight:400;text-transform:none;font-size:.72rem;">(Opcional — JPG/PNG, máx. 2 MB)</span>
                        </label>
                        <div class="foto-preview-wrap">
                            @if($estudiante->foto)
                                <img src="{{ asset('storage/' . $estudiante->foto) }}"
                                     alt="Foto actual" class="foto-preview" id="fotoPreview">
                            @else
                                <div class="foto-placeholder" id="fotoPlaceholder">
                                    <i class="fas fa-user"></i>
                                </div>
                                <img src="" alt="Nueva foto" class="foto-preview d-none" id="fotoPreview">
                            @endif
                            <div class="flex-grow-1">
                                <input type="file" name="foto" accept="image/*"
                                       class="form-control @error('foto') is-invalid @enderror"
                                       id="fotoInput" onchange="previewFoto(this)">
                                @error('foto')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                                @if($estudiante->foto)
                                    <small class="text-muted">Subir una nueva imagen reemplazará la actual.</small>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>{{-- fin row Personal --}}
            </div>{{-- fin sección Personal --}}

            {{-- ══ SECCIÓN 2 · INFORMACIÓN ACADÉMICA ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">

                <div style="display:flex;align-items:center;gap:.5rem;
                        font-size:.75rem;font-weight:700;color:#00508f;
                        text-transform:uppercase;letter-spacing:.08em;
                        margin-bottom:.95rem;padding-bottom:.55rem;
                        border-bottom:2px solid rgba(78,199,210,.1);">
                    <i class="fas fa-graduation-cap" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Información Académica
                </div>

                <div class="row g-3">

                    {{-- Grado --}}
                    <div class="col-md-4">
                        <label class="form-label">Grado <span style="color:#ef4444;">*</span></label>
                        <select name="grado"
                                class="form-select @error('grado') is-invalid @enderror"
                                required>
                            <option value="">Seleccione</option>
                            @foreach($grados as $grado)
                                <option value="{{ $grado }}"
                                    {{ old('grado', $estudiante->grado) == $grado ? 'selected' : '' }}>
                                    {{ $grado }}
                                </option>
                            @endforeach
                        </select>
                        @error('grado')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Sección --}}
                    <div class="col-md-4">
                        <label class="form-label">Sección <span style="color:#ef4444;">*</span></label>
                        <select name="seccion"
                                class="form-select @error('seccion') is-invalid @enderror"
                                required>
                            <option value="">Seleccione</option>
                            @foreach($secciones as $seccion)
                                <option value="{{ $seccion }}"
                                    {{ old('seccion', $estudiante->seccion) == $seccion ? 'selected' : '' }}>
                                    {{ $seccion }}
                                </option>
                            @endforeach
                        </select>
                        @error('seccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-4">
                        <label class="form-label">Estado <span style="color:#ef4444;">*</span></label>
                        <select name="estado"
                                class="form-select @error('estado') is-invalid @enderror"
                                required>
                            <option value="activo"      {{ old('estado', $estudiante->estado) == 'activo'      ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo"    {{ old('estado', $estudiante->estado) == 'inactivo'    ? 'selected' : '' }}>Inactivo</option>
                            <option value="retirado"    {{ old('estado', $estudiante->estado) == 'retirado'    ? 'selected' : '' }}>Retirado</option>
                            <option value="suspendido"  {{ old('estado', $estudiante->estado) == 'suspendido'  ? 'selected' : '' }}>Suspendido</option>
                        </select>
                        @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>{{-- fin sección Académica --}}

            {{-- ══ SECCIÓN 3 · INFORMACIÓN ADICIONAL ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">

                <div style="display:flex;align-items:center;gap:.5rem;
                        font-size:.75rem;font-weight:700;color:#00508f;
                        text-transform:uppercase;letter-spacing:.08em;
                        margin-bottom:.95rem;padding-bottom:.55rem;
                        border-bottom:2px solid rgba(78,199,210,.1);">
                    <i class="fas fa-clipboard" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Información Adicional
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones" rows="3" maxlength="500"
                                  class="form-control @error('observaciones') is-invalid @enderror"
                                  placeholder="Alergias, condiciones médicas, notas especiales..."
                        >{{ old('observaciones', $estudiante->observaciones) }}</textarea>
                        @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>{{-- fin sección Adicional --}}

            {{-- ══ BOTONES ══ --}}
            <div style="display:flex;gap:.6rem;flex-wrap:wrap;
                    padding:1.1rem 1.7rem;
                    background:#f5f8fc;border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;">
                <button type="submit" class="btn btn-primary-custom flex-fill">
                    <i class="fas fa-save me-1"></i> Guardar Cambios
                </button>
                <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="btn btn-cancel-custom flex-fill">
                    <i class="fas fa-times me-1"></i> Cancelar
                </a>
            </div>

        </form>
    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}

@endsection

@push('scripts')
<script>
    function previewFoto(input) {
        const preview   = document.getElementById('fotoPreview');
        const placeholder = document.getElementById('fotoPlaceholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
