@extends('layouts.app')

@section('title', 'Administradores')
@section('page-title', 'Gestión de Administradores')

@section('topbar-actions')
    <a href="{{ route('superadmin.administradores.permisos') }}" class="adm-topbar-btn-outline">
        <i class="fas fa-shield-alt"></i>
        <span class="adm-btn-text">Permisos y Roles</span>
    </a>
    <a href="{{ route('superadmin.administradores.create') }}" class="adm-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="adm-btn-text">Nuevo Administrador</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botones topbar ── */
    .adm-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .adm-topbar-btn:hover { opacity: .88; color: white; }

    .adm-topbar-btn-outline {
        display: inline-flex; align-items: center; gap: .45rem;
        background: white; color: #00508f;
        border: 1.5px solid #4ec7d2;
        padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        white-space: nowrap; transition: background .15s;
    }
    .adm-topbar-btn-outline:hover { background: #e8f8f9; color: #00508f; }

    @media(max-width: 600px) {
        .adm-btn-text { display: none; }
        .adm-topbar-btn, .adm-topbar-btn-outline { padding: .5rem .65rem; }
    }

    /* ── Variables ── */
    :root {
        --blue-dark:   #003b73;
        --blue-mid:    #00508f;
        --teal:        #4ec7d2;
        --teal-light:  rgba(78,199,210,0.12);
        --border:      #e8edf4;
        --surface:     #f5f8fc;
        --text-main:   #0d2137;
        --text-muted:  #6b7a90;
        --green:       #10b981;
        --amber:       #f59e0b;
        --red:         #ef4444;
        --purple:      #8b5cf6;
        --radius-lg:   14px;
        --radius-md:   10px;
        --radius-sm:   7px;
        --shadow-sm:   0 1px 4px rgba(0,59,115,0.07);
        --shadow-md:   0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .adm-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media(max-width:768px){ .adm-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .adm-stats { grid-template-columns: 1fr; } }

    .adm-stat {
        background: white;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm);
        transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .adm-stat::before {
        content: '';
        position: absolute; top: 0; left: 0;
        width: 4px; height: 100%;
        border-radius: 4px 0 0 4px;
    }
    .adm-stat-total::before  { background: var(--teal); }
    .adm-stat-super::before  { background: var(--red); }
    .adm-stat-admins::before { background: var(--green); }
    .adm-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .adm-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .adm-stat-total  .adm-stat-icon { background: var(--teal-light); color: var(--teal); }
    .adm-stat-super  .adm-stat-icon { background: rgba(239,68,68,.12); color: var(--red); }
    .adm-stat-admins .adm-stat-icon { background: rgba(16,185,129,.12); color: var(--green); }

    .adm-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .adm-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .adm-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Toolbar ── */
    .adm-toolbar {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: .9rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .adm-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .adm-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; }
    .adm-search {
        width: 100%; padding: .5rem 1rem .5rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: .85rem; background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s;
        font-family: inherit; color: var(--text-main);
    }
    .adm-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

    .adm-badge-info { display: flex; align-items: center; gap: 1.25rem; flex-shrink: 0; }
    .adm-badge-info span { display: flex; align-items: center; gap: .4rem; font-size: .82rem; }

    .adm-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
    .adm-perpage label { white-space: nowrap; font-weight: 500; }
    .adm-perpage select {
        padding: .3rem .6rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
        font-size: .8rem; font-family: inherit; color: #0f172a;
        background: #f8fafc; outline: none; cursor: pointer; transition: border-color .2s;
    }
    .adm-perpage select:focus { border-color: #4ec7d2; }

    /* ── Tabla card ── */
    .adm-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .adm-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem;
        display: flex; align-items: center; gap: .6rem;
    }
    .adm-card-head i    { color: var(--teal); font-size: 1rem; }
    .adm-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    .adm-tbl { width: 100%; border-collapse: collapse; }
    .adm-tbl thead th {
        background: var(--surface); padding: .65rem 1rem;
        font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .adm-tbl thead th.tc { text-align: center; }
    .adm-tbl tbody td { padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: .84rem; color: var(--text-main); vertical-align: middle; }
    .adm-tbl tbody td.tc { text-align: center; }
    .adm-tbl tbody tr:last-child td { border-bottom: none; }
    .adm-tbl tbody tr { transition: background .15s; }
    .adm-tbl tbody tr:hover { background: #f7fbff; }
    .adm-tbl tbody tr.hidden { display: none; }

    .row-num {
        width: 26px; height: 26px; border-radius: 7px;
        background: var(--surface); border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .72rem; font-weight: 700; color: var(--text-muted);
    }

    .adm-av {
        width: 38px; height: 38px; border-radius: 10px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: inline-flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: .9rem; flex-shrink: 0;
        border: 2px solid rgba(78,199,210,.3);
    }
    .adm-name  { font-weight: 600; color: var(--blue-dark); font-size: .88rem; }
    .adm-email { font-size: .73rem; color: var(--text-muted); margin-top: .1rem; }

    .bpill {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .22rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600; white-space: nowrap;
    }
    .b-red    { background: rgba(220,38,38,.1);  color: #dc2626; border: 1px solid rgba(220,38,38,.25); }
    .b-blue   { background: var(--teal-light);   color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
    .b-green  { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.3); }
    .b-indigo { background: rgba(99,102,241,.1); color: #4f46e5; border: 1px solid rgba(99,102,241,.25); }
    .b-amber  { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }

    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid; font-size: .78rem;
        background: white; cursor: pointer;
        transition: all .15s; text-decoration: none;
    }
    .act-edit { border-color: var(--teal);  color: var(--teal); }
    .act-del  { border-color: var(--red);   color: var(--red); }
    .act-edit:hover { background: var(--teal); color: white; transform: translateY(-1px); }
    .act-del:hover  { background: var(--red);  color: white; transform: translateY(-1px); }

    .adm-empty { padding: 4rem 1rem; text-align: center; }
    .adm-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .adm-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .adm-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    .adm-footer {
        padding: .85rem 1.25rem;
        border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    }
    .adm-footer-info { font-size: .78rem; color: var(--text-muted); }

    .pagination { margin: 0; }
    .pagination .page-link {
        border-radius: 7px; margin: 0 2px;
        border: 1.5px solid var(--border);
        color: var(--blue-mid);
        padding: .28rem .6rem; font-size: .82rem; transition: all .15s;
    }
    .pagination .page-link:hover { background: var(--teal-light); border-color: var(--teal); color: var(--blue-dark); }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        border-color: var(--teal); color: white;
        box-shadow: 0 2px 6px rgba(78,199,210,.35);
    }

    .no-results-row td { padding: 2rem; text-align: center; color: #94a3b8; font-size: .83rem; }

    /* ── Badge búsqueda activa ── */
    .search-active-badge {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .2rem .6rem; border-radius: 999px;
        background: var(--teal-light); color: var(--blue-mid);
        font-size: .72rem; font-weight: 600;
    }
    .search-active-badge a { color: var(--red); text-decoration: none; margin-left: .2rem; }
    .search-active-badge a:hover { color: #dc2626; }

    /* ── Responsive ── */
    @media(max-width: 768px) {
        .adm-toolbar { flex-direction: column; align-items: stretch; gap: .75rem; }
        .adm-search-wrap { min-width: unset; }
        .adm-badge-info { justify-content: center; flex-wrap: wrap; gap: .75rem; }
        .adm-footer { flex-direction: column; align-items: center; text-align: center; gap: .75rem; }
    }
    @media(max-width: 480px) {
        .adm-stats { grid-template-columns: 1fr; }
        .adm-stat-num { font-size: 1.45rem; }
        .adm-stat-icon { width: 38px; height: 38px; font-size: .95rem; }
        .adm-name  { font-size: .82rem; }
        .adm-email { display: none; }
        .act-btn   { width: 26px; height: 26px; font-size: .72rem; }
    }
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="adm-stats">
        <div class="adm-stat adm-stat-total">
            <div class="adm-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="adm-stat-lbl">Total</div>
                <div class="adm-stat-num">{{ $administradores->total() }}</div>
                <div class="adm-stat-sub">Administradores</div>
            </div>
        </div>
        <div class="adm-stat adm-stat-super">
            <div class="adm-stat-icon"><i class="fas fa-crown"></i></div>
            <div>
                <div class="adm-stat-lbl">Super Admins</div>
                <div class="adm-stat-num">{{ $administradores->getCollection()->where('is_super_admin', true)->count() }}</div>
                <div class="adm-stat-sub">Con todos los permisos</div>
            </div>
        </div>
        <div class="adm-stat adm-stat-admins">
            <div class="adm-stat-icon"><i class="fas fa-user-shield"></i></div>
            <div>
                <div class="adm-stat-lbl">Administradores</div>
                <div class="adm-stat-num">{{ $administradores->getCollection()->where('is_super_admin', false)->count() }}</div>
                <div class="adm-stat-sub">Con permisos limitados</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <form method="GET" action="{{ route('superadmin.administradores.index') }}" id="searchForm">
        <div class="adm-toolbar">
            <div class="adm-search-wrap">
                <i class="fas fa-search"></i>
                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    class="adm-search"
                    placeholder="Buscar por nombre o email..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
            </div>
            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

            @if(request('search'))
                <span class="search-active-badge">
                    <i class="fas fa-filter"></i>
                    "{{ request('search') }}"
                    <a href="{{ route('superadmin.administradores.index', ['per_page' => request('per_page', 10)]) }}" title="Limpiar búsqueda">
                        <i class="fas fa-times-circle"></i>
                    </a>
                </span>
            @endif

            <div class="adm-badge-info">
                <span>
                    <i class="fas fa-users" style="color:var(--blue-mid);"></i>
                    <strong style="color:var(--blue-mid);">{{ $administradores->total() }}</strong>
                    <span style="color:var(--text-muted);">Total</span>
                </span>
            </div>

            <div class="adm-perpage">
                <label><i class="fas fa-list-ol" style="color:#4ec7d2;"></i> Mostrar:</label>
                <select onchange="cambiarPerPage(this.value)">
                    @foreach([10, 25, 50] as $op)
                        <option value="{{ $op }}" {{ request('per_page', 10) == $op ? 'selected' : '' }}>
                            {{ $op }} por página
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    {{-- ── TABLA ── --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-user-shield"></i>
            <span>Lista de Administradores</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="adm-tbl" id="adminsTable">
                <thead>
                    <tr>
                        <th class="tc" style="width:50px;">#</th>
                        <th>Administrador</th>
                        <th>Email</th>
                        <th class="tc">Rol</th>
                        <th class="tc">Permisos</th>
                        <th class="tc">Estado</th>
                        <th class="tc">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($administradores as $index => $admin)
                    <tr>
                        <td class="tc">
                            <span class="row-num">{{ $administradores->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:.65rem;">
                                <div class="adm-av">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
                                <div>
                                    <div class="adm-name">{{ $admin->name }}</div>
                                    @if($admin->is_protected)
                                        <span class="bpill b-amber" style="margin-top:.2rem;">
                                            <i class="fas fa-lock"></i> Protegido
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="adm-email">{{ $admin->email }}</td>
                        <td class="tc">
                            @if($admin->is_super_admin)
                                <span class="bpill b-red"><i class="fas fa-crown"></i> Super Admin</span>
                            @else
                                <span class="bpill b-blue"><i class="fas fa-user-shield"></i> Administrador</span>
                            @endif
                        </td>
                        <td class="tc">
                            @php $perms = is_array($admin->permissions) ? count($admin->permissions) : 0; @endphp
                            @if($admin->is_super_admin)
                                <span class="bpill b-green"><i class="fas fa-check-circle"></i> Todos</span>
                            @else
                                <span class="bpill b-indigo"><i class="fas fa-list"></i> {{ $perms }}</span>
                            @endif
                        </td>
                        <td class="tc">
                            <span class="bpill b-green">
                                <i class="fas fa-circle" style="font-size:.45rem;vertical-align:middle;"></i> Activo
                            </span>
                        </td>
                        <td class="tc">
                            @if(!$admin->is_protected)
                                <div style="display:inline-flex;gap:.35rem;align-items:center;">
                                    <a href="{{ route('superadmin.administradores.edit', $admin->id) }}"
                                       class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button"
                                            class="act-btn act-del"
                                            onclick="mostrarModalDeleteData(this)"
                                            data-route="{{ route('superadmin.administradores.destroy', $admin->id) }}"
                                            data-message="¿Estás seguro de eliminar a este administrador?"
                                            data-name="{{ $admin->name }}"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;font-weight:600;">
                                    <i class="fas fa-lock"></i> Protegido
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="adm-empty">
                                <i class="fas fa-user-shield"></i>
                                <h6>No hay administradores registrados</h6>
                                @if(request('search'))
                                    <p>Sin resultados para "<strong>{{ request('search') }}</strong>"</p>
                                @else
                                    <p>Comienza agregando el primer administrador al sistema</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Paginación ── --}}
        @if($administradores->hasPages() || $administradores->total() > 0)
        <div class="adm-footer">
            <span class="adm-footer-info">
                @if($administradores->total() > 0)
                    Mostrando {{ $administradores->firstItem() }}–{{ $administradores->lastItem() }}
                    de {{ $administradores->total() }} administradores
                    @if(request('search'))
                        · filtrado por "<strong>{{ request('search') }}</strong>"
                    @endif
                @else
                    Sin resultados
                @endif
            </span>
            {{ $administradores->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
function cambiarPerPage(valor) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', valor);
    url.searchParams.set('page', 1);
    @if(request('search'))
    url.searchParams.set('search', '{{ request('search') }}');
    @endif
    window.location.href = url.toString();
}

// Auto-submit al escribir con delay
const searchInput = document.getElementById('searchInput');
let searchTimer;
if (searchInput) {
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500);
    });
}
</script>
@endpush