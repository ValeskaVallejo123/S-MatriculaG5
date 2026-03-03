@extends('layouts.app')

@section('title', 'Matrículas')
@section('page-title', 'Gestión de Matrículas')

@section('topbar-actions')
    <a href="{{ route('matriculas.create') }}" class="adm-btn-solid">
        <i class="fas fa-plus"></i> Nueva Matrícula
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.mat-wrap { font-family: 'Inter', sans-serif; }

.adm-btn-solid {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; border: none; text-decoration: none; transition: opacity .15s;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

/* ── Stats ── */
.mat-stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.25rem; }
@media(max-width:768px){ .mat-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .mat-stats { grid-template-columns: 1fr; } }

.mat-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1rem 1.1rem; display: flex; align-items: center; gap: .85rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.mat-stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.mat-stat-icon i { font-size: 1.15rem; color: #fff; }
.mat-stat-lbl { font-size: .72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .1rem; }
.mat-stat-num { font-size: 1.6rem; font-weight: 700; color: #0f172a; line-height: 1; }

/* ── Filter card ── */
.mat-filter {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1rem 1.25rem; margin-bottom: 1.25rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.filter-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: .65rem; align-items: end; }
@media(max-width:900px){ .filter-grid { grid-template-columns: 1fr 1fr; } }
@media(max-width:500px){ .filter-grid { grid-template-columns: 1fr; } }

.filter-label { font-size: .73rem; font-weight: 700; color: #003b73; margin-bottom: .3rem; display: block; }
.filter-input, .filter-select {
    width: 100%; padding: .42rem .75rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; font-family: 'Inter', sans-serif;
    color: #0f172a; outline: none;
    transition: border-color .2s, box-shadow .2s;
    background: #f8fafc;
}
.filter-input:focus, .filter-select:focus {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    background: #fff;
}
.filter-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
    padding: .42rem 1rem; border-radius: 8px;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; border: none; font-size: .82rem; font-weight: 600;
    cursor: pointer; white-space: nowrap; width: 100%;
}
.filter-clear {
    font-size: .75rem; color: #94a3b8; text-decoration: none;
    display: inline-flex; align-items: center; gap: .3rem;
    margin-top: .5rem;
}
.filter-clear:hover { color: #ef4444; }

/* ── Table card ── */
.mat-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.mat-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.mat-card-head i { color: #4ec7d2; font-size: 1rem; }
.mat-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

/* ── Table ── */
.mat-tbl { width: 100%; border-collapse: collapse; }
.mat-tbl thead th {
    background: #f8fafc; padding: .65rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.mat-tbl thead th.tc { text-align: center; }
.mat-tbl thead th.tr { text-align: right; }

.mat-tbl tbody td {
    padding: .7rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155;
    vertical-align: middle;
}
.mat-tbl tbody td.tc { text-align: center; }
.mat-tbl tbody td.tr { text-align: right; }
.mat-tbl tbody tr:last-child td { border-bottom: none; }
.mat-tbl tbody tr { transition: background .12s; }
.mat-tbl tbody tr:hover { background: #f8fafc; }

/* Avatar */
.mat-av {
    width: 36px; height: 36px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .85rem;
}
.mat-name  { font-weight: 600; color: #0f172a; font-size: .83rem; }
.mat-sub   { font-size: .73rem; color: #94a3b8; margin-top: .1rem; }
.mat-code  { font-family: monospace; font-size: .75rem; color: #64748b; }

/* Badges */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-cyan     { background: #e8f8f9; color: #00508f; border: 1px solid #b2e8ed; }
.b-green    { background: #ecfdf5; color: #059669; }
.b-yellow   { background: #fffbeb; color: #92400e; }
.b-red      { background: #fef2f2; color: #dc2626; }
.b-gray     { background: #f1f5f9; color: #64748b; }

/* Action btns */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none;
    transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view { background: #f0f9ff; color: #0369a1; }
.act-view:hover { background: #0369a1; color: #fff; }
.act-edit { background: #e8f8f9; color: #00508f; }
.act-edit:hover { background: #4ec7d2; color: #fff; }

/* Empty */
.mat-empty { padding: 3.5rem 1rem; text-align: center; }
.mat-empty i { font-size: 2rem; color: #cbd5e1; margin-bottom: .75rem; display: block; }
.mat-empty p { color: #94a3b8; font-size: .85rem; margin: .25rem 0 1rem; }

/* Footer */
.mat-footer {
    padding: .85rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    background: #fafafa;
}
.mat-pages { font-size: .78rem; color: #94a3b8; }

.pagination { margin: 0; gap: 3px; display: flex; }
.pagination .page-link {
    border-radius: 7px; padding: .3rem .65rem;
    font-size: .78rem; font-weight: 500;
    border: 1px solid #e2e8f0; color: #00508f;
    transition: all .15s; line-height: 1.4;
}
.pagination .page-link:hover { background: #e8f8f9; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border-color: #4ec7d2; color: #fff;
}
.pagination .page-item.disabled .page-link { opacity: .45; }
</style>
@endpush

@section('content')
<div class="mat-wrap">

    {{-- Stats --}}
    <div class="mat-stats">
        <div class="mat-stat">
            <div class="mat-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div>
                <div class="mat-stat-lbl">Total</div>
                <div class="mat-stat-num">{{ $matriculas->total() }}</div>
            </div>
        </div>
        <div class="mat-stat">
            <div class="mat-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="mat-stat-lbl">Aprobadas</div>
                <div class="mat-stat-num">{{ $aprobadas ?? 0 }}</div>
            </div>
        </div>
        <div class="mat-stat">
            <div class="mat-stat-icon" style="background:linear-gradient(135deg,#fbbf24,#f59e0b);">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="mat-stat-lbl">Pendientes</div>
                <div class="mat-stat-num">{{ $pendientes ?? 0 }}</div>
            </div>
        </div>
        <div class="mat-stat">
            <div class="mat-stat-icon" style="background:linear-gradient(135deg,#f87171,#dc2626);">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <div class="mat-stat-lbl">Rechazadas</div>
                <div class="mat-stat-num">{{ $rechazadas ?? 0 }}</div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="mat-filter">
        <form action="{{ route('matriculas.index') }}" method="GET">
            <div class="filter-grid">
                <div>
                    <label class="filter-label"><i class="fas fa-search"></i> Buscar</label>
                    <input type="text" name="buscar" class="filter-input"
                           placeholder="Nombre, apellido o DNI..."
                           value="{{ request('buscar') }}">
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-graduation-cap"></i> Grado</label>
                    <select name="grado" class="filter-select">
                        <option value="">Todos</option>
                        @foreach(['1°','2°','3°','4°','5°','6°'] as $g)
                        <option value="{{ $g }}" {{ request('grado') === $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-flag"></i> Estado</label>
                    <select name="estado" class="filter-select">
                        <option value="">Todos</option>
                        <option value="aprobada"  {{ request('estado') === 'aprobada'  ? 'selected' : '' }}>Aprobada</option>
                        <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="rechazada" {{ request('estado') === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                    </select>
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-calendar"></i> Año</label>
                    <select name="anio" class="filter-select">
                        <option value="">Todos</option>
                        <option value="2025" {{ request('anio') === '2025' ? 'selected' : '' }}>2025</option>
                        <option value="2024" {{ request('anio') === '2024' ? 'selected' : '' }}>2024</option>
                        <option value="2023" {{ request('anio') === '2023' ? 'selected' : '' }}>2023</option>
                    </select>
                </div>
                <div>
                    <label class="filter-label" style="opacity:0;">-</label>
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </div>
            @if(request('buscar') || request('grado') || request('estado') || request('anio'))
            <a href="{{ route('matriculas.index') }}" class="filter-clear">
                <i class="fas fa-times"></i> Limpiar filtros
            </a>
            @endif
        </form>
    </div>

    {{-- Table card --}}
    <div class="mat-card">
        <div class="mat-card-head">
            <i class="fas fa-clipboard-list"></i>
            <span>Lista de Matrículas</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="mat-tbl">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th class="tc">Grado / Sección</th>
                        <th class="tc">Año</th>
                        <th>Padre/Tutor</th>
                        <th class="tc">Estado</th>
                        <th class="tr">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matriculas as $matricula)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:.65rem;">
                                <div class="mat-av">
                                    {{ strtoupper(substr($matricula->estudiante->nombre1 ?? $matricula->estudiante->nombre ?? 'N', 0, 1) . substr($matricula->estudiante->apellido1 ?? $matricula->estudiante->apellido ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="mat-name">
                                        {{ $matricula->estudiante->nombre1 ?? $matricula->estudiante->nombre ?? 'N/A' }}
                                        {{ $matricula->estudiante->apellido1 ?? $matricula->estudiante->apellido ?? '' }}
                                    </div>
                                    <div class="mat-sub">
                                        <i class="fas fa-id-card"></i> {{ $matricula->estudiante->dni ?? 'Sin DNI' }}
                                        &nbsp;·&nbsp;
                                        <span class="mat-code">{{ $matricula->codigo_matricula }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="tc">
                            <span class="bpill b-cyan" style="margin-right:.4rem;">{{ $matricula->estudiante->grado ?? 'N/A' }}</span>
                            <span class="bpill b-gray">Sec. {{ $matricula->estudiante->seccion ?? 'N/A' }}</span>
                        </td>

                        <td class="tc">
                            <span style="font-size:.8rem;font-weight:600;color:#475569;">{{ $matricula->anio_lectivo ?? '—' }}</span>
                        </td>

                        <td>
                            @if($matricula->padre)
                            <div class="mat-name">{{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}</div>
                            <div class="mat-sub"><i class="fas fa-phone"></i> {{ $matricula->padre->telefono ?? 'Sin teléfono' }}</div>
                            @else
                            <span style="font-size:.78rem;color:#cbd5e1;font-style:italic;">Sin padre asignado</span>
                            @endif
                        </td>

                        <td class="tc">
                            @if($matricula->estado === 'aprobada')
                                <span class="bpill b-green"><i class="fas fa-check-circle"></i> Aprobada</span>
                            @elseif($matricula->estado === 'pendiente')
                                <span class="bpill b-yellow"><i class="fas fa-clock"></i> Pendiente</span>
                            @elseif($matricula->estado === 'rechazada')
                                <span class="bpill b-red"><i class="fas fa-times-circle"></i> Rechazada</span>
                            @else
                                <span class="bpill b-gray">{{ ucfirst($matricula->estado) }}</span>
                            @endif
                        </td>

                        <td class="tr">
                            <div style="display:inline-flex;gap:.35rem;">
                                <a href="{{ route('matriculas.show', $matricula->id) }}"
                                   class="act-btn act-view" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('matriculas.edit', $matricula->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="mat-empty">
                                <i class="fas fa-clipboard-list"></i>
                                <p>
                                    @if(request('buscar') || request('grado') || request('estado') || request('anio'))
                                        No se encontraron resultados con los filtros aplicados
                                    @else
                                        No hay matrículas registradas
                                    @endif
                                </p>
                                <a href="{{ route('matriculas.create') }}" class="adm-btn-solid">
                                    <i class="fas fa-plus"></i> Nueva Matrícula
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($matriculas->hasPages())
        <div class="mat-footer">
            <span class="mat-pages">
                Mostrando {{ $matriculas->firstItem() }}–{{ $matriculas->lastItem() }} de {{ $matriculas->total() }}
            </span>
            {{ $matriculas->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection