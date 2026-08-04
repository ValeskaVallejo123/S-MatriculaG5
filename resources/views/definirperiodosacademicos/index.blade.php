@extends('layouts.app')

@section('title', 'Períodos Académicos')
@section('page-title', 'Períodos Académicos')

@section('topbar-actions')
    <a href="{{ route('periodos-academicos.create') }}" class="pa-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="pa-btn-text">Nuevo Período</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botón topbar ── */
    .pa-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .pa-topbar-btn:hover { opacity: .88; color: white; }
    @media(max-width:600px) {
        .pa-btn-text { display: none; }
        .pa-topbar-btn { padding: .5rem .65rem; }
    }

    /* ── Variables ── */
    :root {
        --blue-dark: #003b73; --blue-mid: #00508f;
        --teal: #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border: #e8edf4; --surface: #f5f8fc;
        --text-main: #0d2137; --text-muted: #6b7a90;
        --green: #10b981; --radius-lg: 14px; --radius-sm: 7px;
        --shadow-sm: 0 1px 4px rgba(0,59,115,0.07);
        --shadow-md: 0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .pa-stats {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width:768px){ .pa-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .pa-stats { grid-template-columns: 1fr; } }

    .pa-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .pa-stat::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; border-radius: 4px 0 0 4px; }
    .ps-encurso::before   { background: var(--green); }
    .ps-proximos::before  { background: #3b82f6; }
    .ps-finalizado::before{ background: #94a3b8; }
    .pa-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .pa-stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.15rem; }
    .ps-encurso   .pa-stat-icon { background: rgba(16,185,129,.12);  color: var(--green); }
    .ps-proximos  .pa-stat-icon { background: rgba(59,130,246,.12);  color: #2563eb; }
    .ps-finalizado .pa-stat-icon{ background: rgba(148,163,184,.15); color: #475569; }

    .pa-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .pa-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .pa-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Card ── */
    .pa-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .pa-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .pa-card-head i    { color: var(--teal); font-size: 1rem; }
    .pa-card-head span { color: white; font-weight: 700; font-size: .95rem; }
    .pa-count-badge {
        margin-left: auto; background: rgba(255,255,255,.15);
        color: white; font-size: .72rem; padding: .2rem .6rem;
        border-radius: 999px; font-weight: 600;
    }

    /* ── Tabla ── */
    .pa-tbl { width: 100%; border-collapse: collapse; }
    .pa-tbl thead th {
        background: var(--surface); padding: .65rem 1rem;
        font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .pa-tbl thead th.tc { text-align: center; }
    .pa-tbl tbody td { padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: .84rem; color: var(--text-main); vertical-align: middle; }
    .pa-tbl tbody td.tc { text-align: center; }
    .pa-tbl tbody tr:last-child td { border-bottom: none; }
    .pa-tbl tbody tr { transition: background .15s; }
    .pa-tbl tbody tr:hover { background: #f7fbff; }

    .pa-nombre { font-weight: 600; color: var(--blue-dark); display: flex; align-items: center; gap: .4rem; }
    .pa-nombre i { color: var(--teal); font-size: .75rem; }

    /* Badges tipo */
    .bpill { display: inline-flex; align-items: center; gap: .25rem; padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 600; white-space: nowrap; }
    .b-blue   { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
    .b-purple { background: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe; }
    .b-amber  { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }
    .b-green  { background: rgba(16,185,129,.1); color: #065f46; border: 1px solid rgba(16,185,129,.3); }
    .b-sky    { background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
    .b-gray   { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .dot-green { background: var(--green); }
    .dot-blue  { background: #3b82f6; }
    .dot-gray  { background: #94a3b8; }

    /* Botones acción */
    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid; font-size: .78rem;
        background: white; cursor: pointer; transition: all .15s; text-decoration: none;
    }
    .act-edit { border-color: var(--teal); color: var(--teal); }
    .act-del  { border-color: #ef4444;     color: #ef4444; }
    .act-edit:hover { background: var(--teal); color: white; transform: translateY(-1px); }
    .act-del:hover  { background: #ef4444;     color: white; transform: translateY(-1px); }

    /* Empty */
    .pa-empty { padding: 4rem 1rem; text-align: center; }
    .pa-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .pa-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .pa-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0 0 1.25rem; }

    /* Info box */
    .pa-info {
        display: flex; align-items: flex-start; gap: .75rem;
        background: var(--teal-light); border-left: 4px solid var(--teal);
        border-radius: 10px; padding: .85rem 1.1rem;
        font-size: .82rem; color: var(--text-main); margin-top: 1.25rem;
    }
    .pa-info i { color: var(--blue-mid); margin-top: .1rem; flex-shrink: 0; }
</style>
@endpush

@section('content')
<div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;color:#065f46;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#065f46;font-size:1.2rem;cursor:pointer;">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;color:#991b1b;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#991b1b;font-size:1.2rem;cursor:pointer;">&times;</button>
    </div>
    @endif

    {{-- ── STATS ── --}}
    <div class="pa-stats">
        <div class="pa-stat ps-encurso">
            <div class="pa-stat-icon"><i class="fas fa-play-circle"></i></div>
            <div>
                <div class="pa-stat-lbl">En Curso</div>
                <div class="pa-stat-num">{{ $enCurso }}</div>
                <div class="pa-stat-sub">Activos ahora</div>
            </div>
        </div>
        <div class="pa-stat ps-proximos">
            <div class="pa-stat-icon"><i class="fas fa-clock"></i></div>
            <div>
                <div class="pa-stat-lbl">Próximos</div>
                <div class="pa-stat-num">{{ $proximos }}</div>
                <div class="pa-stat-sub">Por comenzar</div>
            </div>
        </div>
        <div class="pa-stat ps-finalizado">
            <div class="pa-stat-icon"><i class="fas fa-check-double"></i></div>
            <div>
                <div class="pa-stat-lbl">Finalizados</div>
                <div class="pa-stat-num">{{ $finalizados }}</div>
                <div class="pa-stat-sub">Completados</div>
            </div>
        </div>
    </div>

    {{-- ── TABLA ── --}}
    <div class="pa-card">
        <div class="pa-card-head">
            <i class="fas fa-list-alt"></i>
            <span>Todos los Períodos</span>
            @if($periodos->isNotEmpty())
                <span class="pa-count-badge">{{ $periodos->count() }} períodos</span>
            @endif
        </div>

        @if($periodos->isEmpty())
            <div class="pa-empty">
                <i class="fas fa-calendar-times"></i>
                <h6>No hay períodos académicos registrados</h6>
                <p>Crea el primero para comenzar a registrar calificaciones.</p>
                <a href="{{ route('periodos-academicos.create') }}" class="pa-topbar-btn">
                    <i class="fas fa-plus"></i> Crear período
                </a>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="pa-tbl">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="tc">Tipo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th class="tc">Estado</th>
                            <th class="tc">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($periodos as $periodo)
                        @php
                            if ($periodo->fecha_inicio->isFuture()) {
                                $estadoClass = 'b-sky';
                                $estadoLabel = 'Próximo';
                                $estadoDot   = 'dot-blue';
                            } elseif ($periodo->fecha_fin->isPast()) {
                                $estadoClass = 'b-gray';
                                $estadoLabel = 'Finalizado';
                                $estadoDot   = 'dot-gray';
                            } else {
                                $estadoClass = 'b-green';
                                $estadoLabel = 'En curso';
                                $estadoDot   = 'dot-green';
                            }

                            $tipoClass = match($periodo->tipo) {
                                'clases'     => 'b-blue',
                                'examenes'   => 'b-purple',
                                'vacaciones' => 'b-amber',
                                default      => 'b-gray',
                            };
                            $tipoIcon = match($periodo->tipo) {
                                'clases'     => 'book-open',
                                'examenes'   => 'pen-nib',
                                'vacaciones' => 'umbrella-beach',
                                default      => 'circle',
                            };
                        @endphp
                        <tr>
                            <td>
                                <div class="pa-nombre">
                                    <i class="fas fa-calendar-check"></i>
                                    {{ $periodo->nombre_periodo }}
                                </div>
                            </td>
                            <td class="tc">
                                <span class="bpill {{ $tipoClass }}">
                                    <i class="fas fa-{{ $tipoIcon }}" style="font-size:.65rem;"></i>
                                    {{ ucfirst($periodo->tipo) }}
                                </span>
                            </td>
                            <td style="font-size:.82rem;color:var(--text-muted);">
                                {{ $periodo->fecha_inicio->format('d/m/Y') }}
                            </td>
                            <td style="font-size:.82rem;color:var(--text-muted);">
                                {{ $periodo->fecha_fin->format('d/m/Y') }}
                            </td>
                            <td class="tc">
                                <span class="bpill {{ $estadoClass }}">
                                    <span class="dot {{ $estadoDot }}"></span>
                                    {{ $estadoLabel }}
                                </span>
                            </td>
                            <td class="tc">
                                <div style="display:inline-flex;gap:.35rem;">
                                    <a href="{{ route('periodos-academicos.edit', $periodo->id) }}"
                                       class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form method="POST"
                                          action="{{ route('periodos-academicos.destroy', $periodo->id) }}"
                                          data-confirm="¿Eliminar este período? Las calificaciones vinculadas también se verán afectadas."
                                          style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="act-btn act-del" title="Eliminar">
                                            <i class="fas fa-trash"></i>
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

    {{-- Info box ── --}}
    <div class="pa-info">
        <i class="fas fa-info-circle"></i>
        <div>
            <strong>¿Para qué sirven los períodos académicos?</strong><br>
            Permiten organizar las calificaciones por trimestres, parciales o bimestres.
            Cada nota registrada por un profesor queda vinculada a un período específico,
            lo que permite a los estudiantes ver su progreso y calcular promedios.
        </div>
    </div>

</div>
@endsection