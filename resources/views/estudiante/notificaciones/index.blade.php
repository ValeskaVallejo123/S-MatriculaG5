@extends('layouts.app')

@section('title', 'Mis Notificaciones')
@section('page-title', 'Mis Notificaciones')

@push('styles')
<style>
    :root {
        --blue-dark: #003b73; --blue-mid: #00508f;
        --teal: #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border: #e8edf4; --surface: #f5f8fc;
        --text-main: #0d2137; --text-muted: #6b7a90;
        --green: #10b981; --amber: #f59e0b;
        --radius-lg: 14px; --shadow-sm: 0 1px 4px rgba(0,59,115,0.07);
        --shadow-md: 0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .notif-stats {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width:768px){ .notif-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .notif-stats { grid-template-columns: 1fr; } }

    .notif-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .notif-stat::before { content:''; position:absolute; top:0; left:0; width:4px; height:100%; border-radius:4px 0 0 4px; }
    .ns-total::before  { background: var(--teal); }
    .ns-nuevas::before { background: var(--amber); }
    .ns-leidas::before { background: var(--green); }
    .notif-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .notif-stat-icon { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1.15rem; }
    .ns-total  .notif-stat-icon { background: var(--teal-light);      color: var(--teal); }
    .ns-nuevas .notif-stat-icon { background: rgba(245,158,11,.12);    color: var(--amber); }
    .ns-leidas .notif-stat-icon { background: rgba(16,185,129,.12);    color: var(--green); }

    .notif-stat-lbl { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-muted); margin-bottom:.2rem; }
    .notif-stat-num { font-size:1.75rem; font-weight:800; color:var(--blue-dark); line-height:1; }

    /* ── Card ── */
    .notif-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .notif-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; justify-content: space-between; gap: .6rem;
    }
    .notif-card-title { color: white; font-weight: 700; font-size: .95rem; display: flex; align-items: center; gap: .5rem; }
    .notif-card-title i { color: var(--teal); }

    /* ── Items ── */
    .notif-list { padding: .75rem 1.1rem; }

    .notif-item {
        display: flex; align-items: flex-start; gap: 1rem;
        padding: 1rem; border-radius: 10px; margin-bottom: .6rem;
        border-left: 4px solid var(--teal);
        background: var(--surface); transition: background .15s;
        position: relative;
    }
    .notif-item:last-child { margin-bottom: 0; }
    .notif-item.leida { border-left-color: #cbd5e1; background: #f8fafc; }
    .notif-item:hover { background: rgba(78,199,210,.05); }

    .notif-item-icon {
        width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .95rem;
    }
    .ni-calificacion { background: rgba(245,158,11,.12);  color: var(--amber); }
    .ni-horario      { background: var(--teal-light);     color: var(--teal); }
    .ni-observacion  { background: rgba(99,102,241,.12);  color: #6366f1; }
    .ni-matricula    { background: rgba(0,80,143,.1);     color: var(--blue-mid); }
    .ni-default      { background: var(--teal-light);     color: var(--teal); }

    .notif-item-body { flex: 1; min-width: 0; }
    .notif-item-titulo {
        font-weight: 700; color: var(--blue-dark); font-size: .9rem;
        display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; margin-bottom: .3rem;
    }
    .notif-nueva-badge {
        display: inline-flex; align-items: center;
        padding: .12rem .5rem; border-radius: 999px; font-size: .65rem; font-weight: 700;
        background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35);
    }
    .notif-item-msg  { font-size: .83rem; color: var(--text-muted); line-height: 1.55; margin-bottom: .4rem; }
    .notif-item-meta { font-size: .72rem; color: var(--text-muted); display: flex; align-items: center; gap: .4rem; }

    /* Botón marcar leída */
    .btn-marcar {
        flex-shrink: 0; width: 30px; height: 30px; border-radius: 7px;
        border: 1.5px solid var(--teal); color: var(--teal); background: white;
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .15s; font-size: .78rem;
    }
    .btn-marcar:hover { background: var(--teal); color: white; transform: translateY(-1px); }

    /* Empty */
    .notif-empty { text-align: center; padding: 4rem 1rem; }
    .notif-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .notif-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .notif-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    /* Filtro tabs */
    .notif-tabs { display: flex; gap: .4rem; margin-bottom: 1.25rem; }
    .notif-tab {
        padding: .42rem 1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
        border: 1.5px solid var(--border); background: white; color: #64748b;
        cursor: pointer; transition: all .15s;
    }
    .notif-tab.active { background: linear-gradient(135deg, var(--teal), var(--blue-mid)); color: white; border-color: transparent; }
    .notif-tab:not(.active):hover { border-color: var(--teal); color: var(--blue-mid); }
</style>
@endpush

@section('content')
@php
    $total  = $notificaciones->count();
    $nuevas = $notificaciones->where('leida', false)->count();
    $leidas = $notificaciones->where('leida', true)->count();
@endphp
<div>

    {{-- ── STATS ── --}}
    <div class="notif-stats">
        <div class="notif-stat ns-total">
            <div class="notif-stat-icon"><i class="fas fa-bell"></i></div>
            <div>
                <div class="notif-stat-lbl">Total</div>
                <div class="notif-stat-num">{{ $total }}</div>
            </div>
        </div>
        <div class="notif-stat ns-nuevas">
            <div class="notif-stat-icon"><i class="fas fa-bell-on"></i></div>
            <div>
                <div class="notif-stat-lbl">Sin leer</div>
                <div class="notif-stat-num">{{ $nuevas }}</div>
            </div>
        </div>
        <div class="notif-stat ns-leidas">
            <div class="notif-stat-icon"><i class="fas fa-check-double"></i></div>
            <div>
                <div class="notif-stat-lbl">Leídas</div>
                <div class="notif-stat-num">{{ $leidas }}</div>
            </div>
        </div>
    </div>

    {{-- ── TABS FILTRO ── --}}
    <div class="notif-tabs">
        <button class="notif-tab active" onclick="filtrar('todas', this)">
            <i class="fas fa-list me-1"></i> Todas
        </button>
        <button class="notif-tab" onclick="filtrar('nuevas', this)">
            <i class="fas fa-circle me-1" style="font-size:.5rem;"></i> Sin leer
            @if($nuevas > 0)
                <span style="background:#ef4444;color:white;font-size:.65rem;font-weight:700;padding:.1rem .4rem;border-radius:999px;margin-left:.2rem;">{{ $nuevas }}</span>
            @endif
        </button>
        <button class="notif-tab" onclick="filtrar('leidas', this)">
            <i class="fas fa-check me-1"></i> Leídas
        </button>
    </div>

    {{-- ── LISTA ── --}}
    <div class="notif-card">
        <div class="notif-card-head">
            <div class="notif-card-title">
                <i class="fas fa-bell"></i> Mis Notificaciones
            </div>
            @if($nuevas > 0)
                <span style="background:rgba(245,158,11,.25);color:#fde68a;font-size:.72rem;font-weight:700;padding:.25rem .7rem;border-radius:999px;">
                    {{ $nuevas }} sin leer
                </span>
            @endif
        </div>

        <div class="notif-list" id="notifList">
            @forelse($notificaciones as $notif)
            @php
                $iconClass = match($notif->tipo ?? '') {
                    'calificacion' => 'ni-calificacion',
                    'horario'      => 'ni-horario',
                    'observacion'  => 'ni-observacion',
                    'matricula'    => 'ni-matricula',
                    default        => 'ni-default',
                };
                $iconName = match($notif->tipo ?? '') {
                    'calificacion' => 'fa-star',
                    'horario'      => 'fa-calendar-alt',
                    'observacion'  => 'fa-comment-alt',
                    'matricula'    => 'fa-file-signature',
                    default        => 'fa-info-circle',
                };
            @endphp
            <div class="notif-item {{ $notif->leida ? 'leida' : '' }}"
                 data-estado="{{ $notif->leida ? 'leida' : 'nueva' }}">

                <div class="notif-item-icon {{ $iconClass }}">
                    <i class="fas {{ $iconName }}"></i>
                </div>

                <div class="notif-item-body">
                    <div class="notif-item-titulo">
                        {{ $notif->titulo }}
                        @if(!$notif->leida)
                            <span class="notif-nueva-badge">Nueva</span>
                        @endif
                    </div>
                    <div class="notif-item-msg">{{ $notif->mensaje }}</div>
                    <div class="notif-item-meta">
                        <i class="fas fa-clock" style="font-size:.65rem;"></i>
                        {{ $notif->created_at->diffForHumans() }}
                        &nbsp;·&nbsp;
                        <span style="text-transform:capitalize;">{{ $notif->tipo ?? 'general' }}</span>
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
            @empty
            <div class="notif-empty">
                <i class="fas fa-bell-slash"></i>
                <h6>Sin notificaciones</h6>
                <p>No tienes notificaciones registradas aún.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function filtrar(tipo, btn) {
    document.querySelectorAll('.notif-tab').forEach(function(t) { t.classList.remove('active'); });
    btn.classList.add('active');

    document.querySelectorAll('.notif-item').forEach(function(item) {
        if (tipo === 'todas') {
            item.style.display = '';
        } else if (tipo === 'nuevas') {
            item.style.display = item.dataset.estado === 'nueva' ? '' : 'none';
        } else {
            item.style.display = item.dataset.estado === 'leida' ? '' : 'none';
        }
    });
}
</script>
@endpush