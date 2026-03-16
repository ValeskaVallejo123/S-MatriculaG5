@extends('layouts.app')

@section('title', 'Carga Docente')
@section('page-title', 'Carga Docente')

@section('topbar-actions')
    <a href="{{ route('superadmin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Volver
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.cd-wrap { font-family: 'Inter', sans-serif; }

/* ── Stats ── */
.cd-stats {
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
@media(max-width:900px){ .cd-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:540px){ .cd-stats { grid-template-columns: 1fr; } }

.cd-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.cd-stat-icon {
    width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.cd-stat-icon i { font-size: 1.1rem; color: #fff; }
.cd-stat-lbl { font-size: .71rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .15rem; }
.cd-stat-num { font-size: 1.7rem; font-weight: 700; color: #0f172a; line-height: 1; }

/* ── Toolbar ── */
.cd-toolbar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: .85rem 1.25rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.cd-toolbar form { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; flex: 1; }
.cd-select {
    padding: .38rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #0f172a; background: #f8fafc; outline: none; cursor: pointer;
    font-family: 'Inter', sans-serif;
}
.cd-select:focus { border-color: #4ec7d2; }
.cd-btn-filter {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .38rem 1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f); color: #fff;
    border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: opacity .15s;
}
.cd-btn-filter:hover { opacity: .88; }
.cd-search {
    padding: .38rem .75rem .38rem 2rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; outline: none; font-family: 'Inter', sans-serif; background: #f8fafc;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' fill='none' stroke='%236b7280' stroke-width='2' viewBox='0 0 24 24'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='M21 21l-4.35-4.35'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: 8px center; min-width: 200px;
}
.cd-search:focus { border-color: #4ec7d2; background-color: #fff; }

/* ── Card tabla ── */
.cd-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.cd-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.cd-card-head i   { color: #4ec7d2; font-size: 1rem; }
.cd-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

/* ── Tabla ── */
.cd-tbl { width: 100%; border-collapse: collapse; }
.cd-tbl thead th {
    background: #f8fafc; padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.cd-tbl thead th.tc { text-align: center; }
.cd-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.cd-tbl tbody td.tc { text-align: center; }
.cd-tbl tbody tr:last-child td { border-bottom: none; }
.cd-tbl tbody tr:hover { background: #fafbfc; }

/* Posición / ranking */
.cd-rank {
    width: 28px; height: 28px; border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700;
}
.cd-rank-1 { background: #fef3c7; color: #b45309; }
.cd-rank-2 { background: #f1f5f9; color: #475569; }
.cd-rank-3 { background: #fef2f2; color: #b91c1c; }
.cd-rank-n { background: #f1f5f9; color: #94a3b8; }

/* Avatar */
.cd-av {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .9rem;
}
.cd-name  { font-weight: 600; color: #0f172a; font-size: .83rem; }
.cd-spec  { font-size: .73rem; color: #64748b; margin-top: .1rem; }

/* Barra de carga */
.cd-bar-wrap { display: flex; align-items: center; gap: .6rem; }
.cd-bar-bg {
    flex: 1; height: 7px; background: #f1f5f9; border-radius: 99px; overflow: hidden;
    min-width: 80px;
}
.cd-bar-fill { height: 100%; border-radius: 99px; transition: width .4s; }
.cd-bar-num { font-size: .78rem; font-weight: 700; color: #0f172a; white-space: nowrap; }

/* Materias chips */
.cd-chips { display: flex; flex-wrap: wrap; gap: .3rem; max-width: 260px; }
.cd-chip {
    display: inline-flex; align-items: center;
    padding: .18rem .55rem; border-radius: 999px;
    font-size: .68rem; font-weight: 600;
    background: #e8f8f9; color: #00508f; white-space: nowrap;
}

/* Contrato badge */
.bpill {
    display: inline-flex; align-items: center; gap: .2rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .69rem; font-weight: 600; white-space: nowrap;
}
.b-full  { background: #ecfdf5; color: #059669; }
.b-half  { background: #eff6ff; color: #3b82f6; }
.b-hours { background: #fffbeb; color: #92400e; }

/* Empty */
.cd-empty { padding: 4rem 1rem; text-align: center; }
.cd-empty i { font-size: 2.2rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }
.cd-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }

/* Footer */
.cd-footer {
    padding: .85rem 1.25rem; border-top: 1px solid #f1f5f9;
    font-size: .78rem; color: #94a3b8; background: #fafafa;
}
</style>
@endpush

@section('content')
<div class="cd-wrap">

    {{-- Stats --}}
    <div class="cd-stats">
        <div class="cd-stat">
            <div class="cd-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div class="cd-stat-lbl">Total Profesores</div>
                <div class="cd-stat-num">{{ $totalProfesores }}</div>
            </div>
        </div>
        <div class="cd-stat">
            <div class="cd-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="cd-stat-lbl">Con Carga</div>
                <div class="cd-stat-num">{{ $totalConCarga }}</div>
            </div>
        </div>
        <div class="cd-stat">
            <div class="cd-stat-icon" style="background:linear-gradient(135deg,#f87171,#dc2626);">
                <i class="fas fa-user-times"></i>
            </div>
            <div>
                <div class="cd-stat-lbl">Sin Carga</div>
                <div class="cd-stat-num">{{ $totalSinCarga }}</div>
            </div>
        </div>
        <div class="cd-stat">
            <div class="cd-stat-icon" style="background:linear-gradient(135deg,#a78bfa,#7c3aed);">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="cd-stat-lbl">Prom. Estudiantes</div>
                <div class="cd-stat-num">{{ $promEstudiantes }}</div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="cd-toolbar">
        <form method="GET" action="{{ route('carga-docente.index') }}">
            <label style="font-size:.82rem;font-weight:600;color:#64748b;">Año lectivo:</label>
            <select name="anio" class="cd-select">
                @foreach($aniosDisponibles as $a)
                    <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endforeach
                @if($aniosDisponibles->isEmpty())
                    <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                @endif
            </select>
            <button type="submit" class="cd-btn-filter">
                <i class="fas fa-filter"></i> Filtrar
            </button>
        </form>
        <input type="text" id="cdSearch" class="cd-search" placeholder="Buscar profesor...">
    </div>

    {{-- Tabla --}}
    <div class="cd-card">
        <div class="cd-card-head">
            <i class="fas fa-chart-bar"></i>
            <span>Distribución de Carga Docente — {{ $anio }}</span>
        </div>

        @php
            $maxEst = $profesores->max('total_estudiantes') ?: 1;
        @endphp

        <div style="overflow-x:auto;">
            <table class="cd-tbl" id="cdTable">
                <thead>
                    <tr>
                        <th class="tc">#</th>
                        <th>Profesor</th>
                        <th class="tc">Contrato</th>
                        <th>Materias</th>
                        <th class="tc">Grados</th>
                        <th class="tc">Horas/sem</th>
                        <th>Estudiantes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profesores as $i => $p)
                    @php
                        $pct = $maxEst > 0 ? ($p->total_estudiantes / $maxEst) * 100 : 0;
                        $barColor = $pct >= 80 ? '#ef4444' : ($pct >= 50 ? '#f59e0b' : '#4ec7d2');
                        $rankClass = $i === 0 ? 'cd-rank-1' : ($i === 1 ? 'cd-rank-2' : ($i === 2 ? 'cd-rank-3' : 'cd-rank-n'));
                        $contrato = match($p->tipo_contrato ?? '') {
                            'tiempo_completo' => ['Tiempo Completo', 'b-full'],
                            'medio_tiempo'    => ['Medio Tiempo',    'b-half'],
                            'por_horas'       => ['Por Horas',       'b-hours'],
                            default           => ['—',               'b-half'],
                        };
                        $materiasList = $p->nombres_materias ? explode(', ', $p->nombres_materias) : [];
                    @endphp
                    <tr data-name="{{ strtolower($p->nombre . ' ' . $p->apellido) }}">
                        <td class="tc">
                            <span class="cd-rank {{ $rankClass }}">{{ $i + 1 }}</span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:.65rem;">
                                <div class="cd-av">{{ strtoupper(substr($p->nombre,0,1)) }}</div>
                                <div>
                                    <div class="cd-name">{{ $p->nombre }} {{ $p->apellido }}</div>
                                    <div class="cd-spec">{{ $p->especialidad ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="tc">
                            <span class="bpill {{ $contrato[1] }}">{{ $contrato[0] }}</span>
                        </td>
                        <td>
                            @if(count($materiasList))
                            <div class="cd-chips">
                                @foreach(array_slice($materiasList, 0, 3) as $m)
                                    <span class="cd-chip">{{ $m }}</span>
                                @endforeach
                                @if(count($materiasList) > 3)
                                    <span class="cd-chip" style="background:#f1f5f9;color:#64748b;">
                                        +{{ count($materiasList) - 3 }}
                                    </span>
                                @endif
                            </div>
                            @else
                                <span style="color:#cbd5e1;font-size:.78rem;">Sin materias</span>
                            @endif
                        </td>
                        <td class="tc">
                            <span style="font-weight:700;color:#0f172a;">{{ $p->total_grados ?? 0 }}</span>
                        </td>
                        <td class="tc">
                            <span style="font-weight:700;color:#00508f;">{{ $p->total_horas ?? 0 }}</span>
                        </td>
                        <td style="min-width:160px;">
                            <div class="cd-bar-wrap">
                                <div class="cd-bar-bg">
                                    <div class="cd-bar-fill"
                                         style="width:{{ $pct }}%;background:{{ $barColor }};"></div>
                                </div>
                                <span class="cd-bar-num">{{ $p->total_estudiantes }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="cd-empty">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <p>No hay datos de carga docente para este año lectivo</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="cd-footer">
            Mostrando {{ $profesores->count() }} profesores activos · Año lectivo {{ $anio }}
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('cdSearch')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#cdTable tbody tr[data-name]').forEach(row => {
        row.style.display = row.dataset.name.includes(q) ? '' : 'none';
    });
});
</script>
@endpush
