@extends('layouts.app')

@section('title', 'Mi Portal')
@section('page-title', 'Portal del Padre/Tutor')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
    --blue-dark:  #003b73;
    --blue-mid:   #00508f;
    --cyan:       #4ec7d2;
    --cyan-light: #e8f8f9;
    --cyan-border:#b2e8ed;
    --surface:    #f8fafc;
    --border:     #e2e8f0;
    --text:       #0f172a;
    --muted:      #64748b;
    --subtle:     #94a3b8;
}

.portal-wrap {
    font-family: 'Inter', sans-serif;
    max-width: 960px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* ── Bienvenida ── */
.welcome-card {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    border-radius: 14px;
    padding: 1.75rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: 0 4px 20px rgba(0,59,115,.2);
}
.welcome-avatar {
    width: 64px; height: 64px; border-radius: 14px; flex-shrink: 0;
    background: rgba(255,255,255,.15);
    border: 2.5px solid var(--cyan);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; font-weight: 800; color: #fff;
}
.welcome-name { font-size: 1.2rem; font-weight: 700; color: #fff; margin: 0 0 .2rem; }
.welcome-sub  { font-size: .82rem; color: rgba(255,255,255,.7); margin: 0; }

/* ── Estadísticas ── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}
@media(max-width: 600px) { .stats-row { grid-template-columns: 1fr; } }

.stat-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.1rem 1.25rem;
    display: flex; align-items: center; gap: .85rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.stat-icon {
    width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; color: #fff;
}
.stat-icon.blue  { background: linear-gradient(135deg, var(--cyan), var(--blue-mid)); }
.stat-icon.green { background: linear-gradient(135deg, #34d399, #059669); }
.stat-icon.amber { background: linear-gradient(135deg, #fbbf24, #d97706); }
.stat-num   { font-size: 1.5rem; font-weight: 800; color: var(--blue-dark); line-height: 1; }
.stat-label { font-size: .72rem; color: var(--muted); margin-top: .15rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }

/* ── Section header ── */
.section-header {
    display: flex; align-items: center; gap: .5rem;
    font-size: .78rem; font-weight: 700; color: var(--blue-dark);
    text-transform: uppercase; letter-spacing: .07em;
    padding-bottom: .75rem;
    border-bottom: 2px solid var(--cyan-light);
    margin-bottom: 1rem;
}
.section-header i { color: var(--cyan); }

/* ── Tarjeta hijo ── */
.hijo-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.hijo-card:hover {
    box-shadow: 0 6px 20px rgba(78,199,210,.15);
    transform: translateY(-2px);
}
.hijo-header {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    padding: 1.1rem 1.25rem;
    display: flex; align-items: center; gap: .85rem;
}
.hijo-avatar {
    width: 48px; height: 48px; border-radius: 10px; flex-shrink: 0;
    background: rgba(255,255,255,.15);
    border: 2px solid var(--cyan);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; font-weight: 800; color: #fff;
    overflow: hidden;
}
.hijo-avatar img { width: 100%; height: 100%; object-fit: cover; }
.hijo-nombre { font-size: .95rem; font-weight: 700; color: #fff; margin: 0 0 .2rem; }
.hijo-grado  { font-size: .75rem; color: rgba(255,255,255,.75); margin: 0; }
.hijo-body { padding: 1.1rem 1.25rem; }
.info-row {
    display: flex; align-items: center; gap: .5rem;
    padding: .5rem 0; border-bottom: 1px solid var(--surface);
    font-size: .82rem;
}
.info-row:last-child { border-bottom: none; }
.info-row i { color: var(--cyan); width: 14px; text-align: center; flex-shrink: 0; }
.info-row .lbl { color: var(--subtle); font-weight: 600; min-width: 100px; }
.info-row .val { color: var(--text); font-weight: 500; }
.info-row .val.mono { font-family: monospace; color: var(--blue-mid); }
.hijo-footer {
    padding: .85rem 1.25rem;
    background: var(--surface);
    border-top: 1px solid var(--border);
    display: flex; gap: .6rem;
}
.hijo-btn {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .45rem .9rem; border-radius: 8px;
    font-size: .78rem; font-weight: 700; text-decoration: none;
    transition: all .15s; flex: 1; justify-content: center;
}
.hijo-btn-main { background: linear-gradient(135deg, var(--cyan), var(--blue-mid)); color: #fff; box-shadow: 0 2px 8px rgba(78,199,210,.3); }
.hijo-btn-main:hover { opacity: .88; color: #fff; }

/* ── Badges ── */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .2rem .65rem; border-radius: 999px;
    font-size: .68rem; font-weight: 700;
}
.b-active   { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
.b-inactive { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
.b-pending  { background: #fefce8; color: #854d0e; border: 1px solid #fde047; }

/* ── Historial ── */
.hist-card {
    background: #fff; border: 1px solid var(--border);
    border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.05); overflow: hidden;
}
.hist-header {
    background: var(--cyan-light); border-bottom: 1.5px solid var(--cyan-border);
    padding: .85rem 1.25rem; display: flex; align-items: center; gap: .5rem;
    font-size: .78rem; font-weight: 700; color: var(--blue-dark);
}
.hist-header i { color: var(--cyan); }
.hist-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
.hist-table th {
    padding: .65rem 1rem; text-align: left;
    font-size: .67rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: var(--subtle);
    background: var(--surface); border-bottom: 1px solid var(--border);
}
.hist-table td {
    padding: .75rem 1rem; border-bottom: 1px solid var(--surface);
    color: var(--text); font-weight: 500;
}
.hist-table tr:last-child td { border-bottom: none; }
.hist-table tr:hover td { background: var(--surface); }
.code-pill {
    font-family: monospace; font-size: .78rem; font-weight: 700;
    color: var(--blue-mid); background: var(--cyan-light);
    border: 1px solid var(--cyan-border);
    padding: .15rem .55rem; border-radius: 5px;
}

/* ── Empty state ── */
.empty-state { text-align: center; padding: 3rem 2rem; color: var(--subtle); }
.empty-state i { font-size: 2.5rem; color: var(--border); display: block; margin-bottom: 1rem; }
.empty-state p { margin: 0; font-size: .875rem; }

/* ── Info padre ── */
.padre-info-card {
    background: #fff; border: 1px solid var(--border);
    border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.05); overflow: hidden;
}
.padre-info-header {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .5rem;
    font-size: .82rem; font-weight: 700; color: #fff;
}
.padre-info-header i { color: var(--cyan); }
.padre-info-body { padding: 1.1rem 1.25rem; }
.padre-fields { display: grid; grid-template-columns: 1fr 1fr; gap: .65rem; }
@media(max-width: 500px) { .padre-fields { grid-template-columns: 1fr; } }
.pf-box {
    background: var(--surface); border-radius: 8px;
    border-left: 3px solid var(--cyan); padding: .55rem .8rem;
}
.pf-label { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--subtle); margin-bottom: .15rem; }
.pf-value { font-size: .82rem; font-weight: 600; color: var(--text); }
.pf-value.empty { color: var(--subtle); font-style: italic; font-weight: 400; }

/* ── Credenciales ── */
.creds-alert {
    background: #fefce8; border: 1.5px solid #fde047;
    border-radius: 10px; padding: 1rem 1.25rem;
    display: flex; gap: .75rem; align-items: flex-start;
}
.creds-alert i { color: #d97706; margin-top: .1rem; flex-shrink: 0; }
.creds-alert strong { color: #92400e; }
.creds-alert p { margin: .25rem 0 0; font-size: .82rem; color: var(--muted); }

/* ── Inputs contraseña ── */
.pw-input-wrap { position: relative; }
.pw-input {
    width: 100%; padding: .48rem 2.4rem .48rem .85rem;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .82rem; color: var(--text); background: var(--surface);
    outline: none; font-family: 'Inter', sans-serif; transition: border .15s;
    box-sizing: border-box;
}
.pw-input:focus { border-color: var(--cyan); background: #fff; box-shadow: 0 0 0 3px rgba(78,199,210,.1); }
.pw-toggle {
    position: absolute; right: .6rem; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer; color: var(--subtle); padding: 0;
}
.pw-toggle:hover { color: var(--blue-mid); }

.pw-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: .85rem; }
@media(max-width: 700px) { .pw-grid { grid-template-columns: 1fr; } }

.pw-label {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: var(--subtle); display: block; margin-bottom: .4rem;
}
.pw-label i { color: var(--cyan); margin-right: .3rem; }

.strength-bar {
    height: 4px; border-radius: 99px; background: var(--border);
    margin-top: .4rem; transition: background .3s, width .3s; display: none;
}
.hint-text { font-size: .68rem; margin: .2rem 0 0; font-weight: 600; }
.error-text { font-size: .72rem; color: #ef4444; margin: .3rem 0 0; }

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

.btn-save {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .48rem 1.4rem; border-radius: 8px; border: none;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    color: #fff; font-size: .78rem; font-weight: 700;
    cursor: pointer; font-family: 'Inter', sans-serif;
    box-shadow: 0 2px 8px rgba(78,199,210,.3); transition: opacity .15s;
}
.btn-save:hover { opacity: .88; }
.btn-cancel {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .48rem 1.1rem; border-radius: 8px;
    border: 1.5px solid var(--border); background: #fff;
    color: var(--muted); font-size: .78rem; font-weight: 700;
    cursor: pointer; font-family: 'Inter', sans-serif; transition: background .15s;
}
.btn-cancel:hover { background: var(--surface); }
</style>
@endpush

@section('content')
<div class="portal-wrap">

    {{-- ══ Bienvenida ══ --}}
    <div class="welcome-card">
        <div class="welcome-avatar">
            {{ strtoupper(substr($padre->nombre, 0, 1) . substr($padre->apellido, 0, 1)) }}
        </div>
        <div>
            <p class="welcome-name">Bienvenido/a, {{ $padre->nombre }} {{ $padre->apellido }}</p>
            <p class="welcome-sub">
                <i class="fas fa-users" style="margin-right:.35rem;"></i>
                Portal Familiar · {{ now()->format('d/m/Y') }}
            </p>
        </div>
    </div>

    {{-- ══ Estadísticas ══ --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-child"></i></div>
            <div>
                <div class="stat-num">{{ $matriculas->count() }}</div>
                <div class="stat-label">Hijos activos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-num">{{ $todasMatriculas->where('estado','aprobada')->count() }}</div>
                <div class="stat-label">Matrículas aprobadas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-clock"></i></div>
            <div>
                <div class="stat-num">{{ $todasMatriculas->where('estado','pendiente')->count() }}</div>
                <div class="stat-label">Matrículas pendientes</div>
            </div>
        </div>
    </div>

    {{-- ══ Alerta credenciales ══ --}}
    @if(auth()->user()->created_at->diffInDays(now()) <= 3)
    <div class="creds-alert">
        <i class="fas fa-key"></i>
        <div>
            <strong>Tus credenciales de acceso</strong>
            <p>Tu contraseña inicial es tu <strong>número de DNI</strong>. Te recomendamos cambiarla lo antes posible.</p>
        </div>
    </div>
    @endif

    {{-- ══ Hijos Vinculados ══ --}}
    <div>
        <div class="section-header">
            <i class="fas fa-user-graduate"></i>
            Hijos / Estudiantes Vinculados
        </div>
        @if($matriculas->count() > 0)
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1rem;">
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
                        <a href="{{ route('padre.hijo', $estudiante->id) }}" class="hijo-btn hijo-btn-main">
                            <i class="fas fa-eye"></i> Ver Detalles
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="hist-card">
                <div class="empty-state">
                    <i class="fas fa-user-slash"></i>
                    <p>No tienes hijos con matrícula aprobada actualmente.</p>
                </div>
            </div>
        @endif
    </div>

    {{-- ══ Historial matrículas ══ --}}
    @if($todasMatriculas->count() > 0)
    <div class="hist-card">
        <div class="hist-header">
            <i class="fas fa-history"></i>
            Historial de Solicitudes de Matrícula
        </div>
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
                    <td>{{ $m->estudiante?->nombre1 }} {{ $m->estudiante?->apellido1 }}</td>
                    <td>{{ $m->anio_lectivo }}</td>
                    <td>{{ $m->fecha_matricula ? \Carbon\Carbon::parse($m->fecha_matricula)->format('d/m/Y') : '—' }}</td>
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
    @endif

    {{-- ══ Mis Datos ══ --}}
    <div class="padre-info-card">
        <div class="padre-info-header">
            <i class="fas fa-user-circle"></i>
            Mis Datos
        </div>
        <div class="padre-info-body">
            <div class="padre-fields">
                <div class="pf-box">
                    <div class="pf-label">DNI</div>
                    <div class="pf-value" style="font-family:monospace;color:var(--blue-mid);">{{ $padre->dni ?: '—' }}</div>
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

    {{-- ══ Cambiar Contraseña ══ --}}
    <div class="padre-info-card">
        <div class="padre-info-header">
            <i class="fas fa-lock"></i>
            Cambiar Contraseña
        </div>
        <div class="padre-info-body">

            {{-- Alertas de sesión --}}
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

                    {{-- Contraseña actual --}}
                    <div>
                        <label class="pw-label">
                            <i class="fas fa-key"></i> Contraseña actual
                        </label>
                        <div class="pw-input-wrap">
                            <input type="password" name="password_actual" id="pw_actual"
                                   class="pw-input" placeholder="Tu contraseña actual">
                            <button type="button" class="pw-toggle"
                                    onclick="togglePw('pw_actual','eye_actual')">
                                <i class="fas fa-eye" id="eye_actual"></i>
                            </button>
                        </div>
                        @error('password_actual')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nueva contraseña --}}
                    <div>
                        <label class="pw-label">
                            <i class="fas fa-lock"></i> Nueva contraseña
                        </label>
                        <div class="pw-input-wrap">
                            <input type="password" name="password_nuevo" id="pw_nuevo"
                                   class="pw-input" placeholder="Mínimo 8 caracteres"
                                   oninput="checkStrength(this.value)">
                            <button type="button" class="pw-toggle"
                                    onclick="togglePw('pw_nuevo','eye_nuevo')">
                                <i class="fas fa-eye" id="eye_nuevo"></i>
                            </button>
                        </div>
                        <div class="strength-bar" id="strength-bar"></div>
                        <p class="hint-text" id="strength-text"></p>
                        @error('password_nuevo')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar --}}
                    <div>
                        <label class="pw-label">
                            <i class="fas fa-check-double"></i> Confirmar contraseña
                        </label>
                        <div class="pw-input-wrap">
                            <input type="password" name="password_nuevo_confirmation" id="pw_confirm"
                                   class="pw-input" placeholder="Repite la nueva contraseña"
                                   oninput="checkMatch()">
                            <button type="button" class="pw-toggle"
                                    onclick="togglePw('pw_confirm','eye_confirm')">
                                <i class="fas fa-eye" id="eye_confirm"></i>
                            </button>
                        </div>
                        <p class="hint-text" id="match-text"></p>
                        @error('password_nuevo_confirmation')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div style="margin-top:1.1rem;display:flex;align-items:center;gap:.65rem;flex-wrap:wrap;">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Guardar contraseña
                    </button>
                    <button type="reset" class="btn-cancel" onclick="resetForm()">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <span style="font-size:.75rem;color:var(--subtle);">
                        <i class="fas fa-info-circle" style="color:var(--cyan);"></i>
                        Mínimo 8 caracteres.
                    </span>
                </div>

            </form>
        </div>
    </div>

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
    if (val.length >= 8)            score++;
    if (/[A-Z]/.test(val))          score++;
    if (/[0-9]/.test(val))          score++;
    if (/[^A-Za-z0-9]/.test(val))   score++;
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
        text.style.color  = '#22c55e';
        text.textContent  = '✓ Las contraseñas coinciden';
    } else {
        text.style.color  = '#ef4444';
        text.textContent  = '✗ No coinciden';
    }
}

function resetForm() {
    document.getElementById('strength-bar').style.display = 'none';
    document.getElementById('strength-text').textContent  = '';
    document.getElementById('match-text').textContent     = '';
}
</script>
@endpush
