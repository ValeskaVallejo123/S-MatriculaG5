@extends('layouts.app')

@section('title', 'Dashboard Estudiante')
@section('page-title', 'Mi Panel Estudiantil')

@push('styles')
<style>
    .info-card { transition: all 0.3s ease; }
    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,59,115,0.12) !important;
    }
    .notif-item {
        border-left: 4px solid #4ec7d2;
        transition: background 0.2s ease;
        border-radius: 8px;
    }
    .notif-item.leida {
        border-left-color: #cbd5e1;
        background: #f8fafc !important;
    }
    .notif-item:hover { background: rgba(78,199,210,0.05); }
</style>
@endpush

@section('content')
@php
    $user       = auth()->user();
    $estudiante = $user->estudiante;
    // Usa el accessor getTotalNotificacionesNoLeidasAttribute()
    $noLeidas   = $user->total_notificaciones_no_leidas;
    // Usa notificacionesPermitidas() que ya tienes en el modelo
    $notificaciones = $user->notificacionesPermitidas()->take(5)->get();
@endphp

<div class="container" style="max-width: 1200px;">

    {{-- Bienvenida --}}
    <div class="card border-0 shadow-sm mb-4"
         style="border-radius:12px;background:linear-gradient(135deg,rgba(78,199,210,0.15) 0%,rgba(0,80,143,0.1) 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-auto">
                    <div style="width:70px;height:70px;background:linear-gradient(135deg,#00508f 0%,#003b73 100%);border-radius:16px;display:flex;align-items:center;justify-content:center;border:3px solid #4ec7d2;">
                        <i class="fas fa-user-graduate" style="font-size:2rem;color:white;"></i>
                    </div>
                </div>

                <div class="col">
                    <h2 class="mb-1 fw-bold" style="color:#003b73;font-size:1.5rem;">
                        Hola, {{ $user->name }}
                    </h2>
                    <p class="text-muted mb-2">Bienvenido a tu portal estudiantil</p>

                    @if($estudiante)
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge" style="background:rgba(78,199,210,0.2);color:#00508f;border:1px solid #4ec7d2;font-size:0.8rem;">
                                <i class="fas fa-graduation-cap me-1"></i>{{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                            </span>
                            <span class="badge" style="background:rgba(0,59,115,0.1);color:#003b73;border:1px solid #00508f;font-size:0.8rem;">
                                <i class="fas fa-id-card me-1"></i>DNI: {{ $estudiante->dni }}
                            </span>
                            <span class="badge" style="background:rgba(16,185,129,0.1);color:#059669;border:1px solid #10b981;font-size:0.8rem;">
                                <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>{{ ucfirst($estudiante->estado) }}
                            </span>
                        </div>
                    @else
                        <span class="badge bg-warning text-dark" style="font-size:0.8rem;">
                            <i class="fas fa-exclamation-triangle me-1"></i>Sin perfil de estudiante vinculado
                        </span>
                    @endif
                </div>

                <div class="col-auto">
                    <a href="{{ route('estado-solicitud') }}" class="btn btn-sm fw-semibold"
                       style="background:#00508f;color:white;border-radius:8px;">
                        <i class="fas fa-question-circle me-1"></i>Estado de Solicitud
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Tarjetas resumen --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 info-card"
                 style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fas fa-book fa-2x" style="color:#4ec7d2;"></i>
                    <div>
                        <p class="text-muted mb-0 small">Mis Materias</p>
                        <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $totalMaterias ?? '—' }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 info-card"
                 style="border-radius:10px;border-left:4px solid #00508f !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fas fa-clipboard-check fa-2x" style="color:#00508f;"></i>
                    <div>
                        <p class="text-muted mb-0 small">Calificaciones</p>
                        <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $totalCalificaciones ?? '—' }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 info-card"
                 style="border-radius:10px;border-left:4px solid #003b73 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fas fa-calendar-alt fa-2x" style="color:#003b73;"></i>
                    <div>
                        <p class="text-muted mb-0 small">Horario</p>
                        <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $totalHoras ?? '—' }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 info-card"
                 style="border-radius:10px;border-left:4px solid #f59e0b !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fas fa-bell fa-2x" style="color:#f59e0b;"></i>
                    <div>
                        <p class="text-muted mb-0 small">Sin leer</p>
                        {{-- Usa el accessor: total_notificaciones_no_leidas --}}
                        <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $noLeidas }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- Notificaciones recientes --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                <div class="card-header border-0 py-3 px-4"
                     style="background:linear-gradient(135deg,#00508f 0%,#4ec7d2 100%);border-radius:12px 12px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fas fa-bell me-2"></i>Notificaciones Recientes
                        </h5>
                        <a href="{{ route('notificaciones.index') }}" class="btn btn-light btn-sm fw-semibold">
                            Ver todas
                        </a>
                    </div>
                </div>

                <div class="card-body p-3">
                    @if($notificaciones->isEmpty())
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-bell-slash fa-2x mb-2" style="color:#cbd5e1;"></i>
                            <p class="mb-0 small">No tienes notificaciones nuevas.</p>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-2">
                            @foreach($notificaciones as $notif)
                                <div class="notif-item p-3 {{ $notif->leida ? 'leida' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div class="flex-grow-1">

                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                {{-- Ícono según el campo 'tipo' de la tabla notificaciones --}}
                                                @switch($notif->tipo)
                                                    @case('calificacion')
                                                        <i class="fas fa-star" style="color:#f59e0b;font-size:0.85rem;"></i>
                                                        @break
                                                    @case('horario')
                                                        <i class="fas fa-calendar-alt" style="color:#4ec7d2;font-size:0.85rem;"></i>
                                                        @break
                                                    @case('observacion')
                                                        <i class="fas fa-comment-alt" style="color:#6366f1;font-size:0.85rem;"></i>
                                                        @break
                                                    @case('matricula')
                                                        <i class="fas fa-file-signature" style="color:#00508f;font-size:0.85rem;"></i>
                                                        @break
                                                    @default
                                                        <i class="fas fa-info-circle" style="color:#4ec7d2;font-size:0.85rem;"></i>
                                                @endswitch

                                                <span class="fw-semibold" style="color:#003b73;font-size:0.9rem;">
                                                    {{ $notif->titulo }}
                                                </span>

                                                @if(!$notif->leida)
                                                    <span class="badge" style="background:rgba(78,199,210,0.2);color:#00508f;font-size:0.65rem;">
                                                        Nueva
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="text-muted mb-1" style="font-size:0.82rem;">
                                                {{ $notif->mensaje }}
                                            </p>

                                            <small class="text-muted" style="font-size:0.75rem;">
                                                <i class="fas fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
                                            </small>
                                        </div>

                                        @if(!$notif->leida)
                                            <form action="{{ route('notificaciones.marcarLeida', $notif->id) }}"
                                                  method="POST" class="flex-shrink-0">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-outline-primary btn-sm"
                                                        style="font-size:0.75rem;padding:0.2rem 0.5rem;"
                                                        title="Marcar como leída">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Accesos rápidos --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                <div class="card-header border-0 py-3 px-4"
                     style="background:linear-gradient(135deg,#003b73 0%,#00508f 100%);border-radius:12px 12px 0 0;">
                    <h5 class="text-white fw-bold mb-0">
                        <i class="fas fa-rocket me-2"></i>Accesos Rápidos
                    </h5>
                </div>
                <div class="card-body p-3 d-flex flex-column gap-2">

                    <a href="{{ route('estado-solicitud') }}"
                       class="btn text-start fw-semibold"
                       style="background:rgba(78,199,210,0.08);color:#003b73;border:1px solid #4ec7d2;border-radius:8px;">
                        <i class="fas fa-file-signature me-2" style="color:#4ec7d2;"></i>Estado de mi Matrícula
                    </a>

                    <a href="{{ route('notificaciones.index') }}"
                       class="btn text-start fw-semibold"
                       style="background:rgba(245,158,11,0.08);color:#003b73;border:1px solid #f59e0b;border-radius:8px;">
                        <i class="fas fa-bell me-2" style="color:#f59e0b;"></i>
                        Todas mis Notificaciones
                        @if($noLeidas > 0)
                            <span class="badge bg-danger ms-1">{{ $noLeidas }}</span>
                        @endif
                    </a>

                    <a href="{{ route('notificaciones.preferencias') }}"
                       class="btn text-start fw-semibold"
                       style="background:rgba(0,80,143,0.08);color:#003b73;border:1px solid #00508f;border-radius:8px;">
                        <i class="fas fa-sliders-h me-2" style="color:#00508f;"></i>Preferencias de Notificación
                    </a>

                    <a href="{{ route('cambiarcontrasenia.edit') }}"
                       class="btn text-start fw-semibold"
                       style="background:rgba(0,59,115,0.06);color:#003b73;border:1px solid #003b73;border-radius:8px;">
                        <i class="fas fa-key me-2" style="color:#003b73;"></i>Cambiar Contraseña
                    </a>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
