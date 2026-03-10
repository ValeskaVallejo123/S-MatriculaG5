@extends('layouts.app')

@section('title', 'Secciones')
@section('page-title', 'Gestión de Secciones')

@section('topbar-actions')
    
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    {{-- ── Alertas ─────────────────────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert"
         style="border-radius:10px; border-left:4px solid #28a745;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error') || $errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"
         style="border-radius:10px; border-left:4px solid #dc3545;">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') ?? $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- ── Estadísticas ─────────────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-card__icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div>
                    <p class="stat-card__label">Total Matrículas</p>
                    <h4 class="stat-card__value">{{ $matriculas->total() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-card__icon" style="background:linear-gradient(135deg,#28a745,#20c997);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="stat-card__label">Con Sección</p>
                    <h4 class="stat-card__value" style="color:#28a745;">{{ $conSeccion }}</h4>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-card__icon" style="background:linear-gradient(135deg,#ffc107,#ff9800);">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="stat-card__label">Sin Asignar</p>
                    <h4 class="stat-card__value" style="color:#d97706;">{{ $sinSeccion }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Pestañas ──────────────────────────────────────────────────────────── --}}
    <ul class="nav nav-tabs mb-0" id="seccionesTabs" role="tablist"
        style="border-bottom: 2px solid #e0eaf4;">
        <li class="nav-item" role="presentation">
            <button class="tab-btn active"
                    id="tab-asignar-btn"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-asignar"
                    type="button" role="tab">
                <i class="fas fa-user-check me-2"></i>Asignar Secciones
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="tab-btn"
                    id="tab-alumnos-btn"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-alumnos"
                    type="button" role="tab">
                <i class="fas fa-chalkboard-teacher me-2"></i>Alumnos por Sección
            </button>
        </li>
    </ul>

    <div class="tab-content" id="seccionesTabsContent">

        {{-- ════════════════════════════════════════════════════════════════════
             PESTAÑA 1: ASIGNAR SECCIONES
             ════════════════════════════════════════════════════════════════════ --}}
        <div class="tab-pane fade show active" id="tab-asignar" role="tabpanel">
            <div class="card border-0 shadow-sm"
                 style="border-radius:0 12px 12px 12px; border-top:none; padding-top:1rem;">
                <div class="card-body p-3">

                    {{-- Filtros --}}
                    <form action="{{ route('secciones.index') }}" method="GET" class="mb-3">
                        <input type="hidden" name="tab" value="asignar">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="filter-label"><i class="fas fa-search"></i> Buscar alumno</label>
                                <input type="text" name="buscar"
                                       class="form-control form-control-sm filter-input"
                                       placeholder="Nombre, apellido o DNI..."
                                       value="{{ request('buscar') }}">
                            </div>
                           <div class="col-md-3">
    <label class="filter-label"><i class="fas fa-graduation-cap"></i> Grado</label>
    <select name="grado" class="form-select form-select-sm filter-input">
        <option value="">Todos los grados</option>
        @foreach ($grados as $g)
            <option value="{{ $g }}" {{ request('grado') === $g ? 'selected' : '' }}>
                {{ $g }}
            </option>
        @endforeach
    </select>
</div>
    <div class="col-md-3">
    <label class="filter-label"><i class="fas fa-chalkboard"></i> Sección / Estado</label>
    <select name="estado" class="form-select form-select-sm filter-input">
        <option value="">Todas las matrículas</option>
        
        <optgroup label="Estados Generales">
            <option value="sin_asignar" {{ request('estado') === 'sin_asignar' ? 'selected' : '' }}>
                ⚠ Sin asignar
            </option>
            <option value="asignada" {{ request('estado') === 'asignada' ? 'selected' : '' }}>
                ✓ Asignadas (Cualquiera)
            </option>
        </optgroup>

        <optgroup label="Secciones Específicas">
            @foreach($secciones as $seccion)
                <option value="{{ $seccion->id }}" {{ request('estado') == $seccion->id ? 'selected' : '' }}>
                {{ $seccion->grado }}° {{ $seccion->nombre }}
                </option>
            @endforeach
        </optgroup>
    </select>
</div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-sm w-100 btn-filtrar">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>
                        @if(request()->hasAny(['buscar','grado','estado']))
                        <div class="mt-2">
                            <a href="{{ route('secciones.index') }}"
                               class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                        @endif
                    </form>

                    {{-- Tabla --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0"
                               style="border-radius:10px; overflow:hidden;">
                            <thead>
                                <tr style="background:linear-gradient(135deg,#003b73,#00508f);">
                                    <th class="th-style">Código</th>
                                    <th class="th-style">Alumno</th>
                                    <th class="th-style">Grado</th>
                                    <th class="th-style">Sección actual</th>
                                    <th class="th-style">Asignar sección</th>
                                    <th class="th-style text-center">Modal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($matriculas as $matricula)
                                <tr class="matricula-row">

                                    <td>
                                        <span class="badge-codigo">{{ $matricula->codigo_matricula }}</span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-initials">
                                                {{ strtoupper(substr($matricula->estudiante->nombre1 ?? 'N', 0, 1)) }}{{ strtoupper(substr($matricula->estudiante->apellido1 ?? 'A', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold" style="color:#003b73; font-size:0.88rem;">
                                                    {{ $matricula->estudiante->nombre1 }}
                                                    {{ $matricula->estudiante->nombre2 }}
                                                    {{ $matricula->estudiante->apellido1 }}
                                                    {{ $matricula->estudiante->apellido2 }}
                                                </div>
                                                <small class="text-muted" style="font-size:0.73rem;">
                                                    <i class="fas fa-id-card me-1"></i>{{ $matricula->estudiante->dni }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge-grado">{{ $matricula->estudiante->grado }}</span>
                                    </td>

                                    <td>
                                        @if($matricula->seccion)
                                            <span class="badge-seccion-ok">
                                                <i class="fas fa-chalkboard me-1"></i>
                                                {{ $matricula->seccion->grado }} — {{ $matricula->seccion->letra }}
                                            </span>
                                        @else
                                            <span class="badge-sin-asignar">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Sin asignar
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Dropdown inline --}}
                                    <td>
                                        <form action="{{ route('secciones.asignar') }}" method="POST"
                                              class="d-flex align-items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="matricula_id" value="{{ $matricula->id }}">
                                            <select name="seccion_id"
                                                    class="form-select form-select-sm"
                                                    style="min-width:190px; border-radius:8px; border:1.5px solid #d0dce8; font-size:0.8rem;">
                                                <option value="">— Elegir sección —</option>
                                                @foreach($secciones->where('grado', $matricula->estudiante->grado) as $sec)
                                                    <option value="{{ $sec->id }}"
                                                        {{ $matricula->seccion_id == $sec->id ? 'selected' : '' }}>
                                                        {{ $sec->grado }} — Sección {{ $sec->letra }}
                                                        ({{ $sec->cupo_disponible }} cupos)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-guardar">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Modal individual --}}
                                    <td class="text-center">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-modal"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalAsignar{{ $matricula->id }}"
                                                title="{{ $matricula->seccion ? 'Cambiar sección' : 'Asignar sección' }}">
                                            <i class="fas {{ $matricula->seccion ? 'fa-exchange-alt' : 'fa-user-check' }}"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal por fila --}}
                                <div class="modal fade" id="modalAsignar{{ $matricula->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content modal-custom">
                                            <div class="modal-header modal-header-custom">
                                                <h5 class="modal-title text-white">
                                                    <i class="fas fa-user-check me-2"></i>Asignar Sección
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('secciones.asignar') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="matricula_id" value="{{ $matricula->id }}">
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold" style="color:#003b73;">
                                                            <i class="fas fa-user me-1"></i>Alumno
                                                        </label>
                                                        <input type="text" class="form-control"
                                                               value="{{ $matricula->estudiante->nombre1 }} {{ $matricula->estudiante->apellido1 }}"
                                                               disabled style="background:#f8f9fa; border-radius:8px;">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold" style="color:#003b73;">
                                                            <i class="fas fa-graduation-cap me-1"></i>Grado
                                                        </label>
                                                        <input type="text" class="form-control"
                                                               value="{{ $matricula->estudiante->grado }}"
                                                               disabled style="background:#f8f9fa; border-radius:8px;">
                                                    </div>
                                                    <div class="mb-1">
                                                        <label class="form-label fw-semibold" style="color:#003b73;">
                                                            <i class="fas fa-chalkboard me-1"></i>Sección *
                                                        </label>
                                                        <select name="seccion_id" class="form-select" required
                                                                style="border-radius:8px; border:1.5px solid #e0e0e0;">
                                                            <option value="">— Seleccione una sección —</option>
                                                            @foreach($secciones->where('grado', $matricula->estudiante->grado) as $sec)
                                                                <option value="{{ $sec->id }}"
                                                                    {{ $matricula->seccion_id == $sec->id ? 'selected' : '' }}>
                                                                    {{ $sec->grado }} — Sección {{ $sec->letra }}
                                                                    ({{ $sec->cupo_disponible }} cupos)
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if($secciones->where('grado', $matricula->estudiante->grado)->isEmpty())
                                                        <small class="text-warning d-block mt-1">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            No hay secciones para el grado "{{ $matricula->estudiante->grado }}".
                                                        </small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top:1px solid #e0e0e0; padding:1rem 1.5rem;">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:8px;">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-confirmar">
                                                        <i class="fas fa-check"></i> Confirmar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-2x d-block mb-2 opacity-50"></i>
                                        No hay matrículas que coincidan con los filtros.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $matriculas->withQueryString()->links() }}</div>

                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════════
             PESTAÑA 2: ALUMNOS POR SECCIÓN
             ════════════════════════════════════════════════════════════════════ --}}
        <div class="tab-pane fade" id="tab-alumnos" role="tabpanel">
            <div class="card border-0 shadow-sm"
                 style="border-radius:0 12px 12px 12px; border-top:none; padding-top:1rem;">
                <div class="card-body p-3">

                    @forelse($gradosSecciones as $grado => $seccionesGrupo)
                    <div class="mb-5">

                        {{-- Encabezado del grado --}}
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="grado-badge">{{ $grado }}</div>
                            <div>
                                <h5 class="mb-0 fw-bold" style="color:#003b73;">Grado {{ $grado }}</h5>
                                <small class="text-muted">
                                    {{ $seccionesGrupo->sum(fn($s) => $s->matriculas->count()) }} alumno(s)
                                    · {{ $seccionesGrupo->count() }} sección(es)
                                </small>
                            </div>
                            <hr class="flex-grow-1 ms-2" style="border-color:#d0dce8;">
                        </div>

                        {{-- Cards de sección --}}
                        <div class="row g-3">
                            @foreach($seccionesGrupo as $seccion)
                            <div class="col-md-6 col-lg-4">
                                <div class="card seccion-card border-0 shadow-sm h-100">

                                    {{-- Header sección --}}
                                    <div class="seccion-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="mb-0 text-white fw-bold">
                                                <i class="fas fa-chalkboard me-2"></i>
                                                Sección {{ $seccion->letra }}
                                            </h6>
                                            <div class="d-flex gap-2 align-items-center">
                                                <span class="cupo-badge">
                                                    {{ $seccion->matriculas->count() }}/{{ $seccion->capacidad }}
                                                </span>
                                                @if($seccion->cupo_disponible > 0)
                                                    <span class="cupo-libre">
                                                        {{ $seccion->cupo_disponible }} libre(s)
                                                    </span>
                                                @else
                                                    <span class="cupo-lleno">Llena</span>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Barra de ocupación --}}
                                        @php
                                            $pct = $seccion->capacidad > 0
                                                ? min(($seccion->matriculas->count() / $seccion->capacidad) * 100, 100)
                                                : 0;
                                            $barColor = $pct >= 100 ? '#ff4757' : ($pct >= 80 ? '#ffa502' : 'white');
                                        @endphp
                                        <div class="progress-track mt-2">
                                            <div class="progress-fill"
                                                 style="width:{{ $pct }}%; background:{{ $barColor }};"></div>
                                        </div>
                                    </div>

                                    {{-- Lista alumnos --}}
                                    <div class="card-body p-0" style="max-height:280px; overflow-y:auto;">
                                        @forelse($seccion->matriculas as $matricula)
                                        <div class="alumno-row d-flex align-items-center gap-2 px-3 py-2">
                                            <div class="avatar-sm">
                                                {{ strtoupper(
                                                    substr($matricula->estudiante->nombre1 ?? 'N', 0, 1) .
                                                    substr($matricula->estudiante->apellido1 ?? 'A', 0, 1)
                                                ) }}
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-0 fw-semibold text-truncate"
                                                   style="color:#003b73; font-size:0.83rem;">
                                                    {{ $matricula->estudiante->nombre1 }}
                                                    {{ $matricula->estudiante->nombre2 }}
                                                    {{ $matricula->estudiante->apellido1 }}
                                                    {{ $matricula->estudiante->apellido2 }}
                                                </p>
                                                <small class="text-muted" style="font-size:0.7rem;">
                                                    <i class="fas fa-id-card me-1"></i>{{ $matricula->estudiante->dni ?? 'Sin DNI' }}
                                                </small>
                                            </div>
                                            <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                @if($matricula->estado === 'aprobada')
                                                    <i class="fas fa-check-circle text-success" style="font-size:0.8rem;" title="Aprobada"></i>
                                                @elseif($matricula->estado === 'pendiente')
                                                    <i class="fas fa-clock text-warning" style="font-size:0.8rem;" title="Pendiente"></i>
                                                @else
                                                    <i class="fas fa-times-circle text-danger" style="font-size:0.8rem;" title="Rechazada"></i>
                                                @endif
                                                {{-- Quitar de sección --}}
                                                <form action="{{ route('secciones.quitar') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="matricula_id" value="{{ $matricula->id }}">
                                                    <button type="submit" class="btn-quitar"
                                                            title="Quitar de sección"
                                                            onclick="return confirm('¿Quitar a este alumno de la sección {{ $seccion->letra }}?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="text-center py-4">
                                            <i class="fas fa-user-slash mb-2" style="font-size:1.4rem; color:#cbd5e1;"></i>
                                            <p class="text-muted mb-0 small">Sin alumnos asignados</p>
                                        </div>
                                        @endforelse
                                    </div>

                                    {{-- Footer: asignar alumno directo a esta sección --}}
                                    <div class="card-footer border-0 p-3"
                                         style="background:#f8fafc; border-top:1px solid #e8f0f8;">
                                        @if($seccion->cupo_disponible > 0)
                                        <form action="{{ route('secciones.asignar') }}" method="POST"
                                              class="d-flex gap-2 align-items-center">
                                            @csrf
                                            {{-- Sección fija; el usuario solo elige la matrícula --}}
                                            <input type="hidden" name="seccion_id" value="{{ $seccion->id }}">
                                            <select name="matricula_id"
                                                    class="form-select form-select-sm flex-grow-1"
                                                    style="border-radius:7px; border:1.5px solid #d0dce8; font-size:0.77rem;">
                                                <option value="">— Agregar alumno —</option>
                                                @foreach($matriculasSinSeccionPorGrado[$grado] ?? [] as $m)
                                                    <option value="{{ $m->id }}">
                                                        {{ $m->estudiante->nombre1 }}
                                                        {{ $m->estudiante->apellido1 }}
                                                        ({{ $m->estudiante->dni }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-asignar-rapido" title="Asignar">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                        @else
                                        <p class="text-center mb-0" style="font-size:0.78rem; color:#dc3545; font-weight:600;">
                                            <i class="fas fa-lock me-1"></i>Sección llena
                                        </p>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-school fa-3x mb-3" style="color:#bfd9ea;"></i>
                        <p class="mb-1">No hay secciones creadas.</p>
                        <a href="{{ route('secciones.create') }}"
                           class="btn btn-sm mt-2"
                           style="background:linear-gradient(135deg,#4ec7d2,#00508f); color:white; border-radius:8px;">
                            <i class="fas fa-plus me-1"></i> Crear primera sección
                        </a>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>{{-- /tab-content --}}

</div>

{{-- ── Modal nueva asignación global ───────────────────────────────────────── --}}
<div class="modal fade" id="nuevaInscripcionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title text-white">
                    <i class="fas fa-plus-circle me-2"></i>Nueva Asignación de Sección
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('secciones.asignar') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:#003b73;">
                            <i class="fas fa-id-badge me-1"></i>Matrícula *
                        </label>
                        <select name="matricula_id" class="form-select" required
                                style="border-radius:8px; border:1.5px solid #e0e0e0;">
                            <option value="">— Seleccione una matrícula —</option>
                            @foreach($matriculas as $m)
                                <option value="{{ $m->id }}">
                                    {{ $m->codigo_matricula }} —
                                    {{ $m->estudiante->nombre1 }} {{ $m->estudiante->apellido1 }}
                                    ({{ $m->estudiante->grado }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-semibold" style="color:#003b73;">
                            <i class="fas fa-chalkboard me-1"></i>Sección *
                        </label>
                        <select name="seccion_id" class="form-select" required
                                style="border-radius:8px; border:1.5px solid #e0e0e0;">
                            <option value="">— Seleccione una sección —</option>
                            @foreach($secciones as $sec)
                                <option value="{{ $sec->id }}">
                                    {{ $sec->grado }} — Sección {{ $sec->letra }}
                                    ({{ $sec->cupo_disponible }} cupos)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #e0e0e0; padding:1rem 1.5rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:8px;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-confirmar">
                        <i class="fas fa-check"></i> Confirmar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── Estilos ───────────────────────────────────────────────────────────────── --}}
<style>
/* Topbar */
.btn-topbar {
    background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
    color: white; padding: 0.5rem 1.2rem; border-radius: 8px;
    font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;
    border: none; box-shadow: 0 2px 8px rgba(78,199,210,0.3); font-size: 0.9rem;
    transition: all 0.2s;
}
.btn-topbar:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(78,199,210,0.45); }

/* Stat cards */
.stat-card {
    display: flex; align-items: center; gap: 1rem;
    padding: 0.9rem 1rem; border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.07);
    background: white;
}
.stat-card__icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.stat-card__icon i { color: white; font-size: 1.3rem; }
.stat-card__label { margin: 0; font-size: 0.78rem; color: #6c757d; }
.stat-card__value { margin: 0; font-weight: 700; font-size: 1.4rem; color: #003b73; }

/* Pestañas */
.tab-btn {
    background: #f1f5f9; border: 2px solid #e0eaf4; border-bottom: none;
    color: #5a7a9a; font-weight: 600; font-size: 0.88rem;
    padding: 0.65rem 1.4rem; border-radius: 10px 10px 0 0;
    cursor: pointer; transition: all 0.2s; margin-right: 4px;
}
.tab-btn:hover { background: #e8f2fb; color: #003b73; }
.tab-btn.active {
    background: white; color: #003b73;
    border-color: #e0eaf4; border-bottom-color: white;
}

/* Filtros */
.filter-label { display:block; font-size:0.79rem; font-weight:600; color:#003b73; margin-bottom:0.2rem; }
.filter-input { border-radius: 8px !important; border: 1.5px solid #d0dce8 !important; }
.btn-filtrar {
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    color: white; border: none; border-radius: 8px; padding: 0.47rem; font-weight: 600;
}

/* Tabla */
.th-style {
    color: white; font-size: 0.81rem; font-weight: 600;
    padding: 0.75rem 1rem; white-space: nowrap; border: none;
}
.matricula-row td { padding: 0.65rem 1rem; vertical-align: middle; border-color: #f0f0f0; }
.matricula-row:hover { background: rgba(78,199,210,0.04); }

/* Avatar tabla */
.avatar-initials {
    width: 36px; height: 36px; border-radius: 9px;
    background: linear-gradient(135deg, #00508f, #003b73);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 0.82rem; flex-shrink: 0;
    border: 2px solid #4ec7d2;
}

/* Badges tabla */
.badge-codigo {
    background: rgba(0,80,143,0.08); color: #003b73;
    border: 1px solid #cde; padding: 0.28rem 0.55rem;
    border-radius: 6px; font-size: 0.76rem; font-weight: 600; font-family: monospace;
}
.badge-grado {
    background: rgba(78,199,210,0.12); color: #00508f;
    border: 1px solid #4ec7d2; padding: 0.28rem 0.6rem;
    border-radius: 20px; font-size: 0.74rem; font-weight: 600; white-space: nowrap;
}
.badge-seccion-ok {
    background: rgba(40,167,69,0.1); color: #28a745;
    border: 1px solid #28a745; padding: 0.28rem 0.6rem;
    border-radius: 20px; font-size: 0.74rem; font-weight: 600;
}
.badge-sin-asignar {
    background: rgba(255,193,7,0.12); color: #b45309;
    border: 1px solid #ffc107; padding: 0.28rem 0.6rem;
    border-radius: 20px; font-size: 0.74rem; font-weight: 600;
}

/* Botones tabla */
.btn-guardar {
    width: 32px; height: 32px; border-radius: 7px; flex-shrink: 0;
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    color: white; border: none; font-size: 0.8rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: all 0.2s;
}
.btn-guardar:hover { transform: scale(1.08); box-shadow: 0 3px 10px rgba(0,80,143,0.3); }
.btn-outline-modal {
    border: 1.5px solid #00508f; color: #00508f; background: white;
    border-radius: 7px; padding: 0.3rem 0.6rem; font-size: 0.8rem; transition: all 0.2s;
}
.btn-outline-modal:hover { background: #00508f; color: white; }

/* Modal */
.modal-custom { border-radius: 12px; border: none; box-shadow: 0 4px 24px rgba(0,0,0,0.15); }
.modal-header-custom {
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    border-radius: 12px 12px 0 0; border: none;
}
.btn-confirmar {
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    color: white; border: none; border-radius: 8px;
    padding: 0.5rem 1.2rem; font-weight: 600;
    box-shadow: 0 2px 8px rgba(78,199,210,0.3); transition: all 0.2s;
}
.btn-confirmar:hover { transform: translateY(-1px); color: white; }

/* ── Pestaña 2: Secciones ─────────────────────────────────────────── */
.grado-badge {
    width: 44px; height: 44px; flex-shrink: 0;
    background: linear-gradient(135deg,#00508f,#003b73);
    border-radius: 11px; display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 1rem;
    box-shadow: 0 4px 10px rgba(0,59,115,0.2);
}

.seccion-card { border-radius: 12px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; }
.seccion-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,59,115,0.12) !important; }

.seccion-header {
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    padding: 0.7rem 1rem;
}
.progress-track { background: rgba(255,255,255,0.2); border-radius: 4px; height: 4px; }
.progress-fill  { height: 100%; border-radius: 4px; transition: width 0.4s; }

.cupo-badge {
    background: rgba(255,255,255,0.2); color: white;
    font-size: 0.7rem; font-weight: 600; padding: 0.18rem 0.5rem; border-radius: 20px;
}
.cupo-libre {
    background: rgba(40,167,69,0.85); color: white;
    font-size: 0.67rem; font-weight: 600; padding: 0.18rem 0.45rem; border-radius: 20px;
}
.cupo-lleno {
    background: rgba(220,53,69,0.85); color: white;
    font-size: 0.67rem; font-weight: 600; padding: 0.18rem 0.45rem; border-radius: 20px;
}

.alumno-row { border-bottom: 1px solid #f0f4f8; transition: background 0.15s; }
.alumno-row:last-child { border-bottom: none; }
.alumno-row:hover { background: #f0f8ff; }

.avatar-sm {
    width: 30px; height: 30px; flex-shrink: 0; border-radius: 7px;
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 0.72rem;
    border: 1.5px solid #e8f4f8;
}

.btn-quitar {
    width: 22px; height: 22px; border-radius: 5px; padding: 0;
    background: rgba(220,53,69,0.08); border: 1px solid rgba(220,53,69,0.25);
    color: #dc3545; font-size: 0.62rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: all 0.15s;
}
.btn-quitar:hover { background: #dc3545; color: white; border-color: #dc3545; }

.btn-asignar-rapido {
    width: 30px; height: 30px; flex-shrink: 0; border-radius: 7px;
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    border: none; color: white; font-size: 0.78rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: all 0.2s;
}
.btn-asignar-rapido:hover { transform: scale(1.1); box-shadow: 0 3px 10px rgba(0,80,143,0.3); }
</style>

@push('scripts')
<script>
// Reabrir la pestaña correcta tras redirect (evita volver siempre a la tab 1)
document.addEventListener('DOMContentLoaded', function () {
    const activeTab = new URLSearchParams(window.location.search).get('tab');
    if (activeTab === 'alumnos') {
        const btn = document.getElementById('tab-alumnos-btn');
        if (btn) new bootstrap.Tab(btn).show();
    }
});
</script>
@endpush

@endsection