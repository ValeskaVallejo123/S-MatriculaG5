@extends('layouts.app')

@section('title', 'Detalles de Matrícula')
@section('page-title', 'Detalles de Matrícula')

@section('topbar-actions')
    <a href="{{ route('matriculas.edit', $matricula->id) }}" class="adm-btn-solid" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="{{ route('matriculas.index') }}" class="adm-btn-outline">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
    --blue-dark:  #003b73;
    --blue-mid:   #00508f;
    --cyan:       #4ec7d2;
    --cyan-light: #e8f8f9;
    --cyan-border:#b2e8ed;
    --red:        #ef4444;
    --surface:    #f8fafc;
    --border:     #e2e8f0;
    --text:       #0f172a;
    --muted:      #64748b;
    --subtle:     #94a3b8;
}

.show-wrap {
    font-family: 'Inter', sans-serif;
    max-width: 960px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* ── Topbar buttons ── */
.adm-btn-solid {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px;
    font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    color: #fff; border: none; text-decoration: none;
    transition: opacity .15s; margin-right: .35rem;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }
.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px;
    font-size: .82rem; font-weight: 600;
    background: #fff; color: var(--blue-mid);
    border: 1.5px solid var(--cyan); text-decoration: none;
    transition: background .15s;
}
.adm-btn-outline:hover { background: var(--cyan-light); color: var(--blue-dark); }

/* ── Card base ── */
.sm-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    overflow: hidden;
}
.sm-card-header {
    display: flex; align-items: center; gap: .6rem;
    padding: .95rem 1.35rem;
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    font-size: .82rem; font-weight: 700; color: #fff;
}
.sm-card-header i { color: var(--cyan); }
.sm-card-body { padding: 1.35rem; }

/* ── Profile header card ── */
.profile-header-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    overflow: hidden;
}
.profile-header-inner {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    padding: 1.5rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    flex-wrap: wrap;
}
.profile-header-left {
    display: flex; align-items: center; gap: 1rem;
}
.profile-icon {
    width: 56px; height: 56px; border-radius: 12px; flex-shrink: 0;
    background: rgba(255,255,255,.15);
    border: 2.5px solid var(--cyan);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,.2);
}
.profile-codigo { font-size: 1.1rem; font-weight: 700; color: #fff; margin: 0 0 .2rem; }
.profile-fecha  { font-size: .78rem; color: rgba(255,255,255,.7); margin: 0; }

/* ── Estado badges ── */
.estado-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1.1rem; border-radius: 999px;
    font-size: .78rem; font-weight: 700; white-space: nowrap;
    letter-spacing: .03em;
}
.estado-aprobada  { background: #f0fdf4; color: #166534; border: 1.5px solid #86efac; }
.estado-pendiente { background: #fefce8; color: #854d0e; border: 1.5px solid #fde047; }
.estado-rechazada { background: #fef2f2; color: #991b1b; border: 1.5px solid #fca5a5; }
.estado-cancelada { background: var(--surface); color: var(--muted); border: 1.5px solid var(--border); }

/* ── Motivo rechazo ── */
.motivo-alert {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .9rem 1.35rem;
    background: rgba(239,68,68,.06);
    border-top: 1px solid rgba(239,68,68,.15);
    font-size: .84rem; color: #991b1b;
}
.motivo-alert i { color: var(--red); margin-top: .05rem; flex-shrink: 0; }

/* ── Two-column layout ── */
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
@media(max-width: 720px) { .two-col { grid-template-columns: 1fr; } }

/* ── Info items ── */
.info-item {
    padding-bottom: 1rem;
    margin-bottom: 1rem;
    border-bottom: 1px solid var(--border);
}
.info-item:last-child { padding-bottom: 0; margin-bottom: 0; border-bottom: none; }

.info-label {
    font-size: .67rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: var(--subtle); margin-bottom: .25rem;
    display: flex; align-items: center; gap: .35rem;
}
.info-label i { color: var(--cyan); width: 12px; text-align: center; }

.info-value {
    font-size: .875rem; font-weight: 600;
    color: var(--text); padding-left: 1.1rem;
}
.info-value.empty { color: var(--subtle); font-weight: 400; font-style: italic; }
.info-value.mono  { font-family: monospace; color: var(--blue-mid); }

/* ── Documentos grid ── */
.docs-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: .75rem;
}
@media(max-width: 900px) { .docs-grid { grid-template-columns: repeat(3, 1fr); } }
@media(max-width: 500px) { .docs-grid { grid-template-columns: repeat(2, 1fr); } }

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
.doc-card:hover { border-color: var(--cyan-border); box-shadow: 0 4px 12px rgba(78,199,210,.15); transform: translateY(-2px); }
.doc-card-icon {
    width: 42px; height: 42px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .9rem;
    box-shadow: 0 2px 8px rgba(78,199,210,.3);
}
.doc-card-name {
    font-size: .72rem; font-weight: 700; color: var(--blue-dark);
    line-height: 1.3; min-height: 28px;
    display: flex; align-items: center; justify-content: center;
}
.doc-btn {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .28rem .65rem; border-radius: 6px;
    font-size: .7rem; font-weight: 700;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    color: #fff; text-decoration: none;
    box-shadow: 0 1px 4px rgba(78,199,210,.3);
    transition: opacity .15s;
}
.doc-btn:hover { opacity: .85; color: #fff; }
.doc-empty {
    font-size: .7rem; color: var(--subtle); font-style: italic;
}

/* ── Observaciones ── */
.obs-card {
    background: #fff;
    border: 1px solid var(--border);
    border-left: 3.5px solid #f59e0b;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    padding: 1.1rem 1.35rem;
}
.obs-title {
    font-size: .78rem; font-weight: 700; color: #92400e;
    text-transform: uppercase; letter-spacing: .07em;
    margin-bottom: .65rem;
    display: flex; align-items: center; gap: .4rem;
}
.obs-text { font-size: .875rem; color: var(--muted); line-height: 1.65; margin: 0; }

/* ── Sistema footer ── */
.sistema-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    padding: .9rem 1.35rem;
    display: flex; gap: 1.5rem; flex-wrap: wrap;
}
.sistema-item {
    display: flex; align-items: center; gap: .5rem;
    font-size: .78rem; color: var(--muted);
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
    <div class="profile-header-card">
        <div class="profile-header-inner">
            <div class="profile-header-left">
                <div class="profile-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div>
                    <p class="profile-codigo">{{ $matricula->codigo_matricula }}</p>
                    <p class="profile-fecha">
                        <i class="fas fa-calendar" style="margin-right:.3rem;"></i>
                        Registrada el {{ $matricula->fecha_matricula ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') : 'N/A' }}
                    </p>
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

        @if($matricula->estado === 'rechazada' && $matricula->motivo_rechazo)
        <div class="motivo-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Motivo del rechazo:</strong>
                <p style="margin:.2rem 0 0; color:#64748b;">{{ $matricula->motivo_rechazo }}</p>
            </div>
        </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════
         Estudiante + Padre/Tutor (2 cols)
    ═══════════════════════════════════ --}}
    <div class="two-col">

        {{-- Estudiante --}}
        <div class="sm-card">
            <div class="sm-card-header">
                <i class="fas fa-user-graduate"></i> Información del Estudiante
            </div>
            <div class="sm-card-body">
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
                        <div class="info-value {{ !$matricula->estudiante->direccion ? 'empty' : '' }}">{{ $matricula->estudiante->direccion ?? 'No registrada' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-phone"></i> Teléfono</div>
                        <div class="info-value {{ !$matricula->estudiante->telefono ? 'empty' : '' }}">{{ $matricula->estudiante->telefono ?? 'No registrado' }}</div>
                    </div>
                @else
                    <div style="text-align:center; padding:2rem; color:var(--subtle);">
                        <i class="fas fa-exclamation-circle" style="font-size:2rem; display:block; margin-bottom:.75rem; color:var(--border);"></i>
                        No hay información del estudiante disponible
                    </div>
                @endif
            </div>
        </div>

        {{-- Padre/Tutor --}}
        <div class="sm-card">
            <div class="sm-card-header">
                <i class="fas fa-user-friends"></i> Información del Padre/Tutor
            </div>
            <div class="sm-card-body">
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
                        <div class="info-value {{ !$matricula->padre->correo ? 'empty' : '' }}">{{ $matricula->padre->correo ?? 'No registrado' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-phone"></i> Teléfono</div>
                        <div class="info-value {{ !$matricula->padre->telefono ? 'empty' : '' }}">{{ $matricula->padre->telefono ?? 'No registrado' }}</div>
                    </div>
                    @if($matricula->padre->telefono_secundario)
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-phone-alt"></i> Teléfono Secundario</div>
                        <div class="info-value">{{ $matricula->padre->telefono_secundario }}</div>
                    </div>
                    @endif
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-map-marker-alt"></i> Dirección</div>
                        <div class="info-value {{ !$matricula->padre->direccion ? 'empty' : '' }}">{{ $matricula->padre->direccion ?? 'No registrada' }}</div>
                    </div>
                    @if($matricula->padre->ocupacion)
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-briefcase"></i> Ocupación</div>
                        <div class="info-value">{{ $matricula->padre->ocupacion }}</div>
                    </div>
                    @endif
                @else
                    <div style="text-align:center; padding:2rem; color:var(--subtle);">
                        <i class="fas fa-exclamation-circle" style="font-size:2rem; display:block; margin-bottom:.75rem; color:var(--border);"></i>
                        No hay información del padre/tutor disponible
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════
         Documentos Adjuntos
    ═══════════════════════════════════ --}}
    <div class="sm-card">
        <div class="sm-card-header">
            <i class="fas fa-paperclip"></i> Documentos Adjuntos
        </div>
        <div class="sm-card-body">
            <div class="docs-grid">

                <div class="doc-card">
                    <div class="doc-card-icon"><i class="fas fa-camera"></i></div>
                    <div class="doc-card-name">Foto del Estudiante</div>
                    @if($matricula->foto_estudiante)
                        <a href="{{ asset('storage/' . $matricula->foto_estudiante) }}" target="_blank" class="doc-btn">
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
                        <a href="{{ asset('storage/' . $matricula->acta_nacimiento) }}" target="_blank" class="doc-btn">
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
                        <a href="{{ asset('storage/' . $matricula->certificado_estudios) }}" target="_blank" class="doc-btn">
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
                        <a href="{{ asset('storage/' . $matricula->constancia_conducta) }}" target="_blank" class="doc-btn">
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
                        <a href="{{ asset('storage/' . $matricula->foto_dni_estudiante) }}" target="_blank" class="doc-btn">
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
                        <a href="{{ asset('storage/' . $matricula->foto_dni_padre) }}" target="_blank" class="doc-btn">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                    @else
                        <span class="doc-empty">No adjuntado</span>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════
         Observaciones (condicional)
    ═══════════════════════════════════ --}}
    @if($matricula->observaciones)
    <div class="obs-card">
        <div class="obs-title"><i class="fas fa-sticky-note"></i> Observaciones</div>
        <p class="obs-text">{{ $matricula->observaciones }}</p>
    </div>
    @endif

    {{-- ═══════════════════════════════════
         Datos del Sistema
    ═══════════════════════════════════ --}}
    <div class="sistema-card">
        <div class="sistema-item">
            <i class="fas fa-calendar-plus"></i>
            <span><strong>Creado:</strong> {{ $matricula->created_at ? $matricula->created_at->format('d/m/Y H:i') : 'N/A' }}</span>
        </div>
        <div class="sistema-item">
            <i class="fas fa-calendar-check"></i>
            <span><strong>Última actualización:</strong> {{ $matricula->updated_at ? $matricula->updated_at->format('d/m/Y H:i') : 'N/A' }}</span>
        </div>
    </div>

</div>
@endsection