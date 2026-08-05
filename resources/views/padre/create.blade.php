@extends('layouts.app')

@section('title', 'Registrar Padre / Tutor')

@push('styles')
<style>
/* ── Inputs, Selects, Textarea ── */
.field input,
.field select,
.field textarea {
    width: 100%;
    padding: 0.68rem 1rem;
    border: 2px solid #bfd9ea;
    border-radius: 10px;
    font-size: .88rem;
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
    font-size: .63rem;
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
    font-size: .75rem;
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
    font-size: .7rem;
    color: #ef4444;
    display: flex;
    align-items: center;
    gap: .3rem;
    margin-top: .2rem;
}

/* ── Texto ayuda ── */
.hint-text { font-size: .68rem; color: #6b7a90; }

/* ── Textarea ── */
.field textarea {
    resize: vertical;
    min-height: 80px;
    padding-left: 1rem;
}

/* ── Prefijo teléfono ── */
.input-prefix {
    display: flex;
    border: 2px solid #bfd9ea;
    border-radius: 10px;
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
    font-size: .78rem;
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
    border-radius: 10px;
    cursor: pointer;
    transition: border-color .2s, background .2s, transform .15s;
    text-align: center;
    font-size: .75rem;
    font-weight: 600;
    color: #6b7a90;
}
.relation-label .rl-icon {
    font-size: 1.3rem;
    color: #00508f;
    line-height: 1;
}
.relation-option:checked + .relation-label {
    border-color: #4ec7d2;
    background: rgba(78,199,210,.1);
    color: #00508f;
    transform: scale(1.03);
}
.relation-label:hover { border-color: #00508f; background: #f0f6ff; }

/* ── Alerta errores ── */
.alert-padre {
    margin-bottom: 1.2rem;
    padding: .9rem 1.1rem;
    border-radius: 10px;
    font-size: .83rem;
    display: flex;
    align-items: flex-start;
    gap: .6rem;
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

/* ── Botones ── */
.btn-primary-custom {
    flex: 1; min-width: 140px; justify-content: center;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none; border-radius: 9px;
    padding: .6rem .75rem; font-size: .83rem; font-weight: 600;
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
.btn-cancel-custom {
    flex: 1; min-width: 120px; justify-content: center;
    border: 1.5px solid #00508f; color: #00508f;
    background: white; border-radius: 9px;
    padding: .6rem .75rem; font-size: .83rem; font-weight: 600;
    transition: all .2s;
    display: inline-flex; align-items: center; gap: .45rem;
    cursor: pointer; text-decoration: none;
}
.btn-cancel-custom:hover {
    background: #eff6ff; color: #00508f;
    transform: translateY(-2px);
}
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- HEADER --}}
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
                <i class="fas fa-user-friends" style="color:white;font-size:2rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white;
                           margin:0 0 .4rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Registrar Padre / Tutor
                </h2>
                <span style="display:inline-flex;align-items:center;gap:.3rem;
                             padding:.2rem .65rem;border-radius:999px;
                             background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                             font-size:.72rem;font-weight:600;
                             border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-pen"></i> Complete los datos del responsable
                </span>
            </div>
        </div>
    </div>

    {{-- BODY --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        @if ($errors->any())
        <div style="padding:1rem 1.7rem 0;">
            <div class="alert-padre">
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

            {{-- SECCIÓN 1: DATOS PERSONALES --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="section-title">
                    <i class="fas fa-user" style="color:#4ec7d2;font-size:.88rem;"></i>
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
                            <i class="fas fa-camera"></i> Subir foto
                        </button>
                        <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none;">
                        <span class="hint-text">JPG, PNG — máx. 2 MB</span>
                    </div>

                    {{-- nombre = campo que espera el controlador --}}
                    <div class="field">
                        <label>Nombre(s) <span class="req">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                               class="{{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                               placeholder="Ej: María Elena" maxlength="50" required>
                        @error('nombre')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- apellido = campo que espera el controlador --}}
                    <div class="field">
                        <label>Apellido(s) <span class="req">*</span></label>
                        <input type="text" name="apellido" value="{{ old('apellido') }}"
                               class="{{ $errors->has('apellido') ? 'is-invalid' : '' }}"
                               placeholder="Ej: García López" maxlength="50" required>
                        @error('apellido')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- DNI --}}
                    <div class="field">
                        <label>DNI / Identidad</label>
                        <input type="text" name="dni" value="{{ old('dni') }}"
                               class="{{ $errors->has('dni') ? 'is-invalid' : '' }}"
                               placeholder="0801-1990-XXXXX" maxlength="20">
                        @error('dni')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="field">
                        <label>Estado</label>
                        <select name="estado">
                            <option value="activo"   {{ old('estado', 'activo') == 'activo'   ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                </div>
            </div>

            {{-- SECCIÓN 2: PARENTESCO --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="section-title">
                    <i class="fas fa-user-friends" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Parentesco con el Estudiante
                </div>

                <div class="relation-grid">
                    @php
                        $parentescos = [
                            ['value' => 'padre',       'label' => 'Padre',       'icon' => 'fa-male'],
                            ['value' => 'madre',       'label' => 'Madre',       'icon' => 'fa-female'],
                            ['value' => 'abuelo',      'label' => 'Abuelo/a',    'icon' => 'fa-user'],
                            ['value' => 'tio',         'label' => 'Tío/a',       'icon' => 'fa-user-tie'],
                            ['value' => 'tutor_legal', 'label' => 'Tutor Legal', 'icon' => 'fa-user-shield'],
                            ['value' => 'otro',        'label' => 'Otro',        'icon' => 'fa-user-tag'],
                        ];
                    @endphp

                    @foreach ($parentescos as $p)
                        <input type="radio" name="parentesco" id="par_{{ $p['value'] }}"
                               value="{{ $p['value'] }}" class="relation-option"
                               {{ old('parentesco') == $p['value'] ? 'checked' : '' }}
                               onchange="toggleOtro(this.value)">
                        <label for="par_{{ $p['value'] }}" class="relation-label">
                            <span class="rl-icon"><i class="fas {{ $p['icon'] }}"></i></span>
                            {{ $p['label'] }}
                        </label>
                    @endforeach
                </div>

                {{-- Campo extra si elige "otro" --}}
                <div id="campo-parentesco-otro" style="display:none;margin-top:.9rem;">
                    <div class="field">
                        <label>Especificar parentesco <span class="req">*</span></label>
                        <input type="text" name="parentesco_otro" value="{{ old('parentesco_otro') }}"
                               class="{{ $errors->has('parentesco_otro') ? 'is-invalid' : '' }}"
                               placeholder="Ej: Padrino, Madrina..." maxlength="50">
                        @error('parentesco_otro')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @error('parentesco')
                    <span class="error-msg" style="margin-top:.5rem;display:flex;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- SECCIÓN 3: CONTACTO --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="section-title">
                    <i class="fas fa-phone" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Información de Contacto
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Teléfono Principal</label>
                        <div class="input-prefix">
                            <span class="prefix-tag">+504</span>
                            <input type="tel" name="telefono" value="{{ old('telefono') }}"
                                   class="{{ $errors->has('telefono') ? 'is-invalid' : '' }}"
                                   placeholder="9999-9999" maxlength="15">
                        </div>
                        @error('telefono')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label>Teléfono Secundario</label>
                        <div class="input-prefix">
                            <span class="prefix-tag">+504</span>
                            <input type="tel" name="telefono_secundario" value="{{ old('telefono_secundario') }}"
                                   placeholder="9999-9999" maxlength="15">
                        </div>
                    </div>

                    <div class="field">
                        <label>Teléfono Trabajo</label>
                        <div class="input-prefix">
                            <span class="prefix-tag">+504</span>
                            <input type="tel" name="telefono_trabajo" value="{{ old('telefono_trabajo') }}"
                                   placeholder="9999-9999" maxlength="15">
                        </div>
                    </div>

                    <div class="field">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" value="{{ old('correo') }}"
                               class="{{ $errors->has('correo') ? 'is-invalid' : '' }}"
                               placeholder="ejemplo@correo.com" maxlength="100">
                        @error('correo')
                            <span class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 4: DIRECCIÓN Y OCUPACIÓN --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="section-title">
                    <i class="fas fa-map-marker-alt" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Dirección y Ocupación
                </div>

                <div class="grid-2">
                    <div class="field col-span-2">
                        <label>Dirección</label>
                        <textarea name="direccion" rows="2"
                                  placeholder="Barrio, colonia, calle, número de casa..."
                                  maxlength="255">{{ old('direccion') }}</textarea>
                    </div>

                    <div class="field">
                        <label>Ocupación / Profesión</label>
                        <input type="text" name="ocupacion" value="{{ old('ocupacion') }}"
                               placeholder="Ej: Docente, Comerciante..." maxlength="100">
                    </div>

                    <div class="field">
                        <label>Lugar de Trabajo</label>
                        <input type="text" name="lugar_trabajo" value="{{ old('lugar_trabajo') }}"
                               placeholder="Nombre de la empresa o institución" maxlength="100">
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 5: OBSERVACIONES --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="section-title">
                    <i class="fas fa-clipboard-list" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Observaciones
                </div>
                <div class="field">
                    <label>Notas adicionales</label>
                    <textarea name="observaciones" rows="3"
                              placeholder="Cualquier información relevante sobre el padre/tutor..."
                              maxlength="500">{{ old('observaciones') }}</textarea>
                </div>
            </div>

            {{-- BOTONES --}}
            <div style="display:flex;gap:.6rem;flex-wrap:wrap;
                        padding:1.1rem 1.7rem;
                        background:#f5f8fc;border-top:1px solid #e8edf4;
                        border-radius:0 0 14px 14px;">
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-check-circle"></i> Guardar Registro
                </button>
                <button type="reset" class="btn-cancel-custom"
                        onclick="document.getElementById('campo-parentesco-otro').style.display='none'">
                    <i class="fas fa-redo"></i> Limpiar
                </button>
                <a href="{{ route('padres.index') }}" class="btn-cancel-custom">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview foto
    document.getElementById('fotoInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('avatarPreview').innerHTML =
                `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">`;
        };
        reader.readAsDataURL(file);
    });

    // Mostrar/ocultar campo otro parentesco
    function toggleOtro(valor) {
        document.getElementById('campo-parentesco-otro').style.display =
            valor === 'otro' ? 'block' : 'none';
    }

    // Si hay old('parentesco') === 'otro', mostrar el campo al cargar
    document.addEventListener('DOMContentLoaded', function () {
        const checked = document.querySelector('input[name="parentesco"]:checked');
        if (checked && checked.value === 'otro') {
            document.getElementById('campo-parentesco-otro').style.display = 'block';
        }
    });
</script>
@endpush