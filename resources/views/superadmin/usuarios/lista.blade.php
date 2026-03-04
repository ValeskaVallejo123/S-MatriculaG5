@extends('layouts.app')

@section('title', 'Lista de usuarios')
@section('page-title', 'Usuarios del Sistema')

@section('topbar-actions')
    <a href="{{ route('superadmin.dashboard') }}"
       style="background:white; color:#00508f;
              padding:.6rem .75rem; border-radius:9px; font-size:.83rem; font-weight:600;
              display:inline-flex; align-items:center; gap:.4rem;
              text-decoration:none; border:1.5px solid #00508f; transition:all .2s;">
        <i class="fas fa-arrow-left"></i> Volver al Dashboard
    </a>
@endsection

@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */

/* ── Tabla ── */
.tbl-wrap table {
    width: 100%;
    border-collapse: collapse;
}

.tbl-wrap thead th {
    font-size: .63rem;                            /* ← TAMAÑO encabezados tabla */
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #6b7a90;
    background: #f5f8fc;
    padding: .75rem 1rem;
    border-bottom: 2px solid #e8edf4;
    white-space: nowrap;
}

.tbl-wrap tbody td {
    font-size: .83rem;                            /* ← TAMAÑO celdas tabla */
    color: #0d2137;
    padding: .78rem 1rem;
    border-bottom: 1px solid #f0f4f9;
    vertical-align: middle;
}

.tbl-wrap tbody tr:last-child td { border-bottom: none; }

.tbl-wrap tbody tr:hover td {
    background: rgba(78,199,210,.04);
}

/* ── ID bold ── */
.tbl-id {
    font-weight: 700;
    font-size: .8rem;                             /* ← TAMAÑO columna ID */
    color: #00508f;
    font-family: 'Courier New', monospace;
}

/* ── Nombre ── */
.tbl-name {
    font-weight: 600;
    font-size: .85rem;                            /* ← TAMAÑO columna nombre */
    color: #0d2137;
}

/* ── Email ── */
.tbl-email {
    font-size: .8rem;                             /* ← TAMAÑO columna email */
    color: #6b7a90;
}

/* ── Badges rol ── */
.rol-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .68rem; font-weight: 700;          /* ← TAMAÑO badge rol */
    letter-spacing: .04em;
}

/* ── Badges estado ── */
.estado-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .68rem; font-weight: 700;          /* ← TAMAÑO badge estado */
}
.badge-activo    { background: #f0fdf4; color: #166534; border: 1.5px solid #86efac; }
.badge-pendiente { background: #fefce8; color: #854d0e; border: 1.5px solid #fde047; }

/* ── Fecha ── */
.tbl-fecha {
    font-size: .75rem;                            /* ← TAMAÑO columna fecha */
    color: #6b7a90;
}

/* ── Botón ver ── */
.btn-ver {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .65rem; border-radius: 7px;
    font-size: .72rem; font-weight: 700;          /* ← TAMAÑO botón ver */
    background: white; color: #00508f;
    border: 1.5px solid #00508f;
    text-decoration: none; transition: all .2s;
}
.btn-ver:hover {
    background: #eff6ff; color: #00508f;
    transform: translateY(-1px);
}

/* ── Alerta contraseña ── */
.alert-temp {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .9rem 1.1rem; border-radius: 10px;
    background: rgba(78,199,210,.08);
    border: 1px solid #b2e8ed; color: #003b73;
    font-size: .83rem;                            /* ← TAMAÑO alerta contraseña */
    margin-bottom: 1rem;
}

/* ── Alerta éxito / error ── */
.alert-ok  {
    padding: .9rem 1.1rem; border-radius: 10px;
    background: #f0fdf4; border: 1px solid #86efac;
    color: #166534; font-size: .83rem;            /* ← TAMAÑO alerta éxito */
    margin-bottom: 1rem;
}
.alert-err {
    padding: .9rem 1.1rem; border-radius: 10px;
    background: #fef2f2; border: 1px solid #fca5a5;
    color: #991b1b; font-size: .83rem;            /* ← TAMAÑO alerta error */
    margin-bottom: 1rem;
}

/* ── Footer paginación ── */
.tbl-footer {
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    padding: .85rem 1.7rem;
    background: #f5f8fc; border-top: 1px solid #e8edf4;
    border-radius: 0 0 14px 14px;
    font-size: .75rem; color: #6b7a90;            /* ← TAMAÑO texto paginación */
}

/* ── Empty state ── */
.tbl-empty {
    text-align: center; padding: 3rem 1rem;
    font-size: .83rem; color: #94a3b8;            /* ← TAMAÑO mensaje vacío */
}
.tbl-empty i { font-size: 2rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem 1.7rem; position:relative; overflow:hidden;">

        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;
                    justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <div style="display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
                <div style="width:80px;height:80px;              {{-- ← TAMAÑO ícono header --}}
                            border-radius:18px;
                            border:3px solid rgba(78,199,210,.7);
                            background:rgba(255,255,255,.12);
                            display:flex;align-items:center;justify-content:center;
                            box-shadow:0 6px 20px rgba(0,0,0,.25);">
                    <i class="fas fa-users" style="color:white;font-size:2rem;"></i>
                </div>
                <div>
                    <h2 style="font-size:1.45rem;font-weight:800;color:white; {{-- ← TÍTULO header --}}
                               margin:0 0 .4rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                        Usuarios del Sistema
                    </h2>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;
                                 padding:.2rem .65rem;border-radius:999px;
                                 background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                                 font-size:.72rem;font-weight:600; {{-- ← TEXTO tag subtítulo --}}
                                 border:1px solid rgba(255,255,255,.18);">
                        <i class="fas fa-list"></i> Listado de usuarios registrados
                    </span>
                </div>
            </div>
            {{-- Total badge --}}
            <span style="display:inline-flex;align-items:center;gap:.4rem;
                         padding:.35rem .9rem;border-radius:999px;
                         background:rgba(78,199,210,.2);color:white;
                         font-size:.78rem;font-weight:700; {{-- ← TAMAÑO badge total --}}
                         border:1px solid rgba(78,199,210,.4);
                         position:relative;z-index:1;">
                <i class="fas fa-user-check"></i> Total: {{ $usuarios->total() }}
            </span>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        {{-- Alertas --}}
        @if(session('password_temp'))
        <div style="padding:1rem 1.7rem 0;">
            <div class="alert-temp">
                <i class="fas fa-key" style="flex-shrink:0;margin-top:2px;"></i>
                <div>
                    <strong>Contraseña temporal generada:</strong>
                    <span style="color:#ef4444;font-weight:700;margin-left:.4rem;">
                        {{ session('password_temp') }}
                    </span>
                </div>
            </div>
        </div>
        @endif

        @if(session('success'))
        <div style="padding:1rem 1.7rem 0;">
            <div class="alert-ok">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div style="padding:1rem 1.7rem 0;">
            <div class="alert-err">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        </div>
        @endif

        {{-- Tabla --}}
        <div class="tbl-wrap" style="overflow-x:auto;">
            <table>
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
                    @forelse ($usuarios as $u)
                        <tr>
                            <td><span class="tbl-id">#{{ $u->id }}</span></td>

                            <td><span class="tbl-name">{{ $u->name }}</span></td>

                            <td><span class="tbl-email">{{ $u->email }}</span></td>

                            <td>
                                @php
                                    $coloresRol = [
                                        'super_admin'   => 'background:#1e293b;color:white;',
                                        'Administrador' => 'background:#475569;color:white;',
                                        'admin'         => 'background:#475569;color:white;',
                                        'Profesor'      => 'background:rgba(78,199,210,.15);color:#00508f;border:1.5px solid #b2e8ed;',
                                        'profesor'      => 'background:rgba(78,199,210,.15);color:#00508f;border:1.5px solid #b2e8ed;',
                                        'Estudiante'    => 'background:rgba(0,80,143,.1);color:#00508f;border:1.5px solid #bfd9ea;',
                                        'estudiante'    => 'background:rgba(0,80,143,.1);color:#00508f;border:1.5px solid #bfd9ea;',
                                        'Padre'         => 'background:#f0fdf4;color:#166534;border:1.5px solid #86efac;',
                                        'padre'         => 'background:#f0fdf4;color:#166534;border:1.5px solid #86efac;',
                                    ];
                                    $nombreRol = $u->rol->nombre ?? 'Sin rol';
                                    $estiloRol = $coloresRol[$nombreRol] ?? 'background:#f1f5f9;color:#475569;border:1.5px solid #e2e8f0;';
                                @endphp
                                <span class="rol-badge" style="{{ $estiloRol }}">
                                    {{ $nombreRol }}
                                </span>
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

                            <td>
                                <span class="tbl-fecha">
                                    {{ $u->created_at->format('d/m/Y') }}<br>
                                    <span style="font-size:.68rem;color:#94a3b8;">{{ $u->created_at->format('H:i') }}</span>
                                </span>
                            </td>

                            <td style="text-align:center;">
                                <a href="{{ route('superadmin.usuarios.show', $u->id) }}"
                                   class="btn-ver" title="Ver detalle">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="tbl-empty">
                                    <i class="fas fa-users-slash"></i>
                                    No hay usuarios registrados.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($usuarios->hasPages())
        <div class="tbl-footer">
            <span>
                Mostrando {{ $usuarios->firstItem() }}–{{ $usuarios->lastItem() }}
                de {{ $usuarios->total() }} usuarios
            </span>
            {{ $usuarios->links() }}
        </div>
        @endif

    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}
@endsection
