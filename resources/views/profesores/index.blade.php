@extends('layouts.app')

@section('title', 'Profesores')
@section('page-title', 'Gestión de Profesores')
@section('content-class', 'p-0')

@push('styles')
<style>
.prof-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.prof-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.prof-hero-left { display: flex; align-items: center; gap: 1rem; }
.prof-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.prof-hero-icon i { font-size: 1.3rem; color: white; }
.prof-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.prof-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.prof-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 80px;
}
.prof-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.prof-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.prof-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.prof-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Toolbar */
.prof-toolbar {
    padding: .9rem 2rem;
    background: white;
    border-bottom: 1px solid #e8eef5;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}
.prof-search {
    position: relative;
    flex: 1;
    max-width: 420px;
}
.prof-search i {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .85rem;
}
.prof-search input {
    width: 100%;
    padding: .45rem 1rem .45rem 2.4rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .875rem; transition: border-color .2s, box-shadow .2s; background: #f8fafc;
}
.prof-search input:focus {
    border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    outline: none; background: white;
}
.prof-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
.prof-perpage select {
    padding: .35rem .65rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .8rem; background: #f8fafc; outline: none; cursor: pointer;
}
.prof-perpage select:focus { border-color: #4ec7d2; }
.prof-btn-search {
    padding: .38rem .75rem; border-radius: 7px; font-size: .78rem;
    border: 1.5px solid #4ec7d2; color: #00508f; background: #fff; cursor: pointer;
}
.prof-btn-search:hover { background: #e8f8f9; }
.prof-btn-clear {
    padding: .38rem .75rem; border-radius: 7px; font-size: .78rem;
    border: 1.5px solid #fca5a5; color: #ef4444; background: #fff;
    text-decoration: none;
}
.prof-btn-clear:hover { background: #fef2f2; }

/* Search result bar */
.search-result-bar {
    background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px;
    padding: .5rem 1rem; margin-bottom: 1rem;
    display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #0369a1;
}
.q-badge {
    background: rgba(78,199,210,.2); color: #00508f;
    border: 1px solid #4ec7d2; border-radius: 999px;
    padding: .1rem .5rem; font-weight: 600;
}

/* Scrollable body */
.prof-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem 2rem;
}

/* Table card */
.prof-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.prof-table thead th {
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
.prof-table thead th.tc { text-align: center; }
.prof-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.prof-table tbody tr:hover { background: rgba(78,199,210,.05); }
.prof-table tbody td { padding: .7rem 1rem; vertical-align: middle; }
.prof-table tbody td.tc { text-align: center; }
.prof-table tbody tr:last-child { border-bottom: none; }

/* Avatar */
.p-avatar {
    width: 36px; height: 36px; border-radius: 8px;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: .82rem; flex-shrink: 0;
}

/* Badges */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-blue   { background: #e8f8f9; color: #00508f; }
.b-green  { background: #ecfdf5; color: #059669; }
.b-indigo { background: #eef2ff; color: #4f46e5; }
.b-amber  { background: #fffbeb; color: #92400e; }
.b-red    { background: #fef2f2; color: #dc2626; }

/* Action buttons */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view { background: #f1f5f9; color: #475569; }
.act-view:hover { background: #475569; color: #fff; }
.act-edit { background: #e8f8f9; color: #00508f; }
.act-edit:hover { background: #4ec7d2; color: #fff; }
.act-del  { background: #fef2f2; color: #ef4444; }
.act-del:hover  { background: #ef4444; color: #fff; }

/* Pagination */
.prof-pag {
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
body.dark-mode .prof-wrap  { background: #0f172a; }
body.dark-mode .prof-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .prof-search input { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .prof-perpage select { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .prof-table-card { background: #1e293b; }
body.dark-mode .prof-table tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .prof-table tbody td { color: #cbd5e1; }
body.dark-mode .prof-table tbody tr { border-color: #334155; }
body.dark-mode .prof-pag { border-color: #334155; }
</style>
@endpush

@section('content')
<div class="prof-wrap">

    {{-- Hero --}}
    <div class="prof-hero">
        <div class="prof-hero-left">
            <div class="prof-hero-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <h2 class="prof-hero-title">Gestión de Profesores</h2>
                <p class="prof-hero-sub">Administra el cuerpo docente de la institución</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="prof-stat">
                <div class="prof-stat-num">{{ $profesores->total() }}</div>
                <div class="prof-stat-lbl">Total</div>
            </div>
            <div class="prof-stat">
                <div class="prof-stat-num">{{ $profesores->getCollection()->where('estado','activo')->count() }}</div>
                <div class="prof-stat-lbl">Activos</div>
            </div>
            <div class="prof-stat">
                <div class="prof-stat-num">{{ $profesores->getCollection()->where('estado','licencia')->count() }}</div>
                <div class="prof-stat-lbl">Licencia</div>
            </div>
            <a href="{{ route('profesores.create') }}" class="prof-btn-new">
                <i class="fas fa-plus"></i> Nuevo Profesor
            </a>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="prof-toolbar">
        <form action="{{ route('profesores.index') }}" method="GET" style="display:flex;align-items:center;gap:.5rem;flex:1;max-width:500px;">
            <div class="prof-search" style="max-width:none;flex:1;">
                <i class="fas fa-search"></i>
                <input type="text" name="busqueda" value="{{ request('busqueda') }}"
                       placeholder="Buscar por nombre, DNI, email...">
            </div>
            <button type="submit" class="prof-btn-search"><i class="fas fa-search"></i></button>
            @if(request('busqueda'))
                <a href="{{ route('profesores.index') }}" class="prof-btn-clear">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
        <div class="prof-perpage">
            <label>Mostrar:</label>
            <select onchange="cambiarPerPage(this.value)">
                @foreach([10,25,50] as $op)
                    <option value="{{ $op }}" {{ request('per_page',10)==$op?'selected':'' }}>{{ $op }} por página</option>
                @endforeach
            </select>
        </div>
        @if(request('busqueda'))
        <small class="text-muted ms-auto" style="font-size:.78rem;">
            <strong>{{ $profesores->total() }}</strong> resultado(s) para
            <span class="q-badge">{{ request('busqueda') }}</span>
        </small>
        @endif
    </div>

    {{-- Body --}}
    <div class="prof-body">

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
        <div class="prof-table-card">
            <div class="table-responsive">
                <table class="table prof-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Profesor</th>
                            <th>DNI</th>
                            <th class="tc">Especialidad</th>
                            <th class="tc">Contrato</th>
                            <th class="tc">Estado</th>
                            <th class="tc">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profesores as $index => $profesor)
                        <tr>
                            <td>
                                <span style="width:28px;height:28px;border-radius:6px;background:#f1f5f9;color:#64748b;
                                            display:inline-flex;align-items:center;justify-content:center;
                                            font-size:.75rem;font-weight:700;">
                                    {{ $profesores->firstItem() + $index }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="p-avatar">
                                        {{ strtoupper(substr($profesor->nombre,0,1).substr($profesor->apellido??'',0,1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color:#003b73;font-size:.88rem;">{{ $profesor->nombre_completo }}</div>
                                        @if($profesor->email)
                                            <small class="text-muted" style="font-size:.73rem;">{{ $profesor->email }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($profesor->dni)
                                    <span class="font-monospace" style="color:#00508f;font-size:.85rem;">{{ $profesor->dni }}</span>
                                @else
                                    <span style="color:#cbd5e1;">—</span>
                                @endif
                            </td>
                            <td class="tc">
                                @if($profesor->especialidad)
                                    <span class="bpill b-blue"><i class="fas fa-book"></i> {{ $profesor->especialidad }}</span>
                                @else
                                    <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                                @endif
                            </td>
                            <td class="tc">
                                @if($profesor->tipo_contrato)
                                    <span class="bpill b-indigo">
                                        <i class="fas fa-file-contract"></i>
                                        {{ ucwords(str_replace('_',' ',$profesor->tipo_contrato)) }}
                                    </span>
                                @else
                                    <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                                @endif
                            </td>
                            <td class="tc">
                                @if($profesor->estado === 'activo')
                                    <span class="bpill b-green">
                                        <i class="fas fa-circle" style="font-size:.45rem;vertical-align:middle;"></i> Activo
                                    </span>
                                @elseif($profesor->estado === 'licencia')
                                    <span class="bpill b-amber"><i class="fas fa-clock"></i> Licencia</span>
                                @else
                                    <span class="bpill b-red">
                                        <i class="fas fa-circle" style="font-size:.45rem;vertical-align:middle;"></i> Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="tc">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('profesores.show', $profesor->id) }}" class="act-btn act-view" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('profesores.edit', $profesor->id) }}" class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="act-btn act-del"
                                            onclick="confirmDelete('{{ $profesor->id }}','{{ $profesor->nombre_completo }}')"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $profesor->id }}"
                                          action="{{ route('profesores.destroy', $profesor->id) }}"
                                          method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-chalkboard-teacher fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                                <div class="fw-semibold" style="color:#003b73;">
                                    @if(request('busqueda'))
                                        No se encontró ningún profesor con "{{ request('busqueda') }}"
                                    @else
                                        No hay profesores registrados
                                    @endif
                                </div>
                                <small class="text-muted">
                                    @if(request('busqueda'))
                                        <a href="{{ route('profesores.index') }}">Ver todos</a>
                                    @else
                                        Agrega el primer profesor
                                    @endif
                                </small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($profesores->hasPages())
            <div class="prof-pag">
                <small class="text-muted">
                    {{ $profesores->firstItem() }} – {{ $profesores->lastItem() }} de {{ $profesores->total() }} registros
                </small>
                {{ $profesores->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>{{-- /prof-body --}}
</div>

{{-- Modal eliminar --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content" style="border-radius:14px;border:none;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,.15);">
            <div class="modal-header border-0" style="background:rgba(239,68,68,.07);padding:1.2rem 1.4rem;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:42px;height:42px;background:rgba(239,68,68,.15);border-radius:10px;
                                display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-exclamation-triangle" style="color:#ef4444;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold" style="color:#0f172a;font-size:.93rem;">Confirmar Eliminación</h6>
                        <p class="mb-0 small" style="color:#64748b;">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:1.25rem 1.5rem;">
                <p class="mb-1" style="font-size:.9rem;color:#334155;">
                    ¿Eliminar al profesor <strong id="profesorNombre" style="color:#ef4444;"></strong>?
                </p>
                <p class="text-muted small mb-0">Se perderán todos los datos asociados.</p>
            </div>
            <div class="modal-footer border-0" style="background:#f8f9fa;padding:.85rem 1.5rem;gap:.5rem;">
                <button type="button" data-bs-dismiss="modal"
                        style="padding:.4rem 1.1rem;border-radius:7px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:.82rem;font-weight:600;cursor:pointer;">
                    Cancelar
                </button>
                <button type="button" onclick="submitDelete()"
                        style="padding:.4rem 1.1rem;border-radius:7px;border:none;background:#ef4444;color:#fff;font-size:.82rem;font-weight:600;cursor:pointer;">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let deleteFormId = '';
function confirmDelete(id, nombre) {
    deleteFormId = 'delete-form-' + id;
    document.getElementById('profesorNombre').textContent = nombre;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
function submitDelete() {
    if (deleteFormId) document.getElementById(deleteFormId).submit();
}
function cambiarPerPage(valor) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', valor);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endpush
