@extends('layouts.app')

@section('title', 'Dashboard Estudiante')
@section('page-title', 'Mi Panel Estudiantil')

@push('styles')
<style>
    :root {
        --blue-dark: #003b73; --blue-mid: #00508f;
        --teal: #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border: #e8edf4; --surface: #f5f8fc;
        --text-main: #0d2137; --text-muted: #6b7a90;
        --green: #10b981; --amber: #f59e0b; --red: #ef4444;
        --radius-lg: 14px; --radius-sm: 7px;
        --shadow-sm: 0 1px 4px rgba(0,59,115,0.07);
        --shadow-md: 0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Bienvenida ── */
    .est-welcome {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        border-radius: var(--radius-lg); padding: 1.5rem 1.75rem;
        margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1.25rem;
        box-shadow: var(--shadow-md); position: relative; overflow: hidden;
    }
    .est-welcome::after {
        content: ''; position: absolute; right: -30px; top: -30px;
        width: 120px; height: 120px; border-radius: 50%;
        background: rgba(78,199,210,.12); pointer-events: none;
    }
    .est-welcome-av {
        width: 68px; height: 68px; border-radius: 16px; flex-shrink: 0;
        background: rgba(255,255,255,.15); border: 3px solid var(--teal);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; color: white;
    }
    .est-welcome-name { font-size: 1.35rem; font-weight: 800; color: white; margin-bottom: .2rem; }
    .est-welcome-sub  { font-size: .82rem; color: rgba(255,255,255,.65); margin-bottom: .65rem; }
    .est-welcome-chips { display: flex; flex-wrap: wrap; gap: .4rem; }
    .est-chip {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 600;
    }
    .ec-teal  { background: rgba(78,199,210,.2); color: #a5f3fc; border: 1px solid rgba(78,199,210,.35); }
    .ec-white { background: rgba(255,255,255,.15); color: rgba(255,255,255,.85); border: 1px solid rgba(255,255,255,.25); }
    .ec-green { background: rgba(16,185,129,.25); color: #6ee7b7; border: 1px solid rgba(16,185,129,.4); }
    .ec-warn  { background: rgba(245,158,11,.25); color: #fde68a; border: 1px solid rgba(245,158,11,.4); }
    .est-welcome-link {
        margin-left: auto; flex-shrink: 0;
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .45rem 1rem; border-radius: 8px; font-size: .8rem; font-weight: 600;
        background: rgba(255,255,255,.15); color: white; border: 1px solid rgba(255,255,255,.3);
        text-decoration: none; transition: background .15s; white-space: nowrap;
    }
    .est-welcome-link:hover { background: rgba(255,255,255,.25); color: white; }

    /* ── Stats cards ── */
    .est-stats {
        display: grid; grid-template-columns: repeat(4,1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width:900px){ .est-stats { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:480px){ .est-stats { grid-template-columns: 1fr 1fr; gap:.75rem; } }

    .est-stat-card {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1rem 1.1rem;
        display: flex; align-items: center; gap: .9rem;
        box-shadow: var(--shadow-sm); text-decoration: none;
        transition: transform .18s, box-shadow .18s;
        position: relative; overflow: hidden;
    }
    .est-stat-card::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .sc-navy::before  { background: var(--blue-dark); }
    .sc-blue::before  { background: var(--blue-mid); }
    .sc-teal::before  { background: var(--teal); }
    .sc-amber::before { background: var(--amber); }
    .est-stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }

    .est-stat-icon {
        width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
    }
    .sc-navy  .est-stat-icon { background: rgba(0,59,115,.1);    color: var(--blue-dark); }
    .sc-blue  .est-stat-icon { background: rgba(0,80,143,.1);    color: var(--blue-mid); }
    .sc-teal  .est-stat-icon { background: var(--teal-light);    color: var(--teal); }
    .sc-amber .est-stat-icon { background: rgba(245,158,11,.1);  color: var(--amber); }

    .est-stat-lbl { font-size: .73rem; color: var(--text-muted); margin-bottom: .15rem; }
    .est-stat-val { font-size: 1.45rem; font-weight: 800; color: var(--blue-dark); line-height: 1; }
    .est-stat-arrow { margin-left: auto; color: #cbd5e1; font-size: .8rem; flex-shrink: 0; }

    /* ── Main grid ── */
    .est-main-grid {
        display: grid; grid-template-columns: 1fr 380px; gap: 1.25rem;
    }
    @media(max-width:1024px){ .est-main-grid { grid-template-columns: 1fr; } }

    /* ── Sección genérica ── */
    .est-section {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .est-section-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .85rem 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: .6rem;
    }
    .est-section-title { color: white; font-weight: 700; font-size: .92rem; display: flex; align-items: center; gap: .5rem; }
    .est-section-title i { color: var(--teal); }
    .est-section-link {
        font-size: .75rem; font-weight: 600; color: rgba(255,255,255,.8);
        text-decoration: none; padding: .25rem .7rem; border-radius: 6px;
        background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
        transition: background .15s; white-space: nowrap;
    }
    .est-section-link:hover { background: rgba(255,255,255,.25); color: white; }
    .est-section-body { padding: 1rem 1.1rem; }

    /* ── Notificaciones ── */
    .notif-item {
        border-left: 4px solid var(--teal); border-radius: 8px;
        padding: .85rem 1rem; margin-bottom: .5rem;
        background: var(--surface); transition: background .15s;
    }
    .notif-item:last-child { margin-bottom: 0; }
    .notif-item.leida { border-left-color: #cbd5e1; background: #f8fafc; }
    .notif-item:hover { background: rgba(78,199,210,.05); }
    .notif-titulo { font-weight: 600; color: var(--blue-dark); font-size: .88rem; display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
    .notif-msg   { font-size: .8rem; color: var(--text-muted); margin: .3rem 0 .4rem; line-height: 1.5; }
    .notif-time  { font-size: .72rem; color: var(--text-muted); display: flex; align-items: center; gap: .3rem; }
    .notif-nueva {
        display: inline-flex; align-items: center;
        padding: .12rem .5rem; border-radius: 999px; font-size: .65rem; font-weight: 700;
        background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35);
    }
    .btn-marcar {
        width: 26px; height: 26px; border-radius: 6px; font-size: .72rem;
        border: 1.5px solid var(--teal); color: var(--teal); background: white;
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .15s; flex-shrink: 0;
    }
    .btn-marcar:hover { background: var(--teal); color: white; }
    .notif-empty { text-align: center; padding: 2.5rem 1rem; }
    .notif-empty i { font-size: 2rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }
    .notif-empty p { font-size: .83rem; color: var(--text-muted); margin: 0; }

    /* ── Accesos rápidos ── */
    .quick-btn {
        display: flex; align-items: center; gap: .75rem;
        padding: .75rem 1rem; border-radius: 9px; text-decoration: none;
        border: 1.5px solid var(--border); background: var(--surface);
        color: var(--text-main); font-weight: 600; font-size: .85rem;
        transition: all .15s; margin-bottom: .5rem;
    }
    .quick-btn:last-child { margin-bottom: 0; }
    .quick-btn:hover { border-color: var(--teal); background: rgba(78,199,210,.05); color: var(--blue-dark); transform: translateX(3px); }
    .quick-btn-icon {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .88rem;
    }
    .qi-navy  { background: rgba(0,59,115,.1);   color: var(--blue-dark); }
    .qi-blue  { background: rgba(0,80,143,.1);   color: var(--blue-mid); }
    .qi-teal  { background: var(--teal-light);   color: var(--teal); }
    .qi-amber { background: rgba(245,158,11,.1); color: var(--amber); }
    .quick-btn-arrow { margin-left: auto; color: #cbd5e1; font-size: .75rem; flex-shrink: 0; }

    @media(max-width:600px) {
        .est-welcome { flex-wrap: wrap; }
        .est-welcome-link { margin-left: 0; }
    }
</style>
@endpush

@section('content')
@php
    $user           = auth()->user();
    $estudiante     = $user->estudiante;
    $noLeidas       = $user->total_notificaciones_no_leidas;
    $notificaciones = $user->notificacionesPermitidas()->take(5)->get();
@endphp

<div>

    {{-- ── BIENVENIDA ── --}}
    <div class="est-welcome">
        <div class="est-welcome-av">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div style="flex:1;min-width:0;">
            <div class="est-welcome-name">Hola, {{ $user->name }}</div>
            <div class="est-welcome-sub">Bienvenido a tu portal estudiantil</div>
            @if($estudiante)
                <div class="est-welcome-chips">
                    <span class="est-chip ec-teal">
                        <i class="fas fa-graduation-cap" style="font-size:.65rem;"></i>
                        {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                    </span>
                    <span class="est-chip ec-white">
                        <i class="fas fa-id-card" style="font-size:.65rem;"></i>
                        DNI: {{ $estudiante->dni }}
                    </span>
                    <span class="est-chip ec-green">
                        <i class="fas fa-circle" style="font-size:.4rem;"></i>
                        {{ ucfirst($estudiante->estado) }}
                    </span>
                </div>
            @else
                <span class="est-chip ec-warn">
                    <i class="fas fa-exclamation-triangle" style="font-size:.65rem;"></i>
                    Sin perfil de estudiante vinculado
                </span>
            @endif
        </div>
        <a href="{{ route('estado-solicitud') }}" class="est-welcome-link">
            <i class="fas fa-question-circle"></i> Estado de Solicitud
        </a>
    </div>

    {{-- ── STATS ── --}}
    <div class="est-stats">
        <a href="{{ route('estudiante.miHorario') }}" class="est-stat-card sc-navy">
            <div class="est-stat-icon"><i class="fas fa-calendar-alt"></i></div>
            <div>
                <div class="est-stat-lbl">Mi Horario</div>
                <div class="est-stat-val">{{ $totalHoras ?? '—' }}</div>
            </div>
            <i class="fas fa-chevron-right est-stat-arrow"></i>
        </a>
        <a href="{{ route('estudiante.calificaciones') }}" class="est-stat-card sc-blue">
            <div class="est-stat-icon"><i class="fas fa-clipboard-check"></i></div>
            <div>
                <div class="est-stat-lbl">Calificaciones</div>
                <div class="est-stat-val">{{ $totalCalificaciones ?? '—' }}</div>
            </div>
            <i class="fas fa-chevron-right est-stat-arrow"></i>
        </a>
        <a href="{{ route('estado-solicitud') }}" class="est-stat-card sc-teal">
            <div class="est-stat-icon"><i class="fas fa-file-signature"></i></div>
            <div>
                <div class="est-stat-lbl">Mi Matrícula</div>
                <div class="est-stat-val" style="font-size:1rem;padding-top:.15rem;">Estado</div>
            </div>
            <i class="fas fa-chevron-right est-stat-arrow"></i>
        </a>
        <a href="{{ route('notificaciones.index') }}" class="est-stat-card sc-amber">
            <div class="est-stat-icon"><i class="fas fa-bell"></i></div>
            <div>
                <div class="est-stat-lbl">Notificaciones</div>
                <div class="est-stat-val">
                    {{ $noLeidas }}
                    @if($noLeidas > 0)
                        <span style="font-size:.65rem;font-weight:700;background:#ef4444;color:white;padding:.1rem .4rem;border-radius:999px;margin-left:.25rem;">Sin leer</span>
                    @endif
                </div>
            </div>
            <i class="fas fa-chevron-right est-stat-arrow"></i>
        </a>
    </div>

    {{-- ── MAIN GRID ── --}}
    <div class="est-main-grid">

        {{-- Notificaciones recientes --}}
        <div class="est-section">
            <div class="est-section-head">
                <div class="est-section-title">
                    <i class="fas fa-bell"></i> Notificaciones Recientes
                </div>
                <a href="{{ route('notificaciones.index') }}" class="est-section-link">Ver todas</a>
            </div>
            <div class="est-section-body">
                @if($notificaciones->isEmpty())
                    <div class="notif-empty">
                        <i class="fas fa-bell-slash"></i>
                        <p>No tienes notificaciones nuevas</p>
                    </div>
                @else
                    @foreach($notificaciones as $notif)
                    <div class="notif-item {{ $notif->leida ? 'leida' : '' }}">
                        <div style="display:flex;align-items:flex-start;gap:.75rem;">
                            <div style="flex:1;min-width:0;">
                                <div class="notif-titulo">
                                    @switch($notif->tipo)
                                        @case('calificacion') <i class="fas fa-star" style="color:var(--amber);font-size:.82rem;"></i> @break
                                        @case('horario')      <i class="fas fa-calendar-alt" style="color:var(--teal);font-size:.82rem;"></i> @break
                                        @case('observacion')  <i class="fas fa-comment-alt" style="color:#6366f1;font-size:.82rem;"></i> @break
                                        @case('matricula')    <i class="fas fa-file-signature" style="color:var(--blue-mid);font-size:.82rem;"></i> @break
                                        @default              <i class="fas fa-info-circle" style="color:var(--teal);font-size:.82rem;"></i>
                                    @endswitch
                                    {{ $notif->titulo }}
                                    @if(!$notif->leida)
                                        <span class="notif-nueva">Nueva</span>
                                    @endif
                                </div>
                                <div class="notif-msg">{{ $notif->mensaje }}</div>
                                <div class="notif-time">
                                    <i class="fas fa-clock" style="font-size:.65rem;"></i>
                                    {{ $notif->created_at->diffForHumans() }}
                                </div>
                            </div>
                            @if(!$notif->leida)
                                <form action="{{ route('notificaciones.marcarLeida', $notif->id) }}"
                                      method="POST" style="flex-shrink:0;">
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

        {{-- Accesos rápidos --}}
        <div class="est-section">
            <div class="est-section-head">
                <div class="est-section-title">
                    <i class="fas fa-rocket"></i> Accesos Rápidos
                </div>
            </div>
            <div class="est-section-body">

                <a href="{{ route('estudiante.miHorario') }}" class="quick-btn">
                    <div class="quick-btn-icon qi-navy"><i class="fas fa-calendar-alt"></i></div>
                    Mi Horario de Clases
                    <i class="fas fa-chevron-right quick-btn-arrow"></i>
                </a>

                <a href="{{ route('estudiante.calificaciones') }}" class="quick-btn">
                    <div class="quick-btn-icon qi-blue"><i class="fas fa-clipboard-check"></i></div>
                    Mis Calificaciones
                    <i class="fas fa-chevron-right quick-btn-arrow"></i>
                </a>

                <a href="{{ route('estado-solicitud') }}" class="quick-btn">
                    <div class="quick-btn-icon qi-teal"><i class="fas fa-file-signature"></i></div>
                    Estado de mi Matrícula
                    <i class="fas fa-chevron-right quick-btn-arrow"></i>
                </a>

                <a href="{{ route('notificaciones.index') }}" class="quick-btn">
                    <div class="quick-btn-icon qi-amber"><i class="fas fa-bell"></i></div>
                    Todas mis Notificaciones
                    @if($noLeidas > 0)
                        <span style="margin-left:.3rem;background:#ef4444;color:white;font-size:.65rem;font-weight:700;padding:.1rem .45rem;border-radius:999px;">{{ $noLeidas }}</span>
                    @endif
                    <i class="fas fa-chevron-right quick-btn-arrow"></i>
                </a>

                <a href="{{ route('notificaciones.preferencias') }}" class="quick-btn">
                    <div class="quick-btn-icon qi-blue"><i class="fas fa-sliders-h"></i></div>
                    Preferencias de Notificación
                    <i class="fas fa-chevron-right quick-btn-arrow"></i>
                </a>

                <a href="{{ route('cambiarcontrasenia.edit') }}" class="quick-btn">
                    <div class="quick-btn-icon qi-navy"><i class="fas fa-key"></i></div>
                    Cambiar Contraseña
                    <i class="fas fa-chevron-right quick-btn-arrow"></i>
                </a>

            </div>
        </div>

    </div>

</div>
@endsection