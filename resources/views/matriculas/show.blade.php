@extends('layouts.app')

@section('title', 'Detalles de Matrícula')
@section('page-title', 'Detalles de Matrícula')

@section('topbar-actions')
    <a href="{{ route('matriculas.edit', $matricula->id) }}"
       style="background:linear-gradient(135deg,#f59e0b,#d97706); color:white;
              padding:.6rem .75rem; border-radius:9px; font-size:.83rem; font-weight:600;
              display:inline-flex; align-items:center; gap:.4rem;
              text-decoration:none; border:none; transition:all .2s;">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="{{ route('matriculas.index') }}"
       style="background:white; color:#00508f;
              padding:.6rem .75rem; border-radius:9px; font-size:.83rem; font-weight:600;
              display:inline-flex; align-items:center; gap:.4rem;
              text-decoration:none; border:1.5px solid #00508f; transition:all .2s;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */
:root {
    --blue-dark:  #003b73;
    --blue-mid:   #00508f;
    --cyan:       #4ec7d2;
    --cyan-light: rgba(78,199,210,.1);
    --cyan-border:#b2e8ed;
    --red:        #ef4444;
    --surface:    #f5f8fc;
    --border:     #e8edf4;
    --text:       #0d2137;
    --muted:      #6b7a90;
    --subtle:     #94a3b8;
}

/* ── Wrapper ── */
.show-wrap {
    width: 100%;                          /* ← ocupa todo el ancho como el perfil */
    display: flex;
    flex-direction: column;
    gap: 0;                               /* secciones sin gap, separadas por border */
}

/* ── Header principal ── */
.profile-header-inner {
    border-radius: 14px 14px 0 0;        /* ← REDONDEZ header */
    background: linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
    padding: 2rem 1.7rem;                 /* ← PADDING header */
    position: relative; overflow: hidden;
    display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-wrap: wrap;
}

/* burbujas decorativas */
.profile-header-inner::after {
    content:''; position:absolute; right:-50px; top:-50px;
    width:200px; height:200px; border-radius:50%;
    background:rgba(78,199,210,.13); pointer-events:none;
}
.profile-header-inner::before {
    content:''; position:absolute; right:100px; bottom:-45px;
    width:120px; height:120px; border-radius:50%;
    background:rgba(255,255,255,.05); pointer-events:none;
}

.profile-header-left { display:flex; align-items:center; gap:1rem; position:relative; z-index:1; }

.profile-icon {
    width: 80px; height: 80px;           /* ← TAMAÑO ícono header */
    border-radius: 18px; flex-shrink: 0;
    background: rgba(255,255,255,.12);
    border: 3px solid rgba(78,199,210,.7);
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; color: #fff;        /* ← TAMAÑO ícono interno */
    box-shadow: 0 6px 20px rgba(0,0,0,.25);
}

.profile-codigo {
    font-size: 1.45rem;                  /* ← TAMAÑO código matrícula */
    font-weight: 800; color: white;
    margin: 0 0 .4rem;
    text-shadow: 0 1px 4px rgba(0,0,0,.2);
    position: relative; z-index: 1;
}

.profile-fecha {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .65rem; border-radius: 999px;
    background: rgba(255,255,255,.14); color: rgba(255,255,255,.92);
    font-size: .72rem; font-weight: 600; /* ← TAMAÑO fecha tag */
    border: 1px solid rgba(255,255,255,.18);
    position: relative; z-index: 1;
}

/* ── Estado badges ── */
.estado-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .3rem .95rem; border-radius: 999px;
    font-size: .76rem; font-weight: 700; /* ← TAMAÑO texto badge estado */
    white-space: nowrap; letter-spacing: .03em;
    position: relative; z-index: 1;
}
.estado-aprobada  { background: white; color: #166534; border: 2px solid #86efac; }
.estado-pendiente { background: white; color: #854d0e; border: 2px solid #fde047; }
.estado-rechazada { background: white; color: #991b1b; border: 2px solid #fca5a5; }
.estado-cancelada { background: white; color: var(--muted); border: 2px solid var(--border); }

/* ── Motivo rechazo ── */
.motivo-alert {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .9rem 1.7rem;
    background: rgba(239,68,68,.06);
    border-top: 1px solid rgba(239,68,68,.15);
    font-size: .83rem; color: #991b1b;   /* ← TAMAÑO texto motivo rechazo */
}
.motivo-alert i { color: var(--red); margin-top: .05rem; flex-shrink: 0; }

/* ── Body del card ── */
.show-body {
    background: white;
    border: 1px solid var(--border); border-top: none;
    border-radius: 0 0 14px 14px;
    box-shadow: 0 2px 16px rgba(0,59,115,.09);
    overflow: hidden;
}

/* ── Secciones internas ── */
.sm-sec {
    padding: 1.4rem 1.7rem;              /* ← PADDING secciones */
    border-bottom: 1px solid #f0f4f9;
}
.sm-sec:last-child { border-bottom: none; }

/* ── Título de sección ── */
.sm-sec-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700; /* ← TAMAÑO títulos de sección */
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--blue-mid);
    margin-bottom: .95rem; padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.1);
}
.sm-sec-title i { color: var(--cyan); font-size: .88rem; }

/* ── Two-column layout ── */
.two-col {
    display: grid; grid-template-columns: 1fr 1fr; gap: 0;
    border-bottom: 1px solid #f0f4f9;
}
.two-col > div:first-child {
    border-right: 1px solid #f0f4f9;
}
@media(max-width:720px) {
    .two-col { grid-template-columns: 1fr; }
    .two-col > div:first-child { border-right: none; border-bottom: 1px solid #f0f4f9; }
}

/* ── Info items ── */
.info-item {
    padding-bottom: .85rem;
    margin-bottom: .85rem;
    border-bottom: 1px solid #f0f4f9;
}
.info-item:last-child { padding-bottom: 0; margin-bottom: 0; border-bottom: none; }

.info-label {
    font-size: .63rem; font-weight: 700;  /* ← TAMAÑO labels */
    letter-spacing: .08em; text-transform: uppercase;
    color: var(--subtle); margin-bottom: .22rem;
    display: flex; align-items: center; gap: .28rem;
}
.info-label i { color: var(--cyan); font-size: .68rem; }

.info-value {
    font-size: .88rem; font-weight: 600;  /* ← TAMAÑO valores */
    color: var(--text); padding-left: 1rem; line-height: 1.4;
}
.info-value.empty { color: var(--subtle); font-weight: 400; font-style: italic; font-size: .83rem; }
.info-value.mono  {
    font-family: 'Courier New', monospace; font-size: .85rem;
    color: var(--blue-mid);
    background: rgba(0,80,143,.07); padding: .15rem .45rem;
    border-radius: 5px; display: inline-block;
}

/* ── Documentos grid ── */
.docs-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: .75rem;
}
@media(max-width:900px) { .docs-grid { grid-template-columns: repeat(3,1fr); } }
@media(max-width:500px) { .docs-grid { grid-template-columns: repeat(2,1fr); } }

.doc-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 1.1rem .75rem;
    text-align: center;
    display: flex; flex-direction: column;
    align-items: center; gap: .55rem;
    transition: border-color .15s, box-shadow .15s, transform .15s;
}
.doc-card:hover {
    border-color: var(--cyan-border);
    box-shadow: 0 4px 12px rgba(78,199,210,.15);
    transform: translateY(-2px);
}
.doc-card-icon {
    width: 42px; height: 42px; border-radius: 9px;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .9rem;       /* ← TAMAÑO ícono documento */
    box-shadow: 0 2px 8px rgba(78,199,210,.3);
}
.doc-card-name {
    font-size: .72rem; font-weight: 700; /* ← TAMAÑO nombre documento */
    color: var(--blue-dark); line-height: 1.3;
    min-height: 28px;
    display: flex; align-items: center; justify-content: center;
}
.doc-btn {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .28rem .65rem; border-radius: 6px;
    font-size: .7rem; font-weight: 700;  /* ← TAMAÑO botón ver/descargar */
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    color: #fff; text-decoration: none;
    box-shadow: 0 1px 4px rgba(78,199,210,.3);
    transition: opacity .15s;
}
.doc-btn:hover { opacity: .85; color: #fff; }
.doc-empty {
    font-size: .7rem; color: var(--subtle); font-style: italic; /* ← TAMAÑO "No adjuntado" */
}

/* ── Observaciones ── */
.obs-title {
    font-size: .75rem; font-weight: 700; /* ← TAMAÑO título observaciones */
    color: #92400e; text-transform: uppercase;
    letter-spacing: .08em; margin-bottom: .65rem;
    display: flex; align-items: center; gap: .4rem;
    padding-left: .5rem;
    border-left: 3.5px solid #f59e0b;
}
.obs-text {
    font-size: .88rem; color: var(--muted); /* ← TAMAÑO texto observaciones */
    line-height: 1.65; margin: 0;
}

/* ── Sistema footer ── */
.sistema-wrap {
    display: flex; gap: 1.5rem; flex-wrap: wrap;
    background: var(--surface);
    border-top: 1px solid var(--border);
    padding: .9rem 1.7rem;
    border-radius: 0 0 14px 14px;
}
.sistema-item {
    display: flex; align-items: center; gap: .5rem;
    font-size: .78rem; color: var(--muted); /* ← TAMAÑO texto sistema */
}
.sistema-item i { color: var(--cyan); }
.sistema-item strong { color: var(--blue-dark); }
</style>
@endpush

@section('content')
<div class="show-wrap">

    {{-- ═══════════════════════════════════
         Header: Código + Estado
    ═══════════════════════════════════ --}}
    <div>
        <div class="profile-header-inner">
            <div class="profile-header-left">
                <div class="profile-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div>
                    <p class="profile-codigo">{{ $matricula->codigo_matricula }}</p>
                    <span class="profile-fecha">
                        <i class="fas fa-calendar"></i>
                        Registrada el {{ $matricula->fecha_matricula
                            ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y')
                            : 'N/A' }}
                    </span>
                </div>
            </div>

            @php
                $estadoClass = match($matricula->estado) {
                    'aprobada'  => 'estado-aprobada',
                    'pendiente' => 'estado-pendiente',
                    'rechazada' => 'estado-rechazada',
                    default     => 'estado-cancelada',
                };
                $estadoIcon = match($matricula->estado) {
                    'aprobada'  => 'fa-check-circle',
                    'pendiente' => 'fa-clock',
                    'rechazada' => 'fa-times-circle',
                    default     => 'fa-question-circle',
                };
            @endphp

            <span class="estado-badge {{ $estadoClass }}">
                <i class="fas {{ $estadoIcon }}"></i>
                {{ strtoupper($matricula->estado) }}
            </span>
        </div>

        {{-- ── BODY ── --}}
        <div class="show-body">

            @if($matricula->estado === 'rechazada' && $matricula->motivo_rechazo)
            <div class="motivo-alert">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Motivo del rechazo:</strong>
                    <p style="margin:.2rem 0 0; color:#64748b;">{{ $matricula->motivo_rechazo }}</p>
                </div>
            </div>
            @endif

            {{-- ═══════════════════════════════════
                 Estudiante + Padre/Tutor (2 cols)
            ═══════════════════════════════════ --}}
            <div class="two-col">

                {{-- Estudiante --}}
                <div class="sm-sec">
                    <div class="sm-sec-title">
                        <i class="fas fa-user-graduate"></i> Información del Estudiante
                    </div>
                    @if($matricula->estudiante)
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-user"></i> Nombre Completo</div>
                            <div class="info-value">{{ $matricula->estudiante->nombre }} {{ $matricula->estudiante->apellido }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-id-card"></i> DNI</div>
                            <div class="info-value mono">{{ $matricula->estudiante->dni ?? '—' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-birthday-cake"></i> Fecha de Nacimiento</div>
                            <div class="info-value">
                                {{ $matricula->estudiante->fecha_nacimiento
                                    ? \Carbon\Carbon::parse($matricula->estudiante->fecha_nacimiento)->format('d/m/Y')
                                    : 'No registrada' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-venus-mars"></i> Sexo</div>
                            <div class="info-value">{{ ucfirst($matricula->estudiante->sexo ?? 'No especificado') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-graduation-cap"></i> Grado y Sección</div>
                            <div class="info-value">{{ $matricula->estudiante->grado ?? 'N/A' }} — Sección {{ $matricula->estudiante->seccion ?? 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-map-marker-alt"></i> Dirección</div>
                            <div class="info-value {{ !$matricula->estudiante->direccion ? 'empty' : '' }}">
                                {{ $matricula->estudiante->direccion ?? 'No registrada' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-phone"></i> Teléfono</div>
                            <div class="info-value {{ !$matricula->estudiante->telefono ? 'empty' : '' }}">
                                {{ $matricula->estudiante->telefono ?? 'No registrado' }}
                            </div>
                        </div>
                    @else
                        <div style="text-align:center; padding:2rem; color:var(--subtle);">
                            <i class="fas fa-exclamation-circle"
                               style="font-size:2rem; display:block; margin-bottom:.75rem; color:var(--border);"></i>
                            No hay información del estudiante disponible
                        </div>
                    @endif
                </div>

                {{-- Padre/Tutor --}}
                <div class="sm-sec">
                    <div class="sm-sec-title">
                        <i class="fas fa-user-friends"></i> Información del Padre/Tutor
                    </div>
                    @if($matricula->padre)
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-user"></i> Nombre Completo</div>
                            <div class="info-value">{{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-id-card"></i> DNI</div>
                            <div class="info-value mono">{{ $matricula->padre->dni ?? '—' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-users"></i> Parentesco</div>
                            <div class="info-value">{{ $matricula->padre->parentesco_formateado ?? ucfirst($matricula->padre->parentesco) }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-envelope"></i> Correo</div>
                            <div class="info-value {{ !$matricula->padre->correo ? 'empty' : '' }}">
                                {{ $matricula->padre->correo ?? 'No registrado' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-phone"></i> Teléfono</div>
                            <div class="info-value {{ !$matricula->padre->telefono ? 'empty' : '' }}">
                                {{ $matricula->padre->telefono ?? 'No registrado' }}
                            </div>
                        </div>
                        @if($matricula->padre->telefono_secundario)
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-phone-alt"></i> Teléfono Secundario</div>
                            <div class="info-value">{{ $matricula->padre->telefono_secundario }}</div>
                        </div>
                        @endif
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-map-marker-alt"></i> Dirección</div>
                            <div class="info-value {{ !$matricula->padre->direccion ? 'empty' : '' }}">
                                {{ $matricula->padre->direccion ?? 'No registrada' }}
                            </div>
                        </div>
                        @if($matricula->padre->ocupacion)
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-briefcase"></i> Ocupación</div>
                            <div class="info-value">{{ $matricula->padre->ocupacion }}</div>
                        </div>
                        @endif
                    @else
                        <div style="text-align:center; padding:2rem; color:var(--subtle);">
                            <i class="fas fa-exclamation-circle"
                               style="font-size:2rem; display:block; margin-bottom:.75rem; color:var(--border);"></i>
                            No hay información del padre/tutor disponible
                        </div>
                    @endif
                </div>

            </div>{{-- fin two-col --}}

            {{-- ═══════════════════════════════════
                 Documentos Adjuntos
            ═══════════════════════════════════ --}}
            <div class="sm-sec">
                <div class="sm-sec-title">
                    <i class="fas fa-paperclip"></i> Documentos Adjuntos
                </div>
                <div class="docs-grid">

                    <div class="doc-card">
                        <div class="doc-card-icon"><i class="fas fa-camera"></i></div>
                        <div class="doc-card-name">Foto del Estudiante</div>
                        @if($matricula->foto_estudiante)
                            <a href="{{ asset('storage/'.$matricula->foto_estudiante) }}" target="_blank" class="doc-btn">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            <span class="doc-empty">No adjuntado</span>
                        @endif
                    </div>

                    <div class="doc-card">
                        <div class="doc-card-icon"><i class="fas fa-file-alt"></i></div>
                        <div class="doc-card-name">Acta de Nacimiento</div>
                        @if($matricula->acta_nacimiento)
                            <a href="{{ asset('storage/'.$matricula->acta_nacimiento) }}" target="_blank" class="doc-btn">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        @else
                            <span class="doc-empty">No adjuntado</span>
                        @endif
                    </div>

                    <div class="doc-card">
                        <div class="doc-card-icon"><i class="fas fa-certificate"></i></div>
                        <div class="doc-card-name">Certificado de Estudios</div>
                        @if($matricula->certificado_estudios)
                            <a href="{{ asset('storage/'.$matricula->certificado_estudios) }}" target="_blank" class="doc-btn">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        @else
                            <span class="doc-empty">No adjuntado</span>
                        @endif
                    </div>

                    <div class="doc-card">
                        <div class="doc-card-icon"><i class="fas fa-award"></i></div>
                        <div class="doc-card-name">Constancia de Conducta</div>
                        @if($matricula->constancia_conducta)
                            <a href="{{ asset('storage/'.$matricula->constancia_conducta) }}" target="_blank" class="doc-btn">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        @else
                            <span class="doc-empty">No adjuntado</span>
                        @endif
                    </div>

                    <div class="doc-card">
                        <div class="doc-card-icon"><i class="fas fa-id-card"></i></div>
                        <div class="doc-card-name">DNI Estudiante</div>
                        @if($matricula->foto_dni_estudiante)
                            <a href="{{ asset('storage/'.$matricula->foto_dni_estudiante) }}" target="_blank" class="doc-btn">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            <span class="doc-empty">No adjuntado</span>
                        @endif
                    </div>

                    <div class="doc-card">
                        <div class="doc-card-icon"><i class="fas fa-id-card-alt"></i></div>
                        <div class="doc-card-name">DNI Padre/Tutor</div>
                        @if($matricula->foto_dni_padre)
                            <a href="{{ asset('storage/'.$matricula->foto_dni_padre) }}" target="_blank" class="doc-btn">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        @else
                            <span class="doc-empty">No adjuntado</span>
                        @endif
                    </div>

                </div>
            </div>{{-- fin documentos --}}

            {{-- ═══════════════════════════════════
                 Observaciones (condicional)
            ═══════════════════════════════════ --}}
            @if($matricula->observaciones)
            <div class="sm-sec">
                <div class="obs-title">
                    <i class="fas fa-sticky-note"></i> Observaciones
                </div>
                <p class="obs-text">{{ $matricula->observaciones }}</p>
            </div>
            @endif

            {{-- ═══════════════════════════════════
                 Datos del Sistema
            ═══════════════════════════════════ --}}
            <div class="sistema-wrap">
                <div class="sistema-item">
                    <i class="fas fa-calendar-plus"></i>
                    <span><strong>Creado:</strong> {{ $matricula->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                </div>
                <div class="sistema-item">
                    <i class="fas fa-calendar-check"></i>
                    <span><strong>Última actualización:</strong> {{ $matricula->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                </div>
            </div>

        </div>{{-- fin show-body --}}
    </div>

</div>{{-- fin show-wrap --}}
@endsection
