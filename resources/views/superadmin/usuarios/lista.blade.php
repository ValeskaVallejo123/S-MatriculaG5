@extends('layouts.app')

@section('title', 'Usuarios del Sistema')
@section('page-title', 'Usuarios del Sistema')
@section('content-class', 'p-0')

@push('styles')
<style>
.usr-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.usr-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.usr-hero-left { display: flex; align-items: center; gap: 1rem; }
.usr-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.usr-hero-icon i { font-size: 1.3rem; color: white; }
.usr-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.usr-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.usr-stat {
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 70px;
}
.usr-stat-num { font-size: 1.1rem; font-weight: 700; color: white; line-height: 1; }
.usr-stat-lbl { font-size: .65rem; color: rgba(255,255,255,.7); margin-top: .1rem; }

/* Tabs bar */
.usr-tabs {
    background: white; border-bottom: 1px solid #e2e8f0;
    padding: .6rem 1.5rem; display: flex; gap: .4rem;
    flex-wrap: wrap; flex-shrink: 0;
}
.usr-tab {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .35rem .8rem; border-radius: 999px;
    font-size: .75rem; font-weight: 700; text-decoration: none; transition: all .2s;
    border: 1.5px solid #bfd9ea; color: #00508f; background: white;
}
.usr-tab:hover { background: #eff6ff; color: #00508f; }
.usr-tab.active {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border-color: transparent;
    box-shadow: 0 2px 8px rgba(0,80,143,.25);
}
.usr-tab-count {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 1.3rem; height: 1.3rem; border-radius: 999px; font-size: .65rem;
}
.usr-tab.active .usr-tab-count { background: rgba(255,255,255,.25); color: white; }
.usr-tab:not(.active) .usr-tab-count { background: #e8edf4; color: #00508f; }

/* Body */
.usr-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }

/* Table card */
.usr-table-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08); overflow: hidden;
}
.usr-tbl thead th {
    background: #003b73; color: white; font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; padding: .75rem 1rem; border: none;
}
.usr-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.usr-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.usr-tbl tbody td { padding: .72rem 1rem; vertical-align: middle; font-size: .84rem; color: #334155; }
.usr-tbl tbody tr:last-child { border-bottom: none; }

.rol-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700;
}
.estado-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700;
}
.badge-activo    { background: #f0fdf4; color: #166534; border: 1.5px solid #86efac; }
.badge-pendiente { background: #fefce8; color: #854d0e; border: 1.5px solid #fde047; }

.btn-ver {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .65rem; border-radius: 7px; font-size: .75rem; font-weight: 700;
    background: white; color: #00508f; border: 1.5px solid #00508f;
    text-decoration: none; transition: all .2s;
}
.btn-ver:hover { background: #eff6ff; color: #00508f; }

/* Alerts */
.alert-temp {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .9rem 1.1rem; border-radius: 10px;
    background: rgba(78,199,210,.08); border: 1px solid #b2e8ed;
    color: #003b73; font-size: .83rem; margin-bottom: 1rem;
}

/* Footer paginación */
.usr-footer {
    padding: .7rem 1rem; display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    border-top: 1px solid #f1f5f9; background: white;
}
.pagination { margin: 0; }
.pagination .page-link { border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0; color: #00508f; font-size: .8rem; padding: .3rem .65rem; }
.pagination .page-link:hover { background: #bfd9ea; border-color: #4ec7d2; }
.pagination .page-item.active .page-link { background: linear-gradient(135deg,#4ec7d2,#00508f); border-color: #4ec7d2; color: white; }

/* Dark mode */
body.dark-mode .usr-wrap  { background: #0f172a; }
body.dark-mode .usr-tabs  { background: #1e293b; border-color: #334155; }
body.dark-mode .usr-tab:not(.active) { background: #0f172a; border-color: #334155; color: #94a3b8; }
body.dark-mode .usr-table-card { background: #1e293b; }
body.dark-mode .usr-tbl tbody td { color: #cbd5e1; }
body.dark-mode .usr-tbl tbody tr { border-color: #334155; }
body.dark-mode .usr-footer { background: #1e293b; border-color: #334155; }
</style>
@endpush

@section('content')
@php
    $tabs = [
        ''           => ['label' => 'Todos',           'icon' => 'fa-users',             'count' => $conteos['total']],
        'admin'      => ['label' => 'Administradores', 'icon' => 'fa-user-shield',        'count' => $conteos['admin']],
        'profesor'   => ['label' => 'Profesores',      'icon' => 'fa-chalkboard-teacher', 'count' => $conteos['profesor']],
        'Estudiante' => ['label' => 'Estudiantes',     'icon' => 'fa-user-graduate',      'count' => $conteos['Estudiante']],
        'Padre'      => ['label' => 'Padres',          'icon' => 'fa-user-friends',       'count' => $conteos['Padre']],
    ];
    $labelMap = ['admin'=>'administradores','profesor'=>'profesores','Estudiante'=>'estudiantes','Padre'=>'padres'];
@endphp
<div class="usr-wrap">

    {{-- Hero --}}
    <div class="usr-hero">
        <div class="usr-hero-left">
            <div class="usr-hero-icon"><i class="fas fa-users"></i></div>
            <div>
                <h2 class="usr-hero-title">Usuarios del Sistema</h2>
                <p class="usr-hero-sub">Listado de todos los usuarios registrados</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            @foreach(['total'=>'Total','admin'=>'Admins','profesor'=>'Profes','Estudiante'=>'Estudts','Padre'=>'Padres'] as $key => $lbl)
                <div class="usr-stat">
                    <div class="usr-stat-num">{{ $conteos[$key] }}</div>
                    <div class="usr-stat-lbl">{{ $lbl }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tabs --}}
    <div class="usr-tabs">
        @foreach($tabs as $valor => $tab)
            @php
                $activo = ($rolFiltro ?? '') === $valor;
                $url    = $valor === ''
                    ? route('superadmin.usuarios.index')
                    : route('superadmin.usuarios.index', ['rol' => $valor]);
            @endphp
            <a href="{{ $url }}" class="usr-tab {{ $activo ? 'active' : '' }}">
                <i class="fas {{ $tab['icon'] }}" style="font-size:.7rem;"></i>
                {{ $tab['label'] }}
                <span class="usr-tab-count">{{ $tab['count'] }}</span>
            </a>
        @endforeach
    </div>

    {{-- Body --}}
    <div class="usr-body">

        {{-- Alertas --}}
        @if(session('password_temp'))
            <div class="alert-temp">
                <i class="fas fa-key" style="flex-shrink:0;margin-top:2px;"></i>
                <div>
                    <strong>Contraseña temporal generada:</strong>
                    <span style="color:#ef4444;font-weight:700;margin-left:.4rem;">
                        {{ session('password_temp') }}
                    </span>
                </div>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #ef4444 !important;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="usr-table-card">
            @if($usuarios->isEmpty())
                <div style="text-align:center;padding:3.5rem 1rem;color:#94a3b8;">
                    <i class="fas fa-users-slash fa-2x" style="display:block;margin-bottom:.75rem;color:#bfd9ea;"></i>
                    <p style="font-size:.9rem;font-weight:600;color:#003b73;margin:0;">No hay usuarios registrados.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table usr-tbl mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Creado</th>
                                <th style="text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $u)
                            @php
                                $coloresRol = [
                                    'Super Administrador' => 'background:#1e293b;color:white;',
                                    'super_admin'         => 'background:#1e293b;color:white;',
                                    'Administrador'       => 'background:#475569;color:white;',
                                    'admin'               => 'background:#475569;color:white;',
                                    'Maestro'             => 'background:rgba(78,199,210,.15);color:#00508f;border:1.5px solid #b2e8ed;',
                                    'Profesor'            => 'background:rgba(78,199,210,.15);color:#00508f;border:1.5px solid #b2e8ed;',
                                    'profesor'            => 'background:rgba(78,199,210,.15);color:#00508f;border:1.5px solid #b2e8ed;',
                                    'Estudiante'          => 'background:rgba(0,80,143,.1);color:#00508f;border:1.5px solid #bfd9ea;',
                                    'Padre'               => 'background:#f0fdf4;color:#166534;border:1.5px solid #86efac;',
                                ];
                                $nombreRol = $u->rol->nombre ?? 'Sin rol';
                                $estiloRol = $coloresRol[$nombreRol] ?? 'background:#f1f5f9;color:#475569;border:1.5px solid #e2e8f0;';
                            @endphp
                            <tr>
                                <td style="font-family:monospace;font-size:.8rem;color:#00508f;font-weight:700;">#{{ $u->id }}</td>
                                <td style="font-weight:700;color:#003b73;">{{ $u->name }}</td>
                                <td style="color:#64748b;">{{ $u->email }}</td>
                                <td>
                                    <span class="rol-badge" style="{{ $estiloRol }}">{{ $nombreRol }}</span>
                                </td>
                                <td>
                                    @if($u->activo)
                                        <span class="estado-badge badge-activo">
                                            <i class="fas fa-circle" style="font-size:.45rem;"></i> Activo
                                        </span>
                                    @else
                                        <span class="estado-badge badge-pendiente">
                                            <i class="fas fa-circle" style="font-size:.45rem;"></i> Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td style="color:#64748b;font-size:.8rem;">
                                    {{ $u->created_at->format('d/m/Y') }}<br>
                                    <span style="font-size:.7rem;color:#94a3b8;">{{ $u->created_at->format('H:i') }}</span>
                                </td>
                                <td style="text-align:center;">
                                    <a href="{{ route('superadmin.usuarios.show', $u->id) }}"
                                       class="btn-ver" title="Ver detalle">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($usuarios->hasPages())
                    <div class="usr-footer">
                        <small style="color:#94a3b8;">
                            Mostrando {{ $usuarios->firstItem() }}–{{ $usuarios->lastItem() }}
                            de {{ $usuarios->total() }}
                            {{ $rolFiltro ? ($labelMap[$rolFiltro] ?? strtolower($rolFiltro).'s') : 'usuarios' }}
                        </small>
                        {{ $usuarios->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>{{-- /usr-body --}}
</div>
@endsection
