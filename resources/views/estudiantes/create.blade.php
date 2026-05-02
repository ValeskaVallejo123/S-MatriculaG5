@extends('layouts.app')

@section('title', 'Crear Estudiante')
@section('page-title', 'Nuevo Estudiante')


@push('styles')
<style>
.form-control,
.form-select {
    border: 2px solid #bfd9ea !important;
    border-radius: 10px;
    padding: 0.68rem 1rem 0.68rem 2.8rem !important;
    font-size: .88rem !important;
    transition: all 0.3s ease;
    height: auto !important;
}

select[name="grado"],
select[name="seccion"],
select[name="estado"],
textarea[name="observaciones"] {
    padding: 0.68rem 1rem !important;
}

.form-control:focus,
.form-select:focus {
    border-color: #4ec7d2 !important;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.15);
}

.form-label {
    color: #003b73 !important;
    font-size: .63rem !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: .22rem;
}

.invalid-feedback { font-size: .7rem; }

textarea.form-control {
    padding-left: 1rem !important;
    resize: none;
    min-height: 80px;
}

/* ── File upload ── */
.file-upload-area {
    border: 2px dashed #bfd9ea;
    border-radius: 10px;
    padding: 1.1rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: all .25s;
    background: #f8fbfd;
    position: relative;
}
.file-upload-area:hover,
.file-upload-area.dragover {
    border-color: #4ec7d2;
    background: rgba(78,199,210,.05);
}
.file-upload-area input[type="file"] {
    position: absolute; inset: 0;
    opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.file-upload-icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(78,199,210,.12);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto .5rem; color: #00508f; font-size: 1.1rem;
}
.file-upload-label {
    font-size: .78rem; font-weight: 600; color: #003b73; margin-bottom: .2rem;
}
.file-upload-hint {
    font-size: .7rem; color: #94a3b8;
}
.file-upload-name {
    display: none; margin-top: .5rem;
    font-size: .75rem; font-weight: 600; color: #00508f;
    background: rgba(78,199,210,.1); border-radius: 6px;
    padding: .25rem .6rem; display: none; align-items: center; gap: .35rem;
}
.file-upload-name.visible { display: inline-flex; }

.btn-primary-custom {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none; border-radius: 9px;
    padding: .6rem .75rem; font-size: .83rem; font-weight: 600;
    box-shadow: 0 2px 10px rgba(78,199,210,.3); transition: all .2s;
}
.btn-primary-custom:hover {
    color: white;
    box-shadow: 0 4px 16px rgba(78,199,210,.4);
    transform: translateY(-2px);
}

.btn-cancel-custom {
    border: 1.5px solid #00508f; color: #00508f;
    background: white; border-radius: 9px;
    padding: .6rem .75rem; font-size: .83rem; font-weight: 600;
    transition: all .2s;
}
.btn-cancel-custom:hover {
    background: #eff6ff; color: #00508f; transform: translateY(-2px);
}
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

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px;height:80px;border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-user-plus" style="color:white;font-size:2rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white;
                           margin:0 0 .4rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Registro de Estudiante
                </h2>
                <span style="display:inline-flex;align-items:center;gap:.3rem;
                             padding:.2rem .65rem;border-radius:999px;
                             background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                             font-size:.72rem;font-weight:600;
                             border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-pen"></i> Complete la información requerida
                </span>
            </div>
        </div>
    </div>

    {{-- ── FORMULARIO ── --}}
    {{-- ↓ enctype obligatorio para subir archivos --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <form action="{{ route('estudiantes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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

                    <div class="col-md-6">
                        <label class="form-label">Primer Nombre <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="nombre1"
                                   class="form-control @error('nombre1') is-invalid @enderror"
                                   value="{{ old('nombre1') }}" placeholder="Ej: Juan" required>
                            @error('nombre1')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Segundo Nombre <span style="color:#6b7a90;font-weight:400;text-transform:none;font-size:.72rem;">(Opcional)</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="nombre2"
                                   class="form-control @error('nombre2') is-invalid @enderror"
                                   value="{{ old('nombre2') }}" placeholder="Ej: Carlos">
                            @error('nombre2')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Primer Apellido <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="apellido1"
                                   class="form-control @error('apellido1') is-invalid @enderror"
                                   value="{{ old('apellido1') }}" placeholder="Ej: Pérez" required>
                            @error('apellido1')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Segundo Apellido <span style="color:#6b7a90;font-weight:400;text-transform:none;font-size:.72rem;">(Opcional)</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="apellido2"
                                   class="form-control @error('apellido2') is-invalid @enderror"
                                   value="{{ old('apellido2') }}" placeholder="Ej: García">
                            @error('apellido2')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">DNI</label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="dni"
                                   class="form-control @error('dni') is-invalid @enderror"
                                   value="{{ old('dni') }}" placeholder="Ej: 0801199512345" maxlength="13">
                            @error('dni')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fecha de Nacimiento <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-calendar position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="date" name="fecha_nacimiento"
                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                   value="{{ old('fecha_nacimiento') }}" required>
                            @error('fecha_nacimiento')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Género <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-venus-mars position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;z-index:10;"></i>
                            <select name="sexo"
                                    class="form-select @error('sexo') is-invalid @enderror"
                                    style="padding-left:2.8rem !important;" required>
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('sexo')=='masculino'?'selected':'' }}>Masculino</option>
                                <option value="femenino"  {{ old('sexo')=='femenino' ?'selected':'' }}>Femenino</option>
                            </select>
                            @error('sexo')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="se genera automáticamente" readonly
                                   style="background:#f8fbfd;color:#64748b;">
                            @error('email')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="telefono"
                                   class="form-control @error('telefono') is-invalid @enderror"
                                   value="{{ old('telefono') }}" placeholder="Ej: 9999-9999" maxlength="15">
                            @error('telefono')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Dirección</label>
                        <div class="position-relative">
                            <i class="fas fa-map-marker-alt position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.68rem;"></i>
                            <input type="text" name="direccion"
                                   class="form-control @error('direccion') is-invalid @enderror"
                                   value="{{ old('direccion') }}" placeholder="Colonia, ciudad">
                            @error('direccion')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Foto del Estudiante <span style="color:#6b7a90;font-weight:400;text-transform:none;font-size:.72rem;">(Opcional)</span></label>
                        <div class="file-upload-area" id="area-foto">
                            <input type="file" name="foto" id="foto"
                                   accept="image/*"
                                   onchange="mostrarNombre(this, 'nombre-foto')">
                            <div class="file-upload-icon"><i class="fas fa-camera"></i></div>
                            <div class="file-upload-label">Subir foto</div>
                            <div class="file-upload-hint">JPG, PNG — máx. 2 MB</div>
                            <span class="file-upload-name" id="nombre-foto">
                                <i class="fas fa-check-circle" style="color:#10b981;"></i>
                                <span></span>
                            </span>
                        </div>
                        @error('foto')<div class="text-danger mt-1" style="font-size:.7rem;"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>

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
                    <div class="col-md-4">
                        <label class="form-label">Grado <span style="color:#ef4444;">*</span></label>
                        <select name="grado"
                                class="form-select @error('grado') is-invalid @enderror"
                                required>
                            <option value="">Seleccione</option>
                            @foreach($grados as $grado)
                                <option value="{{ $grado }}" {{ old('grado')==$grado?'selected':'' }}>{{ $grado }}</option>
                            @endforeach
                        </select>
                        @error('grado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sección <span style="color:#ef4444;">*</span></label>
                        <select name="seccion"
                                class="form-select @error('seccion') is-invalid @enderror"
                                required>
                            <option value="">Seleccione</option>
                            @foreach($secciones as $seccion)
                                <option value="{{ $seccion }}" {{ old('seccion')==$seccion?'selected':'' }}>{{ $seccion }}</option>
                            @endforeach
                        </select>
                        @error('seccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado <span style="color:#ef4444;">*</span></label>
                        <select name="estado"
                                class="form-select @error('estado') is-invalid @enderror"
                                required>
                            <option value="activo"   {{ old('estado','activo')=='activo'  ?'selected':'' }}>Activo</option>
                            <option value="inactivo" {{ old('estado')=='inactivo'?'selected':'' }}>Inactivo</option>
                        </select>
                        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- ══ SECCIÓN 3 · DOCUMENTOS ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">

                <div style="display:flex;align-items:center;gap:.5rem;
                            font-size:.75rem;font-weight:700;color:#00508f;
                            text-transform:uppercase;letter-spacing:.08em;
                            margin-bottom:.95rem;padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <i class="fas fa-folder-open" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Documentos Requeridos
                </div>

                <div class="row g-3">

                    {{-- Acta de Nacimiento --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Acta de Nacimiento <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="file-upload-area @error('acta_nacimiento') border-danger @enderror"
                             id="area-acta">
                            <input type="file" name="acta_nacimiento" id="acta_nacimiento"
                                   accept=".jpg,.png,.pdf"
                                   onchange="mostrarNombre(this, 'nombre-acta')" required>
                            <div class="file-upload-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="file-upload-label">Subir acta de nacimiento</div>
                            <div class="file-upload-hint">JPG, PNG o PDF — máx. 5 MB</div>
                            <span class="file-upload-name" id="nombre-acta">
                                <i class="fas fa-check-circle" style="color:#10b981;"></i>
                                <span></span>
                            </span>
                        </div>
                        @error('acta_nacimiento')
                            <div class="text-danger mt-1" style="font-size:.7rem;">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Calificaciones --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Calificaciones Anteriores <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="file-upload-area @error('calificaciones') border-danger @enderror"
                             id="area-calificaciones">
                            <input type="file" name="calificaciones" id="calificaciones"
                                   accept=".jpg,.png,.pdf"
                                   onchange="mostrarNombre(this, 'nombre-calificaciones')" required>
                            <div class="file-upload-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="file-upload-label">Subir calificaciones</div>
                            <div class="file-upload-hint">JPG, PNG o PDF — máx. 5 MB</div>
                            <span class="file-upload-name" id="nombre-calificaciones">
                                <i class="fas fa-check-circle" style="color:#10b981;"></i>
                                <span></span>
                            </span>
                        </div>
                        @error('calificaciones')
                            <div class="text-danger mt-1" style="font-size:.7rem;">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ══ SECCIÓN 4 · INFORMACIÓN ADICIONAL ══ --}}
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
                                  placeholder="Información adicional (alergias, condiciones médicas, notas especiales)"
                        >{{ old('observaciones') }}</textarea>
                        @error('observaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- ══ BOTONES ══ --}}
            <div style="display:flex;gap:.6rem;flex-wrap:wrap;
                        padding:1.1rem 1.7rem;
                        background:#f5f8fc;border-top:1px solid #e8edf4;
                        border-radius:0 0 14px 14px;">
                <button type="submit" class="btn btn-primary-custom flex-fill">
                    <i class="fas fa-save me-1"></i> Registrar Estudiante
                </button>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-cancel-custom flex-fill">
                    <i class="fas fa-times me-1"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Mostrar nombre del archivo seleccionado
function mostrarNombre(input, spanId) {
    const span = document.getElementById(spanId);
    if (input.files && input.files[0]) {
        span.querySelector('span').textContent = input.files[0].name;
        span.classList.add('visible');

        // Cambiar borde del área a verde
        input.closest('.file-upload-area').style.borderColor = '#10b981';
        input.closest('.file-upload-area').style.background  = 'rgba(16,185,129,.04)';
    }
}

// Drag & drop visual
document.querySelectorAll('.file-upload-area').forEach(area => {
    area.addEventListener('dragover',  e => { e.preventDefault(); area.classList.add('dragover'); });
    area.addEventListener('dragleave', () => area.classList.remove('dragover'));
    area.addEventListener('drop',      e => { e.preventDefault(); area.classList.remove('dragover'); });
});

// Generar correo automáticamente
document.addEventListener('DOMContentLoaded', function () {
    const nombre1   = document.querySelector('[name="nombre1"]');
    const apellido1 = document.querySelector('[name="apellido1"]');
    const emailInput = document.getElementById('email');

    function normalizar(txt) {
        return txt.normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-zA-Z]/g, '')
            .toLowerCase();
    }

    function generarCorreo() {
        const n = normalizar(nombre1.value   || '');
        const a = normalizar(apellido1.value || '');
        emailInput.value = (n && a) ? `${n}.${a}@egm.edu.hn` : '';
    }

    nombre1.addEventListener('input', generarCorreo);
    apellido1.addEventListener('input', generarCorreo);
});
</script>
@endpush