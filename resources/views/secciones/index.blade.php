@extends('layouts.app')

@section('title', 'Inscripciones')
@section('page-title', 'Gestión de Inscripciones')
@section('content-class', 'p-0')

@push('styles')
<style>
.sec-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.sec-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.sec-hero-left { display: flex; align-items: center; gap: 1rem; }
.sec-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.sec-hero-icon i { font-size: 1.3rem; color: white; }
.sec-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.sec-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.sec-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 80px;
}
.sec-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.sec-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.sec-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s; cursor: pointer;
}
.sec-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Toolbar / filters */
.sec-toolbar {
    padding: .9rem 2rem;
    background: white;
    border-bottom: 1px solid #e8eef5;
    flex-shrink: 0;
}
.sec-input, .sec-select {
    border: 1.5px solid #e2e8f0; border-radius: 8px; padding: .42rem .8rem;
    font-size: .88rem; color: #1e293b; background: #f8fafc; transition: border-color .2s;
    width: 100%;
}
.sec-input:focus, .sec-select:focus { border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.12); outline: none; background: white; }
.sec-filter-label { font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .5px; color: #003b73; margin-bottom: .35rem; display: block; }
.sec-btn-filter {
    background: linear-gradient(135deg, #4ec7d2, #00508f); color: white;
    border: none; border-radius: 8px; padding: .45rem 1rem; font-weight: 600;
    font-size: .82rem; cursor: pointer; display: inline-flex; align-items: center; gap: .4rem;
    white-space: nowrap; width: 100%; justify-content: center; transition: opacity .15s;
}
.sec-btn-filter:hover { opacity: .88; }
.sec-btn-clear {
    border: 1.5px solid #e2e8f0; color: #6b7280; background: white;
    border-radius: 8px; padding: .35rem .9rem; font-size: .82rem; font-weight: 500;
    text-decoration: none; display: inline-flex; align-items: center; gap: .4rem;
}
.sec-btn-clear:hover { border-color: #4ec7d2; color: #00508f; }

/* Scrollable body */
.sec-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Cards */
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

/* Pagination */
.sec-pag {
    background: white; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: .75rem 1.25rem; margin-top: .5rem;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .5rem;
}
.pagination { margin: 0; }
.pagination .page-link {
    border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0;
    color: #00508f; font-size: .82rem; padding: .3rem .65rem; transition: all .2s;
}
.pagination .page-link:hover { background: #bfd9ea; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    border-color: #4ec7d2; color: white;
}

/* Modals */
.sec-modal-header {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border-radius: 12px 12px 0 0; border: none; padding: 1rem 1.5rem;
}
.sec-modal-label { font-size: .78rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .5px; color: #003b73; margin-bottom: .4rem; display: block; }
.sec-modal-input, .sec-modal-select {
    width: 100%; border: 2px solid #bfd9ea; border-radius: 8px;
    padding: .45rem .85rem; font-size: .92rem; color: #1e293b; background: white;
}
.sec-modal-input:focus, .sec-modal-select:focus {
    border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.15); outline: none;
}
.sec-modal-input:disabled { background: #f8fafc; }

/* Dark mode */
body.dark-mode .sec-wrap  { background: #0f172a; }
body.dark-mode .sec-toolbar { background: #1e293b; border-color: #334155; }
body.dark-mode .sec-input, body.dark-mode .sec-select { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .sec-card { background: #1e293b; border-color: #334155; }
body.dark-mode .sec-name { color: #e2e8f0; }
body.dark-mode .sec-pag { background: #1e293b; border-color: #334155; }
</style>
@endpush

@section('content')
<div class="sec-wrap">

    {{-- Hero --}}
    <div class="sec-hero">
        <div class="sec-hero-left">
            <div class="sec-hero-icon"><i class="fas fa-clipboard-check"></i></div>
            <div>
                <h2 class="sec-hero-title">Gestión de Inscripciones</h2>
                <p class="sec-hero-sub">Asigna secciones a los alumnos con matrícula aprobada</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="sec-stat">
                <div class="sec-stat-num">{{ $inscripciones->total() }}</div>
                <div class="sec-stat-lbl">Total</div>
            </div>
            <div class="sec-stat">
                <div class="sec-stat-num">{{ \App\Models\Matricula::whereNotNull('seccion_id')->count() }}</div>
                <div class="sec-stat-lbl">Con Sección</div>
            </div>
            <div class="sec-stat">
                <div class="sec-stat-num">{{ \App\Models\Matricula::whereNull('seccion_id')->count() }}</div>
                <div class="sec-stat-lbl">Sin Asignar</div>
            </div>
            <button type="button" class="sec-btn-new"
                    data-bs-toggle="modal" data-bs-target="#nuevaInscripcionModal">
                <i class="fas fa-plus"></i> Nueva Asignación
            </button>
        </div>
    </div>

    {{-- Toolbar / Filtros --}}
    <div class="sec-toolbar">
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

    {{-- Body --}}
    <div class="sec-body">

        {{-- Flash error --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 border-0 shadow-sm" role="alert"
                 style="border-radius:10px;border-left:4px solid #ef4444 !important;">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- List --}}
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
                <div class="sec-empty" style="text-align:center;padding:3.5rem 1rem;">
                    <i class="fas fa-clipboard-list fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                    <h5 style="color:#003b73;margin-bottom:.5rem;">No hay inscripciones registradas</h5>
                    <p style="color:#6b7280;font-size:.9rem;">
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
            <div class="sec-pag">
                <small class="text-muted">
                    Mostrando {{ $inscripciones->firstItem() }}–{{ $inscripciones->lastItem() }} de {{ $inscripciones->total() }} inscripciones
                </small>
                {{ $inscripciones->appends(request()->query())->links() }}
            </div>
        @endif

    </div>{{-- /sec-body --}}
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
