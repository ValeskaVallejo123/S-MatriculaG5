@extends('layouts.app')

@section('title', 'Gestión de Calificaciones')
@section('page-title', 'Calificaciones')
@section('content-class', 'p-0')

@push('styles')
<style>
.cal-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.cal-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.cal-hero-left { display: flex; align-items: center; gap: 1rem; }
.cal-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.cal-hero-icon i { font-size: 1.3rem; color: white; }
.cal-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.cal-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.cal-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 80px;
}
.cal-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.cal-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.cal-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.cal-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Scrollable body */
.cal-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Table card */
.cal-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.cal-tbl thead th {
    background: #003b73;
    color: white;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: .75rem 1rem;
    border: none;
}
.cal-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.cal-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.cal-tbl tbody td { padding: .7rem 1rem; vertical-align: middle; font-size: .84rem; color: #334155; }
.cal-tbl tbody tr:last-child { border-bottom: none; }

/* Nota badge */
.nota-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    border-radius: 999px; padding: .25rem .65rem;
    font-size: .75rem; font-weight: 700;
}

/* Action buttons */
.btn-view-sm {
    display: inline-flex; align-items: center;
    padding: .28rem .5rem; border-radius: 6px;
    background: rgba(0,80,143,.08); color: #00508f;
    border: 1px solid #00508f;
    font-size: .75rem; text-decoration: none; transition: background .15s;
}
.btn-view-sm:hover { background: rgba(0,80,143,.18); color: #00508f; }
.btn-edit-sm {
    display: inline-flex; align-items: center;
    padding: .28rem .5rem; border-radius: 6px;
    background: rgba(78,199,210,.1); color: #00508f;
    border: 1px solid #4ec7d2;
    font-size: .75rem; text-decoration: none; transition: background .15s;
}
.btn-edit-sm:hover { background: rgba(78,199,210,.25); color: #00508f; }
.btn-del-sm {
    display: inline-flex; align-items: center;
    padding: .28rem .5rem; border-radius: 6px;
    background: rgba(239,68,68,.08); color: #dc2626;
    border: 1px solid #fca5a5;
    font-size: .75rem; cursor: pointer; transition: background .15s;
}
.btn-del-sm:hover { background: rgba(239,68,68,.18); }

/* Empty state */
.cal-empty {
    text-align: center; padding: 3.5rem 1rem; color: #94a3b8;
}
.cal-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
.cal-empty p { font-size: .9rem; font-weight: 600; color: #003b73; margin: 0; }

/* Dark mode */
body.dark-mode .cal-wrap  { background: #0f172a; }
body.dark-mode .cal-table-card { background: #1e293b; }
body.dark-mode .cal-tbl tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .cal-tbl tbody td { color: #cbd5e1; }
body.dark-mode .cal-tbl tbody tr { border-color: #334155; }
</style>
@endpush

@section('content')
@php
    $total     = $calificaciones->count();
    $aprobados = $calificaciones->where('nota_final', '>=', 60)->count();
    $reprobados= $calificaciones->where('nota_final', '<', 60)->whereNotNull('nota_final')->count();
@endphp
<div class="cal-wrap">

    {{-- Hero --}}
    <div class="cal-hero">
        <div class="cal-hero-left">
            <div class="cal-hero-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <h2 class="cal-hero-title">Gestión de Calificaciones</h2>
                <p class="cal-hero-sub">Consulta, edita y administra las calificaciones del sistema</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="cal-stat">
                <div class="cal-stat-num">{{ $total }}</div>
                <div class="cal-stat-lbl">Registros</div>
            </div>
            <div class="cal-stat">
                <div class="cal-stat-num">{{ $aprobados }}</div>
                <div class="cal-stat-lbl">Aprobados</div>
            </div>
            <div class="cal-stat">
                <div class="cal-stat-num">{{ $reprobados }}</div>
                <div class="cal-stat-lbl">Reprobados</div>
            </div>
            <a href="{{ route('calificaciones.create') }}" class="cal-btn-new">
                <i class="fas fa-plus"></i> Nueva Calificación
            </a>
        </div>
    </div>

    {{-- Body --}}
    <div class="cal-body">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #ef4444 !important;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Table card --}}
        <div class="cal-table-card">
            @if($calificaciones->isEmpty())
                <div class="cal-empty">
                    <i class="fas fa-inbox"></i>
                    <p>No hay calificaciones registradas</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table cal-tbl mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Estudiante</th>
                                <th>Materia</th>
                                <th>Grado / Sección</th>
                                <th style="text-align:center;">1er P.</th>
                                <th style="text-align:center;">2do P.</th>
                                <th style="text-align:center;">3er P.</th>
                                <th style="text-align:center;">Recup.</th>
                                <th style="text-align:center;">Nota Final</th>
                                <th style="text-align:center;">Estado</th>
                                <th style="text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($calificaciones as $cal)
                                @php
                                    $nf    = $cal->nota_final;
                                    $bg    = $nf === null ? 'rgba(200,200,200,.15)' : ($nf >= 60 ? 'rgba(76,175,80,.1)'  : 'rgba(244,67,54,.1)');
                                    $color = $nf === null ? '#94a3b8'               : ($nf >= 60 ? '#388e3c'              : '#d32f2f');
                                    $txt   = $nf === null ? 'Pendiente'             : ($nf >= 60 ? 'Aprobado'             : 'Reprobado');
                                    $icon  = $nf === null ? 'fa-clock'              : ($nf >= 60 ? 'fa-check-circle'      : 'fa-times-circle');
                                @endphp
                                <tr>
                                    <td style="color:#94a3b8;font-size:.8rem;">{{ $cal->id }}</td>
                                    <td>
                                        <span style="font-weight:700;color:#003b73;font-size:.88rem;">
                                            {{ $cal->estudiante->nombre_completo ?? $cal->nombre_alumno ?? '—' }}
                                        </span>
                                    </td>
                                    <td style="color:#64748b;">{{ $cal->materia->nombre ?? '—' }}</td>
                                    <td>
                                        <span style="display:inline-flex;align-items:center;
                                                     background:rgba(78,199,210,.1);color:#00508f;
                                                     border:1px solid #4ec7d2;border-radius:999px;
                                                     padding:.22rem .6rem;font-size:.75rem;font-weight:600;">
                                            {{ $cal->grado_nombre ?? '—' }}{{ $cal->seccion ? ' · ' . $cal->seccion : '' }}
                                        </span>
                                    </td>
                                    <td style="text-align:center;">{{ $cal->primer_parcial  ?? '—' }}</td>
                                    <td style="text-align:center;">{{ $cal->segundo_parcial ?? '—' }}</td>
                                    <td style="text-align:center;">{{ $cal->tercer_parcial  ?? '—' }}</td>
                                    <td style="text-align:center;">{{ $cal->recuperacion    ?? '—' }}</td>
                                    <td style="text-align:center;">
                                        <span style="font-weight:700;color:{{ $color }};font-size:.95rem;">
                                            {{ $nf !== null ? number_format($nf, 1) : '—' }}
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="nota-badge"
                                              style="background:{{ $bg }};color:{{ $color }};border:1px solid {{ $color }};">
                                            <i class="fas {{ $icon }}" style="font-size:.65rem;"></i>
                                            {{ $txt }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex;align-items:center;justify-content:center;gap:.35rem;">
                                            <a href="{{ route('calificaciones.show', $cal) }}"
                                               class="btn-view-sm" title="Ver">
                                                <i class="fas fa-eye" style="font-size:.75rem;"></i>
                                            </a>
                                            <a href="{{ route('calificaciones.edit', $cal) }}"
                                               class="btn-edit-sm" title="Editar">
                                                <i class="fas fa-edit" style="font-size:.75rem;"></i>
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('calificaciones.destroy', $cal) }}"
                                                  data-confirm="¿Eliminar esta calificación?"
                                                  class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-del-sm" title="Eliminar">
                                                    <i class="fas fa-trash" style="font-size:.75rem;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>{{-- /cal-body --}}
</div>
@endsection
