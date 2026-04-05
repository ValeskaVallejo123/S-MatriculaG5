@extends('layouts.app')

@section('title', 'Consulta de Solicitud')
@section('page-title', 'Estado de Solicitud')

@push('styles')
<style>
.est-wrap { font-family: 'Inter', sans-serif; }

/* ── Header ── */
.est-header {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #0369a1 100%);
    border-radius: 12px; padding: 1.4rem 1.6rem;
    display: flex; align-items: center; gap: 1rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 16px rgba(0,59,115,.2);
}
.est-header-icon {
    width: 52px; height: 52px; border-radius: 12px; flex-shrink: 0;
    background: rgba(78,199,210,.18); border: 2px solid rgba(78,199,210,.4);
    display: flex; align-items: center; justify-content: center;
}
.est-header-icon i { font-size: 1.4rem; color: #4ec7d2; }
.est-header h4 { margin: 0; color: #fff; font-size: 1.05rem; font-weight: 700; }
.est-header p  { margin: 0; color: rgba(255,255,255,.65); font-size: .8rem; }

/* ── Cards ── */
.est-card {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 12px; overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    margin-bottom: 1.25rem;
}
.est-card-head {
    background: #003b73; padding: .75rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.est-card-head i    { color: #4ec7d2; font-size: .95rem; }
.est-card-head span { color: #fff; font-weight: 700; font-size: .88rem; }
.est-card-body { padding: 1.25rem 1.4rem; }

/* ── Search form ── */
.est-label {
    display: block; font-size: .73rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .05em;
    color: #003b73; margin-bottom: .35rem;
}
.est-input-wrap { display: flex; align-items: center; }
.est-input-icon {
    display: flex; align-items: center; justify-content: center;
    padding: 0 .75rem; height: 40px;
    background: #f8fafc; border: 1.5px solid #e2e8f0;
    border-right: none; border-radius: 8px 0 0 8px;
    color: #4ec7d2; font-size: .9rem;
}
.est-input {
    flex: 1; height: 40px; padding: 0 .9rem;
    border: 1.5px solid #e2e8f0; border-radius: 0 8px 8px 0;
    font-size: .85rem; font-family: 'Inter', sans-serif;
    color: #0f172a; outline: none;
    transition: border-color .2s, box-shadow .2s;
    background: #f8fafc;
}
.est-input:focus {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    background: #fff;
}
.est-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    padding: 0 1.4rem; height: 40px; border-radius: 8px; border: none;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; font-size: .83rem; font-weight: 600;
    font-family: 'Inter', sans-serif; cursor: pointer;
    transition: opacity .15s; text-decoration: none;
}
.est-btn:hover { opacity: .88; color: #fff; }

/* ── Estado badge ── */
.est-status {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.1rem 1.3rem; border-radius: 10px;
}
.est-status-icon {
    width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.est-status-icon i  { font-size: 1.4rem; }
.est-status-title   { font-weight: 700; font-size: .95rem; margin-bottom: .15rem; }
.est-status-desc    { font-size: .8rem; }

.status-aprobada { background: rgba(16,185,129,.08); border: 1px solid rgba(16,185,129,.25); }
.status-aprobada .est-status-icon { background: rgba(16,185,129,.15); }
.status-aprobada .est-status-icon i { color: #10b981; }
.status-aprobada .est-status-title  { color: #059669; }
.status-aprobada .est-status-desc   { color: #064e3b; }

.status-rechazada { background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.25); }
.status-rechazada .est-status-icon { background: rgba(239,68,68,.15); }
.status-rechazada .est-status-icon i { color: #ef4444; }
.status-rechazada .est-status-title  { color: #dc2626; }
.status-rechazada .est-status-desc   { color: #7f1d1d; }

.status-pendiente { background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.25); }
.status-pendiente .est-status-icon { background: rgba(245,158,11,.15); }
.status-pendiente .est-status-icon i { color: #f59e0b; }
.status-pendiente .est-status-title  { color: #d97706; }
.status-pendiente .est-status-desc   { color: #78350f; }

/* ── Info fields ── */
.est-grid   { display: grid; grid-template-columns: repeat(2,1fr); gap: .85rem; }
.est-grid-3 { grid-template-columns: repeat(3,1fr); }
@media(max-width:768px){ .est-grid-3 { grid-template-columns: repeat(2,1fr); } }
@media(max-width:576px){ .est-grid, .est-grid-3 { grid-template-columns: 1fr; } }

.est-field {
    background: #f8fafc; border: 1px solid #f1f5f9;
    border-radius: 8px; padding: .75rem 1rem;
}
.est-field-lbl {
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: #94a3b8; margin-bottom: .25rem;
}
.est-field-val { font-size: .88rem; font-weight: 600; color: #1e293b; }

/* ── Tracker de pasos ── */
.est-steps { display: grid; grid-template-columns: repeat(4,1fr); gap: .5rem; margin-bottom: 1.25rem; }
@media(max-width:576px){ .est-steps { grid-template-columns: repeat(2,1fr); } }
.est-step {
    text-align: center; padding: .9rem .5rem;
    background: #f8fafc; border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: .72rem; font-weight: 600; color: #94a3b8;
}
.est-step i { display: block; font-size: 1.1rem; margin-bottom: .3rem; }
.est-step.done    { background: rgba(16,185,129,.07); border-color: rgba(16,185,129,.3); color: #059669; }
.est-step.active  { background: rgba(245,158,11,.08); border-color: rgba(245,158,11,.35); color: #d97706; }
.est-step.rejected{ background: rgba(239,68,68,.07); border-color: rgba(239,68,68,.25); color: #dc2626; }

/* ── Credenciales ── */
.est-credentials { background: rgba(248,250,252,1); border: 1px solid #e2e8f0; border-radius: 10px; padding: 1rem; }
.est-cred-item {
    display: flex; align-items: center; gap: .75rem;
    padding: .65rem .9rem; background: white;
    border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: .6rem;
}
.est-cred-item:last-child { margin-bottom: 0; }
.est-cred-icon {
    width: 36px; height: 36px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
}
.est-cred-icon i  { color: white; font-size: .85rem; }
.est-cred-lbl     { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; }
.est-cred-val     { font-size: .85rem; font-weight: 700; color: #003b73; }

/* ── Alert ── */
.est-alert {
    display: flex; align-items: center; gap: .6rem;
    background: rgba(239,68,68,.07); border: 1px solid rgba(239,68,68,.2);
    border-radius: 8px; padding: .7rem 1rem;
    font-size: .83rem; color: #dc2626; font-weight: 500;
    margin-bottom: 1rem;
}
</style>
@endpush

@section('content')
<div class="est-wrap container-fluid px-4">

    {{-- ── Encabezado ── --}}
    <div class="est-header">
        <div class="est-header-icon"><i class="fas fa-search"></i></div>
        <div>
            <h4>Consulta de Estado de Solicitud</h4>
            <p>Ingresa el DNI del estudiante para verificar el estado de su matrícula</p>
        </div>
    </div>

    {{-- ── Formulario ── --}}
    <div class="est-card">
        <div class="est-card-head">
            <i class="fas fa-id-card"></i>
            <span>Buscar por DNI del Estudiante</span>
        </div>
        <div class="est-card-body">

            @if ($errors->has('dni'))
                <div class="est-alert">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('dni') }}
                </div>
            @endif

            @if (session('sin_resultado'))
                <div class="est-alert">
                    <i class="fas fa-search"></i>
                    No se encontró ninguna solicitud con el DNI ingresado. Verifica el número e intenta de nuevo.
                </div>
            @endif

            <form method="POST" action="{{ route('estado-solicitud.consultar') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="est-label">DNI del Estudiante</label>
                        <div class="est-input-wrap">
                            <span class="est-input-icon"><i class="fas fa-id-badge"></i></span>
                            <input type="text" name="dni" class="est-input"
                                   placeholder="Ej: 0801-1990-12345"
                                   value="{{ old('dni', $dni ?? '') }}"
                                   autocomplete="off">
                        </div>
                        <small style="color:#94a3b8;font-size:.7rem;margin-top:.25rem;display:block;">
                            Formato: ####-####-#####
                        </small>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="est-btn w-100">
                            <i class="fas fa-search"></i> Buscar Solicitud
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════
         RESULTADO — MATRÍCULA (flujo principal)
    ═════════════════════════════════════════════════ --}}
    @isset($matricula)
        @php
            $est    = $matricula->estudiante;
            $pad    = $matricula->padre;
            $estado = $matricula->estado;
        @endphp

        {{-- Tracker de pasos --}}
        <div class="est-steps">
            <div class="est-step done">
                <i class="fas fa-paper-plane"></i>Enviada
            </div>
            <div class="est-step {{ in_array($estado, ['aprobada','rechazada']) ? ($estado === 'aprobada' ? 'done' : 'rejected') : 'active' }}">
                <i class="fas fa-clock"></i>En Revisión
            </div>
            <div class="est-step {{ $estado === 'aprobada' ? 'done' : ($estado === 'rechazada' ? 'rejected' : '') }}">
                <i class="fas fa-check-double"></i>Decisión
            </div>
            <div class="est-step {{ $estado === 'aprobada' ? 'done' : '' }}">
                <i class="fas fa-graduation-cap"></i>Matriculado
            </div>
        </div>

        {{-- Estado --}}
        <div class="est-card">
            <div class="est-card-head">
                <i class="fas fa-info-circle"></i>
                <span>Estado · {{ $matricula->codigo_matricula }}</span>
            </div>
            <div class="est-card-body">
                @if($estado === 'aprobada')
                    <div class="est-status status-aprobada">
                        <div class="est-status-icon"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <div class="est-status-title">Matrícula Aprobada</div>
                            <div class="est-status-desc">
                                Aprobada el {{ $matricula->fecha_confirmacion ? \Carbon\Carbon::parse($matricula->fecha_confirmacion)->format('d/m/Y') : '—' }}.
                                Ya puedes acceder al portal del estudiante y del padre/tutor.
                            </div>
                        </div>
                    </div>
                @elseif($estado === 'rechazada')
                    <div class="est-status status-rechazada">
                        <div class="est-status-icon"><i class="fas fa-times-circle"></i></div>
                        <div>
                            <div class="est-status-title">Matrícula Rechazada</div>
                            <div class="est-status-desc">
                                {{ $matricula->motivo_rechazo ?? 'Contacta al administrador para más información.' }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="est-status status-pendiente">
                        <div class="est-status-icon"><i class="fas fa-hourglass-half"></i></div>
                        <div>
                            <div class="est-status-title">Solicitud en Revisión</div>
                            <div class="est-status-desc">
                                Tu solicitud está siendo procesada por el equipo administrativo.
                                Te notificaremos cuando haya una respuesta.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Datos --}}
        <div class="row g-0 g-md-3">
            <div class="col-md-7 mb-3 mb-md-0">
                <div class="est-card mb-0">
                    <div class="est-card-head">
                        <i class="fas fa-user-graduate"></i>
                        <span>Datos del Estudiante</span>
                    </div>
                    <div class="est-card-body">
                        <div class="est-grid est-grid-3">
                            <div class="est-field">
                                <div class="est-field-lbl">Nombre Completo</div>
                                <div class="est-field-val">{{ $est?->nombre_completo ?? '—' }}</div>
                            </div>
                            <div class="est-field">
                                <div class="est-field-lbl">DNI</div>
                                <div class="est-field-val">{{ $est?->dni ?? '—' }}</div>
                            </div>
                            <div class="est-field">
                                <div class="est-field-lbl">Grado</div>
                                <div class="est-field-val">{{ $est?->grado ?? '—' }}</div>
                            </div>
                            <div class="est-field">
                                <div class="est-field-lbl">Nacimiento</div>
                                <div class="est-field-val">
                                    {{ $est?->fecha_nacimiento ? \Carbon\Carbon::parse($est->fecha_nacimiento)->format('d/m/Y') : '—' }}
                                </div>
                            </div>
                            <div class="est-field">
                                <div class="est-field-lbl">Correo</div>
                                <div class="est-field-val">{{ $est?->email ?? '—' }}</div>
                            </div>
                            <div class="est-field">
                                <div class="est-field-lbl">Solicitud</div>
                                <div class="est-field-val">{{ $matricula->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="est-card mb-0">
                    <div class="est-card-head">
                        <i class="fas fa-users"></i>
                        <span>Padre / Tutor</span>
                    </div>
                    <div class="est-card-body">
                        <div class="est-grid">
                            <div class="est-field">
                                <div class="est-field-lbl">Nombre</div>
                                <div class="est-field-val">{{ $pad ? trim($pad->nombre . ' ' . $pad->apellido) : '—' }}</div>
                            </div>
                            <div class="est-field">
                                <div class="est-field-lbl">Teléfono</div>
                                <div class="est-field-val">{{ $pad?->telefono ?? '—' }}</div>
                            </div>
                            <div class="est-field" style="grid-column:1/-1;">
                                <div class="est-field-lbl">Correo</div>
                                <div class="est-field-val">{{ $pad?->correo ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Credenciales (solo si aprobada) --}}
        @if($estado === 'aprobada')
        <div class="est-card mt-3">
            <div class="est-card-head">
                <i class="fas fa-key"></i>
                <span>Credenciales de Acceso al Portal</span>
            </div>
            <div class="est-card-body">
                <p style="font-size:.8rem;color:#64748b;margin-bottom:.9rem;">
                    <i class="fas fa-info-circle me-1" style="color:#4ec7d2;"></i>
                    Usa estas credenciales para iniciar sesión. La contraseña inicial es tu DNI — cámbiala al primer acceso.
                </p>
                <div class="est-credentials">
                    @if($pad?->correo || $est?->email)
                    <div class="est-cred-item">
                        <div class="est-cred-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div class="est-cred-lbl">Correo (padre/tutor)</div>
                            <div class="est-cred-val">{{ $pad?->correo ?? $est?->email ?? '—' }}</div>
                        </div>
                    </div>
                    @endif
                    @if($est?->email)
                    <div class="est-cred-item">
                        <div class="est-cred-icon"><i class="fas fa-user-graduate"></i></div>
                        <div>
                            <div class="est-cred-lbl">Correo (estudiante)</div>
                            <div class="est-cred-val">{{ $est->email }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="est-cred-item">
                        <div class="est-cred-icon"><i class="fas fa-lock"></i></div>
                        <div>
                            <div class="est-cred-lbl">Contraseña inicial</div>
                            <div class="est-cred-val">DNI del estudiante — {{ $est?->dni ?? '—' }}</div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:1rem;text-align:right;">
                    <a href="{{ route('login') }}" class="est-btn">
                        <i class="fas fa-sign-in-alt"></i> Ir al Portal
                    </a>
                </div>
            </div>
        </div>
        @endif

    {{-- ════════════════════════════════════════════════
         RESULTADO — SOLICITUD (flujo antiguo)
    ═════════════════════════════════════════════════ --}}
    @elseif(isset($solicitud) && $solicitud)
        @php
            $est    = $solicitud->estudiante;
            $estado = $solicitud->estado;
        @endphp

        <div class="est-card">
            <div class="est-card-head">
                <i class="fas fa-info-circle"></i>
                <span>Estado · {{ $solicitud->codigo }}</span>
            </div>
            <div class="est-card-body">
                @if($estado === 'aprobada')
                    <div class="est-status status-aprobada">
                        <div class="est-status-icon"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <div class="est-status-title">Solicitud Aprobada</div>
                            <div class="est-status-desc">La solicitud de matrícula ha sido aprobada exitosamente.</div>
                        </div>
                    </div>
                @elseif($estado === 'rechazada')
                    <div class="est-status status-rechazada">
                        <div class="est-status-icon"><i class="fas fa-times-circle"></i></div>
                        <div>
                            <div class="est-status-title">Solicitud Rechazada</div>
                            <div class="est-status-desc">Contacta al administrador para más información.</div>
                        </div>
                    </div>
                @else
                    <div class="est-status status-pendiente">
                        <div class="est-status-icon"><i class="fas fa-hourglass-half"></i></div>
                        <div>
                            <div class="est-status-title">En Revisión</div>
                            <div class="est-status-desc">Tu solicitud está siendo procesada.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="est-card">
            <div class="est-card-head">
                <i class="fas fa-user-graduate"></i>
                <span>Datos del Estudiante</span>
            </div>
            <div class="est-card-body">
                <div class="est-grid">
                    <div class="est-field">
                        <div class="est-field-lbl">Nombre Completo</div>
                        <div class="est-field-val">{{ $est?->nombre_completo ?? '—' }}</div>
                    </div>
                    <div class="est-field">
                        <div class="est-field-lbl">DNI</div>
                        <div class="est-field-val">{{ $est?->dni ?? '—' }}</div>
                    </div>
                    <div class="est-field">
                        <div class="est-field-lbl">Correo</div>
                        <div class="est-field-val">{{ $solicitud->email ?? $est?->email ?? '—' }}</div>
                    </div>
                    <div class="est-field">
                        <div class="est-field-lbl">Fecha de Solicitud</div>
                        <div class="est-field-val">{{ $solicitud->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

    @endif

</div>
@endsection
