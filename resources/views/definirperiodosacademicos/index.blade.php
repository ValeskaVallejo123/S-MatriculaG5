@extends('layouts.app')

@section('title', 'Períodos Académicos')
@section('page-title', 'Períodos Académicos')
@section('content-class', 'p-0')

@push('styles')
<style>
.pa-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.pa-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.pa-hero-left { display: flex; align-items: center; gap: 1rem; }
.pa-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pa-hero-icon i { font-size: 1.3rem; color: white; }
.pa-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.pa-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.pa-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 80px;
}
.pa-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.pa-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.pa-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.pa-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Scrollable body */
.pa-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Table card */
.pa-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
    margin-bottom: 1.25rem;
}
.pa-tbl thead th {
    background: #003b73;
    color: white;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: .75rem 1rem;
    border: none;
}
.pa-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.pa-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.pa-tbl tbody td { padding: .75rem 1rem; vertical-align: middle; font-size: .85rem; color: #334155; }
.pa-tbl tbody tr:last-child { border-bottom: none; }

/* Badges tipo */
.badge-clases     { background: #dbeafe; color: #1e40af; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.badge-examenes   { background: #ede9fe; color: #6d28d9; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.badge-vacaciones { background: #fef3c7; color: #92400e; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }

/* Badges estado */
.badge-encurso    { background: #ecfdf5; color: #059669; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.badge-proximo    { background: #f0f9ff; color: #0369a1; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.badge-finalizado { background: #f1f5f9; color: #64748b; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }

/* Action buttons */
.btn-edit-sm {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .75rem; border-radius: 7px;
    background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd;
    font-size: .78rem; font-weight: 600; text-decoration: none; transition: background .15s;
}
.btn-edit-sm:hover { background: #bae6fd; color: #0369a1; }
.btn-del-sm {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .75rem; border-radius: 7px;
    background: #fff5f5; color: #dc2626; border: 1px solid #fecaca;
    font-size: .78rem; font-weight: 600; cursor: pointer; transition: background .15s;
}
.btn-del-sm:hover { background: #fecaca; }

/* Info box */
.pa-info {
    display: flex; align-items: flex-start; gap: .6rem;
    background: rgba(78,199,210,.08); border-left: 3px solid #4ec7d2;
    border-radius: 8px; padding: .65rem 1rem;
    font-size: .82rem; color: #0f172a;
}
.pa-info i { color: #00508f; margin-top: .1rem; flex-shrink: 0; }

/* Dark mode */
body.dark-mode .pa-wrap  { background: #0f172a; }
body.dark-mode .pa-table-card { background: #1e293b; }
body.dark-mode .pa-tbl tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .pa-tbl tbody td { color: #cbd5e1; }
body.dark-mode .pa-tbl tbody tr { border-color: #334155; }
body.dark-mode .pa-info { background: rgba(78,199,210,.05); }
</style>
@endpush

@section('content')
<div class="pa-wrap">

    {{-- Hero --}}
    <div class="pa-hero">
        <div class="pa-hero-left">
            <div class="pa-hero-icon"><i class="fas fa-calendar-alt"></i></div>
            <div>
                <h2 class="pa-hero-title">Períodos Académicos</h2>
                <p class="pa-hero-sub">Define los trimestres, parciales o bimestres del año escolar</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="pa-stat">
                <div class="pa-stat-num">{{ $enCurso }}</div>
                <div class="pa-stat-lbl">En Curso</div>
            </div>
            <div class="pa-stat">
                <div class="pa-stat-num">{{ $proximos }}</div>
                <div class="pa-stat-lbl">Próximos</div>
            </div>
            <div class="pa-stat">
                <div class="pa-stat-num">{{ $finalizados }}</div>
                <div class="pa-stat-lbl">Finalizados</div>
            </div>
            <a href="{{ route('periodos-academicos.create') }}" class="pa-btn-new">
                <i class="fas fa-plus"></i> Nuevo Período
            </a>
        </div>
    </div>

    {{-- Body --}}
    <div class="pa-body">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm" role="alert"
                 style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 border-0 shadow-sm" role="alert"
                 style="border-radius:10px;border-left:4px solid #ef4444 !important;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Table card --}}
        <div class="pa-table-card">
            @if($periodos->isEmpty())
                <div style="text-align:center;padding:3.5rem 1rem;">
                    <i class="fas fa-calendar-times fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                    <div class="fw-semibold mb-2" style="color:#003b73;">No hay períodos académicos registrados</div>
                    <p class="text-muted" style="font-size:.85rem;">Crea el primero para comenzar a registrar calificaciones.</p>
                    <a href="{{ route('periodos-academicos.create') }}"
                       style="display:inline-flex;align-items:center;gap:.4rem;
                              background:linear-gradient(135deg,#4ec7d2,#00508f);
                              color:#fff;padding:.5rem 1.25rem;border-radius:8px;
                              font-weight:700;font-size:.85rem;text-decoration:none;">
                        <i class="fas fa-plus"></i> Crear período
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table pa-tbl mb-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                                <th style="text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($periodos as $periodo)
                            @php
                                if ($periodo->fecha_inicio->isFuture()) {
                                    $estado = 'proximo'; $estadoLabel = 'Próximo'; $estadoIcon = 'clock';
                                } elseif ($periodo->fecha_fin->isPast()) {
                                    $estado = 'finalizado'; $estadoLabel = 'Finalizado'; $estadoIcon = 'check-double';
                                } else {
                                    $estado = 'encurso'; $estadoLabel = 'En curso'; $estadoIcon = 'circle-dot';
                                }
                            @endphp
                            <tr>
                                <td style="font-weight:700;color:#003b73;">
                                    <i class="fas fa-calendar-check" style="color:#4ec7d2;margin-right:.4rem;font-size:.75rem;"></i>
                                    {{ $periodo->nombre_periodo }}
                                </td>
                                <td>
                                    <span class="badge-{{ $periodo->tipo }}">
                                        <i class="fas fa-{{ $periodo->tipo === 'clases' ? 'book-open' : ($periodo->tipo === 'examenes' ? 'pen-nib' : 'umbrella-beach') }}"></i>
                                        {{ ucfirst($periodo->tipo) }}
                                    </span>
                                </td>
                                <td>{{ $periodo->fecha_inicio->format('d/m/Y') }}</td>
                                <td>{{ $periodo->fecha_fin->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge-{{ $estado }}">
                                        <i class="fas fa-{{ $estadoIcon }}"></i> {{ $estadoLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;justify-content:center;gap:.5rem;">
                                        <a href="{{ route('periodos-academicos.edit', $periodo->id) }}" class="btn-edit-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form method="POST"
                                              action="{{ route('periodos-academicos.destroy', $periodo->id) }}"
                                              data-confirm="¿Eliminar este período? Las calificaciones vinculadas también se verán afectadas.">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-del-sm">
                                                <i class="fas fa-trash"></i> Eliminar
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

        {{-- Info box --}}
        <div class="pa-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>¿Para qué sirven los períodos académicos?</strong><br>
                Permiten organizar las calificaciones por trimestres, parciales o bimestres.
                Cada nota registrada por un profesor queda vinculada a un período específico,
                lo que permite a los estudiantes ver su progreso por período y calcular promedios.
            </div>
        </div>

    </div>{{-- /pa-body --}}
</div>
@endsection
