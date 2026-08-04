@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('page-title', 'Editar Usuario')

@section('topbar-actions')
    <a href="{{ route('superadmin.usuarios.index') }}" class="edit-topbar-btn-ghost">
        <i class="fas fa-arrow-left"></i>
        <span class="edit-btn-text">Volver</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botones topbar ── */
    .edit-topbar-btn-ghost {
        display: inline-flex; align-items: center; gap: .45rem;
        background: transparent; color: white;
        padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        border: 1.5px solid rgba(255,255,255,.35); white-space: nowrap;
        transition: background .2s;
    }
    .edit-topbar-btn-ghost:hover { background: rgba(255,255,255,.12); color: white; }
    @media(max-width:600px) {
        .edit-btn-text { display: none; }
        .edit-topbar-btn-ghost { padding: .5rem .65rem; }
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

    /* ── Layout principal ── */
    .edit-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 1.25rem;
        align-items: start;
    }
    @media(max-width:900px) {
        .edit-layout { grid-template-columns: 1fr; }
    }

    /* ── Card base ── */
    .edit-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .edit-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .edit-card-head i    { color: var(--teal); font-size: 1rem; }
    .edit-card-head span { color: white; font-weight: 700; font-size: .95rem; }
    .edit-card-body { padding: 1.5rem 1.4rem; }

    /* ── Avatar ── */
    .edit-avatar {
        width: 72px; height: 72px; border-radius: 16px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #fff; font-size: 1.6rem;
        border: 3px solid rgba(78,199,210,.35);
        flex-shrink: 0;
    }

    /* ── Sección del formulario ── */
    .form-section {
        margin-bottom: 1.75rem;
    }
    .form-section-title {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--teal);
        margin-bottom: 1rem; padding-bottom: .45rem;
        border-bottom: 1.5px solid var(--teal-light);
        display: flex; align-items: center; gap: .4rem;
    }
    .form-section:last-child { margin-bottom: 0; }

    /* ── Grid de campos ── */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .form-row-full { grid-template-columns: 1fr; }
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

    .form-hint {
        font-size: .72rem; color: var(--text-muted);
        margin-top: .35rem; display: flex; align-items: center; gap: .25rem;
    }
    .form-error {
        font-size: .72rem; color: var(--red);
        margin-top: .35rem; display: flex; align-items: center; gap: .25rem;
    }

    /* ── Toggle activo ── */
    .toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: .85rem 1rem; border-radius: 10px;
        background: var(--surface); border: 1px solid var(--border);
        gap: 1rem;
    }
    .toggle-info { flex: 1; }
    .toggle-label { font-size: .85rem; font-weight: 600; color: var(--blue-dark); }
    .toggle-desc  { font-size: .73rem; color: var(--text-muted); margin-top: .1rem; }

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

    /* ── Botones del formulario ── */
    .form-actions {
        display: flex; align-items: center; gap: .75rem;
        padding-top: 1.25rem; border-top: 1px solid var(--border);
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

    /* ── Card lateral: info del usuario ── */
    .usr-info-card { position: sticky; top: 1rem; }

    .info-item {
        display: flex; align-items: flex-start; gap: .75rem;
        padding: .85rem 0; border-bottom: 1px solid var(--border);
    }
    .info-item:last-child { border-bottom: none; padding-bottom: 0; }
    .info-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--teal-light); color: var(--blue-mid);
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem; flex-shrink: 0;
    }
    .info-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--text-muted); margin-bottom: .15rem; }
    .info-val { font-size: .84rem; font-weight: 600; color: var(--text-main); word-break: break-all; }

    /* Badge de rol */
    .rol-preview {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .22rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 700;
    }

    /* Alerta de peligro zona ── */
    .danger-zone {
        margin-top: .5rem; padding: 1rem 1.1rem;
        border-radius: 10px; border: 1px solid #fca5a5;
        background: #fef2f2;
    }
    .danger-zone-title {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: #991b1b; margin-bottom: .65rem;
        display: flex; align-items: center; gap: .35rem;
    }
    .btn-danger {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .5rem 1rem; border-radius: 8px;
        background: white; color: var(--red);
        border: 1.5px solid #fca5a5;
        font-size: .82rem; font-weight: 600; font-family: inherit;
        cursor: pointer; transition: all .2s; width: 100%; justify-content: center;
    }
    .btn-danger:hover { background: #fef2f2; border-color: var(--red); }

    /* Password strength bar */
    .pwd-bar { height: 4px; border-radius: 2px; background: var(--border); margin-top: .5rem; overflow: hidden; }
    .pwd-bar-fill { height: 100%; border-radius: 2px; width: 0; transition: width .3s, background .3s; }

    /* Alert genérica */
    .alert-ok {
        padding: .9rem 1.1rem; border-radius: 10px;
        background: #f0fdf4; border: 1px solid #86efac;
        color: #166534; font-size: .83rem; margin-bottom: 1.25rem;
    }
    .alert-err {
        padding: .9rem 1.1rem; border-radius: 10px;
        background: #fef2f2; border: 1px solid #fca5a5;
        color: #991b1b; font-size: .83rem; margin-bottom: 1.25rem;
    }
</style>
@endpush

@section('content')
<div>

    <div class="edit-layout">

        {{-- ── COLUMNA PRINCIPAL ── --}}
        <div>
            <form action="{{ route('superadmin.usuarios.update', $usuario->id) }}"
                  method="POST" id="edit-form">
                @csrf
                @method('PUT')

                {{-- ── Card: Información básica ── --}}
                <div class="edit-card" style="margin-bottom:1.25rem;">
                    <div class="edit-card-head">
                        <i class="fas fa-user-edit"></i>
                        <span>Información básica</span>
                    </div>
                    <div class="edit-card-body">

                        {{-- Avatar + nombre actual --}}
                        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;
                                    padding-bottom:1.25rem;border-bottom:1px solid var(--border);">
                            @php
                                $partes = explode(' ', $usuario->name);
                                $iniciales = strtoupper(
                                    substr($partes[0], 0, 1) .
                                    (isset($partes[1]) ? substr($partes[1], 0, 1) : '')
                                );
                            @endphp
                            <div class="edit-avatar" id="avatar-preview">{{ $iniciales }}</div>
                            <div>
                                <div style="font-size:.95rem;font-weight:700;color:var(--blue-dark);" id="name-preview">
                                    {{ $usuario->name }}
                                </div>
                                <div style="font-size:.78rem;color:var(--text-muted);margin-top:.2rem;">
                                    ID: <code style="font-size:.78rem;color:var(--blue-mid);">#{{ $usuario->id }}</code>
                                    &nbsp;·&nbsp; Creado {{ $usuario->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        {{-- Nombre y email --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-id-card"></i> Datos personales
                            </div>
                            <div class="form-row" style="margin-bottom:1rem;">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user" style="font-size:.75rem;"></i>
                                        Nombre completo <em class="req">*</em>
                                    </label>
                                    <input type="text" name="name" id="input-name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $usuario->name) }}"
                                           placeholder="Nombre completo" required>
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
                                           value="{{ old('email', $usuario->email) }}"
                                           placeholder="correo@ejemplo.com" required>
                                    @error('email')
                                        <span class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Rol y estado --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-shield-alt"></i> Rol y acceso
                            </div>
                            <div class="form-row" style="margin-bottom:1rem;">
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
                                                {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>
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
                                        Estado de cuenta
                                    </label>
                                    <div class="toggle-row" style="height:42px;">
                                        <div class="toggle-info">
                                            <div class="toggle-label" id="toggle-label">
                                                {{ $usuario->activo ? 'Cuenta activa' : 'Cuenta pendiente' }}
                                            </div>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox" name="activo" value="1"
                                                   id="toggle-activo"
                                                   {{ old('activo', $usuario->activo) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="activo" value="0">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── Card: Cambio de contraseña ── --}}
                <div class="edit-card" style="margin-bottom:1.25rem;">
                    <div class="edit-card-head">
                        <i class="fas fa-lock"></i>
                        <span>Cambiar contraseña</span>
                    </div>
                    <div class="edit-card-body">

                        <div style="display:flex;align-items:flex-start;gap:.65rem;
                                    padding:.75rem 1rem;border-radius:9px;
                                    background:rgba(78,199,210,.07);border:1px solid #b2e8ed;
                                    margin-bottom:1.25rem;">
                            <i class="fas fa-info-circle" style="color:var(--teal);flex-shrink:0;margin-top:2px;"></i>
                            <span style="font-size:.8rem;color:#003b73;">
                                Deja los campos en blanco si no deseas cambiar la contraseña actual.
                            </span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-key" style="font-size:.75rem;"></i>
                                    Nueva contraseña
                                </label>
                                <input type="password" name="password" id="input-password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Mínimo 8 caracteres"
                                       autocomplete="new-password">
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
                                    Confirmar contraseña
                                </label>
                                <input type="password" name="password_confirmation" id="input-pwd-confirm"
                                       class="form-control"
                                       placeholder="Repetir contraseña"
                                       autocomplete="new-password">
                                <span class="form-hint" id="match-hint" style="display:none;">
                                    <i class="fas fa-circle" style="font-size:.4rem;"></i>
                                    <span id="match-text"></span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── Acciones ── --}}
                <div class="form-actions" style="padding-top:0;border-top:none;">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Guardar cambios
                    </button>
                    <a href="{{ route('superadmin.usuarios.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <a href="{{ route('superadmin.usuarios.show', $usuario->id) }}"
                       style="margin-left:auto;font-size:.78rem;color:var(--text-muted);
                              text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;">
                        <i class="fas fa-eye" style="font-size:.72rem;"></i> Ver perfil
                    </a>
                </div>

            </form>
        </div>

        {{-- ── COLUMNA LATERAL ── --}}
        <div class="usr-info-card">

            {{-- Info del usuario --}}
            <div class="edit-card" style="margin-bottom:1rem;">
                <div class="edit-card-head">
                    <i class="fas fa-info-circle"></i>
                    <span>Detalles del usuario</span>
                </div>
                <div class="edit-card-body" style="padding:1rem 1.2rem;">
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-hashtag"></i></div>
                        <div>
                            <div class="info-lbl">ID del sistema</div>
                            <div class="info-val">#{{ $usuario->id }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <div class="info-lbl">Rol actual</div>
                            <div class="info-val">
                                @php
                                    $nombreRol = $usuario->rol->nombre ?? 'Sin rol';
                                    $coloresRol = [
                                        'Super Administrador' => 'background:#1e293b;color:#e2e8f0;',
                                        'super_admin'         => 'background:#1e293b;color:#e2e8f0;',
                                        'Administrador'       => 'background:rgba(71,85,105,.12);color:#334155;border:1px solid rgba(71,85,105,.25);',
                                        'admin'               => 'background:rgba(71,85,105,.12);color:#334155;border:1px solid rgba(71,85,105,.25);',
                                        'Maestro'             => 'background:rgba(78,199,210,.15);color:#00508f;border:1px solid #b2e8ed;',
                                        'Profesor'            => 'background:rgba(78,199,210,.15);color:#00508f;border:1px solid #b2e8ed;',
                                        'profesor'            => 'background:rgba(78,199,210,.15);color:#00508f;border:1px solid #b2e8ed;',
                                        'Estudiante'          => 'background:rgba(0,80,143,.1);color:#00508f;border:1px solid #bfd9ea;',
                                        'Padre'               => 'background:#f0fdf4;color:#166534;border:1px solid #86efac;',
                                    ];
                                    $estiloRol = $coloresRol[$nombreRol] ?? 'background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;';
                                @endphp
                                <span class="rol-preview" style="{{ $estiloRol }}">
                                    {{ $nombreRol }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-calendar-plus"></i></div>
                        <div>
                            <div class="info-lbl">Creado el</div>
                            <div class="info-val">{{ $usuario->created_at->format('d/m/Y') }}</div>
                            <div style="font-size:.72rem;color:var(--text-muted);">{{ $usuario->created_at->format('H:i') }} · {{ $usuario->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-edit"></i></div>
                        <div>
                            <div class="info-lbl">Última actualización</div>
                            <div class="info-val">{{ $usuario->updated_at->format('d/m/Y') }}</div>
                            <div style="font-size:.72rem;color:var(--text-muted);">{{ $usuario->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon" style="{{ $usuario->activo ? 'background:rgba(16,185,129,.12);color:#10b981;' : 'background:rgba(245,158,11,.1);color:#f59e0b;' }}">
                            <i class="fas fa-circle" style="font-size:.55rem;"></i>
                        </div>
                        <div>
                            <div class="info-lbl">Estado actual</div>
                            <div class="info-val" style="color:{{ $usuario->activo ? '#059669' : '#92400e' }};">
                                {{ $usuario->activo ? 'Activo' : 'Pendiente' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Zona de peligro --}}
            @if($usuario->id !== Auth::id())
            <div class="danger-zone">
                <div class="danger-zone-title">
                    <i class="fas fa-exclamation-triangle"></i> Zona de peligro
                </div>
                @if($usuario->activo)
                {{-- Desactivar: usa sysConfirm (modal azul del sistema) --}}
                <form id="form-desactivar"
                      action="{{ route('superadmin.usuarios.desactivar', $usuario->id) }}"
                      method="POST" style="margin-bottom:.5rem;">
                    @csrf @method('PUT')
                    <button type="button" class="btn-danger"
                            style="color:#92400e;border-color:#fde047;background:#fefce8;"
                            onclick="sysConfirm(
                                '¿Desactivar la cuenta de {{ addslashes($usuario->name) }}? No podrá iniciar sesión hasta que sea reactivada.',
                                function() { document.getElementById('form-desactivar').submit(); }
                            )">
                        <i class="fas fa-ban"></i> Desactivar cuenta
                    </button>
                </form>
                @else
                {{-- Activar: sin confirmación, acción positiva --}}
                <form action="{{ route('superadmin.usuarios.activar', $usuario->id) }}"
                      method="POST" style="margin-bottom:.5rem;">
                    @csrf @method('PUT')
                    <button type="submit" class="btn-danger" style="color:#059669;border-color:#86efac;background:#f0fdf4;">
                        <i class="fas fa-check-circle"></i> Activar cuenta
                    </button>
                </form>
                @endif

                {{-- Eliminar: usa mostrarModalDelete (modal rojo del sistema) --}}
                <button type="button" class="btn-danger"
                        onclick="mostrarModalDelete(
                            '{{ route('superadmin.usuarios.destroy', $usuario->id) }}',
                            '{{ addslashes($usuario->name) }}'
                        )">
                    <i class="fas fa-trash-alt"></i> Eliminar usuario
                </button>
            </div>
            @endif

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    /* ── Avatar + preview del nombre ── */
    const inputName    = document.getElementById('input-name');
    const namePreview  = document.getElementById('name-preview');
    const avatarPreview= document.getElementById('avatar-preview');

    if (inputName) {
        inputName.addEventListener('input', function () {
            const val = this.value.trim();
            namePreview.textContent = val || '—';
            const partes = val.split(' ').filter(Boolean);
            const ini = ((partes[0]?.[0] ?? '') + (partes[1]?.[0] ?? '')).toUpperCase();
            avatarPreview.textContent = ini || '?';
        });
    }

    /* ── Toggle activo ── */
    const toggleActivo = document.getElementById('toggle-activo');
    const toggleLabel  = document.getElementById('toggle-label');
    if (toggleActivo) {
        toggleActivo.addEventListener('change', function () {
            toggleLabel.textContent = this.checked ? 'Cuenta activa' : 'Cuenta pendiente';
        });
    }

    /* ── Fortaleza de contraseña ── */
    const inputPwd    = document.getElementById('input-password');
    const pwdBar      = document.getElementById('pwd-strength');
    const pwdHint     = document.getElementById('pwd-hint');
    const pwdHintText = document.getElementById('pwd-hint-text');
    const pwdConfirm  = document.getElementById('input-pwd-confirm');
    const matchHint   = document.getElementById('match-hint');
    const matchText   = document.getElementById('match-text');

    function checkStrength(pwd) {
        let score = 0;
        if (pwd.length >= 8)  score++;
        if (pwd.length >= 12) score++;
        if (/[A-Z]/.test(pwd)) score++;
        if (/[0-9]/.test(pwd)) score++;
        if (/[^A-Za-z0-9]/.test(pwd)) score++;
        return score;
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
                pwdBar.style.width = '0'; pwdHint.style.display = 'none';
            } else {
                const score = Math.min(checkStrength(val), 5);
                const lv = levels[score];
                pwdBar.style.width     = lv.pct;
                pwdBar.style.background= lv.color;
                pwdHintText.textContent= lv.text;
                pwdHint.style.display  = 'flex';
                pwdHint.style.color    = lv.color;
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
})();
</script>
@endpush