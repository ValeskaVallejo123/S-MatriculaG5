@extends('layouts.app')

@section('topbar-actions')

    @php
        $usuario = auth()->user();
        $rutaDashboard = match($usuario->rol->nombre ?? '') {
            'Administrador'       => route('admin.dashboard'),
            'Super Administrador' => route('superadmin.dashboard'),
            'Profesor'            => route('profesor.dashboard'),
            'Estudiante'          => route('estudiante.dashboard'),
            'Padre'               => route('padre.dashboard'),
            default               => route('dashboard'),
        };
    @endphp

    <div style="display:flex;gap:10px;">
        <a href="{{ route('registrarcalificaciones.ver') }}"
           class="btn btn-sm"
           style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
                  color:white;border:none;border-radius:8px;font-weight:600;">
            <i class="fas fa-eye me-1"></i> Ver Calificaciones
        </a>
    </div>

@endsection

@push('styles')
<style>
.rc-wrap { font-family: 'Inter', sans-serif; }

/* Header */
.rc-header {
    border-radius: 12px;
    background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 1rem;
}
.rc-header-icon {
    width: 52px; height: 52px; border-radius: 12px;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.rc-header-icon i { color: #fff; font-size: 1.4rem; }
.rc-header h5 { color: #fff; font-weight: 800; margin: 0 0 .2rem; }
.rc-header p  { color: rgba(255,255,255,.8); font-size: .83rem; margin: 0; }

/* Cards */
.rc-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 1.5rem;
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
    font-family: 'Inter', sans-serif; font-size: .88rem; color: #0f172a;
    background: #fff; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2300508f' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right .75rem center;
    padding-right: 2.2rem; cursor: pointer; transition: border-color .2s, box-shadow .2s;
}
.rc-select:focus { outline: none; border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.2); }

/* Fila de campos */
.rc-fields { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; }
@media(max-width:768px) { .rc-fields { grid-template-columns: 1fr; } }

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

/* Inputs de nota */
.nota-input {
    width: 110px; padding: .4rem .7rem;
    border: 2px solid #bfd9ea; border-radius: 8px;
    font-family: 'Inter', sans-serif; font-size: .9rem; font-weight: 700;
    text-align: center; transition: border-color .15s, background .15s;
}
.nota-input:focus { outline: none; border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.2); }
.nota-aprobado  { border-color: #059669 !important; background: #ecfdf5 !important; color: #065f46 !important; }
.nota-reprobado { border-color: #dc2626 !important; background: #fee2e2 !important; color: #991b1b !important; }

/* Input observación */
.obs-input {
    width: 100%; padding: .4rem .7rem;
    border: 2px solid #e2e8f0; border-radius: 8px;
    font-family: 'Inter', sans-serif; font-size: .8rem; color: #475569;
    transition: border-color .15s;
}
.obs-input:focus { outline: none; border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.15); }

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
    font-family: 'Inter', sans-serif; font-weight: 700;
    padding: .55rem 1.5rem; font-size: .9rem; cursor: pointer;
    transition: opacity .2s, box-shadow .2s;
}
.rc-btn-save:hover { opacity: .92; box-shadow: 0 4px 12px rgba(0,80,143,.3); }

/* Alerta éxito/error */
.rc-alert {
    display: flex; align-items: center; gap: .6rem;
    padding: .75rem 1rem; border-radius: 10px;
    font-size: .85rem; font-weight: 600; margin-bottom: 1.25rem;
}
.rc-alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
.rc-alert-error   { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; }

/* Tarjeta resumen del grado */
.rc-resumen-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;
}
@media(max-width:640px) { .rc-resumen-grid { grid-template-columns: 1fr; } }

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
</style>
@endpush

@section('content')
<div class="rc-wrap">

    {{-- Alerta de error (éxito lo muestra el layout global) --}}
    @if(session('error'))
        <div class="rc-alert rc-alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="rc-header">
        <div class="rc-header-icon"><i class="fas fa-clipboard-check"></i></div>
        <div>
            <h5>Registrar Calificaciones</h5>
            <p>
                @if($profesorActual)
                    Prof. <strong>{{ $profesorActual->nombre }} {{ $profesorActual->apellido }}</strong>
                    — Solo sus grados y materias asignadas
                @else
                    Seleccione un curso para registrar las notas de los estudiantes
                @endif
            </p>
        </div>
    </div>

    {{-- Seleccionar Curso --}}
    <div class="rc-card">
        <div class="rc-card-head">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Seleccionar Curso</span>
        </div>
        <div class="rc-card-body">
            <form method="GET" action="{{ route('registrarcalificaciones.index') }}">
                <label class="rc-field-lbl">Grado y Sección</label>
                <select name="grado_id" class="rc-select" onchange="this.form.submit()" required>
                    <option value="">— Seleccione un curso —</option>
                    @foreach($grados as $grado)
                        <option value="{{ $grado->id }}"
                            {{ request('grado_id') == $grado->id ? 'selected' : '' }}>
                            {{ $grado->numero }}° {{ ucfirst($grado->nivel) }} — Sección {{ $grado->seccion }}
                            ({{ $grado->anio_lectivo }})
                        </option>
                    @endforeach
                </select>
            </form>

            @if($grados->isEmpty())
                <div class="rc-warn">
                    <i class="fas fa-exclamation-triangle"></i>
                    No tienes grados asignados. Contacta al administrador.
                </div>
            @endif
        </div>
    </div>


    @if($gradoSeleccionado)

        {{-- ─── RESUMEN DEL GRADO SELECCIONADO ──────────────────────────────── --}}
        <div class="rc-card">
            <div class="rc-card-head">
                <i class="fas fa-info-circle"></i>
                <span>
                    Resumen: {{ $gradoSeleccionado->numero }}°
                    {{ ucfirst($gradoSeleccionado->nivel) }} — Sección {{ $gradoSeleccionado->seccion }}
                </span>
            </div>
            <div class="rc-card-body">

                {{-- Stats rápidos --}}
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

                {{-- Lista de profesores y sus materias --}}
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
                                <div class="rc-prof-avatar">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <div class="rc-prof-nombre">
                                        {{ $prof->apellido }}, {{ $prof->nombre }}
                                    </div>
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
        {{-- ──────────────────────────────────────────────────────────────────── --}}

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
                                {{-- Solo 1 profesor: auto-selección --}}
                                @php $soloProf = $profesoresDelGrado->first()->first(); @endphp
                                <div class="rc-profesor-locked">
                                    <i class="fas fa-user-tie"></i>
                                    {{ $soloProf->apellido }}, {{ $soloProf->nombre }}
                                </div>
                                <input type="hidden" name="profesor_id" id="select-profesor"
                                       value="{{ $soloProf->id }}">
                            @elseif($profesoresDelGrado->isNotEmpty())
                                {{-- Varios profesores: select --}}
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
                        {{-- Contador dinámico actualizado por JS --}}
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
                                    <th>#</th>
                                    <th>Estudiante</th>
                                    <th style="text-align:center;width:60px;">Estado</th>
                                    <th style="text-align:center;width:130px;">Nota (0–100)</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $i => $estudiante)
                                <tr id="fila-{{ $estudiante->id }}">
                                    <td style="color:#94a3b8;font-size:.78rem;font-weight:600;">
                                        {{ $i + 1 }}
                                    </td>
                                    <td>
                                        <span style="font-weight:700;color:#0f172a;">
                                            {{ $estudiante->apellido1 }}
                                            {{ $estudiante->apellido2 }},
                                        </span>
                                        {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                                    </td>
                                    {{-- Columna estado (pendiente / registrada) --}}
                                    <td style="text-align:center;">
                                        <span id="estado-{{ $estudiante->id }}"
                                              class="estado-badge estado-pendiente">
                                            <i class="fas fa-circle-dot"></i> Pendiente
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="number"
                                               name="notas[{{ $estudiante->id }}]"
                                               class="nota-input"
                                               id="nota-{{ $estudiante->id }}"
                                               data-estudiante="{{ $estudiante->id }}"
                                               min="0" max="100" step="0.01"
                                               placeholder="—">
                                    </td>
                                    <td>
                                        <input type="text"
                                               name="observacion[{{ $estudiante->id }}]"
                                               class="obs-input"
                                               id="obs-{{ $estudiante->id }}"
                                               placeholder="Se generará automáticamente...">
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

</div>

<style>
.estado-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .68rem; font-weight: 700; padding: .2rem .55rem;
    border-radius: 999px; white-space: nowrap;
}
.estado-pendiente  { background: #f1f5f9; color: #94a3b8; }
.estado-registrada { background: #ecfdf5; color: #059669; }
</style>

<script>
const ENDPOINT_NOTAS = "{{ route('registrarcalificaciones.notas-existentes') }}";
const GRADO_ID       = "{{ request('grado_id') }}";

// ─── Texto de observación automático según nota ───────────────────────────
function obsDesdeNota(val) {
    if (val >= 90) return 'Excelente';
    if (val >= 80) return 'Muy Bueno';
    if (val >= 70) return 'Bueno';
    if (val >= 60) return 'Aprobado';
    return 'Reprobado';
}

// ─── Actualiza color del input y estado de la fila ───────────────────────
function aplicarEstadoInput(input) {
    const id  = input.dataset.estudiante;
    const val = parseFloat(input.value);
    const obsEl    = document.getElementById('obs-' + id);
    const estadoEl = document.getElementById('estado-' + id);

    input.classList.remove('nota-aprobado', 'nota-reprobado');

    if (!isNaN(val) && input.value !== '') {
        input.classList.add(val >= 60 ? 'nota-aprobado' : 'nota-reprobado');

        // Observación: solo si el usuario no la escribió manualmente
        if (obsEl && !obsEl.dataset.userModified) {
            obsEl.value = obsDesdeNota(val);
        }

        // Badge estado
        if (estadoEl) {
            estadoEl.className = 'estado-badge estado-registrada';
            estadoEl.innerHTML = '<i class="fas fa-check-circle"></i> Registrada';
        }
    } else {
        // Sin nota
        if (obsEl && !obsEl.dataset.userModified) obsEl.value = '';
        if (estadoEl) {
            estadoEl.className = 'estado-badge estado-pendiente';
            estadoEl.innerHTML = '<i class="fas fa-circle-dot"></i> Pendiente';
        }
    }

    actualizarProgreso();
}

// ─── Barra de progreso ────────────────────────────────────────────────────
function actualizarProgreso() {
    const total    = document.querySelectorAll('.nota-input').length;
    const conNota  = [...document.querySelectorAll('.nota-input')]
                        .filter(i => i.value !== '' && !isNaN(parseFloat(i.value))).length;
    const pct      = total > 0 ? Math.round(conNota / total * 100) : 0;

    const badge = document.getElementById('badge-progreso');
    const fill  = document.getElementById('barra-fill');
    const txt   = document.getElementById('txt-progreso');

    if (badge) badge.textContent = conNota + ' / ' + total + ' con nota';
    if (fill)  fill.style.width  = pct + '%';
    if (txt)   txt.textContent   = conNota === total
                                    ? '¡Todos los estudiantes tienen nota! ✓'
                                    : (conNota + ' registradas · ' + (total - conNota) + ' pendientes');
}

// ─── Cargar notas existentes via fetch ───────────────────────────────────
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

    const url = ENDPOINT_NOTAS
        + '?profesor_id='          + profId
        + '&grado_id='             + GRADO_ID
        + '&materia_id='           + materiaId
        + '&periodo_academico_id=' + periodoId;

    const txt = document.getElementById('txt-progreso');
    if (txt) txt.textContent = 'Cargando notas existentes...';

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            document.querySelectorAll('.nota-input').forEach(input => {
                const id = input.dataset.estudiante;
                if (data[id]) {
                    input.value = data[id].nota ?? '';
                    const obsEl = document.getElementById('obs-' + id);
                    if (obsEl && data[id].observacion) {
                        obsEl.value = data[id].observacion;
                        obsEl.dataset.userModified = 'true';
                    }
                } else {
                    input.value = '';
                    const obsEl = document.getElementById('obs-' + id);
                    if (obsEl) { obsEl.value = ''; delete obsEl.dataset.userModified; }
                }
                aplicarEstadoInput(input);
            });
        })
        .catch(() => { if (txt) txt.textContent = 'No se pudieron cargar notas previas.'; });
}

// ─── Eventos ──────────────────────────────────────────────────────────────
document.querySelectorAll('.nota-input').forEach(input => {
    input.addEventListener('input', () => aplicarEstadoInput(input));
});

document.querySelectorAll('.obs-input').forEach(obs => {
    obs.addEventListener('input', function () { this.dataset.userModified = 'true'; });
    obs.addEventListener('blur',  function () { if (!this.value) delete this.dataset.userModified; });
});

// Cargar notas cuando cambian materia o período
const selMateria = document.getElementById('select-materia');
const selPeriodo = document.getElementById('select-periodo');
const selProfesor = document.getElementById('select-profesor');

if (selMateria)  selMateria.addEventListener('change',  cargarNotasExistentes);
if (selPeriodo)  selPeriodo.addEventListener('change',  cargarNotasExistentes);
if (selProfesor && selProfesor.tagName === 'SELECT')
    selProfesor.addEventListener('change', cargarNotasExistentes);
</script>
@endsection
