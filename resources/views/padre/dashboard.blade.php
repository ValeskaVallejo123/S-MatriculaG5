@extends('layouts.app')

@section('title', 'Mi Portal')
@section('page-title', 'Portal del Padre/Tutor')
@section('content-class', 'p-0')

@push('styles')
<style>
.pd-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.pd-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.pd-hero-left { display: flex; align-items: center; gap: 1rem; }
.pd-hero-avatar {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    font-size: 1.1rem; font-weight: 800; color: white;
}
.pd-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.pd-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.pd-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.pd-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.pd-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

/* Body */
.pd-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }

/* Section header */
.pd-section {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700; color: #003b73;
    text-transform: uppercase; letter-spacing: .07em;
    padding-bottom: .6rem; border-bottom: 2px solid rgba(78,199,210,.15);
    margin-bottom: 1rem;
}
.pd-section i { color: #4ec7d2; }

/* Credenciales alert */
.creds-alert {
    background: #fefce8; border: 1.5px solid #fde047;
    border-radius: 10px; padding: .9rem 1.1rem;
    display: flex; gap: .75rem; align-items: flex-start;
    margin-bottom: 1rem;
}
.creds-alert i { color: #d97706; margin-top: .1rem; flex-shrink: 0; }
.creds-alert strong { color: #92400e; font-size: .85rem; }
.creds-alert p { margin: .2rem 0 0; font-size: .8rem; color: #64748b; }

/* Hijos grid */
.hijos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem; margin-bottom: 1.5rem;
}

/* Hijo card */
.hijo-card {
    background: white; border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 12px rgba(0,59,115,.07);
    overflow: hidden; transition: box-shadow .2s, transform .2s;
}
.hijo-card:hover { box-shadow: 0 6px 20px rgba(78,199,210,.15); transform: translateY(-2px); }
.hijo-header {
    background: #003b73; padding: 1rem 1.1rem;
    display: flex; align-items: center; gap: .75rem;
}
.hijo-avatar {
    width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
    background: rgba(255,255,255,.15); border: 2px solid rgba(78,199,210,.6);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; font-weight: 800; color: white; overflow: hidden;
}
.hijo-avatar img { width: 100%; height: 100%; object-fit: cover; }
.hijo-nombre { font-size: .88rem; font-weight: 700; color: white; margin: 0 0 .2rem; }
.hijo-grado  { font-size: .72rem; color: rgba(255,255,255,.7); margin: 0; }
.hijo-body { padding: .9rem 1.1rem; }
.info-row {
    display: flex; align-items: center; gap: .5rem;
    padding: .45rem 0; border-bottom: 1px solid #f8fafc;
    font-size: .81rem;
}
.info-row:last-child { border-bottom: none; }
.info-row i { color: #4ec7d2; width: 14px; text-align: center; flex-shrink: 0; }
.info-row .lbl { color: #94a3b8; font-weight: 600; min-width: 90px; }
.info-row .val { color: #0f172a; font-weight: 500; }
.info-row .val.mono { font-family: monospace; color: #00508f; }
.hijo-footer {
    padding: .75rem 1.1rem; background: #f9fbfd;
    border-top: 1px solid #e2e8f0;
}
.hijo-btn {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .45rem .9rem; border-radius: 8px;
    font-size: .78rem; font-weight: 700; text-decoration: none;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; transition: opacity .15s;
}
.hijo-btn:hover { opacity: .88; color: white; }

/* Badges */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .68rem; font-weight: 700;
}
.b-active   { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
.b-inactive { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
.b-pending  { background: #fefce8; color: #854d0e; border: 1px solid #fde047; }

/* Historial table card */
.hist-card {
    background: white; border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 12px rgba(0,59,115,.07);
    overflow: hidden; margin-bottom: 1.5rem;
}
.hist-header {
    background: #003b73; padding: .75rem 1.1rem;
    display: flex; align-items: center; gap: .5rem;
    font-size: .82rem; font-weight: 700; color: white;
}
.hist-header i { color: #4ec7d2; }
.hist-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
.hist-table thead th {
    background: #f8fafc; padding: .65rem 1rem;
    font-size: .67rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: #94a3b8; border-bottom: 1px solid #e2e8f0;
}
.hist-table tbody td {
    padding: .72rem 1rem; border-bottom: 1px solid #f1f5f9;
    color: #334155; font-weight: 500;
}
.hist-table tbody tr:last-child td { border-bottom: none; }
.hist-table tbody tr:hover td { background: rgba(78,199,210,.03); }
.code-pill {
    font-family: monospace; font-size: .78rem; font-weight: 700;
    color: #00508f; background: rgba(78,199,210,.1);
    border: 1px solid rgba(78,199,210,.3);
    padding: .15rem .55rem; border-radius: 5px;
}

/* Mis datos card */
.pd-info-card {
    background: white; border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 12px rgba(0,59,115,.07);
    overflow: hidden; margin-bottom: 1rem;
}
.pd-info-header {
    background: #003b73; padding: .75rem 1.1rem;
    display: flex; align-items: center; gap: .5rem;
    font-size: .82rem; font-weight: 700; color: white;
}
.pd-info-header i { color: #4ec7d2; }
.pd-info-body { padding: 1.1rem 1.25rem; }
.pd-fields { display: grid; grid-template-columns: 1fr 1fr; gap: .65rem; }
@media(max-width: 500px) { .pd-fields { grid-template-columns: 1fr; } }
.pf-box {
    background: #f8fafc; border-radius: 8px;
    border-left: 3px solid #4ec7d2; padding: .55rem .8rem;
}
.pf-label { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #94a3b8; margin-bottom: .15rem; }
.pf-value { font-size: .82rem; font-weight: 600; color: #0f172a; }
.pf-value.empty { color: #94a3b8; font-style: italic; font-weight: 400; }

/* Cambiar contraseña */
.pw-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: .85rem; }
@media(max-width: 700px) { .pw-grid { grid-template-columns: 1fr; } }
.pw-label {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: #94a3b8; display: block; margin-bottom: .4rem;
}
.pw-label i { color: #4ec7d2; margin-right: .3rem; }
.pw-input-wrap { position: relative; }
.pw-input {
    width: 100%; padding: .48rem 2.4rem .48rem .85rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #0f172a; background: #f8fafc;
    outline: none; transition: border .15s; box-sizing: border-box;
}
.pw-input:focus { border-color: #4ec7d2; background: white; box-shadow: 0 0 0 3px rgba(78,199,210,.1); }
.pw-toggle {
    position: absolute; right: .6rem; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer; color: #94a3b8; padding: 0;
}
.pw-toggle:hover { color: #00508f; }
.strength-bar {
    height: 4px; border-radius: 99px; background: #e2e8f0;
    margin-top: .4rem; transition: background .3s; display: none;
}
.hint-text  { font-size: .68rem; margin: .2rem 0 0; font-weight: 600; }
.error-text { font-size: .72rem; color: #ef4444; margin: .3rem 0 0; }
.btn-save {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .48rem 1.4rem; border-radius: 8px; border: none;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; font-size: .78rem; font-weight: 700;
    cursor: pointer; box-shadow: 0 2px 8px rgba(78,199,210,.3); transition: opacity .15s;
}
.btn-save:hover { opacity: .88; }
.btn-cancel {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .48rem 1.1rem; border-radius: 8px;
    border: 1.5px solid #e2e8f0; background: white;
    color: #64748b; font-size: .78rem; font-weight: 700;
    cursor: pointer; transition: background .15s;
}
.btn-cancel:hover { background: #f8fafc; }
.alert-success {
    background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 9px;
    padding: .85rem 1rem; margin-bottom: 1rem;
    display: flex; align-items: center; gap: .6rem;
    font-size: .83rem; color: #166534; font-weight: 600;
}
.alert-error {
    background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 9px;
    padding: .85rem 1rem; margin-bottom: 1rem;
    display: flex; align-items: center; gap: .6rem;
    font-size: .83rem; color: #991b1b; font-weight: 600;
}

/* Empty */
.pd-empty { text-align: center; padding: 3rem 1rem; color: #94a3b8; }
.pd-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
.pd-empty p { font-size: .9rem; font-weight: 600; color: #003b73; margin: 0; }

/* Dark mode */
body.dark-mode .pd-wrap { background: #0f172a; }
body.dark-mode .hijo-card,
body.dark-mode .hist-card,
body.dark-mode .pd-info-card { background: #1e293b; border-color: #334155; }
body.dark-mode .hijo-body,
body.dark-mode .hijo-footer,
body.dark-mode .pd-info-body { background: #1e293b; }
body.dark-mode .info-row .val { color: #cbd5e1; }
body.dark-mode .hist-table thead th { background: #1e293b; }
body.dark-mode .hist-table tbody td { color: #cbd5e1; border-color: #334155; }
body.dark-mode .pf-box { background: #0f172a; }
body.dark-mode .pf-value { color: #e2e8f0; }
body.dark-mode .pw-input { background: #0f172a; border-color: #334155; color: #cbd5e1; }
</style>
@endpush

@section('content')
<div class="pd-wrap">

    {{-- Hero --}}
    <div class="pd-hero">
        <div class="pd-hero-left">
            <div class="pd-hero-avatar">
                {{ strtoupper(substr($padre->nombre, 0, 1) . substr($padre->apellido, 0, 1)) }}
            </div>
            <div>
                <h2 class="pd-hero-title">{{ $padre->nombre }} {{ $padre->apellido }}</h2>
                <p class="pd-hero-sub">
                    <i class="fas fa-users" style="margin-right:.3rem;"></i>
                    Portal Familiar · {{ now()->format('d/m/Y') }}
                </p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="pd-stat">
                <div class="pd-stat-num">{{ $matriculas->count() }}</div>
                <div class="pd-stat-lbl">Hijos activos</div>
            </div>
            <div class="pd-stat">
                <div class="pd-stat-num">{{ $todasMatriculas->where('estado','aprobada')->count() }}</div>
                <div class="pd-stat-lbl">Aprobadas</div>
            </div>
            <div class="pd-stat">
                <div class="pd-stat-num">{{ $todasMatriculas->where('estado','pendiente')->count() }}</div>
                <div class="pd-stat-lbl">Pendientes</div>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="pd-body">

        {{-- Alerta credenciales --}}
        @if(auth()->user()->created_at->diffInDays(now()) <= 3)
            <div class="creds-alert">
                <i class="fas fa-key"></i>
                <div>
                    <strong>Tus credenciales de acceso</strong>
                    <p>Tu contraseña inicial es tu <strong>número de DNI</strong>. Te recomendamos cambiarla lo antes posible.</p>
                </div>
            </div>
        @endif

        {{-- Hijos Vinculados --}}
        <div class="pd-section">
            <i class="fas fa-user-graduate"></i> Hijos / Estudiantes Vinculados
        </div>

        @if($matriculas->count() > 0)
            <div class="hijos-grid">
                @foreach($matriculas as $matricula)
                    @php $estudiante = $matricula->estudiante; @endphp
                    <div class="hijo-card">
                        <div class="hijo-header">
                            <div class="hijo-avatar">
                                @if($estudiante->foto)
                                    <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="{{ $estudiante->nombre1 }}">
                                @else
                                    {{ strtoupper(substr($estudiante->nombre1, 0, 1) . substr($estudiante->apellido1, 0, 1)) }}
                                @endif
                            </div>
                            <div style="flex:1;">
                                <p class="hijo-nombre">{{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }} {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}</p>
                                <p class="hijo-grado">
                                    <i class="fas fa-graduation-cap" style="margin-right:.3rem;"></i>
                                    {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                                </p>
                            </div>
                            <span class="bpill b-active">
                                <i class="fas fa-circle" style="font-size:.4rem;"></i> Activo
                            </span>
                        </div>
                        <div class="hijo-body">
                            <div class="info-row">
                                <i class="fas fa-id-card"></i>
                                <span class="lbl">DNI</span>
                                <span class="val mono">{{ $estudiante->dni ?: '—' }}</span>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-birthday-cake"></i>
                                <span class="lbl">Nacimiento</span>
                                <span class="val">
                                    {{ $estudiante->fecha_nacimiento
                                        ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y')
                                        : 'No registrado' }}
                                </span>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-barcode"></i>
                                <span class="lbl">Matrícula</span>
                                <span class="val mono">{{ $matricula->codigo_matricula }}</span>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="lbl">Año lectivo</span>
                                <span class="val">{{ $matricula->anio_lectivo }}</span>
                            </div>
                            @if($estudiante->email)
                                <div class="info-row">
                                    <i class="fas fa-envelope"></i>
                                    <span class="lbl">Email</span>
                                    <span class="val">{{ $estudiante->email }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="hijo-footer">
                            <a href="{{ route('padre.hijo', $estudiante->id) }}" class="hijo-btn">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="hist-card" style="margin-bottom:1.5rem;">
                <div class="pd-empty">
                    <i class="fas fa-user-slash"></i>
                    <p>No tienes hijos con matrícula aprobada actualmente.</p>
                </div>
            </div>
        @endif

        {{-- Historial matrículas --}}
        @if($todasMatriculas->count() > 0)
            <div class="pd-section">
                <i class="fas fa-history"></i> Historial de Solicitudes de Matrícula
            </div>
            <div class="hist-card">
                <div class="table-responsive">
                    <table class="hist-table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Estudiante</th>
                                <th>Año</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todasMatriculas as $m)
                                @php
                                    $badgeClass = match($m->estado) {
                                        'aprobada'  => 'b-active',
                                        'pendiente' => 'b-pending',
                                        default     => 'b-inactive',
                                    };
                                    $badgeIcon = match($m->estado) {
                                        'aprobada'  => 'fa-check-circle',
                                        'pendiente' => 'fa-clock',
                                        default     => 'fa-times-circle',
                                    };
                                @endphp
                                <tr>
                                    <td><span class="code-pill">{{ $m->codigo_matricula }}</span></td>
                                    <td style="font-weight:600;color:#003b73;">{{ $m->estudiante?->nombre1 }} {{ $m->estudiante?->apellido1 }}</td>
                                    <td>{{ $m->anio_lectivo }}</td>
                                    <td style="color:#64748b;font-size:.8rem;">{{ $m->fecha_matricula ? \Carbon\Carbon::parse($m->fecha_matricula)->format('d/m/Y') : '—' }}</td>
                                    <td>
                                        <span class="bpill {{ $badgeClass }}">
                                            <i class="fas {{ $badgeIcon }}" style="font-size:.45rem;"></i>
                                            {{ ucfirst($m->estado) }}
                                        </span>
                                        @if($m->estado === 'rechazada' && $m->motivo_rechazo)
                                            <div style="font-size:.7rem;color:#94a3b8;margin-top:.2rem;">
                                                {{ Str::limit($m->motivo_rechazo, 40) }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Mis Datos --}}
        <div class="pd-section">
            <i class="fas fa-user-circle"></i> Mis Datos
        </div>
        <div class="pd-info-card">
            <div class="pd-info-header">
                <i class="fas fa-user-circle"></i> Información Personal
            </div>
            <div class="pd-info-body">
                <div class="pd-fields">
                    <div class="pf-box">
                        <div class="pf-label">DNI</div>
                        <div class="pf-value" style="font-family:monospace;color:#00508f;">{{ $padre->dni ?: '—' }}</div>
                    </div>
                    <div class="pf-box">
                        <div class="pf-label">Parentesco</div>
                        <div class="pf-value">{{ $padre->parentesco_formateado }}</div>
                    </div>
                    <div class="pf-box">
                        <div class="pf-label">Teléfono</div>
                        <div class="pf-value {{ !$padre->telefono ? 'empty' : '' }}">{{ $padre->telefono ?: 'No registrado' }}</div>
                    </div>
                    <div class="pf-box">
                        <div class="pf-label">Correo</div>
                        <div class="pf-value {{ !$padre->correo ? 'empty' : '' }}">{{ $padre->correo ?: 'No registrado' }}</div>
                    </div>
                    <div class="pf-box" style="grid-column:1 / -1;">
                        <div class="pf-label">Dirección</div>
                        <div class="pf-value {{ !$padre->direccion ? 'empty' : '' }}">{{ $padre->direccion ?: 'No registrada' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cambiar Contraseña --}}
        <div class="pd-section">
            <i class="fas fa-lock"></i> Cambiar Contraseña
        </div>
        <div class="pd-info-card">
            <div class="pd-info-header">
                <i class="fas fa-lock"></i> Seguridad de la Cuenta
            </div>
            <div class="pd-info-body">

                @if(session('pw_success'))
                    <div class="alert-success">
                        <i class="fas fa-check-circle" style="color:#22c55e;"></i>
                        {{ session('pw_success') }}
                    </div>
                @endif
                @if(session('pw_error'))
                    <div class="alert-error">
                        <i class="fas fa-exclamation-circle" style="color:#ef4444;"></i>
                        {{ session('pw_error') }}
                    </div>
                @endif

                <form action="{{ route('padre.cambiar-password') }}" method="POST" id="formPassword">
                    @csrf
                    @method('PUT')

                    <div class="pw-grid">
                        <div>
                            <label class="pw-label"><i class="fas fa-key"></i> Contraseña actual</label>
                            <div class="pw-input-wrap">
                                <input type="password" name="password_actual" id="pw_actual"
                                       class="pw-input" placeholder="Tu contraseña actual">
                                <button type="button" class="pw-toggle" onclick="togglePw('pw_actual','eye_actual')">
                                    <i class="fas fa-eye" id="eye_actual"></i>
                                </button>
                            </div>
                            @error('password_actual')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="pw-label"><i class="fas fa-lock"></i> Nueva contraseña</label>
                            <div class="pw-input-wrap">
                                <input type="password" name="password_nuevo" id="pw_nuevo"
                                       class="pw-input" placeholder="Mínimo 8 caracteres"
                                       oninput="checkStrength(this.value)">
                                <button type="button" class="pw-toggle" onclick="togglePw('pw_nuevo','eye_nuevo')">
                                    <i class="fas fa-eye" id="eye_nuevo"></i>
                                </button>
                            </div>
                            <div class="strength-bar" id="strength-bar"></div>
                            <p class="hint-text" id="strength-text"></p>
                            @error('password_nuevo')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="pw-label"><i class="fas fa-check-double"></i> Confirmar contraseña</label>
                            <div class="pw-input-wrap">
                                <input type="password" name="password_nuevo_confirmation" id="pw_confirm"
                                       class="pw-input" placeholder="Repite la nueva contraseña"
                                       oninput="checkMatch()">
                                <button type="button" class="pw-toggle" onclick="togglePw('pw_confirm','eye_confirm')">
                                    <i class="fas fa-eye" id="eye_confirm"></i>
                                </button>
                            </div>
                            <p class="hint-text" id="match-text"></p>
                            @error('password_nuevo_confirmation')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div style="margin-top:1.1rem;display:flex;align-items:center;gap:.65rem;flex-wrap:wrap;">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Guardar contraseña
                        </button>
                        <button type="reset" class="btn-cancel" onclick="resetForm()">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <span style="font-size:.75rem;color:#94a3b8;">
                            <i class="fas fa-info-circle" style="color:#4ec7d2;"></i> Mínimo 8 caracteres.
                        </span>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- /pd-body --}}
</div>
@endsection

@push('scripts')
<script>
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function checkStrength(val) {
    const bar  = document.getElementById('strength-bar');
    const text = document.getElementById('strength-text');
    if (!val) { bar.style.display = 'none'; text.textContent = ''; return; }
    bar.style.display = 'block';
    let score = 0;
    if (val.length >= 8)          score++;
    if (/[A-Z]/.test(val))        score++;
    if (/[0-9]/.test(val))        score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        { color: '#ef4444', label: 'Muy débil',  w: '25%'  },
        { color: '#f97316', label: 'Débil',       w: '50%'  },
        { color: '#eab308', label: 'Regular',     w: '75%'  },
        { color: '#22c55e', label: 'Fuerte',      w: '100%' },
    ];
    const lvl = levels[Math.max(score - 1, 0)];
    bar.style.background = lvl.color;
    bar.style.width      = lvl.w;
    text.style.color     = lvl.color;
    text.textContent     = lvl.label;
}

function checkMatch() {
    const nuevo   = document.getElementById('pw_nuevo').value;
    const confirm = document.getElementById('pw_confirm').value;
    const text    = document.getElementById('match-text');
    if (!confirm) { text.textContent = ''; return; }
    if (nuevo === confirm) {
        text.style.color = '#22c55e';
        text.textContent = '✓ Las contraseñas coinciden';
    } else {
        text.style.color = '#ef4444';
        text.textContent = '✗ No coinciden';
    }
}

function resetForm() {
    document.getElementById('strength-bar').style.display = 'none';
    document.getElementById('strength-text').textContent  = '';
    document.getElementById('match-text').textContent     = '';
}
</script>
@endpush
