@extends('layouts.app')

@section('title', 'Mi Portal')
@section('page-title', 'Portal del Padre/Tutor')

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

.pad-wrap {
    font-family: 'Inter', sans-serif;
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* ══ BANNER ══ */
.pad-banner {
    background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 55%, var(--cyan) 100%);
    border-radius: var(--radius);
    padding: 1.5rem 2rem;
    display: flex; align-items: center; gap: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,59,115,.2);
    position: relative; overflow: hidden;
}
.pad-banner::before {
    content:''; position:absolute; top:-50%; right:-3%;
    width:220px; height:220px; background:rgba(255,255,255,.07); border-radius:50%;
}
.pad-banner::after {
    content:''; position:absolute; bottom:-55%; right:15%;
    width:150px; height:150px; background:rgba(255,255,255,.04); border-radius:50%;
}
.pad-banner-avatar {
    width:68px; height:68px; border-radius:16px; flex-shrink:0;
    background:rgba(255,255,255,.15); border:2.5px solid rgba(255,255,255,.35);
    display:flex; align-items:center; justify-content:center;
    font-size:1.4rem; font-weight:800; color:#fff; position:relative; z-index:1;
    box-shadow: 0 4px 12px rgba(0,0,0,.2);
}
.pad-banner-info { position:relative; z-index:1; flex:1; }
.pad-banner-info h3 { color:#fff; font-weight:800; margin:0 0 .25rem; font-size:1.3rem; }
.pad-banner-info p  { color:rgba(255,255,255,.72); font-size:.82rem; margin:0 0 .65rem; }
.pad-banner-tags { display:flex; flex-wrap:wrap; gap:.4rem; }
.pad-tag {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.22rem .75rem; border-radius:999px; font-size:.72rem; font-weight:600;
}
.tag-cyan  { background:rgba(78,199,210,.3); color:#fff; border:1px solid rgba(78,199,210,.5); }
.tag-white { background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.28); }
.tag-green { background:rgba(16,185,129,.28); color:#fff; border:1px solid rgba(16,185,129,.5); }
.tag-warn  { background:rgba(234,179,8,.22); color:#fde047; border:1px solid rgba(234,179,8,.4); }

/* ══ STATS ══ */
.pad-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}
@media(max-width:768px){ .pad-stats { grid-template-columns: 1fr 1fr; } }
@media(max-width:480px){ .pad-stats { grid-template-columns: 1fr; } }

.pad-stat {
    background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
    box-shadow: var(--shadow); position: relative; overflow: hidden;
    transition: box-shadow .15s, transform .15s;
}
.pad-stat:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.pad-stat-stripe {
    position:absolute; left:0; top:0; bottom:0;
    width:4px; border-radius: var(--radius) 0 0 var(--radius);
}
.pad-stat-icon {
    width:44px; height:44px; border-radius:11px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:1.05rem;
}
.pad-stat-lbl { font-size:.68rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.15rem; }
.pad-stat-val { font-size:1.6rem; font-weight:800; color:var(--blue-dark); line-height:1; }

/* ══ SECTION CARD ══ */
.sec-card {
    background:#fff; border:1px solid var(--border); border-radius:var(--radius);
    overflow:hidden; box-shadow:var(--shadow);
}
.sec-head {
    background: var(--blue-dark);
    padding:.85rem 1.25rem;
    display:flex; align-items:center; justify-content:space-between;
}
.sec-head-left { display:flex; align-items:center; gap:.6rem; }
.sec-head i    { color:var(--cyan); font-size:1rem; }
.sec-head span { color:#fff; font-weight:700; font-size:.95rem; }
.sec-head-badge {
    padding:.2rem .7rem; border-radius:999px; font-size:.72rem; font-weight:700;
    background:rgba(78,199,210,.25); color:#fff; border:1px solid rgba(78,199,210,.4);
}

/* ══ HIJO CARD ══ */
.hijo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
    padding: 1rem;
}
.hijo-card {
    border: 1px solid var(--border); border-radius: 10px;
    overflow: hidden; transition: box-shadow .15s, transform .15s;
}
.hijo-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.hijo-card-head {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    padding: 1rem 1.1rem;
    display: flex; align-items: center; gap: .85rem;
}
.hijo-av {
    width:46px; height:46px; border-radius:10px; flex-shrink:0;
    background:rgba(255,255,255,.15); border:2px solid var(--cyan);
    display:flex; align-items:center; justify-content:center;
    font-size:1rem; font-weight:800; color:#fff; overflow:hidden;
}
.hijo-av img { width:100%; height:100%; object-fit:cover; }
.hijo-nombre { font-size:.9rem; font-weight:700; color:#fff; margin:0 0 .18rem; }
.hijo-grado  { font-size:.73rem; color:rgba(255,255,255,.75); margin:0; }
.hijo-body { padding:1rem 1.1rem; }
.hijo-row {
    display:flex; align-items:center; gap:.5rem;
    padding:.45rem 0; border-bottom:1px solid var(--surface);
    font-size:.81rem;
}
.hijo-row:last-child { border-bottom:none; }
.hijo-row i    { color:var(--cyan); width:14px; text-align:center; flex-shrink:0; }
.hijo-row .lbl { color:var(--subtle); font-weight:600; min-width:90px; }
.hijo-row .val { color:var(--text); font-weight:500; }
.hijo-row .val.mono { font-family:monospace; color:var(--blue-mid); font-weight:700; }
.hijo-foot {
    padding:.75rem 1.1rem;
    background:var(--surface); border-top:1px solid var(--border);
}
.hijo-btn {
    display:flex; align-items:center; justify-content:center; gap:.4rem;
    padding:.5rem 1rem; border-radius:8px; text-decoration:none;
    background:linear-gradient(135deg,var(--cyan),var(--blue-mid));
    color:#fff; font-size:.78rem; font-weight:700;
    box-shadow:0 2px 8px rgba(78,199,210,.3); transition:opacity .15s;
}
.hijo-btn:hover { opacity:.88; color:#fff; }

/* ══ BADGES ══ */
.bpill {
    display:inline-flex; align-items:center; gap:.25rem;
    padding:.2rem .65rem; border-radius:999px; font-size:.68rem; font-weight:700;
}
.b-active   { background:#f0fdf4; color:#166534; border:1px solid #86efac; }
.b-inactive { background:#fef2f2; color:#991b1b; border:1px solid #fca5a5; }
.b-pending  { background:#fefce8; color:#854d0e; border:1px solid #fde047; }

/* ══ HISTORIAL TABLE ══ */
.hist-table { width:100%; border-collapse:collapse; font-size:.82rem; }
.hist-table th {
    padding:.6rem 1rem; text-align:left;
    font-size:.67rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.06em; color:var(--subtle);
    background:var(--surface); border-bottom:1px solid var(--border);
}
.hist-table td {
    padding:.72rem 1rem; border-bottom:1px solid #f1f5f9;
    color:var(--text); font-weight:500; vertical-align:middle;
}
.hist-table tr:last-child td { border-bottom:none; }
.hist-table tr:hover td { background:var(--surface); }
.code-pill {
    font-family:monospace; font-size:.78rem; font-weight:700;
    color:var(--blue-mid); background:var(--cyan-light);
    border:1px solid var(--cyan-border);
    padding:.15rem .55rem; border-radius:5px;
}

/* ══ OBSERVACIONES ══ */
.obs-list { padding:.75rem 1rem; display:flex; flex-direction:column; gap:.5rem; }
.obs-item {
    display:flex; align-items:flex-start; gap:.85rem;
    padding:.85rem 1rem; border-radius:9px;
    border:1px solid var(--border); background:#fff;
    transition:background .15s, border-color .15s;
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

/* ══ QUICK LINKS ══ */
.quick-grid {
    display:grid; grid-template-columns:1fr; gap:.6rem; padding:1rem;
}
.quick-link {
    display:flex; align-items:center; gap:.75rem;
    padding:.8rem 1rem; border-radius:9px; text-decoration:none;
    transition:all .15s; border:1.5px solid var(--border);
    background:var(--surface); min-width:0;
}
.quick-link:hover { transform:translateY(-2px); box-shadow:var(--shadow-md); }
.quick-icon {
    width:36px; height:36px; border-radius:9px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:.9rem;
}
.quick-label {
    font-size:.83rem; font-weight:600; color:var(--blue-dark); flex:1;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.quick-arrow { color:var(--subtle); font-size:.7rem; flex-shrink:0; }

/* ══ MAIN GRID ══ */
.main-grid {
    display:grid; grid-template-columns:1fr 300px; gap:1.25rem; align-items:start;
}
@media(max-width:1100px){ .main-grid { grid-template-columns:1fr; } }

/* ══ EMPTY STATE ══ */
.empty-state { text-align:center; padding:3rem 2rem; color:var(--subtle); }
.empty-state i { font-size:2rem; color:var(--border); display:block; margin-bottom:.75rem; }
.empty-state p { margin:0; font-size:.82rem; }

/* ══ ALERTA CREDENCIALES ══ */
.creds-alert {
    background:#fefce8; border:1.5px solid #fde047; border-radius:10px;
    padding:1rem 1.25rem; display:flex; gap:.75rem; align-items:flex-start;
    font-size:.83rem;
}
.creds-alert i { color:#d97706; margin-top:.1rem; flex-shrink:0; }
.creds-alert strong { color:#92400e; }
.creds-alert p { margin:.2rem 0 0; color:var(--muted); font-size:.8rem; }
</style>
@endpush

@section('content')
@php
    $user       = auth()->user();
    $hijosCount = $matriculas->count();
    $aprobadas  = $todasMatriculas->where('estado','aprobada')->count();
    $pendientes = $todasMatriculas->where('estado','pendiente')->count();

    $observaciones = collect();
    try {
        $estudianteIds = $matriculas->pluck('estudiante_id');
        $observaciones = \App\Models\Observacion::whereIn('estudiante_id', $estudianteIds)
            ->with(['estudiante','profesor'])
            ->latest()
            ->take(10)
            ->get();
    } catch (\Exception $e) {}

    $obsColors = [
        'academica'  => ['bg'=>'rgba(78,199,210,.12)', 'color'=>'#00508f', 'icon'=>'fa-book',           'label'=>'Académica'],
        'conductual' => ['bg'=>'rgba(239,68,68,.1)',   'color'=>'#dc2626', 'icon'=>'fa-exclamation',    'label'=>'Conductual'],
        'positiva'   => ['bg'=>'rgba(16,185,129,.1)',  'color'=>'#059669', 'icon'=>'fa-star',           'label'=>'Positiva'],
        'salud'      => ['bg'=>'rgba(245,158,11,.1)',  'color'=>'#d97706', 'icon'=>'fa-heartbeat',      'label'=>'Salud'],
        'asistencia' => ['bg'=>'rgba(99,102,241,.1)',  'color'=>'#6366f1', 'icon'=>'fa-calendar-check', 'label'=>'Asistencia'],
    ];
@endphp

<div class="pad-wrap">

    {{-- ══ BANNER ══ --}}
    <div class="pad-banner">
        <div class="pad-banner-avatar">
            {{ strtoupper(substr($padre->nombre, 0, 1) . substr($padre->apellido, 0, 1)) }}
        </div>
        <div class="pad-banner-info">
            <h3>Bienvenido/a, {{ $padre->nombre }} {{ $padre->apellido }}</h3>
            <p>
                <i class="fas fa-users me-1"></i>
                Portal Familiar · {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </p>
            <div class="pad-banner-tags">
                <span class="pad-tag tag-cyan">
                    <i class="fas fa-child"></i>
                    {{ $hijosCount }} {{ $hijosCount == 1 ? 'hijo vinculado' : 'hijos vinculados' }}
                </span>
                <span class="pad-tag tag-white">
                    <i class="fas fa-id-card"></i>
                    {{ $padre->dni }}
                </span>
                <span class="pad-tag tag-green">
                    <i class="fas fa-circle" style="font-size:.4rem;"></i>
                    {{ $padre->estado ? 'Activo' : 'Inactivo' }}
                </span>
                @if($pendientes > 0)
                    <span class="pad-tag tag-warn">
                        <i class="fas fa-clock"></i>
                        {{ $pendientes }} matrícula(s) pendiente(s)
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ══ ALERTA CREDENCIALES ══ --}}
    @if(auth()->user()->created_at->diffInDays(now()) <= 3)
    <div class="creds-alert">
        <i class="fas fa-key"></i>
        <div>
            <strong>Tus credenciales de acceso</strong>
            <p>Tu contraseña inicial es tu <strong>número de DNI</strong>. Te recomendamos cambiarla lo antes posible.</p>
        </div>
    </div>
    @endif

    {{-- ══ STATS ══ --}}
    <div class="pad-stats">
        <div class="pad-stat">
            <div class="pad-stat-stripe" style="background:var(--cyan);"></div>
            <div class="pad-stat-icon" style="background:rgba(78,199,210,.12);">
                <i class="fas fa-child" style="color:var(--blue-mid);"></i>
            </div>
            <div>
                <div class="pad-stat-lbl">Hijos Activos</div>
                <div class="pad-stat-val">{{ $hijosCount ?: '0' }}</div>
            </div>
        </div>
        <div class="pad-stat">
            <div class="pad-stat-stripe" style="background:#10b981;"></div>
            <div class="pad-stat-icon" style="background:rgba(16,185,129,.1);">
                <i class="fas fa-check-circle" style="color:#10b981;"></i>
            </div>
            <div>
                <div class="pad-stat-lbl">Matrículas Aprobadas</div>
                <div class="pad-stat-val">{{ $aprobadas }}</div>
            </div>
        </div>
        <div class="pad-stat">
            <div class="pad-stat-stripe" style="background:#f59e0b;"></div>
            <div class="pad-stat-icon" style="background:rgba(245,158,11,.1);">
                <i class="fas fa-clock" style="color:#d97706;"></i>
            </div>
            <div>
                <div class="pad-stat-lbl">Matrículas Pendientes</div>
                <div class="pad-stat-val">{{ $pendientes }}</div>
            </div>
        </div>
    </div>

    {{-- ══ HIJOS + ACCESOS RÁPIDOS ══ --}}
    <div class="main-grid">

        {{-- Hijos vinculados --}}
        <div class="sec-card">
            <div class="sec-head">
                <div class="sec-head-left">
                    <i class="fas fa-user-graduate"></i>
                    <span>Hijos / Estudiantes Vinculados</span>
                </div>
                <span class="sec-head-badge">{{ $hijosCount }}</span>
            </div>

            @if($hijosCount > 0)
                <div class="hijo-grid">
                    @foreach($matriculas as $matricula)
                    @php $estudiante = $matricula->estudiante; @endphp
                    <div class="hijo-card">
                        <div class="hijo-card-head">
                            <div class="hijo-av">
                                @if($estudiante->foto)
                                    <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="">
                                @else
                                    {{ strtoupper(substr($estudiante->nombre1,0,1) . substr($estudiante->apellido1,0,1)) }}
                                @endif
                            </div>
                            <div style="flex:1;">
                                <p class="hijo-nombre">
                                    {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                                    {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                                </p>
                                <p class="hijo-grado">
                                    <i class="fas fa-graduation-cap me-1"></i>
                                    {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                                </p>
                            </div>
                            <span class="bpill b-active">
                                <i class="fas fa-circle" style="font-size:.4rem;"></i> Activo
                            </span>
                        </div>
                        <div class="hijo-body">
                            <div class="hijo-row">
                                <i class="fas fa-id-card"></i>
                                <span class="lbl">DNI</span>
                                <span class="val mono">{{ $estudiante->dni ?: '—' }}</span>
                            </div>
                            <div class="hijo-row">
                                <i class="fas fa-birthday-cake"></i>
                                <span class="lbl">Nacimiento</span>
                                <span class="val">
                                    {{ $estudiante->fecha_nacimiento
                                        ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y')
                                        : 'No registrado' }}
                                </span>
                            </div>
                            <div class="hijo-row">
                                <i class="fas fa-barcode"></i>
                                <span class="lbl">Matrícula</span>
                                <span class="val mono">{{ $matricula->codigo_matricula }}</span>
                            </div>
                            <div class="hijo-row">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="lbl">Año lectivo</span>
                                <span class="val">{{ $matricula->anio_lectivo }}</span>
                            </div>
                            @if($estudiante->email)
                            <div class="hijo-row">
                                <i class="fas fa-envelope"></i>
                                <span class="lbl">Email</span>
                                <span class="val">{{ $estudiante->email }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="hijo-foot">
                            <a href="{{ route('padre.hijo', $estudiante->id) }}" class="hijo-btn">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-user-slash"></i>
                    <p>No tienes hijos con matrícula aprobada actualmente.</p>
                </div>
            @endif
        </div>

        {{-- Accesos rápidos --}}
        <div class="sec-card">
            <div class="sec-head">
                <div class="sec-head-left">
                    <i class="fas fa-rocket"></i>
                    <span>Accesos Rápidos</span>
                </div>
            </div>
            <div class="quick-grid">

                <a href="{{ route('estado-solicitud') }}" class="quick-link"
                   style="border-color:rgba(78,199,210,.3);">
                    <div class="quick-icon" style="background:rgba(78,199,210,.1);">
                        <i class="fas fa-file-signature" style="color:var(--cyan);"></i>
                    </div>
                    <span class="quick-label">Estado de Solicitud</span>
                    <i class="fas fa-chevron-right quick-arrow"></i>
                </a>

                <a href="{{ route('cambiarcontrasenia.edit') }}" class="quick-link"
                   style="border-color:rgba(124,58,237,.25);">
                    <div class="quick-icon" style="background:rgba(124,58,237,.08);">
                        <i class="fas fa-key" style="color:#7c3aed;"></i>
                    </div>
                    <span class="quick-label">Cambiar Contraseña</span>
                    <i class="fas fa-chevron-right quick-arrow"></i>
                </a>

                @foreach($matriculas as $matricula)
                <a href="{{ route('padre.hijo', $matricula->estudiante->id) }}" class="quick-link"
                   style="border-color:rgba(0,80,143,.2);">
                    <div class="quick-icon" style="background:rgba(0,80,143,.1);">
                        <i class="fas fa-user-graduate" style="color:var(--blue-mid);"></i>
                    </div>
                    <span class="quick-label">
                        {{ $matricula->estudiante->nombre1 }} {{ $matricula->estudiante->apellido1 }}
                    </span>
                    <i class="fas fa-chevron-right quick-arrow"></i>
                </a>
                @endforeach

            </div>
        </div>

    </div>

    {{-- ══ OBSERVACIONES ══ --}}
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
                    $c = $obsColors[$obs->tipo] ?? [
                        'bg'    => 'rgba(78,199,210,.12)',
                        'color' => '#00508f',
                        'icon'  => 'fa-comment',
                        'label' => ucfirst($obs->tipo ?? 'General'),
                    ];
                @endphp
                <div class="obs-item">
                    <div class="obs-dot" style="background:{{ $c['bg'] }};">
                        <i class="fas {{ $c['icon'] }}" style="color:{{ $c['color'] }};"></i>
                    </div>
                    <div class="obs-body">
                        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.25rem;flex-wrap:wrap;">
                            <span class="obs-titulo">
                                {{ $obs->estudiante->nombre1 ?? '' }} {{ $obs->estudiante->apellido1 ?? '' }}
                            </span>
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
                <p>No hay observaciones registradas para tus hijos aún.</p>
            </div>
        @endif
    </div>

    {{-- ══ HISTORIAL DE MATRÍCULAS ══ --}}
    @if($todasMatriculas->count() > 0)
    <div class="sec-card">
        <div class="sec-head">
            <div class="sec-head-left">
                <i class="fas fa-history"></i>
                <span>Historial de Solicitudes de Matrícula</span>
            </div>
            <span class="sec-head-badge">{{ $todasMatriculas->count() }}</span>
        </div>
        <div style="overflow-x:auto;">
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
                        <td style="font-weight:600;color:var(--blue-dark);">
                            {{ $m->estudiante?->nombre1 }} {{ $m->estudiante?->apellido1 }}
                        </td>
                        <td>{{ $m->anio_lectivo }}</td>
                        <td style="color:var(--muted);">
                            {{ $m->fecha_matricula
                                ? \Carbon\Carbon::parse($m->fecha_matricula)->format('d/m/Y')
                                : '—' }}
                        </td>
                        <td>
                            <span class="bpill {{ $badgeClass }}">
                                <i class="fas {{ $badgeIcon }}" style="font-size:.45rem;"></i>
                                {{ ucfirst($m->estado) }}
                            </span>
                            @if($m->estado === 'rechazada' && $m->motivo_rechazo)
                                <div style="font-size:.7rem;color:var(--subtle);margin-top:.2rem;">
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

    {{-- ══ MIS DATOS ══ --}}
    <div class="sec-card">
        <div class="sec-head">
            <div class="sec-head-left">
                <i class="fas fa-user-circle"></i>
                <span>Mis Datos</span>
            </div>
        </div>
        <div class="pf-grid">
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
@endsection