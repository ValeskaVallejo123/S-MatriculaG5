@extends('layouts.app')

@section('title', 'Dashboard Estudiante')
@section('page-title', 'Mi Panel Estudiantil')

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

.est-portal { font-family: 'Inter', sans-serif; display: flex; flex-direction: column; gap: 1.25rem; }

/* ── Banner ── */
.welcome-card {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    border-radius: 14px; padding: 1.6rem 1.75rem;
    display: flex; align-items: center; gap: 1.25rem;
    box-shadow: 0 4px 20px rgba(0,59,115,.2);
    position: relative; overflow: hidden;
}
.welcome-card::before {
    content:''; position:absolute; top:-40%; right:-4%;
    width:210px; height:210px; background:rgba(255,255,255,.06); border-radius:50%;
}
.welcome-card::after {
    content:''; position:absolute; bottom:-50%; right:14%;
    width:140px; height:140px; background:rgba(255,255,255,.04); border-radius:50%;
}
.welcome-avatar {
    width: 64px; height: 64px; border-radius: 14px; flex-shrink: 0;
    background: rgba(255,255,255,.15); border: 2.5px solid var(--cyan);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; color: #fff; position: relative; z-index: 1;
}
.welcome-info { position: relative; z-index: 1; flex: 1; }
.welcome-info h4 { color: #fff; font-weight: 700; margin: 0 0 .2rem; font-size: 1.15rem; }
.welcome-info p  { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0 0 .6rem; }
.welcome-badges  { display: flex; flex-wrap: wrap; gap: .4rem; }
.w-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .7rem; border-radius: 999px; font-size: .72rem; font-weight: 600;
}
.w-badge-cyan  { background: rgba(78,199,210,.25); color: #fff; border: 1px solid rgba(78,199,210,.5); }
.w-badge-navy  { background: rgba(255,255,255,.12); color: #fff; border: 1px solid rgba(255,255,255,.25); }
.w-badge-green { background: rgba(16,185,129,.25); color: #fff; border: 1px solid rgba(16,185,129,.5); }
.w-badge-warn  { background: rgba(234,179,8,.2); color: #fde047; border: 1px solid rgba(234,179,8,.4); }

/* ── Stats ── */
.stats-row {
    display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem;
}
@media(max-width:900px){ .stats-row { grid-template-columns: repeat(2,1fr); } }
@media(max-width:500px){ .stats-row { grid-template-columns: 1fr; } }

.stat-card {
    background: #fff; border: 1px solid var(--border); border-radius: 12px;
    padding: 1rem 1.1rem; display: flex; align-items: center; gap: .85rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); position: relative; overflow: hidden;
    transition: box-shadow .15s;
}
.stat-card:hover { box-shadow: 0 4px 14px rgba(0,80,143,.1); }
.stat-stripe {
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 4px; border-radius: 12px 0 0 12px;
}
.stat-icon {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1rem;
}
.stat-label { font-size: .7rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; margin-bottom: .15rem; }
.stat-value { font-size: 1.45rem; font-weight: 800; color: var(--blue-dark); line-height: 1; }

.notif-item {
    border-left: 3.5px solid var(--cyan); border-radius: 8px;
    padding: .85rem 1rem; background: #fff;
    transition: background .15s; margin-bottom: .6rem;
}
.notif-item:last-child { margin-bottom: 0; }
.notif-item.leida { border-left-color: #cbd5e1; background: var(--surface); }
.notif-item:hover { background: var(--cyan-light); }
.notif-title  { font-weight: 700; color: var(--blue-dark); font-size: .84rem; margin-bottom: .2rem; }
.notif-msg    { color: var(--muted); font-size: .78rem; margin-bottom: .25rem; }
.notif-time   { color: var(--subtle); font-size: .72rem; }

.badge-nueva {
    display: inline-flex; align-items: center;
    padding: .15rem .55rem; border-radius: 999px;
    background: var(--cyan-light); color: var(--blue-mid);
    font-size: .65rem; font-weight: 700; border: 1px solid var(--cyan-border);
}
.btn-marcar {
    display: inline-flex; align-items: center; justify-content: center;
    width: 26px; height: 26px; border-radius: 6px; border: 1.5px solid var(--cyan-border);
    background: var(--cyan-light); color: var(--blue-mid); cursor: pointer;
    font-size: .72rem; transition: all .15s; flex-shrink: 0;
}
.btn-marcar:hover { background: var(--cyan); color: #fff; border-color: var(--cyan); }

.info-card { transition: transform .15s, box-shadow .15s; }
.info-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,59,115,.12) !important; }
</style>
@endpush

@section('content')
@php
    $user       = auth()->user();
    $estudiante = $user->estudiante;
    $noLeidas   = $user->total_notificaciones_no_leidas;
    $notificaciones = $user->notificacionesPermitidas()->take(5)->get();
@endphp

<div class="est-portal">

    {{-- ══ Banner bienvenida ══ --}}
    <div class="welcome-card">
        <div class="welcome-avatar">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="welcome-info">
            <h4>Hola, {{ $user->name }}</h4>
            <p>Bienvenido a tu portal estudiantil · {{ now()->format('d/m/Y') }}</p>
            @if($estudiante)
                <div class="welcome-badges">
                    <span class="w-badge w-badge-cyan">
                        <i class="fas fa-graduation-cap"></i>
                        {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                    </span>
                    <span class="w-badge w-badge-navy">
                        <i class="fas fa-id-card"></i> {{ $estudiante->dni }}
                    </span>
                    <span class="w-badge w-badge-green">
                        <i class="fas fa-circle" style="font-size:.4rem;"></i> {{ ucfirst($estudiante->estado) }}
                    </span>
                </div>
            @else
                <span class="w-badge w-badge-warn">
                    <i class="fas fa-exclamation-triangle"></i> Sin perfil de estudiante vinculado
                </span>
            @endif
        </div>
    </div>

    

    {{-- ══ Tarjetas resumen (clicables) ══ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <a href="{{ route('estudiante.miHorario') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 info-card"
                     style="border-radius:10px;border-left:4px solid #003b73 !important;cursor:pointer;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:50px;height:50px;background:rgba(0,59,115,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-calendar-alt fa-lg" style="color:#003b73;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 small">Mi Horario</p>
                            <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $totalHoras ?? '—' }}</h3>
                        </div>
                        <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:0.8rem;"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('estudiante.calificaciones') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 info-card"
                     style="border-radius:10px;border-left:4px solid #00508f !important;cursor:pointer;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:50px;height:50px;background:rgba(0,80,143,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-clipboard-check fa-lg" style="color:#00508f;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 small">Calificaciones</p>
                            <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $totalCalificaciones ?? '—' }}</h3>
                        </div>
                        <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:0.8rem;"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('estado-solicitud') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 info-card"
                     style="border-radius:10px;border-left:4px solid #4ec7d2 !important;cursor:pointer;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:50px;height:50px;background:rgba(78,199,210,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-file-signature fa-lg" style="color:#4ec7d2;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 small">Mi Matrícula</p>
                            <h3 class="mb-0 fw-bold" style="color:#003b73;">Estado</h3>
                        </div>
                        <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:0.8rem;"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('notificaciones.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 info-card"
                     style="border-radius:10px;border-left:4px solid #f59e0b !important;cursor:pointer;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:50px;height:50px;background:rgba(245,158,11,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-bell fa-lg" style="color:#f59e0b;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 small">Notificaciones</p>
                            <h3 class="mb-0 fw-bold" style="color:#003b73;">
                                {{ $noLeidas }}
                                @if($noLeidas > 0)
                                    <span class="badge bg-danger ms-1" style="font-size:0.65rem;">Sin leer</span>
                                @endif
                            </h3>
                        </div>
                        <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:0.8rem;"></i>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- ══ Notificaciones + Accesos rápidos ══ --}}
    <div class="row g-4">

        {{-- Notificaciones recientes --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                <div class="card-header border-0 py-3 px-4"
                     style="background:linear-gradient(135deg,#00508f 0%,#4ec7d2 100%);border-radius:12px 12px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fas fa-bell me-2"></i>Notificaciones Recientes
                        </h5>
                        <a href="{{ route('notificaciones.index') }}" class="btn btn-light btn-sm fw-semibold">
                            Ver todas
                        </a>
                    </div>
                </div>
                <div class="card-body p-3">
                    @if($notificaciones->isEmpty())
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-bell-slash fa-2x mb-2" style="color:#cbd5e1;"></i>
                            <p class="mb-0 small">No tienes notificaciones nuevas.</p>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-2">
                            @foreach($notificaciones as $notif)
                                <div class="notif-item {{ $notif->leida ? 'leida' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                @switch($notif->tipo)
                                                    @case('calificacion')
                                                        <i class="fas fa-star" style="color:#f59e0b;font-size:0.85rem;"></i>
                                                        @break
                                                    @case('horario')
                                                        <i class="fas fa-calendar-alt" style="color:#4ec7d2;font-size:0.85rem;"></i>
                                                        @break
                                                    @case('observacion')
                                                        <i class="fas fa-comment-alt" style="color:#6366f1;font-size:0.85rem;"></i>
                                                        @break
                                                    @case('matricula')
                                                        <i class="fas fa-file-signature" style="color:#00508f;font-size:0.85rem;"></i>
                                                        @break
                                                    @default
                                                        <i class="fas fa-info-circle" style="color:#4ec7d2;font-size:0.85rem;"></i>
                                                @endswitch
                                                <span class="fw-semibold" style="color:#003b73;font-size:0.9rem;">
                                                    {{ $notif->titulo }}
                                                </span>
                                                @if(!$notif->leida)
                                                    <span class="badge-nueva">Nueva</span>
                                                @endif
                                            </div>
                                            <p class="notif-msg">{{ $notif->mensaje }}</p>
                                            <small class="notif-time">
                                                <i class="fas fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        @if(!$notif->leida)
                                            <form action="{{ route('notificaciones.marcarLeida', $notif->id) }}"
                                                  method="POST" class="flex-shrink-0">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-marcar" title="Marcar como leída">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Accesos rápidos --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                <div class="card-header border-0 py-3 px-4"
                     style="background:linear-gradient(135deg,#003b73 0%,#00508f 100%);border-radius:12px 12px 0 0;">
                    <h5 class="text-white fw-bold mb-0">
                        <i class="fas fa-rocket me-2"></i>Accesos Rápidos
                    </h5>
                </div>
                <div class="card-body p-3 d-flex flex-column gap-2">

                    <a href="{{ route('estudiante.miHorario') }}" class="text-decoration-none">
                        <div class="card border-0 info-card" style="background:rgba(0,80,143,0.06);border:1px solid #00508f !important;border-radius:8px;">
                            <div class="card-body py-2 px-3 d-flex align-items-center gap-3">
                                <i class="fas fa-calendar-alt" style="color:#00508f;width:20px;text-align:center;"></i>
                                <span class="fw-semibold" style="color:#003b73;font-size:0.9rem;">Mi Horario de Clases</span>
                                <i class="fas fa-chevron-right ms-auto" style="color:#cbd5e1;font-size:0.75rem;"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('estudiante.calificaciones') }}" class="text-decoration-none">
                        <div class="card border-0 info-card" style="background:rgba(78,199,210,0.06);border:1px solid #4ec7d2 !important;border-radius:8px;">
                            <div class="card-body py-2 px-3 d-flex align-items-center gap-3">
                                <i class="fas fa-clipboard-check" style="color:#4ec7d2;width:20px;text-align:center;"></i>
                                <span class="fw-semibold" style="color:#003b73;font-size:0.9rem;">Mis Calificaciones</span>
                                <i class="fas fa-chevron-right ms-auto" style="color:#cbd5e1;font-size:0.75rem;"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('estado-solicitud') }}" class="text-decoration-none">
                        <div class="card border-0 info-card" style="background:rgba(78,199,210,0.06);border:1px solid #4ec7d2 !important;border-radius:8px;">
                            <div class="card-body py-2 px-3 d-flex align-items-center gap-3">
                                <i class="fas fa-file-signature" style="color:#4ec7d2;width:20px;text-align:center;"></i>
                                <span class="fw-semibold" style="color:#003b73;font-size:0.9rem;">Estado de mi Matrícula</span>
                                <i class="fas fa-chevron-right ms-auto" style="color:#cbd5e1;font-size:0.75rem;"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('notificaciones.index') }}" class="text-decoration-none">
                        <div class="card border-0 info-card" style="background:rgba(245,158,11,0.06);border:1px solid #f59e0b !important;border-radius:8px;">
                            <div class="card-body py-2 px-3 d-flex align-items-center gap-3">
                                <i class="fas fa-bell" style="color:#d97706;width:20px;text-align:center;"></i>
                                <span class="fw-semibold" style="color:#003b73;font-size:0.9rem;">
                                    Todas mis Notificaciones
                                    @if($noLeidas > 0)
                                        <span class="badge bg-danger ms-1" style="font-size:0.65rem;">{{ $noLeidas }}</span>
                                    @endif
                                </span>
                                <i class="fas fa-chevron-right ms-auto" style="color:#cbd5e1;font-size:0.75rem;"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('notificaciones.preferencias') }}" class="text-decoration-none">
                        <div class="card border-0 info-card" style="background:rgba(0,59,115,0.06);border:1px solid #003b73 !important;border-radius:8px;">
                            <div class="card-body py-2 px-3 d-flex align-items-center gap-3">
                                <i class="fas fa-sliders-h" style="color:#003b73;width:20px;text-align:center;"></i>
                                <span class="fw-semibold" style="color:#003b73;font-size:0.9rem;">Preferencias de Notificación</span>
                                <i class="fas fa-chevron-right ms-auto" style="color:#cbd5e1;font-size:0.75rem;"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('cambiarcontrasenia.edit') }}" class="text-decoration-none">
                        <div class="card border-0 info-card" style="background:rgba(124,58,237,0.06);border:1px solid #7c3aed !important;border-radius:8px;">
                            <div class="card-body py-2 px-3 d-flex align-items-center gap-3">
                                <i class="fas fa-key" style="color:#7c3aed;width:20px;text-align:center;"></i>
                                <span class="fw-semibold" style="color:#003b73;font-size:0.9rem;">Cambiar Contraseña</span>
                                <i class="fas fa-chevron-right ms-auto" style="color:#cbd5e1;font-size:0.75rem;"></i>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
