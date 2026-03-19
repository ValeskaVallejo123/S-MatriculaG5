@extends('layouts.app')

@section('title', 'Períodos Académicos')
@section('page-title', 'Períodos Académicos')

@section('topbar-actions')
    <a href="{{ route('periodos-academicos.create') }}"
       class="btn btn-sm"
       style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
              color:white;border:none;border-radius:8px;font-weight:600;">
        <i class="fas fa-plus me-1"></i> Nuevo Período
    </a>
@endsection

@push('styles')
<style>
.pa-wrap { font-family: 'Inter', sans-serif; }

.pa-header {
    border-radius: 12px;
    background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
    padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 1rem;
}
.pa-header-icon {
    width: 52px; height: 52px; border-radius: 12px;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pa-header-icon i { color: #fff; font-size: 1.4rem; }
.pa-header h5 { color: #fff; font-weight: 800; margin: 0 0 .2rem; }
.pa-header p  { color: rgba(255,255,255,.8); font-size: .83rem; margin: 0; }

/* Stats */
.pa-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 1.5rem; }
@media(max-width:600px){ .pa-stats { grid-template-columns: 1fr; } }
.pa-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1rem 1.25rem; display: flex; align-items: center; gap: .85rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.pa-stat-icon {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.pa-stat-icon i { color: #fff; font-size: 1rem; }
.pa-stat-lbl { font-size: .7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; }
.pa-stat-num { font-size: 1.6rem; font-weight: 800; color: #0f172a; line-height: 1; }

/* Card */
.pa-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.pa-card-head {
    background: #003b73; padding: .75rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.pa-card-head i   { color: #4ec7d2; }
.pa-card-head span { color: #fff; font-weight: 700; font-size: .9rem; }

/* Tabla */
.pa-tbl { width: 100%; border-collapse: collapse; }
.pa-tbl thead th {
    background: #f8fafc; padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0;
}
.pa-tbl tbody td {
    padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .85rem; color: #334155; vertical-align: middle;
}
.pa-tbl tbody tr:last-child td { border-bottom: none; }
.pa-tbl tbody tr:hover { background: #fafbfc; }

/* Badges tipo */
.badge-clases    { background: #dbeafe; color: #1e40af; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.badge-examenes  { background: #ede9fe; color: #6d28d9; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.badge-vacaciones{ background: #fef3c7; color: #92400e; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }

/* Badges estado */
.badge-encurso   { background: #ecfdf5; color: #059669; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.badge-proximo   { background: #f0f9ff; color: #0369a1; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.badge-finalizado{ background: #f1f5f9; color: #64748b; padding: .25rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }

/* Botones acción */
.btn-edit-sm {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .75rem; border-radius: 7px;
    background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd;
    font-size: .78rem; font-weight: 600; text-decoration: none;
    transition: background .15s;
}
.btn-edit-sm:hover { background: #bae6fd; color: #0369a1; }
.btn-del-sm {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .75rem; border-radius: 7px;
    background: #fff5f5; color: #dc2626; border: 1px solid #fecaca;
    font-size: .78rem; font-weight: 600; cursor: pointer;
    transition: background .15s;
}
.btn-del-sm:hover { background: #fecaca; }

/* Empty state */
.pa-empty { padding: 3.5rem 1rem; text-align: center; }
.pa-empty i { font-size: 2rem; color: #cbd5e1; display: block; margin-bottom: .6rem; }
.pa-empty p { color: #94a3b8; font-size: .85rem; margin: 0 0 1rem; }

/* Alerta */
.pa-alert {
    display: flex; align-items: center; gap: .6rem;
    padding: .75rem 1rem; border-radius: 10px;
    font-size: .85rem; font-weight: 600; margin-bottom: 1.25rem;
}
.pa-alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
.pa-alert-error   { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; }

/* Info box */
.pa-info {
    display: flex; align-items: flex-start; gap: .6rem;
    background: rgba(78,199,210,.08); border-left: 3px solid #4ec7d2;
    border-radius: 8px; padding: .65rem 1rem;
    font-size: .82rem; color: #0f172a; margin-top: 1.25rem;
}
.pa-info i { color: #00508f; margin-top: .1rem; flex-shrink: 0; }
</style>
@endpush

@section('content')
<div class="pa-wrap">

    {{-- Alertas --}}
    @if(session('success'))
        <div class="pa-alert pa-alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="pa-alert pa-alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="pa-header">
        <div class="pa-header-icon"><i class="fas fa-calendar-alt"></i></div>
        <div>
            <h5>Períodos Académicos</h5>
            <p>Define los trimestres, parciales o bimestres del año escolar para registrar calificaciones</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="pa-stats">
        <div class="pa-stat">
            <div class="pa-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-play-circle"></i>
            </div>
            <div>
                <div class="pa-stat-lbl">En Curso</div>
                <div class="pa-stat-num">{{ $enCurso }}</div>
            </div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon" style="background:linear-gradient(135deg,#60a5fa,#2563eb);">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="pa-stat-lbl">Próximos</div>
                <div class="pa-stat-num">{{ $proximos }}</div>
            </div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon" style="background:linear-gradient(135deg,#94a3b8,#475569);">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <div class="pa-stat-lbl">Finalizados</div>
                <div class="pa-stat-num">{{ $finalizados }}</div>
            </div>
        </div>
    </div>

    {{-- Tabla de períodos --}}
    <div class="pa-card">
        <div class="pa-card-head">
            <i class="fas fa-list-alt"></i>
            <span>Todos los Períodos</span>
            @if($periodos->isNotEmpty())
                <span style="margin-left:auto;background:rgba(255,255,255,.15);
                      color:#fff;font-size:.72rem;padding:.2rem .6rem;
                      border-radius:999px;font-weight:600;">
                    {{ $periodos->count() }} períodos
                </span>
            @endif
        </div>

        @if($periodos->isEmpty())
            <div class="pa-empty">
                <i class="fas fa-calendar-times"></i>
                <p>No hay períodos académicos registrados.<br>Crea el primero para comenzar a registrar calificaciones.</p>
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
                <table class="pa-tbl">
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
                            $hoy = now();
                            if ($periodo->fecha_inicio->isFuture()) {
                                $estado = 'proximo';
                                $estadoLabel = 'Próximo';
                                $estadoIcon = 'clock';
                            } elseif ($periodo->fecha_fin->isPast()) {
                                $estado = 'finalizado';
                                $estadoLabel = 'Finalizado';
                                $estadoIcon = 'check-double';
                            } else {
                                $estado = 'encurso';
                                $estadoLabel = 'En curso';
                                $estadoIcon = 'circle-dot';
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
                                    <i class="fas fa-{{ $estadoIcon }}"></i>
                                    {{ $estadoLabel }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;justify-content:center;gap:.5rem;">
                                    <a href="{{ route('periodos-academicos.edit', $periodo->id) }}"
                                       class="btn-edit-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form method="POST"
                                          action="{{ route('periodos-academicos.destroy', $periodo->id) }}"
                                          onsubmit="return confirm('¿Eliminar el período {{ $periodo->nombre_periodo }}? Las calificaciones vinculadas a él también se verán afectadas.')">
                                        @csrf
                                        @method('DELETE')
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

    <div class="pa-info">
        <i class="fas fa-info-circle"></i>
        <div>
            <strong>¿Para qué sirven los períodos académicos?</strong><br>
            Permiten organizar las calificaciones por trimestres, parciales o bimestres.
            Cada nota registrada por un profesor queda vinculada a un período específico,
            lo que permite a los estudiantes ver su progreso por período y calcular promedios.
        </div>
    </div>

</div>
@endsection
