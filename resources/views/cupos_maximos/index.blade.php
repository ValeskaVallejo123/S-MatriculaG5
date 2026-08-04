@extends('layouts.app')

@section('title', 'Cupos Máximos')
@section('page-title', 'Cupos Máximos')

@section('topbar-actions')
    <a href="{{ route('superadmin.cupos_maximos.create') }}" class="cupo-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="cupo-btn-text">Nuevo Cupo</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botón topbar ── */
    .cupo-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .cupo-topbar-btn:hover { opacity: .88; color: white; }
    @media(max-width:600px) {
        .cupo-btn-text { display: none; }
        .cupo-topbar-btn { padding: .5rem .65rem; }
    }

    /* ── Variables ── */
    :root {
        --blue-dark: #003b73; --blue-mid: #00508f;
        --teal: #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border: #e8edf4; --surface: #f5f8fc;
        --text-main: #0d2137; --text-muted: #6b7a90;
        --green: #10b981; --amber: #f59e0b; --red: #ef4444;
        --radius-lg: 14px; --radius-sm: 7px;
        --shadow-sm: 0 1px 4px rgba(0,59,115,0.07);
        --shadow-md: 0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .cupo-stats {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width:768px){ .cupo-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .cupo-stats { grid-template-columns: 1fr; } }

    .cupo-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm);
        transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .cupo-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .cs-total::before     { background: var(--teal); }
    .cs-matutina::before  { background: var(--amber); }
    .cs-vespertina::before{ background: #818cf8; }
    .cupo-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .cupo-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .cs-total      .cupo-stat-icon { background: var(--teal-light);      color: var(--teal); }
    .cs-matutina   .cupo-stat-icon { background: rgba(245,158,11,.12);    color: var(--amber); }
    .cs-vespertina .cupo-stat-icon { background: rgba(129,140,248,.15);   color: #4f46e5; }

    .cupo-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .cupo-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .cupo-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Toolbar ── */
    .cupo-toolbar {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: .9rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .cupo-search-wrap { position: relative; flex: 1; min-width: 200px; }
    .cupo-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; pointer-events: none; }
    .cupo-search {
        width: 100%; padding: .5rem 1rem .5rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: .85rem; background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s; font-family: inherit; color: var(--text-main);
    }
    .cupo-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

    .cupo-filter-sel {
        padding: .45rem .75rem; border: 1.5px solid var(--border); border-radius: 7px;
        font-size: .82rem; color: var(--text-main); background: var(--surface);
        outline: none; cursor: pointer; font-family: inherit;
    }
    .cupo-filter-sel:focus { border-color: var(--teal); }

    .cupo-btn-filter {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .45rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: white; border: none; cursor: pointer; font-family: inherit; transition: opacity .15s;
    }
    .cupo-btn-filter:hover { opacity: .88; }
    .cupo-btn-clear {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .45rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
        background: white; color: var(--text-muted); border: 1.5px solid var(--border);
        text-decoration: none; transition: all .15s;
    }
    .cupo-btn-clear:hover { border-color: var(--teal); color: var(--blue-mid); }

    /* ── Tabla card ── */
    .cupo-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .cupo-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .cupo-card-head i    { color: var(--teal); font-size: 1rem; }
    .cupo-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    .cupo-tbl { width: 100%; border-collapse: collapse; }
    .cupo-tbl thead th {
        background: var(--surface); padding: .65rem 1rem;
        font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .cupo-tbl thead th.tc { text-align: center; }
    .cupo-tbl tbody td { padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: .84rem; color: var(--text-main); vertical-align: middle; }
    .cupo-tbl tbody td.tc { text-align: center; }
    .cupo-tbl tbody tr:last-child td { border-bottom: none; }
    .cupo-tbl tbody tr { transition: background .15s; }
    .cupo-tbl tbody tr:hover { background: #f7fbff; }

    .row-num {
        width: 26px; height: 26px; border-radius: 7px;
        background: var(--surface); border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .72rem; font-weight: 700; color: var(--text-muted);
    }

    .bpill {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .22rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600; white-space: nowrap;
    }
    .b-teal    { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
    .b-amber   { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }
    .b-purple  { background: rgba(99,102,241,.1); color: #4f46e5; border: 1px solid rgba(99,102,241,.25); }
    .b-green   { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.3); }

    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid; font-size: .78rem;
        background: white; cursor: pointer; transition: all .15s; text-decoration: none;
    }
    .act-edit  { border-color: var(--teal); color: var(--teal); }
    .act-del   { border-color: var(--red);  color: var(--red); }
    .act-edit:hover { background: var(--teal); color: white; transform: translateY(-1px); }
    .act-del:hover  { background: var(--red);  color: white; transform: translateY(-1px); }

    .cupo-empty { padding: 4rem 1rem; text-align: center; }
    .cupo-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .cupo-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .cupo-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    .cupo-footer {
        padding: .85rem 1.25rem; border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    }
    .cupo-footer-info { font-size: .78rem; color: var(--text-muted); }

    .pagination { margin: 0; }
    .pagination .page-link {
        border-radius: 7px; margin: 0 2px; border: 1.5px solid var(--border);
        color: var(--blue-mid); padding: .28rem .6rem; font-size: .82rem; transition: all .15s;
    }
    .pagination .page-link:hover { background: var(--teal-light); border-color: var(--teal); }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        border-color: var(--teal); color: white; box-shadow: 0 2px 6px rgba(78,199,210,.35);
    }
    .pagination .page-item.disabled .page-link { opacity: .45; }
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="cupo-stats">
        <div class="cupo-stat cs-total">
            <div class="cupo-stat-icon"><i class="fas fa-users-cog"></i></div>
            <div>
                <div class="cupo-stat-lbl">Total Cupos</div>
                <div class="cupo-stat-num">{{ $totalCupos }}</div>
                <div class="cupo-stat-sub">Registrados</div>
            </div>
        </div>
        <div class="cupo-stat cs-matutina">
            <div class="cupo-stat-icon"><i class="fas fa-sun"></i></div>
            <div>
                <div class="cupo-stat-lbl">Matutina</div>
                <div class="cupo-stat-num">{{ $totalMatutina }}</div>
                <div class="cupo-stat-sub">Jornada mañana</div>
            </div>
        </div>
        <div class="cupo-stat cs-vespertina">
            <div class="cupo-stat-icon"><i class="fas fa-moon"></i></div>
            <div>
                <div class="cupo-stat-lbl">Vespertina</div>
                <div class="cupo-stat-num">{{ $totalVespertina }}</div>
                <div class="cupo-stat-sub">Jornada tarde</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <form method="GET" action="{{ route('superadmin.cupos_maximos.index') }}">
        <div class="cupo-toolbar">
            <div class="cupo-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="buscar" class="cupo-search"
                       placeholder="Buscar por curso..."
                       value="{{ request('buscar') }}">
            </div>
            <select name="jornada" class="cupo-filter-sel" onchange="this.form.submit()">
                <option value="">Todas las jornadas</option>
                <option value="Matutina"   {{ request('jornada') === 'Matutina'   ? 'selected' : '' }}>Matutina</option>
                <option value="Vespertina" {{ request('jornada') === 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
            </select>
            <select name="seccion" class="cupo-filter-sel" onchange="this.form.submit()">
                <option value="">Todas las secciones</option>
                @foreach(['A','B','C','D'] as $s)
                    <option value="{{ $s }}" {{ request('seccion') === $s ? 'selected' : '' }}>Sección {{ $s }}</option>
                @endforeach
            </select>
            <select name="per_page" class="cupo-filter-sel" onchange="this.form.submit()">
                @foreach([10,15,25,50] as $n)
                    <option value="{{ $n }}" {{ request('per_page', 15) == $n ? 'selected' : '' }}>{{ $n }} por página</option>
                @endforeach
            </select>
            <button type="submit" class="cupo-btn-filter">
                <i class="fas fa-search"></i> Buscar
            </button>
            @if(request()->hasAny(['buscar','jornada','seccion']))
                <a href="{{ route('superadmin.cupos_maximos.index') }}" class="cupo-btn-clear">
                    <i class="fas fa-times"></i> Limpiar
                </a>
            @endif
        </div>
    </form>

    {{-- ── TABLA ── --}}
    <div class="cupo-card">
        <div class="cupo-card-head">
            <i class="fas fa-users-cog"></i>
            <span>Lista de Cupos Máximos</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="cupo-tbl">
                <thead>
                    <tr>
                        <th class="tc" style="width:50px;">#</th>
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
                        <td class="tc">
                            <span class="row-num">{{ $cursos->firstItem() + $loop->index }}</span>
                        </td>
                        <td>
                            <span style="font-weight:600;color:var(--blue-dark);">{{ $curso->nombre }}</span>
                        </td>
                        <td class="tc">
                            <span class="bpill b-teal">
                                <i class="fas fa-users" style="font-size:.65rem;"></i>
                                {{ $curso->cupo_maximo }} alumnos
                            </span>
                        </td>
                        <td class="tc">
                            @if($curso->jornada === 'Matutina')
                                <span class="bpill b-amber"><i class="fas fa-sun" style="font-size:.65rem;"></i> Matutina</span>
                            @elseif($curso->jornada === 'Vespertina')
                                <span class="bpill b-purple"><i class="fas fa-moon" style="font-size:.65rem;"></i> Vespertina</span>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>
                        <td class="tc">
                            @if($curso->seccion)
                                <span class="bpill b-green">{{ $curso->seccion }}</span>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>
                        <td class="tc">
                            <div style="display:inline-flex;gap:.35rem;align-items:center;">
                                <a href="{{ route('superadmin.cupos_maximos.edit', $curso->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button"
                                        class="act-btn act-del" title="Eliminar"
                                        onclick="sysConfirm('¿Eliminar el cupo de {{ addslashes($curso->nombre) }}? Esta acción no se puede deshacer.', function() {
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
                        <td colspan="6">
                            <div class="cupo-empty">
                                <i class="fas fa-users-cog"></i>
                                <h6>No hay cupos registrados</h6>
                                <p>Comienza agregando el primer cupo máximo al sistema</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cursos->hasPages())
            <div class="cupo-footer">
                <span class="cupo-footer-info">
                    Mostrando {{ $cursos->firstItem() }}–{{ $cursos->lastItem() }}
                    de {{ $cursos->total() }} cupos
                </span>
                {{ $cursos->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    {{-- Form oculto para eliminar --}}
    <form id="form-del-idx" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>

</div>
@endsection