@extends('layouts.app')

@section('title', 'Inscripciones')
@section('page-title', 'Gestión de Inscripciones')

@section('topbar-actions')
    <button type="button" class="sec-btn-new"
            data-bs-toggle="modal" data-bs-target="#nuevaInscripcionModal">
        <i class="fas fa-plus"></i> Nueva Asignación
    </button>
@endsection

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    .sec-wrap { font-family: 'Inter', sans-serif; }

    /* Topbar */
    .sec-btn-new {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        color: white; padding: .5rem 1.2rem; border-radius: 8px; font-weight: 600;
        display: inline-flex; align-items: center; gap: .5rem; border: none;
        box-shadow: 0 2px 8px rgba(78,199,210,.3); font-size: .9rem; cursor: pointer; transition: all .2s;
    }
    .sec-btn-new:hover { transform: translateY(-2px); box-shadow: 0 4px 14px rgba(78,199,210,.45); }

    /* Stats */
    .sec-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 1.25rem; }
    @media(max-width:768px){ .sec-stats { grid-template-columns: 1fr; } }

    .sec-stat {
        background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;
        padding: 1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }
    .sec-stat-icon { width: 46px; height: 46px; border-radius: 11px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; }
    .sec-stat-icon i { font-size: 1.15rem; color: #fff; }
    .sec-stat-lbl { font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: #94a3b8; margin-bottom: .15rem; }
    .sec-stat-num { font-size: 1.6rem; font-weight: 700; color: #0f172a; line-height: 1; }

    /* Filtros card */
    .sec-filter-card {
        background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,.05); padding: 1rem 1.25rem; margin-bottom: 1.25rem;
    }
    .sec-input, .sec-select {
        border: 2px solid #bfd9ea; border-radius: 8px; padding: .4rem .8rem;
        font-size: .88rem; color: #1e293b; background: white; transition: border-color .2s;
        font-family: 'Inter', sans-serif; width: 100%;
    }
    .sec-input:focus, .sec-select:focus { border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.12); outline: none; }
    .sec-filter-label { font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .5px; color: #003b73; margin-bottom: .35rem; display: block; }
    .sec-btn-filter {
        background: linear-gradient(135deg, #4ec7d2, #00508f); color: white;
        border: none; border-radius: 8px; padding: .45rem 1rem; font-weight: 600;
        font-size: .88rem; cursor: pointer; display: inline-flex; align-items: center; gap: .4rem;
        white-space: nowrap; transition: opacity .15s; width: 100%;
        justify-content: center;
    }
    .sec-btn-filter:hover { opacity: .88; }
    .sec-btn-clear {
        border: 1.5px solid #e2e8f0; color: #6b7280; background: white;
        border-radius: 8px; padding: .35rem .9rem; font-size: .82rem; font-weight: 500;
        text-decoration: none; display: inline-flex; align-items: center; gap: .4rem;
    }
    .sec-btn-clear:hover { border-color: #4ec7d2; color: #00508f; }

    /* Lista */
    .sec-card {
        background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: .6rem;
        transition: transform .18s, box-shadow .18s;
    }
    .sec-card:hover { transform: translateY(-2px); box-shadow: 0 4px 14px rgba(0,59,115,.1); }
    .sec-card-body { padding: .85rem 1.25rem; }

    .sec-avatar {
        width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
        background: linear-gradient(135deg, #00508f, #003b73);
        display: flex; align-items: center; justify-content: center;
        border: 2px solid #4ec7d2; font-weight: 700; color: white; font-size: .95rem;
    }
    .sec-name { font-weight: 600; color: #003b73; font-size: .9rem; }
    .sec-sub  { font-size: .73rem; color: #94a3b8; margin-top: .1rem; }

    .sec-badge-sec  { background: rgba(78,199,210,.12); color: #00508f; border: 1px solid #4ec7d2;
        border-radius: 20px; padding: .28rem .7rem; font-size: .75rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: .3rem; }
    .sec-badge-pend { background: rgba(255,193,7,.12); color: #b45309; border: 1px solid #ffc107;
        border-radius: 20px; padding: .28rem .7rem; font-size: .75rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: .3rem; }
    .sec-badge-ok   { background: rgba(16,185,129,.1); color: #065f46; border: 1px solid #6ee7b7;
        border-radius: 20px; padding: .28rem .7rem; font-size: .75rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: .3rem; }

    .sec-date  { font-size: .8rem; color: #003b73; }
    .sec-code  { font-size: .72rem; color: #94a3b8; margin-top: .1rem; }

    .sec-btn-assign {
        border: 1.5px solid #4ec7d2; color: #00508f; background: white;
        border-radius: 7px; padding: .32rem .7rem; font-size: .8rem;
        cursor: pointer; display: inline-flex; align-items: center; gap: .3rem; transition: all .15s;
    }
    .sec-btn-assign:hover { background: #00508f; color: white; border-color: #00508f; }
    .sec-btn-assign.assigned { border-color: #00508f; }

    /* Empty */
    .sec-empty { text-align: center; padding: 3.5rem 1rem; }
    .sec-empty i { font-size: 3rem; color: #c3d9ee; margin-bottom: 1rem; display: block; }
    .sec-empty h5 { color: #003b73; margin-bottom: .5rem; }
    .sec-empty p { color: #6b7280; font-size: .9rem; }

    /* Paginación */
    .sec-pag-footer {
        padding: .85rem 1.25rem; border-top: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: space-between;
        background: #fafafa; flex-wrap: wrap; gap: .5rem;
        border-radius: 0 0 12px 12px;
    }
    .sec-pag-info { font-size: .78rem; color: #94a3b8; }
    .pagination { margin: 0; gap: 3px; display: flex; }
    .pagination .page-link {
        border-radius: 7px; padding: .3rem .65rem; font-size: .78rem; font-weight: 500;
        border: 1px solid #e2e8f0; color: #00508f; transition: all .15s; line-height: 1.4;
    }
    .pagination .page-link:hover { background: #e8f8f9; border-color: #4ec7d2; }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4ec7d2, #00508f);
        border-color: #4ec7d2; color: #fff;
    }
    .pagination .page-item.disabled .page-link { opacity: .45; }

    /* Modales */
    .sec-modal-header {
        background: linear-gradient(135deg, #4ec7d2, #00508f);
        border-radius: 12px 12px 0 0; border: none; padding: 1rem 1.5rem;
    }
    .sec-modal-label { font-size: .78rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .5px; color: #003b73; margin-bottom: .4rem; display: block; }
    .sec-modal-input, .sec-modal-select {
        width: 100%; border: 2px solid #bfd9ea; border-radius: 8px;
        padding: .45rem .85rem; font-size: .92rem; color: #1e293b;
        background: white; font-family: 'Inter', sans-serif;
    }
    .sec-modal-input:focus, .sec-modal-select:focus {
        border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.15); outline: none;
    }
    .sec-modal-input:disabled { background: #f8fafc; }
</style>
@endpush

@section('content')
<div class="sec-wrap container-fluid px-4">

    {{-- Error alert (success lo maneja el layout) --}}
    @if(session('error'))
        <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;color:#991b1b;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" onclick="this.parentElement.remove()"
                    style="margin-left:auto;background:none;border:none;color:#991b1b;font-size:1.2rem;cursor:pointer;line-height:1;">&times;</button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="sec-stats">
        <div class="sec-stat">
            <div class="sec-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <div class="sec-stat-lbl">Total Inscripciones</div>
                <div class="sec-stat-num">{{ $inscripciones->total() }}</div>
            </div>
        </div>
        <div class="sec-stat">
            <div class="sec-stat-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="sec-stat-lbl">Con Sección</div>
                <div class="sec-stat-num" style="color:#059669;">{{ \App\Models\Matricula::whereNotNull('seccion_id')->count() }}</div>
            </div>
        </div>
        <div class="sec-stat">
            <div class="sec-stat-icon" style="background:linear-gradient(135deg,#fbbf24,#f59e0b);">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="sec-stat-lbl">Sin Asignar</div>
                <div class="sec-stat-num" style="color:#b45309;">{{ \App\Models\Matricula::whereNull('seccion_id')->count() }}</div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="sec-filter-card">
        <form action="{{ request()->url() }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="sec-filter-label"><i class="fas fa-search me-1"></i> Buscar alumno</label>
                    <input type="text" name="buscar" class="sec-input"
                           placeholder="Nombre del alumno..."
                           value="{{ request('buscar') }}">
                </div>
                <div class="col-md-3">
                    <label class="sec-filter-label"><i class="fas fa-filter me-1"></i> Estado</label>
                    <select name="estado" class="sec-select">
                        <option value="">Todos</option>
                        <option value="asignada"    {{ request('estado')==='asignada'    ? 'selected' : '' }}>Con sección</option>
                        <option value="sin_asignar" {{ request('estado')==='sin_asignar' ? 'selected' : '' }}>Sin asignar</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="sec-btn-filter">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
                @if(request('buscar') || request('estado'))
                <div class="col-md-2">
                    <a href="{{ request()->url() }}" class="sec-btn-clear">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
                @endif
            </div>
        </form>
    </div>

    {{-- Lista --}}
    <div class="sec-list-wrap">
        @forelse($inscripciones as $inscripcion)
            @php $estudiante = $inscripcion->estudiante; @endphp
            @if(!$estudiante) @continue @endif

            <div class="sec-card">
                <div class="sec-card-body">
                    <div class="row align-items-center g-2">

                        {{-- Avatar + nombre --}}
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="sec-avatar">
                                    {{ strtoupper(substr($estudiante->nombre1 ?? 'N', 0, 1) . substr($estudiante->apellido1 ?? 'A', 0, 1)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <div class="sec-name text-truncate">
                                        {{ trim(($estudiante->nombre1 ?? '') . ' ' . ($estudiante->nombre2 ?? '') . ' ' . ($estudiante->apellido1 ?? '') . ' ' . ($estudiante->apellido2 ?? '')) }}
                                    </div>
                                    <div class="sec-sub">
                                        <i class="fas fa-envelope me-1"></i>{{ $estudiante->email ?? 'Sin email' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección --}}
                        <div class="col-lg-3">
                            @if($inscripcion->seccion)
                                <span class="sec-badge-sec">
                                    <i class="fas fa-chalkboard"></i> {{ $inscripcion->seccion->nombre }}
                                </span>
                                <div class="sec-sub mt-1">
                                    <i class="fas fa-users me-1"></i>Cap: {{ $inscripcion->seccion->capacidad }}
                                </div>
                            @else
                                <span class="sec-badge-pend">
                                    <i class="fas fa-exclamation-triangle"></i> Sin asignar
                                </span>
                            @endif
                        </div>

                        {{-- Fecha / código --}}
                        <div class="col-lg-3">
                            <div class="sec-date">
                                <i class="fas fa-calendar-alt text-muted me-1"></i>
                                {{ $inscripcion->fecha_matricula ? \Carbon\Carbon::parse($inscripcion->fecha_matricula)->format('d/m/Y') : '—' }}
                            </div>
                            <div class="sec-code">Código: {{ $inscripcion->codigo_matricula }}</div>
                        </div>

                        {{-- Estado + botón --}}
                        <div class="col-lg-2">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                @if($inscripcion->seccion)
                                    <span class="sec-badge-ok"><i class="fas fa-check-circle"></i> Asignada</span>
                                @else
                                    <span class="sec-badge-pend"><i class="fas fa-clock"></i> Pendiente</span>
                                @endif
                                <button type="button"
                                        class="sec-btn-assign {{ $inscripcion->seccion ? 'assigned' : '' }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalAsignar{{ $inscripcion->id }}"
                                        title="{{ $inscripcion->seccion ? 'Cambiar sección' : 'Asignar sección' }}">
                                    <i class="fas {{ $inscripcion->seccion ? 'fa-exchange-alt' : 'fa-user-check' }}"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Modal asignar sección --}}
            <div class="modal fade" id="modalAsignar{{ $inscripcion->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 4px 20px rgba(0,0,0,.15);">
                        <div class="modal-header sec-modal-header">
                            <h5 class="modal-title text-white fw-700">
                                <i class="fas fa-user-check me-2"></i>Asignar Sección
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('secciones.asignar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="sec-modal-label"><i class="fas fa-user me-1"></i> Alumno</label>
                                    <input type="text" class="sec-modal-input"
                                           value="{{ trim(($estudiante->nombre1 ?? '') . ' ' . ($estudiante->apellido1 ?? '')) }}"
                                           disabled>
                                </div>
                                <div class="mb-1">
                                    <label class="sec-modal-label"><i class="fas fa-chalkboard me-1"></i> Sección <span style="color:#ef4444;">*</span></label>
                                    <select name="seccion_id" class="sec-modal-select" required>
                                        <option value="">— Seleccione una sección —</option>
                                        @foreach($secciones as $s)
                                            <option value="{{ $s->id }}" {{ $inscripcion->seccion_id == $s->id ? 'selected' : '' }}>
                                                {{ $s->nombre }} (Cap: {{ $s->capacidad }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:1px solid #f1f5f9;padding:.85rem 1.5rem;justify-content:space-between;">
                                <button type="button" class="btn btn-sm" data-bs-dismiss="modal"
                                        style="border:2px solid #ef4444;color:#ef4444;background:white;border-radius:8px;padding:.4rem 1.1rem;font-weight:600;">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </button>
                                <button type="submit" class="btn btn-sm"
                                        style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;border-radius:8px;padding:.4rem 1.1rem;font-weight:600;">
                                    <i class="fas fa-check me-1"></i> Confirmar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @empty
            <div class="sec-card">
                <div class="sec-empty">
                    <i class="fas fa-clipboard-list"></i>
                    <h5>No hay inscripciones registradas</h5>
                    <p>
                        @if(request('buscar') || request('estado'))
                            No se encontraron resultados con los filtros aplicados.
                        @else
                            Comienza asignando secciones a los alumnos con matrícula aprobada.
                        @endif
                    </p>
                </div>
            </div>
        @endforelse

        {{-- Paginación --}}
        @if($inscripciones->hasPages())
            <div class="sec-pag-footer" style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;margin-top:.5rem;">
                <span class="sec-pag-info">
                    Mostrando {{ $inscripciones->firstItem() }}–{{ $inscripciones->lastItem() }} de {{ $inscripciones->total() }} inscripciones
                </span>
                {{ $inscripciones->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Modal nueva asignación --}}
<div class="modal fade" id="nuevaInscripcionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 4px 20px rgba(0,0,0,.15);">
            <div class="modal-header sec-modal-header">
                <h5 class="modal-title text-white fw-700">
                    <i class="fas fa-plus-circle me-2"></i>Nueva Asignación de Sección
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('secciones.asignar') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="sec-modal-label"><i class="fas fa-user me-1"></i> Alumno <span style="color:#ef4444;">*</span></label>
                        <select name="estudiante_id" class="sec-modal-select" required>
                            <option value="">— Seleccione un alumno —</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}">
                                    {{ trim(($alumno->nombre1 ?? '') . ' ' . ($alumno->nombre2 ?? '') . ' ' . ($alumno->apellido1 ?? '') . ' ' . ($alumno->apellido2 ?? '')) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="sec-modal-label"><i class="fas fa-chalkboard me-1"></i> Sección <span style="color:#ef4444;">*</span></label>
                        <select name="seccion_id" class="sec-modal-select" required>
                            <option value="">— Seleccione una sección —</option>
                            @foreach($secciones as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }} (Cap: {{ $s->capacidad }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f1f5f9;padding:.85rem 1.5rem;justify-content:space-between;">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal"
                            style="border:2px solid #ef4444;color:#ef4444;background:white;border-radius:8px;padding:.4rem 1.1rem;font-weight:600;">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-sm"
                            style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;border-radius:8px;padding:.4rem 1.1rem;font-weight:600;">
                        <i class="fas fa-check me-1"></i> Confirmar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
