@extends('layouts.app')

@section('title', 'Asignar Materias — {{ $grado->nombreCompleto }}')
@section('page-title', 'Asignar Materias al Grado')

@push('styles')
<style>
:root {
    --c-primary: #00508f;
    --c-dark:    #003b73;
    --c-teal:    #4ec7d2;
    --c-green:   #10b981;
    --c-amber:   #f59e0b;
    --c-red:     #ef4444;
    --c-border:  #e2e8f0;
    --c-surface: #f8fafc;
    --c-muted:   #64748b;
}

.am-header {
    border-radius: 14px 14px 0 0;
    background: linear-gradient(135deg, #002d5a 0%, var(--c-primary) 60%, #0077b6 100%);
    padding: 1.5rem 1.75rem;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 1rem;
}
.am-header h4   { color: white; font-weight: 800; margin: 0 0 .35rem; font-size: 1.2rem; }
.am-header-sub  { color: rgba(255,255,255,.7); font-size: .83rem; }
.am-chip {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .65rem; border-radius: 999px; font-size: .7rem; font-weight: 700;
    background: rgba(255,255,255,.15); color: white; border: 1px solid rgba(255,255,255,.3);
    margin-right: .35rem;
}
.am-count-box {
    background: white; border-radius: 10px; padding: .75rem 1.25rem; text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}
.am-count-box .num { font-size: 1.75rem; font-weight: 800; color: var(--c-primary); line-height: 1; }
.am-count-box .lbl { font-size: .72rem; color: var(--c-muted); margin-top: .2rem; }

.am-body {
    background: white; border: 1px solid var(--c-border); border-top: none;
    border-radius: 0 0 14px 14px;
    box-shadow: 0 4px 16px rgba(0,59,115,.08);
    padding: 1.5rem;
}

.am-rules {
    background: #fffbeb; border: 1px solid #fcd34d; border-left: 4px solid var(--c-amber);
    border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
}
.am-rules-title { font-weight: 700; color: #92400e; font-size: .85rem; margin-bottom: .5rem; }
.am-rules ul    { margin: 0; padding-left: 1.25rem; color: #78350f; font-size: .8rem; }
.am-rules ul li { margin-bottom: .25rem; }

.tipo-section {
    background: var(--c-surface); border: 1.5px solid var(--c-border);
    border-radius: 12px; margin-bottom: 1.25rem; overflow: hidden;
}
.tipo-section-head {
    padding: .85rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
    border-bottom: 1px solid var(--c-border);
    font-weight: 700; font-size: .85rem; color: var(--c-dark);
}
.tipo-section-head i { color: var(--c-teal); }
.tipo-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .18rem .6rem; border-radius: 999px; font-size: .68rem; font-weight: 700;
    margin-left: auto;
}
.tb-principal    { background: rgba(0,80,143,.1); color: var(--c-primary); }
.tb-especialista { background: rgba(16,185,129,.1); color: #065f46; }

.am-table { width: 100%; border-collapse: collapse; }
.am-table thead th {
    font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em;
    color: var(--c-muted); background: white; padding: .6rem 1rem;
    border-bottom: 1.5px solid var(--c-border); text-align: left; white-space: nowrap;
}
.am-table tbody td {
    padding: .65rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .83rem; vertical-align: middle;
}
.am-table tbody tr:last-child td { border-bottom: none; }
.am-table tbody tr:hover td { background: #f0f7ff; }

/*
 * FIX PRINCIPAL: antes era pointer-events:none en toda la fila,
 * lo que bloqueaba el propio checkbox. Ahora solo se aplica
 * opacity y se deshabilita cada input/select individualmente
 * mediante la clase .row-disabled — el checkbox queda siempre clickeable.
 */
.am-table tbody tr.row-disabled td:not(:first-child) {
    opacity: .4;
    pointer-events: none;
}
/* El checkbox de la primera celda SIEMPRE es interactuable */
.am-table tbody tr.row-disabled td:first-child {
    opacity: 1;
    pointer-events: auto;
}

.am-cb {
    width: 18px; height: 18px; cursor: pointer;
    accent-color: var(--c-teal);
}

.am-select {
    padding: .4rem .7rem; border: 1.5px solid var(--c-border); border-radius: 8px;
    font-size: .8rem; color: var(--c-dark); background: var(--c-surface);
    outline: none; transition: border-color .15s; width: 100%; min-width: 180px;
}
.am-select:focus { border-color: var(--c-teal); background: white; }
.am-select.warn  { border-color: var(--c-red); background: #fff1f2; }

.am-hrs {
    width: 65px; padding: .4rem .5rem; border: 1.5px solid var(--c-border);
    border-radius: 8px; font-size: .83rem; font-weight: 700; text-align: center;
    color: var(--c-primary); outline: none; transition: border-color .15s;
}
.am-hrs:focus { border-color: var(--c-teal); }

.mat-tipo {
    display: inline-flex; align-items: center; gap: .25rem;
    padding: .15rem .5rem; border-radius: 6px; font-size: .67rem; font-weight: 700;
}
.mt-basica       { background: rgba(0,80,143,.08); color: var(--c-primary); }
.mt-especialidad { background: rgba(16,185,129,.08); color: #065f46; }

.am-warn-tag {
    display: inline-flex; align-items: center; gap: .25rem;
    font-size: .67rem; font-weight: 700; color: var(--c-red);
    background: rgba(239,68,68,.08); padding: .15rem .5rem; border-radius: 6px;
}

.principal-selector {
    background: rgba(0,80,143,.04); border: 1.5px solid rgba(0,80,143,.15);
    border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
}
.principal-selector label { font-weight: 700; color: var(--c-dark); font-size: .85rem; white-space: nowrap; }
.principal-selector select {
    flex: 1; min-width: 200px;
    padding: .45rem .85rem; border: 1.5px solid var(--c-border); border-radius: 8px;
    font-size: .85rem; color: var(--c-dark); background: white; outline: none;
}
.principal-selector select:focus { border-color: var(--c-teal); }
.principal-hint { font-size: .75rem; color: var(--c-muted); }

.am-footer {
    border-top: 1px solid var(--c-border); padding-top: 1.25rem; margin-top: 1.25rem;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
}
.am-footer-stats { display: flex; gap: 1.5rem; }
.am-fstat { text-align: center; }
.am-fstat .n { font-size: 1.4rem; font-weight: 800; color: var(--c-primary); line-height: 1; }
.am-fstat .l { font-size: .68rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: .06em; }

.btn-save {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .6rem 1.75rem; border-radius: 9px; font-size: .875rem; font-weight: 700;
    background: linear-gradient(135deg, var(--c-green), #059669); color: white;
    border: none; cursor: pointer; transition: all .2s;
}
.btn-save:hover { opacity: .88; transform: translateY(-1px); }
.btn-back {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .6rem 1.25rem; border-radius: 9px; font-size: .875rem; font-weight: 600;
    background: white; color: var(--c-muted); border: 1.5px solid var(--c-border);
    text-decoration: none; transition: border-color .15s;
}
.btn-back:hover { border-color: #94a3b8; color: var(--c-dark); }

.conflict-alert {
    display: none; background: #fff1f2; border: 1px solid #fca5a5; border-left: 4px solid var(--c-red);
    border-radius: 8px; padding: .75rem 1rem; margin-top: 1rem; font-size: .8rem; color: #991b1b;
}
</style>
@endpush

@section('content')

@php
    $materiasBasicas = $materias->filter(fn($m) => !in_array($m->area, [
        'Inglés', 'Educación Física', 'Educación Artística', 'Informática'
    ]));
    $materiasEspecialidad = $materias->filter(fn($m) => in_array($m->area, [
        'Inglés', 'Educación Física', 'Educación Artística', 'Informática'
    ]));

    $profesorPrincipalId = $grado->materias
        ->whereIn('id', $materiasBasicas->pluck('id'))
        ->groupBy(fn($m) => $m->pivot->profesor_id)
        ->sortByDesc(fn($g) => $g->count())
        ->keys()->first();
@endphp

{{-- Header --}}
<div class="am-header">
    <div>
        <h4><i class="fas fa-school me-2"></i>{{ $grado->numero }}° Grado
            @if($grado->seccion) — Sección {{ $grado->seccion }} @endif
        </h4>
        <div class="am-header-sub">
            <span class="am-chip"><i class="fas fa-layer-group"></i> {{ ucfirst($grado->nivel) }}</span>
            <span class="am-chip"><i class="fas fa-calendar"></i> {{ $grado->anio_lectivo }}</span>
        </div>
    </div>
    <div class="am-count-box">
        <div class="num" id="headerCount">{{ count($materiasAsignadas) }}</div>
        <div class="lbl">Materias asignadas</div>
    </div>
</div>

{{-- Body --}}
<div class="am-body">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4"
             style="border-radius:9px;border-left:4px solid var(--c-green);font-size:.83rem;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4"
             style="border-radius:9px;border-left:4px solid var(--c-red);font-size:.83rem;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="am-rules">
        <div class="am-rules-title"><i class="fas fa-info-circle me-1"></i> Reglas de asignación</div>
        <ul>
            <li><strong>Profesor principal</strong> — imparte todas las materias básicas de este grado</li>
            <li><strong>Profesores especialistas</strong> — imparten una sola materia pero pueden dar en varios grados</li>
            <li>Un profesor <strong>no puede repetir horario</strong> en dos grados al mismo tiempo</li>
            <li>Las materias básicas deben tener el <strong>mismo profesor principal</strong></li>
        </ul>
    </div>

    @if($materias->isEmpty())
        <div style="text-align:center;padding:3rem 1rem;">
            <i class="fas fa-inbox" style="font-size:2.5rem;color:#cbd5e1;display:block;margin-bottom:.75rem;"></i>
            <p style="font-weight:600;color:var(--c-muted);">No hay materias de nivel {{ ucfirst($grado->nivel) }} creadas aún.</p>
            <a href="{{ route('materias.create') }}" class="btn-save" style="display:inline-flex;margin-top:.5rem;">
                <i class="fas fa-plus"></i> Crear Materia
            </a>
        </div>
    @else

    <form action="{{ route('grados.guardar-materias', $grado) }}" method="POST" id="formAsignar">
        @csrf

        @if($materiasBasicas->isNotEmpty())
        <div class="principal-selector">
            <label><i class="fas fa-user-tie me-1" style="color:var(--c-teal);"></i> Profesor Principal del Grado:</label>
            <select id="selectPrincipal">
                <option value="">— Seleccionar profesor principal —</option>
                @foreach($profesores as $prof)
                    <option value="{{ $prof->id }}"
                        {{ $profesorPrincipalId == $prof->id ? 'selected' : '' }}>
                        {{ $prof->nombre }} {{ $prof->apellido }}
                        @if($prof->especialidad) ({{ $prof->especialidad }}) @endif
                    </option>
                @endforeach
            </select>
            <div>
                <div style="font-size:.8rem;font-weight:600;color:var(--c-dark);">
                    <i class="fas fa-bolt" style="color:var(--c-amber);"></i>
                    Asigna automáticamente a todas las materias básicas
                </div>
                <div class="principal-hint">Las materias de especialidad mantienen su propio profesor</div>
            </div>
        </div>
        @endif

        {{-- Materias Básicas --}}
        @if($materiasBasicas->isNotEmpty())
        <div class="tipo-section">
            <div class="tipo-section-head">
                <i class="fas fa-book"></i>
                Materias Básicas
                <span class="tipo-badge tb-principal">
                    <i class="fas fa-user-tie"></i> Profesor Principal
                </span>
            </div>
            <table class="am-table">
                <thead>
                    <tr>
                        <th style="width:40px;">✓</th>
                        <th>Materia</th>
                        <th>Código</th>
                        <th>Profesor</th>
                        <th style="width:90px;">Hrs/sem</th>
                    </tr>
                </thead>
                <tbody id="tbodyBasicas">
                    @foreach($materiasBasicas as $materia)
                    @php
                        $asignada    = in_array($materia->id, $materiasAsignadas);
                        $profAsig    = $grado->materias->find($materia->id)?->pivot->profesor_id;
                        $horasAsig   = $grado->materias->find($materia->id)?->pivot->horas_semanales ?? 4;
                        $esConflicto = $asignada && $profAsig && $profAsig != $profesorPrincipalId && $profesorPrincipalId;
                    @endphp
                    <tr class="mat-row {{ !$asignada ? 'row-disabled' : '' }}" data-tipo="basica">
                        <td>
                            <input type="checkbox" name="materias[]" value="{{ $materia->id }}"
                                   class="am-cb mat-cb"
                                   {{ $asignada ? 'checked' : '' }}>
                        </td>
                        <td>
                            <div style="font-weight:600;color:var(--c-dark);">{{ $materia->nombre }}</div>
                            <span class="mat-tipo mt-basica">Básica</span>
                        </td>
                        <td>
                            <code style="background:rgba(78,199,210,.1);padding:.1rem .4rem;border-radius:4px;font-size:.75rem;">
                                {{ $materia->codigo }}
                            </code>
                        </td>
                        <td>
                            <select name="profesor[{{ $materia->id }}]"
                                    class="am-select prof-select-basica {{ $esConflicto ? 'warn' : '' }}"
                                    data-materia="{{ $materia->id }}">
                                <option value="">Sin asignar</option>
                                @foreach($profesores as $prof)
                                    <option value="{{ $prof->id }}"
                                        {{ $profAsig == $prof->id ? 'selected' : '' }}>
                                        {{ $prof->nombre }} {{ $prof->apellido }}
                                    </option>
                                @endforeach
                            </select>
                            @if($esConflicto)
                                <span class="am-warn-tag mt-1">
                                    <i class="fas fa-exclamation-triangle"></i> Profesor diferente al principal
                                </span>
                            @endif
                        </td>
                        <td>
                            <input type="number" name="horas[{{ $materia->id }}]"
                                   class="am-hrs" min="1" max="10"
                                   value="{{ $horasAsig }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Materias de Especialidad --}}
        @if($materiasEspecialidad->isNotEmpty())
        <div class="tipo-section">
            <div class="tipo-section-head">
                <i class="fas fa-star"></i>
                Materias de Especialidad
                <span class="tipo-badge tb-especialista">
                    <i class="fas fa-medal"></i> Profesor Especialista
                </span>
            </div>
            <div style="padding:.75rem 1.25rem;background:#f0fdf4;border-bottom:1px solid var(--c-border);font-size:.78rem;color:#065f46;">
                <i class="fas fa-info-circle me-1"></i>
                Estos profesores pueden dar la misma materia en <strong>múltiples grados</strong>.
            </div>
            <table class="am-table">
                <thead>
                    <tr>
                        <th style="width:40px;">✓</th>
                        <th>Materia</th>
                        <th>Código</th>
                        <th>Especialista</th>
                        <th style="width:90px;">Hrs/sem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materiasEspecialidad as $materia)
                    @php
                        $asignada  = in_array($materia->id, $materiasAsignadas);
                        $profAsig  = $grado->materias->find($materia->id)?->pivot->profesor_id;
                        $horasAsig = $grado->materias->find($materia->id)?->pivot->horas_semanales ?? 3;
                    @endphp
                    <tr class="mat-row {{ !$asignada ? 'row-disabled' : '' }}" data-tipo="especialidad">
                        <td>
                            <input type="checkbox" name="materias[]" value="{{ $materia->id }}"
                                   class="am-cb mat-cb"
                                   {{ $asignada ? 'checked' : '' }}>
                        </td>
                        <td>
                            <div style="font-weight:600;color:var(--c-dark);">{{ $materia->nombre }}</div>
                            <span class="mat-tipo mt-especialidad">Especialidad</span>
                        </td>
                        <td>
                            <code style="background:rgba(16,185,129,.1);padding:.1rem .4rem;border-radius:4px;font-size:.75rem;">
                                {{ $materia->codigo }}
                            </code>
                        </td>
                        <td>
                            <select name="profesor[{{ $materia->id }}]"
                                    class="am-select"
                                    data-materia="{{ $materia->id }}">
                                <option value="">Sin asignar</option>
                                @foreach($profesores as $prof)
                                    <option value="{{ $prof->id }}"
                                        {{ $profAsig == $prof->id ? 'selected' : '' }}>
                                        {{ $prof->nombre }} {{ $prof->apellido }}
                                        @if($prof->especialidad) — {{ $prof->especialidad }} @endif
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="horas[{{ $materia->id }}]"
                                   class="am-hrs" min="1" max="10"
                                   value="{{ $horasAsig }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="conflict-alert" id="conflictAlert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <span id="conflictMsg"></span>
        </div>

        <div class="am-footer">
            <div class="am-footer-stats">
                <div class="am-fstat">
                    <div class="n" id="statSeleccionadas">0</div>
                    <div class="l">Seleccionadas</div>
                </div>
                <div class="am-fstat">
                    <div class="n" id="statHoras">0</div>
                    <div class="l">Horas/sem</div>
                </div>
                <div class="am-fstat">
                    <div class="n" id="statConProfesor">0</div>
                    <div class="l">Con profesor</div>
                </div>
            </div>
            <div style="display:flex;gap:.75rem;align-items:center;">
                <a href="{{ route('grados.show', $grado) }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Guardar Asignación
                </button>
            </div>
        </div>

    </form>
    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Profesor principal → asigna a todas las básicas
    var selectPrincipal = document.getElementById('selectPrincipal');
    if (selectPrincipal) {
        selectPrincipal.addEventListener('change', function () {
            var profId = this.value;
            document.querySelectorAll('.prof-select-basica').forEach(function (sel) {
                sel.value = profId;
                sel.classList.remove('warn');
            });
            actualizarStats();
        });
    }

    // Marcar/desmarcar checkbox habilita o deshabilita el resto de la fila
    // IMPORTANTE: el listener va en el checkbox, no en la fila,
    // para que siempre sea accesible independientemente del estado de la fila.
    document.querySelectorAll('.mat-cb').forEach(function (cb) {
        cb.addEventListener('change', function () {
            var row = this.closest('tr');
            if (this.checked) {
                row.classList.remove('row-disabled');
            } else {
                row.classList.add('row-disabled');
            }
            actualizarStats();
        });
    });

    document.querySelectorAll('.prof-select-basica').forEach(function (sel) {
        sel.addEventListener('change', function () {
            verificarConflictos();
            actualizarStats();
        });
    });

    function verificarConflictos() {
        var profIds = new Set();
        document.querySelectorAll('.prof-select-basica').forEach(function (sel) {
            var row = sel.closest('tr');
            if (!row.classList.contains('row-disabled') && sel.value) {
                profIds.add(sel.value);
            }
        });
        var alertEl = document.getElementById('conflictAlert');
        var msgEl   = document.getElementById('conflictMsg');
        if (profIds.size > 1) {
            alertEl.style.display = 'block';
            msgEl.textContent = 'Las materias básicas tienen ' + profIds.size +
                ' profesores diferentes. En primaria, las materias básicas deben tener un solo profesor principal. ¿Deseas continuar?';
        } else {
            alertEl.style.display = 'none';
        }
    }

    function actualizarStats() {
        var seleccionadas = 0, totalHoras = 0, conProfesor = 0;
        document.querySelectorAll('.mat-cb').forEach(function (cb) {
            if (cb.checked) {
                seleccionadas++;
                var row = cb.closest('tr');
                totalHoras += parseInt(row.querySelector('.am-hrs')?.value) || 0;
                var sel = row.querySelector('.am-select');
                if (sel && sel.value) conProfesor++;
            }
        });
        document.getElementById('statSeleccionadas').textContent = seleccionadas;
        document.getElementById('statHoras').textContent         = totalHoras;
        document.getElementById('statConProfesor').textContent   = conProfesor;
        document.getElementById('headerCount').textContent       = seleccionadas;
    }

    document.querySelectorAll('.am-hrs').forEach(function (inp) {
        inp.addEventListener('input', actualizarStats);
    });

    document.getElementById('formAsignar')?.addEventListener('submit', function (e) {
        if (document.querySelectorAll('.mat-cb:checked').length === 0) {
            e.preventDefault();
            alert('Selecciona al menos una materia para guardar.');
        }
    });

    actualizarStats();
    verificarConflictos();
});
</script>
@endpush

@endsection