@extends('layouts.app')

@section('title', 'Nuevo Administrador')
@section('page-title', 'Crear Nuevo Administrador')

@section('topbar-actions')
    <a href="{{ route('superadmin.administradores.index') }}"
       style="border:1.5px solid #e2e8f0;color:#6b7280;background:white;border-radius:8px;padding:.45rem 1rem;font-size:.88rem;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
    :root {
        --blue-dark: #003b73;
        --blue-mid:  #00508f;
        --teal:      #4ec7d2;
        --border:    #d1e0ee;
        --surface:   #f5f8fc;
        --red:       #ef4444;
        --green:     #10b981;
    }

    .frm-wrap { max-width: 820px; margin: 0 auto; }

    /* Sección */
    .frm-section {
        background: white; border: 1px solid #e2e8f0;
        border-radius: 14px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,59,115,.06);
        margin-bottom: 1.25rem;
    }
    .frm-section-header {
        background: rgba(0,80,143,.04);
        border-bottom: 2px solid var(--teal);
        padding: .85rem 1.5rem;
        display: flex; align-items: center; gap: .6rem;
    }
    .frm-section-header i   { color: var(--teal); font-size: .9rem; }
    .frm-section-header span { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--blue-dark); }
    .frm-section-body { padding: 1.5rem; }

    /* Campos */
    .frm-group { margin-bottom: 1.1rem; }
    .frm-label {
        display: block; font-size: .76rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .05em;
        color: var(--blue-dark); margin-bottom: .45rem;
    }
    .frm-label .req { color: var(--red); margin-left: .15rem; }

    .frm-input-wrap { position: relative; }
    .frm-input-wrap i.ico {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--blue-mid); font-size: .82rem; pointer-events: none;
    }
    .frm-input {
        width: 100%; padding: .6rem 1rem .6rem 2.6rem;
        border: 1.5px solid var(--border); border-radius: 9px;
        font-size: .88rem; font-family: inherit; color: #0f172a;
        background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .frm-input:focus {
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(78,199,210,.15);
        background: white;
    }
    .frm-input.is-invalid { border-color: var(--red); background: #fff5f5; }
    .frm-input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,.12); }

    /* Mostrar/ocultar contraseña */
    .frm-input-wrap .eye-btn {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #94a3b8; font-size: .85rem; padding: .2rem;
        transition: color .15s;
    }
    .frm-input-wrap .eye-btn:hover { color: var(--blue-mid); }
    .frm-input-has-eye { padding-right: 2.4rem; }

    /* Indicador fuerza contraseña */
    .pwd-strength { margin-top: .4rem; }
    .pwd-strength-bar {
        height: 4px; border-radius: 999px;
        background: #e2e8f0; overflow: hidden; margin-bottom: .3rem;
    }
    .pwd-strength-fill {
        height: 100%; border-radius: 999px;
        width: 0; transition: width .3s, background .3s;
    }
    .pwd-strength-label { font-size: .7rem; font-weight: 600; }

    /* Mensaje de error */
    .frm-error {
        display: flex; align-items: center; gap: .35rem;
        margin-top: .4rem; font-size: .76rem;
        color: var(--red); font-weight: 600;
    }
    .frm-hint {
        margin-top: .35rem; font-size: .73rem; color: #94a3b8;
        display: flex; align-items: center; gap: .3rem;
    }

    /* Radio cards */
    .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
    @media(max-width:580px){ .role-grid { grid-template-columns: 1fr; } }

    .role-card {
        border: 2px solid var(--border); border-radius: 11px;
        padding: 1rem 1.1rem; cursor: pointer;
        transition: border-color .2s, background .2s, box-shadow .2s;
        display: flex; align-items: flex-start; gap: .75rem;
        position: relative;
    }
    .role-card:has(input:checked) {
        border-color: var(--teal);
        background: rgba(78,199,210,.06);
        box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    }
    .role-card input[type="radio"] {
        margin-top: .2rem; accent-color: var(--teal);
        width: 17px; height: 17px; flex-shrink: 0; cursor: pointer;
    }
    .role-card-title { font-size: .88rem; font-weight: 700; margin-bottom: .15rem; }
    .role-card-desc  { font-size: .75rem; color: #64748b; line-height: 1.4; }

    /* Switch protegido */
    .protected-row {
        border: 1.5px solid var(--border); border-radius: 11px;
        padding: .9rem 1.1rem;
        display: flex; align-items: center; gap: .85rem;
        transition: border-color .2s, background .2s;
    }
    .protected-row:has(input:checked) {
        border-color: #f59e0b;
        background: rgba(245,158,11,.05);
    }
    .protected-row input[type="checkbox"] {
        width: 42px; height: 22px; accent-color: #f59e0b;
        flex-shrink: 0; cursor: pointer;
    }
    .protected-label { font-size: .88rem; font-weight: 600; color: #1e293b; margin-bottom: .15rem; }
    .protected-desc  { font-size: .74rem; color: #64748b; }

    /* Info box */
    .info-box {
        background: rgba(78,199,210,.07);
        border: 1px solid rgba(78,199,210,.25);
        border-radius: 10px; padding: .9rem 1.1rem;
        display: flex; gap: .7rem; align-items: flex-start;
        margin-bottom: 1.25rem;
    }
    .info-box i    { color: var(--teal); margin-top: .1rem; flex-shrink: 0; }
    .info-box p    { margin: 0; font-size: .8rem; color: #475569; line-height: 1.55; }
    .info-box strong { color: var(--blue-dark); }

    /* Botones footer */
    .frm-footer {
        display: flex; justify-content: flex-end; gap: .75rem;
        padding-top: 1.25rem; border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
    }
    .btn-cancel {
        border: 1.5px solid #e2e8f0; color: #6b7280; background: white;
        border-radius: 9px; padding: .6rem 1.4rem; font-size: .88rem;
        font-weight: 600; cursor: pointer; font-family: inherit;
        display: inline-flex; align-items: center; gap: .4rem;
        text-decoration: none; transition: all .15s;
    }
    .btn-cancel:hover { background: #f8fafc; border-color: #cbd5e1; color: #374151; }
    .btn-submit {
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: white; border: none; border-radius: 9px;
        padding: .6rem 1.6rem; font-size: .88rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        display: inline-flex; align-items: center; gap: .45rem;
        box-shadow: 0 2px 10px rgba(78,199,210,.35); transition: all .2s;
    }
    .btn-submit:hover { opacity: .9; transform: translateY(-1px); }
    .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }

    /* Alerta errores generales */
    .frm-alert-errors {
        background: #fef2f2; border: 1px solid #fca5a5;
        border-radius: 10px; padding: .9rem 1.1rem;
        margin-bottom: 1.25rem;
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
<div class="frm-wrap">

    {{-- Errores generales --}}
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

    <form action="{{ route('superadmin.administradores.store') }}" method="POST" id="frmCrear" novalidate>
        @csrf

        {{-- ── Información Personal ── --}}
        <div class="frm-section">
            <div class="frm-section-header">
                <i class="fas fa-user"></i>
                <span>Información Personal</span>
            </div>
            <div class="frm-section-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="frm-group">
                            <label class="frm-label" for="name">
                                Nombre Completo <span class="req">*</span>
                            </label>
                            <div class="frm-input-wrap">
                                <i class="fas fa-user ico"></i>
                                <input type="text" id="name" name="name"
                                       class="frm-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       value="{{ old('name') }}"
                                       placeholder="Ej: Juan Pérez"
                                       autocomplete="name"
                                       oninput="validarNombre(this)">
                            </div>
                            @error('name')
                                <div class="frm-error" id="nameError"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                            @else
                                <div class="frm-error" id="nameError" style="display:none;"></div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="frm-group">
                            <label class="frm-label" for="email">
                                Correo Electrónico <span class="req">*</span>
                            </label>
                            <div class="frm-input-wrap">
                                <i class="fas fa-envelope ico"></i>
                                <input type="email" id="email" name="email"
                                       class="frm-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       value="{{ old('email') }}"
                                       placeholder="admin@ejemplo.com"
                                       autocomplete="email">
                            </div>
                            @error('email')
                                <div class="frm-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Seguridad ── --}}
        <div class="frm-section">
            <div class="frm-section-header">
                <i class="fas fa-lock"></i>
                <span>Seguridad</span>
            </div>
            <div class="frm-section-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="frm-group">
                            <label class="frm-label" for="password">
                                Contraseña <span class="req">*</span>
                            </label>
                            <div class="frm-input-wrap">
                                <i class="fas fa-key ico"></i>
                                <input type="password" id="password" name="password"
                                       class="frm-input frm-input-has-eye {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       placeholder="Mínimo 8 caracteres"
                                       autocomplete="new-password"
                                       oninput="checkPasswordStrength(this.value)">
                                <button type="button" class="eye-btn" onclick="togglePwd('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="pwd-strength" id="pwdStrength" style="display:none;">
                                <div class="pwd-strength-bar">
                                    <div class="pwd-strength-fill" id="pwdFill"></div>
                                </div>
                                <span class="pwd-strength-label" id="pwdLabel"></span>
                            </div>
                            @error('password')
                                <div class="frm-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                            @else
                                <div class="frm-hint"><i class="fas fa-info-circle"></i>Mínimo 8 caracteres</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="frm-group">
                            <label class="frm-label" for="password_confirmation">
                                Confirmar Contraseña <span class="req">*</span>
                            </label>
                            <div class="frm-input-wrap">
                                <i class="fas fa-key ico"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="frm-input frm-input-has-eye"
                                       placeholder="Repite la contraseña"
                                       autocomplete="new-password"
                                       oninput="checkConfirm()">
                                <button type="button" class="eye-btn" onclick="togglePwd('password_confirmation', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="frm-error" id="confirmError" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden
                            </div>
                            <div class="frm-hint" id="confirmOk" style="display:none;color:#10b981;">
                                <i class="fas fa-check-circle"></i> Las contraseñas coinciden
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Rol y Permisos ── --}}
        <div class="frm-section">
            <div class="frm-section-header">
                <i class="fas fa-shield-alt"></i>
                <span>Rol y Configuración</span>
            </div>
            <div class="frm-section-body">

                <div class="frm-group">
                    <label class="frm-label">Tipo de Administrador <span class="req">*</span></label>
                    <div class="role-grid">
                        <label class="role-card">
                            <input type="radio" name="role" value="super_admin"
                                   {{ old('role') == 'super_admin' ? 'checked' : '' }}>
                            <div>
                                <div class="role-card-title" style="color:#dc2626;">
                                    <i class="fas fa-crown me-1"></i> Super Administrador
                                </div>
                                <div class="role-card-desc">Acceso total al sistema sin restricciones. Puede gestionar otros administradores.</div>
                            </div>
                        </label>
                        <label class="role-card">
                            <input type="radio" name="role" value="admin"
                                   {{ old('role', 'admin') == 'admin' ? 'checked' : '' }}>
                            <div>
                                <div class="role-card-title" style="color:var(--blue-mid);">
                                    <i class="fas fa-user-shield me-1"></i> Administrador
                                </div>
                                <div class="role-card-desc">Permisos configurables. Acceso limitado según los permisos asignados.</div>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <div class="frm-error mt-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="frm-group mb-0">
                    <label class="frm-label">Protección de Cuenta</label>
                    <label class="protected-row">
                        <input type="checkbox" name="is_protected" value="1"
                               {{ old('is_protected') ? 'checked' : '' }}>
                        <div>
                            <div class="protected-label">
                                <i class="fas fa-lock me-1" style="color:#f59e0b;"></i> Usuario Protegido
                            </div>
                            <div class="protected-desc">
                                Esta cuenta no podrá ser editada ni eliminada por otros administradores. Recomendado para cuentas críticas del sistema.
                            </div>
                        </div>
                    </label>
                </div>

            </div>
        </div>

        {{-- Info box --}}
        <div class="info-box">
            <i class="fas fa-lightbulb"></i>
            <p>
                <strong>Nota:</strong> Los permisos específicos para administradores regulares se pueden configurar después de crear la cuenta, desde la sección <strong>Permisos y Roles</strong>.
            </p>
        </div>

        {{-- Botones --}}
        <div class="frm-footer">
            <a href="{{ route('superadmin.administradores.index') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn-submit" id="btnSubmit">
                <i class="fas fa-save"></i> Crear Administrador
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
/* ── Mostrar/ocultar contraseña ── */
function togglePwd(inputId, btn) {
    var input = document.getElementById(inputId);
    var icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

/* ── Fuerza de contraseña ── */
function checkPasswordStrength(val) {
    var wrap  = document.getElementById('pwdStrength');
    var fill  = document.getElementById('pwdFill');
    var label = document.getElementById('pwdLabel');

    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';

    var score = 0;
    if (val.length >= 8)              score++;
    if (val.length >= 12)             score++;
    if (/[A-Z]/.test(val))            score++;
    if (/[0-9]/.test(val))            score++;
    if (/[^A-Za-z0-9]/.test(val))    score++;

    var levels = [
        { pct: '20%', color: '#ef4444', text: 'Muy débil' },
        { pct: '40%', color: '#f97316', text: 'Débil' },
        { pct: '60%', color: '#f59e0b', text: 'Aceptable' },
        { pct: '80%', color: '#10b981', text: 'Fuerte' },
        { pct: '100%',color: '#059669', text: 'Muy fuerte' },
    ];
    var lvl = levels[Math.min(score, 4)];
    fill.style.width      = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent     = lvl.text;
    label.style.color     = lvl.color;
}

/* ── Confirmar contraseña ── */
function checkConfirm() {
    var pwd     = document.getElementById('password').value;
    var confirm = document.getElementById('password_confirmation').value;
    var errEl   = document.getElementById('confirmError');
    var okEl    = document.getElementById('confirmOk');

    if (!confirm) { errEl.style.display='none'; okEl.style.display='none'; return; }

    if (pwd === confirm) {
        errEl.style.display = 'none';
        okEl.style.display  = 'flex';
    } else {
        errEl.style.display = 'flex';
        okEl.style.display  = 'none';
    }
}

/* ── Validar nombre (solo letras y espacios) ── */
function validarNombre(input) {
    var val    = input.value;
    var limpio = val.replace(/[^a-záéíóúüñA-ZÁÉÍÓÚÜÑ\s]/g, '');
    if (val !== limpio) input.value = limpio;

    var errEl = document.getElementById('nameError');
    if (!errEl) return;
    if (!limpio.trim()) {
        errEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> El nombre es obligatorio.';
        errEl.style.display = 'flex';
        input.classList.add('is-invalid');
    } else {
        errEl.style.display = 'none';
        input.classList.remove('is-invalid');
    }
}

/* ── Validación antes de enviar ── */
document.getElementById('frmCrear').addEventListener('submit', function(e) {
    var name  = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var pwd   = document.getElementById('password').value;
    var conf  = document.getElementById('password_confirmation').value;
    var role  = document.querySelector('input[name="role"]:checked');

    var errors = [];
    if (!name)                       errors.push('El nombre completo es obligatorio.');
    if (name && /[^a-záéíóúüñA-ZÁÉÍÓÚÜÑ\s]/g.test(name)) errors.push('El nombre solo puede contener letras.');
    if (!email)                      errors.push('El correo electrónico es obligatorio.');
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('El correo electrónico no es válido.');
    if (!pwd)                        errors.push('La contraseña es obligatoria.');
    if (pwd && pwd.length < 8)       errors.push('La contraseña debe tener al menos 8 caracteres.');
    if (pwd !== conf)                errors.push('Las contraseñas no coinciden.');
    if (!role)                       errors.push('Debes seleccionar un tipo de administrador.');

    if (errors.length > 0) {
        e.preventDefault();
        // Mostrar errores en el bloque superior
        var box = document.querySelector('.frm-alert-errors');
        if (!box) {
            box = document.createElement('div');
            box.className = 'frm-alert-errors';
            document.getElementById('frmCrear').prepend(box);
        }
        box.innerHTML = '<div class="frm-alert-errors-title"><i class="fas fa-exclamation-circle"></i> Por favor corrige los siguientes errores:</div><ul>' +
            errors.map(function(e){ return '<li>' + e + '</li>'; }).join('') + '</ul>';
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnSubmit').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    }
});
</script>
@endpush