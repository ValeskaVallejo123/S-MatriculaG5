@extends('layouts.app')

@section('title', 'Detalle del Padre/Tutor')
@section('page-title', 'Detalle del Padre/Tutor')

@section('topbar-actions')
<div class="d-flex gap-2">
    <a href="{{ route('padres.edit', $padre->id) }}"
       style="background: linear-gradient(135deg,#fbbf24,#f59e0b); color:#fff;
              padding:.45rem 1.1rem; border-radius:8px; text-decoration:none;
              font-weight:600; display:inline-flex; align-items:center; gap:.45rem;
              font-size:.85rem; box-shadow:0 2px 8px rgba(251,191,36,.3);">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="{{ route('padres.index') }}"
       style="background:#fff; color:#00508f; padding:.45rem 1.1rem; border-radius:8px;
              text-decoration:none; font-weight:600; display:inline-flex;
              align-items:center; gap:.45rem; font-size:.85rem;
              border:2px solid #4ec7d2; box-shadow:0 2px 8px rgba(78,199,210,.2);">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.show-wrap { font-family:'Inter',sans-serif; max-width:1100px; margin:0 auto; }

/* ── Banner ── */
.show-banner {
    background: linear-gradient(135deg,#003b73,#00508f 60%,#4ec7d2);
    border-radius:12px; padding:1.4rem 1.75rem;
    display:flex; align-items:center; gap:1.25rem;
    box-shadow:0 4px 18px rgba(0,59,115,.2);
    position:relative; overflow:hidden; margin-bottom:1.5rem;
}
.show-banner::before {
    content:''; position:absolute; top:-40%; right:-4%;
    width:200px; height:200px; background:rgba(255,255,255,.07); border-radius:50%;
}
.show-banner::after {
    content:''; position:absolute; bottom:-50%; right:12%;
    width:130px; height:130px; background:rgba(255,255,255,.05); border-radius:50%;
}
.show-banner-icon {
    width:58px; height:58px; border-radius:14px;
    background:rgba(255,255,255,.18); border:2px solid rgba(255,255,255,.3);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:1.5rem; flex-shrink:0; position:relative; z-index:1;
}
.show-banner-info { position:relative; z-index:1; }
.show-banner-info h4 { color:#fff; font-weight:700; margin:0 0 .2rem; font-size:1.15rem; }
.show-banner-info p  { color:rgba(255,255,255,.75); font-size:.82rem; margin:0; }
.show-banner-badge {
    margin-left:auto; position:relative; z-index:1;
    padding:.35rem .9rem; border-radius:999px; font-size:.78rem; font-weight:700;
    border:1.5px solid rgba(255,255,255,.45); color:#fff;
}

/* ── Stat grid ── */
.stat-grid {
    display:grid; grid-template-columns:repeat(3,1fr);
    gap:1rem; margin-bottom:1.5rem;
}
@media(max-width:768px){ .stat-grid{ grid-template-columns:1fr; } }

.stat-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:12px;
    padding:1.1rem 1.25rem; display:flex; align-items:center; gap:1rem;
    box-shadow:0 1px 3px rgba(0,0,0,.05); position:relative; overflow:hidden;
    transition:box-shadow .15s;
}
.stat-card:hover { box-shadow:0 4px 14px rgba(0,80,143,.1); }
.stat-card-stripe {
    position:absolute; left:0; top:0; bottom:0;
    width:4px; border-radius:12px 0 0 12px;
}
.stat-icon {
    width:46px; height:46px; border-radius:11px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:1.1rem;
}
.stat-label { font-size:.72rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.04em; margin-bottom:.2rem; }
.stat-value { font-size:.95rem; font-weight:700; color:#003b73; }

/* ── Section card ── */
.pad-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:12px;
    overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.05); margin-bottom:1.25rem;
}
.pad-card-head {
    background:#003b73; padding:.85rem 1.25rem;
    display:flex; align-items:center; justify-content:space-between;
}
.pad-card-head-left { display:flex; align-items:center; gap:.6rem; }
.pad-card-head i    { color:#4ec7d2; font-size:1rem; }
.pad-card-head span { color:#fff; font-weight:700; font-size:.95rem; }
.pad-card-body { padding:1.25rem 1.5rem; }

/* ── Field rows ── */
.field-grid {
    display:grid; gap:.9rem;
}
.field-grid-2 { grid-template-columns:repeat(2,1fr); }
.field-grid-3 { grid-template-columns:repeat(3,1fr); }
@media(max-width:600px){
    .field-grid-2,.field-grid-3 { grid-template-columns:1fr; }
}

.field-item {}
.field-label {
    font-size:.7rem; font-weight:600; color:#94a3b8;
    text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;
}
.field-value {
    font-size:.9rem; font-weight:600; color:#0f172a;
    display:flex; align-items:center; gap:.45rem;
}
.field-value i { color:#4ec7d2; font-size:.85rem; }
.field-value a { color:#00508f; text-decoration:none; }
.field-value a:hover { text-decoration:underline; }
.field-empty { color:#cbd5e1; font-weight:400; font-style:italic; font-size:.85rem; }

/* ── Info item (para obs) ── */
.obs-box {
    background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px;
    padding:1rem 1.25rem; color:#0f172a; font-size:.88rem; line-height:1.6;
    border-left:3px solid #4ec7d2;
}

/* ── Badge helpers ── */
.tag-cyan {
    display:inline-flex; align-items:center; gap:.3rem;
    background:rgba(78,199,210,.12); color:#00508f;
    border:1px solid #4ec7d2; padding:.3rem .75rem;
    border-radius:999px; font-size:.78rem; font-weight:700;
}
.tag-green {
    display:inline-flex; align-items:center; gap:.3rem;
    background:#ecfdf5; color:#059669;
    border:1px solid #6ee7b7; padding:.3rem .75rem;
    border-radius:999px; font-size:.78rem; font-weight:700;
}
.tag-red {
    display:inline-flex; align-items:center; gap:.3rem;
    background:#fee2e2; color:#991b1b;
    border:1px solid #fca5a5; padding:.3rem .75rem;
    border-radius:999px; font-size:.78rem; font-weight:700;
}

/* ── Tabla estudiantes ── */
.student-table { width:100%; border-collapse:collapse; }
.student-table thead tr {
    background:linear-gradient(135deg,#f8fafc,#e2e8f0);
}
.student-table th {
    padding:.6rem 1rem; font-size:.7rem; font-weight:700;
    color:#003b73; text-transform:uppercase; letter-spacing:.04em;
    border-bottom:2px solid #e2e8f0;
}
.student-table td {
    padding:.65rem 1rem; font-size:.85rem; color:#0f172a;
    border-bottom:1px solid #f1f5f9; vertical-align:middle;
}
.student-table tbody tr:hover { background:#f8fafc; }
.student-table tbody tr:last-child td { border-bottom:none; }

.btn-view {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.3rem .7rem; border-radius:7px; font-size:.78rem; font-weight:600;
    border:1.5px solid #00508f; color:#00508f; background:#fff;
    text-decoration:none; transition:all .15s;
}
.btn-view:hover { background:#00508f; color:#fff; }

.empty-state {
    padding:3rem 1.5rem; text-align:center;
}
.empty-state-icon {
    width:64px; height:64px; border-radius:16px; margin:0 auto 1rem;
    background:linear-gradient(135deg,rgba(0,80,143,.07),rgba(78,199,210,.12));
    display:flex; align-items:center; justify-content:center;
    font-size:1.6rem; color:#00508f;
}
.empty-state h6  { color:#003b73; font-weight:700; margin-bottom:.3rem; }
.empty-state p   { color:#94a3b8; font-size:.82rem; margin:0; }
</style>
@endpush

@section('content')
<div class="show-wrap">

    {{-- ── Banner ── --}}
    <div class="show-banner">
        <div class="show-banner-icon">
            <i class="fas fa-user-friends"></i>
        </div>
        <div class="show-banner-info">
            <h4>{{ $padre->nombre }} {{ $padre->apellido }}</h4>
            <p>
                <i class="fas fa-id-card me-1"></i>{{ $padre->dni }}
                &nbsp;·&nbsp;
                {{ ucfirst(str_replace('_', ' ', $padre->parentesco)) }}
                @if($padre->parentesco === 'otro' && $padre->parentesco_otro)
                    — {{ $padre->parentesco_otro }}
                @endif
            </p>
        </div>
        <div class="show-banner-badge" style="background:{{ $padre->estado ? 'rgba(110,231,183,.25)' : 'rgba(252,165,165,.25)' }};">
            <i class="fas fa-circle me-1" style="font-size:.5rem; color:{{ $padre->estado ? '#6ee7b7' : '#fca5a5' }};"></i>
            {{ $padre->estado ? 'Activo' : 'Inactivo' }}
        </div>
    </div>

    {{-- ── Stat cards ── --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-card-stripe" style="background:#4ec7d2;"></div>
            <div class="stat-icon" style="background:#e8f8f9;">
                <i class="fas fa-graduation-cap" style="color:#00508f;"></i>
            </div>
            <div>
                <div class="stat-label">Estudiantes a cargo</div>
                <div class="stat-value">{{ $padre->estudiantes->count() }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-stripe" style="background:#00508f;"></div>
            <div class="stat-icon" style="background:#e8f1f9;">
                <i class="fas fa-calendar-plus" style="color:#003b73;"></i>
            </div>
            <div>
                <div class="stat-label">Fecha de registro</div>
                <div class="stat-value">{{ $padre->created_at->format('d/m/Y') }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-stripe" style="background:#003b73;"></div>
            <div class="stat-icon" style="background:#eef2ff;">
                <i class="fas fa-calendar-check" style="color:#4f46e5;"></i>
            </div>
            <div>
                <div class="stat-label">Última actualización</div>
                <div class="stat-value">{{ $padre->updated_at->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    {{-- ── Datos Personales ── --}}
    <div class="pad-card">
        <div class="pad-card-head">
            <div class="pad-card-head-left">
                <i class="fas fa-id-card"></i>
                <span>Datos Personales</span>
            </div>
        </div>
        <div class="pad-card-body">
            <div class="field-grid field-grid-3">
                <div class="field-item">
                    <div class="field-label">Nombre completo</div>
                    <div class="field-value">
                        <i class="fas fa-user"></i>
                        {{ $padre->nombre }} {{ $padre->apellido }}
                    </div>
                </div>
                <div class="field-item">
                    <div class="field-label">DNI</div>
                    <div class="field-value">
                        <i class="fas fa-fingerprint"></i>
                        <span class="font-monospace">{{ $padre->dni }}</span>
                    </div>
                </div>
                <div class="field-item">
                    <div class="field-label">Parentesco</div>
                    <div class="field-value">
                        <span class="tag-cyan">
                            <i class="fas fa-sitemap"></i>
                            {{ ucfirst(str_replace('_', ' ', $padre->parentesco)) }}
                        </span>
                        @if($padre->parentesco === 'otro' && $padre->parentesco_otro)
                            <small class="text-muted ms-1">{{ $padre->parentesco_otro }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Datos de Contacto ── --}}
    <div class="pad-card">
        <div class="pad-card-head">
            <div class="pad-card-head-left">
                <i class="fas fa-phone"></i>
                <span>Datos de Contacto</span>
            </div>
        </div>
        <div class="pad-card-body">
            <div class="field-grid field-grid-2" style="margin-bottom:.9rem;">
                <div class="field-item">
                    <div class="field-label">Correo electrónico</div>
                    <div class="field-value">
                        <i class="fas fa-envelope"></i>
                        @if($padre->correo)
                            <a href="mailto:{{ $padre->correo }}">{{ $padre->correo }}</a>
                        @else
                            <span class="field-empty">No registrado</span>
                        @endif
                    </div>
                </div>
                <div class="field-item">
                    <div class="field-label">Dirección</div>
                    <div class="field-value">
                        <i class="fas fa-map-marker-alt"></i>
                        @if($padre->direccion)
                            {{ $padre->direccion }}
                        @else
                            <span class="field-empty">No registrada</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="field-grid field-grid-3">
                <div class="field-item">
                    <div class="field-label">Teléfono principal</div>
                    <div class="field-value">
                        <i class="fas fa-phone"></i>
                        @if($padre->telefono)
                            <a href="tel:{{ $padre->telefono }}">{{ $padre->telefono }}</a>
                        @else
                            <span class="field-empty">No registrado</span>
                        @endif
                    </div>
                </div>
                <div class="field-item">
                    <div class="field-label">Teléfono secundario</div>
                    <div class="field-value">
                        <i class="fas fa-mobile-alt"></i>
                        @if($padre->telefono_secundario)
                            <a href="tel:{{ $padre->telefono_secundario }}">{{ $padre->telefono_secundario }}</a>
                        @else
                            <span class="field-empty">No registrado</span>
                        @endif
                    </div>
                </div>
                <div class="field-item">
                    <div class="field-label">Teléfono de trabajo</div>
                    <div class="field-value">
                        <i class="fas fa-briefcase"></i>
                        @if($padre->telefono_trabajo)
                            <a href="tel:{{ $padre->telefono_trabajo }}">{{ $padre->telefono_trabajo }}</a>
                        @else
                            <span class="field-empty">No registrado</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Información Laboral ── --}}
    <div class="pad-card">
        <div class="pad-card-head">
            <div class="pad-card-head-left">
                <i class="fas fa-briefcase"></i>
                <span>Información Laboral</span>
            </div>
        </div>
        <div class="pad-card-body">
            <div class="field-grid field-grid-3">
                <div class="field-item">
                    <div class="field-label">Ocupación</div>
                    <div class="field-value">
                        <i class="fas fa-hard-hat"></i>
                        {{ $padre->ocupacion ?? '' }}
                        @if(!$padre->ocupacion)
                            <span class="field-empty">No registrada</span>
                        @endif
                    </div>
                </div>
                <div class="field-item">
                    <div class="field-label">Lugar de trabajo</div>
                    <div class="field-value">
                        <i class="fas fa-building"></i>
                        {{ $padre->lugar_trabajo ?? '' }}
                        @if(!$padre->lugar_trabajo)
                            <span class="field-empty">No registrado</span>
                        @endif
                    </div>
                </div>
                <div class="field-item">
                    <div class="field-label">Teléfono de trabajo</div>
                    <div class="field-value">
                        <i class="fas fa-phone-square"></i>
                        @if($padre->telefono_trabajo)
                            <a href="tel:{{ $padre->telefono_trabajo }}">{{ $padre->telefono_trabajo }}</a>
                        @else
                            <span class="field-empty">No registrado</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Observaciones (condicional) ── --}}
    @if($padre->observaciones)
    <div class="pad-card">
        <div class="pad-card-head">
            <div class="pad-card-head-left">
                <i class="fas fa-clipboard"></i>
                <span>Observaciones</span>
            </div>
        </div>
        <div class="pad-card-body">
            <div class="obs-box">{{ $padre->observaciones }}</div>
        </div>
    </div>
    @endif

    {{-- ── Estudiantes a su cargo ── --}}
    <div class="pad-card">
        <div class="pad-card-head">
            <div class="pad-card-head-left">
                <i class="fas fa-graduation-cap"></i>
                <span>Estudiantes a su Cargo</span>
            </div>
            <span class="tag-cyan" style="border-color:rgba(255,255,255,.4); background:rgba(255,255,255,.15); color:#fff;">
                {{ $padre->estudiantes->count() }} Estudiante(s)
            </span>
        </div>

        @if($padre->estudiantes->count() > 0)
        <div style="overflow-x:auto;">
            <table class="student-table">
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
                    @foreach($padre->estudiantes as $i => $estudiante)
                    <tr>
                        <td style="color:#94a3b8; font-size:.8rem;">{{ $i + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:.5rem;">
                                <div style="width:30px; height:30px; border-radius:8px;
                                            background:linear-gradient(135deg,rgba(0,80,143,.1),rgba(78,199,210,.15));
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:.75rem; color:#00508f; flex-shrink:0;">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <span style="font-weight:600; color:#003b73;">
                                    {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                                    {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                                </span>
                            </div>
                        </td>
                        <td><span class="font-monospace" style="font-size:.82rem; color:#64748b;">{{ $estudiante->dni }}</span></td>
                        <td><span class="tag-cyan" style="font-size:.72rem;">{{ $estudiante->grado }}</span></td>
                        <td><span class="tag-cyan" style="font-size:.72rem;">{{ $estudiante->seccion }}</span></td>
                        <td>
                            @if($estudiante->estado === 'activo')
                                <span class="tag-green">
                                    <i class="fas fa-circle" style="font-size:.45rem;"></i> Activo
                                </span>
                            @else
                                <span class="tag-red">
                                    <i class="fas fa-circle" style="font-size:.45rem;"></i> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h6>Sin estudiantes vinculados</h6>
            <p>Este padre/tutor no tiene estudiantes asignados aún.</p>
        </div>
        @endif
    </div>

</div>
@endsection