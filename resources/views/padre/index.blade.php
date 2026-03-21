@extends('layouts.app')

@section('title', 'Detalle del Estudiante')
@section('page-title', 'Detalle del Estudiante')

@section('topbar-actions')
    <a href="{{ route('padre.dashboard') }}"
       style="background:white;color:#00508f;padding:.5rem 1.2rem;border-radius:8px;
              text-decoration:none;font-weight:600;display:inline-flex;align-items:center;
              gap:.5rem;border:2px solid #00508f;font-size:.9rem;">
        <i class="fas fa-arrow-left"></i> Volver al Portal
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

:root {
    --blue-dark:  #003b73;
    --blue-mid:   #00508f;
    --cyan:       #4ec7d2;
    --cyan-light: rgba(78,199,210,.1);
    --cyan-border:#b2e8ed;
    --surface:    #f5f7fa;
    --border:     #e2e8f0;
    --text:       #0f172a;
    --muted:      #64748b;
    --subtle:     #94a3b8;
    --radius:     12px;
    --shadow:     0 1px 4px rgba(0,59,115,.07);
    --shadow-md:  0 4px 16px rgba(0,59,115,.1);
}

.hijo-wrap {
    font-family:'Inter',sans-serif;
    width:100%;
    display:flex;
    flex-direction:column;
    gap:1.25rem;
}

/* ══ BANNER ══ */
.hijo-banner {
    background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue-mid) 55%,var(--cyan) 100%);
    border-radius:var(--radius);
    padding:1.5rem 2rem;
    display:flex; align-items:center; gap:1.5rem;
    box-shadow:0 4px 20px rgba(0,59,115,.2);
    position:relative; overflow:hidden;
}
.hijo-banner::before {
    content:''; position:absolute; top:-50%; right:-3%;
    width:220px; height:220px; background:rgba(255,255,255,.07); border-radius:50%;
}
.hijo-banner::after {
    content:''; position:absolute; bottom:-55%; right:15%;
    width:150px; height:150px; background:rgba(255,255,255,.04); border-radius:50%;
}
.hijo-banner-av {
    width:72px; height:72px; border-radius:16px; flex-shrink:0;
    background:rgba(255,255,255,.15); border:2.5px solid rgba(255,255,255,.35);
    display:flex; align-items:center; justify-content:center;
    font-size:1.6rem; font-weight:800; color:#fff;
    position:relative; z-index:1; overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,.2);
}
.hijo-banner-av img { width:100%; height:100%; object-fit:cover; }
.hijo-banner-info { position:relative; z-index:1; flex:1; }
.hijo-banner-info h3 { color:#fff; font-weight:800; margin:0 0 .25rem; font-size:1.3rem; }
.hijo-banner-info p  { color:rgba(255,255,255,.72); font-size:.82rem; margin:0 0 .65rem; }
.hijo-banner-tags { display:flex; flex-wrap:wrap; gap:.4rem; }
.h-tag {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.22rem .75rem; border-radius:999px; font-size:.72rem; font-weight:600;
}
.tag-cyan  { background:rgba(78,199,210,.3);  color:#fff; border:1px solid rgba(78,199,210,.5); }
.tag-white { background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.28); }
.tag-green { background:rgba(16,185,129,.28);  color:#fff; border:1px solid rgba(16,185,129,.5); }

/* ══ STATS ══ */
.hijo-stats {
    display:grid; grid-template-columns:repeat(3,1fr); gap:1rem;
}
@media(max-width:768px){ .hijo-stats { grid-template-columns:1fr 1fr; } }
@media(max-width:480px){ .hijo-stats { grid-template-columns:1fr; } }

.h-stat {
    background:#fff; border:1px solid var(--border); border-radius:var(--radius);
    padding:1.1rem 1.25rem; display:flex; align-items:center; gap:1rem;
    box-shadow:var(--shadow); position:relative; overflow:hidden;
    transition:box-shadow .15s,transform .15s;
}
.h-stat:hover { box-shadow:var(--shadow-md); transform:translateY(-2px); }
.h-stat-stripe {
    position:absolute; left:0; top:0; bottom:0;
    width:4px; border-radius:var(--radius) 0 0 var(--radius);
}
.h-stat-icon {
    width:44px; height:44px; border-radius:11px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:1.05rem;
}
.h-stat-lbl { font-size:.68rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.15rem; }
.h-stat-val { font-size:1rem; font-weight:800; color:var(--blue-dark); line-height:1.2; }

/* ══ SECTION CARD ══ */
.sec-card {
    background:#fff; border:1px solid var(--border); border-radius:var(--radius);
    overflow:hidden; box-shadow:var(--shadow);
}
.sec-head {
    background:var(--blue-dark); padding:.85rem 1.25rem;
    display:flex; align-items:center; justify-content:space-between;
}
.sec-head-left { display:flex; align-items:center; gap:.6rem; }
.sec-head i    { color:var(--cyan); font-size:1rem; }
.sec-head span { color:#fff; font-weight:700; font-size:.95rem; }
.sec-head-badge {
    padding:.2rem .7rem; border-radius:999px; font-size:.72rem; font-weight:700;
    background:rgba(78,199,210,.25); color:#fff; border:1px solid rgba(78,199,210,.4);
}

/* ══ DATOS PERSONALES ══ */
.pf-grid {
    display:grid; grid-template-columns:1fr 1fr; gap:.65rem; padding:1rem;
}
@media(max-width:500px){ .pf-grid { grid-template-columns:1fr; } }
.pf-box {
    background:var(--surface); border-radius:8px;
    border-left:3px solid var(--cyan); padding:.55rem .8rem;
}
.pf-label { font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--subtle); margin-bottom:.15rem; }
.pf-value { font-size:.82rem; font-weight:600; color:var(--text); }
.pf-value.empty { color:var(--subtle); font-style:italic; font-weight:400; }

/* ══ OBSERVACIONES ══ */
.obs-list { padding:.75rem 1rem; display:flex; flex-direction:column; gap:.5rem; }
.obs-item {
    display:flex; align-items:flex-start; gap:.85rem;
    padding:.85rem 1rem; border-radius:9px;
    border:1px solid var(--border); background:#fff;
    transition:background .15s,border-color .15s;
}
.obs-item:hover { background:var(--cyan-light); border-color:var(--cyan-border); }
.obs-dot {
    width:36px; height:36px; border-radius:9px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:.85rem;
}
.obs-body { flex:1; min-width:0; }
.obs-titulo { font-weight:700; color:var(--blue-dark); font-size:.84rem; margin-bottom:.2rem; }
.obs-desc   { color:var(--muted); font-size:.78rem; margin-bottom:.25rem; line-height:1.5; }
.obs-meta   { color:var(--subtle); font-size:.7rem; display:flex; align-items:center; gap:.75rem; flex-wrap:wrap; }
.obs-tipo-badge {
    display:inline-flex; align-items:center; gap:.25rem;
    padding:.15rem .55rem; border-radius:999px; font-size:.65rem; font-weight:700;
}

/* ══ EMPTY STATE ══ */
.empty-state { text-align:center; padding:3rem 2rem; color:var(--subtle); }
.empty-state i { font-size:2rem; color:var(--border); display:block; margin-bottom:.75rem; }
.empty-state p { margin:0; font-size:.82rem; }

/* ══ MAIN GRID ══ */
.main-grid {
    display:grid; grid-template-columns:1fr 300px; gap:1.25rem; align-items:start;
}
@media(max-width:1100px){ .main-grid { grid-template-columns:1fr; } }

/* ══ INFO PADRE ══ */
.padre-tag {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.3rem .85rem; border-radius:999px; font-size:.73rem; font-weight:600;
    background:rgba(78,199,210,.12); color:var(--blue-mid);
    border:1px solid var(--cyan-border);
}
</style>
@endpush

@section('content')
@php
    $obsColors = [
        'academica'  => ['bg'=>'rgba(78,199,210,.12)', 'color'=>'#00508f', 'icon'=>'fa-book',           'label'=>'Académica'],
        'conductual' => ['bg'=>'rgba(239,68,68,.1)',   'color'=>'#dc2626', 'icon'=>'fa-exclamation',    'label'=>'Conductual'],
        'positiva'   => ['bg'=>'rgba(16,185,129,.1)',  'color'=>'#059669', 'icon'=>'fa-star',           'label'=>'Positiva'],
        'salud'      => ['bg'=>'rgba(245,158,11,.1)',  'color'=>'#d97706', 'icon'=>'fa-heartbeat',      'label'=>'Salud'],
        'asistencia' => ['bg'=>'rgba(99,102,241,.1)',  'color'=>'#6366f1', 'icon'=>'fa-calendar-check', 'label'=>'Asistencia'],
        'otro'       => ['bg'=>'rgba(100,116,139,.1)', 'color'=>'#475569', 'icon'=>'fa-comment',        'label'=>'General'],
    ];

    $observaciones = collect();
    try {
        $observaciones = \App\Models\Observacion::where('estudiante_id', $estudiante->id)
            ->with(['profesor'])
            ->latest()
            ->get();
    } catch (\Exception $e) {}
@endphp

<div class="hijo-wrap">

    {{-- ══ BANNER ══ --}}
    <div class="hijo-banner">
        <div class="hijo-banner-av">
            @if($estudiante->foto)
                <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="">
            @else
                {{ strtoupper(substr($estudiante->nombre1,0,1) . substr($estudiante->apellido1,0,1)) }}
            @endif
        </div>
        <div class="hijo-banner-info">
            <h3>
                {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
            </h3>
            <p>
                <i class="fas fa-user-friends me-1"></i>
                Viendo como: {{ $padre->nombre }} {{ $padre->apellido }}
                &nbsp;·&nbsp;
                {{ ucfirst(str_replace('_',' ', $padre->parentesco ?? '')) }}
            </p>
            <div class="hijo-banner-tags">
                <span class="h-tag tag-cyan">
                    <i class="fas fa-graduation-cap"></i>
                    {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                </span>
                <span class="h-tag tag-white">
                    <i class="fas fa-id-card"></i>
                    {{ $estudiante->dni }}
                </span>
                <span class="h-tag tag-green">
                    <i class="fas fa-circle" style="font-size:.4rem;"></i>
                    {{ ucfirst($estudiante->estado) }}
                </span>
            </div>
        </div>
    </div>

    {{-- ══ STATS ══ --}}
    <div class="hijo-stats">
        <div class="h-stat">
            <div class="h-stat-stripe" style="background:var(--cyan);"></div>
            <div class="h-stat-icon" style="background:rgba(78,199,210,.12);">
                <i class="fas fa-barcode" style="color:var(--blue-mid);"></i>
            </div>
            <div>
                <div class="h-stat-lbl">Código Matrícula</div>
                <div class="h-stat-val" style="font-family:monospace;font-size:.9rem;">
                    {{ $matricula->codigo_matricula }}
                </div>
            </div>
        </div>
        <div class="h-stat">
            <div class="h-stat-stripe" style="background:#10b981;"></div>
            <div class="h-stat-icon" style="background:rgba(16,185,129,.1);">
                <i class="fas fa-calendar-alt" style="color:#10b981;"></i>
            </div>
            <div>
                <div class="h-stat-lbl">Año Lectivo</div>
                <div class="h-stat-val">{{ $matricula->anio_lectivo }}</div>
            </div>
        </div>
        <div class="h-stat">
            <div class="h-stat-stripe" style="background:#f59e0b;"></div>
            <div class="h-stat-icon" style="background:rgba(245,158,11,.1);">
                <i class="fas fa-comment-alt" style="color:#d97706;"></i>
            </div>
            <div>
                <div class="h-stat-lbl">Observaciones</div>
                <div class="h-stat-val">{{ $observaciones->count() }}</div>
            </div>
        </div>
    </div>

    {{-- ══ MAIN GRID: datos + accesos ══ --}}
    <div class="main-grid">

        {{-- Datos del estudiante --}}
        <div class="sec-card">
            <div class="sec-head">
                <div class="sec-head-left">
                    <i class="fas fa-user-graduate"></i>
                    <span>Datos del Estudiante</span>
                </div>
                <span class="padre-tag">
                    <i class="fas fa-user-friends"></i>
                    {{ $padre->nombre }} {{ $padre->apellido }}
                </span>
            </div>
            <div class="pf-grid">
                <div class="pf-box">
                    <div class="pf-label">Nombre Completo</div>
                    <div class="pf-value">
                        {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                        {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                    </div>
                </div>
                <div class="pf-box">
                    <div class="pf-label">DNI</div>
                    <div class="pf-value" style="font-family:monospace;color:var(--blue-mid);">
                        {{ $estudiante->dni ?: '—' }}
                    </div>
                </div>
                <div class="pf-box">
                    <div class="pf-label">Fecha de Nacimiento</div>
                    <div class="pf-value">
                        {{ $estudiante->fecha_nacimiento
                            ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y')
                            : 'No registrada' }}
                    </div>
                </div>
                <div class="pf-box">
                    <div class="pf-label">Sexo</div>
                    <div class="pf-value">{{ ucfirst($estudiante->sexo ?? '—') }}</div>
                </div>
                <div class="pf-box">
                    <div class="pf-label">Grado</div>
                    <div class="pf-value">{{ $estudiante->grado }}</div>
                </div>
                <div class="pf-box">
                    <div class="pf-label">Sección</div>
                    <div class="pf-value">{{ $estudiante->seccion }}</div>
                </div>
                <div class="pf-box">
                    <div class="pf-label">Correo Institucional</div>
                    <div class="pf-value {{ !$estudiante->email ? 'empty' : '' }}">
                        {{ $estudiante->email ?: 'No registrado' }}
                    </div>
                </div>
                <div class="pf-box">
                    <div class="pf-label">Teléfono</div>
                    <div class="pf-value {{ !$estudiante->telefono ? 'empty' : '' }}">
                        {{ $estudiante->telefono ?: 'No registrado' }}
                    </div>
                </div>
                <div class="pf-box" style="grid-column:1 / -1;">
                    <div class="pf-label">Dirección</div>
                    <div class="pf-value {{ !$estudiante->direccion ? 'empty' : '' }}">
                        {{ $estudiante->direccion ?: 'No registrada' }}
                    </div>
                </div>
                @if($estudiante->observaciones)
                <div class="pf-box" style="grid-column:1 / -1;">
                    <div class="pf-label">Observaciones Generales</div>
                    <div class="pf-value">{{ $estudiante->observaciones }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Panel lateral --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Info matrícula --}}
            <div class="sec-card">
                <div class="sec-head">
                    <div class="sec-head-left">
                        <i class="fas fa-file-signature"></i>
                        <span>Matrícula</span>
                    </div>
                </div>
                <div style="padding:.85rem 1rem;display:flex;flex-direction:column;gap:.5rem;">
                    <div class="pf-box">
                        <div class="pf-label">Código</div>
                        <div class="pf-value" style="font-family:monospace;color:var(--blue-mid);">
                            {{ $matricula->codigo_matricula }}
                        </div>
                    </div>
                    <div class="pf-box">
                        <div class="pf-label">Año Lectivo</div>
                        <div class="pf-value">{{ $matricula->anio_lectivo }}</div>
                    </div>
                    <div class="pf-box">
                        <div class="pf-label">Estado</div>
                        <div class="pf-value">
                            <span style="display:inline-flex;align-items:center;gap:.3rem;
                                         padding:.2rem .65rem;border-radius:999px;
                                         font-size:.72rem;font-weight:700;
                                         background:#f0fdf4;color:#166534;border:1px solid #86efac;">
                                <i class="fas fa-check-circle" style="font-size:.55rem;"></i>
                                {{ ucfirst($matricula->estado) }}
                            </span>
                        </div>
                    </div>
                    @if($matricula->fecha_matricula)
                    <div class="pf-box">
                        <div class="pf-label">Fecha de Matrícula</div>
                        <div class="pf-value">
                            {{ \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Accesos rápidos --}}
            <div class="sec-card">
                <div class="sec-head">
                    <div class="sec-head-left">
                        <i class="fas fa-rocket"></i>
                        <span>Accesos Rápidos</span>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr;gap:.6rem;padding:1rem;">
                    <a href="{{ route('padre.dashboard') }}"
                       style="display:flex;align-items:center;gap:.75rem;padding:.8rem 1rem;
                              border-radius:9px;text-decoration:none;transition:all .15s;
                              border:1.5px solid rgba(78,199,210,.3);background:var(--surface);min-width:0;">
                        <div style="width:36px;height:36px;border-radius:9px;flex-shrink:0;
                                    background:rgba(78,199,210,.1);display:flex;align-items:center;
                                    justify-content:center;font-size:.9rem;">
                            <i class="fas fa-home" style="color:var(--cyan);"></i>
                        </div>
                        <span style="font-size:.83rem;font-weight:600;color:var(--blue-dark);flex:1;">
                            Volver al Portal
                        </span>
                        <i class="fas fa-chevron-right" style="color:var(--subtle);font-size:.7rem;"></i>
                    </a>
                    <a href="{{ route('estado-solicitud') }}"
                       style="display:flex;align-items:center;gap:.75rem;padding:.8rem 1rem;
                              border-radius:9px;text-decoration:none;transition:all .15s;
                              border:1.5px solid rgba(0,80,143,.2);background:var(--surface);min-width:0;">
                        <div style="width:36px;height:36px;border-radius:9px;flex-shrink:0;
                                    background:rgba(0,80,143,.1);display:flex;align-items:center;
                                    justify-content:center;font-size:.9rem;">
                            <i class="fas fa-file-signature" style="color:var(--blue-mid);"></i>
                        </div>
                        <span style="font-size:.83rem;font-weight:600;color:var(--blue-dark);flex:1;">
                            Estado de Solicitud
                        </span>
                        <i class="fas fa-chevron-right" style="color:var(--subtle);font-size:.7rem;"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ══ OBSERVACIONES DEL ESTUDIANTE ══ --}}
    <div class="sec-card">
        <div class="sec-head">
            <div class="sec-head-left">
                <i class="fas fa-comment-alt"></i>
                <span>Observaciones de Profesores</span>
            </div>
            <span class="sec-head-badge">{{ $observaciones->count() }}</span>
        </div>

        @if($observaciones->count() > 0)
            <div class="obs-list">
                @foreach($observaciones as $obs)
                @php
                    $c = $obsColors[$obs->tipo] ?? $obsColors['otro'];
                @endphp
                <div class="obs-item">
                    <div class="obs-dot" style="background:{{ $c['bg'] }};">
                        <i class="fas {{ $c['icon'] }}" style="color:{{ $c['color'] }};"></i>
                    </div>
                    <div class="obs-body">
                        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.25rem;flex-wrap:wrap;">
                            <span class="obs-titulo">{{ $c['label'] }}</span>
                            <span class="obs-tipo-badge"
                                  style="background:{{ $c['bg'] }};color:{{ $c['color'] }};border:1px solid {{ $c['color'] }}33;">
                                {{ $c['label'] }}
                            </span>
                        </div>
                        <div class="obs-desc">{{ $obs->descripcion }}</div>
                        <div class="obs-meta">
                            @if($obs->profesor)
                                <span>
                                    <i class="fas fa-chalkboard-teacher me-1"></i>
                                    {{ $obs->profesor->nombre }} {{ $obs->profesor->apellido }}
                                </span>
                            @endif
                            <span>
                                <i class="fas fa-clock me-1"></i>
                                {{ $obs->created_at->diffForHumans() }}
                            </span>
                            <span>
                                <i class="fas fa-calendar me-1"></i>
                                {{ $obs->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-comment-slash"></i>
                <p>No hay observaciones registradas para este estudiante aún.</p>
            </div>
        @endif
    </div>

</div>
@endsection