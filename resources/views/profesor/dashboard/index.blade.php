@extends('layouts.app')

@section('title', 'Dashboard - Profesor')
@section('page-title', 'Panel del Profesor')

@push('styles')
<style>
:root {
    --navy:       #002d5a;
    --blue:       #00508f;
    --blue-mid:   #003b73;
    --teal:       #4ec7d2;
    --teal-light: rgba(78,199,210,.12);
    --border:     #e8edf4;
    --surface:    #f5f8fc;
    --muted:      #6b7a90;
    --amber:      #f59e0b;
    --shadow-sm:  0 1px 4px rgba(0,59,115,.07);
    --shadow-md:  0 4px 16px rgba(0,59,115,.10);
    --r:          14px;
}

.pd-wrap {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

/* ════════════ HEADER ════════════ */
.pd-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 2rem 1.7rem;
    position: relative;
    overflow: hidden;
}
.pd-header::before {
    content: ''; position: absolute; right: -50px; top: -50px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(78,199,210,.13); pointer-events: none;
}
.pd-header::after {
    content: ''; position: absolute; right: 100px; bottom: -45px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.pd-header-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.4rem; flex-wrap: wrap;
}
.pd-avatar {
    width: 80px; height: 80px; border-radius: 18px;
    border: 3px solid rgba(78,199,210,.7);
    background: rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 20px rgba(0,0,0,.25); flex-shrink: 0;
}
.pd-avatar i { color: white; font-size: 2rem; }
.pd-header h2 {
    font-size: 1.45rem; font-weight: 800; color: white;
    margin: 0 0 .5rem; text-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.pd-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .7rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.15); color: white;
    margin-right: .4rem;
}

/* ════════════ BODY ════════════ */
.pd-body {
    background: white;
    border: 1px solid var(--border);
    border-top: none;
    border-radius: 0 0 var(--r) var(--r);
    box-shadow: var(--shadow-md);
    padding: 1.4rem 1.7rem;
    margin-bottom: 1.3rem;
}

/* ════════════ SEC TITLE ════════════ */
.pd-sec {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--blue); margin-bottom: .95rem;
    padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.1);
}
.pd-sec i { color: var(--teal); font-size: .88rem; }

/* ════════════ STATS ════════════ */
.pd-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.4rem;
}
.pd-stat {
    background: white;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.1rem 1.2rem;
    display: flex; align-items: center; gap: 1rem;
    box-shadow: var(--shadow-sm);
    position: relative; overflow: hidden;
    transition: transform .2s, box-shadow .2s;
}
.pd-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
.pd-stat::before {
    content: ''; position: absolute;
    top: 0; left: 0; width: 4px; height: 100%;
    border-radius: 4px 0 0 4px;
}
.pd-stat-1::before { background: var(--teal); }
.pd-stat-2::before { background: var(--blue); }
.pd-stat-3::before { background: var(--amber); }
.pd-stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.15rem;
}
.pd-stat-1 .pd-stat-icon { background: var(--teal-light); color: var(--teal); }
.pd-stat-2 .pd-stat-icon { background: rgba(0,80,143,.1);  color: var(--blue); }
.pd-stat-3 .pd-stat-icon { background: rgba(245,158,11,.1); color: var(--amber); }
.pd-stat-lbl {
    font-size: .67rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--muted); margin-bottom: .15rem;
}
.pd-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-mid); line-height: 1; }
.pd-stat-sub { font-size: .72rem; color: var(--muted); margin-top: .1rem; }

/* ════════════ QUICK ACCESS ════════════ */
.pd-quick {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .85rem;
}
.pd-qcard {
    border-radius: 12px;
    text-decoration: none;
    overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    display: block;
}
.pd-qcard:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,59,115,.2);
    text-decoration: none;
}
.pd-qcard-inner {
    padding: 1.3rem .9rem;
    text-align: center;
    display: flex; flex-direction: column;
    align-items: center; gap: .5rem;
}
.pd-qcard-inner i { font-size: 1.75rem; color: white; }
.pd-qcard-inner span { font-size: .76rem; font-weight: 700; color: white; line-height: 1.2; }
.qc-1 { background: linear-gradient(135deg, #4ec7d2, #00508f); }
.qc-2 { background: linear-gradient(135deg, #00508f, #003b73); }
.qc-3 { background: linear-gradient(135deg, #003b73, #00508f); }
.qc-4 { background: linear-gradient(135deg, #00508f, #4ec7d2); }

/* ════════════ BOTTOM PANELS ════════════ */
.pd-bottom {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.1rem;
    margin-bottom: 1.3rem;
}
.pd-panel {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--r);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.pd-panel-head {
    background: linear-gradient(135deg, rgba(0,80,143,.07), rgba(78,199,210,.07));
    border-bottom: 1.5px solid var(--border);
    padding: .85rem 1.1rem;
    display: flex; align-items: center; gap: .5rem;
    font-size: .8rem; font-weight: 700; color: var(--blue-mid);
}
.pd-panel-head i { color: var(--teal); }
.pd-panel-body { padding: 1rem 1.1rem; }
.pd-empty {
    text-align: center; padding: 2rem 1rem; color: var(--muted);
}
.pd-empty i { font-size: 1.8rem; display: block; margin-bottom: .5rem; color: rgba(78,199,210,.4); }
.pd-empty p  { font-size: .82rem; margin: 0; }

/* ════════════ BANNER ════════════ */
.pd-banner {
    background: white;
    border: 1px solid var(--border);
    border-left: 4px solid var(--teal);
    border-radius: var(--r);
    padding: 1rem 1.3rem;
    display: flex; align-items: center; gap: 1rem;
    box-shadow: var(--shadow-sm);
}
.pd-banner > i   { color: var(--teal); font-size: 1.5rem; flex-shrink: 0; }
.pd-banner h6    { font-size: .85rem; font-weight: 700; color: var(--blue-mid); margin: 0 0 .2rem; }
.pd-banner p     { font-size: .78rem; color: var(--muted); margin: 0; }

/* ════════════ RESPONSIVE ════════════ */
@media(max-width: 992px) {
    .pd-quick { grid-template-columns: repeat(2, 1fr); }
}
@media(max-width: 768px) {
    .pd-stats  { grid-template-columns: 1fr 1fr; }
    .pd-bottom { grid-template-columns: 1fr; }
    .pd-header { padding: 1.5rem 1.2rem; }
    .pd-body   { padding: 1.1rem 1.2rem; }
}
@media(max-width: 480px) {
    .pd-stats       { grid-template-columns: 1fr; }
    .pd-quick       { grid-template-columns: 1fr 1fr; gap: .6rem; }
    .pd-avatar      { width: 60px; height: 60px; border-radius: 14px; }
    .pd-avatar i    { font-size: 1.5rem; }
    .pd-header h2   { font-size: 1.1rem; }
    .pd-header      { padding: 1.2rem 1rem; }
    .pd-body        { padding: 1rem; }
    .pd-qcard-inner { padding: .9rem .7rem; }
    .pd-qcard-inner i { font-size: 1.4rem; }
    .pd-stat-num    { font-size: 1.45rem; }
    .pd-banner      { flex-direction: column; align-items: flex-start; gap: .5rem; }
}
</style>
@endpush

@section('content')
<div class="pd-wrap">

    {{-- ── HEADER ── --}}
    <div class="pd-header">
        <div class="pd-header-inner">
            <div class="pd-avatar">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <h2>Bienvenido, {{ auth()->user()->name }}</h2>
                <span class="pd-badge"><i class="fas fa-user-tie"></i> Profesor</span>
                <span class="pd-badge"><i class="fas fa-calendar"></i> {{ now()->format('Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div class="pd-body">

        {{-- Stats --}}
        <div class="pd-sec"><i class="fas fa-chart-bar"></i> Resumen General</div>

        <div class="pd-stats">
            <div class="pd-stat pd-stat-1">
                <div class="pd-stat-icon"><i class="fas fa-users"></i></div>
                <div>
                    <div class="pd-stat-lbl">Mis Estudiantes</div>
                    <div class="pd-stat-num">—</div>
                    <div class="pd-stat-sub">Asignados</div>
                </div>
            </div>
            <div class="pd-stat pd-stat-2">
                <div class="pd-stat-icon"><i class="fas fa-book-open"></i></div>
                <div>
                    <div class="pd-stat-lbl">Mis Cursos</div>
                    <div class="pd-stat-num">—</div>
                    <div class="pd-stat-sub">Activos</div>
                </div>
            </div>
            <div class="pd-stat pd-stat-3">
                <div class="pd-stat-icon"><i class="fas fa-clipboard-list"></i></div>
                <div>
                    <div class="pd-stat-lbl">Calificaciones</div>
                    <div class="pd-stat-num">—</div>
                    <div class="pd-stat-sub">Pendientes</div>
                </div>
            </div>
        </div>

        {{-- Accesos rápidos --}}
<div class="pd-sec"><i class="fas fa-rocket"></i> Accesos Rápidos</div>

<div class="pd-quick">

    {{-- Mis Estudiantes → va a Mis Cursos para elegir el grado --}}
    <a href="{{ route('profesor.mis-cursos') }}" class="pd-qcard qc-1">
        <div class="pd-qcard-inner">
            <i class="fas fa-users"></i>
            <span>Mis Estudiantes</span>
        </div>
    </a>

    {{-- Mis Cursos --}}
    <a href="{{ route('profesor.mis-cursos') }}" class="pd-qcard qc-2">
        <div class="pd-qcard-inner">
            <i class="fas fa-book"></i>
            <span>Mis Cursos</span>
        </div>
    </a>

    {{-- Calificaciones — no hay ruta aún --}}
    <a href="{{ route('registrarcalificaciones.index') }}" class="pd-qcard qc-3">
        <div class="pd-qcard-inner">
            <i class="fas fa-clipboard-check"></i>
            <span>Calificaciones</span>
        </div>
    </a>

    {{-- Mi Horario --}}
    <a href="{{ route('profesor.miHorario') }}" class="pd-qcard qc-4">
        <div class="pd-qcard-inner">
            <i class="fas fa-calendar-alt"></i>
            <span>Mi Horario</span>
        </div>
    </a>

</div>

    </div>{{-- fin pd-body --}}

    {{-- ── PANELES INFERIORES ── --}}
    <div class="pd-bottom">
        <div class="pd-panel">
            <div class="pd-panel-head">
                <i class="fas fa-bullhorn"></i> Anuncios Recientes
            </div>
            <div class="pd-panel-body">
                <div class="pd-empty">
                    <i class="fas fa-inbox"></i>
                    <p>No hay anuncios recientes</p>
                </div>
            </div>
        </div>
        <div class="pd-panel">
            <div class="pd-panel-head">
                <i class="fas fa-calendar-check"></i> Próximas Actividades
            </div>
            <div class="pd-panel-body">
                <div class="pd-empty">
                    <i class="fas fa-calendar"></i>
                    <p>No hay actividades programadas</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BANNER ── --}}
    <div class="pd-banner">
        <i class="fas fa-info-circle"></i>
        <div>
            <h6>Portal en Construcción</h6>
            <p>Las funcionalidades completas del portal de profesores estarán disponibles próximamente.</p>
        </div>
    </div>

</div>
@endsection
