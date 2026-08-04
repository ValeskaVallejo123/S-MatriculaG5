@extends('layouts.app')

@section('title', 'Crear Estudiante')
@section('page-title', 'Nuevo Estudiante')

@section('topbar-actions')
    <a href="{{ route('estudiantes.index') }}"
       style="border:1.5px solid #e2e8f0;color:#6b7280;background:white;border-radius:8px;padding:.45rem 1rem;font-size:.88rem;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
:root {
    --c-primary: #00508f;
    --c-dark:    #003b73;
    --c-teal:    #4ec7d2;
    --c-green:   #10b981;
    --c-red:     #ef4444;
    --c-border:  #bfd9ea;
    --c-surface: #f8fbfd;
}

.form-control, .form-select {
    border: 2px solid var(--c-border) !important;
    border-radius: 10px;
    padding: 0.68rem 1rem 0.68rem 2.8rem !important;
    font-size: .88rem !important;
    transition: border-color 0.25s ease;
    height: auto !important;
    background: white;
}
select.form-select,
select[name="grado"],
select[name="seccion"],
select[name="estado"],
textarea.form-control {
    padding-left: 2.8rem !important;
}
textarea.form-control {
    padding-left: 2.6rem !important;
    resize: none;
    min-height: 80px;
}
.form-control:focus, .form-select:focus {
    border-color: var(--c-teal) !important;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.18) !important;
    outline: none;
}
.form-control.field-error,
.form-select.field-error,
.form-control.is-invalid,
.form-select.is-invalid {
    border-color: var(--c-red) !important;
    background: rgba(239,68,68,.03) !important;
}
.form-control.field-ok {
    border-color: var(--c-green) !important;
    background: rgba(16,185,129,.03) !important;
}

.field-wrap { position: relative; }
.field-icon-left {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--c-primary); font-size: .68rem; z-index: 5; pointer-events: none;
}
.field-wrap-ta .field-icon-left { top: 14px; transform: none; }

.form-label {
    color: var(--c-dark) !important;
    font-size: .63rem !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: .22rem;
    display: flex; align-items: center; gap: .3rem;
}
.lbl-required { color: var(--c-red); font-size: .75rem; }
.lbl-optional  { color: #94a3b8; font-weight: 400; text-transform: none; font-size: .7rem; letter-spacing: 0; }

.field-msg {
    font-size: .7rem; font-weight: 600; margin-top: .3rem;
    display: flex; align-items: center; gap: .3rem;
    min-height: 1.1rem;
}
.field-msg.err  { color: var(--c-red); }
.field-msg.ok   { color: var(--c-green); }
.field-msg.hint { color: #94a3b8; font-weight: 400; }

.sec-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700; color: var(--c-primary);
    text-transform: uppercase; letter-spacing: .08em;
    margin-bottom: .95rem; padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.15);
}
.sec-title i { color: var(--c-teal); font-size: .88rem; }

/* File upload */
.file-upload-area {
    border: 2px dashed var(--c-border);
    border-radius: 10px; padding: 1.1rem 1rem;
    text-align: center; cursor: pointer;
    transition: all .25s; background: var(--c-surface);
    position: relative;
}
.file-upload-area:hover, .file-upload-area.dragover {
    border-color: var(--c-teal); background: rgba(78,199,210,.05);
}
.file-upload-area.file-ok    { border-color: var(--c-green); background: rgba(16,185,129,.04); }
.file-upload-area.file-error { border-color: var(--c-red);   background: rgba(239,68,68,.03); }
.file-upload-area input[type="file"] {
    position: absolute; inset: 0; opacity: 0;
    cursor: pointer; width: 100%; height: 100%;
}
.file-upload-icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(78,199,210,.12);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto .5rem; color: var(--c-primary); font-size: 1.1rem;
    transition: background .2s;
}
.file-ok    .file-upload-icon { background: rgba(16,185,129,.12); color: var(--c-green); }
.file-error .file-upload-icon { background: rgba(239,68,68,.12);  color: var(--c-red); }
.file-upload-label { font-size: .78rem; font-weight: 600; color: var(--c-dark); margin-bottom: .2rem; }
.file-upload-hint  { font-size: .7rem; color: #94a3b8; }
.file-upload-name  {
    display: none; margin-top: .5rem;
    font-size: .75rem; font-weight: 600; color: var(--c-green);
    background: rgba(16,185,129,.1); border-radius: 6px;
    padding: .25rem .6rem; align-items: center; gap: .35rem;
}
.file-upload-name.visible { display: inline-flex; }

/* Info de acceso */
.acceso-box {
    background: rgba(78,199,210,.07);
    border: 1px solid rgba(78,199,210,.3);
    border-radius: 10px; padding: .85rem 1.1rem;
    display: flex; gap: .75rem; align-items: flex-start;
    margin-top: .5rem;
}
.acceso-box i  { color: var(--c-teal); margin-top: .1rem; flex-shrink: 0; }
.acceso-box p  { margin: 0; font-size: .78rem; color: #475569; line-height: 1.6; }
.acceso-box strong { color: var(--c-dark); }
.acceso-box code {
    background: rgba(0,80,143,.08); color: var(--c-primary);
    border-radius: 4px; padding: .05rem .35rem;
    font-size: .78rem; font-family: monospace;
}

.btn-submit {
    background: linear-gradient(135deg, var(--c-teal), var(--c-primary));
    color: white; border: none; border-radius: 9px;
    padding: .65rem .9rem; font-size: .85rem; font-weight: 700;
    box-shadow: 0 2px 10px rgba(78,199,210,.3); transition: all .2s;
    display: inline-flex; align-items: center; gap: .4rem; cursor: pointer;
}
.btn-submit:hover { color: white; box-shadow: 0 4px 16px rgba(78,199,210,.45); transform: translateY(-2px); }
.btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }

.btn-cancel {
    border: 1.5px solid var(--c-primary); color: var(--c-primary);
    background: white; border-radius: 9px;
    padding: .65rem .9rem; font-size: .85rem; font-weight: 700;
    transition: all .2s; text-decoration: none;
    display: inline-flex; align-items: center; gap: .4rem;
}
.btn-cancel:hover { background: #eff6ff; color: var(--c-primary); transform: translateY(-2px); }

.char-count { font-size: .65rem; color: #94a3b8; margin-left: auto; }
.char-count.near { color: var(--c-red); }

.frm-alert-errors {
    background: #fef2f2; border: 1px solid #fca5a5;
    border-radius: 10px; padding: .9rem 1.1rem;
    margin: 1rem 1.7rem 0;
}
.frm-alert-errors-title {
    font-size: .8rem; font-weight: 700; color: #991b1b;
    display: flex; align-items: center; gap: .4rem; margin-bottom: .5rem;
}
.frm-alert-errors ul { margin: 0; padding-left: 1.25rem; }
.frm-alert-errors ul li { font-size: .78rem; color: #b91c1c; margin-bottom: .2rem; }
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- Header --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem; position:relative; overflow:hidden;">
        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px;height:80px;border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-user-plus" style="color:white;font-size:2rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white;margin:0 0 .4rem;">
                    Registro de Estudiante
                </h2>
                <span style="display:inline-flex;align-items:center;gap:.3rem;
                             padding:.2rem .65rem;border-radius:999px;
                             background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                             font-size:.72rem;font-weight:600;border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-pen"></i> Complete la información requerida
                </span>
            </div>
        </div>
    </div>

    {{-- Formulario --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        @if($errors->any())
        <div class="frm-alert-errors">
            <div class="frm-alert-errors-title">
                <i class="fas fa-exclamation-circle"></i>
                Por favor corrige los siguientes errores:
            </div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('estudiantes.store') }}" method="POST"
              enctype="multipart/form-data" id="formEstudiante" novalidate>
            @csrf

            {{-- ══ SECCIÓN 1: INFORMACIÓN PERSONAL ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-user"></i> Información Personal</div>
                <div class="row g-3">

                    {{-- Primer Nombre --}}
                    <div class="col-md-6">
                        <label class="form-label">Primer Nombre <span class="lbl-required">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-user field-icon-left"></i>
                            <input type="text" name="nombre1" id="nombre1"
                                   class="form-control {{ $errors->has('nombre1') ? 'field-error' : '' }}"
                                   value="{{ old('nombre1') }}" placeholder="Ej: Juan"
                                   oninput="soloLetras(this); generarEmail();">
                        </div>
                        <div class="field-msg {{ $errors->has('nombre1') ? 'err' : 'hint' }}" id="msg-nombre1">
                            @error('nombre1') <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else <i class="fas fa-info-circle"></i> Solo letras y espacios @enderror
                        </div>
                    </div>

                    {{-- Segundo Nombre --}}
                    <div class="col-md-6">
                        <label class="form-label">Segundo Nombre <span class="lbl-optional">(Opcional)</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-user field-icon-left"></i>
                            <input type="text" name="nombre2" id="nombre2"
                                   class="form-control" value="{{ old('nombre2') }}"
                                   placeholder="Ej: Carlos" oninput="soloLetras(this);">
                        </div>
                        <div class="field-msg hint" id="msg-nombre2">
                            <i class="fas fa-info-circle"></i> Solo letras y espacios
                        </div>
                    </div>

                    {{-- Primer Apellido --}}
                    <div class="col-md-6">
                        <label class="form-label">Primer Apellido <span class="lbl-required">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-user field-icon-left"></i>
                            <input type="text" name="apellido1" id="apellido1"
                                   class="form-control {{ $errors->has('apellido1') ? 'field-error' : '' }}"
                                   value="{{ old('apellido1') }}" placeholder="Ej: Pérez"
                                   oninput="soloLetras(this); generarEmail();">
                        </div>
                        <div class="field-msg {{ $errors->has('apellido1') ? 'err' : 'hint' }}" id="msg-apellido1">
                            @error('apellido1') <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else <i class="fas fa-info-circle"></i> Solo letras y espacios @enderror
                        </div>
                    </div>

                    {{-- Segundo Apellido --}}
                    <div class="col-md-6">
                        <label class="form-label">Segundo Apellido <span class="lbl-optional">(Opcional)</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-user field-icon-left"></i>
                            <input type="text" name="apellido2" id="apellido2"
                                   class="form-control" value="{{ old('apellido2') }}"
                                   placeholder="Ej: García" oninput="soloLetras(this);">
                        </div>
                        <div class="field-msg hint" id="msg-apellido2">
                            <i class="fas fa-info-circle"></i> Solo letras y espacios
                        </div>
                    </div>

                    {{-- DNI --}}
                    <div class="col-md-6">
                        <label class="form-label">DNI <span class="lbl-required">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-id-card field-icon-left"></i>
                            <input type="text" name="dni" id="dni"
                                   class="form-control {{ $errors->has('dni') ? 'field-error' : '' }}"
                                   value="{{ old('dni') }}"
                                   placeholder="0703199512345"
                                   maxlength="13"
                                   inputmode="numeric"
                                   oninput="formatearDNI(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('dni') ? 'err' : 'hint' }}" id="msg-dni">
                            @error('dni') <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else <i class="fas fa-info-circle"></i> Solo números, exactamente 13 dígitos @enderror
                        </div>
                    </div>

                    {{-- Fecha de Nacimiento --}}
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Nacimiento <span class="lbl-required">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-calendar field-icon-left"></i>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                                   class="form-control {{ $errors->has('fecha_nacimiento') ? 'field-error' : '' }}"
                                   value="{{ old('fecha_nacimiento') }}" onchange="validarFecha(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('fecha_nacimiento') ? 'err' : 'hint' }}" id="msg-fecha_nacimiento">
                            @error('fecha_nacimiento') <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else <i class="fas fa-info-circle"></i> El estudiante debe tener entre 4 y 20 años @enderror
                        </div>
                    </div>

                    {{-- Género --}}
                    <div class="col-md-6">
                        <label class="form-label">Género <span class="lbl-required">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-venus-mars field-icon-left" style="z-index:10;"></i>
                            <select name="sexo" id="sexo"
                                    class="form-select {{ $errors->has('sexo') ? 'field-error' : '' }}"
                                    onchange="validarSelect(this,'msg-sexo','El género');">
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('sexo')=='masculino'?'selected':'' }}>Masculino</option>
                                <option value="femenino"  {{ old('sexo')=='femenino' ?'selected':'' }}>Femenino</option>
                            </select>
                        </div>
                        <div class="field-msg {{ $errors->has('sexo') ? 'err' : '' }}" id="msg-sexo">
                            @error('sexo')<i class="fas fa-exclamation-circle"></i> {{ $message }}@enderror
                        </div>
                    </div>

                    {{-- Correo Electrónico --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Correo Electrónico
                            <span class="lbl-optional">(Opcional — se genera si lo dejas vacío)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-envelope field-icon-left"></i>
                            <input type="email" name="email" id="email"
                                   class="form-control {{ $errors->has('email') ? 'field-error' : '' }}"
                                   value="{{ old('email') }}"
                                   placeholder="nombre.apellido@egm.edu.hn"
                                   autocomplete="off">
                        </div>
                        <div class="field-msg {{ $errors->has('email') ? 'err' : 'hint' }}" id="msg-email">
                            @error('email') <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else <i class="fas fa-info-circle"></i> Se genera automáticamente, pero puedes cambiarlo @enderror
                        </div>
                    </div>

                    {{-- Teléfono --}}
                    <div class="col-md-6">
                        <label class="form-label">Teléfono <span class="lbl-optional">(Opcional)</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-phone field-icon-left"></i>
                            <input type="text" name="telefono" id="telefono"
                                   class="form-control {{ $errors->has('telefono') ? 'field-error' : '' }}"
                                   value="{{ old('telefono') }}" placeholder="9999-9999"
                                   maxlength="9" oninput="formatearTelefono(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('telefono') ? 'err' : 'hint' }}" id="msg-telefono">
                            @error('telefono') <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else <i class="fas fa-info-circle"></i> Formato: 9999-9999 @enderror
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div class="col-md-6">
                        <label class="form-label">Dirección <span class="lbl-optional">(Opcional)</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-map-marker-alt field-icon-left"></i>
                            <input type="text" name="direccion" id="direccion"
                                   class="form-control {{ $errors->has('direccion') ? 'field-error' : '' }}"
                                   value="{{ old('direccion') }}" placeholder="Colonia, ciudad">
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="col-md-6">
                        <label class="form-label">Foto del Estudiante <span class="lbl-optional">(Opcional)</span></label>
                        <div class="file-upload-area" id="area-foto">
                            <input type="file" name="foto" id="foto" accept="image/jpeg,image/png"
                                   onchange="mostrarNombre(this,'nombre-foto','area-foto'); validarArchivo(this,'msg-foto',2);">
                            <div class="file-upload-icon"><i class="fas fa-camera"></i></div>
                            <div class="file-upload-label">Subir foto</div>
                            <div class="file-upload-hint">JPG, PNG — máx. 2 MB</div>
                            <span class="file-upload-name" id="nombre-foto">
                                <i class="fas fa-check-circle"></i><span></span>
                            </span>
                        </div>
                        <div class="field-msg err mt-1" id="msg-foto" style="display:none;"></div>
                        @error('foto')
                            <div class="field-msg err mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Caja informativa de acceso --}}
                    <div class="col-12">
                        <div class="acceso-box">
                            <i class="fas fa-key"></i>
                            <p>
                                <strong>Acceso al sistema:</strong> Al registrar al estudiante se creará su cuenta automáticamente.
                                El correo será el que ingreses arriba, o se genera si lo dejas vacío.
                                La <strong>contraseña inicial será <code>egm2025</code></strong> para todos los estudiantes.
                                El estudiante podrá cambiarla al ingresar al sistema.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ══ SECCIÓN 2: INFORMACIÓN ACADÉMICA ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-graduation-cap"></i> Información Académica</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Grado <span class="lbl-required">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-layer-group field-icon-left" style="z-index:10;"></i>
                            <select name="grado" id="grado"
                                    class="form-select {{ $errors->has('grado') ? 'field-error' : '' }}"
                                    onchange="validarSelect(this,'msg-grado','El grado');">
                                <option value="">Seleccione</option>
                                @foreach($grados as $g)
                                    <option value="{{ $g }}" {{ old('grado')==$g?'selected':'' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-msg {{ $errors->has('grado') ? 'err' : '' }}" id="msg-grado">
                            @error('grado')<i class="fas fa-exclamation-circle"></i> {{ $message }}@enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sección <span class="lbl-required">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-sitemap field-icon-left" style="z-index:10;"></i>
                            <select name="seccion" id="seccion"
                                    class="form-select {{ $errors->has('seccion') ? 'field-error' : '' }}"
                                    onchange="validarSelect(this,'msg-seccion','La sección');">
                                <option value="">Seleccione</option>
                                @foreach($secciones as $s)
                                    <option value="{{ $s }}" {{ old('seccion')==$s?'selected':'' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-msg {{ $errors->has('seccion') ? 'err' : '' }}" id="msg-seccion">
                            @error('seccion')<i class="fas fa-exclamation-circle"></i> {{ $message }}@enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado <span class="lbl-required">*</span></label>
                        <div class="field-wrap">
                            <i class="fas fa-toggle-on field-icon-left" style="z-index:10;"></i>
                            <select name="estado" id="estado"
                                    class="form-select {{ $errors->has('estado') ? 'field-error' : '' }}">
                                <option value="activo"   {{ old('estado','activo')=='activo'   ?'selected':'' }}>Activo</option>
                                <option value="inactivo" {{ old('estado')=='inactivo'?'selected':'' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══ SECCIÓN 3: DOCUMENTOS ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-folder-open"></i> Documentos Requeridos</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Acta de Nacimiento <span class="lbl-required">*</span></label>
                        <div class="file-upload-area" id="area-acta">
                            <input type="file" name="acta_nacimiento" id="acta_nacimiento"
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   onchange="mostrarNombre(this,'nombre-acta','area-acta'); validarArchivo(this,'msg-acta',5);">
                            <div class="file-upload-icon"><i class="fas fa-file-alt"></i></div>
                            <div class="file-upload-label">Subir acta de nacimiento</div>
                            <div class="file-upload-hint">JPG, PNG o PDF — máx. 5 MB</div>
                            <span class="file-upload-name" id="nombre-acta">
                                <i class="fas fa-check-circle"></i><span></span>
                            </span>
                        </div>
                        <div class="field-msg err mt-1" id="msg-acta" style="display:none;"></div>
                        @error('acta_nacimiento')
                            <div class="field-msg err mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Calificaciones Anteriores <span class="lbl-required">*</span></label>
                        <div class="file-upload-area" id="area-calificaciones">
                            <input type="file" name="calificaciones" id="calificaciones"
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   onchange="mostrarNombre(this,'nombre-calificaciones','area-calificaciones'); validarArchivo(this,'msg-calificaciones',5);">
                            <div class="file-upload-icon"><i class="fas fa-clipboard-list"></i></div>
                            <div class="file-upload-label">Subir calificaciones</div>
                            <div class="file-upload-hint">JPG, PNG o PDF — máx. 5 MB</div>
                            <span class="file-upload-name" id="nombre-calificaciones">
                                <i class="fas fa-check-circle"></i><span></span>
                            </span>
                        </div>
                        <div class="field-msg err mt-1" id="msg-calificaciones" style="display:none;"></div>
                        @error('calificaciones')
                            <div class="field-msg err mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ══ SECCIÓN 4: INFORMACIÓN ADICIONAL ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-clipboard"></i> Información Adicional</div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">
                            Observaciones <span class="lbl-optional">(Opcional)</span>
                            <span class="char-count" id="char-obs">0/500</span>
                        </label>
                        <div class="field-wrap field-wrap-ta">
                            <i class="fas fa-sticky-note field-icon-left" style="top:14px;transform:none;"></i>
                            <textarea name="observaciones" id="observaciones" rows="3" maxlength="500"
                                      class="form-control {{ $errors->has('observaciones') ? 'field-error' : '' }}"
                                      placeholder="Alergias, condiciones médicas, notas especiales..."
                            >{{ old('observaciones') }}</textarea>
                        </div>
                        @error('observaciones')
                            <div class="field-msg err mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div style="display:flex;gap:.6rem;flex-wrap:wrap;
                        padding:1.1rem 1.7rem;background:#f5f8fc;
                        border-top:1px solid #e8edf4;border-radius:0 0 14px 14px;">
                <button type="submit" class="btn-submit flex-fill" id="btnSubmit">
                    <i class="fas fa-save"></i> Registrar Estudiante
                </button>
                <a href="{{ route('estudiantes.index') }}" class="btn-cancel flex-fill">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
/* ═══════════════════════════════════
   UTILIDADES
═══════════════════════════════════ */
function setMsg(id, tipo, texto) {
    var el = document.getElementById(id);
    if (!el) return;
    el.className = 'field-msg ' + tipo;
    el.style.display = '';
    el.innerHTML = texto;
}
function setFieldOk(i)      { i.classList.remove('field-error'); i.classList.add('field-ok'); }
function setFieldErr(i)     { i.classList.remove('field-ok');    i.classList.add('field-error'); }
function setFieldNeutral(i) { i.classList.remove('field-error', 'field-ok'); }

/* ═══════════════════════════════════
   SOLO LETRAS
═══════════════════════════════════ */
function soloLetras(input) {
    var val    = input.value;
    var limpio = val.replace(/[^a-záéíóúüñA-ZÁÉÍÓÚÜÑ\s]/g, '');
    if (val !== limpio) input.value = limpio;
    var msgId = 'msg-' + input.id;
    if (!limpio.trim() && input.required) {
        setFieldErr(input);
        setMsg(msgId, 'err', '<i class="fas fa-exclamation-circle"></i> Este campo es obligatorio.');
    } else if (limpio.trim()) {
        setFieldOk(input);
        setMsg(msgId, 'hint', '<i class="fas fa-info-circle"></i> Solo letras y espacios');
    } else {
        setFieldNeutral(input);
        setMsg(msgId, 'hint', '<i class="fas fa-info-circle"></i> Solo letras y espacios');
    }
}

/* ═══════════════════════════════════
   DNI — solo números, exactamente 13 dígitos
═══════════════════════════════════ */
function formatearDNI(input) {
    var digits = input.value.replace(/\D/g, '').substring(0, 13);
    input.value = digits;

    if (!digits) {
        setFieldErr(input);
        setMsg('msg-dni', 'err', '<i class="fas fa-exclamation-circle"></i> El DNI es obligatorio.');
    } else if (digits.length === 13) {
        setFieldOk(input);
        setMsg('msg-dni', 'ok', '<i class="fas fa-check-circle"></i> DNI válido');
    } else {
        setFieldErr(input);
        setMsg('msg-dni', 'err',
            '<i class="fas fa-exclamation-circle"></i> El DNI debe tener 13 dígitos (' + digits.length + '/13)');
    }
}

/* ═══════════════════════════════════
   TELÉFONO
═══════════════════════════════════ */
function formatearTelefono(input) {
    var digits = input.value.replace(/\D/g, '').substring(0, 8);
    input.value = digits.length > 4 ? digits.substring(0,4) + '-' + digits.substring(4) : digits;
    if (!digits) {
        setFieldNeutral(input);
        setMsg('msg-telefono', 'hint', '<i class="fas fa-info-circle"></i> Formato: 9999-9999');
        return;
    }
    if (/^\d{4}-\d{4}$/.test(input.value)) {
        setFieldOk(input);
        setMsg('msg-telefono', 'ok', '<i class="fas fa-check-circle"></i> Teléfono válido');
    } else {
        setFieldErr(input);
        setMsg('msg-telefono', 'err', '<i class="fas fa-exclamation-circle"></i> Formato incompleto — debe ser 9999-9999');
    }
}

/* ═══════════════════════════════════
   FECHA
═══════════════════════════════════ */
function validarFecha(input) {
    if (!input.value) {
        setFieldErr(input);
        setMsg('msg-fecha_nacimiento', 'err', '<i class="fas fa-exclamation-circle"></i> La fecha de nacimiento es obligatoria.');
        return;
    }
    var edad = (new Date() - new Date(input.value)) / (1000 * 60 * 60 * 24 * 365.25);
    if (edad < 4 || edad > 20) {
        setFieldErr(input);
        setMsg('msg-fecha_nacimiento', 'err', '<i class="fas fa-exclamation-circle"></i> El estudiante debe tener entre 4 y 20 años.');
    } else {
        setFieldOk(input);
        setMsg('msg-fecha_nacimiento', 'ok', '<i class="fas fa-check-circle"></i> Fecha válida');
    }
}

/* ═══════════════════════════════════
   SELECTS
═══════════════════════════════════ */
function validarSelect(input, msgId, label) {
    if (!input.value) {
        setFieldErr(input);
        setMsg(msgId, 'err', '<i class="fas fa-exclamation-circle"></i> ' + label + ' es obligatorio.');
    } else {
        setFieldOk(input);
        setMsg(msgId, 'ok', '<i class="fas fa-check-circle"></i> Seleccionado');
    }
}

/* ═══════════════════════════════════
   ARCHIVOS
═══════════════════════════════════ */
function validarArchivo(input, msgId, maxMB) {
    var msgEl = document.getElementById(msgId);
    var area  = input.closest('.file-upload-area');
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];
    var ext  = file.name.split('.').pop().toLowerCase();
    if (!['jpg','jpeg','png','pdf'].includes(ext)) {
        if (msgEl) { msgEl.style.display = 'flex'; msgEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> Tipo no permitido. Use JPG, PNG o PDF.'; }
        if (area)  { area.classList.remove('file-ok'); area.classList.add('file-error'); }
        input.value = '';
        return;
    }
    if (file.size / (1024 * 1024) > maxMB) {
        if (msgEl) { msgEl.style.display = 'flex'; msgEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> El archivo supera ' + maxMB + ' MB.'; }
        if (area)  { area.classList.remove('file-ok'); area.classList.add('file-error'); }
        input.value = '';
        return;
    }
    if (msgEl) msgEl.style.display = 'none';
    if (area)  area.classList.remove('file-error');
}

/* ═══════════════════════════════════
   EMAIL — automático pero editable
═══════════════════════════════════ */
var emailManual = false;

function generarEmail() {
    if (emailManual) return;
    function norm(txt) {
        return txt.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-zA-Z]/g, '').toLowerCase();
    }
    var n  = norm(document.getElementById('nombre1').value   || '');
    var a  = norm(document.getElementById('apellido1').value || '');
    var el = document.getElementById('email');
    if (n && a) {
        el.value = n + '.' + a + '@egm.edu.hn';
        setFieldOk(el);
        setMsg('msg-email', 'ok', '<i class="fas fa-check-circle"></i> Generado automáticamente — puedes editarlo si lo necesitas');
    } else {
        el.value = '';
        setFieldNeutral(el);
        setMsg('msg-email', 'hint', '<i class="fas fa-info-circle"></i> Se genera automáticamente, pero puedes cambiarlo');
    }
}

/* ═══════════════════════════════════
   FILE UPLOAD — nombre visible
═══════════════════════════════════ */
function mostrarNombre(input, spanId, areaId) {
    var span = document.getElementById(spanId);
    var area = document.getElementById(areaId);
    if (input.files && input.files[0]) {
        span.querySelector('span').textContent = input.files[0].name;
        span.classList.add('visible');
        if (area) { area.classList.remove('file-error'); area.classList.add('file-ok'); }
    }
}

/* ═══════════════════════════════════
   VALIDACIÓN AL ENVIAR
═══════════════════════════════════ */
document.getElementById('formEstudiante').addEventListener('submit', function (e) {
    var err = [];

    // Nombre1
    var n1 = document.getElementById('nombre1');
    if (!n1.value.trim()) {
        setFieldErr(n1);
        setMsg('msg-nombre1', 'err', '<i class="fas fa-exclamation-circle"></i> El primer nombre es obligatorio.');
        err.push('El primer nombre es obligatorio.');
    }

    // Apellido1
    var a1 = document.getElementById('apellido1');
    if (!a1.value.trim()) {
        setFieldErr(a1);
        setMsg('msg-apellido1', 'err', '<i class="fas fa-exclamation-circle"></i> El primer apellido es obligatorio.');
        err.push('El primer apellido es obligatorio.');
    }

    // DNI — 13 dígitos numéricos
    var dni = document.getElementById('dni');
    if (!dni.value.trim()) {
        setFieldErr(dni);
        setMsg('msg-dni', 'err', '<i class="fas fa-exclamation-circle"></i> El DNI es obligatorio.');
        err.push('El DNI es obligatorio.');
    } else if (!/^\d{13}$/.test(dni.value.trim())) {
        setFieldErr(dni);
        setMsg('msg-dni', 'err', '<i class="fas fa-exclamation-circle"></i> El DNI debe tener exactamente 13 dígitos numéricos.');
        err.push('El DNI debe tener exactamente 13 dígitos.');
    }

    // Fecha
    var fecha = document.getElementById('fecha_nacimiento');
    if (!fecha.value) {
        setFieldErr(fecha);
        setMsg('msg-fecha_nacimiento', 'err', '<i class="fas fa-exclamation-circle"></i> La fecha de nacimiento es obligatoria.');
        err.push('La fecha de nacimiento es obligatoria.');
    } else {
        var edad = (new Date() - new Date(fecha.value)) / (1000 * 60 * 60 * 24 * 365.25);
        if (edad < 4 || edad > 20) {
            setFieldErr(fecha);
            setMsg('msg-fecha_nacimiento', 'err', '<i class="fas fa-exclamation-circle"></i> El estudiante debe tener entre 4 y 20 años.');
            err.push('La edad del estudiante debe estar entre 4 y 20 años.');
        }
    }

    // Sexo
    var sexo = document.getElementById('sexo');
    if (!sexo.value) {
        setFieldErr(sexo);
        setMsg('msg-sexo', 'err', '<i class="fas fa-exclamation-circle"></i> El género es obligatorio.');
        err.push('El género es obligatorio.');
    }

    // Email (si se ingresó)
    var emailEl = document.getElementById('email');
    if (emailEl.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value.trim())) {
        setFieldErr(emailEl);
        setMsg('msg-email', 'err', '<i class="fas fa-exclamation-circle"></i> El correo electrónico no es válido.');
        err.push('El correo electrónico no es válido.');
    }

    // Grado
    var grado = document.getElementById('grado');
    if (!grado.value) {
        setFieldErr(grado);
        setMsg('msg-grado', 'err', '<i class="fas fa-exclamation-circle"></i> El grado es obligatorio.');
        err.push('El grado es obligatorio.');
    }

    // Sección
    var seccion = document.getElementById('seccion');
    if (!seccion.value) {
        setFieldErr(seccion);
        setMsg('msg-seccion', 'err', '<i class="fas fa-exclamation-circle"></i> La sección es obligatoria.');
        err.push('La sección es obligatoria.');
    }

    // Acta de nacimiento
    var acta = document.getElementById('acta_nacimiento');
    if (!acta.files || !acta.files[0]) {
        var aa = document.getElementById('area-acta');
        if (aa) aa.classList.add('file-error');
        var ma = document.getElementById('msg-acta');
        if (ma) { ma.style.display = 'flex'; ma.innerHTML = '<i class="fas fa-exclamation-circle"></i> El acta de nacimiento es obligatoria.'; }
        err.push('El acta de nacimiento es obligatoria.');
    }

    // Calificaciones
    var cal = document.getElementById('calificaciones');
    if (!cal.files || !cal.files[0]) {
        var ac = document.getElementById('area-calificaciones');
        if (ac) ac.classList.add('file-error');
        var mc = document.getElementById('msg-calificaciones');
        if (mc) { mc.style.display = 'flex'; mc.innerHTML = '<i class="fas fa-exclamation-circle"></i> Las calificaciones anteriores son obligatorias.'; }
        err.push('Las calificaciones anteriores son obligatorias.');
    }

    // Teléfono (si se ingresó)
    var tel = document.getElementById('telefono');
    if (tel.value.trim() && !/^\d{4}-\d{4}$/.test(tel.value.trim())) {
        setFieldErr(tel);
        setMsg('msg-telefono', 'err', '<i class="fas fa-exclamation-circle"></i> El teléfono debe tener el formato 9999-9999.');
        err.push('El formato del teléfono no es válido.');
    }

    if (err.length > 0) {
        e.preventDefault();
        var box = document.querySelector('.frm-alert-errors');
        if (!box) {
            box = document.createElement('div');
            box.className = 'frm-alert-errors';
            document.getElementById('formEstudiante').before(box);
        }
        box.innerHTML = '<div class="frm-alert-errors-title"><i class="fas fa-exclamation-circle"></i> Por favor corrige los siguientes errores:</div><ul>'
            + err.map(function (e) { return '<li>' + e + '</li>'; }).join('')
            + '</ul>';
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnSubmit').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
    }
});

/* ═══════════════════════════════════
   INICIALIZAR
═══════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
    var emailEl = document.getElementById('email');

    if (emailEl.value) emailManual = true;

    emailEl.addEventListener('input', function () {
        emailManual = this.value.trim() !== '';
        if (this.value.trim()) {
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value.trim())) {
                setFieldErr(this);
                setMsg('msg-email', 'err', '<i class="fas fa-exclamation-circle"></i> Ingresa un correo válido.');
            } else {
                setFieldOk(this);
                setMsg('msg-email', 'ok', '<i class="fas fa-check-circle"></i> Correo válido');
            }
        } else {
            emailManual = false;
            setFieldNeutral(this);
            setMsg('msg-email', 'hint', '<i class="fas fa-info-circle"></i> Se genera automáticamente, pero puedes cambiarlo');
        }
    });

    // Re-validar campos con old()
    ['nombre1','nombre2','apellido1','apellido2'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el && el.value) soloLetras(el);
    });
    generarEmail();

    var dniEl   = document.getElementById('dni');
    var telEl   = document.getElementById('telefono');
    var fechaEl = document.getElementById('fecha_nacimiento');
    if (dniEl   && dniEl.value)   formatearDNI(dniEl);
    if (telEl   && telEl.value)   formatearTelefono(telEl);
    if (fechaEl && fechaEl.value) validarFecha(fechaEl);

    // Contador observaciones
    var obsEl  = document.getElementById('observaciones');
    var charEl = document.getElementById('char-obs');
    if (obsEl && charEl) {
        obsEl.addEventListener('input', function () {
            var l = this.value.length;
            charEl.textContent = l + '/500';
            charEl.className = 'char-count' + (l > 450 ? ' near' : '');
        });
        if (obsEl.value) charEl.textContent = obsEl.value.length + '/500';
    }

    // Drag & drop en áreas de archivo
    document.querySelectorAll('.file-upload-area').forEach(function (area) {
        area.addEventListener('dragover',  function (e) { e.preventDefault(); area.classList.add('dragover'); });
        area.addEventListener('dragleave', function ()  { area.classList.remove('dragover'); });
        area.addEventListener('drop',      function (e) { e.preventDefault(); area.classList.remove('dragover'); });
    });
});
</script>
@endpush
