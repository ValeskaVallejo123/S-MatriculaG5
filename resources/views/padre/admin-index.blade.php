@extends('layouts.app')

@section('title', 'Padres y Tutores')
@section('page-title', 'Gestión de Padres y Tutores')
@section('content-class', 'p-0')

@push('styles')
<style>
.pad-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.pad-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.pad-hero-left { display: flex; align-items: center; gap: 1rem; }
.pad-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pad-hero-icon i { font-size: 1.3rem; color: white; }
.pad-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.pad-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.pad-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 90px;
}
.pad-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.pad-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.pad-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.pad-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Toolbar */
.pad-toolbar {
    padding: .9rem 2rem;
    background: white;
    border-bottom: 1px solid #e8eef5;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}
.pad-search {
    position: relative;
    flex: 1;
    max-width: 420px;
}
.pad-search i {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .85rem;
}
.pad-search input {
    width: 100%;
    padding: .45rem 1rem .45rem 2.4rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .875rem; transition: border-color .2s, box-shadow .2s; background: #f8fafc;
}
.pad-search input:focus {
    border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    outline: none; background: white;
}
.pad-btn-search {
    padding: .42rem .85rem; border-radius: 7px; border: none;
    background: linear-gradient(135deg,#4ec7d2,#00508f); color: #fff;
    font-size: .8rem; font-weight: 600; cursor: pointer;
}
.pad-btn-clear {
    font-size: .78rem; color: #64748b; text-decoration: none;
    display: inline-flex; align-items: center; gap: .3rem;
}
.pad-btn-clear:hover { color: #ef4444; }

.pad-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; margin-left: auto; }
.pad-perpage select {
    padding: .35rem .65rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .8rem; background: #f8fafc; outline: none; cursor: pointer;
}
.pad-perpage select:focus { border-color: #4ec7d2; }

/* Scrollable body */
.pad-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Table card */
.pad-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.pad-tbl thead th {
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
.pad-tbl thead th.tc { text-align: center; }
.pad-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.pad-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.pad-tbl tbody td { padding: .7rem 1rem; vertical-align: middle; font-size: .82rem; color: #334155; }
.pad-tbl tbody td.tc { text-align: center; }
.pad-tbl tbody tr:last-child { border-bottom: none; }

/* Avatar */
.pad-av {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .9rem;
}
.pad-sub { font-size: .73rem; color: #64748b; }

/* Badges */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-blue   { background: #e8f8f9; color: #00508f; }
.b-green  { background: #ecfdf5; color: #059669; }
.b-red    { background: #fef2f2; color: #dc2626; }
.b-amber  { background: #fffbeb; color: #92400e; }
.b-gray   { background: #f1f5f9; color: #64748b; }

/* Hijos chips */
.hijo-chip {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .2rem .55rem; border-radius: 6px;
    background: #f0f9ff; color: #0369a1;
    font-size: .72rem; font-weight: 600;
    border: 1px solid #bae6fd; margin: .1rem;
}
.hijos-empty { font-size: .75rem; color: #cbd5e1; font-style: italic; }

/* Action buttons */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view { background: #f0fdf4; color: #059669; }
.act-view:hover { background: #059669; color: #fff; }
.act-edit { background: #e8f8f9; color: #00508f; }
.act-edit:hover { background: #4ec7d2; color: #fff; }
.act-del  { background: #fef2f2; color: #ef4444; }
.act-del:hover  { background: #ef4444; color: #fff; }

/* Pagination */
.pad-pag {
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
.pagination .page-item.disabled .page-link { opacity: .45; }

/* Dark mode */
body.dark-mode .pad-wrap  { background: #0f172a; }
body.dark-mode .pad-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .pad-search input { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .pad-perpage select { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .pad-table-card { background: #1e293b; }
body.dark-mode .pad-tbl tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .pad-tbl tbody td { color: #cbd5e1; }
body.dark-mode .pad-tbl tbody tr { border-color: #334155; }
body.dark-mode .pad-pag { border-color: #334155; }
</style>
@endpush

@section('content')
<div class="pad-wrap">

    {{-- Hero --}}
    <div class="pad-hero">
        <div class="pad-hero-left">
            <div class="pad-hero-icon"><i class="fas fa-users"></i></div>
            <div>
                <h2 class="pad-hero-title">Gestión de Padres y Tutores</h2>
                <p class="pad-hero-sub">Administra los responsables y tutores de los estudiantes</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="pad-stat">
                <div class="pad-stat-num">{{ $totalPadres }}</div>
                <div class="pad-stat-lbl">Total</div>
            </div>
            <div class="pad-stat">
                <div class="pad-stat-num">{{ $totalActivos }}</div>
                <div class="pad-stat-lbl">Activos</div>
            </div>
            <div class="pad-stat">
                <div class="pad-stat-num">{{ $totalConHijos }}</div>
                <div class="pad-stat-lbl">Con Hijos</div>
            </div>
            <a href="{{ route('padres.create') }}" class="pad-btn-new">
                <i class="fas fa-plus"></i> Nuevo Padre/Tutor
            </a>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="pad-toolbar">
        <form method="GET" action="{{ route('padres.index') }}" style="display:flex;align-items:center;gap:.5rem;flex:1;max-width:520px;">
            <div class="pad-search" style="max-width:none;flex:1;">
                <i class="fas fa-search"></i>
                <input type="text" name="buscar" placeholder="Buscar por nombre, DNI o correo..."
                       value="{{ request('buscar') }}">
            </div>
            <button type="submit" class="pad-btn-search">
                <i class="fas fa-search"></i> Buscar
            </button>
            @if(request('buscar'))
                <a href="{{ route('padres.index') }}" class="pad-btn-clear">
                    <i class="fas fa-times"></i> Limpiar
                </a>
            @endif
        </form>
        <div class="pad-perpage">
            <label>Mostrar:</label>
            <select onchange="cambiarPerPage(this.value)">
                @foreach([10, 25, 50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 15) == $op ? 'selected' : '' }}>
                        {{ $op }} por página
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Body --}}
    <div class="pad-body">

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
        <div class="pad-table-card">
            <div class="table-responsive">
                <table class="table pad-tbl mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Padre / Tutor</th>
                            <th>Contacto</th>
                            <th class="tc">Parentesco</th>
                            <th>Hijos Vinculados</th>
                            <th class="tc">Estado</th>
                            <th class="tc">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($padres as $index => $padre)
                        <tr>
                            <td>
                                <span style="width:28px;height:28px;border-radius:6px;background:#f1f5f9;color:#64748b;
                                            display:inline-flex;align-items:center;justify-content:center;
                                            font-size:.75rem;font-weight:700;">
                                    {{ $padres->firstItem() + $index }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="pad-av">{{ strtoupper(substr($padre->nombre,0,1)) }}</div>
                                    <div>
                                        <div class="fw-semibold" style="color:#003b73;font-size:.88rem;">
                                            {{ $padre->nombre }} {{ $padre->apellido }}
                                        </div>
                                        @if($padre->dni)
                                            <div class="pad-sub">
                                                <i class="fas fa-id-card" style="font-size:.65rem;"></i> {{ $padre->dni }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($padre->correo)
                                    <div class="pad-sub">
                                        <i class="fas fa-envelope" style="color:#4ec7d2;font-size:.7rem;"></i> {{ $padre->correo }}
                                    </div>
                                @endif
                                @if($padre->telefono)
                                    <div class="pad-sub">
                                        <i class="fas fa-phone" style="color:#4ec7d2;font-size:.7rem;"></i> {{ $padre->telefono }}
                                    </div>
                                @endif
                                @if(!$padre->correo && !$padre->telefono)
                                    <span class="hijos-empty">Sin contacto</span>
                                @endif
                            </td>

                            <td class="tc">
                                @php
                                    $parentesco = match($padre->parentesco) {
                                        'padre'      => ['Padre', 'b-blue'],
                                        'madre'      => ['Madre', 'b-green'],
                                        'tutor_legal'=> ['Tutor Legal', 'b-amber'],
                                        'abuelo'     => ['Abuelo', 'b-gray'],
                                        'abuela'     => ['Abuela', 'b-gray'],
                                        default      => [ucfirst($padre->parentesco_otro ?? $padre->parentesco), 'b-gray'],
                                    };
                                @endphp
                                <span class="bpill {{ $parentesco[1] }}">{{ $parentesco[0] }}</span>
                            </td>

                            <td>
                                @if($padre->estudiantes->count() > 0)
                                    @foreach($padre->estudiantes as $estudiante)
                                        <span class="hijo-chip">
                                            <i class="fas fa-user-graduate" style="font-size:.6rem;"></i>
                                            {{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="hijos-empty">Sin hijos vinculados</span>
                                @endif
                            </td>

                            <td class="tc">
                                @if($padre->estado)
                                    <span class="bpill b-green">
                                        <i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activo
                                    </span>
                                @else
                                    <span class="bpill b-red">
                                        <i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactivo
                                    </span>
                                @endif
                            </td>

                            <td class="tc">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('padres.show', $padre->id) }}"
                                       class="act-btn act-view" title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('padres.edit', $padre->id) }}"
                                       class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="act-btn act-del"
                                            data-route="{{ route('padres.destroy', $padre->id) }}"
                                            data-message="¿Estás seguro de eliminar a este padre/tutor?"
                                            data-name="{{ $padre->nombre }} {{ $padre->apellido }}"
                                            onclick="mostrarModalDeleteData(this)"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                                <div class="fw-semibold" style="color:#003b73;">
                                    @if(request('buscar'))
                                        No se encontraron resultados para "{{ request('buscar') }}"
                                    @else
                                        No hay padres/tutores registrados
                                    @endif
                                </div>
                                <small class="text-muted">
                                    @if(request('buscar'))
                                        <a href="{{ route('padres.index') }}">Ver todos</a>
                                    @else
                                        Agrega el primer padre o tutor
                                    @endif
                                </small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($padres->hasPages())
            <div class="pad-pag">
                <small class="text-muted">
                    Mostrando {{ $padres->firstItem() }} – {{ $padres->lastItem() }} de {{ $padres->total() }} registros
                </small>
                {{ $padres->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>{{-- /pad-body --}}
</div>
@endsection

@push('scripts')
<script>
function cambiarPerPage(valor) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', valor);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endpush
