@extends('layouts.app')

@section('title', 'Registrar Padre / Tutor')

@section('topbar-actions')
    <a href="{{ route('padres.index') }}"
       style="background:white; color:#00508f;
              padding:.6rem .75rem;
              border-radius:9px;
              text-decoration:none; font-weight:600; display:inline-flex; align-items:center;
              gap:0.4rem; transition:all 0.2s ease; border:1.5px solid #00508f;
              font-size:.83rem;">          {{-- ← TEXTO botón volver --}}
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */

/* ── Inputs, Selects, Textarea ── */
.field input,
.field select,
.field textarea {
    width: 100%;
    padding: 0.68rem 1rem;                /* ← ALTO de inputs: cambia 0.68rem */
    border: 2px solid #bfd9ea;
    border-radius: 10px;                  /* ← REDONDEZ inputs */
    font-size: .88rem;                    /* ← TEXTO dentro de inputs */
    color: #0d2137;
    background: #fff;
    transition: border-color .2s, box-shadow .2s;
    box-sizing: border-box;
    font-family: inherit;
    height: auto;
}

.field input:focus,
.field select:focus,
.field textarea:focus {
    outline: none;
    border-color: #4ec7d2;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.15);
}

.field input.is-invalid,
.field select.is-invalid,
.field textarea.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 0.15rem rgba(239,68,68,.1);
}

/* ── Labels ── */
.field label {
    font-size: .63rem;                    /* ← TAMAÑO labels */
    font-weight: 700;
    color: #003b73;
    text-transform: uppercase;
    letter-spacing: .08em;
    display: flex;
    align-items: center;
    gap: .3rem;
    margin-bottom: .22rem;
}

.field label .req { color: #4ec7d2; font-size: .95em; }

/* ── Títulos de sección ── */
.section-title {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .75rem;                    /* ← TAMAÑO títulos de sección */
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #00508f;
    margin: 0 0 1.2rem;
}

.section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, rgba(78,199,210,.2), transparent);
}

/* ── Mensajes de error ── */
.error-msg {
    font-size: .7rem;                     /* ← TAMAÑO mensajes error */
    color: #ef4444;
    display: flex;
    align-items: center;
    gap: .3rem;
    margin-top: .2rem;
}

/* ── Texto ayuda pequeño ── */
.hint-text {
    font-size: .68rem;                    /* ← TAMAÑO texto ayuda */
    color: #6b7a90;
}

/* ── Textarea ── */
.field textarea {
    resize: vertical;
    min-height: 80px;                     /* ← ALTO textarea */
    padding-left: 1rem;
}

/* ── Prefijo teléfono ── */
.input-prefix {
    display: flex;
    border: 2px solid #bfd9ea;
    border-radius: 10px;                  /* ← REDONDEZ input prefijo */
    overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
}

.input-prefix:focus-within {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.15);
}

.prefix-tag {
    background: rgba(78,199,210,.1);
    color: #00508f;
    font-weight: 700;
    font-size: .78rem;                    /* ← TEXTO prefijo +504 */
    padding: 0 .75rem;
    display: flex; align-items: center;
    border-right: 2px solid #bfd9ea;
    white-space: nowrap;
}

.input-prefix input {
    border: none !important;
    box-shadow: none !important;
    border-radius: 0 !important;
    flex: 1;
}

/* ── Relación (radio cards) ── */
.relation-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .65rem;
}

@media (max-width: 500px) { .relation-grid { grid-template-columns: 1fr 1fr; } }

.relation-option { display: none; }

.relation-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .4rem;
    padding: .75rem .5rem;
    border: 2px solid #bfd9ea;
    border-radius: 10px;                  /* ← REDONDEZ cards relación */
    cursor: pointer;
    transition: border-color .2s, background .2s, transform .15s;
    text-align: center;
    font-size: .75rem;                    /* ← TEXTO cards relación */
    font-weight: 600;
    color: #6b7a90;
}

.relation-label .rl-icon {
    font-size: 1.5rem;                    /* ← TAMAÑO emoji relación */
    line-height: 1;
}

.relation-option:checked + .relation-label {
    border-color: #4ec7d2;
    background: rgba(78,199,210,.1);
    color: #00508f;
    transform: scale(1.03);
}

.relation-label:hover {
    border-color: #00508f;
    background: #f0f6ff;
}

/* ── Avatar preview ── */
.foto-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .75rem;
}

.avatar-preview {
    width: 90px; height: 90px;           /* ← TAMAÑO avatar */
    border-radius: 50%;
    border: 3px solid #bfd9ea;
    object-fit: cover;
    background: #f5f8fc;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}

.avatar-preview svg { color: #bfd9ea; width: 42px; height: 42px; }

.btn-upload {
    font-size: .72rem;                    /* ← TEXTO botón subir foto */
    font-weight: 600;
    color: #00508f;
    background: none;
    border: 1.5px dashed #bfd9ea;
    border-radius: 8px;
    padding: .4rem .9rem;
    cursor: pointer;
    transition: border-color .2s, background .2s;
}

.btn-upload:hover { border-color: #4ec7d2; background: rgba(78,199,210,.1); }

/* ── Alerta errores ── */
.alert {
    margin-bottom: 1.2rem;
    padding: .9rem 1.1rem;
    border-radius: 10px;
    font-size: .83rem;                    /* ← TEXTO alerta errores */
    display: flex;
    align-items: flex-start;
    gap: .6rem;
}

.alert-danger {
    background: #fff0f0;
    border: 1px solid #f5c0c0;
    color: #b83232;
}

/* ── Grid layout ── */
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; }
.grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.1rem; }
.col-span-2 { grid-column: span 2; }
.col-span-3 { grid-column: span 3; }
.field { display: flex; flex-direction: column; gap: .35rem; }

@media (max-width: 680px) {
    .grid-2, .grid-3 { grid-template-columns: 1fr; }
    .col-span-2, .col-span-3 { grid-column: span 1; }
}

/* ── Botón Guardar ── */
.btn-primary-custom {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white;
    border: none;
    border-radius: 9px;                   /* ← REDONDEZ botón guardar */
    padding: .6rem .75rem;               /* ← TAMAÑO botón guardar */
    font-size: .83rem;                    /* ← TEXTO botón guardar */
    font-weight: 600;
    box-shadow: 0 2px 10px rgba(78,199,210,.3);
    transition: all .2s;
    display: inline-flex; align-items: center; gap: .45rem;
    cursor: pointer;
}

.btn-primary-custom:hover {
    color: white;
    box-shadow: 0 4px 16px rgba(78,199,210,.4);
    transform: translateY(-2px);
}

/* ── Botón Cancelar / Limpiar ── */
.btn-cancel-custom {
    border: 1.5px solid #00508f;          /* ← GROSOR borde botones secundarios */
    color: #00508f;
    background: white;
    border-radius: 9px;                   /* ← REDONDEZ botones secundarios */
    padding: .6rem .75rem;               /* ← TAMAÑO botones secundarios */
    font-size: .83rem;                    /* ← TEXTO botones secundarios */
    font-weight: 600;
    transition: all .2s;
    display: inline-flex; align-items: center; gap: .45rem;
    cursor: pointer;
    text-decoration: none;
}

.btn-cancel-custom:hover {
    background: #eff6ff;
    color: #00508f;
    transform: translateY(-2px);
}
</style>
@endpush

@section('content')
<div style="width:100%;">  {{-- ← sin container, ocupa todo el ancho --}}

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem; position:relative; overflow:hidden;">

        {{-- burbujas decorativas --}}
        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px; height:80px;             {{-- ← TAMAÑO ícono header --}}
                        border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex; align-items:center; justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-user-friends" style="color:white; font-size:2rem;"></i> {{-- ← ÍCONO interno --}}
            </div>
            <div>
                <h2 style="font-size:1.45rem; font-weight:800; color:white; {{-- ← TÍTULO header --}}
                           margin:0 0 .4rem; text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Registrar Padre / Tutor
                </h2>
                <span style="display:inline-flex; align-items:center; gap:.3rem;
                             padding:.2rem .65rem; border-radius:999px;
                             background:rgba(255,255,255,.14); color:rgba(255,255,255,.92);
                             font-size:.72rem; font-weight:600; {{-- ← TEXTO tag subtítulo --}}
                             border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-pen"></i> Complete los datos del responsable
                </span>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white; border:1px solid #e8edf4; border-top:none;
                border-radius:0 0 14px 14px; box-shadow:0 2px 16px rgba(0,59,115,.09);">

        {{-- Alerta errores --}}
        @if ($errors->any())
        <div style="padding:1rem 1.7rem 0;">
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle" style="flex-shrink:0;margin-top:2px;"></i>
                <div>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul style="margin:.3rem 0 0 1rem;padding:0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('padres.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ══════════════════════════════════════
                 SECCIÓN 1 · DATOS PERSONALES
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div class="section-title">
                    <i class="fas fa-user" style="color:#4ec7d2; font-size:.88rem;"></i>
                    Datos Personales
                </div>

                <div class="grid-3" style="align-items:start;">

                    {{-- Foto --}}
                    <div class="foto-wrap" style="grid-row:span 2;">
                        <div class="avatar-preview" id="avatarPreview">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </div>
                        <button type="button" class="btn-upload"
                                onclick="document.getElementById('fotoInput').click()">
                            📷 Subir foto
                        </button>
                        <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none;">
                        <span class="hint-text">JPG, PNG — máx. 2 MB</span>
                    </div>

                    {{-- Primer Nombre --}}
                    <div class="field">
                        <label>Primer Nombre <span class="req">*</span></label>
                        <input type="text" name="nombre1" value="{{ old('nombre1') }}"
                               class="{{ $errors->has('nombre1') ? 'is-invalid' : '' }}"
                               placeholder="Ej: María" maxlength="50" required>
                        @error('nombre1')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Segundo Nombre --}}
                    <div class="field">
                        <label>Segundo Nombre
                            <span style="color:#6b7a90; font-weight:400; text-transform:none; font-size:.72rem;">(Opcional)</span>
                        </label>
                        <input type="text" name="nombre2" value="{{ old('nombre2') }}"
                               placeholder="Opcional" maxlength="50">
                    </div>

                    {{-- Primer Apellido --}}
                    <div class="field">
                        <label>Primer Apellido <span class="req">*</span></label>
                        <input type="text" name="apellido1" value="{{ old('apellido1') }}"
                               class="{{ $errors->has('apellido1') ? 'is-invalid' : '' }}"
                               placeholder="Ej: García" maxlength="50" required>
                        @error('apellido1')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Segundo Apellido --}}
                    <div class="field">
                        <label>Segundo Apellido
                            <span style="color:#6b7a90; font-weight:400; text-transform:none; font-size:.72rem;">(Opcional)</span>
                        </label>
                        <input type="text" name="apellido2" value="{{ old('apellido2') }}"
                               placeholder="Opcional" maxlength="50">
                    </div>

                </div>

                {{-- Fila 2 --}}
                <div class="grid-3" style="margin-top:1.1rem;">

                    <div class="field">
                        <label>DNI / Identidad <span class="req">*</span></label>
                        <input type="text" name="dni" value="{{ old('dni') }}"
                               class="{{ $errors->has('dni') ? 'is-invalid' : '' }}"
                               placeholder="0801-1990-XXXXX" maxlength="20" required>
                        @error('dni')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label>Fecha de Nacimiento <span class="req">*</span></label>
                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                               class="{{ $errors->has('fecha_nacimiento') ? 'is-invalid' : '' }}" required>
                        @error('fecha_nacimiento')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label>Género <span class="req">*</span></label>
                        <select name="genero"
                                class="{{ $errors->has('genero') ? 'is-invalid' : '' }}" required>
                            <option value="">— Seleccionar —</option>
                            <option value="M" {{ old('genero')=='M'?'selected':'' }}>Masculino</option>
                            <option value="F" {{ old('genero')=='F'?'selected':'' }}>Femenino</option>
                            <option value="O" {{ old('genero')=='O'?'selected':'' }}>Otro</option>
                        </select>
                        @error('genero')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>{{-- fin sección Personal --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 2 · RELACIÓN CON EL ESTUDIANTE
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div class="section-title">
                    <i class="fas fa-user-friends" style="color:#4ec7d2; font-size:.88rem;"></i>
                    Relación con el Estudiante
                </div>

                <div class="relation-grid">
                    @php
                        $relaciones = [
                            ['value'=>'padre',   'label'=>'Padre',    'icon'=>'👨'],
                            ['value'=>'madre',   'label'=>'Madre',    'icon'=>'👩'],
                            ['value'=>'abuelo',  'label'=>'Abuelo/a', 'icon'=>'👴'],
                            ['value'=>'hermano', 'label'=>'Hermano/a','icon'=>'🧑'],
                            ['value'=>'tio',     'label'=>'Tío/a',    'icon'=>'🧔'],
                            ['value'=>'tutor',   'label'=>'Tutor/a',  'icon'=>'🛡️'],
                        ];
                    @endphp

                    @foreach ($relaciones as $rel)
                        <input type="radio" name="relacion" id="rel_{{ $rel['value'] }}"
                               value="{{ $rel['value'] }}" class="relation-option"
                               {{ old('relacion')==$rel['value'] ? 'checked' : '' }}>
                        <label for="rel_{{ $rel['value'] }}" class="relation-label">
                            <span class="rl-icon">{{ $rel['icon'] }}</span>
                            {{ $rel['label'] }}
                        </label>
                    @endforeach
                </div>

                @error('relacion')
                    <span class="error-msg" style="margin-top:.5rem;">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </span>
                @enderror
            </div>{{-- fin sección Relación --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 3 · INFORMACIÓN DE CONTACTO
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div class="section-title">
                    <i class="fas fa-phone" style="color:#4ec7d2; font-size:.88rem;"></i>
                    Información de Contacto
                </div>

                <div class="grid-2">

                    <div class="field">
                        <label>Teléfono Principal <span class="req">*</span></label>
                        <div class="input-prefix">
                            <span class="prefix-tag">🇭🇳 +504</span>
                            <input type="tel" name="telefono" value="{{ old('telefono') }}"
                                   class="{{ $errors->has('telefono') ? 'is-invalid' : '' }}"
                                   placeholder="9999-9999" maxlength="15" required>
                        </div>
                        @error('telefono')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label>Teléfono Alternativo</label>
                        <div class="input-prefix">
                            <span class="prefix-tag">🇭🇳 +504</span>
                            <input type="tel" name="telefono_alt" value="{{ old('telefono_alt') }}"
                                   placeholder="9999-9999" maxlength="15">
                        </div>
                    </div>

                    <div class="field col-span-2">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" value="{{ old('correo') }}"
                               class="{{ $errors->has('correo') ? 'is-invalid' : '' }}"
                               placeholder="ejemplo@correo.com" maxlength="100">
                        @error('correo')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>{{-- fin sección Contacto --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 4 · DIRECCIÓN Y OCUPACIÓN
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div class="section-title">
                    <i class="fas fa-map-marker-alt" style="color:#4ec7d2; font-size:.88rem;"></i>
                    Dirección y Ocupación
                </div>

                <div class="grid-2">

                    <div class="field">
                        <label>Departamento</label>
                        <select name="departamento" id="selectDepto">
                            <option value="">— Seleccionar —</option>
                            <option value="El Paraíso"        {{ old('departamento')=='El Paraíso'       ?'selected':'' }}>El Paraíso</option>
                            <option value="Francisco Morazán" {{ old('departamento')=='Francisco Morazán'?'selected':'' }}>Francisco Morazán</option>
                            <option value="Choluteca"         {{ old('departamento')=='Choluteca'        ?'selected':'' }}>Choluteca</option>
                            <option value="Olancho"           {{ old('departamento')=='Olancho'          ?'selected':'' }}>Olancho</option>
                            <option value="Valle"             {{ old('departamento')=='Valle'            ?'selected':'' }}>Valle</option>
                            <option value="Otro"              {{ old('departamento')=='Otro'             ?'selected':'' }}>Otro</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Municipio / Ciudad</label>
                        <input type="text" name="municipio" value="{{ old('municipio') }}"
                               placeholder="Ej: Danlí" maxlength="80">
                    </div>

                    <div class="field col-span-2">
                        <label>Dirección Exacta</label>
                        <textarea name="direccion"
                                  placeholder="Barrio, colonia, calle, número de casa..."
                                  maxlength="255">{{ old('direccion') }}</textarea>
                    </div>

                    <div class="field">
                        <label>Ocupación / Profesión</label>
                        <input type="text" name="ocupacion" value="{{ old('ocupacion') }}"
                               placeholder="Ej: Docente, Comerciante..." maxlength="80">
                    </div>

                    <div class="field">
                        <label>Lugar de Trabajo</label>
                        <input type="text" name="lugar_trabajo" value="{{ old('lugar_trabajo') }}"
                               placeholder="Nombre de la empresa o institución" maxlength="100">
                    </div>

                </div>
            </div>{{-- fin sección Dirección --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 5 · OBSERVACIONES
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div class="section-title">
                    <i class="fas fa-clipboard-list" style="color:#4ec7d2; font-size:.88rem;"></i>
                    Observaciones
                </div>

                <div class="field">
                    <label>Notas adicionales</label>
                    <textarea name="observaciones" rows="3"
                              placeholder="Cualquier información relevante sobre el padre/tutor...">{{ old('observaciones') }}</textarea>
                </div>

            </div>{{-- fin sección Observaciones --}}

            {{-- ══════════════════════════════════════
                 BOTONES — igual que pf-footer del perfil
            ══════════════════════════════════════ --}}
            <div style="display:flex; gap:.6rem; flex-wrap:wrap;
                        padding:1.1rem 1.7rem;
                        background:#f5f8fc; border-top:1px solid #e8edf4;
                        border-radius:0 0 14px 14px;">

                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-check-circle"></i> Guardar Registro
                </button>

                <button type="reset" class="btn-cancel-custom">
                    <i class="fas fa-redo"></i> Limpiar
                </button>

                <a href="{{ route('padres.index') }}" class="btn-cancel-custom">
                    <i class="fas fa-times"></i> Cancelar
                </a>

            </div>

        </form>
    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}
@endsection

@push('scripts')
<script>
    document.getElementById('fotoInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatarPreview');
            preview.innerHTML = `<img src="${e.target.result}"
                style="width:100%;height:100%;object-fit:cover;border-radius:50%">`;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
