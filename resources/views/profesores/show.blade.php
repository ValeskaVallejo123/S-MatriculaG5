@extends('layouts.app')

@section('title', 'Detalle Profesor')
@section('page-title', 'Detalle del Profesor')

@section('topbar-actions')
    <a href="{{ route('profesores.edit', $profesor->id) }}"
       style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;padding:.5rem 1.2rem;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;gap:.5rem;border:none;box-shadow:0 2px 8px rgba(78,199,210,.3);font-size:.9rem;text-decoration:none;transition:all .2s;">
        <i class="fas fa-edit"></i> Editar Profesor
    </a>

    <form action="{{ route('profesores.destroy', $profesor->id) }}" method="POST" style="display:inline;"
          onsubmit="return confirm('¿Estás segura de eliminar a {{ $profesor->nombre }} {{ $profesor->apellido }}?')">
        @csrf @method('DELETE')
        <button type="submit"
                style="border:1.5px solid #fca5a5;color:#dc2626;background:#fef2f2;border-radius:8px;padding:.45rem 1rem;font-size:.88rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:.4rem;margin-left:.35rem;">
            <i class="fas fa-trash"></i> Eliminar
        </button>
    </form>

    <a href="{{ route('profesores.index') }}"
       style="border:1.5px solid #e2e8f0;color:#6b7280;background:white;border-radius:8px;padding:.45rem 1rem;font-size:.88rem;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;margin-left:.35rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    .prof-wrap { font-family: 'Inter', sans-serif; }

    /* Stats */
    .prof-stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.25rem; }
    @media(max-width:992px){ .prof-stats { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:576px){ .prof-stats { grid-template-columns: 1fr; } }

    .prof-stat {
        background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;
        padding: 1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }
    .prof-stat-icon { width: 44px; height: 44px; border-radius: 11px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; }
    .prof-stat-icon i { font-size: 1.1rem; color: #fff; }
    .prof-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: #94a3b8; margin-bottom: .1rem; }
    .prof-stat-val { font-size: 1rem; font-weight: 700; color: #0f172a; line-height: 1.2; }

    /* Info card */
    .prof-card {
        background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 1rem; overflow: hidden;
    }
    .prof-card-header {
        background: rgba(0,80,143,0.05); border-bottom: 2px solid #4ec7d2;
        padding: .85rem 1.5rem; display: flex; align-items: center; gap: .5rem;
    }
    .prof-card-header-title {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: #00508f;
    }
    .prof-card-body { padding: 1.25rem 1.5rem; }

    /* Info rows */
    .info-row {
        display: flex; align-items: flex-start; gap: .75rem;
        padding: .65rem 0; border-bottom: 1px solid #f1f5f9;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-icon { width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
        background: rgba(78,199,210,.1); display: flex; align-items: center;
        justify-content: center; }
    .info-icon i { font-size: .8rem; color: #00508f; }
    .info-label { font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: #94a3b8; margin-bottom: .15rem; }
    .info-value { font-size: .88rem; font-weight: 600; color: #0f172a; }

    /* Badges */
    .badge-activo   { background:rgba(16,185,129,.1);  color:#065f46; border:1px solid #6ee7b7; }
    .badge-inactivo { background:rgba(239,68,68,.1);   color:#991b1b; border:1px solid #fca5a5; }
    .badge-licencia { background:rgba(245,158,11,.1);  color:#b45309; border:1px solid #fcd34d; }
    .estado-badge {
        display: inline-flex; align-items: center; gap: .35rem;
        border-radius: 20px; padding: .3rem .85rem; font-size: .78rem; font-weight: 700;
    }

    .badge-contrato {
        display: inline-flex; align-items: center; gap: .3rem;
        background: rgba(78,199,210,.12); color: #00508f; border: 1px solid #4ec7d2;
        border-radius: 20px; padding: .2rem .65rem; font-size: .75rem; font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="prof-wrap container-fluid px-4">

    {{-- ══ Hero ════════════════════════════════════════════════ --}}
    <div style="background:linear-gradient(135deg,#003b73,#00508f);border-radius:12px;padding:1.25rem 1.75rem;margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;box-shadow:0 4px 14px rgba(0,59,115,.2);">
        <div style="display:flex;align-items:center;gap:1.1rem;">
            <div style="width:56px;height:56px;background:rgba(255,255,255,.1);border:2px solid #4ec7d2;border-radius:14px;display:flex;align-items:center;justify-content:center;font-weight:800;color:#4ec7d2;font-size:1.3rem;flex-shrink:0;">
                {{ strtoupper(substr($profesor->nombre,0,1)) }}
            </div>
            <div>
                <div style="font-weight:700;color:#fff;font-size:1.1rem;margin-bottom:.25rem;">
                    {{ $profesor->nombre }} {{ $profesor->apellido }}
                </div>
                <div style="font-size:.76rem;color:rgba(255,255,255,.6);display:flex;gap:1.25rem;flex-wrap:wrap;">
                    <span><i class="fas fa-chalkboard-teacher me-1"></i>{{ $profesor->especialidad }}</span>
                    @if($profesor->email)
                        <span><i class="fas fa-envelope me-1"></i>{{ $profesor->email }}</span>
                    @endif
                    @if($profesor->telefono)
                        <span><i class="fas fa-phone me-1"></i>{{ $profesor->telefono }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div>
            @php
                $estadoClass = match($profesor->estado) {
                    'activo'   => 'badge-activo',
                    'inactivo' => 'badge-inactivo',
                    'licencia' => 'badge-licencia',
                    default    => 'badge-inactivo',
                };
                $estadoIcon = match($profesor->estado) {
                    'activo'   => 'fa-check-circle',
                    'inactivo' => 'fa-times-circle',
                    'licencia' => 'fa-clock',
                    default    => 'fa-circle',
                };
            @endphp
            <span class="estado-badge {{ $estadoClass }}">
                <i class="fas {{ $estadoIcon }}"></i>
                {{ ucfirst($profesor->estado) }}
            </span>
        </div>
    </div>

    {{-- ══ Stats ═══════════════════════════════════════════════ --}}
    <div class="prof-stats">
        <div class="prof-stat">
            <div class="prof-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-id-card"></i>
            </div>
            <div>
                <div class="prof-stat-lbl">DNI</div>
                <div class="prof-stat-val">{{ $profesor->dni ?? '—' }}</div>
            </div>
        </div>
        <div class="prof-stat">
            <div class="prof-stat-icon" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <div class="prof-stat-lbl">Nivel Académico</div>
                <div class="prof-stat-val">{{ ucfirst($profesor->nivel_academico ?? '—') }}</div>
            </div>
        </div>
        <div class="prof-stat">
            <div class="prof-stat-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                <i class="fas fa-file-contract"></i>
            </div>
            <div>
                <div class="prof-stat-lbl">Tipo Contrato</div>
                <div class="prof-stat-val" style="font-size:.82rem;">
                    {{ str_replace('_', ' ', ucfirst($profesor->tipo_contrato ?? '—')) }}
                </div>
            </div>
        </div>
        <div class="prof-stat">
            <div class="prof-stat-icon" style="background:linear-gradient(135deg,#fbbf24,#f59e0b);">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
                <div class="prof-stat-lbl">Fecha Contratación</div>
                <div class="prof-stat-val" style="font-size:.85rem;">
                    {{ $profesor->fecha_contratacion ? \Carbon\Carbon::parse($profesor->fecha_contratacion)->format('d/m/Y') : '—' }}
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Información Personal --}}
        <div class="col-lg-6">
            <div class="prof-card">
                <div class="prof-card-header">
                    <i class="fas fa-user" style="color:#4ec7d2;font-size:.85rem;"></i>
                    <span class="prof-card-header-title">Información Personal</span>
                </div>
                <div class="prof-card-body">
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-user"></i></div>
                        <div>
                            <div class="info-label">Nombre completo</div>
                            <div class="info-value">{{ $profesor->nombre }} {{ $profesor->apellido }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-id-card"></i></div>
                        <div>
                            <div class="info-label">DNI / Identidad</div>
                            <div class="info-value">{{ $profesor->dni ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-venus-mars"></i></div>
                        <div>
                            <div class="info-label">Género</div>
                            <div class="info-value">{{ ucfirst($profesor->genero ?? '—') }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-birthday-cake"></i></div>
                        <div>
                            <div class="info-label">Fecha de Nacimiento</div>
                            <div class="info-value">
                                {{ $profesor->fecha_nacimiento ? \Carbon\Carbon::parse($profesor->fecha_nacimiento)->format('d/m/Y') : '—' }}
                            </div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div class="info-label">Dirección</div>
                            <div class="info-value">{{ $profesor->direccion ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Información Laboral --}}
        <div class="col-lg-6">
            <div class="prof-card">
                <div class="prof-card-header">
                    <i class="fas fa-briefcase" style="color:#4ec7d2;font-size:.85rem;"></i>
                    <span class="prof-card-header-title">Información Laboral</span>
                </div>
                <div class="prof-card-body">
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div class="info-label">Correo Electrónico</div>
                            <div class="info-value">{{ $profesor->email ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <div class="info-label">Teléfono</div>
                            <div class="info-value">{{ $profesor->telefono ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div>
                            <div class="info-label">Especialidad</div>
                            <div class="info-value">{{ $profesor->especialidad ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div>
                            <div class="info-label">Nivel Académico</div>
                            <div class="info-value">{{ ucfirst($profesor->nivel_academico ?? '—') }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-file-contract"></i></div>
                        <div>
                            <div class="info-label">Tipo de Contrato</div>
                            <div class="info-value">
                                <span class="badge-contrato">
                                    <i class="fas fa-circle" style="font-size:.45rem;"></i>
                                    {{ str_replace('_', ' ', ucfirst($profesor->tipo_contrato ?? '—')) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-calendar-check"></i></div>
                        <div>
                            <div class="info-label">Fecha de Contratación</div>
                            <div class="info-value">
                                {{ $profesor->fecha_contratacion ? \Carbon\Carbon::parse($profesor->fecha_contratacion)->format('d/m/Y') : '—' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Observaciones --}}
            @if($profesor->observaciones)
            <div class="prof-card">
                <div class="prof-card-header">
                    <i class="fas fa-sticky-note" style="color:#4ec7d2;font-size:.85rem;"></i>
                    <span class="prof-card-header-title">Observaciones</span>
                </div>
                <div class="prof-card-body">
                    <p style="font-size:.88rem;color:#475569;margin:0;line-height:1.6;">
                        {{ $profesor->observaciones }}
                    </p>
                </div>
            </div>
            @endif
        </div>

    </div>

</div>
@endsection