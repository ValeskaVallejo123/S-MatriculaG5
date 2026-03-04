@extends('layouts.app')

@section('title', 'Detalles del Usuario')
@section('page-title', 'Detalles del Usuario')

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

/* ── Labels de campo ── */
.info-label {
    font-size: .63rem;                            /* ← TAMAÑO labels */
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #94a3b8;
    margin-bottom: .22rem;
    display: flex; align-items: center; gap: .28rem;
}
.info-label i { color: #4ec7d2; font-size: .68rem; }

/* ── Valores de campo ── */
.info-value {
    font-size: .88rem;                            /* ← TAMAÑO valores */
    font-weight: 600;
    color: #0d2137;
    padding-left: 1rem;
    line-height: 1.4;
}
.info-value.mono {
    font-family: 'Courier New', monospace;
    font-size: .83rem;                            /* ← TAMAÑO valor mono (ID) */
    color: #00508f;
    background: rgba(0,80,143,.07);
    padding: .15rem .45rem;
    border-radius: 5px;
    display: inline-block;
}

/* ── Info items ── */
.info-item {
    padding-bottom: .85rem;
    margin-bottom: .85rem;
    border-bottom: 1px solid #f0f4f9;
}
.info-item:last-child { padding-bottom: 0; margin-bottom: 0; border-bottom: none; }

/* ── Badges rol ── */
.rol-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 700;           /* ← TAMAÑO badge rol */
    background: rgba(78,199,210,.15);
    color: #00508f; border: 1.5px solid #b2e8ed;
}

/* ── Badges estado ── */
.estado-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 700;           /* ← TAMAÑO badge estado */
}
.badge-activo    { background: #f0fdf4; color: #166534; border: 1.5px solid #86efac; }
.badge-pendiente { background: #fefce8; color: #854d0e; border: 1.5px solid #fde047; }

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

/* ── Botón Aprobar ── */
.btn-aprobar {
    display: inline-flex; align-items: center; gap: .4rem;
    flex: 1; min-width: 140px; justify-content: center;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white; border: none;
    border-radius: 9px;                           /* ← REDONDEZ botón aprobar */
    padding: .6rem .75rem;                       /* ← TAMAÑO botón aprobar */
    font-size: .83rem; font-weight: 600;          /* ← TEXTO botón aprobar */
    box-shadow: 0 2px 10px rgba(34,197,94,.25);
    transition: all .2s; cursor: pointer;
}
.btn-aprobar:hover {
    color: white; transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(34,197,94,.35);
}

/* ── Botón Eliminar ── */
.btn-eliminar {
    display: inline-flex; align-items: center; gap: .4rem;
    flex: 1; min-width: 140px; justify-content: center;
    background: white; color: #ef4444;
    border: 1.5px solid #ef4444;                 /* ← GROSOR borde eliminar */
    border-radius: 9px;                           /* ← REDONDEZ botón eliminar */
    padding: .6rem .75rem;                       /* ← TAMAÑO botón eliminar */
    font-size: .83rem; font-weight: 600;          /* ← TEXTO botón eliminar */
    transition: all .2s; cursor: pointer;
}
.btn-eliminar:hover {
    background: #fef2f2; color: #ef4444;
    transform: translateY(-2px);
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

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px;height:80px;              {{-- ← TAMAÑO ícono header --}}
                        border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-user-circle" style="color:white;font-size:2rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white; {{-- ← TÍTULO header --}}
                           margin:0 0 .4rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    {{ $usuario->name }}
                </h2>
                <span style="display:inline-flex;align-items:center;gap:.3rem;
                             padding:.2rem .65rem;border-radius:999px;
                             background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                             font-size:.72rem;font-weight:600; {{-- ← TEXTO tag subtítulo --}}
                             border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-id-badge"></i> Detalles del usuario
                </span>
            </div>
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

        {{-- ══════════════════════════════════════
             SECCIÓN · INFORMACIÓN DEL USUARIO
        ══════════════════════════════════════ --}}
        <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

            <div style="display:flex;align-items:center;gap:.5rem;
                        font-size:.75rem;font-weight:700;color:#00508f;
                        text-transform:uppercase;letter-spacing:.08em;
                        margin-bottom:.95rem;padding-bottom:.55rem;
                        border-bottom:2px solid rgba(78,199,210,.1);">
                <i class="fas fa-user" style="color:#4ec7d2;font-size:.88rem;"></i>
                Información del Usuario
            </div>

            <div class="row g-0">

                {{-- Columna izquierda --}}
                <div class="col-md-6" style="padding-right:1.5rem;">

                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-hashtag"></i> ID del Usuario</div>
                        <div class="info-value">
                            <span class="mono">{{ $usuario->id }}</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-user"></i> Nombre Completo</div>
                        <div class="info-value">{{ $usuario->name }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-envelope"></i> Correo Electrónico</div>
                        <div class="info-value">{{ $usuario->email }}</div>
                    </div>

                </div>

                {{-- Columna derecha --}}
                <div class="col-md-6" style="padding-left:1.5rem;
                            border-left:1px solid #f0f4f9;">

                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-id-badge"></i> Rol Asignado</div>
                        <div class="info-value">
                            <span class="rol-badge">
                                {{ $usuario->rol->nombre ?? 'Sin rol asignado' }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-toggle-on"></i> Estado</div>
                        <div class="info-value">
                            @if($usuario->activo)
                                <span class="estado-badge badge-activo">
                                    <i class="fas fa-circle" style="font-size:.45rem;"></i> Activo
                                </span>
                            @else
                                <span class="estado-badge badge-pendiente">
                                    <i class="fas fa-circle" style="font-size:.45rem;"></i> Pendiente
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-calendar-plus"></i> Fecha de Creación</div>
                        <div class="info-value">{{ $usuario->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-calendar-check"></i> Última Actualización</div>
                        <div class="info-value">{{ $usuario->updated_at->format('d/m/Y H:i') }}</div>
                    </div>

                </div>
            </div>
        </div>{{-- fin sección info --}}

        {{-- ══════════════════════════════════════
             BOTONES DE ACCIÓN
        ══════════════════════════════════════ --}}
        <div style="display:flex;gap:.6rem;flex-wrap:wrap;
                    padding:1.1rem 1.7rem;
                    background:#f5f8fc;border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;">

            @if(!$usuario->activo)
                <form action="{{ route('superadmin.usuarios.aprobar', $usuario->id) }}"
                      method="POST" style="flex:1;min-width:140px;">
                    @csrf
                    <button type="submit" class="btn-aprobar" style="width:100%;">
                        <i class="fas fa-check"></i> Aprobar Usuario
                    </button>
                </form>
            @endif

            <button type="button" class="btn-eliminar"
                    onclick="mostrarModalDelete(
                        '{{ route('superadmin.usuarios.rechazar', $usuario->id) }}',
                        '¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.',
                        '{{ $usuario->name }}'
                    )">
                <i class="fas fa-trash"></i> Eliminar Usuario
            </button>

        </div>

    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}
@endsection
