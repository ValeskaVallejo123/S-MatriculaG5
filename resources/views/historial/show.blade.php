@extends('layouts.app')

@section('title', 'Historial Académico — ' . $estudiante->nombre1)
@section('page-title', 'Historial Académico')

@section('topbar-actions')
    <a href="{{ url()->previous() }}" class="hist-topbar-btn-ghost">
        <i class="fas fa-arrow-left"></i>
        <span class="hist-btn-text">Volver</span>
    </a>
    @if(auth()->user()->id_rol == 1)
    <a href="{{ route('superadmin.estudiantes.historial.edit', $estudiante->id) }}"
       class="hist-topbar-btn-edit">
        <i class="fas fa-pen"></i>
        <span class="hist-btn-text">Editar Notas</span>
    </a>
    @endif
    <button onclick="window.print();" class="hist-topbar-btn-print">
        <i class="fas fa-print"></i>
        <span class="hist-btn-text">Imprimir</span>
    </button>
@endsection

@push('styles')
<style>
    /* ── Botones topbar ── */
    .hist-topbar-btn-ghost {
        display: inline-flex; align-items: center; gap: .45rem;
        background: transparent; color: white;
        padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        border: 1.5px solid rgba(255,255,255,.35); white-space: nowrap;
        transition: background .2s;
    }
    .hist-topbar-btn-ghost:hover { background: rgba(255,255,255,.12); color: white; }

    .hist-topbar-btn-edit {
        display: inline-flex; align-items: center; gap: .45rem;
        background: #f59e0b; color: white;
        padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        white-space: nowrap; border: none; cursor: pointer;
        box-shadow: 0 2px 8px rgba(245,158,11,.3); transition: opacity .2s;
    }
    .hist-topbar-btn-edit:hover { opacity: .88; color: white; }

    .hist-topbar-btn-print {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        font-weight: 600; font-size: .83rem; white-space: nowrap;
        border: none; cursor: pointer;
        box-shadow: 0 2px 8px rgba(78,199,210,.3); transition: opacity .2s;
    }
    .hist-topbar-btn-print:hover { opacity: .88; }

    @media(max-width:600px) {
        .hist-btn-text { display: none; }
        .hist-topbar-btn-ghost,
        .hist-topbar-btn-edit,
        .hist-topbar-btn-print { padding: .5rem .65rem; }
    }

    /* ── Variables ── */
    :root {
        --blue-dark:   #003b73;
        --blue-mid:    #00508f;
        --teal:        #4ec7d2;
        --teal-light:  rgba(78,199,210,0.12);
        --border:      #e8edf4;
        --surface:     #f5f8fc;
        --text-main:   #0d2137;
        --text-muted:  #6b7a90;
        --green:       #10b981;
        --amber:       #f59e0b;
        --red:         #ef4444;
        --purple:      #7c3aed;
        --radius-lg:   14px;
        --shadow-sm:   0 1px 4px rgba(0,59,115,0.07);
        --shadow-md:   0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .hist-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media(max-width:700px){ .hist-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .hist-stats { grid-template-columns: 1fr; } }

    .hist-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .hist-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .hist-stat-registros::before  { background: var(--teal); }
    .hist-stat-promedio::before   { background: var(--purple); }
    .hist-stat-estado::before     { background: var(--green); }
    .hist-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .hist-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .hist-stat-registros .hist-stat-icon { background: var(--teal-light);          color: var(--teal); }
    .hist-stat-promedio  .hist-stat-icon { background: rgba(124,58,237,.1);         color: var(--purple); }
    .hist-stat-estado    .hist-stat-icon { background: rgba(16,185,129,.12);        color: var(--green); }

    .hist-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .hist-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .hist-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Card perfil del estudiante ── */
    .hist-perfil-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm); margin-bottom: 1.25rem;
    }
    .hist-perfil-head {
        background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
        padding: 1.5rem 1.75rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; position: relative; overflow: hidden;
    }
    .hist-perfil-head::after {
        content: '\f19d';
        font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%);
        font-size: 6rem; color: rgba(255,255,255,.06); pointer-events: none;
    }
    .hist-avatar {
        width: 68px; height: 68px; border-radius: 14px; flex-shrink: 0;
        background: rgba(255,255,255,.15); border: 2.5px solid #4ec7d2;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; font-weight: 800; color: white;
    }
    .hist-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 11px; }

    .hist-perfil-nombre { font-size: 1.25rem; font-weight: 800; color: white; margin: 0 0 .4rem; }
    .hist-perfil-meta {
        display: flex; flex-wrap: wrap; gap: .9rem;
        font-size: .8rem; color: rgba(255,255,255,.85);
    }
    .hist-perfil-meta span { display: flex; align-items: center; gap: .3rem; }

    /* ── Card tabla historial ── */
    .hist-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .hist-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .hist-card-head i    { color: var(--teal); font-size: 1rem; }
    .hist-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    /* ── Ciclo lectivo ── */
    .hist-ciclo {
        border: 1px solid var(--border); border-radius: 10px;
        overflow: hidden; margin: 1.25rem; margin-bottom: 0;
    }
    .hist-ciclo:last-child { margin-bottom: 1.25rem; }

    .hist-ciclo-head {
        background: var(--surface); padding: .65rem 1.1rem;
        display: flex; align-items: center; gap: .5rem;
        border-bottom: 1px solid var(--border);
    }
    .hist-ciclo-head-txt { font-weight: 700; color: var(--blue-dark); font-size: .82rem; }
    .hist-ciclo-count {
        margin-left: auto;
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .18rem .55rem; border-radius: 999px;
        background: var(--teal-light); color: var(--blue-mid);
        border: 1px solid rgba(78,199,210,.35);
        font-size: .68rem; font-weight: 700;
    }

    /* ── Tabla notas ── */
    .hist-tbl-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .hist-tbl { width: 100%; border-collapse: collapse; min-width: 620px; }
    .hist-tbl thead th {
        background: var(--surface); padding: .6rem .85rem;
        font-size: .67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .hist-tbl thead th.tc { text-align: center; }
    .hist-tbl tbody td {
        padding: .65rem .85rem; border-bottom: 1px solid #f1f5f9;
        font-size: .82rem; color: var(--text-main); vertical-align: middle;
    }
    .hist-tbl tbody td.tc { text-align: center; }
    .hist-tbl tbody tr:last-child td { border-bottom: none; }
    .hist-tbl tbody tr { transition: background .15s; }
    .hist-tbl tbody tr:hover { background: #f7fbff; }

    .nota-materia  { font-weight: 600; color: var(--blue-dark); font-size: .84rem; }
    .nota-periodo  { font-size: .7rem; color: var(--text-muted); margin-top: .1rem; }

    .nota-parcial {
        font-size: .82rem; font-weight: 600; text-align: center;
    }
    .nota-parcial.vacio { color: #cbd5e1; }

    .nota-final-val {
        font-size: .92rem; font-weight: 800; text-align: center;
    }
    .nota-aprobado  { color: #059669; }
    .nota-reprobado { color: var(--red); }

    /* Badges estado nota */
    .bpill {
        display: inline-flex; align-items: center; gap: .22rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .68rem; font-weight: 700; white-space: nowrap;
    }
    .b-green  { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.3); }
    .b-red    { background: rgba(239,68,68,.1);  color: #dc2626; border: 1px solid rgba(239,68,68,.25); }
    .b-yellow { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }

    /* ── Footer ── */
    .hist-footer {
        padding: .85rem 1.4rem; border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .5rem;
        font-size: .75rem; color: var(--text-muted);
    }
    .hist-footer strong { color: var(--blue-dark); }

    /* ── Empty ── */
    .hist-empty { padding: 4rem 1rem; text-align: center; }
    .hist-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .hist-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .hist-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    /* ── Impresión ── */
    @media print {
        .no-print, .sidebar, .topbar { display: none !important; }
        .main-content { margin-left: 0 !important; }
        .content-wrapper { padding: 0 !important; }
        body { background: white !important; }
        .hist-card, .hist-perfil-card { box-shadow: none !important; }
        @page { margin: 1cm; }
    }
</style>
@endpush

@section('content')
<div style="display:flex;flex-direction:column;gap:1.25rem;">

    {{-- ── PERFIL DEL ESTUDIANTE ── --}}
    <div class="hist-perfil-card">
        <div class="hist-perfil-head">
            <div style="display:flex;align-items:center;gap:1.1rem;flex-wrap:wrap;position:relative;z-index:1;">
                <div class="hist-avatar">
                    @if($estudiante->foto)
                        <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto">
                    @else
                        {{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1 ?? '', 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="hist-perfil-nombre">
                        {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                        {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                    </div>
                    <div class="hist-perfil-meta">
                        <span><i class="fas fa-id-card"></i> DNI: <strong>{{ $estudiante->dni }}</strong></span>
                        <span><i class="fas fa-layer-group"></i> Grado: <strong>{{ $estudiante->grado ?? 'N/A' }}</strong></span>
                        <span><i class="fas fa-sitemap"></i> Sección: <strong>{{ $estudiante->seccion ?? 'N/A' }}</strong></span>
                        @if($estudiante->email)
                        <span><i class="fas fa-envelope"></i> {{ $estudiante->email }}</span>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Badge estado académico --}}
            <div style="position:relative;z-index:1;">
                @php $estadoBadge = $promedio >= 60 ? 'b-green' : 'b-red'; @endphp
                <span class="bpill {{ $estadoBadge }}"
                      style="font-size:.75rem;padding:.35rem 1rem;
                             background:{{ $promedio >= 60 ? 'rgba(16,185,129,.2)' : 'rgba(239,68,68,.2)' }};
                             color:white;border-color:{{ $promedio >= 60 ? 'rgba(16,185,129,.5)' : 'rgba(239,68,68,.5)' }};">
                    <i class="fas {{ $promedio >= 60 ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"></i>
                    {{ $promedio >= 60 ? 'SATISFACTORIO' : 'EN RIESGO' }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── STATS ── --}}
    <div class="hist-stats">
        <div class="hist-stat hist-stat-registros">
            <div class="hist-stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <div class="hist-stat-lbl">Registros</div>
                <div class="hist-stat-num">{{ $estudiante->calificaciones->count() }}</div>
                <div class="hist-stat-sub">Calificaciones</div>
            </div>
        </div>
        <div class="hist-stat hist-stat-promedio">
            <div class="hist-stat-icon"><i class="fas fa-chart-line"></i></div>
            <div>
                <div class="hist-stat-lbl">Promedio General</div>
                <div class="hist-stat-num">
                    {{ number_format($promedio, 1) }}<span style="font-size:1rem;color:var(--text-muted);">%</span>
                </div>
                <div class="hist-stat-sub">Todas las materias</div>
            </div>
        </div>
        <div class="hist-stat hist-stat-estado">
            <div class="hist-stat-icon">
                <i class="fas {{ $promedio >= 60 ? 'fa-check-circle' : 'fa-exclamation-circle' }}"
                   style="color:{{ $promedio >= 60 ? 'var(--green)' : 'var(--red)' }};"></i>
            </div>
            <div>
                <div class="hist-stat-lbl">Estado Académico</div>
                <div style="margin-top:.25rem;">
                    <span class="bpill {{ $promedio >= 60 ? 'b-green' : 'b-red' }}"
                          style="font-size:.72rem;padding:.25rem .8rem;">
                        {{ $promedio >= 60 ? '✓ Aprobado' : '⚠ En riesgo' }}
                    </span>
                </div>
                <div class="hist-stat-sub" style="margin-top:.3rem;">Ciclo actual</div>
            </div>
        </div>
    </div>

    {{-- ── DETALLE POR CICLO ── --}}
    <div class="hist-card">
        <div class="hist-card-head">
            <i class="fas fa-list-check"></i>
            <span>Detalle por Ciclo Lectivo</span>
        </div>

        @forelse($historialAgrupado as $anio => $notas)
            <div class="hist-ciclo">

                {{-- Cabecera ciclo --}}
                <div class="hist-ciclo-head">
                    <i class="fas fa-calendar-alt" style="color:var(--teal);font-size:.85rem;"></i>
                    <span class="hist-ciclo-head-txt">Ciclo Lectivo: {{ $anio }}</span>
                    @php
                        $aprobadas  = $notas->where('nota_final', '>=', 60)->count();
                        $reprobadas = $notas->where('nota_final', '<', 60)->count();
                        $promedioAnio = $notas->avg('nota_final');
                    @endphp
                    <span class="hist-ciclo-count">
                        <i class="fas fa-book" style="font-size:.6rem;"></i>
                        {{ $notas->count() }} {{ $notas->count() == 1 ? 'materia' : 'materias' }}
                    </span>
                    @if($aprobadas > 0)
                    <span class="bpill b-green" style="margin-left:.35rem;font-size:.65rem;">
                        {{ $aprobadas }} aprobadas
                    </span>
                    @endif
                    @if($reprobadas > 0)
                    <span class="bpill b-red" style="margin-left:.35rem;font-size:.65rem;">
                        {{ $reprobadas }} reprobadas
                    </span>
                    @endif
                    <span style="margin-left:.35rem;font-size:.72rem;color:var(--text-muted);font-weight:600;">
                        Prom. {{ number_format($promedioAnio, 1) }}%
                    </span>
                </div>

                {{-- Tabla de notas --}}
                <div class="hist-tbl-wrapper">
                    <table class="hist-tbl">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th class="tc" style="width:90px;">Tarea</th>
                                <th class="tc" style="width:90px;">Parcial</th>
                                <th class="tc" style="width:90px;">Final</th>
                                <th class="tc" style="width:105px;">Promedio</th>
                                <th class="tc" style="width:105px;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notas as $nota)
                            <tr>
                                <td>
                                    <div class="nota-materia">{{ $nota->materia->nombre }}</div>
                                    <div class="nota-periodo">{{ $nota->periodo->nombre_periodo }}</div>
                                </td>
                                <td class="tc">
                                    <span class="nota-parcial {{ is_null($nota->nota_tarea) ? 'vacio' : '' }}">
                                        {{ !is_null($nota->nota_tarea) ? number_format($nota->nota_tarea, 0) : '—' }}
                                    </span>
                                </td>
                                <td class="tc">
                                    <span class="nota-parcial {{ is_null($nota->nota_parcial) ? 'vacio' : '' }}">
                                        {{ !is_null($nota->nota_parcial) ? number_format($nota->nota_parcial, 0) : '—' }}
                                    </span>
                                </td>
                                <td class="tc">
                                    <span class="nota-parcial {{ is_null($nota->nota_final) ? 'vacio' : '' }}">
                                        {{ !is_null($nota->nota_final) ? number_format($nota->nota_final, 0) : '—' }}
                                    </span>
                                </td>
                                <td class="tc">
                                    @php $prom = $nota->promedio; @endphp
                                    <span class="nota-final-val {{ is_null($prom) ? '' : ($prom >= 60 ? 'nota-aprobado' : 'nota-reprobado') }}"
                                          style="{{ is_null($prom) ? 'color:#94a3b8;font-size:.8rem;font-weight:600;' : '' }}">
                                        {{ is_null($prom) ? 'Pendiente' : number_format($prom, 1).'%' }}
                                    </span>
                                </td>
                                <td class="tc">
                                    @php $est = $nota->estado ?? 'pendiente'; @endphp
                                    <span class="bpill {{ $est === 'aprobado' ? 'b-green' : ($est === 'reprobado' ? 'b-red' : 'b-yellow') }}">
                                        <i class="fas {{ $est === 'aprobado' ? 'fa-check' : ($est === 'reprobado' ? 'fa-times' : 'fa-clock') }}"
                                           style="font-size:.55rem;"></i>
                                        {{ ucfirst($est) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        @empty
            <div class="hist-empty">
                <i class="fas fa-folder-open"></i>
                <h6>Sin historial disponible</h6>
                <p>No hay calificaciones registradas para este estudiante.</p>
            </div>
        @endforelse

        <div class="hist-footer">
            <span>Generado el: <strong>{{ date('d/m/Y') }}</strong> a las {{ date('h:i A') }}</span>
            <strong>Escuela Gabriela Mistral</strong>
        </div>
    </div>

</div>
@endsection