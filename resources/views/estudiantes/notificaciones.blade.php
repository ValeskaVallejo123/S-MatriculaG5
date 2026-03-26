@extends('layouts.app')

@section('title', 'Notificaciones')
@section('page-title', 'Mis Notificaciones')

@push('styles')
<style>
:root {
    --blue:     #00508f;
    --blue-mid: #003b73;
    --teal:     #4ec7d2;
    --border:   #e8edf4;
    --muted:    #6b7a90;
    --r:        14px;
}

.mn-wrap { width: 100%; box-sizing: border-box; }

/* ── HEADER ── */
.mn-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 2rem 1.7rem;
    position: relative; overflow: hidden;
}
.mn-header::before {
    content: ''; position: absolute; right: -50px; top: -50px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(78,199,210,.13); pointer-events: none;
}
.mn-header::after {
    content: ''; position: absolute; right: 100px; bottom: -45px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.mn-header-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.4rem; flex-wrap: wrap;
}
.mn-avatar {
    width: 80px; height: 80px; border-radius: 18px;
    border: 3px solid rgba(78,199,210,.7);
    background: rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 20px rgba(0,0,0,.25); flex-shrink: 0;
}
.mn-avatar i { color: white; font-size: 2rem; }
.mn-header h2 {
    font-size: 1.45rem; font-weight: 800; color: white;
    margin: 0 0 .5rem; text-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.mn-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .7rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.15); color: white;
    margin-right: .4rem;
}

/* ── BODY ── */
.mn-body {
    background: white;
    border: 1px solid var(--border);
    border-top: none;
    border-radius: 0 0 var(--r) var(--r);
    box-shadow: 0 4px 16px rgba(0,59,115,.10);
    padding: 1.4rem 1.7rem;
    margin-bottom: 1.3rem;
}

.mn-sec {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--blue); margin-bottom: .95rem;
    padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.15);
}
.mn-sec i { color: var(--teal); }

/* ── NOTIFICACION CARD ── */
.mn-list { display: flex; flex-direction: column; gap: .65rem; }

.mn-card {
    display: flex; align-items: flex-start; gap: 1rem;
    padding: 1rem 1.1rem;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: #f9fbfd;
    position: relative;
    transition: box-shadow .18s, border-color .18s;
}
.mn-card:hover {
    box-shadow: 0 3px 14px rgba(0,80,143,.10);
    border-color: rgba(78,199,210,.4);
}
.mn-card.unread {
    background: linear-gradient(135deg, rgba(78,199,210,.07), rgba(0,80,143,.04));
    border-color: rgba(78,199,210,.4);
}
.mn-card.unread::before {
    content: '';
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 3px; border-radius: var(--r) 0 0 var(--r);
    background: linear-gradient(180deg, var(--teal), var(--blue));
}

/* icon */
.mn-icon {
    flex-shrink: 0;
    width: 40px; height: 40px; border-radius: 10px;
    background: linear-gradient(135deg, rgba(78,199,210,.18), rgba(0,80,143,.10));
    border: 1px solid rgba(78,199,210,.3);
    display: flex; align-items: center; justify-content: center;
}
.mn-icon i { color: var(--blue); font-size: .95rem; }

/* content */
.mn-content { flex: 1; min-width: 0; }
.mn-top {
    display: flex; align-items: center;
    justify-content: space-between; gap: .5rem;
    margin-bottom: .25rem; flex-wrap: wrap;
}
.mn-titulo {
    font-size: .85rem; font-weight: 700;
    color: var(--blue-mid);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.mn-card.unread .mn-titulo { color: var(--blue); }

.mn-time {
    font-size: .68rem; color: var(--muted);
    white-space: nowrap; flex-shrink: 0;
    display: inline-flex; align-items: center; gap: .25rem;
}
.mn-time i { color: var(--teal); font-size: .6rem; }

.mn-msg {
    font-size: .8rem; color: var(--muted); line-height: 1.55;
}

/* unread dot */
.mn-dot {
    position: absolute; top: 12px; right: 12px;
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--teal);
    box-shadow: 0 0 0 3px rgba(78,199,210,.2);
}

/* ── EMPTY ── */
.mn-empty {
    text-align: center; padding: 3.5rem 1rem; color: var(--muted);
}
.mn-empty i {
    font-size: 2.8rem; display: block;
    margin-bottom: .75rem; color: rgba(78,199,210,.35);
}
.mn-empty p  { font-size: .9rem; font-weight: 600; margin: 0 0 .25rem; }
.mn-empty small { font-size: .78rem; }

/* ── MARK ALL ── */
.mn-mark-all {
    font-size: .73rem; color: var(--muted);
    background: none; border: none; cursor: pointer;
    font-weight: 600; transition: color .15s;
    display: inline-flex; align-items: center; gap: .3rem;
    margin-left: auto;
}
.mn-mark-all:hover { color: var(--blue); }

@media(max-width: 768px) {
    .mn-header { padding: 1.4rem 1.1rem; }
    .mn-body   { padding: 1rem 1.1rem; }
    .mn-avatar { width: 60px; height: 60px; }
    .mn-avatar i { font-size: 1.5rem; }
    .mn-header h2 { font-size: 1.1rem; }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
<div class="mn-wrap">

    {{-- ── HEADER ── --}}
    <div class="mn-header">
        <div class="mn-header-inner">
            <div class="mn-avatar">
                <i class="fas fa-bell"></i>
            </div>
            <div>
                <h2>Mis Notificaciones</h2>
                <span class="mn-badge">
                    <i class="fas fa-bell"></i>
                    {{ $notificaciones->count() }} notificaciones
                </span>
                @php $noLeidas = $notificaciones->where('leida', false)->count(); @endphp
                @if($noLeidas > 0)
                    <span class="mn-badge">
                        <i class="fas fa-circle" style="font-size:.5rem;"></i>
                        {{ $noLeidas }} sin leer
                    </span>
                @endif
                <span class="mn-badge">
                    <i class="fas fa-calendar"></i> {{ now()->format('Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div class="mn-body">

        @if($notificaciones->isEmpty())

            <div class="mn-empty">
                <i class="fas fa-bell-slash"></i>
                <p>No tienes notificaciones</p>
                <small>Cuando tengas nuevos avisos, aparecerán aquí.</small>
            </div>

        @else

            <div class="mn-sec">
                <i class="fas fa-list"></i> Listado de Notificaciones
                @if($noLeidas > 0)
                    <button class="mn-mark-all">
                        <i class="fas fa-check-double"></i> Marcar todas como leídas
                    </button>
                @endif
            </div>

            <div class="mn-list">
                @foreach($notificaciones as $notificacion)
                    <div class="mn-card {{ $notificacion->leida ? '' : 'unread' }}">

                        <div class="mn-icon">
                            <i class="fas fa-bell"></i>
                        </div>

                        <div class="mn-content">
                            <div class="mn-top">
                                <span class="mn-titulo">{{ $notificacion->titulo }}</span>
                                <span class="mn-time">
                                    <i class="fas fa-clock"></i>
                                    {{ $notificacion->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="mn-msg">{{ $notificacion->mensaje }}</p>
                        </div>

                        @if(!$notificacion->leida)
                            <div class="mn-dot"></div>
                        @endif

                    </div>
                @endforeach
            </div>

        @endif

    </div>

</div>
</div>
@endsection
