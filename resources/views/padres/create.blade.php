@extends('layouts.app')

@section('title', 'Registrar Padre / Tutor')

@section('content')

<style>
    :root {
        --azul-oscuro:  #0f2d4a;
        --azul-medio:   #1a4b72;
        --azul-claro:   #2074a8;
        --teal:         #1a9b8a;
        --teal-claro:   #22c9b0;
        --teal-suave:   #e6f9f7;
        --gris-fondo:   #f4f7fb;
        --gris-borde:   #d0dce8;
        --texto-dark:   #1a2a3a;
        --texto-medio:  #4a6278;
        --blanco:       #ffffff;
        --error:        #e05252;
    }

    .page-wrapper {
        min-height: 100vh;
        background: var(--gris-fondo);
        padding: 2rem 1rem;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    /* ── Encabezado ── */
    .page-header {
        max-width: 860px;
        margin: 0 auto 1.75rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-header .icon-box {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, var(--azul-medio), var(--teal));
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 14px rgba(26,75,114,.25);
        flex-shrink: 0;
    }

    .page-header .icon-box svg { color: #fff; width: 26px; height: 26px; }

    .page-header h1 {
        font-size: 1.55rem;
        font-weight: 700;
        color: var(--azul-oscuro);
        margin: 0;
        line-height: 1.2;
    }

    .page-header p {
        margin: .2rem 0 0;
        color: var(--texto-medio);
        font-size: .88rem;
    }

    /* ── Tarjeta principal ── */
    .form-card {
        max-width: 860px;
        margin: 0 auto;
        background: var(--blanco);
        border-radius: 18px;
        box-shadow: 0 6px 30px rgba(15,45,74,.10);
        overflow: hidden;
    }

    /* ── Secciones ── */
    .form-section {
        padding: 1.6rem 2rem;
        border-bottom: 1px solid var(--gris-borde);
    }

    .form-section:last-of-type { border-bottom: none; }

    .section-title {
        display: flex;
        align-items: center;
        gap: .55rem;
        font-size: .82rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--azul-claro);
        margin: 0 0 1.2rem;
    }

    .section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, var(--gris-borde), transparent);
    }

    /* ── Grid ── */
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; }
    .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.1rem; }
    .col-span-2 { grid-column: span 2; }
    .col-span-3 { grid-column: span 3; }

    @media (max-width: 680px) {
        .grid-2, .grid-3 { grid-template-columns: 1fr; }
        .col-span-2, .col-span-3 { grid-column: span 1; }
        .form-section { padding: 1.2rem 1rem; }
    }

    /* ── Campos ── */
    .field { display: flex; flex-direction: column; gap: .35rem; }

    .field label {
        font-size: .8rem;
        font-weight: 600;
        color: var(--texto-dark);
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .field label .req { color: var(--teal); font-size: .95em; }

    .field input,
    .field select,
    .field textarea {
        width: 100%;
        padding: .62rem .85rem;
        border: 1.5px solid var(--gris-borde);
        border-radius: 9px;
        font-size: .9rem;
        color: var(--texto-dark);
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
        font-family: inherit;
    }

    .field input:focus,
    .field select:focus,
    .field textarea:focus {
        outline: none;
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(26,155,138,.12);
    }

    .field input.is-invalid,
    .field select.is-invalid,
    .field textarea.is-invalid {
        border-color: var(--error);
        box-shadow: 0 0 0 3px rgba(224,82,82,.10);
    }

    .field textarea { resize: vertical; min-height: 80px; }

    .field .error-msg {
        font-size: .76rem;
        color: var(--error);
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    /* ── Prefijo teléfono ── */
    .input-prefix {
        display: flex;
        border: 1.5px solid var(--gris-borde);
        border-radius: 9px;
        overflow: hidden;
        transition: border-color .2s, box-shadow .2s;
    }

    .input-prefix:focus-within {
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(26,155,138,.12);
    }

    .prefix-tag {
        background: var(--teal-suave);
        color: var(--teal);
        font-weight: 700;
        font-size: .85rem;
        padding: 0 .75rem;
        display: flex; align-items: center;
        border-right: 1.5px solid var(--gris-borde);
        white-space: nowrap;
    }

    .input-prefix input {
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        flex: 1;
    }

    /* ── Badge relación ── */
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
        border: 1.5px solid var(--gris-borde);
        border-radius: 10px;
        cursor: pointer;
        transition: border-color .2s, background .2s, transform .15s;
        text-align: center;
        font-size: .78rem;
        font-weight: 600;
        color: var(--texto-medio);
    }

    .relation-label .rl-icon {
        font-size: 1.5rem;
        line-height: 1;
    }

    .relation-option:checked + .relation-label {
        border-color: var(--teal);
        background: var(--teal-suave);
        color: var(--teal);
        transform: scale(1.03);
    }

    .relation-label:hover {
        border-color: var(--azul-claro);
        background: #f0f6ff;
    }

    /* ── Footer del form ── */
    .form-footer {
        padding: 1.4rem 2rem;
        background: var(--gris-fondo);
        border-top: 1px solid var(--gris-borde);
        display: flex;
        justify-content: flex-end;
        gap: .85rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: .65rem 1.5rem;
        border-radius: 9px;
        font-size: .9rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        transition: transform .15s, box-shadow .2s, opacity .2s;
        text-decoration: none;
    }

    .btn:active { transform: scale(.97); }

    .btn-cancel {
        background: #fff;
        color: var(--texto-medio);
        border: 1.5px solid var(--gris-borde);
    }

    .btn-cancel:hover { background: var(--gris-fondo); border-color: #b0c4d8; }

    .btn-primary {
        background: linear-gradient(135deg, var(--azul-medio) 0%, var(--teal) 100%);
        color: #fff;
        box-shadow: 0 4px 14px rgba(26,75,114,.22);
    }

    .btn-primary:hover {
        box-shadow: 0 6px 20px rgba(26,75,114,.32);
        opacity: .95;
    }

    /* ── Alerta éxito / error global ── */
    .alert {
        max-width: 860px;
        margin: 0 auto 1.2rem;
        padding: .9rem 1.1rem;
        border-radius: 10px;
        font-size: .87rem;
        display: flex;
        align-items: flex-start;
        gap: .6rem;
    }

    .alert-danger {
        background: #fff0f0;
        border: 1px solid #f5c0c0;
        color: #b83232;
    }

    /* ── Foto avatar preview ── */
    .foto-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .75rem;
    }

    .avatar-preview {
        width: 90px; height: 90px;
        border-radius: 50%;
        border: 3px solid var(--gris-borde);
        object-fit: cover;
        background: var(--gris-fondo);
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }

    .avatar-preview svg { color: #b0c4d8; width: 42px; height: 42px; }

    .btn-upload {
        font-size: .78rem;
        font-weight: 600;
        color: var(--azul-claro);
        background: none;
        border: 1.5px dashed var(--gris-borde);
        border-radius: 8px;
        padding: .4rem .9rem;
        cursor: pointer;
        transition: border-color .2s, background .2s;
    }

    .btn-upload:hover { border-color: var(--teal); background: var(--teal-suave); }
</style>

<div class="page-wrapper">

    {{-- Encabezado --}}
    <div class="page-header">
        <div class="icon-box">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
            </svg>
        </div>
        <div>
            <h1>Registrar Padre / Tutor</h1>
            <p>Complete los datos del responsable del estudiante</p>
        </div>
    </div>

    {{-- Alerta de errores de validación --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="flex-shrink:0;margin-top:1px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
        </svg>
        <div>
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul style="margin:.3rem 0 0 1rem;padding:0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- Formulario --}}
    <div class="form-card">
        <form action="{{ route('padres.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 1. Datos personales --}}
            <div class="form-section">
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
                    </svg>
                    Datos Personales
                </div>

                <div class="grid-3" style="align-items:start">

                    {{-- Foto (ocupa columna 1, fila 1-2) --}}
                    <div class="foto-wrap" style="grid-row:span 2">
                        <div class="avatar-preview" id="avatarPreview">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </div>
                        <button type="button" class="btn-upload" onclick="document.getElementById('fotoInput').click()">
                            📷 Subir foto
                        </button>
                        <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none">
                        <span style="font-size:.72rem;color:var(--texto-medio)">JPG, PNG — máx. 2 MB</span>
                    </div>

                    {{-- Primer nombre --}}
                    <div class="field">
                        <label>Primer Nombre <span class="req">*</span></label>
                        <input type="text" name="nombre1" value="{{ old('nombre1') }}"
                               class="{{ $errors->has('nombre1') ? 'is-invalid' : '' }}"
                               placeholder="Ej: María" maxlength="50" required>
                        @error('nombre1') <span class="error-msg">⚠ {{ $message }}</span> @enderror
                    </div>

                    {{-- Segundo nombre --}}
                    <div class="field">
                        <label>Segundo Nombre</label>
                        <input type="text" name="nombre2" value="{{ old('nombre2') }}"
                               placeholder="Opcional" maxlength="50">
                    </div>

                    {{-- Primer apellido --}}
                    <div class="field">
                        <label>Primer Apellido <span class="req">*</span></label>
                        <input type="text" name="apellido1" value="{{ old('apellido1') }}"
                               class="{{ $errors->has('apellido1') ? 'is-invalid' : '' }}"
                               placeholder="Ej: García" maxlength="50" required>
                        @error('apellido1') <span class="error-msg">⚠ {{ $message }}</span> @enderror
                    </div>

                    {{-- Segundo apellido --}}
                    <div class="field">
                        <label>Segundo Apellido</label>
                        <input type="text" name="apellido2" value="{{ old('apellido2') }}"
                               placeholder="Opcional" maxlength="50">
                    </div>

                </div>

                {{-- Fila 2 --}}
                <div class="grid-3" style="margin-top:1.1rem">
                    <div class="field">
                        <label>DNI / Identidad <span class="req">*</span></label>
                        <input type="text" name="dni" value="{{ old('dni') }}"
                               class="{{ $errors->has('dni') ? 'is-invalid' : '' }}"
                               placeholder="0801-1990-XXXXX" maxlength="20" required>
                        @error('dni') <span class="error-msg">⚠ {{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label>Fecha de Nacimiento <span class="req">*</span></label>
                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                               class="{{ $errors->has('fecha_nacimiento') ? 'is-invalid' : '' }}" required>
                        @error('fecha_nacimiento') <span class="error-msg">⚠ {{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label>Género <span class="req">*</span></label>
                        <select name="genero" class="{{ $errors->has('genero') ? 'is-invalid' : '' }}" required>
                            <option value="">— Seleccionar —</option>
                            <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                            <option value="O" {{ old('genero') == 'O' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('genero') <span class="error-msg">⚠ {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- 2. Tipo de relación --}}
            <div class="form-section">
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                    </svg>
                    Relación con el Estudiante
                </div>

                <div class="relation-grid">
                    @php
                        $relaciones = [
                            ['value' => 'padre',   'label' => 'Padre',    'icon' => '👨'],
                            ['value' => 'madre',   'label' => 'Madre',    'icon' => '👩'],
                            ['value' => 'abuelo',  'label' => 'Abuelo/a', 'icon' => '👴'],
                            ['value' => 'hermano', 'label' => 'Hermano/a','icon' => '🧑'],
                            ['value' => 'tio',     'label' => 'Tío/a',    'icon' => '🧔'],
                            ['value' => 'tutor',   'label' => 'Tutor/a',  'icon' => '🛡️'],
                        ];
                    @endphp

                    @foreach ($relaciones as $rel)
                        <input type="radio" name="relacion" id="rel_{{ $rel['value'] }}"
                               value="{{ $rel['value'] }}" class="relation-option"
                               {{ old('relacion') == $rel['value'] ? 'checked' : '' }}>
                        <label for="rel_{{ $rel['value'] }}" class="relation-label">
                            <span class="rl-icon">{{ $rel['icon'] }}</span>
                            {{ $rel['label'] }}
                        </label>
                    @endforeach
                </div>
                @error('relacion')
                    <span class="error-msg" style="margin-top:.5rem;display:flex">⚠ {{ $message }}</span>
                @enderror
            </div>

            {{-- 3. Contacto --}}
            <div class="form-section">
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                    </svg>
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
                        @error('telefono') <span class="error-msg">⚠ {{ $message }}</span> @enderror
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
                        @error('correo') <span class="error-msg">⚠ {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- 4. Dirección y trabajo --}}
            <div class="form-section">
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                    </svg>
                    Dirección y Ocupación
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Departamento</label>
                        <select name="departamento" id="selectDepto">
                            <option value="">— Seleccionar —</option>
                            <option value="El Paraíso" {{ old('departamento') == 'El Paraíso' ? 'selected' : '' }}>El Paraíso</option>
                            <option value="Francisco Morazán" {{ old('departamento') == 'Francisco Morazán' ? 'selected' : '' }}>Francisco Morazán</option>
                            <option value="Choluteca" {{ old('departamento') == 'Choluteca' ? 'selected' : '' }}>Choluteca</option>
                            <option value="Olancho" {{ old('departamento') == 'Olancho' ? 'selected' : '' }}>Olancho</option>
                            <option value="Valle" {{ old('departamento') == 'Valle' ? 'selected' : '' }}>Valle</option>
                            <option value="Otro" {{ old('departamento') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Municipio / Ciudad</label>
                        <input type="text" name="municipio" value="{{ old('municipio') }}"
                               placeholder="Ej: Danlí" maxlength="80">
                    </div>

                    <div class="field col-span-2">
                        <label>Dirección Exacta</label>
                        <textarea name="direccion" placeholder="Barrio, colonia, calle, número de casa..." maxlength="255">{{ old('direccion') }}</textarea>
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
            </div>

            {{-- 5. Observaciones --}}
            <div class="form-section" style="border-bottom:none">
                <div class="section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                    </svg>
                    Observaciones
                </div>

                <div class="field">
                    <label>Notas adicionales</label>
                    <textarea name="observaciones" rows="3"
                              placeholder="Cualquier información relevante sobre el padre/tutor...">{{ old('observaciones') }}</textarea>
                </div>
            </div>

            {{-- Footer botones --}}
            <div class="form-footer">
                <a href="{{ route('padres.index') }}" class="btn btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3"/>
                    </svg>
                    Cancelar
                </a>
                <button type="reset" class="btn btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                    Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    Guardar Registro
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    // Preview de foto
    document.getElementById('fotoInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatarPreview');
            preview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">`;
        };
        reader.readAsDataURL(file);
    });
</script>

@endsection