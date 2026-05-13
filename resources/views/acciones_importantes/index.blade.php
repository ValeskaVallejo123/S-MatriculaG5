@extends('layouts.app')

@section('title', 'Acciones Importantes')
@section('page-title', 'Acciones Importantes del Sistema')

@push('styles')
<style>
.sec-title {
    display:flex;align-items:center;gap:.5rem;
    font-size:.74rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
    color:#00508f;margin-bottom:.95rem;padding-bottom:.5rem;
    border-bottom:2px solid rgba(78,199,210,.15);
}
.sec-title i { color:#4ec7d2; }

.accion-card {
    border-radius:12px;border:1px solid #e8edf4;background:white;
    box-shadow:0 2px 8px rgba(0,59,115,.07);overflow:hidden;
    display:flex;flex-direction:column;
}
.accion-card-header {
    background:linear-gradient(135deg,#002d5a,#00508f);
    padding:.9rem 1.2rem;display:flex;align-items:center;gap:.6rem;
}
.accion-card-header i { color:#4ec7d2;font-size:1rem; }
.accion-card-header span { font-size:.82rem;font-weight:700;color:white; }

.accion-item {
    display:flex;flex-direction:column;gap:.2rem;
    padding:.65rem .2rem;border-bottom:1px solid #f1f5f9;
    font-size:.8rem;
}
.accion-item:last-child { border-bottom:none; }
.accion-item .nombre { font-weight:700;color:#003b73; }
.accion-item .meta   { color:#94a3b8;font-size:.72rem;display:flex;gap:.5rem;flex-wrap:wrap; }

.estado-badge {
    display:inline-flex;align-items:center;gap:.25rem;
    padding:.15rem .55rem;border-radius:999px;font-size:.67rem;font-weight:700;
}
.estado-pendiente  { background:rgba(245,158,11,.12);color:#b45309;border:1px solid rgba(245,158,11,.3); }
.estado-aprobada   { background:rgba(16,185,129,.12);color:#065f46;border:1px solid rgba(16,185,129,.3); }
.estado-rechazada  { background:rgba(239,68,68,.12);color:#991b1b;border:1px solid rgba(239,68,68,.3); }
.estado-default    { background:rgba(78,199,210,.12);color:#0e7490;border:1px solid rgba(78,199,210,.3); }

.empty-state {
    text-align:center;padding:2rem 1rem;color:#94a3b8;
    font-size:.8rem;font-weight:600;
}
.empty-state i { font-size:1.8rem;display:block;margin-bottom:.5rem;color:#dde4ee; }
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem 1.7rem;position:relative;overflow:hidden;">
        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:72px;height:72px;border-radius:16px;
                        border:3px solid rgba(78,199,210,.7);background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-bolt" style="color:white;font-size:1.9rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.35rem;font-weight:800;color:white;margin:0 0 .5rem;
                           text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Acciones Importantes del Sistema
                </h2>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                    <span style="display:inline-flex;align-items:center;gap:.3rem;
                                 padding:.28rem .85rem;border-radius:999px;font-size:.72rem;font-weight:700;
                                 background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.35);">
                        <i class="fas fa-user-graduate"></i> {{ $matriculasRecientes->count() }} matrícula(s) recientes
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;
                                 padding:.28rem .85rem;border-radius:999px;font-size:.72rem;font-weight:700;
                                 background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.35);">
                        <i class="fas fa-file-alt"></i> {{ $solicitudesPendientes->count() }} solicitud(es) pendientes
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;
                                 padding:.28rem .85rem;border-radius:999px;font-size:.72rem;font-weight:700;
                                 background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.35);">
                        <i class="fas fa-calendar"></i> {{ date('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <div style="padding:1.5rem 1.7rem;">

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.2rem;">

                {{-- MATRÍCULAS --}}
                <div class="accion-card">
                    <div class="accion-card-header">
                        <i class="fas fa-user-graduate"></i>
                        <span>Matrículas recientes</span>
                    </div>
                    <div style="padding:.8rem 1.1rem;flex:1;">
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
                                                'pendiente'  => 'estado-pendiente',
                                                'aprobada'   => 'estado-aprobada',
                                                'rechazada'  => 'estado-rechazada',
                                                default      => 'estado-default',
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
                    <div style="padding:.8rem 1.1rem;flex:1;">
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
                                                'pendiente'  => 'estado-pendiente',
                                                'aprobada'   => 'estado-aprobada',
                                                'rechazada'  => 'estado-rechazada',
                                                default      => 'estado-default',
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
                    <div style="padding:.8rem 1.1rem;flex:1;">
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

        </div>

        {{-- Footer --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;
                    padding:.85rem 1.7rem;background:#f5f8fc;border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;font-size:.72rem;color:#94a3b8;">
            <span>
                <i class="fas fa-info-circle me-1" style="color:#4ec7d2;"></i>
                Vista actualizada con las últimas acciones registradas en el sistema
            </span>
            <span>
                <i class="fas fa-calendar me-1" style="color:#4ec7d2;"></i>
                Año {{ date('Y') }}
            </span>
        </div>

    </div>
</div>
@endsection
