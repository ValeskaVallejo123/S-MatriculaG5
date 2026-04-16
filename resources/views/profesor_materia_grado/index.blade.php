@extends('layouts.app')

@section('title', 'Asignación Profesor-Materia-Grado')
@section('page-title', 'Asignación Profesor-Materia-Grado')
@section('content-class', 'p-0')

@push('styles')
<style>
.pmg-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.pmg-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.pmg-hero-left { display: flex; align-items: center; gap: 1rem; }
.pmg-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pmg-hero-icon i { font-size: 1.3rem; color: white; }
.pmg-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.pmg-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.pmg-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 80px;
}
.pmg-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.pmg-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.pmg-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.pmg-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Toolbar */
.pmg-toolbar {
    background: white;
    border-bottom: 1px solid #e2e8f0;
    padding: .75rem 1.5rem;
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
    flex-shrink: 0;
}
.pmg-search-wrap {
    position: relative;
    flex: 1;
    min-width: 220px;
    max-width: 380px;
}
.pmg-search-wrap i {
    position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .8rem; pointer-events: none;
}
.pmg-search-wrap input {
    width: 100%;
    padding: .4rem .75rem .4rem 2rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #334155;
    transition: border-color .2s;
}
.pmg-search-wrap input:focus { outline: none; border-color: #4ec7d2; }
.pmg-select {
    padding: .4rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #334155; background: white; cursor: pointer;
}
.pmg-btn-search {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .4rem .9rem; border-radius: 8px;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none; font-size: .82rem; font-weight: 600; cursor: pointer;
}
.pmg-btn-clear {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .4rem .75rem; border-radius: 8px;
    border: 1.5px solid #e2e8f0; background: white;
    color: #64748b; font-size: .82rem; font-weight: 500; text-decoration: none;
}
.pmg-btn-clear:hover { background: #f8fafc; color: #334155; }

/* Scrollable body */
.pmg-body { flex: 1; overflow-y: auto; }

/* Table card */
.pmg-table-card {
    background: white;
    margin: 1.25rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.pmg-tbl thead th {
    background: #003b73;
    color: white;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: .75rem 1rem;
    border: none;
}
.pmg-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.pmg-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.pmg-tbl tbody td { padding: .75rem 1rem; vertical-align: middle; font-size: .85rem; color: #334155; }
.pmg-tbl tbody tr:last-child { border-bottom: none; }

/* Materia badge */
.materia-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    background: rgba(78,199,210,.1); color: #00508f;
    border: 1px solid #4ec7d2;
    border-radius: 999px; padding: .25rem .65rem;
    font-size: .75rem; font-weight: 600;
}
.seccion-badge {
    display: inline-flex; align-items: center;
    background: rgba(0,80,143,.1); color: #00508f;
    border: 1px solid #00508f;
    border-radius: 999px; padding: .25rem .65rem;
    font-size: .78rem; font-weight: 700;
}

/* Action buttons */
.btn-edit-sm {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .6rem; border-radius: 6px;
    background: rgba(78,199,210,.1); color: #00508f;
    border: 1px solid #4ec7d2;
    font-size: .75rem; font-weight: 600; text-decoration: none; transition: background .15s;
}
.btn-edit-sm:hover { background: rgba(78,199,210,.25); color: #00508f; }
.btn-del-sm {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .6rem; border-radius: 6px;
    background: rgba(239,68,68,.08); color: #dc2626;
    border: 1px solid #fca5a5;
    font-size: .75rem; font-weight: 600; cursor: pointer; transition: background .15s;
}
.btn-del-sm:hover { background: rgba(239,68,68,.18); }

/* Empty state */
.pmg-empty {
    text-align: center; padding: 3.5rem 1rem;
}
.pmg-empty i { font-size: 2.5rem; color: #bfd9ea; display: block; margin-bottom: .75rem; }
.pmg-empty p { font-size: .9rem; font-weight: 600; color: #003b73; margin: 0 0 .5rem; }
.pmg-empty small { font-size: .8rem; color: #94a3b8; }

/* Footer paginación */
.pmg-footer {
    padding: .75rem 1.5rem;
    display: flex; align-items: center; justify-content: space-between;
    background: white; border-top: 1px solid #f1f5f9;
    flex-wrap: wrap; gap: .5rem; flex-shrink: 0;
    margin: 0 1.5rem 1.25rem;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
}
.pmg-pages { font-size: .78rem; color: #94a3b8; }
.pagination { margin: 0; gap: 3px; display: flex; }
.pagination .page-link {
    border-radius: 7px; padding: .3rem .65rem;
    font-size: .78rem; font-weight: 500;
    border: 1px solid #e2e8f0; color: #00508f; transition: all .15s; line-height: 1.4;
}
.pagination .page-link:hover { background: #e8f8f9; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border-color: #4ec7d2; color: #fff;
}
.pagination .page-item.disabled .page-link { opacity: .45; }

/* Dark mode */
body.dark-mode .pmg-wrap  { background: #0f172a; }
body.dark-mode .pmg-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .pmg-search-wrap input { background: #0f172a; border-color: #334155; color: #cbd5e1; }
body.dark-mode .pmg-select { background: #0f172a; border-color: #334155; color: #cbd5e1; }
body.dark-mode .pmg-table-card { background: #1e293b; }
body.dark-mode .pmg-tbl tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .pmg-tbl tbody td { color: #cbd5e1; }
body.dark-mode .pmg-tbl tbody tr { border-color: #334155; }
body.dark-mode .pmg-footer { background: #1e293b; border-color: #334155; }
</style>
@endpush

@section('content')
<div class="pmg-wrap">

    {{-- Hero --}}
    <div class="pmg-hero">
        <div class="pmg-hero-left">
            <div class="pmg-hero-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <h2 class="pmg-hero-title">Asignación Profesor-Materia-Grado</h2>
                <p class="pmg-hero-sub">Gestiona qué profesor imparte cada materia en cada grado y sección</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="pmg-stat">
                <div class="pmg-stat-num">{{ $totalProfesores }}</div>
                <div class="pmg-stat-lbl">Profesores</div>
            </div>
            <div class="pmg-stat">
                <div class="pmg-stat-num">{{ $totalAsignaciones }}</div>
                <div class="pmg-stat-lbl">Asignaciones</div>
            </div>
            <div class="pmg-stat">
                <div class="pmg-stat-num">{{ $asignaciones->sum(fn($g) => $g->count()) }}</div>
                <div class="pmg-stat-lbl">Grupos</div>
            </div>
            <a href="{{ route('profesor_materia_grado.create') }}" class="pmg-btn-new">
                <i class="fas fa-plus"></i> Nueva Asignación
            </a>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="pmg-toolbar">
        <form method="GET" action="{{ route('profesor_materia_grado.index') }}"
              class="d-flex align-items-center gap-2 flex-wrap w-100">
            <div class="pmg-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       placeholder="Buscar profesor o materia...">
            </div>
            <select name="per_page" class="pmg-select" onchange="this.form.submit()">
                @foreach([10, 15, 25, 50] as $n)
                    <option value="{{ $n }}" {{ request('per_page', 15) == $n ? 'selected' : '' }}>
                        {{ $n }} por página
                    </option>
                @endforeach
            </select>
            <button type="submit" class="pmg-btn-search">
                <i class="fas fa-search"></i> Buscar
            </button>
            @if(request('buscar'))
                <a href="{{ route('profesor_materia_grado.index') }}" class="pmg-btn-clear">
                    <i class="fas fa-times"></i> Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- Body --}}
    <div class="pmg-body">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3 mb-0 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3 mb-0 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #ef4444 !important;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Table card --}}
        <div class="pmg-table-card">
            @if($asignaciones->isEmpty())
                <div class="pmg-empty">
                    <i class="fas fa-inbox"></i>
                    <p>No hay asignaciones registradas</p>
                    <small>Crea la primera asignación para comenzar.</small><br>
                    <a href="{{ route('profesor_materia_grado.create') }}"
                       style="display:inline-flex;align-items:center;gap:.4rem;margin-top:.75rem;
                              background:linear-gradient(135deg,#4ec7d2,#00508f);
                              color:white;padding:.5rem 1.25rem;border-radius:8px;
                              font-weight:700;font-size:.85rem;text-decoration:none;">
                        <i class="fas fa-plus"></i> Crear primera asignación
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table pmg-tbl mb-0" id="pmgTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Profesor</th>
                                <th>Materia</th>
                                <th>Grado</th>
                                <th style="text-align:center;">Sección</th>
                                <th style="text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asignaciones as $asignacion)
                                <tr>
                                    <td style="color:#94a3b8;font-size:.8rem;">
                                        {{ $asignaciones->firstItem() + $loop->index }}
                                    </td>
                                    <td>
                                        <div style="font-weight:700;color:#003b73;font-size:.88rem;">
                                            {{ $asignacion->profesor?->nombre_completo
                                               ?? trim(($asignacion->profesor?->nombre ?? '') . ' ' . ($asignacion->profesor?->apellido ?? ''))
                                               ?: 'Sin asignar' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="materia-badge">
                                            <i class="fas fa-book" style="font-size:.65rem;"></i>
                                            {{ $asignacion->materia->nombre ?? '—' }}
                                        </span>
                                    </td>
                                    <td style="font-size:.84rem;">
                                        {{ $asignacion->grado?->nombre_completo ?? '—' }}
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="seccion-badge">{{ $asignacion->seccion }}</span>
                                    </td>
                                    <td>
                                        <div style="display:flex;align-items:center;justify-content:center;gap:.4rem;">
                                            <a href="{{ route('profesor_materia_grado.edit', $asignacion->id) }}"
                                               class="btn-edit-sm" title="Editar">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('profesor_materia_grado.destroy', $asignacion->id) }}"
                                                  data-confirm="¿Eliminar esta asignación?"
                                                  class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-del-sm" title="Eliminar">
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

        {{-- Paginación --}}
        @if($asignaciones->hasPages())
            <div class="pmg-footer">
                <span class="pmg-pages">
                    Mostrando {{ $asignaciones->firstItem() }}–{{ $asignaciones->lastItem() }}
                    de {{ $asignaciones->total() }} asignaciones
                </span>
                {{ $asignaciones->appends(request()->query())->links() }}
            </div>
        @endif

    </div>{{-- /pmg-body --}}
</div>
@endsection
