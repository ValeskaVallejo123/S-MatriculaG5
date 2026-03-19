@extends('layouts.app')

@section('title', 'Detalle del Padre/Tutor')

@section('page-title', 'Información del Padre/Tutor')

@section('topbar-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('padres.edit', $padre->id) }}" class="pd-btn-edit">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="{{ route('padres.index') }}" class="pd-btn-back">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@endsection

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .pd-wrap { font-family: 'Inter', sans-serif; }

    /* Botones topbar */
    .pd-btn-edit {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white; padding: 0.5rem 1.2rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: 0.9rem;
        display: inline-flex; align-items: center; gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(251,191,36,0.3); transition: all 0.3s;
    }
    .pd-btn-edit:hover { transform: translateY(-2px); box-shadow: 0 4px 14px rgba(251,191,36,0.45); color: white; }

    .pd-btn-back {
        background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: 0.9rem;
        display: inline-flex; align-items: center; gap: 0.5rem;
        border: 2px solid #4ec7d2; box-shadow: 0 2px 8px rgba(78,199,210,0.2); transition: all 0.3s;
    }
    .pd-btn-back:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(78,199,210,0.4); color: #00508f; }

    /* Banner hero */
    .pd-hero {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 60%, #003b73 100%);
        border-radius: 14px; padding: 2rem 2.5rem; margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 1.5rem;
        box-shadow: 0 6px 24px rgba(0,59,115,0.18);
    }
    .pd-hero-avatar {
        width: 72px; height: 72px; border-radius: 50%;
        background: rgba(255,255,255,0.18); display: flex;
        align-items: center; justify-content: center;
        border: 3px solid rgba(255,255,255,0.4); flex-shrink: 0;
    }
    .pd-hero-avatar i { font-size: 2rem; color: white; }
    .pd-hero-name { font-size: 1.6rem; font-weight: 700; color: white; margin: 0 0 0.25rem; line-height: 1.2; }
    .pd-hero-sub { color: rgba(255,255,255,0.8); font-size: 0.9rem; margin: 0; display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
    .pd-hero-badge {
        display: inline-flex; align-items: center; gap: 0.35rem;
        background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.35);
        color: white; border-radius: 20px; padding: 0.3rem 0.85rem; font-size: 0.8rem; font-weight: 600;
    }
    .pd-hero-badge.activo  { background: rgba(16,185,129,0.3); border-color: rgba(16,185,129,0.6); }
    .pd-hero-badge.inactivo{ background: rgba(239,68,68,0.3);  border-color: rgba(239,68,68,0.6); }

    /* Cards */
    .pd-card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,59,115,0.09); margin-bottom: 1.25rem; overflow: hidden; }
    .pd-card-head {
        background: #003b73; padding: 1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .pd-card-head h5 { color: white; font-weight: 700; font-size: 0.95rem; margin: 0; display: flex; align-items: center; gap: 0.6rem; }
    .pd-card-head h5 i { color: #4ec7d2; font-size: 1rem; }
    .pd-card-head .pd-count {
        background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);
        color: white; border-radius: 20px; padding: 0.25rem 0.8rem; font-size: 0.8rem; font-weight: 600;
    }
    .pd-card-body { background: white; padding: 1.5rem; }

    /* Campo label + valor */
    .pd-field { margin-bottom: 1.1rem; }
    .pd-label {
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.6px; color: #6b7280; margin-bottom: 0.3rem; display: block;
    }
    .pd-value { color: #003b73; font-size: 0.95rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem; }
    .pd-value i { color: #4ec7d2; font-size: 0.9rem; flex-shrink: 0; }
    .pd-value a { color: #00508f; text-decoration: none; font-weight: 500; }
    .pd-value a:hover { text-decoration: underline; }
    .pd-value.empty { color: #9ca3af; font-style: italic; font-size: 0.88rem; }

    /* Badges */
    .pd-badge-parentesco {
        background: rgba(78,199,210,0.12); color: #00508f;
        border: 1px solid #4ec7d2; border-radius: 20px;
        padding: 0.35rem 0.85rem; font-size: 0.82rem; font-weight: 600; display: inline-block;
    }
    .pd-badge-activo   { background: rgba(16,185,129,0.1); color: #065f46; border: 1px solid #6ee7b7; border-radius: 20px; padding: 0.35rem 0.85rem; font-size: 0.82rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.35rem; }
    .pd-badge-inactivo { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 20px; padding: 0.35rem 0.85rem; font-size: 0.82rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.35rem; }
    .pd-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
    .pd-dot.green { background: #10b981; }
    .pd-dot.red   { background: #ef4444; }

    /* Observaciones */
    .pd-obs-box {
        background: rgba(78,199,210,0.07); border: 1px solid rgba(78,199,210,0.35);
        border-radius: 10px; padding: 1rem 1.25rem; color: #003b73; font-size: 0.92rem; line-height: 1.6;
    }

    /* Tabla estudiantes */
    .pd-table thead tr { background: #f1f8ff; }
    .pd-table thead th {
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.4px; color: #003b73; padding: 0.75rem 1rem; border: none;
    }
    .pd-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
    .pd-table tbody tr:hover { background: rgba(78,199,210,0.06); }
    .pd-table tbody td { padding: 0.75rem 1rem; vertical-align: middle; border: none; }
    .pd-student-name { color: #003b73; font-weight: 600; font-size: 0.9rem; }
    .pd-badge-grado {
        background: rgba(78,199,210,0.12); color: #00508f;
        border: 1px solid #4ec7d2; border-radius: 8px;
        padding: 0.25rem 0.6rem; font-size: 0.75rem; font-weight: 600;
    }
    .pd-btn-ver {
        border: 1.5px solid #00508f; color: #00508f; background: white;
        border-radius: 7px; padding: 0.3rem 0.65rem; font-size: 0.8rem;
        text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.3rem;
    }
    .pd-btn-ver:hover { background: #00508f; color: white; }

    /* Empty state */
    .pd-empty { text-align: center; padding: 3rem 1rem; }
    .pd-empty i { color: #c3d9ee; font-size: 3rem; margin-bottom: 1rem; display: block; }
    .pd-empty p { color: #6b7280; font-size: 0.9rem; margin: 0; }
</style>
@endpush

@section('content')
<div class="pd-wrap container-fluid px-4">

    {{-- ── Banner Hero ── --}}
    <div class="pd-hero">
        <div class="pd-hero-avatar">
            <i class="fas fa-user-tie"></i>
        </div>
        <div>
            <h2 class="pd-hero-name">{{ $padre->nombre }} {{ $padre->apellido }}</h2>
            <p class="pd-hero-sub">
                <span class="pd-hero-badge">
                    <i class="fas fa-users"></i>
                    {{ ucfirst(str_replace('_', ' ', $padre->parentesco)) }}
                    @if($padre->parentesco === 'otro' && $padre->parentesco_otro)
                        — {{ $padre->parentesco_otro }}
                    @endif
                </span>
                @if($padre->estado)
                    <span class="pd-hero-badge activo"><i class="fas fa-circle" style="font-size:0.5rem;"></i> Activo</span>
                @else
                    <span class="pd-hero-badge inactivo"><i class="fas fa-circle" style="font-size:0.5rem;"></i> Inactivo</span>
                @endif
                @if($padre->dni)
                    <span style="color:rgba(255,255,255,0.7); font-size:0.85rem;">
                        <i class="fas fa-id-card me-1"></i>{{ $padre->dni }}
                    </span>
                @endif
            </p>
        </div>
    </div>

    {{-- ── Fila superior: Datos Personales + Contacto ── --}}
    <div class="row g-3 mb-0">

        {{-- Datos Personales --}}
        <div class="col-lg-6">
            <div class="pd-card h-100">
                <div class="pd-card-head">
                    <h5><i class="fas fa-id-card"></i> Datos Personales</h5>
                </div>
                <div class="pd-card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="pd-field">
                                <span class="pd-label">Nombre</span>
                                <div class="pd-value"><i class="fas fa-user"></i> {{ $padre->nombre }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-field">
                                <span class="pd-label">Apellido</span>
                                <div class="pd-value"><i class="fas fa-user"></i> {{ $padre->apellido }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-field">
                                <span class="pd-label">DNI / Identidad</span>
                                @if($padre->dni)
                                    <div class="pd-value"><i class="fas fa-id-card"></i> <span class="font-monospace">{{ $padre->dni }}</span></div>
                                @else
                                    <div class="pd-value empty">No registrado</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-field">
                                <span class="pd-label">Parentesco</span>
                                <div>
                                    <span class="pd-badge-parentesco">
                                        <i class="fas fa-people-arrows me-1" style="color:#4ec7d2;"></i>
                                        {{ ucfirst(str_replace('_', ' ', $padre->parentesco)) }}
                                    </span>
                                    @if($padre->parentesco === 'otro' && $padre->parentesco_otro)
                                        <div class="text-muted small mt-1">{{ $padre->parentesco_otro }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-field">
                                <span class="pd-label">Estado</span>
                                <div>
                                    @if($padre->estado)
                                        <span class="pd-badge-activo"><span class="pd-dot green"></span> Activo</span>
                                    @else
                                        <span class="pd-badge-inactivo"><span class="pd-dot red"></span> Inactivo</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-field">
                                <span class="pd-label">Registro / Actualización</span>
                                <div class="pd-value" style="font-size:0.85rem; flex-direction: column; align-items: flex-start; gap: 0.1rem;">
                                    <span><i class="fas fa-calendar-plus" style="color:#4ec7d2;"></i> {{ $padre->created_at ? \Carbon\Carbon::parse($padre->created_at)->format('d/m/Y H:i') : '—' }}</span>
                                    <span><i class="fas fa-calendar-check" style="color:#4ec7d2;"></i> {{ $padre->updated_at ? \Carbon\Carbon::parse($padre->updated_at)->format('d/m/Y H:i') : '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Datos de Contacto --}}
        <div class="col-lg-6">
            <div class="pd-card h-100">
                <div class="pd-card-head">
                    <h5><i class="fas fa-phone"></i> Datos de Contacto</h5>
                </div>
                <div class="pd-card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="pd-field">
                                <span class="pd-label">Correo Electrónico</span>
                                @if($padre->correo)
                                    <div class="pd-value"><i class="fas fa-envelope"></i><a href="mailto:{{ $padre->correo }}">{{ $padre->correo }}</a></div>
                                @else
                                    <div class="pd-value empty">No registrado</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-field">
                                <span class="pd-label">Teléfono Principal</span>
                                @if($padre->telefono)
                                    <div class="pd-value"><i class="fas fa-phone"></i><a href="tel:{{ $padre->telefono }}">{{ $padre->telefono }}</a></div>
                                @else
                                    <div class="pd-value empty">No registrado</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pd-field">
                                <span class="pd-label">Teléfono Secundario</span>
                                @if($padre->telefono_secundario)
                                    <div class="pd-value"><i class="fas fa-mobile-alt"></i><a href="tel:{{ $padre->telefono_secundario }}">{{ $padre->telefono_secundario }}</a></div>
                                @else
                                    <div class="pd-value empty">No registrado</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="pd-field mb-0">
                                <span class="pd-label">Dirección</span>
                                @if($padre->direccion)
                                    <div class="pd-value"><i class="fas fa-map-marker-alt"></i> {{ $padre->direccion }}</div>
                                @else
                                    <div class="pd-value empty">No registrada</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Información Laboral ── --}}
    <div class="pd-card mt-3">
        <div class="pd-card-head">
            <h5><i class="fas fa-briefcase"></i> Información Laboral</h5>
        </div>
        <div class="pd-card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="pd-field">
                        <span class="pd-label">Ocupación</span>
                        @if($padre->ocupacion)
                            <div class="pd-value"><i class="fas fa-hard-hat"></i> {{ $padre->ocupacion }}</div>
                        @else
                            <div class="pd-value empty">No registrada</div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pd-field">
                        <span class="pd-label">Lugar de Trabajo</span>
                        @if($padre->lugar_trabajo)
                            <div class="pd-value"><i class="fas fa-building"></i> {{ $padre->lugar_trabajo }}</div>
                        @else
                            <div class="pd-value empty">No registrado</div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pd-field mb-0">
                        <span class="pd-label">Teléfono de Trabajo</span>
                        @if($padre->telefono_trabajo)
                            <div class="pd-value"><i class="fas fa-phone-square"></i><a href="tel:{{ $padre->telefono_trabajo }}">{{ $padre->telefono_trabajo }}</a></div>
                        @else
                            <div class="pd-value empty">No registrado</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Observaciones (solo si existen) ── --}}
    @if($padre->observaciones)
    <div class="pd-card">
        <div class="pd-card-head">
            <h5><i class="fas fa-clipboard"></i> Observaciones</h5>
        </div>
        <div class="pd-card-body">
            <div class="pd-obs-box">
                {{ $padre->observaciones }}
            </div>
        </div>
    </div>
    @endif

    {{-- ── Estudiantes a su Cargo ── --}}
    <div class="pd-card">
        <div class="pd-card-head">
            <h5><i class="fas fa-graduation-cap"></i> Estudiantes a su Cargo</h5>
            <span class="pd-count">{{ $padre->estudiantes->count() }} Estudiante(s)</span>
        </div>
        <div class="pd-card-body p-0">
            @if($padre->estudiantes->count() > 0)
                <div class="table-responsive">
                    <table class="table pd-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre Completo</th>
                                <th>DNI</th>
                                <th>Grado</th>
                                <th>Sección</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($padre->estudiantes as $index => $estudiante)
                            <tr>
                                <td class="text-muted" style="font-size:0.85rem;">{{ $index + 1 }}</td>
                                <td>
                                    <span class="pd-student-name">
                                        <i class="fas fa-user-graduate me-1" style="color:#4ec7d2;"></i>
                                        {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                                        {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                                    </span>
                                </td>
                                <td>
                                    <span class="font-monospace" style="color:#00508f; font-size:0.85rem;">
                                        {{ $estudiante->dni ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    @if($estudiante->gradoAsignado)
                                        <span class="pd-badge-grado">
                                            {{ $estudiante->gradoAsignado->numero }}°
                                            {{ $estudiante->gradoAsignado->nivel }}
                                        </span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($estudiante->seccion)
                                        <span class="pd-badge-grado">{{ $estudiante->seccion }}</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($estudiante->estado === 'activo')
                                        <span class="pd-badge-activo"><span class="pd-dot green"></span> Activo</span>
                                    @else
                                        <span class="pd-badge-inactivo"><span class="pd-dot red"></span> Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="pd-btn-ver" title="Ver detalles">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="pd-empty">
                    <i class="fas fa-user-graduate"></i>
                    <p class="fw-semibold mb-1" style="color:#003b73;">No hay estudiantes vinculados</p>
                    <p>Este padre/tutor no tiene estudiantes asignados.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
