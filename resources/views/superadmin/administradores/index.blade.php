@extends('layouts.app')

@section('title', 'Administradores')
@section('page-title', 'Gestión de Administradores')

@section('topbar-actions')
<<<<<<< HEAD
    <a href="{{ route('superadmin.administradores.permisos') }}" class="adm-btn-outline">
        <i class="fas fa-shield-alt"></i> Permisos y Roles
    </a>
    <a href="{{ route('superadmin.administradores.create') }}" class="adm-btn-solid">
        <i class="fas fa-plus"></i> Nuevo Administrador
=======
    <a href="{{ route('superadmin.administradores.permisos') }}"
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem; margin-right: 0.5rem;">
        <i class="fas fa-shield-alt"></i>
        Permisos y Roles
    </a>
    <a href="{{ route('superadmin.administradores.create') }}"
       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo Administrador
>>>>>>> cesia-dev
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.adm-wrap { font-family: 'Inter', sans-serif; }

/* Topbar btns */
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
.adm-btn-solid:hover { opacity: .88; }

/* ── Stats ── */
.adm-stats {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
@media(max-width:640px){ .adm-stats { grid-template-columns: 1fr; } }

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

/* ── Card ── */
.adm-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.adm-card-head i { color: #4ec7d2; font-size: 1rem; }
.adm-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

/* ── Table ── */
.adm-tbl { width: 100%; border-collapse: collapse; }

.adm-tbl thead th {
    background: #f8fafc;
    padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0;
    white-space: nowrap;
}
.adm-tbl thead th.tc { text-align: center; }

.adm-tbl tbody td {
    padding: .65rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155;
    vertical-align: middle;
}
.adm-tbl tbody td.tc { text-align: center; }
.adm-tbl tbody tr:last-child td { border-bottom: none; }
.adm-tbl tbody tr:hover { background: #fafbfc; }

/* Avatar */
.adm-av {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .9rem;
}
.adm-name { font-weight: 600; color: #0f172a; font-size: .82rem; }
.adm-email { font-size: .75rem; color: #64748b; }

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

/* Action btns */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none;
    transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-edit   { background: #e8f8f9; color: #00508f; }
.act-edit:hover   { background: #4ec7d2; color: #fff; }
.act-del    { background: #fef2f2; color: #ef4444; }
.act-del:hover    { background: #ef4444; color: #fff; }

/* Empty */
.adm-empty { padding: 3.5rem 1rem; text-align: center; }
.adm-empty i { font-size: 2rem; color: #cbd5e1; margin-bottom: .75rem; display: block; }
.adm-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }
</style>
@endpush

@section('content')
<<<<<<< HEAD
<div class="adm-wrap">

    {{-- Stats --}}
    <div class="adm-stats">
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Total</div>
                <div class="adm-stat-num">{{ $administradores->count() }}</div>
=======
<div class="container-fluid">
    <!-- Estadísticas en Cards -->
    <div class="row g-4 mb-4">
        <!-- Total -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
                            <i class="fas fa-users" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1" style="color: #64748b; font-size: 0.875rem; font-weight: 600;">Total Administradores</p>
                            <h3 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1.875rem;">{{ $administradores->count() }}</h3>
                        </div>
                    </div>
                </div>
>>>>>>> cesia-dev
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#f87171,#dc2626);">
                <i class="fas fa-crown"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Super Admins</div>
                <div class="adm-stat-num">{{ $administradores->where('is_super_admin', true)->count() }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Administradores</div>
                <div class="adm-stat-num">{{ $administradores->where('is_super_admin', false)->count() }}</div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-user-shield"></i>
            <span>Lista de Administradores</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="adm-tbl">
                <thead>
                    <tr>
                        <th>Administrador</th>
                        <th>Email</th>
                        <th class="tc">Rol</th>
                        <th class="tc">Permisos</th>
                        <th class="tc">Estado</th>
                        <th class="tc">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($administradores as $admin)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:.65rem;">
                                <div class="adm-av">{{ substr($admin->name,0,1) }}</div>
                                <div>
                                    <div class="adm-name">{{ $admin->name }}</div>
                                    @if($admin->is_protected)
                                        <span class="bpill b-amber" style="margin-top:.2rem;">
                                            <i class="fas fa-lock"></i> Protegido
                                        </span>
                                    @endif
                                </div>
<<<<<<< HEAD
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
                            <span class="bpill b-green"><i class="fas fa-circle" style="font-size:.45rem;vertical-align:middle;"></i> Activo</span>
                        </td>

                        <td class="tc">
                            @if(!$admin->is_protected)
                                <div style="display:inline-flex;gap:.4rem;align-items:center;">
                                    <a href="{{ route('superadmin.administradores.edit', $admin->id) }}"
                                       class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="act-btn act-del"
=======
                            </td>
                            <td class="px-4 py-3" style="color: #64748b; font-size: 0.875rem;">
                                <i class="fas fa-envelope me-2" style="color: #4ec7d2;"></i>{{ $admin->email }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($admin->is_super_admin)
                                    <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);">
                                        <i class="fas fa-crown me-1"></i>Super Admin
                                    </span>
                                @else
                                    <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);">
                                        <i class="fas fa-user-shield me-1"></i>Administrador
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $permisosActivos = is_array($admin->permissions) ? count($admin->permissions) : 0;
                                @endphp
                                @if($admin->is_super_admin)
                                    <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);">
                                        <i class="fas fa-infinity me-1"></i>Todos
                                    </span>
                                @else
                                    <span class="badge" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);">
                                        <i class="fas fa-list-check me-1"></i>{{ $permisosActivos }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);">
                                    <i class="fas fa-check-circle me-1"></i>Activo
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if(!$admin->is_protected)
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('superadmin.administradores.edit', $admin->id) }}"
                                       class="btn btn-sm"
                                       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.5rem 0.875rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm"
                                            style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; padding: 0.5rem 0.875rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);"
>>>>>>> cesia-dev
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
                        <td colspan="6">
                            <div class="adm-empty">
                                <i class="fas fa-users"></i>
                                <p>No hay administradores registrados</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
<<<<<<< HEAD
@endsection
=======

@push('styles')
<style>
    .table tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.001);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    @media (max-width: 768px) {
        .table {
            font-size: 0.875rem;
        }
        .card-body {
            padding: 1rem !important;
        }
    }
</style>
@endpush
@endsection
>>>>>>> cesia-dev
