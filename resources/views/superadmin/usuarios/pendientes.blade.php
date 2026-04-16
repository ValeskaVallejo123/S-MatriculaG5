@extends('layouts.app')

@section('title', 'Usuarios Pendientes')
@section('page-title', 'Usuarios Pendientes')
@section('content-class', 'p-0')

@push('styles')
<style>
.usp-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}
.usp-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.usp-hero-left { display: flex; align-items: center; gap: 1rem; }
.usp-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.usp-hero-icon i { font-size: 1.3rem; color: white; }
.usp-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.usp-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.usp-stat {
    background: rgba(251,191,36,.25); border: 1px solid rgba(251,191,36,.45);
    border-radius: 10px; padding: .45rem 1rem; text-align: center; min-width: 80px;
}
.usp-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.usp-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.8); margin-top: .15rem; }

.usp-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

.usp-table-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08); overflow: hidden;
}
.usp-tbl thead th {
    background: #003b73; color: white; font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; padding: .75rem 1rem; border: none;
}
.usp-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.usp-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.usp-tbl tbody td { padding: .75rem 1rem; vertical-align: middle; font-size: .85rem; color: #334155; }
.usp-tbl tbody tr:last-child { border-bottom: none; }

.rol-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700;
    background: rgba(78,199,210,.15); color: #00508f; border: 1.5px solid #b2e8ed;
}
.btn-aprobar {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .65rem; border-radius: 7px; font-size: .75rem; font-weight: 700;
    background: linear-gradient(135deg, #22c55e, #16a34a); color: white; border: none;
    cursor: pointer; transition: opacity .2s;
}
.btn-aprobar:hover { opacity: .88; color: white; }
.btn-rechazar {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .65rem; border-radius: 7px; font-size: .75rem; font-weight: 700;
    background: white; color: #ef4444; border: 1.5px solid #ef4444; cursor: pointer; transition: all .2s;
}
.btn-rechazar:hover { background: #fef2f2; }

.alert-temp {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .9rem 1.1rem; border-radius: 10px;
    background: rgba(78,199,210,.08); border: 1px solid #b2e8ed;
    color: #003b73; font-size: .83rem; margin-bottom: 1rem;
}

body.dark-mode .usp-wrap  { background: #0f172a; }
body.dark-mode .usp-table-card { background: #1e293b; }
body.dark-mode .usp-tbl tbody td { color: #cbd5e1; }
body.dark-mode .usp-tbl tbody tr { border-color: #334155; }
</style>
@endpush

@section('content')
<div class="usp-wrap">

    <div class="usp-hero">
        <div class="usp-hero-left">
            <div class="usp-hero-icon"><i class="fas fa-user-clock"></i></div>
            <div>
                <h2 class="usp-hero-title">Usuarios Pendientes</h2>
                <p class="usp-hero-sub">Cuentas que esperan aprobación para acceder al sistema</p>
            </div>
        </div>
        @if(!$usuariosPendientes->isEmpty())
            <div class="usp-stat">
                <div class="usp-stat-num">{{ $usuariosPendientes->count() }}</div>
                <div class="usp-stat-lbl">Pendientes</div>
            </div>
        @endif
    </div>

    <div class="usp-body">

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

        <div class="usp-table-card">
            @if($usuariosPendientes->isEmpty())
                <div style="text-align:center;padding:3.5rem 1rem;color:#94a3b8;">
                    <i class="fas fa-check-circle fa-2x" style="display:block;margin-bottom:.75rem;color:#86efac;"></i>
                    <p style="font-size:.9rem;font-weight:600;color:#166534;margin:0;">
                        No hay usuarios pendientes por aprobar.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table usp-tbl mb-0">
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
                            @foreach($usuariosPendientes as $u)
                            <tr>
                                <td style="font-weight:700;color:#003b73;">{{ $u->name }}</td>
                                <td style="color:#64748b;">{{ $u->email }}</td>
                                <td><span class="rol-badge">{{ $u->rol->nombre ?? 'Sin rol' }}</span></td>
                                <td style="color:#64748b;font-size:.82rem;">
                                    {{ $u->created_at->format('d/m/Y') }}<br>
                                    <span style="font-size:.7rem;color:#94a3b8;">{{ $u->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;justify-content:center;gap:.5rem;">
                                        <form action="{{ route('superadmin.usuarios.aprobar', $u->id) }}"
                                              method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn-aprobar">
                                                <i class="fas fa-check"></i> Aprobar
                                            </button>
                                        </form>
                                        <button type="button" class="btn-rechazar"
                                                onclick="mostrarModalDelete(
                                                    '{{ route('superadmin.usuarios.rechazar', $u->id) }}',
                                                    '¿Rechazar y eliminar este usuario? Esta acción no se puede deshacer.',
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
        </div>

    </div>{{-- /usp-body --}}
</div>
@endsection
