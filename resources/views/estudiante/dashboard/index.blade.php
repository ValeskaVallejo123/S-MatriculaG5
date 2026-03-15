@extends('layouts.app')

@section('title', 'Dashboard Estudiante')
@section('page-title', 'Mi Panel Estudiantil')

@push('styles')
    <style>
        /* Variables de color para cambio dinámico */
        :root {
            --bg-body: #f4f7f6;
            --bg-card: #ffffff;
            --text-main: #003b73;
            --text-muted: #6c757d;
            --border-color: #cbd5e1;
        }

        /* Estilos Modo Oscuro */
        body.dark-mode {
            --bg-body: #121212;
            --bg-card: #1e1e1e;
            --text-main: #4ec7d2;
            --text-muted: #a0a0a0;
            --border-color: #334155;
            background-color: var(--bg-body) !important;
            color: #e2e8f0;
        }

        body { background-color: var(--bg-body); transition: all 0.3s ease; }
        .card { background-color: var(--bg-card) !important; border-color: var(--border-color) !important; transition: all 0.3s ease; }

        .info-card { transition: all 0.3s ease; text-decoration: none !important; }
        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0,59,115,0.15) !important;
        }

        body.dark-mode .info-card h3, body.dark-mode .info-card p { color: var(--text-main) !important; }
        body.dark-mode .text-muted { color: var(--text-muted) !important; }

        .notif-item {
            border-left: 4px solid #4ec7d2;
            transition: background 0.2s ease;
            border-radius: 8px;
        }
        .notif-item.leida {
            border-left-color: var(--border-color);
            background: rgba(0,0,0,0.02) !important;
        }
        body.dark-mode .notif-item.leida { background: rgba(255,255,255,0.05) !important; }
        .notif-item:hover { background: rgba(78,199,210,0.05); }

        #darkModeToggle { transition: transform 0.2s ease; }
        #darkModeToggle:active { transform: scale(0.95); }
    </style>
@endpush

@section('content')
    @php
        $user = auth()->user();
        $estudiante = $user->estudiante;
        $noLeidas = $user->total_notificaciones_no_leidas ?? 0;
        $notificaciones = $user->notificacionesPermitidas()->take(5)->get();
    @endphp

    <div class="container-fluid px-4">

        {{-- Botón Switch Modo Oscuro --}}
        <div class="d-flex justify-content-end mb-3">
            <button id="darkModeToggle" class="btn shadow-sm fw-bold d-flex align-items-center gap-2"
                    style="border-radius: 50px; background: #003b73; color: white; padding: 8px 20px; border:none;">
                <i class="fas fa-moon"></i> <span id="modeText">Modo Oscuro</span>
            </button>
        </div>

        {{-- Bienvenida --}}
        <div class="card border-0 shadow-sm mb-4"
             style="border-radius:12px; background:linear-gradient(135deg,rgba(78,199,210,0.15) 0%,rgba(0,80,143,0.1) 100%);">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div style="width:70px;height:70px;background:#00508f;border-radius:16px;display:flex;align-items:center;justify-content:center;border:3px solid #4ec7d2;">
                            <i class="fas fa-user-graduate" style="font-size:2rem;color:white;"></i>
                        </div>
                    </div>

                    <div class="col">
                        <h2 class="mb-1 fw-bold" style="color:#003b73;font-size:1.5rem;">
                            Hola, {{ $user->name }}
                        </h2>
                        <p class="text-muted mb-0">Bienvenido a tu portal estudiantil</p>
                    </div>

                    <div class="col-12 col-md-auto d-flex gap-2 mt-3 mt-md-0">
                        <a href="{{ route('estudiante.historial') }}" class="btn fw-bold shadow-sm"
                           style="background:#4ec7d2; color:#003b73; border: 1px solid #4ec7d2; padding: 10px 20px;">
                            <i class="fas fa-history me-1"></i>Historial Académico
                        </a>

                        <a href="{{ route('estado-solicitud') }}" class="btn fw-bold shadow-sm"
                           style="background:#00508f; color:white; padding: 10px 20px;">
                            <i class="fas fa-question-circle me-1"></i>Estado de Solicitud
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjetas resumen --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <a href="{{ route('estudiante.miHorario') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 info-card" style="border-left:4px solid #003b73 !important;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div style="width:50px;height:50px;background:rgba(0,59,115,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-calendar-alt fa-lg" style="color:#003b73;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 small">Mi Horario</p>
                                <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $totalHoras ?? '—' }}</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('estudiante.calificaciones') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 info-card" style="border-left:4px solid #00508f !important;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div style="width:50px;height:50px;background:rgba(0,80,143,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-clipboard-check fa-lg" style="color:#00508f;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 small">Calificaciones</p>
                                <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $totalCalificaciones ?? '—' }}</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('estado-solicitud') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 info-card" style="border-left:4px solid #4ec7d2 !important;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div style="width:50px;height:50px;background:rgba(78,199,210,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-file-signature fa-lg" style="color:#4ec7d2;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 small">Mi Matrícula</p>
                                <h3 class="mb-0 fw-bold" style="color:#003b73;">Estado</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('notificaciones.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 info-card" style="border-left:4px solid #f59e0b !important;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div style="width:50px;height:50px;background:rgba(245,158,11,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-bell fa-lg" style="color:#f59e0b;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 small">Notificaciones</p>
                                <h3 class="mb-0 fw-bold" style="color:#003b73;">
                                    {{ $noLeidas }}
                                    @if($noLeidas > 0)
                                        <span class="badge bg-danger ms-1" style="font-size:0.65rem;">Sin leer</span>
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                    <div class="card-header border-0 py-3 px-4"
                         style="background:linear-gradient(135deg,#00508f 0%,#4ec7d2 100%);border-radius:12px 12px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="text-white fw-bold mb-0"><i class="fas fa-bell me-2"></i>Notificaciones Recientes</h5>
                            <a href="{{ route('notificaciones.index') }}" class="btn btn-light btn-sm fw-semibold">Ver todas</a>
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
                                        <h6 class="fw-semibold mb-1" style="color:#003b73;">{{ $notif->titulo }}</h6>
                                        <p class="text-muted mb-1" style="font-size:0.82rem;">{{ $notif->mensaje }}</p>
                                        <small class="text-muted" style="font-size:0.75rem;"><i class="fas fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}</small>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                    <div class="card-header border-0 py-3 px-4"
                         style="background:linear-gradient(135deg,#003b73 0%,#00508f 100%);border-radius:12px 12px 0 0;">
                        <h5 class="text-white fw-bold mb-0"><i class="fas fa-rocket me-2"></i>Accesos Rápidos</h5>
                    </div>
                    <div class="card-body p-3 d-flex flex-column gap-2">
                        <a href="{{ route('estudiante.miHorario') }}" class="btn text-start fw-semibold" style="background:rgba(0,80,143,0.08);color:#003b73;border:1px solid #00508f;border-radius:8px;">
                            <i class="fas fa-calendar-alt me-2"></i>Mi Horario de Clases
                        </a>
                        <a href="{{ route('estudiante.calificaciones') }}" class="btn text-start fw-semibold" style="background:rgba(78,199,210,0.08);color:#003b73;border:1px solid #4ec7d2;border-radius:8px;">
                            <i class="fas fa-clipboard-check me-2"></i>Mis Calificaciones
                        </a>
                        <a href="{{ route('cambiarcontrasenia.edit') }}" class="btn text-start fw-semibold" style="background:rgba(0,59,115,0.06);color:#003b73;border:1px solid #003b73;border-radius:8px;">
                            <i class="fas fa-key me-2"></i>Cambiar Contraseña
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('darkModeToggle');
            if(!btn) return;

            const modeText = document.getElementById('modeText');
            const icon = btn.querySelector('i');
            const body = document.body;

            const enableDarkMode = () => {
                body.classList.add('dark-mode');
                if(icon) icon.classList.replace('fa-moon', 'fa-sun');
                if(modeText) modeText.innerText = "Modo Claro";
                btn.style.background = "#ffc107";
                btn.style.color = "#000";
                localStorage.setItem('theme', 'dark');
            };

            const disableDarkMode = () => {
                body.classList.remove('dark-mode');
                if(icon) icon.classList.replace('fa-sun', 'fa-moon');
                if(modeText) modeText.innerText = "Modo Oscuro";
                btn.style.background = "#003b73";
                btn.style.color = "#fff";
                localStorage.setItem('theme', 'light');
            };

            if (localStorage.getItem('theme') === 'dark') enableDarkMode();

            btn.addEventListener('click', () => {
                body.classList.contains('dark-mode') ? disableDarkMode() : enableDarkMode();
            });
        });
    </script>
@endsection
