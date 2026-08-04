@extends('layouts.app')

@section('title', 'Nuevo Profesor')
@section('page-title', 'Registrar Nuevo Profesor')

@section('topbar-actions')
    <a href="{{ route('profesores.index') }}"
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
}
.form-control:focus, .form-select:focus {
    border-color: var(--c-teal) !important;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.18) !important;
    outline: none;
}
.form-control.field-error, .form-select.field-error,
.form-control.is-invalid,  .form-select.is-invalid {
    border-color: var(--c-red) !important;
    background: rgba(239,68,68,.03) !important;
}
.form-control.field-ok, .form-select.field-ok {
    border-color: var(--c-green) !important;
    background: rgba(16,185,129,.03) !important;
}

.field-wrap { position: relative; }
.field-icon {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--c-primary); font-size: .68rem; z-index: 5; pointer-events: none;
}

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
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>
        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px;height:80px;border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-chalkboard-teacher" style="color:white;font-size:2rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white;margin:0 0 .4rem;">
                    Registro de Profesor
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

    {{-- Body --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        {{-- Errores del servidor --}}
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

        <form action="{{ route('profesores.store') }}" method="POST" id="frmProfesor" novalidate>
            @csrf

            {{-- ══ SECCIÓN 1: INFORMACIÓN PERSONAL ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-user"></i> Información Personal</div>

                <div class="row g-3">

                    {{-- Nombre --}}
                    <div class="col-md-6">
                        <label class="form-label" for="nombre">
                            Nombre <span class="lbl-required">*</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text" id="nombre" name="nombre"
                                   class="form-control {{ $errors->has('nombre') ? 'field-error' : '' }}"
                                   value="{{ old('nombre') }}"
                                   placeholder="Ej: Juan Carlos"
                                   oninput="soloLetras(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('nombre') ? 'err' : 'hint' }}" id="msg-nombre">
                            @error('nombre')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> Solo letras y espacios
                            @enderror
                        </div>
                    </div>

                    {{-- Apellido --}}
                    <div class="col-md-6">
                        <label class="form-label" for="apellido">
                            Apellido <span class="lbl-required">*</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text" id="apellido" name="apellido"
                                   class="form-control {{ $errors->has('apellido') ? 'field-error' : '' }}"
                                   value="{{ old('apellido') }}"
                                   placeholder="Ej: Pérez García"
                                   oninput="soloLetras(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('apellido') ? 'err' : 'hint' }}" id="msg-apellido">
                            @error('apellido')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> Solo letras y espacios
                            @enderror
                        </div>
                    </div>

                    {{-- DNI --}}
                    <div class="col-md-6">
                        <label class="form-label" for="dni">
                            DNI <span class="lbl-required">*</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-id-card field-icon"></i>
                            <input type="text" id="dni" name="dni"
                                   class="form-control {{ $errors->has('dni') ? 'field-error' : '' }}"
                                   value="{{ old('dni') }}"
                                   placeholder="0703-1995-12345"
                                   maxlength="15"
                                   oninput="formatearDNI(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('dni') ? 'err' : 'hint' }}" id="msg-dni">
                            @error('dni')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> Formato: 0703-1995-12345
                            @enderror
                        </div>
                    </div>

                    {{-- Fecha de Nacimiento --}}
                    <div class="col-md-6">
                        <label class="form-label" for="fecha_nacimiento">
                            Fecha de Nacimiento <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-calendar field-icon"></i>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                                   class="form-control {{ $errors->has('fecha_nacimiento') ? 'field-error' : '' }}"
                                   value="{{ old('fecha_nacimiento') }}"
                                   onchange="validarFechaProfesor(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('fecha_nacimiento') ? 'err' : 'hint' }}" id="msg-fecha_nacimiento">
                            @error('fecha_nacimiento')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> El profesor debe tener entre 18 y 70 años
                            @enderror
                        </div>
                    </div>

                    {{-- Género --}}
                    <div class="col-md-6">
                        <label class="form-label" for="genero">
                            Género <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-venus-mars field-icon" style="z-index:10;"></i>
                            <select id="genero" name="genero"
                                    class="form-select {{ $errors->has('genero') ? 'field-error' : '' }}">
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('genero')=='masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino"  {{ old('genero')=='femenino'  ? 'selected' : '' }}>Femenino</option>
                                <option value="otro"      {{ old('genero')=='otro'      ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                        <div class="field-msg {{ $errors->has('genero') ? 'err' : '' }}" id="msg-genero">
                            @error('genero')<i class="fas fa-exclamation-circle"></i> {{ $message }}@enderror
                        </div>
                    </div>

                    {{-- Teléfono --}}
                    <div class="col-md-6">
                        <label class="form-label" for="telefono">
                            Teléfono <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-phone field-icon"></i>
                            <input type="text" id="telefono" name="telefono"
                                   class="form-control {{ $errors->has('telefono') ? 'field-error' : '' }}"
                                   value="{{ old('telefono') }}"
                                   placeholder="9999-9999" maxlength="9"
                                   oninput="formatearTelefono(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('telefono') ? 'err' : 'hint' }}" id="msg-telefono">
                            @error('telefono')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> Formato: 9999-9999
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- ══ SECCIÓN 2: INFORMACIÓN DE CONTACTO ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-envelope"></i> Información de Contacto</div>

                <div class="row g-3">

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label" for="email">
                            Correo Electrónico <span class="lbl-required">*</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-envelope field-icon"></i>
                            <input type="email" id="email" name="email"
                                   class="form-control {{ $errors->has('email') ? 'field-error' : '' }}"
                                   value="{{ old('email') }}"
                                   placeholder="profesor@ejemplo.com"
                                   oninput="validarEmail(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('email') ? 'err' : 'hint' }}" id="msg-email">
                            @error('email')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> Ingresa un correo válido
                            @enderror
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div class="col-md-6">
                        <label class="form-label" for="direccion">
                            Dirección <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-map-marker-alt field-icon"></i>
                            <input type="text" id="direccion" name="direccion"
                                   class="form-control {{ $errors->has('direccion') ? 'field-error' : '' }}"
                                   value="{{ old('direccion') }}"
                                   placeholder="Ej: Barrio El Centro, Calle Principal">
                        </div>
                        <div class="field-msg hint" id="msg-direccion"></div>
                    </div>

                </div>
            </div>

            {{-- ══ SECCIÓN 3: INFORMACIÓN ACADÉMICA ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-graduation-cap"></i> Información Académica</div>

                <div class="row g-3">

                    {{-- Especialidad --}}
                    <div class="col-md-6">
                        <label class="form-label" for="especialidad">
                            Especialidad <span class="lbl-required">*</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-book field-icon"></i>
                            <input type="text" id="especialidad" name="especialidad"
                                   class="form-control {{ $errors->has('especialidad') ? 'field-error' : '' }}"
                                   value="{{ old('especialidad') }}"
                                   placeholder="Ej: Matemáticas, Español, Ciencias"
                                   oninput="validarEspecialidad(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('especialidad') ? 'err' : 'hint' }}" id="msg-especialidad">
                            @error('especialidad')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> Materia o área de enseñanza
                            @enderror
                        </div>
                    </div>

                    {{-- Nivel Académico --}}
                    <div class="col-md-6">
                        <label class="form-label" for="nivel_academico">
                            Nivel Académico <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-certificate field-icon" style="z-index:10;"></i>
                            <select id="nivel_academico" name="nivel_academico"
                                    class="form-select {{ $errors->has('nivel_academico') ? 'field-error' : '' }}">
                                <option value="">Seleccionar...</option>
                                <option value="bachillerato" {{ old('nivel_academico')=='bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                                <option value="licenciatura" {{ old('nivel_academico')=='licenciatura' ? 'selected' : '' }}>Licenciatura</option>
                                <option value="maestria"     {{ old('nivel_academico')=='maestria'     ? 'selected' : '' }}>Maestría</option>
                                <option value="doctorado"    {{ old('nivel_academico')=='doctorado'    ? 'selected' : '' }}>Doctorado</option>
                            </select>
                        </div>
                        <div class="field-msg {{ $errors->has('nivel_academico') ? 'err' : '' }}" id="msg-nivel_academico">
                            @error('nivel_academico')<i class="fas fa-exclamation-circle"></i> {{ $message }}@enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- ══ SECCIÓN 4: INFORMACIÓN LABORAL ══ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">
                <div class="sec-title"><i class="fas fa-briefcase"></i> Información Laboral</div>

                <div class="row g-3">

                    {{-- Fecha de Contratación --}}
                    <div class="col-md-6">
                        <label class="form-label" for="fecha_contratacion">
                            Fecha de Contratación <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-calendar-check field-icon"></i>
                            <input type="date" id="fecha_contratacion" name="fecha_contratacion"
                                   class="form-control {{ $errors->has('fecha_contratacion') ? 'field-error' : '' }}"
                                   value="{{ old('fecha_contratacion') }}"
                                   onchange="validarFechaContratacion(this);">
                        </div>
                        <div class="field-msg {{ $errors->has('fecha_contratacion') ? 'err' : 'hint' }}" id="msg-fecha_contratacion">
                            @error('fecha_contratacion')
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            @else
                                <i class="fas fa-info-circle"></i> No puede ser una fecha futura
                            @enderror
                        </div>
                    </div>

                    {{-- Tipo de Contrato --}}
                    <div class="col-md-6">
                        <label class="form-label" for="tipo_contrato">
                            Tipo de Contrato <span class="lbl-optional">(Opcional)</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-file-contract field-icon" style="z-index:10;"></i>
                            <select id="tipo_contrato" name="tipo_contrato"
                                    class="form-select {{ $errors->has('tipo_contrato') ? 'field-error' : '' }}">
                                <option value="">Seleccionar...</option>
                                <option value="tiempo_completo" {{ old('tipo_contrato')=='tiempo_completo' ? 'selected' : '' }}>Tiempo Completo</option>
                                <option value="medio_tiempo"    {{ old('tipo_contrato')=='medio_tiempo'    ? 'selected' : '' }}>Medio Tiempo</option>
                                <option value="por_horas"       {{ old('tipo_contrato')=='por_horas'       ? 'selected' : '' }}>Por Horas</option>
                            </select>
                        </div>
                        <div class="field-msg {{ $errors->has('tipo_contrato') ? 'err' : '' }}" id="msg-tipo_contrato">
                            @error('tipo_contrato')<i class="fas fa-exclamation-circle"></i> {{ $message }}@enderror
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6">
                        <label class="form-label" for="estado">
                            Estado <span class="lbl-required">*</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-toggle-on field-icon" style="z-index:10;"></i>
                            <select id="estado" name="estado"
                                    class="form-select {{ $errors->has('estado') ? 'field-error' : '' }}"
                                    onchange="validarSelectField(this, 'msg-estado', 'El estado');">
                                <option value="">Seleccionar...</option>
                                <option value="activo"   {{ old('estado','activo')=='activo'   ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado')=='inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="licencia" {{ old('estado')=='licencia' ? 'selected' : '' }}>En Licencia</option>
                            </select>
                        </div>
                        <div class="field-msg {{ $errors->has('estado') ? 'err' : '' }}" id="msg-estado">
                            @error('estado')<i class="fas fa-exclamation-circle"></i> {{ $message }}@enderror
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-12">
                        <label class="form-label" for="observaciones">
                            Observaciones <span class="lbl-optional">(Opcional)</span>
                            <span id="char-obs" style="font-size:.65rem;color:#94a3b8;margin-left:auto;">0/300</span>
                        </label>
                        <div class="field-wrap">
                            <i class="fas fa-sticky-note field-icon" style="top:14px;transform:none;"></i>
                            <textarea id="observaciones" name="observaciones"
                                      rows="3" maxlength="300"
                                      class="form-control {{ $errors->has('observaciones') ? 'field-error' : '' }}"
                                      style="padding-left:2.6rem!important;resize:none;min-height:80px;"
                                      placeholder="Notas adicionales sobre el profesor...">{{ old('observaciones') }}</textarea>
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
                    <i class="fas fa-save"></i> Guardar Profesor
                </button>
                <a href="{{ route('profesores.index') }}" class="btn-cancel flex-fill">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
/* ═══════════════════════════════════════════════
   UTILIDADES
═══════════════════════════════════════════════ */
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

/* ═══════════════════════════════════════════════
   SOLO LETRAS — bloquea números y caracteres especiales
═══════════════════════════════════════════════ */
function soloLetras(input) {
    var val    = input.value;
    var limpio = val.replace(/[^a-záéíóúüñA-ZÁÉÍÓÚÜÑ\s]/g, '');
    if (val !== limpio) input.value = limpio;

    var msgId = 'msg-' + input.id;
    if (!limpio.trim()) {
        setErr(input);
        setMsg(msgId, 'err', '<i class="fas fa-exclamation-circle"></i> Este campo es obligatorio.');
    } else {
        setOk(input);
        setMsg(msgId, 'hint', '<i class="fas fa-info-circle"></i> Solo letras y espacios');
    }
}

/* ═══════════════════════════════════════════════
   DNI — formatea automáticamente 0703-1995-12345
═══════════════════════════════════════════════ */
function formatearDNI(input) {
    var digits    = input.value.replace(/\D/g, '').substring(0, 13);
    var formatted = digits;
    if (digits.length > 8)      formatted = digits.substring(0,4) + '-' + digits.substring(4,8) + '-' + digits.substring(8);
    else if (digits.length > 4) formatted = digits.substring(0,4) + '-' + digits.substring(4);
    input.value = formatted;

    if (!formatted) {
        setErr(input);
        setMsg('msg-dni', 'err', '<i class="fas fa-exclamation-circle"></i> El DNI es obligatorio.');
    } else if (/^\d{4}-\d{4}-\d{5}$/.test(formatted)) {
        setOk(input);
        setMsg('msg-dni', 'ok', '<i class="fas fa-check-circle"></i> DNI válido');
    } else {
        setErr(input);
        setMsg('msg-dni', 'err', '<i class="fas fa-exclamation-circle"></i> Formato incompleto — debe ser 0703-1995-12345');
    }
}

/* ═══════════════════════════════════════════════
   TELÉFONO — formatea automáticamente 9999-9999
═══════════════════════════════════════════════ */
function formatearTelefono(input) {
    var digits = input.value.replace(/\D/g, '').substring(0, 8);
    input.value = digits.length > 4 ? digits.substring(0,4) + '-' + digits.substring(4) : digits;

    if (!digits) {
        setNeutral(input);
        setMsg('msg-telefono', 'hint', '<i class="fas fa-info-circle"></i> Formato: 9999-9999');
        return;
    }
    if (/^\d{4}-\d{4}$/.test(input.value)) {
        setOk(input);
        setMsg('msg-telefono', 'ok', '<i class="fas fa-check-circle"></i> Teléfono válido');
    } else {
        setErr(input);
        setMsg('msg-telefono', 'err', '<i class="fas fa-exclamation-circle"></i> Formato incompleto — debe ser 9999-9999');
    }
}

/* ═══════════════════════════════════════════════
   EMAIL
═══════════════════════════════════════════════ */
function validarEmail(input) {
    var val = input.value.trim();
    if (!val) {
        setErr(input);
        setMsg('msg-email', 'err', '<i class="fas fa-exclamation-circle"></i> El correo electrónico es obligatorio.');
        return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
        setErr(input);
        setMsg('msg-email', 'err', '<i class="fas fa-exclamation-circle"></i> Ingresa un correo electrónico válido.');
    } else {
        setOk(input);
        setMsg('msg-email', 'ok', '<i class="fas fa-check-circle"></i> Correo válido');
    }
}

/* ═══════════════════════════════════════════════
   ESPECIALIDAD
═══════════════════════════════════════════════ */
function validarEspecialidad(input) {
    var val = input.value.trim();
    if (!val) {
        setErr(input);
        setMsg('msg-especialidad', 'err', '<i class="fas fa-exclamation-circle"></i> La especialidad es obligatoria.');
    } else if (val.length < 3) {
        setErr(input);
        setMsg('msg-especialidad', 'err', '<i class="fas fa-exclamation-circle"></i> La especialidad debe tener al menos 3 caracteres.');
    } else {
        setOk(input);
        setMsg('msg-especialidad', 'ok', '<i class="fas fa-check-circle"></i> Especialidad válida');
    }
}

/* ═══════════════════════════════════════════════
   FECHA DE NACIMIENTO — entre 18 y 70 años
═══════════════════════════════════════════════ */
function validarFechaProfesor(input) {
    if (!input.value) {
        setNeutral(input);
        setMsg('msg-fecha_nacimiento', 'hint', '<i class="fas fa-info-circle"></i> El profesor debe tener entre 18 y 70 años');
        return;
    }
    var edad = (new Date() - new Date(input.value)) / (1000*60*60*24*365.25);
    if (edad < 18 || edad > 70) {
        setErr(input);
        setMsg('msg-fecha_nacimiento', 'err', '<i class="fas fa-exclamation-circle"></i> El profesor debe tener entre 18 y 70 años.');
    } else {
        setOk(input);
        setMsg('msg-fecha_nacimiento', 'ok', '<i class="fas fa-check-circle"></i> Fecha válida');
    }
}

/* ═══════════════════════════════════════════════
   FECHA DE CONTRATACIÓN — no puede ser futura
═══════════════════════════════════════════════ */
function validarFechaContratacion(input) {
    if (!input.value) {
        setNeutral(input);
        setMsg('msg-fecha_contratacion', 'hint', '<i class="fas fa-info-circle"></i> No puede ser una fecha futura');
        return;
    }
    var hoy      = new Date(); hoy.setHours(0,0,0,0);
    var seleccion = new Date(input.value);
    if (seleccion > hoy) {
        setErr(input);
        setMsg('msg-fecha_contratacion', 'err', '<i class="fas fa-exclamation-circle"></i> La fecha de contratación no puede ser futura.');
    } else {
        setOk(input);
        setMsg('msg-fecha_contratacion', 'ok', '<i class="fas fa-check-circle"></i> Fecha válida');
    }
}

/* ═══════════════════════════════════════════════
   SELECTS
═══════════════════════════════════════════════ */
function validarSelectField(input, msgId, label) {
    if (!input.value) {
        setErr(input);
        setMsg(msgId, 'err', '<i class="fas fa-exclamation-circle"></i> ' + label + ' es obligatorio.');
    } else {
        setOk(input);
        setMsg(msgId, 'ok', '<i class="fas fa-check-circle"></i> Seleccionado');
    }
}

/* ═══════════════════════════════════════════════
   VALIDACIÓN AL ENVIAR
═══════════════════════════════════════════════ */
document.getElementById('frmProfesor').addEventListener('submit', function(e) {
    var errores = [];

    // Nombre
    var nombre = document.getElementById('nombre');
    if (!nombre.value.trim()) {
        setErr(nombre);
        setMsg('msg-nombre', 'err', '<i class="fas fa-exclamation-circle"></i> El nombre es obligatorio.');
        errores.push('El nombre es obligatorio.');
    } else if (/[^a-záéíóúüñA-ZÁÉÍÓÚÜÑ\s]/g.test(nombre.value)) {
        errores.push('El nombre solo puede contener letras y espacios.');
    }

    // Apellido
    var apellido = document.getElementById('apellido');
    if (!apellido.value.trim()) {
        setErr(apellido);
        setMsg('msg-apellido', 'err', '<i class="fas fa-exclamation-circle"></i> El apellido es obligatorio.');
        errores.push('El apellido es obligatorio.');
    } else if (/[^a-záéíóúüñA-ZÁÉÍÓÚÜÑ\s]/g.test(apellido.value)) {
        errores.push('El apellido solo puede contener letras y espacios.');
    }

    // DNI
    var dni = document.getElementById('dni');
    if (!dni.value.trim()) {
        setErr(dni);
        setMsg('msg-dni', 'err', '<i class="fas fa-exclamation-circle"></i> El DNI es obligatorio.');
        errores.push('El DNI es obligatorio.');
    } else if (!/^\d{4}-\d{4}-\d{5}$/.test(dni.value.trim())) {
        setErr(dni);
        setMsg('msg-dni', 'err', '<i class="fas fa-exclamation-circle"></i> El DNI debe tener el formato 0703-1995-12345.');
        errores.push('El formato del DNI no es válido.');
    }

    // Email
    var email = document.getElementById('email');
    if (!email.value.trim()) {
        setErr(email);
        setMsg('msg-email', 'err', '<i class="fas fa-exclamation-circle"></i> El correo electrónico es obligatorio.');
        errores.push('El correo electrónico es obligatorio.');
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
        setErr(email);
        setMsg('msg-email', 'err', '<i class="fas fa-exclamation-circle"></i> Ingresa un correo electrónico válido.');
        errores.push('El correo electrónico no es válido.');
    }

    // Especialidad
    var especialidad = document.getElementById('especialidad');
    if (!especialidad.value.trim()) {
        setErr(especialidad);
        setMsg('msg-especialidad', 'err', '<i class="fas fa-exclamation-circle"></i> La especialidad es obligatoria.');
        errores.push('La especialidad es obligatoria.');
    } else if (especialidad.value.trim().length < 3) {
        setErr(especialidad);
        setMsg('msg-especialidad', 'err', '<i class="fas fa-exclamation-circle"></i> La especialidad debe tener al menos 3 caracteres.');
        errores.push('La especialidad debe tener al menos 3 caracteres.');
    }

    // Estado
    var estado = document.getElementById('estado');
    if (!estado.value) {
        setErr(estado);
        setMsg('msg-estado', 'err', '<i class="fas fa-exclamation-circle"></i> El estado es obligatorio.');
        errores.push('El estado es obligatorio.');
    }

    // Teléfono (si fue llenado)
    var tel = document.getElementById('telefono');
    if (tel.value.trim() && !/^\d{4}-\d{4}$/.test(tel.value.trim())) {
        setErr(tel);
        setMsg('msg-telefono', 'err', '<i class="fas fa-exclamation-circle"></i> El teléfono debe tener el formato 9999-9999.');
        errores.push('El formato del teléfono no es válido.');
    }

    // Fecha de nacimiento (si fue llenada)
    var fechaN = document.getElementById('fecha_nacimiento');
    if (fechaN.value) {
        var edad = (new Date() - new Date(fechaN.value)) / (1000*60*60*24*365.25);
        if (edad < 18 || edad > 70) {
            setErr(fechaN);
            setMsg('msg-fecha_nacimiento', 'err', '<i class="fas fa-exclamation-circle"></i> El profesor debe tener entre 18 y 70 años.');
            errores.push('La edad del profesor debe estar entre 18 y 70 años.');
        }
    }

    // Fecha de contratación (si fue llenada)
    var fechaC = document.getElementById('fecha_contratacion');
    if (fechaC.value) {
        var hoy = new Date(); hoy.setHours(0,0,0,0);
        if (new Date(fechaC.value) > hoy) {
            setErr(fechaC);
            setMsg('msg-fecha_contratacion', 'err', '<i class="fas fa-exclamation-circle"></i> La fecha de contratación no puede ser futura.');
            errores.push('La fecha de contratación no puede ser futura.');
        }
    }

    if (errores.length > 0) {
        e.preventDefault();
        var box = document.querySelector('.frm-alert-errors');
        if (!box) {
            box = document.createElement('div');
            box.className = 'frm-alert-errors';
            document.getElementById('frmProfesor').before(box);
        }
        box.innerHTML = '<div class="frm-alert-errors-title"><i class="fas fa-exclamation-circle"></i> Por favor corrige los siguientes errores:</div><ul>' +
            errores.map(function(err){ return '<li>' + err + '</li>'; }).join('') + '</ul>';
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnSubmit').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    }
});

/* ═══════════════════════════════════════════════
   CONTADOR OBSERVACIONES + INICIALIZAR old()
═══════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
    // Contador observaciones
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

    // Inicializar campos con old()
    var nombre    = document.getElementById('nombre');
    var apellido  = document.getElementById('apellido');
    var dniEl     = document.getElementById('dni');
    var telEl     = document.getElementById('telefono');
    var emailEl   = document.getElementById('email');
    var espEl     = document.getElementById('especialidad');
    var fechaN    = document.getElementById('fecha_nacimiento');
    var fechaC    = document.getElementById('fecha_contratacion');

    if (nombre   && nombre.value)   soloLetras(nombre);
    if (apellido && apellido.value) soloLetras(apellido);
    if (dniEl    && dniEl.value)    formatearDNI(dniEl);
    if (telEl    && telEl.value)    formatearTelefono(telEl);
    if (emailEl  && emailEl.value)  validarEmail(emailEl);
    if (espEl    && espEl.value)    validarEspecialidad(espEl);
    if (fechaN   && fechaN.value)   validarFechaProfesor(fechaN);
    if (fechaC   && fechaC.value)   validarFechaContratacion(fechaC);
});
</script>
@endpush