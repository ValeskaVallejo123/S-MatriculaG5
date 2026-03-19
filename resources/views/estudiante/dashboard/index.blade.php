@extends('layouts.app')

@section('title', 'Dashboard Estudiante')
@section('page-title', 'Mi Panel Estudiantil')

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

.est-wrap {
    font-family: 'Inter', sans-serif;
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* ══ BANNER ══ */
.est-banner {
    background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 55%, var(--cyan) 100%);
    border-radius: var(--radius);
    padding: 1.5rem 2rem;
    display: flex; align-items: center; gap: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,59,115,.2);
    position: relative; overflow: hidden;
}
.est-banner::before {
    content:''; position:absolute; top:-50%; right:-3%;
    width:220px; height:220px; background:rgba(255,255,255,.07); border-radius:50%;
}
.est-banner::after {
    content:''; position:absolute; bottom:-55%; right:15%;
    width:150px; height:150px; background:rgba(255,255,255,.04); border-radius:50%;
}
.est-banner-avatar {
    width:68px; height:68px; border-radius:16px; flex-shrink:0;
    background:rgba(255,255,255,.15); border:2.5px solid rgba(255,255,255,.35);
    display:flex; align-items:center; justify-content:center;
    font-size:1.75rem; color:#fff; position:relative; z-index:1;
    box-shadow: 0 4px 12px rgba(0,0,0,.2);
}
.est-banner-info { position:relative; z-index:1; flex:1; }
.est-banner-info h3 { color:#fff; font-weight:800; margin:0 0 .25rem; font-size:1.3rem; }
.est-banner-info p  { color:rgba(255,255,255,.72); font-size:.82rem; margin:0 0 .65rem; }
.est-banner-tags { display:flex; flex-wrap:wrap; gap:.4rem; }
.est-tag {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.22rem .75rem; border-radius:999px;
    font-size:.72rem; font-weight:600;
}
.tag-cyan  { background:rgba(78,199,210,.3); color:#fff; border:1px solid rgba(78,199,210,.5); }
.tag-white { background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.28); }
.tag-green { background:rgba(16,185,129,.28); color:#fff; border:1px solid rgba(16,185,129,.5); }
.tag-warn  { background:rgba(234,179,8,.22); color:#fde047; border:1px solid rgba(234,179,8,.4); }

/* ══ STAT GRID ══ */
.est-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}
@media(max-width:900px){ .est-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:500px){ .est-stats { grid-template-columns: 1fr 1fr; gap:.65rem; } }

.est-stat {
    background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
    box-shadow: var(--shadow); position: relative; overflow: hidden;
    transition: box-shadow .15s, transform .15s;
}
.est-stat:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.est-stat-stripe {
    position:absolute; left:0; top:0; bottom:0;
    width:4px; border-radius: var(--radius) 0 0 var(--radius);
}
.est-stat-icon {
    width:44px; height:44px; border-radius:11px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:1.05rem;
}
.est-stat-lbl { font-size:.68rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.15rem; }
.est-stat-val { font-size:1.6rem; font-weight:800; color:var(--blue-dark); line-height:1; }

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
.sec-head-link {
    color:rgba(255,255,255,.75); font-size:.75rem; font-weight:600;
    text-decoration:none; display:flex; align-items:center; gap:.3rem;
    transition:color .15s;
}
.sec-head-link:hover { color:#fff; }

/* ══ QUICK LINKS ══ */
.quick-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .6rem;
    padding: 1rem;
}
@media(max-width:480px){ .quick-grid { grid-template-columns: 1fr; } }

.quick-link {
    display:flex; align-items:center; gap:.75rem;
    padding:.8rem 1rem; border-radius:9px;
    text-decoration:none; transition:all .15s;
    border:1.5px solid var(--border);
    background:var(--surface);
}
.quick-link:hover { transform:translateY(-2px); box-shadow:var(--shadow-md); }
.quick-icon {
    width:36px; height:36px; border-radius:9px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:.9rem;
}
.quick-label { font-size:.83rem; font-weight:600; color:var(--blue-dark); flex:1; }
.quick-arrow { color:var(--subtle); font-size:.7rem; }

/* ══ NOTIFICACIONES ══ */
.notif-list { padding:.75rem 1rem; display:flex; flex-direction:column; gap:.5rem; }

.notif-item {
    display:flex; align-items:flex-start; gap:.85rem;
    padding:.85rem 1rem; border-radius:9px;
    border:1px solid var(--border); background:#fff;
    transition:background .15s, border-color .15s;
}
.notif-item:hover { background:var(--cyan-light); border-color:var(--cyan-border); }
.notif-item.leida { background:var(--surface); border-color:var(--border); opacity:.75; }

.notif-dot {
    width:36px; height:36px; border-radius:9px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:.85rem;
}
.notif-body { flex:1; min-width:0; }
.notif-title { font-weight:700; color:var(--blue-dark); font-size:.84rem; margin-bottom:.2rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.notif-msg   { color:var(--muted); font-size:.76rem; margin-bottom:.2rem; line-height:1.4;
               display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.notif-time  { color:var(--subtle); font-size:.7rem; }

.badge-nueva {
    display:inline-flex; align-items:center;
    padding:.12rem .5rem; border-radius:999px; margin-left:.4rem;
    background:var(--cyan-light); color:var(--blue-mid);
    font-size:.62rem; font-weight:700; border:1px solid var(--cyan-border);
}
.btn-marcar {
    width:28px; height:28px; border-radius:7px; flex-shrink:0;
    border:1.5px solid var(--cyan-border); background:var(--cyan-light);
    color:var(--blue-mid); cursor:pointer; font-size:.72rem;
    display:flex; align-items:center; justify-content:center;
    transition:all .15s;
}
.btn-marcar:hover { background:var(--cyan); color:#fff; border-color:var(--cyan); }

.notif-empty {
    padding:3rem 1rem; text-align:center;
}
.notif-empty i { font-size:2rem; color:#cbd5e1; display:block; margin-bottom:.75rem; }
.notif-empty p { color:var(--subtle); font-size:.82rem; margin:0; }

/* ══ MAIN GRID ══ */
.main-grid {
    display: grid;
    grid-template-columns: 1fr 300px;  /* ← reducido de 380px */
    gap: 1.25rem;
    align-items: start;
}
@media(max-width:1100px){ .main-grid { grid-template-columns: 1fr; } }

.quick-grid {
    display: grid;
    grid-template-columns: 1fr;  /* ← una sola columna */
    gap: .6rem;
    padding: 1rem;
}
@media(max-width:1024px){ .main-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
@php
    $user           = auth()->user();
    $estudiante     = $user->estudiante;
    $noLeidas       = $user->total_notificaciones_no_leidas;
    $notificaciones = $user->notificacionesPermitidas()->take(6)->get();
@endphp

<div class="est-wrap">

    {{-- ══ BANNER ══ --}}
    <div class="est-banner">
        <div class="est-banner-avatar">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="est-banner-info">
            <h3>Hola, {{ $user->name }}</h3>
            <p>
                <i class="fas fa-calendar me-1"></i>
                {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </p>
            @if($estudiante)
                <div class="est-banner-tags">
                    <span class="est-tag tag-cyan">
                        <i class="fas fa-graduation-cap"></i>
                        {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                    </span>
                    <span class="est-tag tag-white">
                        <i class="fas fa-id-card"></i>
                        {{ $estudiante->dni }}
                    </span>
                    <span class="est-tag tag-green">
                        <i class="fas fa-circle" style="font-size:.4rem;"></i>
                        {{ ucfirst($estudiante->estado) }}
                    </span>
                    @if($noLeidas > 0)
                        <span class="est-tag tag-warn">
                            <i class="fas fa-bell"></i>
                            {{ $noLeidas }} sin leer
                        </span>
                    @endif
                </div>
            @else
                <span class="est-tag tag-warn">
                    <i class="fas fa-exclamation-triangle"></i>
                    Sin perfil de estudiante vinculado
                </span>
            @endif
        </div>
    </div>

    {{-- ══ STATS ══ --}}
    <div class="est-stats">
        <div class="est-stat">
            <div class="est-stat-stripe" style="background:var(--cyan);"></div>
            <div class="est-stat-icon" style="background:rgba(78,199,210,.12);">
                <i class="fas fa-book" style="color:var(--blue-mid);"></i>
            </div>
            <div>
                <div class="est-stat-lbl">Materias</div>
                <div class="est-stat-val">{{ $totalMaterias ?? '—' }}</div>
            </div>
        </div>

        <div class="est-stat">
            <div class="est-stat-stripe" style="background:var(--blue-mid);"></div>
            <div class="est-stat-icon" style="background:rgba(0,80,143,.1);">
                <i class="fas fa-clipboard-check" style="color:var(--blue-dark);"></i>
            </div>
            <div>
                <div class="est-stat-lbl">Calificaciones</div>
                <div class="est-stat-val">{{ $totalCalificaciones ?? '—' }}</div>
            </div>
        </div>

        <div class="est-stat">
            <div class="est-stat-stripe" style="background:#4f46e5;"></div>
            <div class="est-stat-icon" style="background:rgba(79,70,229,.1);">
                <i class="fas fa-calendar-alt" style="color:#4f46e5;"></i>
            </div>
            <div>
                <div class="est-stat-lbl">Horas / Semana</div>
                <div class="est-stat-val">{{ $totalHoras ?? '—' }}</div>
            </div>
        </div>

        <div class="est-stat">
            <div class="est-stat-stripe" style="background:#f59e0b;"></div>
            <div class="est-stat-icon" style="background:rgba(245,158,11,.1);">
                <i class="fas fa-bell" style="color:#d97706;"></i>
            </div>
            <div>
                <div class="est-stat-lbl">Sin Leer</div>
                <div class="est-stat-val">{{ $noLeidas }}</div>
            </div>
        </div>
    </div>

    {{-- ══ MAIN GRID: notificaciones + accesos ══ --}}
    <div class="main-grid">

        {{-- Notificaciones --}}
        <div class="sec-card">
            <div class="sec-head">
                <div class="sec-head-left">
                    <i class="fas fa-bell"></i>
                    <span>Notificaciones Recientes</span>
                </div>
                <a href="{{ route('notificaciones.index') }}" class="sec-head-link">
                    Ver todas <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            @if($notificaciones->isEmpty())
                <div class="notif-empty">
                    <i class="fas fa-bell-slash"></i>
                    <p>No tienes notificaciones nuevas.</p>
                </div>
            @else
                <div class="notif-list">
                    @foreach($notificaciones as $notif)
                        @php
                            $colors = [
                                'calificacion' => ['bg'=>'rgba(245,158,11,.12)','color'=>'#d97706','icon'=>'fa-star'],
                                'horario'      => ['bg'=>'rgba(78,199,210,.12)','color'=>'#00508f','icon'=>'fa-calendar-alt'],
                                'observacion'  => ['bg'=>'rgba(99,102,241,.12)','color'=>'#6366f1','icon'=>'fa-comment-alt'],
                                'matricula'    => ['bg'=>'rgba(0,80,143,.12)','color'=>'#00508f','icon'=>'fa-file-signature'],
                            ];
                            $c = $colors[$notif->tipo] ?? ['bg'=>'rgba(78,199,210,.12)','color'=>'#00508f','icon'=>'fa-info-circle'];
                        @endphp
                        <div class="notif-item {{ $notif->leida ? 'leida' : '' }}">
                            <div class="notif-dot" style="background:{{ $c['bg'] }};">
                                <i class="fas {{ $c['icon'] }}" style="color:{{ $c['color'] }};"></i>
                            </div>
                            <div class="notif-body">
                                <div class="notif-title">
                                    {{ $notif->titulo }}
                                    @if(!$notif->leida)
                                        <span class="badge-nueva">Nueva</span>
                                    @endif
                                </div>
                                <div class="notif-msg">{{ $notif->mensaje }}</div>
                                <div class="notif-time">
                                    <i class="fas fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
                                </div>
                            </div>
                            @if(!$notif->leida)
                                <form action="{{ route('notificaciones.marcarLeida', $notif->id) }}"
                                      method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-marcar" title="Marcar como leída">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
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

                <a href="{{ route('estudiante.miHorario') }}" class="quick-link"
                   style="border-color:rgba(0,80,143,.2);">
                    <div class="quick-icon" style="background:rgba(0,80,143,.1);">
                        <i class="fas fa-calendar-alt" style="color:var(--blue-mid);"></i>
                    </div>
                    <span class="quick-label">Mi Horario</span>
                    <i class="fas fa-chevron-right quick-arrow"></i>
                </a>

                <a href="{{ route('estudiante.calificaciones') }}" class="quick-link"
                   style="border-color:rgba(78,199,210,.3);">
                    <div class="quick-icon" style="background:rgba(78,199,210,.1);">
                        <i class="fas fa-clipboard-check" style="color:var(--cyan);"></i>
                    </div>
                    <span class="quick-label">Calificaciones</span>
                    <i class="fas fa-chevron-right quick-arrow"></i>
                </a>

                <a href="{{ route('estado-solicitud') }}" class="quick-link"
                   style="border-color:rgba(78,199,210,.3);">
                    <div class="quick-icon" style="background:rgba(78,199,210,.1);">
                        <i class="fas fa-file-signature" style="color:var(--cyan);"></i>
                    </div>
                    <span class="quick-label">Mi Matrícula</span>
                    <i class="fas fa-chevron-right quick-arrow"></i>
                </a>

                <a href="{{ route('notificaciones.index') }}" class="quick-link"
                   style="border-color:rgba(245,158,11,.3);">
                    <div class="quick-icon" style="background:rgba(245,158,11,.1);">
                        <i class="fas fa-bell" style="color:#d97706;"></i>
                    </div>
                    <span class="quick-label">
                        Notificaciones
                        @if($noLeidas > 0)
                            <span style="display:inline-flex;align-items:center;justify-content:center;
                                         width:18px;height:18px;border-radius:50%;
                                         background:#ef4444;color:#fff;font-size:.6rem;
                                         font-weight:700;margin-left:.3rem;">
                                {{ $noLeidas }}
                            </span>
                        @endif
                    </span>
                    <i class="fas fa-chevron-right quick-arrow"></i>
                </a>

                <a href="{{ route('notificaciones.preferencias') }}" class="quick-link"
                   style="border-color:rgba(0,59,115,.2);">
                    <div class="quick-icon" style="background:rgba(0,59,115,.08);">
                        <i class="fas fa-sliders-h" style="color:var(--blue-dark);"></i>
                    </div>
                    <span class="quick-label">Preferencias</span>
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

            </div>
        </div>

    </div>

</div>
@endsection