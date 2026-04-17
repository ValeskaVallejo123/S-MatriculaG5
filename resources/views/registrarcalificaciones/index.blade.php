@extends('layouts.app')

@section('title', 'Registrar Calificaciones')
@section('page-title', 'Registrar Calificaciones')
@section('content-class', 'p-0')

@push('styles')
<style>
.rc-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.rc-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.rc-hero-left { display: flex; align-items: center; gap: 1rem; }
.rc-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.rc-hero-icon i { font-size: 1.3rem; color: white; }
.rc-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.rc-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.rc-btn-ver {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .82rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.rc-btn-ver:hover { background: #f0f4f8; color: #003b73; }

/* Body */
.rc-body { flex: 1; overflow-y: auto; padding: 1.25rem 1.5rem; }

/* Cards */
.rc-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 1rem;
}
.rc-card-head {
    background: #003b73; padding: .75rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.rc-card-head i   { color: #4ec7d2; }
.rc-card-head span { color: #fff; font-weight: 700; font-size: .9rem; }
.rc-card-body { padding: 1.25rem; }

/* Select de grado */
.rc-select {
    width: 100%; padding: .55rem .9rem;
    border: 2px solid #bfd9ea; border-radius: 8px;
    font-size: .88rem; color: #0f172a;
    background: #fff; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2300508f' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right .75rem center;
    padding-right: 2.2rem; cursor: pointer; transition: border-color .2s, box-shadow .2s;
}
.rc-select:focus { outline: none; border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.2); }

/* Fila de campos */
.rc-fields { display: flex; gap: 1rem; flex-wrap: wrap; }
.rc-fields > div { flex: 1; min-width: 200px; }

.rc-field-lbl {
    font-size: .72rem; font-weight: 700; letter-spacing: .06em;
    text-transform: uppercase; color: #64748b; margin-bottom: .4rem; display: block;
}

/* Profesor bloqueado */
.rc-profesor-locked {
    padding: .55rem .9rem; border: 2px solid #bfd9ea; border-radius: 8px;
    background: #f0f7ff; color: #003b73; font-weight: 600;
    font-size: .88rem; display: flex; align-items: center; gap: .5rem;
}
.rc-profesor-locked i { color: #4ec7d2; }

/* Tabla estudiantes */
.rc-tbl { width: 100%; border-collapse: collapse; }
.rc-tbl thead th {
    background: #003b73; color: #fff;
    padding: .6rem 1rem; font-size: .75rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
}
.rc-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .85rem; color: #334155; vertical-align: middle;
}
.rc-tbl tbody tr:last-child td { border-bottom: none; }
.rc-tbl tbody tr:hover { background: #fafbfc; }

/* Input parcial */
.parcial-input {
    width: 72px; padding: .35rem .4rem;
    border: 2px solid #bfd9ea; border-radius: 6px;
    font-size: .82rem; font-weight: 700;
    text-align: center; transition: border-color .15s, background .15s;
    display: block; margin: 0 auto;
}
.parcial-input:focus { outline: none; border-color: #4ec7d2; box-shadow: 0 0 0 2px rgba(78,199,210,.2); }
.parcial-aprobado  { border-color: #059669 !important; background: #ecfdf5 !important; color: #065f46 !important; }
.parcial-reprobado { border-color: #dc2626 !important; background: #fee2e2 !important; color: #991b1b !important; }
.parcial-rec       { border-color: #d97706 !important; background: #fffbeb !important; color: #92400e !important; }

/* Display nota final */
.nota-final-display {
    display: inline-block; min-width: 60px; padding: .35rem .6rem;
    border-radius: 8px; font-size: 1rem; font-weight: 800;
    text-align: center; background: #f1f5f9; color: #94a3b8;
}
.nota-final-aprobado  { background: #ecfdf5 !important; color: #059669 !important; }
.nota-final-reprobado { background: #fee2e2 !important; color: #dc2626 !important; }

/* Input observación */
.obs-input {
    width: 100%; padding: .4rem .7rem;
    border: 2px solid #e2e8f0; border-radius: 8px;
    font-size: .8rem; color: #475569;
    transition: border-color .15s;
}
.obs-input:focus { outline: none; border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.15); }

/* Cabecera de parcial */
.th-parcial {
    font-size: .67rem !important; letter-spacing: .04em !important;
    white-space: nowrap;
}

/* Empty state */
.rc-empty { padding: 3rem 1rem; text-align: center; }
.rc-empty i { font-size: 2rem; color: #cbd5e1; display: block; margin-bottom: .6rem; }
.rc-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }

/* Warning inline */
.rc-warn {
    display: flex; align-items: center; gap: .5rem;
    background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px;
    padding: .6rem 1rem; font-size: .83rem; color: #92400e; margin-top: .75rem;
}
.rc-warn i { color: #d97706; }

/* Botón guardar */
.rc-btn-save {
    background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
    color: #fff; border: none; border-radius: 8px;
    font-weight: 700; padding: .55rem 1.5rem; font-size: .9rem; cursor: pointer;
    transition: opacity .2s, box-shadow .2s;
}
.rc-btn-save:hover { opacity: .92; box-shadow: 0 4px 12px rgba(0,80,143,.3); }

/* Estado badge */
.estado-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .68rem; font-weight: 700; padding: .2rem .55rem;
    border-radius: 999px; white-space: nowrap;
}
.estado-pendiente  { background: #f1f5f9; color: #94a3b8; }
.estado-registrada { background: #ecfdf5; color: #059669; }

/* Tarjeta resumen del grado */
.rc-resumen-grid {
    display: flex; gap: 1.25rem; flex-wrap: wrap;
}
.rc-resumen-stat { flex: 1; min-width: 180px; }

.rc-resumen-stat {
    display: flex; align-items: center; gap: .75rem;
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 10px; padding: .85rem 1rem;
}
.rc-resumen-stat-icon {
    width: 40px; height: 40px; border-radius: 9px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.rc-resumen-stat-icon i { color: #fff; font-size: .95rem; }
.rc-resumen-stat-lbl { font-size: .68rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; }
.rc-resumen-stat-val { font-size: 1.4rem; font-weight: 800; color: #0f172a; line-height: 1.1; }

/* Lista de profesores */
.rc-prof-list { list-style: none; margin: 0; padding: 0; }
.rc-prof-item {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
}
.rc-prof-item:last-child { border-bottom: none; }
.rc-prof-avatar {
    width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
}
.rc-prof-avatar i { color: #fff; font-size: .9rem; }
.rc-prof-nombre { font-weight: 700; font-size: .85rem; color: #003b73; }
.rc-prof-materias { font-size: .75rem; color: #64748b; margin-top: .15rem; }
.rc-prof-materias span {
    display: inline-block; background: #f0f9ff; color: #0369a1;
    border-radius: 999px; padding: .1rem .55rem; margin: .15rem .1rem 0 0;
    font-size: .7rem; font-weight: 600;
}

/* Dark mode */
body.dark-mode .rc-wrap { background: #0f172a; }
body.dark-mode .rc-card { background: #1e293b; border-color: #334155; }
body.dark-mode .rc-card-body { background: #1e293b; }
body.dark-mode .rc-select { background: #0f172a; color: #cbd5e1; border-color: #334155; }
body.dark-mode .rc-profesor-locked { background: #0f172a; color: #cbd5e1; }
body.dark-mode .rc-tbl tbody td { color: #cbd5e1; }
body.dark-mode .rc-tbl tbody tr { border-color: #334155; }
body.dark-mode .rc-resumen-stat { background: #0f172a; border-color: #334155; }
body.dark-mode .rc-resumen-stat-val { color: #e2e8f0; }
body.dark-mode .obs-input { background: #0f172a; border-color: #334155; color: #cbd5e1; }
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
                <p class="rc-hero-sub">
                    @if($profesorActual)
                        Prof. {{ $profesorActual->nombre }} {{ $profesorActual->apellido }}
                        — Solo sus grados y materias asignadas
                    @else
                        Seleccione un curso para registrar las notas de los estudiantes
                    @endif
                </p>
            </div>
        </div>
        <a href="{{ route('registrarcalificaciones.ver') }}" class="rc-btn-ver">
            <i class="fas fa-eye"></i> Ver Calificaciones
        </a>
    </div>

    {{-- Body --}}
    <div class="rc-body">

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 border-0 shadow-sm"
                 role="alert" style="border-radius:10px;border-left:4px solid #ef4444 !important;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Seleccionar Curso — Grid de cards --}}
        <div class="rc-card" style="margin-bottom:1rem;">
            <div class="rc-card-head">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Seleccionar Curso</span>
                @if($gradoSeleccionado)
                    <span style="margin-left:auto;font-size:.72rem;background:rgba(78,199,210,.2);
                                 color:#4ec7d2;padding:.2rem .65rem;border-radius:999px;font-weight:600;">
                        {{ $gradoSeleccionado->nombre_completo }}
                    </span>
                @endif
            </div>
            <div class="rc-card-body" style="padding:.9rem 1.25rem;">

                @if($grados->isEmpty())
                    <div class="rc-warn">
                        <i class="fas fa-exclamation-triangle"></i>
                        No tienes grados asignados. Contacta al administrador.
                    </div>

                @elseif($gradoSeleccionado)
                    {{-- Solo mostrar el grado seleccionado + botón cambiar --}}
                    <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">

                        <div style="display:flex;flex-direction:column;align-items:center;
                                    padding:.65rem 1rem;border-radius:10px;min-width:105px;
                                    border:2px solid #4ec7d2;
                                    background:linear-gradient(135deg,#003b73,#00508f);
                                    box-shadow:0 4px 14px rgba(0,59,115,.25);">
                            <span style="font-size:1.5rem;font-weight:800;line-height:1;color:white;">
                                {{ $gradoSeleccionado->numero }}
                            </span>
                            <span style="font-size:.72rem;font-weight:700;margin-top:.15rem;color:#4ec7d2;">
                                Sección {{ $gradoSeleccionado->seccion }}
                            </span>
                            <span style="font-size:.62rem;margin-top:.3rem;color:rgba(255,255,255,.65);">
                                <i class="fas fa-users" style="font-size:.55rem;"></i>
                                {{ $gradoSeleccionado->estudiantes_count ?? $gradoSeleccionado->estudiantes()->count() }}
                            </span>
                        </div>

                        <div>
                            <div style="font-size:.82rem;font-weight:700;color:#003b73;margin-bottom:.25rem;">
                                {{ $gradoSeleccionado->nombre_completo }}
                            </div>
                            <div style="font-size:.75rem;color:#64748b;margin-bottom:.5rem;">
                                {{ ucfirst($gradoSeleccionado->nivel) }} · {{ $gradoSeleccionado->anio_lectivo }}
                            </div>
                            <a href="{{ route('registrarcalificaciones.index') }}"
                               style="display:inline-flex;align-items:center;gap:.35rem;
                                      font-size:.75rem;font-weight:600;color:#00508f;
                                      background:#f0f9ff;border:1px solid #bfd9ea;
                                      border-radius:7px;padding:.3rem .75rem;
                                      text-decoration:none;transition:all .15s;"
                               onmouseover="this.style.background='#e0f2fe'"
                               onmouseout="this.style.background='#f0f9ff'">
                                <i class="fas fa-exchange-alt" style="font-size:.65rem;"></i>
                                Cambiar grado
                            </a>
                        </div>

                    </div>

                @else
                    {{-- Grid completo cuando no hay selección --}}
                    @php $gradosPorNivel = $grados->groupBy('nivel'); @endphp

                    @foreach($gradosPorNivel as $nivel => $listaGrados)
                        <div style="margin-bottom:.6rem;">
                            <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;
                                        letter-spacing:.1em;color:#94a3b8;margin-bottom:.55rem;
                                        display:flex;align-items:center;gap:.4rem;">
                                <i class="fas fa-{{ $nivel === 'primaria' ? 'child' : 'graduation-cap' }}"
                                   style="color:#4ec7d2;font-size:.65rem;"></i>
                                {{ ucfirst($nivel) }}
                            </div>
                            <div style="display:flex;flex-wrap:wrap;gap:.55rem;">
                                @foreach($listaGrados as $g)
                                    <a href="{{ route('registrarcalificaciones.index', ['grado_id' => $g->id]) }}"
                                       style="display:flex;flex-direction:column;align-items:center;
                                              text-decoration:none;padding:.6rem .85rem;
                                              border-radius:10px;min-width:100px;transition:all .18s;
                                              border:2px solid #e2e8f0;background:white;
                                              box-shadow:0 1px 3px rgba(0,0,0,.06);"
                                       onmouseover="this.style.borderColor='#4ec7d2';this.style.boxShadow='0 4px 12px rgba(78,199,210,.2)'"
                                       onmouseout="this.style.borderColor='#e2e8f0';this.style.boxShadow='0 1px 3px rgba(0,0,0,.06)'">
                                        <span style="font-size:1.5rem;font-weight:800;line-height:1;color:#003b73;">
                                            {{ $g->numero }}
                                        </span>
                                        <span style="font-size:.72rem;font-weight:700;margin-top:.15rem;color:#00508f;">
                                            Sección {{ $g->seccion }}
                                        </span>
                                        <span style="font-size:.62rem;margin-top:.3rem;color:#94a3b8;">
                                            <i class="fas fa-users" style="font-size:.55rem;"></i>
                                            {{ $g->estudiantes_count ?? 0 }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div style="border-top:1px solid #f1f5f9;margin:.6rem 0;"></div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        @if($gradoSeleccionado)

            {{-- Resumen del grado --}}
            <div class="rc-card">
                <div class="rc-card-head">
                    <i class="fas fa-info-circle"></i>
                    <span>Resumen: {{ $gradoSeleccionado->nombre_completo }}</span>
                </div>
                <div class="rc-card-body">

                    <div class="rc-resumen-grid" style="margin-bottom:1.25rem;">
                        <div class="rc-resumen-stat">
                            <div class="rc-resumen-stat-icon"
                                 style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <div class="rc-resumen-stat-lbl">Estudiantes</div>
                                <div class="rc-resumen-stat-val">{{ $estudiantes->count() }}</div>
                            </div>
                        </div>
                        <div class="rc-resumen-stat">
                            <div class="rc-resumen-stat-icon"
                                 style="background:linear-gradient(135deg,#a78bfa,#7c3aed);">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div>
                                <div class="rc-resumen-stat-lbl">Profesores asignados</div>
                                <div class="rc-resumen-stat-val">{{ $profesoresDelGrado->count() }}</div>
                            </div>
                        </div>
                    </div>

                    @if($profesoresDelGrado->isEmpty())
                        <div class="rc-warn">
                            <i class="fas fa-exclamation-triangle"></i>
                            No hay profesores asignados a este grado. Ve a <strong>Asignar Profesor</strong> para configurarlo.
                        </div>
                    @else
                        <div style="font-size:.72rem;font-weight:700;color:#64748b;
                                    text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;">
                            <i class="fas fa-chalkboard-teacher" style="color:#4ec7d2;margin-right:.3rem;"></i>
                            Profesores y Materias
                        </div>
                        <ul class="rc-prof-list">
                            @foreach($profesoresDelGrado as $profId => $asignaciones)
                                @php $prof = $asignaciones->first(); @endphp
                                <li class="rc-prof-item">
                                    <div class="rc-prof-avatar"><i class="fas fa-user-tie"></i></div>
                                    <div>
                                        <div class="rc-prof-nombre">{{ $prof->apellido }}, {{ $prof->nombre }}</div>
                                        <div class="rc-prof-materias">
                                            @foreach($asignaciones as $a)
                                                <span>{{ $a->materia_nombre }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>

            <form action="{{ route('registrarcalificaciones.store') }}" method="POST" id="form-calificaciones">
                @csrf
                <input type="hidden" name="grado_id"  value="{{ request('grado_id') }}" id="hidden-grado-id">

                @if($profesorActual)
                    <input type="hidden" name="profesor_id" value="{{ $profesorActual->id }}" id="hidden-prof-id">
                @endif

                {{-- Información de la Calificación --}}
                <div class="rc-card">
                    <div class="rc-card-head">
                        <i class="fas fa-cogs"></i>
                        <span>Información de la Calificación</span>
                    </div>
                    <div class="rc-card-body">
                        <div class="rc-fields">

                            {{-- Profesor --}}
                            <div>
                                <label class="rc-field-lbl">Profesor</label>
                                @if($profesorActual)
                                    <div class="rc-profesor-locked">
                                        <i class="fas fa-user-tie"></i>
                                        {{ $profesorActual->apellido }}, {{ $profesorActual->nombre }}
                                    </div>
                                @elseif($profesoresDelGrado->count() === 1)
                                    @php $soloProf = $profesoresDelGrado->first()->first(); @endphp
                                    <div class="rc-profesor-locked">
                                        <i class="fas fa-user-tie"></i>
                                        {{ $soloProf->apellido }}, {{ $soloProf->nombre }}
                                    </div>
                                    <input type="hidden" name="profesor_id" id="select-profesor"
                                           value="{{ $soloProf->id }}">
                                @elseif($profesoresDelGrado->isNotEmpty())
                                    <select name="profesor_id" id="select-profesor" class="rc-select" required>
                                        <option value="">— Seleccione profesor —</option>
                                        @foreach($profesoresDelGrado as $profId => $asignaciones)
                                            @php $p = $asignaciones->first(); @endphp
                                            <option value="{{ $p->id }}">
                                                {{ $p->apellido }}, {{ $p->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <div class="rc-warn" style="margin-top:0;">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Sin profesores asignados a este grado.
                                    </div>
                                    <input type="hidden" name="profesor_id" id="select-profesor" value="">
                                @endif
                            </div>

                            {{-- Materia --}}
                            <div>
                                <label class="rc-field-lbl">Materia</label>
                                <select name="materia_id" id="select-materia" class="rc-select" required>
                                    <option value="">— Seleccione materia —</option>
                                    @foreach($materias as $materia)
                                        <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                                    @endforeach
                                </select>
                                @if($materias->isEmpty())
                                    <div class="rc-warn" style="margin-top:.5rem;padding:.4rem .75rem;">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Sin materias asignadas en este grado.
                                    </div>
                                @endif
                            </div>

                            {{-- Período --}}
                            <div>
                                <label class="rc-field-lbl">Período Académico</label>
                                <select name="periodo_academico_id" id="select-periodo" class="rc-select" required>
                                    <option value="">— Seleccione período —</option>
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}">{{ $periodo->nombre_periodo }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Tabla de Estudiantes --}}
                <div class="rc-card">
                    <div class="rc-card-head">
                        <i class="fas fa-users"></i>
                        <span>Estudiantes del Curso</span>
                        @if($estudiantes->isNotEmpty())
                            <span id="badge-progreso"
                                  style="margin-left:auto;background:rgba(255,255,255,.15);
                                  color:#fff;font-size:.72rem;padding:.2rem .6rem;
                                  border-radius:999px;font-weight:600;">
                                0 / {{ $estudiantes->count() }} con nota
                            </span>
                        @endif
                    </div>

                    @if($estudiantes->isEmpty())
                        <div class="rc-empty">
                            <i class="fas fa-user-slash"></i>
                            <p>No hay estudiantes registrados en este curso.</p>
                        </div>
                    @else
                        {{-- Barra de progreso --}}
                        <div id="barra-progreso-wrap"
                             style="padding:.6rem 1.25rem .25rem;background:#f8fafc;border-bottom:1px solid #f1f5f9;">
                            <div style="display:flex;justify-content:space-between;align-items:center;
                                        font-size:.72rem;color:#64748b;font-weight:600;margin-bottom:.3rem;">
                                <span>Progreso de calificación</span>
                                <span id="txt-progreso">Seleccione materia y período para cargar notas existentes</span>
                            </div>
                            <div style="height:6px;background:#e2e8f0;border-radius:999px;overflow:hidden;">
                                <div id="barra-fill"
                                     style="height:100%;width:0%;
                                            background:linear-gradient(90deg,#4ec7d2,#059669);
                                            border-radius:999px;transition:width .4s ease;"></div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="rc-tbl">
                                <thead>
                                    <tr>
                                        <th style="width:36px;">#</th>
                                        <th>Estudiante</th>
                                        <th class="th-parcial" style="text-align:center;width:82px;">1er Parcial</th>
                                        <th class="th-parcial" style="text-align:center;width:82px;">2do Parcial</th>
                                        <th class="th-parcial" style="text-align:center;width:82px;">3er Parcial</th>
                                        <th class="th-parcial" style="text-align:center;width:82px;">Recuperación</th>
                                        <th class="th-parcial" style="text-align:center;width:80px;">Nota Final</th>
                                        <th style="text-align:center;width:90px;">Estado</th>
                                        <th>Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($estudiantes as $i => $estudiante)
                                    <tr id="fila-{{ $estudiante->id }}">
                                        <td style="color:#94a3b8;font-size:.78rem;font-weight:600;">{{ $i + 1 }}</td>
                                        <td>
                                            <span style="font-weight:700;color:#0f172a;">
                                                {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }},
                                            </span>
                                            {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                                        </td>
                                        <td style="text-align:center;">
                                            <input type="number" min="0" max="100" step="0.01"
                                                   class="parcial-input"
                                                   id="p1-{{ $estudiante->id }}"
                                                   name="primer_parcial[{{ $estudiante->id }}]"
                                                   data-estudiante="{{ $estudiante->id }}"
                                                   data-parcial="p1" placeholder="—">
                                        </td>
                                        <td style="text-align:center;">
                                            <input type="number" min="0" max="100" step="0.01"
                                                   class="parcial-input"
                                                   id="p2-{{ $estudiante->id }}"
                                                   name="segundo_parcial[{{ $estudiante->id }}]"
                                                   data-estudiante="{{ $estudiante->id }}"
                                                   data-parcial="p2" placeholder="—">
                                        </td>
                                        <td style="text-align:center;">
                                            <input type="number" min="0" max="100" step="0.01"
                                                   class="parcial-input"
                                                   id="p3-{{ $estudiante->id }}"
                                                   name="tercer_parcial[{{ $estudiante->id }}]"
                                                   data-estudiante="{{ $estudiante->id }}"
                                                   data-parcial="p3" placeholder="—">
                                        </td>
                                        <td style="text-align:center;">
                                            <input type="number" min="0" max="100" step="0.01"
                                                   class="parcial-input parcial-rec"
                                                   id="rec-{{ $estudiante->id }}"
                                                   name="recuperacion[{{ $estudiante->id }}]"
                                                   data-estudiante="{{ $estudiante->id }}"
                                                   data-parcial="rec" placeholder="—"
                                                   style="border-color:#d97706;">
                                        </td>
                                        <td style="text-align:center;">
                                            <span id="final-display-{{ $estudiante->id }}" class="nota-final-display">—</span>
                                            <input type="hidden"
                                                   name="notas[{{ $estudiante->id }}]"
                                                   id="nota-{{ $estudiante->id }}"
                                                   class="nota-input"
                                                   data-estudiante="{{ $estudiante->id }}">
                                        </td>
                                        <td style="text-align:center;">
                                            <span id="estado-{{ $estudiante->id }}"
                                                  class="estado-badge estado-pendiente">
                                                <i class="fas fa-circle-dot"></i> Pendiente
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   name="observacion[{{ $estudiante->id }}]"
                                                   class="obs-input"
                                                   id="obs-{{ $estudiante->id }}"
                                                   placeholder="Se genera automáticamente...">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div style="padding:1rem 1.25rem;display:flex;justify-content:flex-end;
                                    border-top:1px solid #f1f5f9;background:#fafbfc;">
                            <button type="submit" class="rc-btn-save">
                                <i class="fas fa-save me-2"></i>Guardar Calificaciones
                            </button>
                        </div>
                    @endif
                </div>

            </form>

        @endif

    </div>{{-- /rc-body --}}
</div>

@push('scripts')
<script>
const ENDPOINT_NOTAS = "{{ route('registrarcalificaciones.notas-existentes') }}";
const GRADO_ID       = "{{ request('grado_id') }}";

// Mapa profesor → materias para filtrado dinámico
@if($gradoSeleccionado)
const PROF_MATERIAS = @json(
    $profesoresDelGrado->map(fn($asigns) =>
        $asigns->map(fn($a) => ['id' => $a->materia_id, 'nombre' => $a->materia_nombre])->values()
    )
);
@else
const PROF_MATERIAS = {};
@endif

/* ── Utilidades ─────────────────────────────────────── */
function obsDesdeNota(val) {
    if (val >= 90) return 'Excelente';
    if (val >= 80) return 'Muy Bueno';
    if (val >= 70) return 'Bueno';
    if (val >= 60) return 'Aprobado';
    return 'Reprobado';
}

function getNum(id) {
    const el = document.getElementById(id);
    if (!el || el.value === '') return null;
    const v = parseFloat(el.value);
    return isNaN(v) ? null : v;
}

function calcularFinal(id) {
    const p1  = getNum('p1-'  + id);
    const p2  = getNum('p2-'  + id);
    const p3  = getNum('p3-'  + id);
    const rec = getNum('rec-' + id);
    const parciales = [p1, p2, p3].filter(v => v !== null);
    if (parciales.length === 0) return null;
    const promedio = parciales.reduce((a, b) => a + b, 0) / parciales.length;
    return (promedio < 60 && rec !== null) ? Math.max(promedio, rec) : promedio;
}

/* ── Actualizar fila al cambiar cualquier parcial ───── */
function actualizarFila(id) {
    const final    = calcularFinal(id);
    const hiddenEl = document.getElementById('nota-' + id);
    const dispEl   = document.getElementById('final-display-' + id);
    const estadoEl = document.getElementById('estado-' + id);
    const obsEl    = document.getElementById('obs-' + id);

    if (final !== null) {
        hiddenEl.value  = final.toFixed(2);
        dispEl.textContent = final.toFixed(1);
        dispEl.className = 'nota-final-display ' + (final >= 60 ? 'nota-final-aprobado' : 'nota-final-reprobado');

        if (estadoEl) {
            estadoEl.className = 'estado-badge estado-registrada';
            estadoEl.innerHTML = '<i class="fas fa-check-circle"></i> Registrada';
        }
        if (obsEl && !obsEl.dataset.userModified) obsEl.value = obsDesdeNota(final);
    } else {
        hiddenEl.value = '';
        dispEl.textContent = '—';
        dispEl.className = 'nota-final-display';
        if (estadoEl) {
            estadoEl.className = 'estado-badge estado-pendiente';
            estadoEl.innerHTML = '<i class="fas fa-circle-dot"></i> Pendiente';
        }
        if (obsEl && !obsEl.dataset.userModified) obsEl.value = '';
    }

    // Color en cada parcial individualmente
    ['p1','p2','p3'].forEach(p => {
        const inp = document.getElementById(p + '-' + id);
        if (!inp) return;
        inp.classList.remove('parcial-aprobado','parcial-reprobado');
        if (inp.value !== '') {
            const v = parseFloat(inp.value);
            if (!isNaN(v)) inp.classList.add(v >= 60 ? 'parcial-aprobado' : 'parcial-reprobado');
        }
    });

    actualizarProgreso();
}

/* ── Progreso global ─────────────────────────────────── */
function actualizarProgreso() {
    const inputs   = document.querySelectorAll('.nota-input');
    const total    = inputs.length;
    const conNota  = [...inputs].filter(i => i.value !== '' && !isNaN(parseFloat(i.value))).length;
    const pct      = total > 0 ? Math.round(conNota / total * 100) : 0;

    const badge = document.getElementById('badge-progreso');
    const fill  = document.getElementById('barra-fill');
    const txt   = document.getElementById('txt-progreso');

    if (badge) badge.textContent = conNota + ' / ' + total + ' con nota';
    if (fill)  fill.style.width  = pct + '%';
    if (txt)   txt.textContent   = conNota === total && total > 0
                                    ? '¡Todos los estudiantes tienen nota! ✓'
                                    : (conNota + ' registradas · ' + (total - conNota) + ' pendientes');
}

/* ── Filtrar materias por profesor ───────────────────── */
function filtrarMateriasPorProfesor(profId) {
    const sel = document.getElementById('select-materia');
    if (!sel) return;
    const prevVal = sel.value;
    sel.innerHTML = '<option value="">— Seleccione materia —</option>';
    if (!profId || !PROF_MATERIAS[profId]) return;
    PROF_MATERIAS[profId].forEach(m => {
        const opt = document.createElement('option');
        opt.value = m.id;
        opt.textContent = m.nombre;
        if (String(m.id) === String(prevVal)) opt.selected = true;
        sel.appendChild(opt);
    });
}

/* ── Cargar notas existentes (AJAX) ──────────────────── */
function cargarNotasExistentes() {
    const profesorEl = document.getElementById('select-profesor') ||
                       document.getElementById('hidden-prof-id');
    const materiaEl  = document.getElementById('select-materia');
    const periodoEl  = document.getElementById('select-periodo');
    if (!profesorEl || !materiaEl || !periodoEl) return;

    const profId    = profesorEl.value || profesorEl.getAttribute('value');
    const materiaId = materiaEl.value;
    const periodoId = periodoEl.value;
    if (!profId || !materiaId || !periodoId) return;

    const txt = document.getElementById('txt-progreso');
    if (txt) txt.textContent = 'Cargando notas existentes...';

    const url = ENDPOINT_NOTAS
        + '?profesor_id='          + profId
        + '&grado_id='             + GRADO_ID
        + '&materia_id='           + materiaId
        + '&periodo_academico_id=' + periodoId;

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            document.querySelectorAll('.nota-input').forEach(hidden => {
                const id = hidden.dataset.estudiante;
                const d  = data[id];

                const setVal = (inputId, val) => {
                    const el = document.getElementById(inputId);
                    if (el) el.value = (val !== null && val !== undefined) ? val : '';
                };

                setVal('p1-'  + id, d?.primer_parcial);
                setVal('p2-'  + id, d?.segundo_parcial);
                setVal('p3-'  + id, d?.tercer_parcial);
                setVal('rec-' + id, d?.recuperacion);

                const obsEl = document.getElementById('obs-' + id);
                if (obsEl && d?.observacion) {
                    obsEl.value = d.observacion;
                    obsEl.dataset.userModified = 'true';
                } else if (obsEl) {
                    obsEl.value = '';
                    delete obsEl.dataset.userModified;
                }

                actualizarFila(id);
            });
        })
        .catch(() => { if (txt) txt.textContent = 'No se pudieron cargar notas previas.'; });
}

/* ── Eventos ─────────────────────────────────────────── */
document.querySelectorAll('.parcial-input').forEach(input => {
    input.addEventListener('input', () => actualizarFila(input.dataset.estudiante));
});

document.querySelectorAll('.obs-input').forEach(obs => {
    obs.addEventListener('input', function () { this.dataset.userModified = 'true'; });
    obs.addEventListener('blur',  function () { if (!this.value) delete this.dataset.userModified; });
});

const selMateria  = document.getElementById('select-materia');
const selPeriodo  = document.getElementById('select-periodo');
const selProfesor = document.getElementById('select-profesor');

if (selMateria)  selMateria.addEventListener('change',  cargarNotasExistentes);
if (selPeriodo)  selPeriodo.addEventListener('change',  cargarNotasExistentes);
if (selProfesor && selProfesor.tagName === 'SELECT') {
    selProfesor.addEventListener('change', function() {
        filtrarMateriasPorProfesor(this.value);
        cargarNotasExistentes();
    });
    // Filtrar al cargar si ya hay un profesor seleccionado
    if (selProfesor.value) filtrarMateriasPorProfesor(selProfesor.value);
}
</script>
@endpush
@endsection
