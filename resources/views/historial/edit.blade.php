@extends('layouts.app')

@section('title', 'Editar Historial — ' . $estudiante->nombre1)
@section('page-title', 'Editar Historial Académico')

@section('topbar-actions')
    <a href="{{ route('superadmin.estudiantes.historial.show', $estudiante->id) }}"
       class="hedit-btn-ghost">
        <i class="fas fa-times"></i>
        <span class="hedit-btn-text">Cancelar</span>
    </a>
@endsection

@push('styles')
<style>
    .hedit-btn-ghost {
        display: inline-flex; align-items: center; gap: .45rem;
        background: transparent; color: white;
        padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        border: 1.5px solid rgba(255,255,255,.35); white-space: nowrap;
        transition: background .2s;
    }
    .hedit-btn-ghost:hover { background: rgba(255,255,255,.12); color: white; }
    @media(max-width:600px) {
        .hedit-btn-text { display: none; }
        .hedit-btn-ghost { padding: .5rem .65rem; }
    }

    :root {
        --blue-dark:  #003b73;
        --blue-mid:   #00508f;
        --teal:       #4ec7d2;
        --teal-light: rgba(78,199,210,0.12);
        --border:     #e8edf4;
        --surface:    #f5f8fc;
        --text-main:  #0d2137;
        --text-muted: #6b7a90;
        --green:      #10b981;
        --red:        #ef4444;
        --amber:      #f59e0b;
        --radius-lg:  14px;
        --shadow-sm:  0 1px 4px rgba(0,59,115,0.07);
    }

    .hedit-perfil {
        background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
        border-radius: var(--radius-lg); padding: 1.25rem 1.5rem;
        display: flex; align-items: center; gap: 1rem;
        margin-bottom: 1.25rem; position: relative; overflow: hidden;
    }
    .hedit-perfil::after {
        content: '\f044'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%);
        font-size: 5rem; color: rgba(255,255,255,.06); pointer-events: none;
    }
    .hedit-av {
        width: 58px; height: 58px; border-radius: 13px; flex-shrink: 0;
        background: rgba(255,255,255,.15); border: 2px solid #4ec7d2;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; font-weight: 800; color: white; overflow: hidden;
    }
    .hedit-av img { width: 100%; height: 100%; object-fit: cover; }
    .hedit-nombre { font-size: 1.1rem; font-weight: 800; color: white; margin: 0 0 .3rem; }
    .hedit-meta   { display: flex; flex-wrap: wrap; gap: .75rem; font-size: .79rem; color: rgba(255,255,255,.85); }
    .hedit-meta span { display: flex; align-items: center; gap: .3rem; }

    .hedit-aviso {
        display: flex; align-items: flex-start; gap: .65rem;
        padding: .8rem 1rem; border-radius: 9px;
        background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.3);
        margin-bottom: 1.25rem; font-size: .81rem; color: #92400e;
    }

    .hedit-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .hedit-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .hedit-card-head i    { color: var(--teal); font-size: 1rem; }
    .hedit-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    .hedit-ciclo {
        border: 1px solid var(--border); border-radius: 10px;
        overflow: hidden; margin: 1.25rem 1.25rem 0;
    }
    .hedit-ciclo:last-of-type { margin-bottom: 0; }
    .hedit-ciclo-head {
        background: var(--surface); padding: .6rem 1.1rem;
        display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;
        border-bottom: 1px solid var(--border);
        font-weight: 700; color: var(--blue-dark); font-size: .82rem;
    }

    .hedit-tbl-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .hedit-tbl { width: 100%; border-collapse: collapse; min-width: 580px; }
    .hedit-tbl thead th {
        background: var(--surface); padding: .6rem .85rem;
        font-size: .67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .hedit-tbl thead th.tc { text-align: center; }
    .hedit-tbl tbody td {
        padding: .6rem .85rem; border-bottom: 1px solid #f1f5f9;
        vertical-align: middle; font-size: .82rem;
    }
    .hedit-tbl tbody td.tc { text-align: center; }
    .hedit-tbl tbody tr:last-child td { border-bottom: none; }
    .hedit-tbl tbody tr:hover { background: #f7fbff; }

    .nota-materia { font-weight: 600; color: var(--blue-dark); font-size: .84rem; }
    .nota-periodo { font-size: .7rem; color: var(--text-muted); margin-top: .1rem; }

    .input-nota {
        width: 72px; padding: .38rem .5rem;
        border: 2px solid #bfd9ea; border-radius: 7px;
        text-align: center; font-weight: 700; font-size: .85rem;
        color: var(--text-main); font-family: 'Courier New', monospace;
        outline: none; transition: border-color .2s, box-shadow .2s; background: white;
    }
    .input-nota:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); }
    .input-nota.nota-alta  { border-color: rgba(16,185,129,.4); color: #059669; }
    .input-nota.nota-media { border-color: rgba(245,158,11,.4); color: #92400e; }
    .input-nota.nota-baja  { border-color: rgba(239,68,68,.35); color: #dc2626; }

    .promedio-calc { font-size: .92rem; font-weight: 800; min-width: 52px; display: inline-block; text-align: center; }
    .calc-ok  { color: #059669; }
    .calc-nok { color: var(--red); }
    .calc-nd  { color: #94a3b8; font-weight: 600; font-size: .8rem; }

    .bpill {
        display: inline-flex; align-items: center; gap: .22rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .68rem; font-weight: 700; white-space: nowrap;
    }
    .b-green   { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.3); }
    .b-red     { background: rgba(239,68,68,.1);  color: #dc2626; border: 1px solid rgba(239,68,68,.25); }
    .b-pending { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }

    .pct-badge {
        font-size: .62rem; font-weight: 700; color: var(--text-muted);
        background: var(--surface); border: 1px solid var(--border);
        padding: .1rem .4rem; border-radius: 4px; display: block;
        margin-top: .2rem; text-align: center;
    }

    .hedit-footer {
        padding: 1.1rem 1.4rem; border-top: 1px solid var(--border);
        background: var(--surface); margin-top: 1.25rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .75rem;
    }
    .btn-guardar {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .65rem 1.6rem; border-radius: 9px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: white; border: none; font-size: .88rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        box-shadow: 0 3px 10px rgba(0,80,143,.25);
        transition: opacity .2s, transform .15s;
    }
    .btn-guardar:hover  { opacity: .88; transform: translateY(-1px); }
    .btn-guardar:active { transform: translateY(0); }
    .btn-cancelar {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .65rem 1.1rem; border-radius: 9px;
        background: white; color: var(--text-muted);
        border: 1.5px solid var(--border);
        font-size: .88rem; font-weight: 600;
        text-decoration: none; transition: all .2s;
    }
    .btn-cancelar:hover { border-color: #94a3b8; color: var(--text-main); }
</style>
@endpush

@section('content')
<div>

    {{-- ── Perfil ── --}}
    <div class="hedit-perfil">
        <div class="hedit-av">
            @if($estudiante->foto)
                <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto">
            @else
                {{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1 ?? '', 0, 1)) }}
            @endif
        </div>
        <div style="position:relative;z-index:1;">
            <div class="hedit-nombre">
                {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
            </div>
            <div class="hedit-meta">
                <span><i class="fas fa-id-card"></i> {{ $estudiante->dni }}</span>
                <span><i class="fas fa-layer-group"></i> {{ $estudiante->grado ?? 'N/A' }}</span>
                <span><i class="fas fa-sitemap"></i> Sección {{ $estudiante->seccion ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    {{-- ── Aviso ── --}}
    <div class="hedit-aviso">
        <i class="fas fa-exclamation-triangle" style="flex-shrink:0;margin-top:1px;color:var(--amber);"></i>
        <span>
            Modo edición administrativa. El <strong>promedio</strong> se recalcula al guardar
            usando los porcentajes configurados por materia
            (<strong>Tarea 20% · Parcial 30% · Final 50%</strong> por defecto).
        </span>
    </div>

    {{-- ── Formulario ── --}}
    <form action="{{ route('superadmin.estudiantes.historial.update', $estudiante->id) }}"
          method="POST" id="form-historial">
        @csrf
        @method('PUT')

        @php
            $notasAgrupadas = $estudiante->calificaciones
                ->groupBy(fn($n) => $n->periodo->anio_lectivo ?? 'Ciclo Actual');
        @endphp

        <div class="hedit-card">
            <div class="hedit-card-head">
                <i class="fas fa-pen-to-square"></i>
                <span>Actualizar calificaciones</span>
            </div>

            @forelse($notasAgrupadas as $anio => $notas)
                <div class="hedit-ciclo">
                    <div class="hedit-ciclo-head">
                        <i class="fas fa-calendar-alt" style="color:var(--teal);font-size:.82rem;"></i>
                        Ciclo Lectivo: {{ $anio }}
                        <span style="margin-left:auto;font-size:.72rem;font-weight:600;color:var(--text-muted);">
                            {{ $notas->count() }} {{ $notas->count() == 1 ? 'materia' : 'materias' }}
                        </span>
                    </div>
                    <div class="hedit-tbl-wrap">
                        <table class="hedit-tbl">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th class="tc" style="width:95px;">
                                        Tarea
                                        <span class="pct-badge">20%</span>
                                    </th>
                                    <th class="tc" style="width:95px;">
                                        Parcial
                                        <span class="pct-badge">30%</span>
                                    </th>
                                    <th class="tc" style="width:95px;">
                                        Final
                                        <span class="pct-badge">50%</span>
                                    </th>
                                    <th class="tc" style="width:115px;">Promedio</th>
                                    <th class="tc" style="width:105px;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notas as $nota)
                                <tr data-id="{{ $nota->id }}">
                                    <td>
                                        <div class="nota-materia">{{ $nota->materia->nombre }}</div>
                                        <div class="nota-periodo">{{ $nota->periodo->nombre_periodo }}</div>
                                    </td>

                                    <td class="tc">
                                        <input type="number"
                                               name="notas[{{ $nota->id }}][nota_tarea]"
                                               class="input-nota nota-input"
                                               value="{{ $nota->nota_tarea }}"
                                               min="0" max="100" step="0.01"
                                               placeholder="—"
                                               data-row="{{ $nota->id }}"
                                               data-campo="tarea">
                                    </td>

                                    <td class="tc">
                                        <input type="number"
                                               name="notas[{{ $nota->id }}][nota_parcial]"
                                               class="input-nota nota-input"
                                               value="{{ $nota->nota_parcial }}"
                                               min="0" max="100" step="0.01"
                                               placeholder="—"
                                               data-row="{{ $nota->id }}"
                                               data-campo="parcial">
                                    </td>

                                    <td class="tc">
                                        <input type="number"
                                               name="notas[{{ $nota->id }}][nota_final]"
                                               class="input-nota nota-input"
                                               value="{{ $nota->nota_final }}"
                                               min="0" max="100" step="0.01"
                                               placeholder="—"
                                               data-row="{{ $nota->id }}"
                                               data-campo="final">
                                    </td>

                                    <td class="tc">
                                        @php
                                            $prom = $nota->promedio;
                                            $cls  = is_null($prom) ? 'calc-nd' : ($prom >= 60 ? 'calc-ok' : 'calc-nok');
                                        @endphp
                                        <span class="promedio-calc {{ $cls }}"
                                              id="prom-{{ $nota->id }}">
                                            {{ is_null($prom) ? 'Pendiente' : number_format($prom, 1).'%' }}
                                        </span>
                                    </td>

                                    <td class="tc">
                                        @php $est = $nota->estado ?? 'pendiente'; @endphp
                                        <span class="bpill {{ $est === 'aprobado' ? 'b-green' : ($est === 'reprobado' ? 'b-red' : 'b-pending') }}"
                                              id="estado-{{ $nota->id }}">
                                            <i class="fas {{ $est === 'aprobado' ? 'fa-check' : ($est === 'reprobado' ? 'fa-times' : 'fa-clock') }}"
                                               style="font-size:.52rem;"></i>
                                            {{ ucfirst($est) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div style="padding:3rem;text-align:center;color:var(--text-muted);">
                    <i class="fas fa-folder-open" style="font-size:2rem;display:block;margin-bottom:.75rem;color:#cbd5e1;"></i>
                    No hay calificaciones para editar.
                </div>
            @endforelse

            <div class="hedit-footer">
                <a href="{{ route('superadmin.estudiantes.historial.show', $estudiante->id) }}"
                   class="btn-cancelar">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn-guardar" id="btn-guardar">
                    <i class="fas fa-save"></i> Guardar calificaciones
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var PCT = { tarea: 20, parcial: 30, final: 50 };

    function colorear(input) {
        var v = parseFloat(input.value);
        input.classList.remove('nota-alta', 'nota-media', 'nota-baja');
        if (isNaN(v) || input.value.trim() === '') return;
        if (v >= 70)      input.classList.add('nota-alta');
        else if (v >= 60) input.classList.add('nota-media');
        else               input.classList.add('nota-baja');
    }

    function recalcular(rowId) {
        var inputs = document.querySelectorAll('.nota-input[data-row="' + rowId + '"]');
        var vals   = {};
        inputs.forEach(function(inp) {
            vals[inp.dataset.campo] = inp.value.trim() !== '' ? parseFloat(inp.value) : null;
        });

        var promEl   = document.getElementById('prom-' + rowId);
        var estadoEl = document.getElementById('estado-' + rowId);
        if (!promEl) return;

        var t = vals['tarea'], p = vals['parcial'], f = vals['final'];

        if (t === null && p === null && f === null) {
            promEl.textContent = 'Pendiente';
            promEl.className   = 'promedio-calc calc-nd';
            if (estadoEl) {
                estadoEl.className = 'bpill b-pending';
                estadoEl.innerHTML = '<i class="fas fa-clock" style="font-size:.52rem;"></i> Pendiente';
            }
            return;
        }

        /* Misma fórmula que el modelo */
        var prom = 0;
        if (t !== null && p !== null && f !== null) {
            prom = Math.round((t * PCT.tarea / 100 + p * PCT.parcial / 100 + f * PCT.final / 100) * 100) / 100;
        } else {
            /* Parcial: promediar solo los presentes */
            var suma = 0, total = 0;
            if (t !== null) { suma += t * PCT.tarea   / 100; total += PCT.tarea; }
            if (p !== null) { suma += p * PCT.parcial  / 100; total += PCT.parcial; }
            if (f !== null) { suma += f * PCT.final    / 100; total += PCT.final; }
            prom = total > 0 ? Math.round((suma * 100 / total) * 100) / 100 : 0;
        }

        var aprobado = prom >= 60;
        promEl.textContent = prom.toFixed(1) + '%';
        promEl.className   = 'promedio-calc ' + (aprobado ? 'calc-ok' : 'calc-nok');

        if (estadoEl) {
            estadoEl.className = 'bpill ' + (aprobado ? 'b-green' : 'b-red');
            estadoEl.innerHTML = '<i class="fas ' + (aprobado ? 'fa-check' : 'fa-times') +
                '" style="font-size:.52rem;"></i> ' + (aprobado ? 'Aprobado' : 'Reprobado');
        }
    }

    document.querySelectorAll('.nota-input').forEach(function(input) {
        colorear(input);
        input.addEventListener('input', function() {
            colorear(this);
            recalcular(this.dataset.row);
        });
    });

    document.getElementById('form-historial').addEventListener('submit', function() {
        var btn = document.getElementById('btn-guardar');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    });
})();
</script>
@endpush