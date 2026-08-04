@extends('layouts.app')

@section('title', 'Registrar Padre / Tutor')
@section('page-title', 'Registrar Padre / Tutor')

@section('topbar-actions')
    <a href="{{ route('padres.index') }}"
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
    transition: all 0.3s ease;
    height: auto !important;
    background: white;
    font-family: inherit;
    color: #0d2137;
}
.form-control:focus, .form-select:focus {
    border-color: var(--c-teal) !important;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.18) !important;
    outline: none;
}
.form-control.field-error, .form-select.field-error {
    border-color: var(--c-red) !important;
    background: rgba(239,68,68,.03) !important;
}
.form-control.field-ok, .form-select.field-ok {
    border-color: var(--c-green) !important;
    background: rgba(16,185,129,.03) !important;
}
textarea.form-control {
    padding-left: 2.6rem !important;
    resize: none;
    min-height: 80px;
}
.field-wrap { position: relative; }
.field-icon {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--c-primary); font-size: .68rem; z-index: 5; pointer-events: none;
}
.field-icon-ta { top: 14px; transform: none; }
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

/* Relacion cards */
.relation-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: .65rem;
}
@media(max-width:768px){ .relation-grid { grid-template-columns: repeat(3,1fr); } }
@media(max-width:480px){ .relation-grid { grid-template-columns: repeat(2,1fr); } }
.relation-option { display: none; }
.relation-label {
    display: flex; flex-direction: column; align-items: center; gap: .4rem;
    padding: .85rem .5rem; border: 2px solid var(--c-border); border-radius: 10px;
    cursor: pointer; transition: all .2s; text-align: center;
    font-size: .75rem; font-weight: 600; color: #6b7a90;
}
.relation-label .rl-icon {
    width: 36px; height: 36px; border-radius: 9px;
    background: rgba(0,80,143,.08); color: var(--c-primary);
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem;
}
.relation-option:checked + .relation-label {
    border-color: var(--c-teal); background: rgba(78,199,210,.1);
    color: var(--c-primary); transform: scale(1.03);
}
.relation-option:checked + .relation-label .rl-icon {
    background: var(--c-teal); color: white;
}
.relation-label:hover { border-color: var(--c-primary); background: #f0f6ff; }
.relation-grid.has-error .relation-label { border-color: var(--c-red); }

/* Prefijo telefono */
.input-prefix {
    display: flex; border: 2px solid var(--c-border);
    border-radius: 10px; overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
}
.input-prefix:focus-within {
    border-color: var(--c-teal);
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.15);
}
.input-prefix.field-error { border-color: var(--c-red); }
.input-prefix.field-ok    { border-color: var(--c-green); }
.prefix-tag {
    background: rgba(78,199,210,.1); color: var(--c-primary);
    font-weight: 700; font-size: .78rem; padding: 0 .75rem;
    display: flex; align-items: center; border-right: 2px solid var(--c-border);
    white-space: nowrap; flex-shrink: 0;
}
.input-prefix input {
    border: none !important; box-shadow: none !important;
    border-radius: 0 !important; flex: 1;
    padding: 0.68rem 1rem !important;
    font-size: .88rem !important; font-family: inherit;
    color: #0d2137; background: white; outline: none;
}

/* Avatar */
.foto-wrap { display: flex; flex-direction: column; align-items: center; gap: .75rem; }
.avatar-preview {
    width: 90px; height: 90px; border-radius: 50%;
    border: 3px solid var(--c-border);
    background: #f5f8fc; display: flex; align-items: center;
    justify-content: center; overflow: hidden;
}
.avatar-preview i { color: #bfd9ea; font-size: 2rem; }
.btn-upload {
    font-size: .72rem; font-weight: 600; color: var(--c-primary);
    background: none; border: 1.5px dashed var(--c-border);
    border-radius: 8px; padding: .4rem .9rem; cursor: pointer;
    transition: all .2s;
}
.btn-upload:hover { border-color: var(--c-teal); background: rgba(78,199,210,.1); }

/* Botones */
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
    background: white; border-radius: 9px; padding: .65rem .9rem;
    font-size: .85rem; font-weight: 700; transition: all .2s;
    text-decoration: none; display: inline-flex; align-items: center; gap: .4rem;
    cursor: pointer; font-family: inherit;
}
.btn-cancel:hover { background: #eff6ff; color: var(--c-primary); transform: translateY(-2px); }

/* Errores */
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
                padding:2rem;position:relative;overflow:hidden;">
        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:70px;height:70px;border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-user-friends" style="color:white;font-size:1.9rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white;margin:0 0 .4rem;">
                    Registrar Padre / Tutor
                </h2>
                <span style="display:inline-flex;align-items:center;gap:.3rem;
                             padding:.2rem .65rem;border-radius:999px;
                             background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                             font-size:.72rem;font-weight:600;border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-pen"></i> Complete los datos del responsable
                </span>
            </div>
        </div>
    </div>

    {{-- Body --}}
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

        <form action="{{ route('padres.store') }}" method="POST"
              enctype="multipart/form-data" id="frmPadre" novalidate>
            @csrf
            <input type="hidden" name="estado" value="activo">

            {{-- SECCION 1: DATOS PERSONALES --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-user"></i> Datos Personales</div>

                <div class="row g-3" style="align-items:start;">

                    {{-- Foto --}}
                    <div class="col-md-2 d-flex justify-content-center">
                        <div class="foto-wrap">
                            <div class="avatar-preview" id="avatarPreview">
                                <i class="fas fa-user"></i>
                            </div>
                            <button type="button" class="btn-upload"
                                    onclick="document.getElementById('fotoInput').click()">
                                <i class="fas fa-camera"></i> Subir foto
                            </button>
                            <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none;">
                            <span style="font-size:.68rem;color:#94a3b8;">JPG, PNG — max. 2 MB</span>
                            <div class="field-msg err" id="msg-foto" style="display:none;text-align:center;"></div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label" for="nombre1">
                                    Primer Nombre <span class="lbl-required">*</span>
                                </label>
                                <div class="field-wrap">
                                    <i class="fas fa-user field-icon"></i>
                                    <input type="text" id="nombre1" name="nombre1"
                                           class="form-control @error('nombre') field-error @enderror"
                                           value="{{ old('nombre1') }}" placeholder="Ej: Maria"
                                           maxlength="50" oninput="soloLetras(this);">
                                </div>
                                <div class="field-msg @error('nombre') err @else hint @enderror" id="msg-nombre1">
                                    @error('nombre')
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    @else
                                        <i class="fas fa-info-circle"></i> Solo letras y espacios
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="nombre2">
                                    Segundo Nombre <span class="lbl-optional">(Opcional)</span>
                                </label>
                                <div class="field-wrap">
                                    <i class="fas fa-user field-icon"></i>
                                    <input type="text" id="nombre2" name="nombre2"
                                           class="form-control"
                                           value="{{ old('nombre2') }}" placeholder="Opcional"
                                           maxlength="50" oninput="soloLetras(this);">
                                </div>
                                <div class="field-msg hint" id="msg-nombre2">
                                    <i class="fas fa-info-circle"></i> Solo letras y espacios
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="apellido1">
                                    Primer Apellido <span class="lbl-required">*</span>
                                </label>
                                <div class="field-wrap">
                                    <i class="fas fa-user field-icon"></i>
                                    <input type="text" id="apellido1" name="apellido1"
                                           class="form-control @error('apellido') field-error @enderror"
                                           value="{{ old('apellido1') }}" placeholder="Ej: Garcia"
                                           maxlength="50" oninput="soloLetras(this);">
                                </div>
                                <div class="field-msg @error('apellido') err @else hint @enderror" id="msg-apellido1">
                                    @error('apellido')
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    @else
                                        <i class="fas fa-info-circle"></i> Solo letras y espacios
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="apellido2">
                                    Segundo Apellido <span class="lbl-optional">(Opcional)</span>
                                </label>
                                <div class="field-wrap">
                                    <i class="fas fa-user field-icon"></i>
                                    <input type="text" id="apellido2" name="apellido2"
                                           class="form-control"
                                           value="{{ old('apellido2') }}" placeholder="Opcional"
                                           maxlength="50" oninput="soloLetras(this);">
                                </div>
                                <div class="field-msg hint" id="msg-apellido2">
                                    <i class="fas fa-info-circle"></i> Solo letras y espacios
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="dni">
                                    DNI / Identidad <span class="lbl-optional">(Opcional)</span>
                                </label>
                                <div class="field-wrap">
                                    <i class="fas fa-id-card field-icon"></i>
                                    <input type="text" id="dni" name="dni"
                                           class="form-control @error('dni') field-error @enderror"
                                           value="{{ old('dni') }}" placeholder="0801-1990-12345"
                                           maxlength="15" oninput="formatearDNI(this);">
                                </div>
                                <div class="field-msg @error('dni') err @else hint @enderror" id="msg-dni">
                                    @error('dni')
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    @else
                                        <i class="fas fa-info-circle"></i> Formato: 0801-1990-12345
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="fecha_nacimiento">
                                    Fecha de Nacimiento <span class="lbl-optional">(Opcional)</span>
                                </label>
                                <div class="field-wrap">
                                    <i class="fas fa-calendar field-icon"></i>
                                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                                           class="form-control"
                                           value="{{ old('fecha_nacimiento') }}"
                                           onchange="validarFechaPadre(this);">
                                </div>
                                <div class="field-msg hint" id="msg-fecha_nacimiento">
                                    <i class="fas fa-info-circle"></i> Debe tener entre 18 y 80 anos
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="genero">
                                    Genero <span class="lbl-optional">(Opcional)</span>
                                </label>
                                <div class="field-wrap">
                                    <i class="fas fa-venus-mars field-icon" style="z-index:10;"></i>
                                    <select id="genero" name="genero" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="M" {{ old('genero')=='M' ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ old('genero')=='F' ? 'selected' : '' }}>Femenino</option>
                                        <option value="O" {{ old('genero')=='O' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCION 2: RELACION --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-user-friends"></i> Relacion con el Estudiante</div>

                <div class="relation-grid" id="relationGrid">
                    @php
                        $relaciones = [
                            ['value'=>'padre',   'label'=>'Padre',    'icon'=>'fa-male'],
                            ['value'=>'madre',   'label'=>'Madre',    'icon'=>'fa-female'],
                            ['value'=>'abuelo',  'label'=>'Abuelo/a', 'icon'=>'fa-user'],
                            ['value'=>'hermano', 'label'=>'Hermano/a','icon'=>'fa-user-friends'],
                            ['value'=>'tio',     'label'=>'Tio/a',    'icon'=>'fa-user-tie'],
                            ['value'=>'tutor',   'label'=>'Tutor/a',  'icon'=>'fa-user-shield'],
                        ];
                    @endphp
                    @foreach($relaciones as $rel)
                        <input type="radio" name="relacion" id="rel_{{ $rel['value'] }}"
                               value="{{ $rel['value'] }}" class="relation-option"
                               {{ old('relacion')==$rel['value'] ? 'checked' : '' }}>
                        <label for="rel_{{ $rel['value'] }}" class="relation-label">
                            <div class="rl-icon"><i class="fas {{ $rel['icon'] }}"></i></div>
                            {{ $rel['label'] }}
                        </label>
                    @endforeach
                </div>

                <div class="field-msg err mt-2" id="msg-relacion" style="display:none;">
                    <i class="fas fa-exclamation-circle"></i> Debes seleccionar la relacion con el estudiante.
                </div>
                @error('parentesco')
                    <div class="field-msg err mt-2">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- SECCION 3: CONTACTO --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-phone"></i> Informacion de Contacto</div>

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">
                            Telefono Principal <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="input-prefix @error('telefono') field-error @enderror" id="wrap-telefono">
                            <span class="prefix-tag">+504</span>
                            <input type="tel" id="telefono" name="telefono"
                                   value="{{ old('telefono') }}"
                                   placeholder="9999-9999" maxlength="9"
                                   oninput="formatearTelefono(this, 'wrap-telefono', 'msg-telefono');">
                        </div>
                        <div class="field-msg @error('telefono') err @else hint @enderror" id="msg-telefono">
                            @error('telefono')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> Formato: 9999-9999
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Telefono Alternativo <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="input-prefix" id="wrap-telefono_alt">
                            <span class="prefix-tag">+504</span>
                            <input type="tel" id="telefono_alt" name="telefono_alt"
                                   value="{{ old('telefono_alt') }}"
                                   placeholder="9999-9999" maxlength="9"
                                   oninput="formatearTelefono(this, 'wrap-telefono_alt', 'msg-telefono_alt');">
                        </div>
                        <div class="field-msg hint" id="msg-telefono_alt">
                            <i class="fas fa-info-circle"></i> Formato: 9999-9999
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="correo">
                            Correo Electronico <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-envelope field-icon"></i>
                            <input type="email" id="correo" name="correo"
                                   class="form-control @error('correo') field-error @enderror"
                                   value="{{ old('correo') }}"
                                   placeholder="ejemplo@correo.com" maxlength="100"
                                   oninput="validarEmail(this);">
                        </div>
                        <div class="field-msg @error('correo') err @else hint @enderror" id="msg-correo">
                            @error('correo')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> Se usara para crear la cuenta del padre
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- SECCION 4: DIRECCION --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-map-marker-alt"></i> Direccion y Ocupacion</div>

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label" for="departamento">
                            Departamento <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-map field-icon" style="z-index:10;"></i>
                            <select id="departamento" name="departamento" class="form-select">
                                <option value="">-- Seleccionar --</option>
                                <option value="El Paraiso"        {{ old('departamento')=='El Paraiso'        ? 'selected' : '' }}>El Paraiso</option>
                                <option value="Francisco Morazan" {{ old('departamento')=='Francisco Morazan' ? 'selected' : '' }}>Francisco Morazan</option>
                                <option value="Choluteca"         {{ old('departamento')=='Choluteca'         ? 'selected' : '' }}>Choluteca</option>
                                <option value="Olancho"           {{ old('departamento')=='Olancho'           ? 'selected' : '' }}>Olancho</option>
                                <option value="Valle"             {{ old('departamento')=='Valle'             ? 'selected' : '' }}>Valle</option>
                                <option value="Otro"              {{ old('departamento')=='Otro'              ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="municipio">
                            Municipio / Ciudad <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-city field-icon"></i>
                            <input type="text" id="municipio" name="municipio"
                                   class="form-control"
                                   value="{{ old('municipio') }}"
                                   placeholder="Ej: Danli" maxlength="80">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="ocupacion">
                            Ocupacion / Profesion <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-briefcase field-icon"></i>
                            <input type="text" id="ocupacion" name="ocupacion"
                                   class="form-control"
                                   value="{{ old('ocupacion') }}"
                                   placeholder="Ej: Docente, Comerciante..." maxlength="80">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label" for="direccion">
                            Direccion Exacta <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-map-marker-alt field-icon field-icon-ta"></i>
                            <textarea id="direccion" name="direccion" rows="2" maxlength="255"
                                      class="form-control"
                                      placeholder="Barrio, colonia, calle, numero de casa...">{{ old('direccion') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="lugar_trabajo">
                            Lugar de Trabajo <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-building field-icon"></i>
                            <input type="text" id="lugar_trabajo" name="lugar_trabajo"
                                   class="form-control"
                                   value="{{ old('lugar_trabajo') }}"
                                   placeholder="Nombre de la empresa" maxlength="100">
                        </div>
                    </div>

                </div>
            </div>

            {{-- SECCION 5: OBSERVACIONES --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-clipboard-list"></i> Observaciones</div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="observaciones">
                            Notas adicionales <span class="lbl-optional">(Opcional)</span>
                            <span id="char-obs" style="font-size:.65rem;color:#94a3b8;margin-left:auto;">0/300</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-sticky-note field-icon field-icon-ta"></i>
                            <textarea id="observaciones" name="observaciones" rows="3" maxlength="300"
                                      class="form-control @error('observaciones') field-error @enderror"
                                      placeholder="Cualquier informacion relevante sobre el padre/tutor...">{{ old('observaciones') }}</textarea>
                        </div>
                        @error('observaciones')
                            <div class="field-msg err mt-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div style="display:flex;gap:.6rem;flex-wrap:wrap;
                        padding:1.1rem 1.7rem;background:#f5f8fc;
                        border-top:1px solid #e8edf4;border-radius:0 0 14px 14px;">
                <button type="submit" class="btn-submit flex-fill" id="btnSubmit">
                    <i class="fas fa-save"></i> Guardar Registro
                </button>
                <button type="reset" class="btn-cancel flex-fill" onclick="limpiarForm();">
                    <i class="fas fa-redo"></i> Limpiar
                </button>
                <a href="{{ route('padres.index') }}" class="btn-cancel flex-fill">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setMsg(id, tipo, texto) {
    var el = document.getElementById(id);
    if (!el) return;
    el.className = 'field-msg ' + tipo;
    el.style.display = '';
    el.innerHTML = texto;
}
function setOk(input)      { input.classList.remove('field-error'); input.classList.add('field-ok'); }
function setErr(input)     { input.classList.remove('field-ok');    input.classList.add('field-error'); }
function setNeutral(input) { input.classList.remove('field-error', 'field-ok'); }

function soloLetras(input) {
    var val    = input.value;
    var limpio = val.replace(/[^a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]/g, '');
    if (val !== limpio) input.value = limpio;
    var msgId = 'msg-' + input.id;
    if (!limpio.trim() && (input.id === 'nombre1' || input.id === 'apellido1')) {
        setErr(input);
        setMsg(msgId, 'err', '<i class="fas fa-exclamation-circle"></i> Este campo es obligatorio.');
    } else if (limpio.trim()) {
        setOk(input);
        setMsg(msgId, 'hint', '<i class="fas fa-info-circle"></i> Solo letras y espacios');
    } else {
        setNeutral(input);
        setMsg(msgId, 'hint', '<i class="fas fa-info-circle"></i> Solo letras y espacios');
    }
}

function formatearDNI(input) {
    var digits    = input.value.replace(/\D/g, '').substring(0, 13);
    var formatted = digits;
    if (digits.length > 8)      formatted = digits.substring(0,4) + '-' + digits.substring(4,8) + '-' + digits.substring(8);
    else if (digits.length > 4) formatted = digits.substring(0,4) + '-' + digits.substring(4);
    input.value = formatted;
    if (!formatted) {
        setNeutral(input);
        setMsg('msg-dni', 'hint', '<i class="fas fa-info-circle"></i> Formato: 0801-1990-12345');
    } else if (/^\d{4}-\d{4}-\d{5}$/.test(formatted)) {
        setOk(input);
        setMsg('msg-dni', 'ok', '<i class="fas fa-check-circle"></i> DNI valido');
    } else {
        setErr(input);
        setMsg('msg-dni', 'err', '<i class="fas fa-exclamation-circle"></i> Formato incompleto: 0801-1990-12345');
    }
}

function formatearTelefono(input, wrapId, msgId) {
    var digits = input.value.replace(/\D/g, '').substring(0, 8);
    input.value = digits.length > 4 ? digits.substring(0,4) + '-' + digits.substring(4) : digits;
    var wrap = document.getElementById(wrapId);
    if (!digits) {
        if (wrap) { wrap.classList.remove('field-error','field-ok'); }
        setMsg(msgId, 'hint', '<i class="fas fa-info-circle"></i> Formato: 9999-9999');
        return;
    }
    if (/^\d{4}-\d{4}$/.test(input.value)) {
        if (wrap) { wrap.classList.remove('field-error'); wrap.classList.add('field-ok'); }
        setMsg(msgId, 'ok', '<i class="fas fa-check-circle"></i> Telefono valido');
    } else {
        if (wrap) { wrap.classList.remove('field-ok'); wrap.classList.add('field-error'); }
        setMsg(msgId, 'err', '<i class="fas fa-exclamation-circle"></i> Formato incompleto: 9999-9999');
    }
}

function validarEmail(input) {
    var val = input.value.trim();
    if (!val) {
        setNeutral(input);
        setMsg('msg-correo', 'hint', '<i class="fas fa-info-circle"></i> Se usara para crear la cuenta del padre');
        return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
        setErr(input);
        setMsg('msg-correo', 'err', '<i class="fas fa-exclamation-circle"></i> El correo electronico no es valido.');
    } else {
        setOk(input);
        setMsg('msg-correo', 'ok', '<i class="fas fa-check-circle"></i> Correo valido');
    }
}

function validarFechaPadre(input) {
    if (!input.value) {
        setNeutral(input);
        setMsg('msg-fecha_nacimiento', 'hint', '<i class="fas fa-info-circle"></i> Debe tener entre 18 y 80 anos');
        return;
    }
    var edad = (new Date() - new Date(input.value)) / (1000*60*60*24*365.25);
    if (edad < 18 || edad > 80) {
        setErr(input);
        setMsg('msg-fecha_nacimiento', 'err', '<i class="fas fa-exclamation-circle"></i> El padre/tutor debe tener entre 18 y 80 anos.');
    } else {
        setOk(input);
        setMsg('msg-fecha_nacimiento', 'ok', '<i class="fas fa-check-circle"></i> Fecha valida');
    }
}

document.getElementById('fotoInput').addEventListener('change', function() {
    var file  = this.files[0];
    var msgEl = document.getElementById('msg-foto');
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
        msgEl.style.display = 'flex';
        msgEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> La foto no puede superar 2 MB.';
        this.value = '';
        return;
    }
    msgEl.style.display = 'none';
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('avatarPreview').innerHTML =
            '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;border-radius:50%">';
    };
    reader.readAsDataURL(file);
});

function limpiarForm() {
    document.getElementById('avatarPreview').innerHTML = '<i class="fas fa-user" style="color:#bfd9ea;font-size:2rem;"></i>';
    document.querySelectorAll('.field-error,.field-ok').forEach(function(el) {
        el.classList.remove('field-error','field-ok');
    });
    document.getElementById('char-obs').textContent = '0/300';
}

document.getElementById('frmPadre').addEventListener('submit', function(e) {
    var errores = [];

    var n1 = document.getElementById('nombre1');
    if (!n1.value.trim()) {
        setErr(n1);
        setMsg('msg-nombre1', 'err', '<i class="fas fa-exclamation-circle"></i> El primer nombre es obligatorio.');
        errores.push('El primer nombre es obligatorio.');
    }

    var a1 = document.getElementById('apellido1');
    if (!a1.value.trim()) {
        setErr(a1);
        setMsg('msg-apellido1', 'err', '<i class="fas fa-exclamation-circle"></i> El primer apellido es obligatorio.');
        errores.push('El primer apellido es obligatorio.');
    }

    var relacionSeleccionada = document.querySelector('input[name="relacion"]:checked');
    var msgRelacion = document.getElementById('msg-relacion');
    var grid = document.getElementById('relationGrid');
    if (!relacionSeleccionada) {
        if (msgRelacion) msgRelacion.style.display = 'flex';
        if (grid) grid.classList.add('has-error');
        errores.push('Debes seleccionar la relacion con el estudiante.');
    } else {
        if (msgRelacion) msgRelacion.style.display = 'none';
        if (grid) grid.classList.remove('has-error');
    }

    var correo = document.getElementById('correo');
    if (correo.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo.value.trim())) {
        setErr(correo);
        setMsg('msg-correo', 'err', '<i class="fas fa-exclamation-circle"></i> El correo electronico no es valido.');
        errores.push('El correo electronico no es valido.');
    }

    var tel = document.getElementById('telefono');
    if (tel.value.trim() && !/^\d{4}-\d{4}$/.test(tel.value.trim())) {
        setMsg('msg-telefono', 'err', '<i class="fas fa-exclamation-circle"></i> El telefono debe tener el formato 9999-9999.');
        errores.push('El formato del telefono no es valido.');
    }

    if (errores.length > 0) {
        e.preventDefault();
        var box = document.querySelector('.frm-alert-errors');
        if (!box) {
            box = document.createElement('div');
            box.className = 'frm-alert-errors';
            document.getElementById('frmPadre').before(box);
        }
        box.innerHTML = '<div class="frm-alert-errors-title"><i class="fas fa-exclamation-circle"></i> Por favor corrige los siguientes errores:</div><ul>' +
            errores.map(function(err){ return '<li>' + err + '</li>'; }).join('') + '</ul>';
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnSubmit').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var obsEl  = document.getElementById('observaciones');
    var charEl = document.getElementById('char-obs');
    if (obsEl && charEl) {
        obsEl.addEventListener('input', function() {
            var len = this.value.length;
            charEl.textContent = len + '/300';
            charEl.style.color = len > 270 ? '#ef4444' : '#94a3b8';
        });
        if (obsEl.value) charEl.textContent = obsEl.value.length + '/300';
    }
    ['nombre1','nombre2','apellido1','apellido2'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el && el.value) soloLetras(el);
    });
    var dniEl   = document.getElementById('dni');
    var fechaEl = document.getElementById('fecha_nacimiento');
    var telEl   = document.getElementById('telefono');
    var telAlt  = document.getElementById('telefono_alt');
    var correoEl= document.getElementById('correo');
    if (dniEl    && dniEl.value)    formatearDNI(dniEl);
    if (fechaEl  && fechaEl.value)  validarFechaPadre(fechaEl);
    if (telEl    && telEl.value)    formatearTelefono(telEl,  'wrap-telefono',     'msg-telefono');
    if (telAlt   && telAlt.value)   formatearTelefono(telAlt, 'wrap-telefono_alt', 'msg-telefono_alt');
    if (correoEl && correoEl.value) validarEmail(correoEl);
});
</script>
@endpush