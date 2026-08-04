@extends('layouts.app')

@section('title', 'Mi Panel')
@section('page-title', 'Mi Panel Estudiantil')

@push('styles')
<style>
    :root {
        --blue-dark: #003b73; --blue-mid: #00508f;
        --teal: #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border: #e8edf4; --surface: #f5f8fc;
        --text-main: #0d2137; --text-muted: #6b7a90;
        --green: #10b981; --amber: #f59e0b; --red: #ef4444;
        --indigo: #6366f1;
        --radius-lg: 14px; --radius-sm: 7px;
        --shadow-sm: 0 1px 4px rgba(0,59,115,0.07);
        --shadow-md: 0 4px 16px rgba(0,59,115,0.10);
    }

    .est-banner {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        border-radius: var(--radius-lg); padding: 1.5rem 1.75rem;
        margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1.25rem;
        box-shadow: var(--shadow-md); position: relative; overflow: hidden;
    }
    .est-banner::after {
        content: ''; position: absolute; right: -30px; top: -30px;
        width: 130px; height: 130px; border-radius: 50%;
        background: rgba(78,199,210,.1); pointer-events: none;
    }
    .est-banner-av {
        width: 68px; height: 68px; border-radius: 16px; flex-shrink: 0;
        background: rgba(255,255,255,.15); border: 3px solid var(--teal);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; color: white; position: relative; z-index: 1;
    }
    .est-banner-av img { width:100%; height:100%; object-fit:cover; border-radius:13px; }
    .est-banner-info { position: relative; z-index: 1; flex: 1; min-width: 0; }
    .est-banner-name { font-size: 1.3rem; font-weight: 800; color: white; margin-bottom: .2rem; }
    .est-banner-sub  { font-size: .82rem; color: rgba(255,255,255,.65); margin-bottom: .65rem; }
    .est-banner-chips { display: flex; flex-wrap: wrap; gap: .4rem; }
    .echip { display: inline-flex; align-items: center; gap: .3rem; padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 600; }
    .ec-teal  { background: rgba(78,199,210,.2);  color: #a5f3fc; border: 1px solid rgba(78,199,210,.35); }
    .ec-white { background: rgba(255,255,255,.15); color: rgba(255,255,255,.85); border: 1px solid rgba(255,255,255,.25); }
    .ec-green { background: rgba(16,185,129,.25);  color: #6ee7b7; border: 1px solid rgba(16,185,129,.4); }

    /* Stats */
    .est-stats { display: grid; grid-template-columns: repeat(5,1fr); gap: 1rem; margin-bottom: 1.5rem; }
    @media(max-width:1100px){ .est-stats { grid-template-columns: repeat(3,1fr); } }
    @media(max-width:700px) { .est-stats { grid-template-columns: repeat(2,1fr); gap:.75rem; } }

    .est-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1rem 1.1rem;
        display: flex; align-items: center; gap: .9rem;
        box-shadow: var(--shadow-sm); text-decoration: none;
        transition: transform .18s, box-shadow .18s;
        position: relative; overflow: hidden;
    }
    .est-stat::before { content:''; position:absolute; top:0; left:0; width:4px; height:100%; border-radius:4px 0 0 4px; }
    .ss-navy::before   { background: var(--blue-dark); }
    .ss-blue::before   { background: var(--blue-mid); }
    .ss-green::before  { background: var(--green); }
    .ss-amber::before  { background: var(--amber); }
    .ss-indigo::before { background: var(--indigo); }
    .est-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }

    .est-stat-icon { width:46px; height:46px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:1.1rem; }
    .ss-navy   .est-stat-icon { background: rgba(0,59,115,.1);    color: var(--blue-dark); }
    .ss-blue   .est-stat-icon { background: rgba(0,80,143,.1);    color: var(--blue-mid); }
    .ss-green  .est-stat-icon { background: rgba(16,185,129,.1);  color: var(--green); }
    .ss-amber  .est-stat-icon { background: rgba(245,158,11,.1);  color: var(--amber); }
    .ss-indigo .est-stat-icon { background: rgba(99,102,241,.12); color: var(--indigo); }

    .est-stat-lbl { font-size:.73rem; color:var(--text-muted); margin-bottom:.1rem; }
    .est-stat-val { font-size:1.45rem; font-weight:800; color:var(--blue-dark); line-height:1; }
    .est-stat-arrow { margin-left:auto; color:#cbd5e1; font-size:.8rem; flex-shrink:0; }

    /* Layout */
    .est-grid-top { display: grid; grid-template-columns: 1fr 360px; gap: 1.25rem; margin-bottom: 1.25rem; }
    .est-grid-mid { display: grid; grid-template-columns: 1fr 320px; gap: 1.25rem; margin-bottom: 1.25rem; }
    .est-grid-bot { display: grid; grid-template-columns: 1fr 1fr;   gap: 1.25rem; margin-bottom: 1.25rem; }
    @media(max-width:1024px){ .est-grid-top, .est-grid-mid, .est-grid-bot { grid-template-columns: 1fr; } }

    /* Cards */
    .est-card { background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm); }
    .est-card-head { background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%); padding: .85rem 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: .6rem; }
    .est-card-title { color: white; font-weight: 700; font-size: .92rem; display: flex; align-items: center; gap: .5rem; }
    .est-card-title i { color: var(--teal); }
    .est-card-link { font-size:.75rem; font-weight:600; color:rgba(255,255,255,.8); text-decoration:none; padding:.25rem .7rem; border-radius:6px; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25); transition:background .15s; white-space:nowrap; }
    .est-card-link:hover { background:rgba(255,255,255,.25); color:white; }
    .est-card-body { padding: 1rem 1.1rem; }

    /* Notificaciones */
    .notif-item { border-left: 4px solid var(--teal); border-radius: 8px; padding: .85rem 1rem; margin-bottom: .5rem; background: var(--surface); transition: background .15s; }
    .notif-item:last-child { margin-bottom: 0; }
    .notif-item.leida { border-left-color: #cbd5e1; background: #f8fafc; }
    .notif-item:hover { background: rgba(78,199,210,.05); }
    .notif-titulo { font-weight:600; color:var(--blue-dark); font-size:.88rem; display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
    .notif-msg    { font-size:.8rem; color:var(--text-muted); margin:.3rem 0 .4rem; line-height:1.5; }
    .notif-time   { font-size:.72rem; color:var(--text-muted); display:flex; align-items:center; gap:.3rem; }
    .notif-nueva  { display:inline-flex; align-items:center; padding:.12rem .5rem; border-radius:999px; font-size:.65rem; font-weight:700; background:var(--teal-light); color:var(--blue-mid); border:1px solid rgba(78,199,210,.35); }
    .btn-marcar   { width:26px; height:26px; border-radius:6px; font-size:.72rem; border:1.5px solid var(--teal); color:var(--teal); background:white; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; transition:all .15s; flex-shrink:0; }
    .btn-marcar:hover { background:var(--teal); color:white; }

    /* Accesos */
    .quick-btn { display:flex; align-items:center; gap:.75rem; padding:.7rem 1rem; border-radius:9px; text-decoration:none; border:1.5px solid var(--border); background:var(--surface); color:var(--text-main); font-weight:600; font-size:.85rem; transition:all .15s; margin-bottom:.5rem; }
    .quick-btn:last-child { margin-bottom:0; }
    .quick-btn:hover { border-color:var(--teal); background:rgba(78,199,210,.05); color:var(--blue-dark); transform:translateX(3px); }
    .qb-icon { width:34px; height:34px; border-radius:8px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:.88rem; }
    .qi-navy   { background: rgba(0,59,115,.1);    color: var(--blue-dark); }
    .qi-blue   { background: rgba(0,80,143,.1);    color: var(--blue-mid); }
    .qi-teal   { background: var(--teal-light);    color: var(--teal); }
    .qi-amber  { background: rgba(245,158,11,.1);  color: var(--amber); }
    .qi-green  { background: rgba(16,185,129,.1);  color: var(--green); }
    .qi-indigo { background: rgba(99,102,241,.12); color: var(--indigo); }
    .qb-arrow { margin-left:auto; color:#cbd5e1; font-size:.75rem; flex-shrink:0; }

    /* Materias */
    .materia-row { display:flex; align-items:center; gap:1rem; padding:.75rem 0; border-bottom:1px solid #f1f5f9; }
    .materia-row:last-child { border-bottom:none; padding-bottom:0; }
    .mat-icon { width:38px; height:38px; border-radius:9px; flex-shrink:0; background:var(--teal-light); color:var(--blue-mid); display:flex; align-items:center; justify-content:center; font-size:.88rem; }
    .mat-nombre { font-weight:600; color:var(--blue-dark); font-size:.87rem; }
    .mat-prof   { font-size:.72rem; color:var(--text-muted); margin-top:.1rem; }
    .mat-right  { margin-left:auto; text-align:right; flex-shrink:0; }
    .mat-prom   { font-size:1.05rem; font-weight:800; }
    .mat-asist  { font-size:.7rem; color:var(--text-muted); }
    .nota-bar-bg   { height:5px; background:#f1f5f9; border-radius:99px; width:80px; margin-top:.3rem; }
    .nota-bar-fill { height:100%; border-radius:99px; }

    /* Calificaciones */
    .cal-tbl { width:100%; border-collapse:collapse; }
    .cal-tbl thead th { background:var(--surface); padding:.55rem .9rem; font-size:.67rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:var(--text-muted); border-bottom:1.5px solid var(--border); }
    .cal-tbl thead th.tc { text-align:center; }
    .cal-tbl tbody td { padding:.65rem .9rem; border-bottom:1px solid #f1f5f9; font-size:.83rem; color:var(--text-main); vertical-align:middle; }
    .cal-tbl tbody td.tc { text-align:center; }
    .cal-tbl tbody tr:last-child td { border-bottom:none; }
    .cal-tbl tbody tr:hover { background:#f7fbff; }
    .nota-badge { display:inline-flex; align-items:center; justify-content:center; width:40px; height:28px; border-radius:7px; font-size:.8rem; font-weight:800; }
    .nb-a { background:rgba(16,185,129,.12); color:#059669; }
    .nb-b { background:rgba(78,199,210,.12); color:var(--blue-mid); }
    .nb-c { background:rgba(245,158,11,.12); color:#92400e; }
    .nb-d { background:rgba(239,68,68,.12);  color:#dc2626; }

    .bpill { display:inline-flex; align-items:center; gap:.25rem; padding:.22rem .65rem; border-radius:999px; font-size:.72rem; font-weight:600; white-space:nowrap; }
    .b-green  { background:rgba(16,185,129,.1); color:#059669; border:1px solid rgba(16,185,129,.3); }
    .b-red    { background:rgba(239,68,68,.1);  color:#dc2626; border:1px solid rgba(239,68,68,.25); }
    .b-gray   { background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0; }
    .b-amber  { background:rgba(245,158,11,.1); color:#92400e; border:1px solid rgba(245,158,11,.3); }
    .b-blue   { background:rgba(33,150,243,.1); color:#1565c0; border:1px solid rgba(33,150,243,.3); }
    .b-indigo { background:rgba(99,102,241,.1); color:#4338ca; border:1px solid rgba(99,102,241,.3); }

    .promedio-strip { background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid)); border-radius:10px; padding:.85rem 1.1rem; display:flex; align-items:center; justify-content:space-between; margin-top:1rem; }
    .promedio-strip-label { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:rgba(255,255,255,.6); }
    .promedio-strip-val   { font-size:1.6rem; font-weight:800; color:white; }

    .periodo-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--teal); margin:.9rem 0 .55rem; display:flex; align-items:center; gap:.4rem; }
    .periodo-title:first-child { margin-top:0; }

    /* Tareas */
    .tarea-item { display:flex; align-items:center; gap:.85rem; padding:.7rem 0; border-bottom:1px solid #f1f5f9; }
    .tarea-item:last-child { border-bottom:none; padding-bottom:0; }
    .tarea-dot  { width:8px; height:8px; border-radius:50%; flex-shrink:0; background:var(--amber); }
    .tarea-mat  { font-size:.7rem; font-weight:700; color:var(--teal); text-transform:uppercase; letter-spacing:.05em; }
    .tarea-name { font-weight:600; color:var(--blue-dark); font-size:.85rem; }
    .tarea-date { font-size:.72rem; color:var(--text-muted); margin-top:.1rem; }

    /* Observaciones — solo lectura */
    .obs-item { display:flex; align-items:flex-start; gap:.85rem; padding:.85rem 0; border-bottom:1px solid #f1f5f9; }
    .obs-item:last-child { border-bottom:none; padding-bottom:0; }
    .obs-tipo-icon { width:38px; height:38px; border-radius:9px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:.88rem; }
    .oi-academica  { background:rgba(33,150,243,.12);  color:#1565c0; }
    .oi-conductual { background:rgba(239,68,68,.12);   color:#dc2626; }
    .oi-salud      { background:rgba(76,175,80,.12);   color:#2e7d32; }
    .oi-otro       { background:rgba(158,158,158,.12); color:#616161; }
    .obs-desc { font-size:.83rem; color:var(--text-main); line-height:1.55; margin:.25rem 0 .3rem; }
    .obs-meta { font-size:.72rem; color:var(--text-muted); display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }

    /* Vacío */
    .est-empty { text-align:center; padding:2.5rem 1rem; }
    .est-empty i { font-size:2rem; color:#cbd5e1; display:block; margin-bottom:.75rem; }
    .est-empty p { font-size:.83rem; color:var(--text-muted); margin:0; }

    @media(max-width:600px) { .est-banner { flex-wrap:wrap; } }
</style>
@endpush

@section('content')
@php
    $misObservaciones   = \App\Models\Observacion::with('profesor')
                            ->where('estudiante_id', $estudiante->id)
                            ->latest()->take(4)->get();
    $totalObservaciones = \App\Models\Observacion::where('estudiante_id', $estudiante->id)->count();
    $calificaciones     = $estudiante->calificaciones ?? collect();
    $porPeriodo         = $calificaciones->groupBy(fn($c) => $c->periodo?->nombre_periodo ?? 'Sin período');
    $promedioReal       = $calificaciones->avg('nota_final') ?? $calificaciones->avg('nota');
@endphp
<div>

    {{-- ── BANNER ── --}}
    <div class="est-banner">
        <div class="est-banner-av">
            @if($estudiante->foto)
                <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto">
            @else
                <i class="fas fa-user-graduate"></i>
            @endif
        </div>
        <div class="est-banner-info">
            <div class="est-banner-name">Hola, {{ $user->name }}</div>
            <div class="est-banner-sub">Bienvenido a tu portal estudiantil</div>
            <div class="est-banner-chips">
                <span class="echip ec-teal">
                    <i class="fas fa-graduation-cap" style="font-size:.65rem;"></i>
                    {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                </span>
                <span class="echip ec-white">
                    <i class="fas fa-id-card" style="font-size:.65rem;"></i>
                    DNI: {{ $estudiante->dni }}
                </span>
                <span class="echip ec-green">
                    <i class="fas fa-circle" style="font-size:.4rem;"></i>
                    {{ ucfirst($estudiante->estado) }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── STATS ── --}}
    <div class="est-stats">
        {{-- Materias: solo informativo --}}
        <div class="est-stat ss-navy">
            <div class="est-stat-icon"><i class="fas fa-book-open"></i></div>
            <div>
                <div class="est-stat-lbl">Materias</div>
                <div class="est-stat-val">{{ count($misMaterias) }}</div>
            </div>
        </div>

        {{-- Promedio: enlaza a ver calificaciones (solo lectura) --}}
        <a href="{{ route('estudiante.calificaciones') }}" class="est-stat ss-blue">
            <div class="est-stat-icon"><i class="fas fa-star"></i></div>
            <div>
                <div class="est-stat-lbl">Promedio</div>
                <div class="est-stat-val">{{ $promedioGeneral }}</div>
            </div>
            <i class="fas fa-chevron-right est-stat-arrow"></i>
        </a>

        {{-- Asistencia: solo informativo --}}
        <div class="est-stat ss-green">
            <div class="est-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="est-stat-lbl">Asistencia</div>
                <div class="est-stat-val">{{ $asistencia }}%</div>
            </div>
        </div>

        {{-- Notificaciones: enlaza a ver (solo lectura) --}}
        <a href="{{ route('notificaciones.index') }}" class="est-stat ss-amber">
            <div class="est-stat-icon"><i class="fas fa-bell"></i></div>
            <div>
                <div class="est-stat-lbl">Sin leer</div>
                <div class="est-stat-val">
                    {{ $notificacionesNoLeidas->count() }}
                    @if($notificacionesNoLeidas->count() > 0)
                        <span style="font-size:.6rem;background:#ef4444;color:white;padding:.1rem .35rem;border-radius:999px;margin-left:.2rem;">Nuevas</span>
                    @endif
                </div>
            </div>
            <i class="fas fa-chevron-right est-stat-arrow"></i>
        </a>

        {{-- Observaciones: solo contador, SIN enlace externo --}}
        <div class="est-stat ss-indigo">
            <div class="est-stat-icon"><i class="fas fa-comment-alt"></i></div>
            <div>
                <div class="est-stat-lbl">Observaciones</div>
                <div class="est-stat-val">{{ $totalObservaciones }}</div>
            </div>
        </div>
    </div>

    {{-- ── FILA 1: Notificaciones + Accesos rápidos ── --}}
    <div class="est-grid-top">

        {{-- Notificaciones recientes (marcar leída sí se permite) --}}
        <div class="est-card">
            <div class="est-card-head">
                <div class="est-card-title"><i class="fas fa-bell"></i> Notificaciones Recientes</div>
                <a href="{{ route('notificaciones.index') }}" class="est-card-link">Ver todas</a>
            </div>
            <div class="est-card-body">
                @php $ultimas = $todasNotificaciones->take(5); @endphp
                @if($ultimas->isEmpty())
                    <div class="est-empty">
                        <i class="fas fa-bell-slash"></i>
                        <p>No tienes notificaciones nuevas</p>
                    </div>
                @else
                    @foreach($ultimas as $notif)
                    <div class="notif-item {{ $notif->leida ? 'leida' : '' }}">
                        <div style="display:flex;align-items:flex-start;gap:.75rem;">
                            <div style="flex:1;min-width:0;">
                                <div class="notif-titulo">
                                    @switch($notif->tipo)
                                        @case('calificacion') <i class="fas fa-star"           style="color:var(--amber);font-size:.82rem;"></i> @break
                                        @case('horario')      <i class="fas fa-calendar-alt"   style="color:var(--teal);font-size:.82rem;"></i>  @break
                                        @case('observacion')  <i class="fas fa-comment-alt"    style="color:var(--indigo);font-size:.82rem;"></i> @break
                                        @case('matricula')    <i class="fas fa-file-signature" style="color:var(--blue-mid);font-size:.82rem;"></i> @break
                                        @default              <i class="fas fa-info-circle"    style="color:var(--teal);font-size:.82rem;"></i>
                                    @endswitch
                                    {{ $notif->titulo }}
                                    @if(!$notif->leida)<span class="notif-nueva">Nueva</span>@endif
                                </div>
                                <div class="notif-msg">{{ $notif->mensaje }}</div>
                                <div class="notif-time">
                                    <i class="fas fa-clock" style="font-size:.65rem;"></i>
                                    {{ $notif->created_at->diffForHumans() }}
                                </div>
                            </div>
                            {{-- Marcar como leída SÍ se permite --}}
                            @if(!$notif->leida)
                                <form action="{{ route('notificaciones.marcarLeida', $notif->id) }}" method="POST" style="flex-shrink:0;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-marcar" title="Marcar como leída">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Accesos rápidos — solo páginas de CONSULTA y cambio de contraseña --}}
        <div class="est-card">
            <div class="est-card-head">
                <div class="est-card-title"><i class="fas fa-rocket"></i> Accesos Rápidos</div>
            </div>
            <div class="est-card-body">
                <a href="{{ route('estudiante.miHorario') }}" class="quick-btn">
                    <div class="qb-icon qi-navy"><i class="fas fa-calendar-alt"></i></div>
                    Mi Horario de Clases
                    <i class="fas fa-chevron-right qb-arrow"></i>
                </a>
                <a href="{{ route('estudiante.calificaciones') }}" class="quick-btn">
                    <div class="qb-icon qi-blue"><i class="fas fa-clipboard-check"></i></div>
                    Mis Calificaciones
                    <i class="fas fa-chevron-right qb-arrow"></i>
                </a>
                <a href="{{ route('estudiante.historial') }}" class="quick-btn">
                    <div class="qb-icon qi-teal"><i class="fas fa-history"></i></div>
                    Mi Historial Académico
                    <i class="fas fa-chevron-right qb-arrow"></i>
                </a>
                <a href="{{ route('notificaciones.index') }}" class="quick-btn">
                    <div class="qb-icon qi-amber"><i class="fas fa-bell"></i></div>
                    Mis Notificaciones
                    @if($notificacionesNoLeidas->count() > 0)
                        <span style="margin-left:.3rem;background:#ef4444;color:white;font-size:.65rem;font-weight:700;padding:.1rem .45rem;border-radius:999px;">
                            {{ $notificacionesNoLeidas->count() }}
                        </span>
                    @endif
                    <i class="fas fa-chevron-right qb-arrow"></i>
                </a>
                {{-- Única acción de escritura permitida --}}
                <a href="{{ route('cambiarcontrasenia.edit') }}" class="quick-btn">
                    <div class="qb-icon qi-navy"><i class="fas fa-key"></i></div>
                    Cambiar Contraseña
                    <i class="fas fa-chevron-right qb-arrow"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- ── FILA 2: Mis Materias + Tareas ── --}}
    <div class="est-grid-mid">

        <div class="est-card">
            <div class="est-card-head">
                <div class="est-card-title"><i class="fas fa-book-open"></i> Mis Materias</div>
            </div>
            <div class="est-card-body">
                @forelse($misMaterias as $mat)
                @php
                    $prom     = $mat['promedio'];
                    $barColor = $prom >= 90 ? '#10b981' : ($prom >= 70 ? '#4ec7d2' : ($prom >= 60 ? '#f59e0b' : '#ef4444'));
                @endphp
                <div class="materia-row">
                    <div class="mat-icon"><i class="fas fa-book"></i></div>
                    <div style="flex:1;min-width:0;">
                        <div class="mat-nombre">{{ $mat['nombre'] }}</div>
                        <div class="mat-prof">{{ $mat['profesor'] }}</div>
                        <div class="nota-bar-bg" style="margin-top:.4rem;">
                            <div class="nota-bar-fill" style="width:{{ $prom }}%;background:{{ $barColor }};"></div>
                        </div>
                    </div>
                    <div class="mat-right">
                        <div class="mat-prom" style="color:{{ $barColor }};">{{ $prom }}</div>
                        <div class="mat-asist">{{ $mat['asistencia'] }}% asist.</div>
                    </div>
                </div>
                @empty
                    <div class="est-empty"><i class="fas fa-book"></i><p>Sin materias asignadas</p></div>
                @endforelse
            </div>
        </div>

        <div class="est-card">
            <div class="est-card-head">
                <div class="est-card-title"><i class="fas fa-tasks"></i> Tareas Próximas</div>
                @if($tareasPendientes > 0)
                    <span style="background:rgba(245,158,11,.25);color:#fde68a;font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:999px;">
                        {{ $tareasPendientes }} pendientes
                    </span>
                @endif
            </div>
            <div class="est-card-body">
                @forelse($tareasProximas as $tarea)
                <div class="tarea-item">
                    <div class="tarea-dot"></div>
                    <div style="flex:1;min-width:0;">
                        <div class="tarea-mat">{{ $tarea['materia'] }}</div>
                        <div class="tarea-name text-truncate">{{ $tarea['titulo'] }}</div>
                        <div class="tarea-date">
                            <i class="fas fa-calendar" style="font-size:.6rem;"></i>
                            Entrega: {{ \Carbon\Carbon::parse($tarea['fecha_entrega'])->format('d/m/Y') }}
                        </div>
                    </div>
                    <span class="bpill b-amber" style="flex-shrink:0;">Pendiente</span>
                </div>
                @empty
                    <div class="est-empty"><i class="fas fa-check-double"></i><p>¡Sin tareas pendientes!</p></div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── FILA 3: Calificaciones + Observaciones (solo lectura) ── --}}
    <div class="est-grid-bot">

        {{-- Calificaciones --}}
        @if($calificaciones->isNotEmpty())
        <div class="est-card">
            <div class="est-card-head">
                <div class="est-card-title"><i class="fas fa-star"></i> Mi Historial de Calificaciones</div>
                <a href="{{ route('estudiante.historial') }}" class="est-card-link">
                    Ver completo <i class="fas fa-arrow-right" style="font-size:.7rem;"></i>
                </a>
            </div>
            <div class="est-card-body">
                @foreach($porPeriodo as $nombrePeriodo => $calsPeriodo)
                <div class="periodo-title">
                    <i class="fas fa-calendar-check"></i> {{ $nombrePeriodo }}
                    <span style="margin-left:auto;font-size:.68rem;color:var(--text-muted);font-weight:600;text-transform:none;">
                        {{ $calsPeriodo->count() }} materias
                    </span>
                </div>
                <div style="overflow-x:auto;margin-bottom:.5rem;">
                    <table class="cal-tbl">
                        <thead>
                            <tr><th>Materia</th><th class="tc">Nota</th><th class="tc">Estado</th></tr>
                        </thead>
                        <tbody>
                            @foreach($calsPeriodo->sortBy(fn($c) => $c->materia?->nombre) as $cal)
                            @php
                                $nota    = $cal->nota_final ?? $cal->nota ?? 0;
                                $nbClass = $nota >= 90 ? 'nb-a' : ($nota >= 70 ? 'nb-b' : ($nota >= 60 ? 'nb-c' : 'nb-d'));
                            @endphp
                            <tr>
                                <td><span style="font-weight:600;color:var(--blue-dark);">{{ $cal->materia?->nombre ?? '—' }}</span></td>
                                <td class="tc"><span class="nota-badge {{ $nbClass }}">{{ number_format($nota, 1) }}</span></td>
                                <td class="tc">
                                    <span class="bpill {{ $nota >= 60 ? 'b-green' : 'b-red' }}">
                                        {{ $nota >= 60 ? 'Aprobado' : 'Reprobado' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach

                @if($promedioReal)
                <div class="promedio-strip">
                    <div>
                        <div class="promedio-strip-label">Promedio General</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.55);">Todas las materias</div>
                    </div>
                    <div style="text-align:right;">
                        <div class="promedio-strip-val">{{ number_format($promedioReal, 1) }}</div>
                        <div style="font-size:.72rem;color:rgba(255,255,255,.6);">
                            {{ $promedioReal >= 60 ? '✓ Aprobado' : '✗ Reprobado' }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Observaciones — SOLO LECTURA, sin botones de acción --}}
        <div class="est-card">
            <div class="est-card-head">
                <div class="est-card-title">
                    <i class="fas fa-comment-alt"></i> Mis Observaciones
                </div>
                {{-- Sin enlace "Ver todas" — todo se muestra aquí mismo --}}
                @if($totalObservaciones > 0)
                    <span style="background:rgba(255,255,255,.15);color:rgba(255,255,255,.8);font-size:.72rem;font-weight:600;padding:.25rem .7rem;border-radius:6px;border:1px solid rgba(255,255,255,.25);">
                        {{ $totalObservaciones }} en total
                    </span>
                @endif
            </div>
            <div class="est-card-body">
                @if($misObservaciones->isEmpty())
                    <div class="est-empty">
                        <i class="fas fa-comment-slash"></i>
                        <p>No tienes observaciones registradas</p>
                    </div>
                @else
                    @foreach($misObservaciones as $obs)
                    @php
                        $tipoClass = match($obs->tipo) {
                            'academica'  => 'oi-academica',
                            'conductual' => 'oi-conductual',
                            'salud'      => 'oi-salud',
                            default      => 'oi-otro'
                        };
                        $tipoIcon  = match($obs->tipo) {
                            'academica'  => 'fa-book',
                            'conductual' => 'fa-user-shield',
                            'salud'      => 'fa-heartbeat',
                            default      => 'fa-ellipsis-h'
                        };
                        $tipoPill  = match($obs->tipo) {
                            'academica'  => 'b-blue',
                            'conductual' => 'b-red',
                            'salud'      => 'b-green',
                            default      => 'b-gray'
                        };
                    @endphp
                    <div class="obs-item">
                        <div class="obs-tipo-icon {{ $tipoClass }}">
                            <i class="fas {{ $tipoIcon }}"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.25rem;flex-wrap:wrap;">
                                <span class="bpill {{ $tipoPill }}" style="font-size:.67rem;">
                                    {{ ucfirst($obs->tipo) }}
                                </span>
                                @if($obs->profesor)
                                    <span style="font-size:.72rem;color:var(--text-muted);">
                                        <i class="fas fa-chalkboard-teacher" style="color:var(--teal);font-size:.65rem;"></i>
                                        {{ $obs->profesor->nombre ?? '—' }}
                                    </span>
                                @endif
                            </div>
                            {{-- Descripción completa, sin límite de caracteres para que pueda leer todo --}}
                            <div class="obs-desc">{{ $obs->descripcion }}</div>
                            <div class="obs-meta">
                                <i class="fas fa-clock" style="font-size:.65rem;"></i>
                                {{ $obs->created_at->diffForHumans() }}
                                &nbsp;·&nbsp;
                                {{ $obs->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                        {{-- Sin botones de editar, eliminar ni ninguna acción --}}
                    </div>
                    @endforeach

                    @if($totalObservaciones > 4)
                    <div style="text-align:center;padding-top:.85rem;border-top:1px solid #f1f5f9;margin-top:.5rem;">
                        <span style="font-size:.78rem;color:var(--text-muted);">
                            <i class="fas fa-info-circle me-1"></i>
                            Mostrando las 4 más recientes de {{ $totalObservaciones }} en total
                        </span>
                    </div>
                    @endif
                @endif
            </div>
        </div>

    </div>

</div>
@endsection