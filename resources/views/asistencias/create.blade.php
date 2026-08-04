@extends('layouts.app')
@section('title', 'Registrar Asistencia')
@section('page-title', 'Registrar Asistencia')

@push('styles')
<style>
:root {
    --c-primary:#00508f; --c-dark:#003b73; --c-teal:#4ec7d2;
    --c-green:#10b981; --c-amber:#f59e0b; --c-red:#ef4444;
    --c-border:#e2e8f0; --c-surface:#f8fafc; --c-muted:#64748b;
}

/* ── Hero ── */
.adm-hero {
    background:linear-gradient(135deg,#4ec7d2 0%,#00508f 60%,#003b73 100%);
    border-radius:14px; padding:1.5rem 1.75rem; margin-bottom:1.5rem;
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:1rem;
    box-shadow:0 4px 18px rgba(0,59,115,.18);
}
.adm-hero-left   { display:flex; align-items:center; gap:1.25rem; }
.adm-hero-icon   {
    width:56px; height:56px; border-radius:14px; flex-shrink:0;
    background:rgba(255,255,255,.18);
    display:flex; align-items:center; justify-content:center;
}
.adm-hero-icon i { font-size:1.5rem; color:#fff; }
.adm-hero-title  { font-size:1.3rem; font-weight:700; color:#fff; margin:0; }
.adm-hero-sub    { font-size:.82rem; color:rgba(255,255,255,.78); margin-top:.2rem; }

/* ── Card ── */
.adm-card {
    background:#fff; border:1px solid var(--c-border);
    border-radius:12px; overflow:hidden;
    box-shadow:0 1px 3px rgba(0,0,0,.05); margin-bottom:1.25rem;
}
.adm-card-head {
    background:var(--c-dark); padding:.85rem 1.25rem;
    display:flex; align-items:center; gap:.6rem;
}
.adm-card-head i    { color:var(--c-teal); font-size:1rem; }
.adm-card-head span { color:#fff; font-weight:700; font-size:.95rem; }
.adm-card-body { padding:1.25rem 1.5rem; }

/* ── Selector de contexto ── */
.rc-context {
    display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem;
    padding:1.25rem 1.5rem; border-bottom:1px solid var(--c-border);
    background:var(--c-surface);
}
@media(max-width:640px){ .rc-context { grid-template-columns:1fr; } }

.rc-field  { display:flex; flex-direction:column; gap:.35rem; }
.rc-label  {
    font-size:.72rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.06em; color:var(--c-muted);
}
.rc-label i { color:var(--c-teal); margin-right:.2rem; }
.rc-select, .rc-input {
    padding:.45rem .75rem; border:1.5px solid var(--c-border); border-radius:8px;
    font-size:.84rem; color:#0f172a; background:#fff; outline:none;
    font-family:inherit; transition:border-color .15s; width:100%;
}
.rc-select:focus, .rc-input:focus {
    border-color:var(--c-teal);
    box-shadow:0 0 0 3px rgba(78,199,210,.12);
}
.rc-select:disabled { background:var(--c-surface); color:var(--c-muted); cursor:not-allowed; }

/* ── Botones masivos ── */
.bulk-bar {
    display:flex; gap:.5rem; padding:.85rem 1.5rem;
    border-bottom:1px solid var(--c-border);
    flex-wrap:wrap; align-items:center;
    background:var(--c-surface);
}
.bulk-label { font-size:.72rem; font-weight:700; color:var(--c-muted); text-transform:uppercase; letter-spacing:.06em; margin-right:.25rem; }
.bulk-btn {
    padding:.3rem .8rem; border-radius:7px; font-size:.72rem; font-weight:700;
    border:1.5px solid; cursor:pointer; transition:all .15s; display:inline-flex; align-items:center; gap:.3rem;
}
.bb-presente  { border-color:#10b981; color:#065f46; background:rgba(16,185,129,.08); }
.bb-presente:hover  { background:#10b981; color:#fff; }
.bb-ausente   { border-color:#ef4444; color:#991b1b; background:rgba(239,68,68,.08); }
.bb-ausente:hover   { background:#ef4444; color:#fff; }
.bb-tardanza  { border-color:#f59e0b; color:#92400e; background:rgba(245,158,11,.08); }
.bb-tardanza:hover  { background:#f59e0b; color:#fff; }

/* ── Contadores ── */
.counters {
    display:flex; gap:1.25rem; padding:.65rem 1.5rem;
    border-bottom:1px solid var(--c-border);
    background:#fff; flex-wrap:wrap; align-items:center;
}
.counter-item { display:flex; align-items:center; gap:.4rem; font-size:.8rem; font-weight:700; }

/* ── Tabla ── */
.est-table { width:100%; border-collapse:collapse; }
.est-table thead th {
    font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em;
    color:var(--c-muted); background:var(--c-surface); padding:.65rem 1rem;
    border-bottom:1.5px solid var(--c-border); text-align:left; white-space:nowrap;
}
.est-table tbody td {
    padding:.65rem 1rem; border-bottom:1px solid #f1f5f9;
    font-size:.83rem; vertical-align:middle;
}
.est-table tbody tr:last-child td { border-bottom:none; }
.est-table tbody tr:hover td { background:#f0f7ff; }

/* ── Radio de estado ── */
.estado-group { display:flex; gap:.35rem; flex-wrap:wrap; }
.estado-radio { display:none; }
.estado-label {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.28rem .65rem; border-radius:8px; font-size:.72rem; font-weight:700;
    border:1.5px solid var(--c-border); cursor:pointer;
    transition:all .15s; user-select:none; white-space:nowrap;
    background:#fff;
}
.estado-label:hover { background:var(--c-surface); border-color:#94a3b8; }
.estado-radio[value="presente"]:checked   + .estado-label { background:rgba(16,185,129,.12); border-color:#10b981; color:#065f46; border-width:2px; }
.estado-radio[value="ausente"]:checked    + .estado-label { background:rgba(239,68,68,.12);  border-color:#ef4444; color:#991b1b; border-width:2px; }
.estado-radio[value="tardanza"]:checked   + .estado-label { background:rgba(245,158,11,.12); border-color:#f59e0b; color:#92400e; border-width:2px; }
.estado-radio[value="justificado"]:checked + .estado-label { background:rgba(78,199,210,.12); border-color:#4ec7d2; color:#0e7490; border-width:2px; }

/* ── Observacion ── */
.obs-input {
    padding:.3rem .65rem; border:1.5px solid var(--c-border); border-radius:7px;
    font-size:.75rem; color:#0f172a; outline:none; width:100%; min-width:140px;
    transition:border-color .15s; font-family:inherit;
}
.obs-input:focus { border-color:var(--c-teal); box-shadow:0 0 0 2px rgba(78,199,210,.1); }

/* ── Avatar ── */
.av {
    width:34px; height:34px; border-radius:8px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:.85rem; font-weight:700; color:#fff;
    background:linear-gradient(135deg,var(--c-teal),var(--c-primary));
}

/* ── Footer ── */
.rc-footer {
    padding:1rem 1.5rem; display:flex; align-items:center; justify-content:space-between;
    border-top:1px solid var(--c-border); flex-wrap:wrap; gap:.75rem;
    background:var(--c-surface);
}
.btn-guardar {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.55rem 1.5rem; border-radius:8px; font-size:.875rem; font-weight:700;
    background:linear-gradient(135deg,var(--c-green),#059669); color:#fff;
    border:none; cursor:pointer; transition:all .2s;
}
.btn-guardar:hover { opacity:.88; transform:translateY(-1px); }
.btn-volver {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.55rem 1.1rem; border-radius:8px; font-size:.82rem; font-weight:600;
    background:#fff; color:var(--c-muted); border:1.5px solid var(--c-border);
    text-decoration:none; transition:border-color .15s;
}
.btn-volver:hover { border-color:#94a3b8; color:#334155; }

/* ── Estado vacío ── */
.rc-empty { text-align:center; padding:3rem 1rem; color:var(--c-muted); }
.rc-empty i { font-size:2.5rem; color:#cbd5e1; display:block; margin-bottom:.75rem; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">

    {{-- Hero --}}
    <div class="adm-hero">
        <div class="adm-hero-left">
            <div class="adm-hero-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <div class="adm-hero-title">Registrar Asistencia</div>
                <div class="adm-hero-sub">Selecciona el grado, materia y fecha para comenzar</div>
            </div>
        </div>
        <a href="{{ route('asistencias.index') }}" class="btn-volver"
           style="border-color:rgba(255,255,255,.4);color:#fff;background:rgba(255,255,255,.12);">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    {{-- Card con selector de contexto --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-filter"></i>
            <span>Filtro de registro</span>
        </div>

        {{--
            IMPORTANTE: este formulario es SOLO para los selectores de contexto (GET).
            El formulario de asistencia (POST) está completamente separado abajo.
            Nunca deben anidarse.
        --}}
        <form method="GET" action="{{ route('asistencias.create') }}" id="formContexto">
            <div class="rc-context">
                <div class="rc-field">
                    <label class="rc-label"><i class="fas fa-school"></i> Grado</label>
                    <select name="grado_id" class="rc-select" id="selGrado"
                            onchange="document.getElementById('formContexto').submit()">
                        <option value="">— Seleccionar grado —</option>
                        @foreach($grados as $g)
                            <option value="{{ $g->id }}"
                                {{ $gradoSeleccionado?->id == $g->id ? 'selected' : '' }}>
                                {{ $g->numero }}° {{ ucfirst($g->nivel) }} &mdash; Secci&oacute;n {{ $g->seccion }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="rc-field">
                    <label class="rc-label"><i class="fas fa-book"></i> Materia</label>
                    <select name="materia_id" class="rc-select"
                            {{ !$gradoSeleccionado ? 'disabled' : '' }}
                            onchange="document.getElementById('formContexto').submit()">
                        <option value="">— Seleccionar materia —</option>
                        @foreach($materias as $m)
                            <option value="{{ $m->id }}"
                                {{ $materiaSeleccionada?->id == $m->id ? 'selected' : '' }}>
                                {{ $m->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="rc-field">
                    <label class="rc-label"><i class="fas fa-calendar-alt"></i> Fecha</label>
                    <input type="date" name="fecha" class="rc-input"
                           value="{{ $fechaSeleccionada }}"
                           max="{{ now()->toDateString() }}"
                           onchange="document.getElementById('formContexto').submit()">
                </div>
            </div>
        </form>{{-- fin formContexto --}}

        @if($gradoSeleccionado && $materiaSeleccionada && $estudiantes->isNotEmpty())

            {{-- Botones masivos (fuera del form, usan JS para marcar radios) --}}
            <div class="bulk-bar">
                <span class="bulk-label">Marcar todos como:</span>
                <button type="button" class="bulk-btn bb-presente" onclick="marcarTodos('presente')">
                    <i class="fas fa-check-circle"></i> Presentes
                </button>
                <button type="button" class="bulk-btn bb-ausente" onclick="marcarTodos('ausente')">
                    <i class="fas fa-times-circle"></i> Ausentes
                </button>
                <button type="button" class="bulk-btn bb-tardanza" onclick="marcarTodos('tardanza')">
                    <i class="fas fa-clock"></i> Tardanzas
                </button>
            </div>

            {{-- Contadores --}}
            <div class="counters">
                <div class="counter-item" style="color:#10b981;">
                    <i class="fas fa-check-circle"></i>
                    Presentes: <strong id="cntPresentes">0</strong>
                </div>
                <div class="counter-item" style="color:#ef4444;">
                    <i class="fas fa-times-circle"></i>
                    Ausentes: <strong id="cntAusentes">0</strong>
                </div>
                <div class="counter-item" style="color:#f59e0b;">
                    <i class="fas fa-clock"></i>
                    Tardanzas: <strong id="cntTardanzas">0</strong>
                </div>
                <div class="counter-item" style="color:#4ec7d2;">
                    <i class="fas fa-file-alt"></i>
                    Justificados: <strong id="cntJustificados">0</strong>
                </div>
                <div class="counter-item" style="color:#94a3b8;margin-left:auto;">
                    Total: <strong>{{ $estudiantes->count() }}</strong>
                </div>
            </div>

            {{--
                Formulario POST de asistencia — completamente independiente del formContexto.
                No tiene ningun elemento que haga submit automatico.
            --}}
            <form method="POST" action="{{ route('asistencias.store') }}" id="formAsistencia">
                @csrf
                <input type="hidden" name="grado_id"   value="{{ $gradoSeleccionado->id }}">
                <input type="hidden" name="materia_id" value="{{ $materiaSeleccionada->id }}">
                <input type="hidden" name="fecha"      value="{{ $fechaSeleccionada }}">

                <div style="overflow-x:auto;">
                    <table class="est-table">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Estudiante</th>
                                <th style="width:110px;">DNI</th>
                                <th>Estado</th>
                                <th>Observaci&oacute;n</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $i => $est)
                            @php $asist = $asistenciasExistentes->get($est->id); @endphp
                            <tr>
                                <td style="color:#94a3b8;font-size:.75rem;">{{ $i + 1 }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.65rem;">
                                        <div class="av">{{ strtoupper(substr($est->nombre1, 0, 1)) }}</div>
                                        <div style="font-weight:700;color:var(--c-dark);">
                                            {{ $est->nombre1 }} {{ $est->nombre2 }}
                                            {{ $est->apellido1 }} {{ $est->apellido2 }}
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:.75rem;color:#64748b;font-family:monospace;">
                                    {{ $est->dni }}
                                </td>
                                <td>
                                    <div class="estado-group">
                                        @foreach(['presente' => '&#10003; Presente', 'ausente' => '&#10007; Ausente', 'tardanza' => '&#9201; Tardanza', 'justificado' => '&#128196; Justificado'] as $val => $lbl)
                                        <input type="radio"
                                               name="asistencias[{{ $est->id }}][estado]"
                                               value="{{ $val }}"
                                               id="est{{ $est->id }}_{{ $val }}"
                                               class="estado-radio asist-radio"
                                               data-tipo="{{ $val }}"
                                               {{ ($asist?->estado ?? 'presente') === $val ? 'checked' : '' }}
                                               onchange="actualizarContadores()">
                                        <label for="est{{ $est->id }}_{{ $val }}" class="estado-label">{!! $lbl !!}</label>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <input type="text"
                                           name="asistencias[{{ $est->id }}][observacion]"
                                           class="obs-input"
                                           placeholder="Opcional..."
                                           value="{{ $asist?->observacion ?? '' }}"
                                           maxlength="200">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="rc-footer">
                    <div style="font-size:.78rem;color:var(--c-muted);">
                        <i class="fas fa-info-circle me-1" style="color:var(--c-teal);"></i>
                        {{ $gradoSeleccionado->numero }}° {{ ucfirst($gradoSeleccionado->nivel) }}
                        &mdash; Secci&oacute;n {{ $gradoSeleccionado->seccion }}
                        &nbsp;&middot;&nbsp; {{ $materiaSeleccionada->nombre }}
                        &nbsp;&middot;&nbsp; {{ \Carbon\Carbon::parse($fechaSeleccionada)->format('d/m/Y') }}
                    </div>
                    <button type="submit" class="btn-guardar">
                        <i class="fas fa-save"></i> Guardar Asistencia
                    </button>
                </div>
            </form>{{-- fin formAsistencia --}}

        @elseif($gradoSeleccionado && $materiaSeleccionada && $estudiantes->isEmpty())
            <div class="rc-empty">
                <i class="fas fa-user-slash"></i>
                <p style="font-weight:600;">No hay estudiantes asignados a este grado</p>
            </div>
        @elseif($gradoSeleccionado && $materias->isEmpty())
            <div class="rc-empty">
                <i class="fas fa-book-open"></i>
                <p style="font-weight:600;">No hay materias asignadas a este grado</p>
                <a href="{{ route('grados.asignar-materias', $gradoSeleccionado) }}"
                   style="display:inline-flex;align-items:center;gap:.4rem;margin-top:.5rem;
                          background:var(--c-primary);color:#fff;padding:.45rem 1rem;
                          border-radius:8px;text-decoration:none;font-size:.82rem;font-weight:700;">
                    <i class="fas fa-tasks"></i> Asignar Materias
                </a>
            </div>
        @else
            <div class="rc-empty">
                <i class="fas fa-hand-point-up"></i>
                <p style="font-weight:600;">Selecciona un grado, materia y fecha para comenzar</p>
            </div>
        @endif

    </div>{{-- fin adm-card --}}

</div>
@endsection

@push('scripts')
<script>
function marcarTodos(estado) {
    document.querySelectorAll('.asist-radio[value="' + estado + '"]').forEach(function(r) {
        r.checked = true;
    });
    actualizarContadores();
}

function actualizarContadores() {
    var cnt = { presente: 0, ausente: 0, tardanza: 0, justificado: 0 };
    document.querySelectorAll('.asist-radio:checked').forEach(function(r) {
        cnt[r.dataset.tipo] = (cnt[r.dataset.tipo] || 0) + 1;
    });
    document.getElementById('cntPresentes').textContent    = cnt.presente    || 0;
    document.getElementById('cntAusentes').textContent     = cnt.ausente     || 0;
    document.getElementById('cntTardanzas').textContent    = cnt.tardanza    || 0;
    document.getElementById('cntJustificados').textContent = cnt.justificado || 0;
}

document.addEventListener('DOMContentLoaded', actualizarContadores);
</script>
@endpush