@extends('layouts.app')

@section('title', "Horario {$grado->numero}°{$grado->seccion}")
@section('page-title', "Horario — {$grado->numero}°{$grado->seccion}")

@section('topbar-actions')
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
        <a href="{{ route('horarios_grado.edit', [$grado->id, $jornada]) }}"
           style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;
                  padding:.6rem .75rem;border-radius:9px;font-size:.83rem;font-weight:600;
                  display:inline-flex;align-items:center;gap:.4rem;
                  text-decoration:none;border:none;transition:all .2s;">
            <i class="fas fa-edit"></i> Editar Horario
        </a>
        <a href="{{ route('horarios_grado.pdf', [$grado->id, $jornada]) }}"
           style="background:white;color:#ef4444;
                  padding:.6rem .75rem;border-radius:9px;font-size:.83rem;font-weight:600;
                  display:inline-flex;align-items:center;gap:.4rem;
                  text-decoration:none;border:1.5px solid #ef4444;transition:all .2s;">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
    </div>
@endsection

@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */

/* ── Jornada badge ── */
.jornada-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .7rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;          /* ← TAMAÑO badge jornada */
    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.15); color: white;
}

/* ── Título sección ── */
.sm-sec-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;          /* ← TAMAÑO título sección */
    text-transform: uppercase; letter-spacing: .08em;
    color: #00508f;
    margin-bottom: .95rem; padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.1);
}
.sm-sec-title i { color: #4ec7d2; font-size: .88rem; }

/* ── Tabla ── */
.ht-table { width: 100%; border-collapse: collapse; }

.ht-table thead th {
    font-size: .63rem;                            /* ← TAMAÑO encabezados tabla */
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #6b7a90;
    background: #f5f8fc;
    padding: .7rem .85rem;
    border: 1px solid #e8edf4;
    text-align: center;
    white-space: nowrap;
}
.ht-table thead th.th-hora {
    background: linear-gradient(135deg,rgba(0,80,143,.08),rgba(78,199,210,.08));
    color: #003b73;
    width: 130px;                                 /* ← ANCHO columna hora */
}

.ht-table tbody td {
    border: 1px solid #e8edf4;
    padding: .6rem .75rem;                       /* ← PADDING celdas */
    vertical-align: middle;
    text-align: center;
    min-width: 130px;                             /* ← ANCHO mínimo celdas */
}
.ht-table tbody tr:hover td { background: rgba(78,199,210,.03); }

/* ── Celda hora ── */
.td-hora {
    font-size: .72rem;                            /* ← TAMAÑO texto hora */
    font-weight: 700;
    color: #00508f;
    background: linear-gradient(135deg,rgba(0,80,143,.05),rgba(78,199,210,.05));
    text-align: left !important;
    white-space: nowrap;
}

/* ── Celda con materia ── */
.td-materia-nombre {
    font-size: .8rem;                             /* ← TAMAÑO nombre materia */
    font-weight: 700;
    color: #003b73;
    display: block;
    margin-bottom: .1rem;
}
.td-profesor {
    font-size: .7rem;                             /* ← TAMAÑO nombre profesor */
    color: #6b7a90;
    display: block;
}
.td-salon {
    font-size: .68rem;                            /* ← TAMAÑO aula */
    color: #94a3b8;
    display: block;
    margin-top: .1rem;
}

/* ── Celda vacía ── */
.td-vacia {
    font-size: .75rem;
    color: #cbd5e1;
}

/* ── Empty state ── */
.empty-state {
    text-align: center; padding: 3.5rem 1rem;
    color: #94a3b8;
}
.empty-state i {
    font-size: 3rem; display: block;
    margin-bottom: .75rem; color: #bfd9ea;
}
.empty-state p     { font-size: .88rem; font-weight: 600; margin: 0 0 .25rem; }
.empty-state small { font-size: .75rem; }
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem 1.7rem; position:relative; overflow:hidden;">

        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px;height:80px;
                        border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-calendar-alt" style="color:white;font-size:2rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white;
                           margin:0 0 .5rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    {{ $grado->numero }}° {{ $grado->seccion }}
                    — {{ ucfirst($grado->nivel) }}
                </h2>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                    <span class="jornada-badge">
                        @if($jornada === 'matutina')
                            <i class="fas fa-sun"></i>
                        @else
                            <i class="fas fa-moon"></i>
                        @endif
                        Jornada {{ ucfirst($jornada) }}
                    </span>
                    <span class="jornada-badge">
                        <i class="fas fa-calendar"></i> {{ $grado->anio_lectivo }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <div style="padding:1.4rem 1.7rem;">

            <div class="sm-sec-title">
                <i class="fas fa-table"></i> Distribución de Clases
            </div>

            @if(!$horarioGrado || empty($horarioGrado->horario))

                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No hay horario registrado para esta jornada.</p>
                    <small>Use el botón "Editar Horario" para crear el horario.</small>
                </div>

            @else
                @php
                    $estructura = $horarioGrado->horario;
                    $dias       = array_keys($estructura);
                    $horas      = array_keys(reset($estructura));
                @endphp

                <div style="overflow-x:auto;">
                    <table class="ht-table">
                        <thead>
                            <tr>
                                <th class="th-hora">
                                    <i class="fas fa-clock" style="margin-right:.3rem;color:#4ec7d2;"></i>
                                    Hora
                                </th>
                                @foreach($dias as $dia)
                                    <th>{{ $dia }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($horas as $hora)
                                @if(str_starts_with($hora, 'RECREO'))
                                <tr>
                                    <td class="td-hora" style="color:#1d4ed8;background:linear-gradient(135deg,rgba(219,234,254,.6),rgba(147,197,253,.3));">
                                        <i class="fas fa-coffee" style="color:#3b82f6;margin-right:.3rem;"></i>
                                        {{ str_replace('RECREO ', '', $hora) }}
                                    </td>
                                    <td colspan="{{ count($dias) }}"
                                        style="background:linear-gradient(135deg,rgba(219,234,254,.5),rgba(147,197,253,.2));
                                               text-align:center;font-size:.78rem;font-weight:800;
                                               color:#1d4ed8;letter-spacing:.25em;
                                               border:1px solid #bfdbfe;">
                                        R &nbsp; E &nbsp; C &nbsp; R &nbsp; E &nbsp; O
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td class="td-hora">
                                        <i class="fas fa-circle"
                                           style="font-size:.4rem;color:#4ec7d2;
                                                  vertical-align:middle;margin-right:.3rem;"></i>
                                        {{ $hora }}
                                    </td>

                                    @foreach($dias as $dia)
                                        @php $c = $estructura[$dia][$hora] ?? null; @endphp
                                        <td>
                                            @if($c && ($c['materia_id'] || $c['profesor_id']))
                                                <span class="td-materia-nombre">
                                                    {{ optional($materias->find($c['materia_id']))->nombre ?? '—' }}
                                                </span>
                                                <span class="td-profesor">
                                                    <i class="fas fa-user-tie"
                                                       style="font-size:.6rem;color:#4ec7d2;margin-right:.2rem;"></i>
                                                    {{ optional($profesores->find($c['profesor_id']))->nombre ?? '—' }}
                                                </span>
                                                <span class="td-salon">
                                                    <i class="fas fa-door-open"
                                                       style="font-size:.6rem;margin-right:.2rem;"></i>
                                                    Aula: {{ $c['salon'] ?? '—' }}
                                                </span>
                                            @else
                                                <span class="td-vacia">—</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </div>

        {{-- Footer info ── --}}
        <div style="display:flex;align-items:center;justify-content:space-between;
                    flex-wrap:wrap;gap:.5rem;
                    padding:.85rem 1.7rem;
                    background:#f5f8fc;border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;
                    font-size:.72rem;color:#94a3b8;">
            <span>
                <i class="fas fa-info-circle me-1" style="color:#4ec7d2;"></i>
                Horario de {{ $grado->numero }}° {{ $grado->seccion }}
                · Jornada {{ ucfirst($jornada) }}
            </span>
            <span>
                <i class="fas fa-calendar me-1" style="color:#4ec7d2;"></i>
                Año lectivo {{ $grado->anio_lectivo }}
            </span>
        </div>

    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}
@endsection
