@extends('layouts.app')

@section('title', 'Usuarios Pendientes')
@section('page-title', 'Usuarios Pendientes')

@section('topbar-actions')
    <a href="{{ url()->previous() }}"
       style="background:white; color:#00508f;
              padding:.6rem .75rem; border-radius:9px; font-size:.83rem; font-weight:600;
              display:inline-flex; align-items:center; gap:.4rem;
              text-decoration:none; border:1.5px solid #00508f; transition:all .2s;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */

/* ── Encabezados tabla ── */
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

/* ── Celdas tabla ── */
.tbl-wrap tbody td {
    font-size: .83rem;                            /* ← TAMAÑO celdas tabla */
    color: #0d2137;
    padding: .78rem 1rem;
    border-bottom: 1px solid #f0f4f9;
    vertical-align: middle;
}
.tbl-wrap tbody tr:last-child td { border-bottom: none; }
.tbl-wrap tbody tr:hover td { background: rgba(78,199,210,.04); }

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

/* ── Fecha ── */
.tbl-fecha {
    font-size: .75rem;                            /* ← TAMAÑO columna fecha */
    color: #6b7a90;
}

/* ── Badge rol ── */
.rol-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .68rem; font-weight: 700;          /* ← TAMAÑO badge rol */
    background: rgba(78,199,210,.15);
    color: #00508f; border: 1.5px solid #b2e8ed;
}

/* ── Botón Aprobar ── */
.btn-aprobar {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .65rem; border-radius: 7px;
    font-size: .72rem; font-weight: 700;          /* ← TAMAÑO botón aprobar */
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white; border: none;
    box-shadow: 0 1px 4px rgba(34,197,94,.25);
    transition: all .2s; cursor: pointer;
}
.btn-aprobar:hover {
    color: white; opacity: .9;
    transform: translateY(-1px);
}

/* ── Botón Rechazar ── */
.btn-rechazar {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .65rem; border-radius: 7px;
    font-size: .72rem; font-weight: 700;          /* ← TAMAÑO botón rechazar */
    background: white; color: #ef4444;
    border: 1.5px solid #ef4444;
    transition: all .2s; cursor: pointer;
}
.btn-rechazar:hover {
    background: #fef2f2; color: #ef4444;
    transform: translateY(-1px);
}

/* ── Alertas ── */
.alert-ok  {
    padding: .9rem 1.1rem; border-radius: 10px;
    background: #f0fdf4; border: 1px solid #86efac;
    color: #166534; font-size: .83rem;            /* ← TAMAÑO alerta éxito */
    margin-bottom: 1rem;
    display: flex; align-items: center; gap: .5rem;
}
.alert-err {
    padding: .9rem 1.1rem; border-radius: 10px;
    background: #fef2f2; border: 1px solid #fca5a5;
    color: #991b1b; font-size: .83rem;            /* ← TAMAÑO alerta error */
    margin-bottom: 1rem;
    display: flex; align-items: center; gap: .5rem;
}
.alert-temp {
    padding: .9rem 1.1rem; border-radius: 10px;
    background: rgba(78,199,210,.08); border: 1px solid #b2e8ed;
    color: #003b73; font-size: .83rem;            /* ← TAMAÑO alerta contraseña */
    margin-bottom: 1rem;
    display: flex; align-items: center; gap: .5rem;
}
.alert-info-custom {
    padding: .9rem 1.1rem; border-radius: 10px;
    background: #f5f8fc; border: 1px solid #bfd9ea;
    color: #00508f; font-size: .83rem;            /* ← TAMAÑO alerta info */
    display: flex; align-items: center; gap: .5rem;
}

/* ── Empty state ── */
.tbl-empty {
    text-align: center; padding: 3rem 1rem;
    font-size: .83rem; color: #94a3b8;            /* ← TAMAÑO mensaje vacío */
}
.tbl-empty i {
    font-size: 2.5rem; display: block;
    margin-bottom: .75rem; color: #bfd9ea;
}
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
                    <i class="fas fa-user-clock" style="color:white;font-size:2rem;"></i>
                </div>
                <div>
                    <h2 style="font-size:1.45rem;font-weight:800;color:white; {{-- ← TÍTULO header --}}
                               margin:0 0 .4rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                        Usuarios Pendientes
                    </h2>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;
                                 padding:.2rem .65rem;border-radius:999px;
                                 background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                                 font-size:.72rem;font-weight:600; {{-- ← TEXTO tag subtítulo --}}
                                 border:1px solid rgba(255,255,255,.18);">
                        <i class="fas fa-clock"></i> Cuentas que esperan aprobación
                    </span>
                </div>
            </div>

            {{-- Badge total --}}
            @if(!$usuariosPendientes->isEmpty())
            <span style="display:inline-flex;align-items:center;gap:.4rem;
                         padding:.35rem .9rem;border-radius:999px;
                         background:rgba(251,191,36,.25);color:white;
                         font-size:.78rem;font-weight:700; {{-- ← TAMAÑO badge total --}}
                         border:1px solid rgba(251,191,36,.45);
                         position:relative;z-index:1;">
                <i class="fas fa-user-clock"></i> Pendientes: {{ $usuariosPendientes->count() }}
            </span>
            @endif
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        {{-- Alertas --}}
        @if(session('success'))
        <div style="padding:1rem 1.7rem 0;">
            <div class="alert-ok">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div style="padding:1rem 1.7rem 0;">
            <div class="alert-err">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        </div>
        @endif

        @if(session('password_temp'))
        <div style="padding:1rem 1.7rem 0;">
            <div class="alert-temp">
                <i class="fas fa-key"></i>
                <div>
                    <strong>Contraseña temporal generada:</strong>
                    <span style="color:#ef4444;font-weight:700;margin-left:.4rem;">
                        {{ session('password_temp') }}
                    </span>
                </div>
            </div>
        </div>
        @endif

        {{-- ── Contenido ── --}}
        @if($usuariosPendientes->isEmpty())

            {{-- Empty state --}}
            <div style="padding:1.4rem 1.7rem;">
                <div class="alert-info-custom">
                    <i class="fas fa-check-circle" style="font-size:1.1rem;color:#4ec7d2;flex-shrink:0;"></i>
                    No hay usuarios pendientes por aprobar.
                </div>
            </div>

        @else

            {{-- ══════════════════════════════════════
                 SECCIÓN · TÍTULO TABLA
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem 0;">
                <div style="display:flex;align-items:center;gap:.5rem;
                            font-size:.75rem;font-weight:700;color:#00508f;
                            text-transform:uppercase;letter-spacing:.08em;
                            margin-bottom:.95rem;padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <i class="fas fa-user-clock" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Pendientes de Aprobación
                </div>
            </div>

            {{-- Tabla --}}
            <div class="tbl-wrap" style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Fecha Registro</th>
                            <th style="text-align:center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuariosPendientes as $u)
                        <tr>
                            <td><span class="tbl-name">{{ $u->name }}</span></td>

                            <td><span class="tbl-email">{{ $u->email }}</span></td>

                            <td>
                                <span class="rol-badge">
                                    {{ $u->rol->nombre ?? 'Sin rol' }}
                                </span>
                            </td>

                            <td>
                                <span class="tbl-fecha">
                                    {{ $u->created_at->format('d/m/Y') }}<br>
                                    <span style="font-size:.68rem;color:#94a3b8;">
                                        {{ $u->created_at->format('H:i') }}
                                    </span>
                                </span>
                            </td>

                            <td style="text-align:center;">
                                <div style="display:flex;gap:.5rem;justify-content:center;flex-wrap:wrap;">

                                    {{-- Aprobar --}}
                                    <form action="{{ route('superadmin.usuarios.aprobar', $u->id) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-aprobar">
                                            <i class="fas fa-check"></i> Aprobar
                                        </button>
                                    </form>

                                    {{-- Rechazar --}}
                                    <button type="button" class="btn-rechazar"
                                            onclick="mostrarModalDelete(
                                                '{{ route('superadmin.usuarios.rechazar', $u->id) }}',
                                                '¿Estás seguro de que deseas rechazar y eliminar este usuario? Esta acción no se puede deshacer.',
                                                '{{ $u->name }}'
                                            )">
                                        <i class="fas fa-times"></i> Rechazar
                                    </button>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

        {{-- Footer vacío para redondear --}}
        <div style="height:.1px;border-radius:0 0 14px 14px;"></div>

    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}
@endsection
