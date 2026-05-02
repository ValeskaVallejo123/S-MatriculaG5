@extends('layouts.app')

@section('title', 'Profesores')
@section('page-title', 'Gestión de Profesores')

@section('topbar-actions')
    <a href="{{ route('profesores.create') }}" class="adm-btn-solid">
        <i class="fas fa-plus"></i> Nuevo Profesor
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.adm-wrap { font-family: 'Inter', sans-serif; }

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: #fff; color: #00508f; border: 1.5px solid #4ec7d2;
    text-decoration: none; margin-right: .4rem; transition: background .15s;
}
.adm-btn-outline:hover { background: #e8f8f9; }
.adm-btn-solid {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; border: none; text-decoration: none; transition: opacity .15s;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

/* Stats */
.adm-stats {
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
@media(max-width:768px){ .adm-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .adm-stats { grid-template-columns: 1fr; } }

.adm-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.adm-stat-icon i { font-size: 1.15rem; color: #fff; }
.adm-stat-lbl { font-size: .72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .15rem; }
.adm-stat-num { font-size: 1.75rem; font-weight: 700; color: #0f172a; line-height: 1; }

/* Toolbar */
.adm-toolbar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: .85rem 1.25rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); gap: 1rem; flex-wrap: wrap;
}
.adm-search-wrap {
    display: flex; align-items: center; gap: .5rem; flex: 1; min-width: 200px;
}
.adm-search-wrap .search-inner {
    position: relative; flex: 1; max-width: 340px;
}
.adm-search-wrap .search-inner i {
    position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .82rem; pointer-events: none;
}
.adm-search-wrap input {
    width: 100%; padding: .38rem .75rem .38rem 2rem;
    border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .82rem; color: #0f172a; background: #f8fafc; outline: none;
}
.adm-search-wrap input:focus { border-color: #4ec7d2; }
.adm-search-wrap .btn-search {
    padding: .38rem .75rem; border-radius: 7px; font-size: .78rem;
    border: 1.5px solid #4ec7d2; color: #00508f; background: #fff; cursor: pointer;
    transition: background .15s;
}
.adm-search-wrap .btn-search:hover { background: #e8f8f9; }
.adm-search-wrap .btn-clear {
    padding: .38rem .75rem; border-radius: 7px; font-size: .78rem;
    border: 1.5px solid #fca5a5; color: #ef4444; background: #fff; cursor: pointer;
    text-decoration: none; transition: background .15s;
}
.adm-search-wrap .btn-clear:hover { background: #fef2f2; }

.adm-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
.adm-perpage select {
    padding: .3rem .6rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .8rem; color: #0f172a; background: #f8fafc; outline: none; cursor: pointer;
}
.adm-perpage select:focus { border-color: #4ec7d2; }

/* Tabla */
.adm-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
}
.adm-card-head-left { display: flex; align-items: center; gap: .6rem; }
.adm-card-head i { color: #4ec7d2; font-size: 1rem; }
.adm-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }
.adm-card-head-info { color: rgba(255,255,255,.6); font-size: .78rem; }

.adm-tbl { width: 100%; border-collapse: collapse; }
.adm-tbl thead th {
    background: #f8fafc; padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.adm-tbl thead th.tc { text-align: center; }
.adm-tbl tbody td {
    padding: .65rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.adm-tbl tbody td.tc { text-align: center; }
.adm-tbl tbody tr:last-child td { border-bottom: none; }
.adm-tbl tbody tr:hover { background: #fafbfc; }

.adm-num {
    width: 28px; height: 28px; border-radius: 6px;
    background: #f1f5f9; color: #64748b;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700;
}
.adm-av {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .9rem;
}
.adm-name  { font-weight: 600; color: #0f172a; font-size: .82rem; }
.adm-email { font-size: .75rem; color: #64748b; }

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

/* Acciones */
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

/* Empty */
.adm-empty { padding: 3.5rem 1rem; text-align: center; }
.adm-empty i { font-size: 2rem; color: #cbd5e1; margin-bottom: .75rem; display: block; }
.adm-empty p { color: #94a3b8; font-size: .85rem; margin: 0 0 1rem; }
.adm-empty .empty-actions { display: flex; gap: .5rem; justify-content: center; flex-wrap: wrap; }

/* Footer */
.adm-footer {
    padding: .85rem 1.25rem; border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    background: #fafafa; flex-wrap: wrap; gap: .5rem;
}
.adm-pages { font-size: .78rem; color: #94a3b8; }

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

/* Search result badge */
.search-result-bar {
    background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px;
    padding: .5rem 1rem; margin-bottom: 1rem;
    display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #0369a1;
}
.search-result-bar .q-badge {
    background: rgba(78,199,210,.2); color: #00508f;
    border: 1px solid #4ec7d2; border-radius: 999px;
    padding: .1rem .5rem; font-weight: 600;
}
</style>
@endpush

@section('content')
<div class="adm-wrap">

    {{-- ══ Stats ══ --}}
    <div class="adm-stats">
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Total</div>
                <div class="adm-stat-num">{{ $profesores->total() }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Activos</div>
                <div class="adm-stat-num">{{ $profesores->getCollection()->where('estado','activo')->count() }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#fbbf24,#d97706);">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Licencia</div>
                <div class="adm-stat-num">{{ $profesores->getCollection()->where('estado','licencia')->count() }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#f87171,#dc2626);">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Inactivos</div>
                <div class="adm-stat-num">{{ $profesores->getCollection()->where('estado','inactivo')->count() }}</div>
            </div>
        </div>
    </div>

    {{-- ══ Toolbar ══ --}}
    <div class="adm-toolbar">
        <form action="{{ route('profesores.index') }}" method="GET" class="adm-search-wrap">
            <div class="search-inner">
                <i class="fas fa-search"></i>
                <input type="text" name="busqueda" value="{{ request('busqueda') }}"
                       placeholder="Buscar por nombre, DNI, email...">
            </div>
            <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
            @if(request('busqueda'))
                <a href="{{ route('profesores.index') }}" class="btn-clear">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>

        <div class="adm-perpage">
            <label>Mostrar:</label>
            <select onchange="cambiarPerPage(this.value)">
                @foreach([10,25,50] as $op)
                    <option value="{{ $op }}" {{ request('per_page',10)==$op?'selected':'' }}>
                        {{ $op }} por página
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ══ Resultado de búsqueda ══ --}}
    @if(request('busqueda'))
    <div class="search-result-bar">
        <i class="fas fa-filter"></i>
        @if($profesores->total() > 0)
            Mostrando <strong>{{ $profesores->total() }}</strong> resultado(s) para:
            <span class="q-badge">{{ request('busqueda') }}</span>
        @else
            <span style="color:#dc2626;">
                <i class="fas fa-exclamation-circle me-1"></i>
                Sin resultados para: <strong>"{{ request('busqueda') }}"</strong>
            </span>
        @endif
    </div>
    @endif

    {{-- ══ Tabla ══ --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <div class="adm-card-head-left">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Lista de Profesores</span>
            </div>
            @if($profesores->total() > 0)
                <span class="adm-card-head-info">{{ $profesores->total() }} registros</span>
            @endif
        </div>

        <div style="overflow-x:auto;">
            <table class="adm-tbl">
                <thead>
                    <tr>
                        <th class="tc">#</th>
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
                        <td class="tc">
                            <span class="adm-num">{{ $profesores->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:.65rem;">
                                <div class="adm-av">
                                    {{ strtoupper(substr($profesor->nombre,0,1).substr($profesor->apellido??'',0,1)) }}
                                </div>
                                <div>
                                    <div class="adm-name">{{ $profesor->nombre_completo }}</div>
                                    @if($profesor->email)
                                        <div class="adm-email">{{ $profesor->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="adm-email">
                            @if($profesor->dni)
                                <i class="fas fa-id-card" style="color:#94a3b8;font-size:.7rem;margin-right:.3rem;"></i>
                                {{ $profesor->dni }}
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>
                        <td class="tc">
                            @if($profesor->especialidad)
                                <span class="bpill b-blue">
                                    <i class="fas fa-book"></i> {{ $profesor->especialidad }}
                                </span>
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
                                <span class="bpill b-amber">
                                    <i class="fas fa-clock"></i> Licencia
                                </span>
                            @else
                                <span class="bpill b-red">
                                    <i class="fas fa-circle" style="font-size:.45rem;vertical-align:middle;"></i> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="tc">
                            <div style="display:inline-flex;gap:.4rem;align-items:center;">
                                <a href="{{ route('profesores.show', $profesor->id) }}"
                                   class="act-btn act-view" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('profesores.edit', $profesor->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="act-btn act-del"
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
                        <td colspan="7">
                            <div class="adm-empty">
                                <i class="fas fa-chalkboard-teacher"></i>
                                @if(request('busqueda'))
                                    <p>No se encontró ningún profesor con "{{ request('busqueda') }}"</p>
                                    <div class="empty-actions">
                                        <a href="{{ route('profesores.index') }}" class="adm-btn-outline">
                                            <i class="fas fa-list"></i> Ver todos
                                        </a>
                                        <a href="{{ route('profesores.create') }}" class="adm-btn-solid">
                                            <i class="fas fa-plus"></i> Crear nuevo
                                        </a>
                                    </div>
                                @else
                                    <p>No hay profesores registrados</p>
                                    <div class="empty-actions">
                                        <a href="{{ route('profesores.create') }}" class="adm-btn-solid">
                                            <i class="fas fa-plus"></i> Agregar primer profesor
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($profesores->hasPages())
        <div class="adm-footer">
            <span class="adm-pages">
                Mostrando {{ $profesores->firstItem() }}–{{ $profesores->lastItem() }}
                de {{ $profesores->total() }} registros
            </span>
            {{ $profesores->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ══ Modal eliminar ══ --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content" style="border-radius:14px;border:none;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,.15);">
            <div class="modal-header border-0" style="background:rgba(239,68,68,.07);padding:1.2rem 1.4rem;">
                <div style="display:flex;align-items:center;gap:.7rem;">
                    <div style="width:42px;height:42px;background:rgba(239,68,68,.15);border-radius:10px;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
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
                        style="padding:.4rem 1.1rem;border-radius:7px;border:none;background:#ef4444;color:#fff;font-size:.82rem;font-weight:600;cursor:pointer;box-shadow:0 2px 6px rgba(239,68,68,.3);">
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
