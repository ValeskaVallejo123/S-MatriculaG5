@extends('layouts.app')

@section('title', 'Secciones')
@section('page-title', 'Gestión de Secciones')

@section('topbar-actions')
@endsection

@section('content')
<div class="container-fluid" style="max-width:1400px;">

    {{-- ── Alertas ──────────────────────────────────────────────────────────── --}}
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
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div style="width:56px;height:56px;border-radius:12px;background:linear-gradient(135deg,#4ec7d2,#00508f);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-clipboard-list text-white" style="font-size:1.3rem;"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted" style="font-size:.82rem;">Total Matrículas</p>
                        <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $matriculas->total() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div style="width:56px;height:56px;border-radius:12px;background:linear-gradient(135deg,#28a745,#20c997);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-check-circle text-white" style="font-size:1.3rem;"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted" style="font-size:.82rem;">Con Sección</p>
                        <h3 class="mb-0 fw-bold" style="color:#28a745;">{{ $conSeccion }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div style="width:56px;height:56px;border-radius:12px;background:linear-gradient(135deg,#ffc107,#ff9800);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-clock text-white" style="font-size:1.3rem;"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted" style="font-size:.82rem;">Sin Asignar</p>
                        <h3 class="mb-0 fw-bold" style="color:#d97706;">{{ $sinSeccion }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Pestañas ──────────────────────────────────────────────────────────── --}}
    <ul class="nav nav-tabs mb-0" id="seccionesTabs" role="tablist"
        style="border-bottom:2px solid #e0eaf4;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active d-flex align-items-center gap-2"
                    id="tab-asignar-btn"
                    data-bs-toggle="tab" data-bs-target="#tab-asignar"
                    type="button" role="tab"
                    style="font-weight:600;font-size:.88rem;color:#003b73;border-radius:8px 8px 0 0;">
                <i class="fas fa-user-check"></i> Asignar Secciones
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-flex align-items-center gap-2"
                    id="tab-alumnos-btn"
                    data-bs-toggle="tab" data-bs-target="#tab-alumnos"
                    type="button" role="tab"
                    style="font-weight:600;font-size:.88rem;border-radius:8px 8px 0 0;">
                <i class="fas fa-chalkboard-teacher"></i> Alumnos por Sección
            </button>
        </li>
    </ul>

    <div class="tab-content" id="seccionesTabsContent">

        {{-- ════════════════════════════════════════════════════════════════════
             PESTAÑA 1 — ASIGNAR SECCIONES
        ════════════════════════════════════════════════════════════════════ --}}
        <div class="tab-pane fade show active" id="tab-asignar" role="tabpanel">
            <div class="card border-0 shadow-sm"
                 style="border-radius:0 12px 12px 12px;border-top:none;">
                <div class="card-body p-3">

                    {{-- Filtros --}}
                    <form action="{{ route('secciones.index') }}" method="GET" class="mb-3">
                        <input type="hidden" name="tab" value="asignar">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="d-block mb-1" style="font-size:.8rem;font-weight:600;color:#003b73;">
                                    <i class="fas fa-search me-1"></i>Buscar alumno
                                </label>
                                <input type="text" name="buscar"
                                       class="form-control form-control-sm"
                                       style="border-radius:8px;border:1.5px solid #d0dce8;"
                                       placeholder="Nombre, apellido o DNI..."
                                       value="{{ request('buscar') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="d-block mb-1" style="font-size:.8rem;font-weight:600;color:#003b73;">
                                    <i class="fas fa-graduation-cap me-1"></i>Grado
                                </label>
                                <select name="grado" class="form-select form-select-sm"
                                        style="border-radius:8px;border:1.5px solid #d0dce8;">
                                    <option value="">Todos los grados</option>
                                    @foreach($grados as $g)
                                        <option value="{{ $g }}" {{ request('grado') === $g ? 'selected' : '' }}>{{ $g }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="d-block mb-1" style="font-size:.8rem;font-weight:600;color:#003b73;">
                                    <i class="fas fa-chalkboard me-1"></i>Sección / Estado
                                </label>
                                <select name="estado" class="form-select form-select-sm"
                                        style="border-radius:8px;border:1.5px solid #d0dce8;">
                                    <option value="">Todas las matrículas</option>
                                    <optgroup label="Estados Generales">
                                        <option value="sin_asignar" {{ request('estado') === 'sin_asignar' ? 'selected' : '' }}>⚠ Sin asignar</option>
                                        <option value="asignada"    {{ request('estado') === 'asignada'    ? 'selected' : '' }}>✓ Asignadas</option>
                                    </optgroup>
                                    <optgroup label="Secciones Específicas">
                                        @foreach($secciones as $s)
                                            <option value="{{ $s->id }}" {{ request('estado') == $s->id ? 'selected' : '' }}>
                                                {{ $s->grado }} — Sección {{ $s->nombre }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-sm flex-grow-1"
                                        style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;border-radius:8px;font-weight:600;">
                                    <i class="fas fa-filter me-1"></i>Filtrar
                                </button>
                                @if(request()->hasAny(['buscar','grado','estado']))
                                <a href="{{ route('secciones.index') }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   style="border-radius:8px;">
                                    <i class="fas fa-times"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    {{-- Tabla --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0"
                               style="border-radius:10px;overflow:hidden;table-layout:auto;">
                            <thead>
                                <tr style="background:linear-gradient(135deg,#003b73,#00508f);">
                                    {{-- width fijo en columnas problemáticas --}}
                                    <th style="color:white;font-size:.8rem;font-weight:600;padding:.75rem 1rem;border:none;min-width:140px;">Código</th>
                                    <th style="color:white;font-size:.8rem;font-weight:600;padding:.75rem 1rem;border:none;">Alumno</th>
                                    <th style="color:white;font-size:.8rem;font-weight:600;padding:.75rem 1rem;border:none;min-width:110px;">Grado</th>
                                    <th style="color:white;font-size:.8rem;font-weight:600;padding:.75rem 1rem;border:none;min-width:130px;">Sección actual</th>
                                    <th style="color:white;font-size:.8rem;font-weight:600;padding:.75rem 1rem;border:none;min-width:260px;">Asignar sección</th>
                                    <th style="color:white;font-size:.8rem;font-weight:600;padding:.75rem 1rem;border:none;text-align:center;min-width:70px;">Modal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($matriculas as $matricula)
                                @php
                                    $gradoNorm    = \App\Http\Controllers\SeccionController::normalizarGrado($matricula->estudiante->grado);
                                    $secsDelGrado = $seccionesPorGrado[$gradoNorm] ?? collect();
                                    $iniciales    = strtoupper(
                                        substr($matricula->estudiante->nombre1   ?? 'N', 0, 1) .
                                        substr($matricula->estudiante->apellido1 ?? 'A', 0, 1)
                                    );
                                @endphp
                                <tr style="border-bottom:1px solid #f0f4f8;">

                                    {{-- Código: nunca se rompe en múltiples líneas --}}
                                    <td style="padding:.65rem 1rem;white-space:nowrap;">
                                        <span style="background:#eef2f7;color:#003b73;border:1px solid #d0dce8;padding:4px 8px;border-radius:6px;font-size:.76rem;font-weight:600;font-family:monospace;display:inline-block;">
                                            {{ $matricula->codigo_matricula }}
                                        </span>
                                    </td>

                                    {{-- Alumno --}}
                                    <td style="padding:.65rem 1rem;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#00508f,#003b73);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:.82rem;flex-shrink:0;border:2px solid #4ec7d2;">
                                                {{ $iniciales }}
                                            </div>
                                            <div>
                                                <div style="font-weight:600;color:#003b73;font-size:.88rem;">
                                                    {{ $matricula->estudiante->nombre1 }}
                                                    {{ $matricula->estudiante->nombre2 }}
                                                    {{ $matricula->estudiante->apellido1 }}
                                                    {{ $matricula->estudiante->apellido2 }}
                                                </div>
                                                <small class="text-muted" style="font-size:.74rem;">
                                                    <i class="fas fa-id-card me-1"></i>{{ $matricula->estudiante->dni }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Grado --}}
                                    <td style="padding:.65rem 1rem;white-space:nowrap;">
                                        <span style="background:#e0f2fe;color:#0369a1;border:1px solid #7dd3fc;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;white-space:nowrap;">
                                            {{ $matricula->estudiante->grado }}
                                        </span>
                                    </td>

                                    {{-- Sección actual: nunca se parte en dos líneas --}}
                                    <td style="padding:.65rem 1rem;white-space:nowrap;">
                                        @if($matricula->seccion)
                                            <span style="background:#dcfce7;color:#15803d;border:1px solid #86efac;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;white-space:nowrap;display:inline-block;">
                                                <i class="fas fa-chalkboard me-1"></i>{{ $matricula->seccion->grado }} — {{ $matricula->seccion->nombre }}
                                            </span>
                                        @else
                                            <span style="background:#fef9c3;color:#a16207;border:1px solid #fde047;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;white-space:nowrap;display:inline-flex;align-items:center;gap:4px;">
                                                <i class="fas fa-exclamation-triangle" style="font-size:.7rem;"></i>Sin asignar
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Asignar inline --}}
                                    <td style="padding:.65rem 1rem;">
                                        <form action="{{ route('secciones.asignar') }}" method="POST"
                                              class="d-flex align-items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="matricula_id" value="{{ $matricula->id }}">
                                            <select name="seccion_id"
                                                    class="form-select form-select-sm"
                                                    style="min-width:195px;border-radius:8px;border:1.5px solid #d0dce8;font-size:.8rem;">
                                                <option value="">— Elegir sección —</option>
                                                @foreach($secsDelGrado as $sec)
                                                    <option value="{{ $sec->id }}"
                                                        {{ $matricula->seccion_id == $sec->id ? 'selected' : '' }}>
                                                        {{ $sec->grado }} — Sección {{ $sec->nombre }}
                                                        ({{ $sec->cupo_disponible }} cupos)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                style="width:34px;height:34px;flex-shrink:0;border-radius:8px;background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                                                <i class="fas fa-save" style="font-size:.85rem;"></i>
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Botón modal --}}
                                    <td style="padding:.65rem 1rem;text-align:center;">
                                        <button type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalAsignar{{ $matricula->id }}"
                                                style="width:34px;height:34px;padding:0;border-radius:8px;border:1.5px solid #00508f;color:#00508f;background:white;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;">
                                            <i class="fas {{ $matricula->seccion ? 'fa-exchange-alt' : 'fa-user-check' }}" style="font-size:.85rem;"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal por fila --}}
                                <div class="modal fade" id="modalAsignar{{ $matricula->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
                                        <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 8px 32px rgba(0,0,0,0.15);">
                                            <div class="modal-header" style="background:linear-gradient(135deg,#4ec7d2,#00508f);border-radius:12px 12px 0 0;border:none;padding:.9rem 1.25rem;">
                                                <h5 class="modal-title text-white" style="font-size:.9rem;font-weight:600;">
                                                    <i class="fas fa-user-check me-2"></i>Asignar Sección
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('secciones.asignar') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="matricula_id" value="{{ $matricula->id }}">
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold" style="font-size:.82rem;color:#003b73;">Alumno</label>
                                                        <input type="text" class="form-control form-control-sm" disabled
                                                               style="border-radius:8px;background:#f8fafc;"
                                                               value="{{ $matricula->estudiante->nombre1 }} {{ $matricula->estudiante->apellido1 }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold" style="font-size:.82rem;color:#003b73;">Grado</label>
                                                        <input type="text" class="form-control form-control-sm" disabled
                                                               style="border-radius:8px;background:#f8fafc;"
                                                               value="{{ $matricula->estudiante->grado }}">
                                                    </div>
                                                    <div class="mb-1">
                                                        <label class="form-label fw-semibold" style="font-size:.82rem;color:#003b73;">Sección *</label>
                                                        <select name="seccion_id" class="form-select form-select-sm" required
                                                                style="border-radius:8px;border:1.5px solid #d0dce8;">
                                                            <option value="">— Seleccione una sección —</option>
                                                            @foreach($secsDelGrado as $sec)
                                                                <option value="{{ $sec->id }}"
                                                                    {{ $matricula->seccion_id == $sec->id ? 'selected' : '' }}>
                                                                    {{ $sec->grado }} — Sección {{ $sec->nombre }}
                                                                    ({{ $sec->cupo_disponible }} cupos)
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if($secsDelGrado->isEmpty())
                                                        <small class="text-warning d-block mt-1">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            No hay secciones para "{{ $matricula->estudiante->grado }}".
                                                        </small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top:1px solid #e8edf3;padding:.9rem 1.25rem;gap:.5rem;">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal" style="border-radius:8px;">
                                                        <i class="fas fa-times me-1"></i>Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-sm"
                                                            style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;border-radius:8px;font-weight:600;padding:.4rem 1rem;">
                                                        <i class="fas fa-check me-1"></i>Confirmar
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

                    <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted">
                            Mostrando {{ $matriculas->firstItem() }}–{{ $matriculas->lastItem() }} de {{ $matriculas->total() }}
                        </small>
                        {{ $matriculas->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════════
             PESTAÑA 2 — ALUMNOS POR SECCIÓN
        ════════════════════════════════════════════════════════════════════ --}}
        <div class="tab-pane fade" id="tab-alumnos" role="tabpanel">
            <div class="card border-0 shadow-sm"
                 style="border-radius:0 12px 12px 12px;border-top:none;padding-top:.5rem;">
                <div class="card-body p-3">

                    @forelse($gradosSecciones as $grado => $seccionesGrupo)
                    <div class="mb-5">

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width:44px;height:44px;flex-shrink:0;background:linear-gradient(135deg,#00508f,#003b73);border-radius:11px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:1rem;box-shadow:0 4px 10px rgba(0,59,115,0.2);">
                                {{ substr($grado, 0, 1) }}
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold" style="color:#003b73;">Grado {{ $grado }}</h5>
                                <small class="text-muted">
                                    {{ $seccionesGrupo->sum(fn($s) => $s->matriculas->count()) }} alumno(s) · {{ $seccionesGrupo->count() }} sección(es)
                                </small>
                            </div>
                            <hr class="flex-grow-1 ms-2" style="border-color:#d0dce8;">
                        </div>

                        <div class="row g-3">
                            @foreach($seccionesGrupo as $seccion)
                            @php
                                $pct      = $seccion->capacidad > 0 ? min(($seccion->matriculas->count() / $seccion->capacidad) * 100, 100) : 0;
                                $barColor = $pct >= 100 ? '#dc2626' : ($pct >= 80 ? '#d97706' : '#2563eb');
                                $gradoNormSec      = \App\Http\Controllers\SeccionController::normalizarGrado($grado);
                                $alumnosSinSeccion = $matriculasSinSeccionPorGrado[$gradoNormSec] ?? collect();
                            @endphp
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100"
                                     style="border-radius:12px;overflow:hidden;transition:transform .2s,box-shadow .2s;"
                                     onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(0,59,115,0.12)'"
                                     onmouseout="this.style.transform='';this.style.boxShadow=''">

                                    <div style="background:linear-gradient(135deg,#4ec7d2,#00508f);padding:.75rem 1rem;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="mb-0 text-white fw-bold" style="font-size:.9rem;">
                                                <i class="fas fa-chalkboard me-2"></i>Sección {{ $seccion->nombre }}
                                            </h6>
                                            <div class="d-flex gap-2 align-items-center">
                                                <span style="background:rgba(255,255,255,.2);color:white;font-size:.7rem;font-weight:600;padding:2px 8px;border-radius:20px;">
                                                    {{ $seccion->matriculas->count() }}/{{ $seccion->capacidad }}
                                                </span>
                                                @if($seccion->cupo_disponible > 0)
                                                    <span style="background:rgba(40,167,69,.85);color:white;font-size:.68rem;font-weight:600;padding:2px 7px;border-radius:20px;">
                                                        {{ $seccion->cupo_disponible }} libre(s)
                                                    </span>
                                                @else
                                                    <span style="background:rgba(220,53,69,.85);color:white;font-size:.68rem;font-weight:600;padding:2px 7px;border-radius:20px;">
                                                        Llena
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="background:rgba(255,255,255,.2);border-radius:4px;height:4px;margin-top:.5rem;">
                                            <div style="width:{{ $pct }}%;height:100%;border-radius:4px;background:{{ $barColor }};transition:width .4s;"></div>
                                        </div>
                                    </div>

                                    <div style="max-height:260px;overflow-y:auto;">
                                        @forelse($seccion->matriculas as $mat)
                                        @php $ini = strtoupper(substr($mat->estudiante->nombre1 ?? 'N', 0, 1) . substr($mat->estudiante->apellido1 ?? 'A', 0, 1)); @endphp
                                        <div class="d-flex align-items-center gap-2 px-3 py-2"
                                             style="border-bottom:1px solid #f0f4f8;transition:background .15s;"
                                             onmouseover="this.style.background='#f0f8ff'"
                                             onmouseout="this.style.background=''">
                                            <div style="width:30px;height:30px;flex-shrink:0;border-radius:7px;background:linear-gradient(135deg,#4ec7d2,#00508f);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:.72rem;">
                                                {{ $ini }}
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-0 fw-semibold text-truncate" style="color:#003b73;font-size:.83rem;">
                                                    {{ $mat->estudiante->nombre1 }}
                                                    {{ $mat->estudiante->nombre2 }}
                                                    {{ $mat->estudiante->apellido1 }}
                                                    {{ $mat->estudiante->apellido2 }}
                                                </p>
                                                <small class="text-muted" style="font-size:.7rem;">
                                                    <i class="fas fa-id-card me-1"></i>{{ $mat->estudiante->dni ?? 'Sin DNI' }}
                                                </small>
                                            </div>
                                            <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                @if($mat->estado === 'aprobada')
                                                    <i class="fas fa-check-circle text-success" style="font-size:.8rem;" title="Aprobada"></i>
                                                @elseif($mat->estado === 'pendiente')
                                                    <i class="fas fa-clock text-warning" style="font-size:.8rem;" title="Pendiente"></i>
                                                @else
                                                    <i class="fas fa-times-circle text-danger" style="font-size:.8rem;" title="Rechazada"></i>
                                                @endif
                                                <form action="{{ route('secciones.quitar') }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Quitar a este alumno de la sección {{ $seccion->nombre }}?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="matricula_id" value="{{ $mat->id }}">
                                                    <button type="submit"
                                                        style="width:22px;height:22px;border-radius:5px;padding:0;background:rgba(220,53,69,.08);border:1px solid rgba(220,53,69,.25);color:#dc3545;font-size:.62rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;"
                                                        onmouseover="this.style.background='#dc3545';this.style.color='white'"
                                                        onmouseout="this.style.background='rgba(220,53,69,.08)';this.style.color='#dc3545'"
                                                        title="Quitar de sección">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="text-center py-4">
                                            <i class="fas fa-user-slash mb-2 d-block" style="font-size:1.4rem;color:#cbd5e1;"></i>
                                            <p class="text-muted mb-0 small">Sin alumnos asignados</p>
                                        </div>
                                        @endforelse
                                    </div>

                                    <div style="background:#f8fafc;border-top:1px solid #e8f0f8;padding:.6rem .85rem;">
                                        @if($seccion->cupo_disponible > 0)
                                        <form action="{{ route('secciones.asignar') }}" method="POST"
                                              class="d-flex gap-2 align-items-center">
                                            @csrf
                                            <input type="hidden" name="seccion_id" value="{{ $seccion->id }}">
                                            <select name="matricula_id"
                                                    class="form-select form-select-sm flex-grow-1"
                                                    style="border-radius:7px;border:1.5px solid #d0dce8;font-size:.77rem;">
                                                <option value="">— Agregar alumno —</option>
                                                @foreach($alumnosSinSeccion as $m)
                                                    <option value="{{ $m->id }}">
                                                        {{ $m->estudiante->nombre1 }} {{ $m->estudiante->apellido1 }}
                                                        ({{ $m->estudiante->dni }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                style="width:30px;height:30px;flex-shrink:0;border-radius:7px;background:linear-gradient(135deg,#4ec7d2,#00508f);border:none;color:white;font-size:.78rem;cursor:pointer;display:flex;align-items:center;justify-content:center;"
                                                title="Asignar">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                        @else
                                        <p class="text-center mb-0" style="font-size:.78rem;color:#dc3545;font-weight:600;">
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
                        <i class="fas fa-school fa-3x mb-3 d-block" style="color:#bfd9ea;"></i>
                        <p class="mb-1">No hay secciones creadas.</p>
                        <a href="{{ route('secciones.create') }}"
                           class="btn btn-sm mt-2"
                           style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border-radius:8px;">
                            <i class="fas fa-plus me-1"></i>Crear primera sección
                        </a>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>{{-- /tab-content --}}
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tab = new URLSearchParams(window.location.search).get('tab');
    if (tab === 'alumnos') {
        const btn = document.getElementById('tab-alumnos-btn');
        if (btn) new bootstrap.Tab(btn).show();
    }
});
</script>
@endpush

@endsection