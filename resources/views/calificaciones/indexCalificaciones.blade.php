@extends('layouts.app')

@section('title', 'Mis Calificaciones')
@section('page-title', 'Mis Calificaciones')
@section('content-class', 'p-0')

@push('styles')
<style>
.ical-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.ical-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.ical-hero-left { display: flex; align-items: center; gap: 1rem; }
.ical-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ical-hero-icon i { font-size: 1.3rem; color: white; }
.ical-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.ical-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.ical-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.ical-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.ical-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

/* Toolbar */
.ical-toolbar {
    background: white; border-bottom: 1px solid #e2e8f0;
    padding: .75rem 1.5rem; flex-shrink: 0;
}
.ical-filter-row {
    display: flex; align-items: flex-end; gap: .6rem; flex-wrap: wrap;
}
.ical-field { display: flex; flex-direction: column; gap: .25rem; }
.ical-label {
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .04em; color: #64748b;
}
.ical-select {
    padding: .4rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #334155; background: white; transition: border-color .2s;
    min-width: 180px;
}
.ical-select:focus { outline: none; border-color: #4ec7d2; }
.ical-btn-filter {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .4rem .9rem; border-radius: 8px;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none; font-size: .82rem; font-weight: 600; cursor: pointer;
}

/* Body */
.ical-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }

/* Table card */
.ical-table-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08); overflow: hidden;
}
.ical-tbl thead th {
    background: #003b73; color: white; font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; padding: .75rem 1rem; border: none;
}
.ical-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.ical-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.ical-tbl tbody td { padding: .72rem 1rem; vertical-align: middle; font-size: .84rem; color: #334155; }
.ical-tbl tbody tr:last-child { border-bottom: none; }

.ical-footer {
    padding: .7rem 1rem; display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    border-top: 1px solid #f1f5f9; background: #f9fbfd;
}

/* Dark mode */
body.dark-mode .ical-wrap { background: #0f172a; }
body.dark-mode .ical-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .ical-select { background: #0f172a; border-color: #334155; color: #cbd5e1; }
body.dark-mode .ical-table-card { background: #1e293b; }
body.dark-mode .ical-tbl tbody td { color: #cbd5e1; }
body.dark-mode .ical-tbl tbody tr { border-color: #334155; }
body.dark-mode .ical-footer { background: #1e293b; border-color: #334155; }
</style>
@endpush

@section('content')
<div class="ical-wrap">

    {{-- Hero --}}
    <div class="ical-hero">
        <div class="ical-hero-left">
            <div class="ical-hero-icon"><i class="fas fa-chart-line"></i></div>
            <div>
                <h2 class="ical-hero-title">Mis Calificaciones</h2>
                <p class="ical-hero-sub">Historial de notas por materia y período académico</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="ical-stat">
                <div class="ical-stat-num">{{ count($calificaciones) }}</div>
                <div class="ical-stat-lbl">Registros</div>
            </div>
            @if($promedio)
                <div class="ical-stat">
                    <div class="ical-stat-num">{{ number_format($promedio, 1) }}</div>
                    <div class="ical-stat-lbl">Promedio</div>
                </div>
            @endif
        </div>
    </div>

    {{-- Toolbar / Filtros --}}
    <div class="ical-toolbar">
        <form method="GET" action="{{ route('calificaciones.index') }}" class="ical-filter-row" id="filterForm">
            <div class="ical-field">
                <label class="ical-label">Período Académico</label>
                <div style="position:relative;">
                    <i class="fas fa-calendar-alt" style="position:absolute;left:9px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.75rem;"></i>
                    <select name="periodo_id" id="periodo_id" class="ical-select" style="padding-left:2rem;">
                        <option value="">Todos</option>
                        @foreach($periodos as $p)
                            <option value="{{ $p->id }}" {{ request('periodo_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nombre_periodo }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="ical-field">
                <label class="ical-label">Materia</label>
                <div style="position:relative;">
                    <i class="fas fa-book-open" style="position:absolute;left:9px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.75rem;"></i>
                    <select name="materia_id" id="materia_id" class="ical-select" style="padding-left:2rem;">
                        <option value="">Todas</option>
                        @foreach($materias as $m)
                            <option value="{{ $m->id }}" {{ request('materia_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="ical-btn-filter">
                <i class="fas fa-filter"></i> Filtrar
            </button>
        </form>
    </div>

    {{-- Body --}}
    <div class="ical-body">

        <div class="ical-table-card">
            @forelse($calificaciones as $c)
                @if($loop->first)
                    <div class="table-responsive">
                        <table class="table ical-tbl mb-0">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th>Período</th>
                                    <th style="text-align:center;">Nota</th>
                                    <th style="text-align:center;">Rendimiento</th>
                                    <th style="text-align:center;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                @endif
                @php
                    $rendimiento = $c->nota >= 85 ? 'Excelente' : ($c->nota >= 70 ? 'Bueno' : 'Bajo');
                    if ($c->nota < 70) {
                        $estadoBg = 'rgba(239,68,68,.1)'; $estadoColor = '#dc2626'; $estadoIcon = 'fa-times-circle';
                    } elseif ($c->nota >= 85) {
                        $estadoBg = 'rgba(34,197,94,.1)'; $estadoColor = '#16a34a'; $estadoIcon = 'fa-check-circle';
                    } else {
                        $estadoBg = 'rgba(234,179,8,.1)'; $estadoColor = '#ca8a04'; $estadoIcon = 'fa-minus-circle';
                    }
                @endphp
                <tr>
                    <td style="font-weight:700;color:#003b73;">{{ $c->materia->nombre }}</td>
                    <td>
                        <span style="background:rgba(78,199,210,.15);color:#00508f;border:1px solid #4ec7d2;
                                     border-radius:999px;padding:.2rem .6rem;font-size:.72rem;font-weight:600;">
                            {{ $c->periodo->nombre_periodo }}
                        </span>
                    </td>
                    <td style="text-align:center;font-weight:800;font-size:1rem;color:#003b73;">
                        {{ $c->nota }}
                    </td>
                    <td style="text-align:center;color:#64748b;font-size:.82rem;font-weight:500;">
                        {{ $rendimiento }}
                    </td>
                    <td style="text-align:center;">
                        <span style="background:{{ $estadoBg }};color:{{ $estadoColor }};
                                     border:1px solid {{ $estadoColor }};border-radius:999px;
                                     padding:.22rem .65rem;font-size:.72rem;font-weight:700;
                                     display:inline-flex;align-items:center;gap:.3rem;">
                            <i class="fas {{ $estadoIcon }}" style="font-size:.55rem;"></i>
                            {{ $c->nota >= 60 ? 'Aprobado' : 'Reprobado' }}
                        </span>
                    </td>
                </tr>
                @if($loop->last)
                            </tbody>
                        </table>
                    </div>
                @endif
            @empty
                <div style="text-align:center;padding:3.5rem 1rem;color:#94a3b8;">
                    <i class="fas fa-inbox fa-2x" style="display:block;margin-bottom:.75rem;color:#bfd9ea;"></i>
                    <p style="font-size:.9rem;font-weight:600;color:#003b73;margin:0 0 .25rem;">
                        No hay calificaciones registradas
                    </p>
                    <small>Intenta seleccionar otro período o materia</small>
                </div>
            @endforelse

            @if(count($calificaciones) > 0)
                @php
                    $promedioColor = $promedio >= 85 ? '#16a34a' : ($promedio >= 70 ? '#ca8a04' : '#dc2626');
                @endphp
                <div class="ical-footer">
                    <span style="font-size:.82rem;color:#64748b;display:flex;align-items:center;gap:.4rem;">
                        <i class="fas fa-chart-pie" style="color:#4ec7d2;"></i>
                        <strong style="color:#003b73;">Promedio General:</strong>
                    </span>
                    <span style="font-size:1.1rem;font-weight:800;color:{{ $promedioColor }};">
                        {{ $promedio ? number_format($promedio, 2) : 'N/A' }}
                    </span>
                </div>
            @endif
        </div>

    </div>{{-- /ical-body --}}
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#filterForm select').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
    const selects = document.querySelectorAll('#filterForm select');
    selects.forEach(s => s.addEventListener('change', () => document.getElementById('filterForm').submit()));
});
</script>
@endpush
@endsection
