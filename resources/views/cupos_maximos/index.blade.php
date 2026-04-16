@extends('layouts.app')

@section('title', 'Cupos Máximos')
@section('page-title', 'Cupos Máximos')
@section('content-class', 'p-0')

@push('styles')
<style>
.cup-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.cup-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.cup-hero-left { display: flex; align-items: center; gap: 1rem; }
.cup-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.cup-hero-icon i { font-size: 1.3rem; color: white; }
.cup-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.cup-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.cup-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 90px;
}
.cup-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.cup-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.cup-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.cup-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Toolbar / filters */
.cup-toolbar {
    padding: .9rem 2rem;
    background: white;
    border-bottom: 1px solid #e8eef5;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
}
.cup-search-wrap { position: relative; flex: 1; min-width: 180px; max-width: 320px; }
.cup-search-icon { position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: .75rem; pointer-events: none; }
.cup-search-input {
    width: 100%; padding: .4rem .75rem .4rem 2rem;
    border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .82rem; background: #f8fafc; outline: none;
}
.cup-search-input:focus { border-color: #4ec7d2; }

.cup-filters { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
.cup-filter-sel {
    padding: .38rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .8rem; background: #f8fafc; outline: none; cursor: pointer;
}
.cup-filter-sel:focus { border-color: #4ec7d2; }

.cup-btn-filter {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .38rem .9rem; border-radius: 7px; font-size: .8rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f); color: #fff;
    border: none; cursor: pointer; transition: opacity .15s;
}
.cup-btn-filter:hover { opacity: .88; }
.cup-btn-clear {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .38rem .9rem; border-radius: 7px; font-size: .8rem; font-weight: 600;
    background: #fff; color: #64748b; border: 1.5px solid #e2e8f0; text-decoration: none;
}
.cup-btn-clear:hover { border-color: #94a3b8; color: #334155; }

/* Scrollable body */
.cup-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Table card */
.cup-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.cup-tbl thead th {
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
.cup-tbl thead th.tc { text-align: center; }
.cup-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.cup-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.cup-tbl tbody td { padding: .7rem 1rem; vertical-align: middle; font-size: .82rem; color: #334155; }
.cup-tbl tbody td.tc { text-align: center; }
.cup-tbl tbody tr:last-child { border-bottom: none; }

/* Badges */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-blue   { background: #e8f8f9; color: #00508f; }
.b-yellow { background: #fef9c3; color: #854d0e; }
.b-purple { background: #f3e8ff; color: #6b21a8; }
.b-green  { background: #dcfce7; color: #166534; }

/* Action buttons */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-edit { background: #e8f8f9; color: #00508f; }
.act-edit:hover { background: #4ec7d2; color: #fff; }
.act-del  { background: #fef2f2; color: #ef4444; }
.act-del:hover  { background: #ef4444; color: #fff; }

/* Pagination */
.cup-pag {
    padding: .75rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .5rem;
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
.pagination .page-item.disabled .page-link { color: #cbd5e1; }

/* Dark mode */
body.dark-mode .cup-wrap  { background: #0f172a; }
body.dark-mode .cup-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .cup-search-input, body.dark-mode .cup-filter-sel { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .cup-table-card { background: #1e293b; }
body.dark-mode .cup-tbl tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .cup-tbl tbody td { color: #cbd5e1; }
body.dark-mode .cup-tbl tbody tr { border-color: #334155; }
body.dark-mode .cup-pag { border-color: #334155; }
</style>
@endpush

@section('content')
<div class="cup-wrap">

    {{-- Hero --}}
    <div class="cup-hero">
        <div class="cup-hero-left">
            <div class="cup-hero-icon"><i class="fas fa-users-cog"></i></div>
            <div>
                <h2 class="cup-hero-title">Cupos Máximos</h2>
                <p class="cup-hero-sub">Configura la capacidad máxima de alumnos por curso y jornada</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="cup-stat">
                <div class="cup-stat-num">{{ $totalCupos }}</div>
                <div class="cup-stat-lbl">Total Cupos</div>
            </div>
            <div class="cup-stat">
                <div class="cup-stat-num">{{ $totalMatutina }}</div>
                <div class="cup-stat-lbl">Matutina</div>
            </div>
            <div class="cup-stat">
                <div class="cup-stat-num">{{ $totalVespertina }}</div>
                <div class="cup-stat-lbl">Vespertina</div>
            </div>
            <a href="{{ route('superadmin.cupos_maximos.create') }}" class="cup-btn-new">
                <i class="fas fa-plus"></i> Nuevo Cupo
            </a>
        </div>
    </div>

    {{-- Toolbar / Filtros --}}
    <form method="GET" action="{{ route('superadmin.cupos_maximos.index') }}" id="frmFiltro">
        <div class="cup-toolbar">
            <div class="cup-search-wrap">
                <i class="fas fa-search cup-search-icon"></i>
                <input type="text" name="buscar" class="cup-search-input"
                       placeholder="Buscar por curso..."
                       value="{{ request('buscar') }}">
            </div>
            <div class="cup-filters">
                <select name="jornada" class="cup-filter-sel" onchange="this.form.submit()">
                    <option value="">Jornada...</option>
                    <option value="Matutina"   {{ request('jornada') === 'Matutina'   ? 'selected' : '' }}>Matutina</option>
                    <option value="Vespertina" {{ request('jornada') === 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                </select>
                <select name="seccion" class="cup-filter-sel" onchange="this.form.submit()">
                    <option value="">Sección...</option>
                    @foreach(['A','B','C','D'] as $s)
                        <option value="{{ $s }}" {{ request('seccion') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                <select name="per_page" class="cup-filter-sel" onchange="this.form.submit()">
                    @foreach([10,15,25,50] as $n)
                        <option value="{{ $n }}" {{ request('per_page', 15) == $n ? 'selected' : '' }}>{{ $n }} / pág</option>
                    @endforeach
                </select>
                <button type="submit" class="cup-btn-filter">
                    <i class="fas fa-search"></i> Buscar
                </button>
                @if(request()->hasAny(['buscar','jornada','seccion']))
                    <a href="{{ route('superadmin.cupos_maximos.index') }}" class="cup-btn-clear">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                @endif
            </div>
        </div>
    </form>

    {{-- Body --}}
    <div class="cup-body">

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
        <div class="cup-table-card">
            <div class="table-responsive">
                <table class="table cup-tbl mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre del Curso</th>
                            <th class="tc">Cupo Máximo</th>
                            <th class="tc">Jornada</th>
                            <th class="tc">Sección</th>
                            <th class="tc">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($cursos as $curso)
                        <tr>
                            <td>
                                <span style="width:28px;height:28px;border-radius:6px;background:#f1f5f9;color:#64748b;
                                            display:inline-flex;align-items:center;justify-content:center;
                                            font-size:.75rem;font-weight:700;">
                                    {{ $cursos->firstItem() + $loop->index }}
                                </span>
                            </td>
                            <td class="fw-semibold" style="color:#003b73;">{{ $curso->nombre }}</td>
                            <td class="tc">
                                <span class="bpill b-blue">
                                    <i class="fas fa-users"></i> {{ $curso->cupo_maximo }} alumnos
                                </span>
                            </td>
                            <td class="tc">
                                @if($curso->jornada === 'Matutina')
                                    <span class="bpill b-yellow"><i class="fas fa-sun"></i> Matutina</span>
                                @elseif($curso->jornada === 'Vespertina')
                                    <span class="bpill b-purple"><i class="fas fa-moon"></i> Vespertina</span>
                                @else
                                    <span style="color:#cbd5e1;">—</span>
                                @endif
                            </td>
                            <td class="tc">
                                @if($curso->seccion)
                                    <span class="bpill b-green">{{ $curso->seccion }}</span>
                                @else
                                    <span style="color:#cbd5e1;">—</span>
                                @endif
                            </td>
                            <td class="tc">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('superadmin.cupos_maximos.edit', $curso->id) }}"
                                       class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="act-btn act-del"
                                            title="Eliminar"
                                            onclick="sysConfirm('¿Eliminar el cupo de {{ addslashes($curso->nombre) }}? Esta acción no se puede deshacer.', () => {
                                                document.getElementById('form-del-idx').action='{{ route('superadmin.cupos_maximos.destroy', $curso->id) }}';
                                                document.getElementById('form-del-idx').submit();
                                            })">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                                <div class="fw-semibold" style="color:#003b73;">No hay cupos registrados</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($cursos->hasPages())
            <div class="cup-pag">
                <small class="text-muted">
                    Mostrando {{ $cursos->firstItem() }} – {{ $cursos->lastItem() }} de {{ $cursos->total() }} cupos
                </small>
                {{ $cursos->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>{{-- /cup-body --}}
</div>

{{-- Form oculto para eliminar --}}
<form id="form-del-idx" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

@endsection
