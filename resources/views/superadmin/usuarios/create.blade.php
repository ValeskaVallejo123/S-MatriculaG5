@extends('layouts.app')

@section('title', 'Nuevo Usuario')
@section('page-title', 'Nuevo Usuario')

@section('topbar-actions')
    <a href="{{ route('superadmin.usuarios.index') }}" class="create-topbar-btn-ghost">
        <i class="fas fa-arrow-left"></i>
        <span class="create-btn-text">Volver</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botón topbar ── */
    .create-topbar-btn-ghost {
        display: inline-flex; align-items: center; gap: .45rem;
        background: transparent; color: white;
        padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        border: 1.5px solid rgba(255,255,255,.35); white-space: nowrap;
        transition: background .2s;
    }
    .create-topbar-btn-ghost:hover { background: rgba(255,255,255,.12); color: white; }
    @media(max-width:600px) {
        .create-btn-text { display: none; }
        .create-topbar-btn-ghost { padding: .5rem .65rem; }
    }

    /* ── Variables ── */
    :root {
        --blue-dark:   #003b73;
        --blue-mid:    #00508f;
        --teal:        #4ec7d2;
        --teal-light:  rgba(78,199,210,0.12);
        --border:      #e8edf4;
        --surface:     #f5f8fc;
        --text-main:   #0d2137;
        --text-muted:  #6b7a90;
        --green:       #10b981;
        --red:         #ef4444;
        --radius-lg:   14px;
        --shadow-sm:   0 1px 4px rgba(0,59,115,0.07);
        --shadow-md:   0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Layout ── */
    .create-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 1.25rem;
        align-items: start;
    }
    @media(max-width:900px) { .create-layout { grid-template-columns: 1fr; } }

    /* ── Card base ── */
    .create-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .create-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .create-card-head i    { color: var(--teal); font-size: 1rem; }
    .create-card-head span { color: white; font-weight: 700; font-size: .95rem; }
    .create-card-body { padding: 1.5rem 1.4rem; }

    /* ── Avatar preview ── */
    .create-avatar {
        width: 72px; height: 72px; border-radius: 16px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #fff; font-size: 1.6rem;
        border: 3px solid rgba(78,199,210,.35);
        flex-shrink: 0; transition: background .3s;
    }

    /* ── Secciones ── */
    .form-section { margin-bottom: 1.75rem; }
    .form-section:last-child { margin-bottom: 0; }
    .form-section-title {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--teal);
        margin-bottom: 1rem; padding-bottom: .45rem;
        border-bottom: 1.5px solid var(--teal-light);
        display: flex; align-items: center; gap: .4rem;
    }

    /* ── Campos ── */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    @media(max-width:600px) { .form-row { grid-template-columns: 1fr; } }

    .form-group { display: flex; flex-direction: column; }

    .form-label {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: var(--blue-dark);
        margin-bottom: .4rem; display: flex; align-items: center; gap: .3rem;
    }
    .form-label .req { color: var(--red); font-size: .8rem; font-style: normal; }

    .form-control {
        width: 100%; padding: .55rem .9rem;
        border: 2px solid #bfd9ea; border-radius: 8px;
        font-size: .88rem; font-family: inherit;
        color: var(--text-main); outline: none; background: white;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus {
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    }
    .form-control.is-invalid {
        border-color: var(--red);
        box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }
    select.form-control { cursor: pointer; }

    .form-hint  { font-size: .72rem; color: var(--text-muted); margin-top: .35rem; display: flex; align-items: center; gap: .25rem; }
    .form-error { font-size: .72rem; color: var(--red);          margin-top: .35rem; display: flex; align-items: center; gap: .25rem; }

    /* ── Toggle activo ── */
    .toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: .85rem 1rem; border-radius: 10px;
        background: var(--surface); border: 1px solid var(--border); gap: 1rem;
    }
    .toggle-label { font-size: .85rem; font-weight: 600; color: var(--blue-dark); }

    .switch { position: relative; display: inline-block; width: 44px; height: 24px; flex-shrink: 0; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider {
        position: absolute; cursor: pointer; inset: 0;
        background: #cbd5e1; border-radius: 999px; transition: .3s;
    }
    .slider::before {
        content: ''; position: absolute;
        width: 18px; height: 18px; border-radius: 50%;
        left: 3px; bottom: 3px; background: white;
        transition: .3s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    input:checked + .slider { background: var(--green); }
    input:checked + .slider::before { transform: translateX(20px); }

    /* ── Botones ── */
    .form-actions {
        display: flex; align-items: center; gap: .75rem;
        flex-wrap: wrap;
    }
    .btn-save {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .6rem 1.4rem; border-radius: 8px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: white; border: none; font-size: .87rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        box-shadow: 0 2px 8px rgba(0,80,143,.2);
        transition: opacity .2s, transform .15s;
    }
    .btn-save:hover { opacity: .88; transform: translateY(-1px); }
    .btn-save:active { transform: translateY(0); }

    .btn-cancel {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .6rem 1.1rem; border-radius: 8px;
        background: white; color: var(--text-muted);
        border: 1.5px solid var(--border);
        font-size: .87rem; font-weight: 600;
        text-decoration: none; transition: all .2s;
    }
    .btn-cancel:hover { border-color: #94a3b8; color: var(--text-main); }

    /* ── Password strength ── */
    .pwd-bar { height: 4px; border-radius: 2px; background: var(--border); margin-top: .5rem; overflow: hidden; }
    .pwd-bar-fill { height: 100%; border-radius: 2px; width: 0; transition: width .3s, background .3s; }

    /* ── Card lateral ── */
    .create-side { position: sticky; top: 1rem; }

    .tip-item {
        display: flex; align-items: flex-start; gap: .75rem;
        padding: .85rem 0; border-bottom: 1px solid var(--border);
    }
    .tip-item:last-child { border-bottom: none; padding-bottom: 0; }
    .tip-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--teal-light); color: var(--blue-mid);
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem; flex-shrink: 0;
    }
    .tip-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--text-muted); margin-bottom: .15rem; }
    .tip-val { font-size: .82rem; color: var(--text-main); line-height: 1.45; }

    /* Roles preview */
    .role-pills { display: flex; flex-wrap: wrap; gap: .35rem; margin-top: .5rem; }
    .role-pill {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .18rem .55rem; border-radius: 999px;
        font-size: .68rem; font-weight: 600;
    }
</style>
@endpush

@section('content')
<div>
    <div class="create-layout">

        {{-- ── COLUMNA PRINCIPAL ── --}}
        <div>
            <form action="{{ route('superadmin.usuarios.store') }}"
                  method="POST" id="create-form">
                @csrf

                {{-- ── Card: Datos personales ── --}}
                <div class="create-card" style="margin-bottom:1.25rem;">
                    <div class="create-card-head">
                        <i class="fas fa-user-plus"></i>
                        <span>Datos del nuevo usuario</span>
                    </div>
                    <div class="create-card-body">

                        {{-- Preview de avatar ── --}}
                        <div style="display:flex;align-items:center;gap:1rem;
                                    margin-bottom:1.5rem;padding-bottom:1.25rem;
                                    border-bottom:1px solid var(--border);">
                            <div class="create-avatar" id="avatar-preview">
                                <i class="fas fa-user" style="font-size:1.4rem;opacity:.6;"></i>
                            </div>
                            <div>
                                <div style="font-size:.95rem;font-weight:700;color:var(--blue-dark);"
                                     id="name-preview">Nombre del usuario</div>
                                <div style="font-size:.78rem;color:var(--text-muted);margin-top:.2rem;">
                                    El avatar se generará automáticamente con las iniciales
                                </div>
                            </div>
                        </div>

                        {{-- Nombre y email ── --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-id-card"></i> Información personal
                            </div>
                            <div class="form-row" style="margin-bottom:1rem;">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user" style="font-size:.75rem;"></i>
                                        Nombre completo <em class="req">*</em>
                                    </label>
                                    <input type="text" name="name" id="input-name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           placeholder="Ej. María García López"
                                           required autofocus>
                                    @error('name')
                                        <span class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-envelope" style="font-size:.75rem;"></i>
                                        Correo electrónico <em class="req">*</em>
                                    </label>
                                    <input type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="correo@ejemplo.com"
                                           required>
                                    @error('email')
                                        <span class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Rol y estado ── --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-shield-alt"></i> Rol y acceso
                            </div>
                            <div class="form-row" style="margin-bottom:0;">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user-tag" style="font-size:.75rem;"></i>
                                        Rol del usuario <em class="req">*</em>
                                    </label>
                                    <select name="rol_id"
                                            class="form-control @error('rol_id') is-invalid @enderror"
                                            required>
                                        <option value="">— Seleccionar rol —</option>
                                        @foreach(\App\Models\Rol::orderBy('nombre')->get() as $rol)
                                            <option value="{{ $rol->id }}"
                                                {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
                                                {{ $rol->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rol_id')
                                        <span class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-toggle-on" style="font-size:.75rem;"></i>
                                        Estado inicial
                                    </label>
                                    <div class="toggle-row" style="height:42px;">
                                        <div>
                                            <div class="toggle-label" id="toggle-label">Cuenta activa</div>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox" name="activo" value="1"
                                                   id="toggle-activo" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="activo" value="0">
                                    <span class="form-hint">
                                        <i class="fas fa-info-circle"></i>
                                        Desactiva si quieres que el usuario no pueda ingresar aún
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── Card: Contraseña ── --}}
                <div class="create-card" style="margin-bottom:1.25rem;">
                    <div class="create-card-head">
                        <i class="fas fa-lock"></i>
                        <span>Contraseña de acceso</span>
                    </div>
                    <div class="create-card-body">

                        <div style="display:flex;align-items:flex-start;gap:.65rem;
                                    padding:.75rem 1rem;border-radius:9px;
                                    background:rgba(78,199,210,.07);border:1px solid #b2e8ed;
                                    margin-bottom:1.25rem;">
                            <i class="fas fa-info-circle" style="color:var(--teal);flex-shrink:0;margin-top:2px;"></i>
                            <span style="font-size:.8rem;color:#003b73;">
                                La contraseña debe tener al menos <strong>8 caracteres</strong>.
                                Se recomienda combinar letras mayúsculas, números y símbolos.
                            </span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-key" style="font-size:.75rem;"></i>
                                    Contraseña <em class="req">*</em>
                                </label>
                                <div style="position:relative;">
                                    <input type="password" name="password" id="input-password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Mínimo 8 caracteres"
                                           autocomplete="new-password" required
                                           style="padding-right:2.5rem;">
                                    <button type="button" id="toggle-pwd"
                                            style="position:absolute;right:.7rem;top:50%;transform:translateY(-50%);
                                                   background:none;border:none;cursor:pointer;
                                                   color:var(--text-muted);font-size:.85rem;padding:0;">
                                        <i class="fas fa-eye" id="pwd-eye"></i>
                                    </button>
                                </div>
                                <div class="pwd-bar"><div class="pwd-bar-fill" id="pwd-strength"></div></div>
                                <span class="form-hint" id="pwd-hint" style="display:none;">
                                    <i class="fas fa-circle" style="font-size:.4rem;"></i>
                                    <span id="pwd-hint-text"></span>
                                </span>
                                @error('password')
                                    <span class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-key" style="font-size:.75rem;"></i>
                                    Confirmar contraseña <em class="req">*</em>
                                </label>
                                <div style="position:relative;">
                                    <input type="password" name="password_confirmation"
                                           id="input-pwd-confirm"
                                           class="form-control"
                                           placeholder="Repetir contraseña"
                                           autocomplete="new-password" required
                                           style="padding-right:2.5rem;">
                                    <button type="button" id="toggle-pwd-confirm"
                                            style="position:absolute;right:.7rem;top:50%;transform:translateY(-50%);
                                                   background:none;border:none;cursor:pointer;
                                                   color:var(--text-muted);font-size:.85rem;padding:0;">
                                        <i class="fas fa-eye" id="pwd-confirm-eye"></i>
                                    </button>
                                </div>
                                <span class="form-hint" id="match-hint" style="display:none;">
                                    <i class="fas fa-circle" style="font-size:.4rem;"></i>
                                    <span id="match-text"></span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── Acciones ── --}}
                <div class="form-actions">
                    <button type="submit" class="btn-save" id="btn-submit">
                        <i class="fas fa-user-plus"></i> Crear usuario
                    </button>
                    <a href="{{ route('superadmin.usuarios.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>

        {{-- ── COLUMNA LATERAL ── --}}
        <div class="create-side">

            {{-- Tips ── --}}
            <div class="create-card" style="margin-bottom:1rem;">
                <div class="create-card-head">
                    <i class="fas fa-lightbulb"></i>
                    <span>Información útil</span>
                </div>
                <div class="create-card-body" style="padding:1rem 1.2rem;">

                    <div class="tip-item">
                        <div class="tip-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <div class="tip-lbl">Roles disponibles</div>
                            <div class="role-pills">
                                <span class="role-pill" style="background:#1e293b;color:#e2e8f0;">Super Admin</span>
                                <span class="role-pill" style="background:rgba(71,85,105,.12);color:#334155;border:1px solid rgba(71,85,105,.25);">Admin</span>
                                <span class="role-pill" style="background:rgba(78,199,210,.15);color:#00508f;border:1px solid #b2e8ed;">Profesor</span>
                                <span class="role-pill" style="background:rgba(0,80,143,.1);color:#00508f;border:1px solid #bfd9ea;">Estudiante</span>
                                <span class="role-pill" style="background:#f0fdf4;color:#166534;border:1px solid #86efac;">Padre</span>
                            </div>
                        </div>
                    </div>

                    <div class="tip-item">
                        <div class="tip-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div class="tip-lbl">Email único</div>
                            <div class="tip-val">Cada usuario debe tener un correo electrónico distinto en el sistema.</div>
                        </div>
                    </div>

                    <div class="tip-item">
                        <div class="tip-icon"><i class="fas fa-lock"></i></div>
                        <div>
                            <div class="tip-lbl">Contraseña segura</div>
                            <div class="tip-val">Mín. 8 caracteres. Recomienda usar mayúsculas, números y símbolos.</div>
                        </div>
                    </div>

                    <div class="tip-item">
                        <div class="tip-icon"><i class="fas fa-toggle-on"></i></div>
                        <div>
                            <div class="tip-lbl">Estado</div>
                            <div class="tip-val">Un usuario inactivo no puede iniciar sesión hasta ser activado.</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Acceso rápido ── --}}
            <div style="background:var(--teal-light);border:1px solid rgba(78,199,210,.3);
                        border-radius:var(--radius-lg);padding:1rem 1.2rem;">
                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                            letter-spacing:.06em;color:var(--blue-mid);margin-bottom:.75rem;
                            display:flex;align-items:center;gap:.35rem;">
                    <i class="fas fa-link"></i> Acciones rápidas
                </div>
                <a href="{{ route('superadmin.usuarios.index') }}"
                   style="display:flex;align-items:center;gap:.5rem;padding:.5rem .65rem;
                          border-radius:8px;text-decoration:none;font-size:.82rem;
                          font-weight:600;color:var(--blue-mid);
                          background:white;border:1px solid rgba(78,199,210,.3);
                          margin-bottom:.4rem;transition:all .15s;">
                    <i class="fas fa-users" style="font-size:.75rem;"></i>
                    Ver todos los usuarios
                </a>
                <a href="{{ route('superadmin.usuarios.pendientes') }}"
                   style="display:flex;align-items:center;gap:.5rem;padding:.5rem .65rem;
                          border-radius:8px;text-decoration:none;font-size:.82rem;
                          font-weight:600;color:#92400e;
                          background:white;border:1px solid rgba(245,158,11,.3);
                          transition:all .15s;">
                    <i class="fas fa-clock" style="font-size:.75rem;"></i>
                    Usuarios pendientes
                </a>
            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    /* ── Preview nombre → avatar ── */
    const inputName    = document.getElementById('input-name');
    const namePreview  = document.getElementById('name-preview');
    const avatarPreview= document.getElementById('avatar-preview');

    if (inputName) {
        inputName.addEventListener('input', function () {
            const val = this.value.trim();
            if (!val) {
                namePreview.textContent = 'Nombre del usuario';
                avatarPreview.innerHTML = '<i class="fas fa-user" style="font-size:1.4rem;opacity:.6;"></i>';
                return;
            }
            namePreview.textContent = val;
            const partes = val.split(' ').filter(Boolean);
            const ini = ((partes[0]?.[0] ?? '') + (partes[1]?.[0] ?? '')).toUpperCase();
            avatarPreview.textContent = ini || val[0].toUpperCase();
        });
    }

    /* ── Toggle estado ── */
    const toggleActivo = document.getElementById('toggle-activo');
    const toggleLabel  = document.getElementById('toggle-label');
    if (toggleActivo) {
        toggleActivo.addEventListener('change', function () {
            toggleLabel.textContent = this.checked ? 'Cuenta activa' : 'Cuenta inactiva';
        });
    }

    /* ── Ver/ocultar contraseña ── */
    function makeToggle(btnId, inputId, eyeId) {
        const btn   = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        const eye   = document.getElementById(eyeId);
        if (!btn || !input) return;
        btn.addEventListener('click', function () {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            eye.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    }
    makeToggle('toggle-pwd',         'input-password',    'pwd-eye');
    makeToggle('toggle-pwd-confirm', 'input-pwd-confirm', 'pwd-confirm-eye');

    /* ── Fortaleza de contraseña ── */
    const inputPwd    = document.getElementById('input-password');
    const pwdBar      = document.getElementById('pwd-strength');
    const pwdHint     = document.getElementById('pwd-hint');
    const pwdHintText = document.getElementById('pwd-hint-text');
    const pwdConfirm  = document.getElementById('input-pwd-confirm');
    const matchHint   = document.getElementById('match-hint');
    const matchText   = document.getElementById('match-text');

    function checkStrength(pwd) {
        let s = 0;
        if (pwd.length >= 8)           s++;
        if (pwd.length >= 12)          s++;
        if (/[A-Z]/.test(pwd))         s++;
        if (/[0-9]/.test(pwd))         s++;
        if (/[^A-Za-z0-9]/.test(pwd))  s++;
        return s;
    }

    const levels = [
        { pct: '0%',   color: '#e2e8f0', text: '' },
        { pct: '25%',  color: '#ef4444', text: 'Muy débil' },
        { pct: '40%',  color: '#f59e0b', text: 'Débil' },
        { pct: '60%',  color: '#f59e0b', text: 'Aceptable' },
        { pct: '80%',  color: '#10b981', text: 'Fuerte' },
        { pct: '100%', color: '#059669', text: 'Muy fuerte' },
    ];

    if (inputPwd) {
        inputPwd.addEventListener('input', function () {
            const val = this.value;
            if (!val) {
                pwdBar.style.width = '0';
                pwdHint.style.display = 'none';
            } else {
                const lv = levels[Math.min(checkStrength(val), 5)];
                pwdBar.style.width      = lv.pct;
                pwdBar.style.background = lv.color;
                pwdHintText.textContent = lv.text;
                pwdHint.style.display   = 'flex';
                pwdHint.style.color     = lv.color;
            }
            checkMatch();
        });
    }

    function checkMatch() {
        if (!pwdConfirm || !inputPwd) return;
        const a = inputPwd.value, b = pwdConfirm.value;
        if (!b) { matchHint.style.display = 'none'; return; }
        matchHint.style.display = 'flex';
        if (a === b) {
            matchText.textContent = 'Las contraseñas coinciden';
            matchHint.style.color = '#10b981';
        } else {
            matchText.textContent = 'Las contraseñas no coinciden';
            matchHint.style.color = '#ef4444';
        }
    }

    if (pwdConfirm) pwdConfirm.addEventListener('input', checkMatch);

    /* ── Bloquear doble submit ── */
    document.getElementById('create-form').addEventListener('submit', function () {
        const btn = document.getElementById('btn-submit');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    });
})();
</script>
@endpush