@extends('layouts.app')

@section('title', 'Matrículas')
@section('page-title', 'Gestión de Matrículas')
@section('content-class', 'p-0')

@push('styles')
<style>
.mat-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.mat-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.mat-hero-left { display: flex; align-items: center; gap: 1rem; }
.mat-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.mat-hero-icon i { font-size: 1.3rem; color: white; }
.mat-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.mat-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.mat-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 80px;
}
.mat-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.mat-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.mat-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.mat-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Toolbar / filters */
.mat-toolbar {
    padding: .9rem 2rem;
    background: white;
    border-bottom: 1px solid #e8eef5;
    flex-shrink: 0;
}
.filter-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: .65rem; align-items: end; }
@media(max-width:900px){ .filter-grid { grid-template-columns: 1fr 1fr; } }
@media(max-width:500px){ .filter-grid { grid-template-columns: 1fr; } }

.filter-label { font-size: .73rem; font-weight: 700; color: #003b73; margin-bottom: .3rem; display: block; }
.filter-input, .filter-select {
    width: 100%; padding: .42rem .75rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #0f172a; outline: none;
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
    display: inline-flex; align-items: center; gap: .3rem; margin-top: .4rem;
}
.filter-clear:hover { color: #ef4444; }

/* Scrollable body */
.mat-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Table card */
.mat-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.mat-tbl thead th {
    background: #003b73;
    color: white;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: .75rem 1rem;
    border: none;
    white-space: nowrap;
}
.mat-tbl thead th.tc { text-align: center; }
.mat-tbl thead th.tr { text-align: right; }
.mat-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.mat-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.mat-tbl tbody td { padding: .7rem 1rem; vertical-align: middle; font-size: .82rem; color: #334155; }
.mat-tbl tbody td.tc { text-align: center; }
.mat-tbl tbody td.tr { text-align: right; }
.mat-tbl tbody tr:last-child { border-bottom: none; }

/* Avatar */
.mat-av {
    width: 36px; height: 36px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .85rem;
}

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

/* Action buttons */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view { background: #f0f9ff; color: #0369a1; }
.act-view:hover { background: #0369a1; color: #fff; }
.act-edit { background: #e8f8f9; color: #00508f; }
.act-edit:hover { background: #4ec7d2; color: #fff; }

/* Pagination */
.mat-pag {
    padding: .75rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.pagination { margin: 0; }
.pagination .page-link {
    border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0;
    color: #00508f; font-size: .82rem; padding: .3rem .65rem; transition: all .2s;
}
.pagination .page-link:hover { background: #bfd9ea; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    border-color: #4ec7d2; color: white;
}

/* Dark mode */
body.dark-mode .mat-wrap  { background: #0f172a; }
body.dark-mode .mat-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .filter-input, body.dark-mode .filter-select { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .mat-table-card { background: #1e293b; }
body.dark-mode .mat-tbl tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .mat-tbl tbody td { color: #cbd5e1; }
body.dark-mode .mat-tbl tbody tr { border-color: #334155; }
body.dark-mode .mat-pag { border-color: #334155; }
</style>
@endpush

@section('content')
<div class="mat-wrap">

    {{-- Hero --}}
    <div class="mat-hero">
        <div class="mat-hero-left">
            <div class="mat-hero-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <h2 class="mat-hero-title">Gestión de Matrículas</h2>
                <p class="mat-hero-sub">Administra las matrículas y vinculaciones de estudiantes</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="mat-stat">
                <div class="mat-stat-num">{{ $matriculas->total() }}</div>
                <div class="mat-stat-lbl">Total</div>
            </div>
            <div class="mat-stat">
                <div class="mat-stat-num">{{ $aprobadas ?? 0 }}</div>
                <div class="mat-stat-lbl">Aprobadas</div>
            </div>
            <div class="mat-stat">
                <div class="mat-stat-num">{{ $pendientes ?? 0 }}</div>
                <div class="mat-stat-lbl">Pendientes</div>
            </div>
            <div class="mat-stat">
                <div class="mat-stat-num">{{ $rechazadas ?? 0 }}</div>
                <div class="mat-stat-lbl">Rechazadas</div>
            </div>
            <a href="{{ route('matriculas.create') }}" class="mat-btn-new">
                <i class="fas fa-plus"></i> Nueva Matrícula
            </a>
        </div>
    </div>

    {{-- Toolbar / Filtros --}}
    <div class="mat-toolbar">
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
                        @foreach(['Primer Grado','Segundo Grado','Tercer Grado','Cuarto Grado','Quinto Grado','Sexto Grado','Séptimo Grado','Octavo Grado','Noveno Grado'] as $g)
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

    {{-- Body --}}
    <div class="mat-body">

        {{-- Table card --}}
        <div class="mat-table-card">
            <div class="table-responsive">
                <table class="table mat-tbl mb-0">
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
                                <div class="d-flex align-items-center gap-2">
                                    <div class="mat-av">
                                        {{ strtoupper(substr($matricula->estudiante->nombre1 ?? $matricula->estudiante->nombre ?? 'N', 0, 1) . substr($matricula->estudiante->apellido1 ?? $matricula->estudiante->apellido ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color:#003b73;font-size:.88rem;">
                                            {{ $matricula->estudiante->nombre1 ?? $matricula->estudiante->nombre ?? 'N/A' }}
                                            {{ $matricula->estudiante->apellido1 ?? $matricula->estudiante->apellido ?? '' }}
                                        </div>
                                        <small style="color:#94a3b8;font-size:.73rem;">
                                            <i class="fas fa-id-card"></i> {{ $matricula->estudiante->dni ?? 'Sin DNI' }}
                                            &nbsp;·&nbsp;
                                            <span class="font-monospace">{{ $matricula->codigo_matricula }}</span>
                                        </small>
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
                                    <div class="fw-semibold" style="font-size:.85rem;">{{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}</div>
                                    <small style="color:#94a3b8;font-size:.73rem;"><i class="fas fa-phone"></i> {{ $matricula->padre->telefono ?? 'Sin teléfono' }}</small>
                                @else
                                    <span style="font-size:.78rem;color:#cbd5e1;font-style:italic;">Sin padre asignado</span>
                                @endif
                            </td>
                            <td class="tc">
                                @if($matricula->estado === 'aprobada')
                                    <span class="bpill b-green"><i class="fas fa-check-circle"></i> Aprobada</span>
                                @elseif($matricula->estado === 'pendiente')
                                    <form action="{{ route('matriculas.aprobar', $matricula->id) }}" method="POST"
                                          style="display:inline;" data-confirm="¿Aprobar esta matrícula?">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bpill b-yellow"
                                                style="border:none;cursor:pointer;font-family:inherit;" title="Clic para aprobar">
                                            <i class="fas fa-clock"></i> Pendiente
                                            <i class="fas fa-arrow-right" style="font-size:.6rem;opacity:.6;"></i>
                                        </button>
                                    </form>
                                @elseif($matricula->estado === 'rechazada')
                                    <span class="bpill b-red"><i class="fas fa-times-circle"></i> Rechazada</span>
                                @else
                                    <span class="bpill b-gray">{{ ucfirst($matricula->estado) }}</span>
                                @endif
                            </td>
                            <td class="tr">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('matriculas.show', $matricula->id) }}" class="act-btn act-view" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('matriculas.edit', $matricula->id) }}" class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-clipboard-list fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                                <div class="fw-semibold" style="color:#003b73;">
                                    @if(request('buscar') || request('grado') || request('estado') || request('anio'))
                                        No se encontraron resultados con los filtros aplicados
                                    @else
                                        No hay matrículas registradas
                                    @endif
                                </div>
                                <small class="text-muted">
                                    @if(request('buscar') || request('grado') || request('estado') || request('anio'))
                                        <a href="{{ route('matriculas.index') }}">Limpiar filtros</a>
                                    @else
                                        <a href="{{ route('matriculas.create') }}">Registrar la primera matrícula</a>
                                    @endif
                                </small>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($matriculas->hasPages())
            <div class="mat-pag">
                <small class="text-muted">
                    Mostrando {{ $matriculas->firstItem() }} – {{ $matriculas->lastItem() }} de {{ $matriculas->total() }} registros
                </small>
                {{ $matriculas->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>{{-- /mat-body --}}
</div>
@endsection
