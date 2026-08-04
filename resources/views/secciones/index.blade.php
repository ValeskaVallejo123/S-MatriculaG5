@extends('layouts.app')

@section('title', 'Inscripciones')
@section('page-title', 'Gestión de Inscripciones')

@section('topbar-actions')
    <button type="button" class="sec-topbar-btn"
            data-bs-toggle="modal" data-bs-target="#nuevaInscripcionModal">
        <i class="fas fa-plus"></i>
        <span class="sec-btn-text">Nueva Asignación</span>
    </button>
@endsection

@push('styles')
<style>
    .sec-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        font-weight: 600; font-size: .83rem; border: none; cursor: pointer;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap; transition: opacity .15s;
    }
    .sec-topbar-btn:hover { opacity: .88; color: white; }
    @media(max-width:600px) {
        .sec-btn-text { display: none; }
        .sec-topbar-btn { padding: .5rem .65rem; }
    }

    :root {
        --blue-dark: #003b73; --blue-mid: #00508f;
        --teal: #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border: #e8edf4; --surface: #f5f8fc;
        --text-main: #0d2137; --text-muted: #6b7a90;
        --green: #10b981; --amber: #f59e0b; --red: #ef4444;
        --radius-lg: 14px; --radius-sm: 7px;
        --shadow-sm: 0 1px 4px rgba(0,59,115,0.07);
        --shadow-md: 0 4px 16px rgba(0,59,115,0.10);
    }

    /* Stats */
    .sec-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 1.5rem; }
    @media(max-width:768px){ .sec-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .sec-stats { grid-template-columns: 1fr; } }

    .sec-stat {
        background: white; border-radius: var(--radius-lg); border: 1px solid var(--border);
        padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .sec-stat::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; border-radius: 4px 0 0 4px; }
    .ss-total::before { background: var(--teal); }
    .ss-con::before   { background: var(--green); }
    .ss-sin::before   { background: var(--amber); }
    .sec-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .sec-stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.15rem; }
    .ss-total .sec-stat-icon { background: var(--teal-light); color: var(--teal); }
    .ss-con   .sec-stat-icon { background: rgba(16,185,129,.12); color: var(--green); }
    .ss-sin   .sec-stat-icon { background: rgba(245,158,11,.12); color: var(--amber); }

    .sec-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .sec-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .sec-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* Filtros */
    .sec-filter-card { background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: .9rem 1.25rem; margin-bottom: 1.25rem; box-shadow: var(--shadow-sm); }
    .sec-filter-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--blue-dark); margin-bottom: .35rem; display: block; }
    .sec-input, .sec-select { width: 100%; border: 2px solid #bfd9ea; border-radius: 8px; padding: .45rem .8rem; font-size: .88rem; color: var(--text-main); background: white; font-family: inherit; outline: none; transition: border-color .2s; }
    .sec-input:focus, .sec-select:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.12); }
    .sec-btn-filter { background: linear-gradient(135deg, var(--teal), var(--blue-mid)); color: white; border: none; border-radius: 8px; padding: .47rem 1rem; font-weight: 600; font-size: .88rem; cursor: pointer; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: .4rem; font-family: inherit; transition: opacity .15s; }
    .sec-btn-filter:hover { opacity: .88; }
    .sec-btn-clear { border: 1.5px solid var(--border); color: var(--text-muted); background: white; border-radius: 8px; padding: .4rem .9rem; font-size: .82rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: .4rem; width: 100%; justify-content: center; transition: all .15s; }
    .sec-btn-clear:hover { border-color: var(--teal); color: var(--blue-mid); }

    /* Cards lista */
    .sec-card { background: white; border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-sm); margin-bottom: .6rem; transition: transform .18s, box-shadow .18s; }
    .sec-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
    .sec-card-body { padding: .9rem 1.25rem; }

    .sec-avatar { width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0; background: linear-gradient(135deg, var(--teal), var(--blue-mid)); display: flex; align-items: center; justify-content: center; border: 2px solid rgba(78,199,210,.3); font-weight: 700; color: white; font-size: .95rem; }
    .sec-name { font-weight: 600; color: var(--blue-dark); font-size: .9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sec-sub  { font-size: .73rem; color: var(--text-muted); margin-top: .1rem; }
    .sec-date { font-size: .8rem; color: var(--blue-dark); font-weight: 500; }
    .sec-code { font-size: .72rem; color: var(--text-muted); margin-top: .1rem; }

    .bpill { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 999px; font-size: .73rem; font-weight: 600; }
    .b-teal  { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.4); }
    .b-amber { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }
    .b-green { background: rgba(16,185,129,.1); color: #065f46; border: 1px solid rgba(16,185,129,.35); }

    .btn-asignar { width: 32px; height: 32px; border-radius: 7px; display: inline-flex; align-items: center; justify-content: center; border: 1.5px solid var(--teal); color: var(--blue-mid); background: white; cursor: pointer; font-size: .8rem; transition: all .15s; }
    .btn-asignar:hover { background: var(--blue-mid); color: white; border-color: var(--blue-mid); transform: translateY(-1px); }
    .btn-asignar.asignado { border-color: var(--blue-mid); }

    /* Empty */
    .sec-empty { text-align: center; padding: 4rem 1rem; }
    .sec-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .sec-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .sec-empty p  { color: var(--text-muted); font-size: .85rem; margin: 0; }

    /* Paginación */
    .sec-pag-footer { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: .85rem 1.25rem; margin-top: .5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem; }
    .sec-pag-info { font-size: .78rem; color: var(--text-muted); }
    .pagination { margin: 0; }
    .pagination .page-link { border-radius: 7px; margin: 0 2px; border: 1.5px solid var(--border); color: var(--blue-mid); padding: .28rem .6rem; font-size: .82rem; transition: all .15s; }
    .pagination .page-link:hover { background: var(--teal-light); border-color: var(--teal); }
    .pagination .page-item.active .page-link { background: linear-gradient(135deg, var(--teal), var(--blue-mid)); border-color: var(--teal); color: white; }
    .pagination .page-item.disabled .page-link { opacity: .45; }

    /* Modales */
    .sec-modal-header { background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid)); border-radius: 12px 12px 0 0; border: none; padding: 1rem 1.5rem; }
    .sec-modal-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--blue-dark); margin-bottom: .4rem; display: block; }
    .sec-modal-input, .sec-modal-select { width: 100%; border: 2px solid #bfd9ea; border-radius: 8px; padding: .48rem .85rem; font-size: .92rem; color: var(--text-main); background: white; font-family: inherit; outline: none; transition: border-color .2s; }
    .sec-modal-input:focus, .sec-modal-select:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.12); }
    .sec-modal-input:disabled { background: var(--surface); }
    .btn-modal-cancel { border: 1.5px solid var(--red); color: var(--red); background: white; border-radius: 8px; padding: .4rem 1.1rem; font-weight: 600; font-size: .82rem; cursor: pointer; font-family: inherit; transition: all .15s; }
    .btn-modal-cancel:hover { background: var(--red); color: white; }
    .btn-modal-confirm { background: linear-gradient(135deg, var(--teal), var(--blue-mid)); color: white; border: none; border-radius: 8px; padding: .4rem 1.1rem; font-weight: 600; font-size: .82rem; cursor: pointer; font-family: inherit; transition: opacity .15s; }
    .btn-modal-confirm:hover { opacity: .88; }
</style>
@endpush

@section('content')
<div>

    @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;color:#991b1b;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;">
        <i class="fas fa-exclamation-triangle"></i>
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#991b1b;font-size:1.2rem;cursor:pointer;">&times;</button>
    </div>
    @endif

    {{-- ── STATS ── --}}
    <div class="sec-stats">
        <div class="sec-stat ss-total">
            <div class="sec-stat-icon"><i class="fas fa-clipboard-check"></i></div>
            <div>
                <div class="sec-stat-lbl">Total</div>
                <div class="sec-stat-num">{{ $inscripciones->total() }}</div>
                <div class="sec-stat-sub">Inscripciones</div>
            </div>
        </div>
        <div class="sec-stat ss-con">
            <div class="sec-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="sec-stat-lbl">Con Sección</div>
                <div class="sec-stat-num">{{ \App\Models\Matricula::whereNotNull('seccion_id')->count() }}</div>
                <div class="sec-stat-sub">Asignadas</div>
            </div>
        </div>
        <div class="sec-stat ss-sin">
            <div class="sec-stat-icon"><i class="fas fa-clock"></i></div>
            <div>
                <div class="sec-stat-lbl">Sin Asignar</div>
                <div class="sec-stat-num">{{ \App\Models\Matricula::whereNull('seccion_id')->count() }}</div>
                <div class="sec-stat-sub">Pendientes</div>
            </div>
        </div>
    </div>

    {{-- ── FILTROS ── --}}
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

    {{-- ── LISTA ── --}}
    <div>
        @forelse($inscripciones as $inscripcion)
            @php $estudiante = $inscripcion->estudiante; @endphp
            @if(!$estudiante) @continue @endif

            <div class="sec-card">
                <div class="sec-card-body">
                    <div class="row align-items-center g-2">

                        <div class="col-lg-4">
                            <div style="display:flex;align-items:center;gap:.75rem;">
                                <div class="sec-avatar">
                                    {{ strtoupper(substr($estudiante->nombre1 ?? 'N', 0, 1) . substr($estudiante->apellido1 ?? 'A', 0, 1)) }}
                                </div>
                                <div style="overflow:hidden;min-width:0;">
                                    <div class="sec-name">
                                        {{ trim(($estudiante->nombre1 ?? '') . ' ' . ($estudiante->nombre2 ?? '') . ' ' . ($estudiante->apellido1 ?? '') . ' ' . ($estudiante->apellido2 ?? '')) }}
                                    </div>
                                    <div class="sec-sub">
                                        <i class="fas fa-envelope" style="font-size:.65rem;"></i>
                                        {{ $estudiante->email ?? 'Sin email' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            @if($inscripcion->seccion)
                                <span class="bpill b-teal">
                                    <i class="fas fa-chalkboard" style="font-size:.65rem;"></i>
                                    {{ $inscripcion->seccion->nombre }}
                                </span>
                                <div class="sec-sub mt-1">
                                    <i class="fas fa-users" style="font-size:.65rem;"></i>
                                    Cap: {{ $inscripcion->seccion->capacidad }}
                                </div>
                            @else
                                <span class="bpill b-amber">
                                    <i class="fas fa-exclamation-triangle" style="font-size:.65rem;"></i>
                                    Sin asignar
                                </span>
                            @endif
                        </div>

                        <div class="col-lg-3">
                            <div class="sec-date">
                                <i class="fas fa-calendar-alt" style="color:var(--text-muted);font-size:.75rem;margin-right:.3rem;"></i>
                                {{ $inscripcion->fecha_matricula ? \Carbon\Carbon::parse($inscripcion->fecha_matricula)->format('d/m/Y') : '—' }}
                            </div>
                            <div class="sec-code">Código: {{ $inscripcion->codigo_matricula }}</div>
                        </div>

                        <div class="col-lg-2">
                            <div style="display:flex;align-items:center;justify-content:flex-end;gap:.5rem;">
                                @if($inscripcion->seccion)
                                    <span class="bpill b-green">
                                        <i class="fas fa-check-circle" style="font-size:.65rem;"></i> Asignada
                                    </span>
                                @else
                                    <span class="bpill b-amber">
                                        <i class="fas fa-clock" style="font-size:.65rem;"></i> Pendiente
                                    </span>
                                @endif
                                <button type="button"
                                        class="btn-asignar {{ $inscripcion->seccion ? 'asignado' : '' }}"
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
                    <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 8px 30px rgba(0,0,0,.15);">
                        <div class="modal-header sec-modal-header">
                            <h5 class="modal-title text-white fw-bold">
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
                                <div>
                                    <label class="sec-modal-label">
                                        <i class="fas fa-chalkboard me-1"></i> Sección <span style="color:var(--red);">*</span>
                                    </label>
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
                            <div class="modal-footer" style="border-top:1px solid var(--border);padding:.85rem 1.5rem;justify-content:space-between;">
                                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </button>
                                <button type="submit" class="btn-modal-confirm">
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
                    <h6>No hay inscripciones registradas</h6>
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

        @if($inscripciones->hasPages())
            <div class="sec-pag-footer">
                <span class="sec-pag-info">
                    Mostrando {{ $inscripciones->firstItem() }}–{{ $inscripciones->lastItem() }}
                    de {{ $inscripciones->total() }} inscripciones
                </span>
                {{ $inscripciones->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Modal nueva asignación --}}
<div class="modal fade" id="nuevaInscripcionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 8px 30px rgba(0,0,0,.15);">
            <div class="modal-header sec-modal-header">
                <h5 class="modal-title text-white fw-bold">
                    <i class="fas fa-plus-circle me-2"></i>Nueva Asignación de Sección
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('secciones.asignar') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="sec-modal-label">
                            <i class="fas fa-user me-1"></i> Alumno <span style="color:var(--red);">*</span>
                        </label>
                        <select name="estudiante_id" class="sec-modal-select" required>
                            <option value="">— Seleccione un alumno —</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}">
                                    {{ trim(($alumno->nombre1 ?? '') . ' ' . ($alumno->nombre2 ?? '') . ' ' . ($alumno->apellido1 ?? '') . ' ' . ($alumno->apellido2 ?? '')) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="sec-modal-label">
                            <i class="fas fa-chalkboard me-1"></i> Sección <span style="color:var(--red);">*</span>
                        </label>
                        <select name="seccion_id" class="sec-modal-select" required>
                            <option value="">— Seleccione una sección —</option>
                            @foreach($secciones as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }} (Cap: {{ $s->capacidad }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid var(--border);padding:.85rem 1.5rem;justify-content:space-between;">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn-modal-confirm">
                        <i class="fas fa-check me-1"></i> Confirmar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection