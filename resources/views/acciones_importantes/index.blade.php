@extends('layouts.app')

@section('title', 'Acciones Importantes')
@section('page-title', 'Acciones Importantes del Sistema')
@section('content-class', 'p-0')

@push('styles')
<style>
.ai-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.ai-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.ai-hero-left { display: flex; align-items: center; gap: 1rem; }
.ai-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ai-hero-icon i { font-size: 1.3rem; color: white; }
.ai-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.ai-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.ai-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.ai-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.ai-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

/* Body */
.ai-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }

/* Cards grid */
.ai-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.2rem;
}

/* Card */
.accion-card {
    background: white; border-radius: 12px; overflow: hidden;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 12px rgba(0,59,115,.07);
    display: flex; flex-direction: column;
}
.accion-card-header {
    background: #003b73; padding: .75rem 1.1rem;
    display: flex; align-items: center; gap: .5rem;
}
.accion-card-header i { color: #4ec7d2; font-size: .95rem; }
.accion-card-header span { font-size: .82rem; font-weight: 700; color: white; }

.accion-item {
    display: flex; flex-direction: column; gap: .2rem;
    padding: .65rem 1.1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .8rem;
}
.accion-item:last-child { border-bottom: none; }
.accion-item .nombre { font-weight: 700; color: #003b73; }
.accion-item .meta   { color: #94a3b8; font-size: .72rem; display: flex; gap: .5rem; flex-wrap: wrap; }

.estado-badge {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .15rem .55rem; border-radius: 999px; font-size: .67rem; font-weight: 700;
}
.estado-pendiente  { background: rgba(245,158,11,.12); color: #b45309; border: 1px solid rgba(245,158,11,.3); }
.estado-aprobada   { background: rgba(16,185,129,.12); color: #065f46; border: 1px solid rgba(16,185,129,.3); }
.estado-rechazada  { background: rgba(239,68,68,.12);  color: #991b1b; border: 1px solid rgba(239,68,68,.3); }
.estado-default    { background: rgba(78,199,210,.12); color: #0e7490; border: 1px solid rgba(78,199,210,.3); }

.empty-state {
    text-align: center; padding: 2rem 1rem; color: #94a3b8;
    font-size: .8rem; font-weight: 600;
}
.empty-state i { font-size: 1.8rem; display: block; margin-bottom: .5rem; color: #dde4ee; }

/* Dark mode */
body.dark-mode .ai-wrap { background: #0f172a; }
body.dark-mode .accion-card { background: #1e293b; border-color: #334155; }
body.dark-mode .accion-item { border-color: #334155; }
body.dark-mode .accion-item .nombre { color: #e2e8f0; }
</style>
@endpush

@section('content')
<div class="ai-wrap">

    {{-- Hero --}}
    <div class="ai-hero">
        <div class="ai-hero-left">
            <div class="ai-hero-icon"><i class="fas fa-bolt"></i></div>
            <div>
                <h2 class="ai-hero-title">Acciones Importantes del Sistema</h2>
                <p class="ai-hero-sub">Resumen rápido de matrículas, solicitudes y calificaciones recientes</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="ai-stat">
                <div class="ai-stat-num">{{ $matriculasRecientes->count() }}</div>
                <div class="ai-stat-lbl">Matrículas</div>
            </div>
            <div class="ai-stat">
                <div class="ai-stat-num">{{ $solicitudesPendientes->count() }}</div>
                <div class="ai-stat-lbl">Solicitudes</div>
            </div>
            <div class="ai-stat">
                <div class="ai-stat-num">{{ $calificacionesRecientes->count() }}</div>
                <div class="ai-stat-lbl">Calificaciones</div>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="ai-body">

        <div class="ai-grid">

            {{-- MATRÍCULAS --}}
            <div class="accion-card">
                <div class="accion-card-header">
                    <i class="fas fa-user-graduate"></i>
                    <span>Matrículas recientes</span>
                </div>
                <div style="flex:1;">
                    @if($matriculasRecientes->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-user-graduate"></i>
                            No hay matrículas recientes
                        </div>
                    @else
                        @foreach($matriculasRecientes as $m)
                            <div class="accion-item">
                                <span class="nombre">{{ $m->estudiante->nombre ?? '—' }}</span>
                                <div class="meta">
                                    <span><i class="fas fa-calendar-alt" style="color:#4ec7d2;"></i> {{ $m->fecha_matricula }}</span>
                                    @php
                                        $cls = match($m->estado ?? '') {
                                            'pendiente' => 'estado-pendiente',
                                            'aprobada'  => 'estado-aprobada',
                                            'rechazada' => 'estado-rechazada',
                                            default     => 'estado-default',
                                        };
                                    @endphp
                                    <span class="estado-badge {{ $cls }}">{{ ucfirst($m->estado) }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- SOLICITUDES --}}
            <div class="accion-card">
                <div class="accion-card-header">
                    <i class="fas fa-file-alt"></i>
                    <span>Solicitudes pendientes</span>
                </div>
                <div style="flex:1;">
                    @if($solicitudesPendientes->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-file-alt"></i>
                            No hay solicitudes pendientes
                        </div>
                    @else
                        @foreach($solicitudesPendientes as $s)
                            <div class="accion-item">
                                <span class="nombre">{{ $s->estudiante->nombre ?? '—' }}</span>
                                <div class="meta">
                                    <span><i class="fas fa-calendar-alt" style="color:#4ec7d2;"></i> {{ $s->created_at->format('d/m/Y') }}</span>
                                    @php
                                        $cls = match($s->estado ?? '') {
                                            'pendiente' => 'estado-pendiente',
                                            'aprobada'  => 'estado-aprobada',
                                            'rechazada' => 'estado-rechazada',
                                            default     => 'estado-default',
                                        };
                                    @endphp
                                    <span class="estado-badge {{ $cls }}">{{ ucfirst($s->estado) }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- CALIFICACIONES --}}
            <div class="accion-card">
                <div class="accion-card-header">
                    <i class="fas fa-star"></i>
                    <span>Calificaciones recientes</span>
                </div>
                <div style="flex:1;">
                    @if($calificacionesRecientes->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            No hay calificaciones recientes
                        </div>
                    @else
                        @foreach($calificacionesRecientes as $c)
                            <div class="accion-item">
                                <span class="nombre">{{ $c->estudiante->nombre ?? '—' }}</span>
                                <div class="meta">
                                    <span><i class="fas fa-book" style="color:#4ec7d2;"></i> {{ $c->materia->nombre ?? '—' }}</span>
                                    <span><i class="fas fa-hashtag" style="color:#4ec7d2;"></i> Nota: <strong style="color:#003b73;">{{ $c->nota }}</strong></span>
                                    <span><i class="fas fa-calendar-alt" style="color:#4ec7d2;"></i> {{ $c->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>

        <div style="text-align:center;padding:.75rem 0;font-size:.72rem;color:#94a3b8;">
            <i class="fas fa-info-circle" style="color:#4ec7d2;margin-right:.3rem;"></i>
            Vista actualizada con las últimas acciones registradas en el sistema — Año {{ date('Y') }}
        </div>

    </div>{{-- /ai-body --}}
</div>
@endsection
