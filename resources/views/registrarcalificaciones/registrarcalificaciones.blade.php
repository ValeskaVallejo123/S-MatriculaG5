@extends('layouts.app')

@section('title', 'Registrar Calificaciones')
@section('page-title', 'Registrar Calificaciones')
@section('content-class', 'p-0')

@push('styles')
<style>
.rc-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.rc-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.rc-hero-left { display: flex; align-items: center; gap: 1rem; }
.rc-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.rc-hero-icon i { font-size: 1.3rem; color: white; }
.rc-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.rc-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.rc-btn-ver {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.rc-btn-ver:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Scrollable body */
.rc-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Cards */
.rc-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    border: 1px solid #e2e8f0;
    margin-bottom: 1.25rem;
    overflow: hidden;
}
.rc-card-header {
    background: #003b73;
    padding: .75rem 1.25rem;
    display: flex; align-items: center; gap: .5rem;
}
.rc-card-header-title {
    font-size: .88rem; font-weight: 700; color: white; margin: 0;
}
.rc-card-header i { color: #4ec7d2; font-size: .85rem; }
.rc-card-body { padding: 1.25rem; }

/* Form controls */
.rc-label {
    font-size: .78rem; font-weight: 700; color: #334155;
    text-transform: uppercase; letter-spacing: .04em;
    margin-bottom: .4rem; display: block;
}
.rc-select {
    width: 100%;
    padding: .5rem .85rem;
    border: 1.5px solid #bfd9ea; border-radius: 8px;
    font-size: .88rem; color: #334155; background: white;
    transition: border-color .2s;
}
.rc-select:focus { outline: none; border-color: #4ec7d2; }
.rc-input {
    width: 100%;
    padding: .45rem .75rem;
    border: 1.5px solid #bfd9ea; border-radius: 8px;
    font-size: .85rem; color: #334155;
    transition: border-color .2s;
}
.rc-input:focus { outline: none; border-color: #4ec7d2; }

/* Table */
.rc-tbl thead th {
    background: #003b73;
    color: white;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: .75rem 1rem;
    border: none;
}
.rc-tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.rc-tbl tbody tr:hover { background: rgba(78,199,210,.05); }
.rc-tbl tbody td { padding: .7rem 1rem; vertical-align: middle; font-size: .85rem; color: #334155; }
.rc-tbl tbody tr:last-child { border-bottom: none; }

/* Save button */
.rc-btn-save {
    display: inline-flex; align-items: center; gap: .4rem;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none; border-radius: 8px;
    padding: .55rem 1.4rem; font-size: .88rem; font-weight: 700;
    cursor: pointer; transition: opacity .2s;
    box-shadow: 0 2px 8px rgba(78,199,210,.3);
}
.rc-btn-save:hover { opacity: .9; }

/* Empty state */
.rc-empty {
    text-align: center; padding: 2.5rem 1rem;
    color: #94a3b8;
}
.rc-empty i { font-size: 2.5rem; display: block; margin-bottom: .6rem; color: #bfd9ea; }
.rc-empty p { font-size: .88rem; font-weight: 600; margin: 0; color: #64748b; }

/* Dark mode */
body.dark-mode .rc-wrap  { background: #0f172a; }
body.dark-mode .rc-card  { background: #1e293b; border-color: #334155; }
body.dark-mode .rc-card-body { background: #1e293b; }
body.dark-mode .rc-select { background: #0f172a; border-color: #334155; color: #cbd5e1; }
body.dark-mode .rc-input  { background: #0f172a; border-color: #334155; color: #cbd5e1; }
body.dark-mode .rc-tbl tbody td { color: #cbd5e1; }
body.dark-mode .rc-tbl tbody tr { border-color: #334155; }
body.dark-mode .rc-tbl tbody tr:hover { background: rgba(78,199,210,.07); }
body.dark-mode .rc-label { color: #94a3b8; }
</style>
@endpush

@section('content')
<div class="rc-wrap">

    {{-- Hero --}}
    <div class="rc-hero">
        <div class="rc-hero-left">
            <div class="rc-hero-icon"><i class="fas fa-clipboard-check"></i></div>
            <div>
                <h2 class="rc-hero-title">Registrar Calificaciones</h2>
                <p class="rc-hero-sub">Selecciona un curso y registra las notas de los estudiantes</p>
            </div>
        </div>
        <a href="{{ route('registrarcalificaciones.ver') }}" class="rc-btn-ver">
            <i class="fas fa-eye"></i> Ver Calificaciones
        </a>
    </div>

    {{-- Body --}}
    <div class="rc-body">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #ef4444 !important;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Seleccionar Curso --}}
        <div class="rc-card">
            <div class="rc-card-header">
                <i class="fas fa-chalkboard"></i>
                <h6 class="rc-card-header-title">Seleccionar Curso</h6>
            </div>
            <div class="rc-card-body">
                <form method="GET" action="{{ route('registrarcalificaciones.index') }}">
                    <label class="rc-label">Curso</label>
                    <select name="grado_id" class="rc-select" onchange="this.form.submit()" required>
                        <option value="">Seleccione un curso...</option>
                        @foreach($grados as $grado)
                            <option value="{{ $grado->id }}"
                                {{ request('grado_id') == $grado->id ? 'selected' : '' }}>
                                {{ $grado->numero }}° {{ ucfirst($grado->nivel) }}
                                — Sección {{ $grado->seccion }}
                                ({{ $grado->anio_lectivo }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        {{-- Formulario de calificaciones (solo si hay grado seleccionado) --}}
        @if(request()->filled('grado_id'))
            <form action="{{ route('registrarcalificaciones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="grado_id" value="{{ request('grado_id') }}">

                {{-- Información general --}}
                <div class="rc-card">
                    <div class="rc-card-header">
                        <i class="fas fa-cogs"></i>
                        <h6 class="rc-card-header-title">Información de la Calificación</h6>
                    </div>
                    <div class="rc-card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="rc-label">Profesor</label>
                                <select name="profesor_id" class="rc-select" required>
                                    <option value="">Seleccione profesor</option>
                                    @foreach($profesores as $profesor)
                                        <option value="{{ $profesor->id }}">
                                            {{ $profesor->apellido }}, {{ $profesor->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="rc-label">Materia</label>
                                <select name="materia_id" class="rc-select" required>
                                    <option value="">Seleccione materia</option>
                                    @foreach($materias as $materia)
                                        <option value="{{ $materia->id }}">
                                            {{ $materia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="rc-label">Período Académico</label>
                                <select name="periodo_academico_id" class="rc-select" required>
                                    <option value="">Seleccione período</option>
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}">
                                            {{ $periodo->nombre_periodo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabla de estudiantes --}}
                <div class="rc-card">
                    <div class="rc-card-header">
                        <i class="fas fa-users"></i>
                        <h6 class="rc-card-header-title">Estudiantes del Curso</h6>
                    </div>
                    <div class="rc-card-body" style="padding:0;">
                        @if($estudiantes->isEmpty())
                            <div class="rc-empty">
                                <i class="fas fa-user-slash"></i>
                                <p>No hay estudiantes en este curso.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table rc-tbl mb-0">
                                    <thead>
                                        <tr>
                                            <th>Estudiante</th>
                                            <th style="width:160px;">Nota (0–100)</th>
                                            <th>Observación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($estudiantes as $estudiante)
                                            <tr>
                                                <td>
                                                    <span style="font-weight:700;color:#003b73;">
                                                        {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }},
                                                        {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="number"
                                                           name="notas[{{ $estudiante->id }}]"
                                                           class="rc-input"
                                                           min="0" max="100" step="0.01"
                                                           placeholder="0.00">
                                                </td>
                                                <td>
                                                    <input type="text"
                                                           name="observacion[{{ $estudiante->id }}]"
                                                           class="rc-input"
                                                           placeholder="Observación opcional...">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="padding:1rem 1.25rem;text-align:right;border-top:1px solid #f1f5f9;">
                                <button type="submit" class="rc-btn-save">
                                    <i class="fas fa-save"></i> Guardar Calificaciones
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

            </form>
        @endif

    </div>{{-- /rc-body --}}
</div>
@endsection
