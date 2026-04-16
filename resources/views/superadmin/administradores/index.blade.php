@extends('layouts.app')

@section('title', 'Administradores')
@section('page-title', 'Gestión de Administradores')
@section('content-class', 'p-0')

@push('styles')
<style>
.adm-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.adm-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.adm-hero-left { display: flex; align-items: center; gap: 1rem; }
.adm-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.adm-hero-icon i { font-size: 1.3rem; color: white; }
.adm-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.adm-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.adm-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 80px;
}
.adm-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.adm-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.adm-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.adm-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }
.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    background: rgba(255,255,255,.15); color: white;
    border: 1px solid rgba(255,255,255,.4);
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 600; text-decoration: none; flex-shrink: 0; transition: all .2s;
}
.adm-btn-outline:hover { background: rgba(255,255,255,.25); color: white; }

/* Toolbar */
.adm-toolbar {
    padding: .9rem 2rem;
    background: white;
    border-bottom: 1px solid #e8eef5;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 1rem;
}
.adm-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
.adm-perpage select {
    padding: .35rem .65rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .8rem; background: #f8fafc; outline: none; cursor: pointer;
}
.adm-perpage select:focus { border-color: #4ec7d2; }

/* Scrollable body */
.adm-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Table card */
.adm-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.adm-tbl thead th {
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
.adm-tbl thead th.tc { text-align: center; }
.adm-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.adm-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.adm-tbl tbody td { padding: .7rem 1rem; vertical-align: middle; font-size: .82rem; color: #334155; }
.adm-tbl tbody td.tc { text-align: center; }
.adm-tbl tbody tr:last-child { border-bottom: none; }

/* Avatar */
.adm-av {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .9rem;
}

/* Badges */
.bpill {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
}
.b-red    { background: #fef2f2; color: #dc2626; }
.b-blue   { background: #e8f8f9; color: #00508f; }
.b-green  { background: #ecfdf5; color: #059669; }
.b-indigo { background: #eef2ff; color: #4f46e5; }
.b-amber  { background: #fffbeb; color: #92400e; }

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
.adm-pag {
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
body.dark-mode .adm-wrap  { background: #0f172a; }
body.dark-mode .adm-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .adm-perpage select { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .adm-table-card { background: #1e293b; }
body.dark-mode .adm-tbl tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .adm-tbl tbody td { color: #cbd5e1; }
body.dark-mode .adm-tbl tbody tr { border-color: #334155; }
body.dark-mode .adm-pag { border-color: #334155; }
</style>
@endpush

@section('content')
<div class="adm-wrap">

    {{-- Hero --}}
    <div class="adm-hero">
        <div class="adm-hero-left">
            <div class="adm-hero-icon"><i class="fas fa-user-shield"></i></div>
            <div>
                <h2 class="adm-hero-title">Gestión de Administradores</h2>
                <p class="adm-hero-sub">Administra los usuarios con acceso al panel de control</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="adm-stat">
                <div class="adm-stat-num">{{ $administradores->total() }}</div>
                <div class="adm-stat-lbl">Total</div>
            </div>
            <div class="adm-stat">
                <div class="adm-stat-num">{{ $administradores->getCollection()->where('is_super_admin', true)->count() }}</div>
                <div class="adm-stat-lbl">Super Admins</div>
            </div>
            <a href="{{ route('superadmin.administradores.permisos') }}" class="adm-btn-outline">
                <i class="fas fa-shield-alt"></i> Permisos y Roles
            </a>
            <a href="{{ route('superadmin.administradores.create') }}" class="adm-btn-new">
                <i class="fas fa-plus"></i> Nuevo Administrador
            </a>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="adm-toolbar">
        <div class="adm-perpage">
            <label>Mostrar:</label>
            <select onchange="cambiarPerPage(this.value)">
                @foreach([10, 25, 50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 10) == $op ? 'selected' : '' }}>
                        {{ $op }} por página
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Body --}}
    <div class="adm-body">

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
        <div class="adm-table-card">
            <div class="table-responsive">
                <table class="table adm-tbl mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
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
                            <td>
                                <span style="width:28px;height:28px;border-radius:6px;background:#f1f5f9;color:#64748b;
                                            display:inline-flex;align-items:center;justify-content:center;
                                            font-size:.75rem;font-weight:700;">
                                    {{ $administradores->firstItem() + $index }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="adm-av">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="fw-semibold" style="color:#003b73;font-size:.88rem;">{{ $admin->name }}</div>
                                        @if($admin->is_protected)
                                            <span class="bpill b-amber" style="margin-top:.2rem;">
                                                <i class="fas fa-lock"></i> Protegido
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:.8rem;color:#64748b;">{{ $admin->email }}</td>
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
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('superadmin.administradores.edit', $admin->id) }}"
                                           class="act-btn act-edit" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="act-btn act-del"
                                                data-route="{{ route('superadmin.administradores.destroy', $admin->id) }}"
                                                data-message="¿Estás seguro de eliminar a este administrador?"
                                                data-name="{{ $admin->name }}"
                                                onclick="mostrarModalDeleteData(this)"
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
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                                <div class="fw-semibold" style="color:#003b73;">No hay administradores registrados</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($administradores->hasPages())
            <div class="adm-pag">
                <small class="text-muted">
                    {{ $administradores->firstItem() }} – {{ $administradores->lastItem() }} de {{ $administradores->total() }} registros
                </small>
                {{ $administradores->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>{{-- /adm-body --}}
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
