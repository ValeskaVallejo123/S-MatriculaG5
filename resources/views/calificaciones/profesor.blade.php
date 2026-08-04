@extends('layouts.app')

@section('title', 'Cuadro de Calificaciones')

@push('styles')
<style>
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

    .cal-banner {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        border-radius: var(--radius-lg); padding: 1.25rem 1.75rem;
        margin-bottom: 1.5rem; display: flex; align-items: center;
        justify-content: space-between; gap: 1rem;
        box-shadow: var(--shadow-md); position: relative; overflow: hidden;
    }
    .cal-banner::after {
        content: ''; position: absolute; right: -30px; top: -30px;
        width: 130px; height: 130px; border-radius: 50%;
        background: rgba(78,199,210,.1); pointer-events: none;
    }
    .cal-banner-left { display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1; }
    .cal-banner-icon {
        width: 54px; height: 54px; border-radius: 14px; flex-shrink: 0;
        background: rgba(255,255,255,.15); border: 2px solid rgba(78,199,210,.5);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; color: var(--teal);
    }
    .cal-banner-title { font-size: 1.25rem; font-weight: 800; color: white; margin-bottom: .15rem; }
    .cal-banner-sub   { font-size: .82rem; color: rgba(255,255,255,.65); }
    .cal-banner-right { position: relative; z-index: 1; }
    .btn-volver {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .5rem 1.1rem; border-radius: 8px; font-size: .82rem;
        font-weight: 600; text-decoration: none;
        background: rgba(255,255,255,.15); color: white;
        border: 1.5px solid rgba(255,255,255,.3); transition: all .15s;
    }
    .btn-volver:hover { background: rgba(255,255,255,.25); color: white; }

    .cal-filtros {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 1rem 1.25rem;
        margin-bottom: 1.25rem; box-shadow: var(--shadow-sm);
        display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;
    }
    .cal-filtro-grupo { display: flex; flex-direction: column; gap: .35rem; flex: 1; min-width: 200px; }
    .cal-filtro-label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--text-muted); }
    .cal-filtro-grupo select {
        padding: .55rem .9rem; border-radius: 8px;
        border: 1.5px solid var(--border); background: var(--surface);
        color: var(--text-main); font-size: .88rem; font-weight: 500;
        transition: border-color .15s;
    }
    .cal-filtro-grupo select:focus { outline: none; border-color: var(--teal); }

    .mat-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); margin-bottom: 1.25rem;
        box-shadow: var(--shadow-sm); overflow: hidden;
    }
    .mat-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.25rem; display: flex; align-items: center; justify-content: space-between;
    }
    .mat-card-title { color: white; font-weight: 700; font-size: .95rem; display: flex; align-items: center; gap: .5rem; }
    .mat-card-title i { color: var(--teal); }
    .btn-pct {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .3rem .85rem; border-radius: 7px; font-size: .75rem; font-weight: 600;
        background: rgba(255,255,255,.15); color: white;
        border: 1.5px solid rgba(255,255,255,.3); cursor: pointer; transition: background .15s;
    }
    .btn-pct:hover { background: rgba(255,255,255,.25); }

    .pct-panel { background: var(--surface); border-bottom: 1px solid var(--border); padding: 1rem 1.25rem; }
    .pct-panel .form-control { border-radius: 8px; border: 1.5px solid var(--border); font-size: .85rem; }
    .pct-panel .form-control:focus { border-color: var(--teal); box-shadow: none; }
    .pct-suma-ok  { color: var(--green); font-weight: 700; }
    .pct-suma-err { color: var(--red);   font-weight: 700; }
    .btn-guardar-pct {
        background: var(--blue-mid); color: white; border: none;
        padding: .5rem 1rem; border-radius: 8px; font-size: .82rem;
        font-weight: 600; width: 100%; cursor: pointer; transition: background .15s;
    }
    .btn-guardar-pct:hover { background: var(--blue-dark); }

    .cal-tbl { width: 100%; border-collapse: collapse; }
    .cal-tbl thead th {
        background: var(--surface); padding: .65rem 1rem;
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .cal-tbl thead th.tc { text-align: center; }
    .cal-tbl tbody td { padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: .85rem; color: var(--text-main); vertical-align: middle; }
    .cal-tbl tbody td.tc { text-align: center; }
    .cal-tbl tbody tr:last-child td { border-bottom: none; }
    .cal-tbl tbody tr:hover td { background: #f7fbff; }

    .nota-inp {
        width: 76px; padding: .4rem .5rem; border-radius: 7px;
        border: 1.5px solid var(--border); background: var(--surface);
        font-size: .88rem; font-weight: 600; text-align: center;
        color: var(--blue-dark); transition: border-color .15s, background .15s;
    }
    .nota-inp:focus { outline: none; border-color: var(--teal); background: white; }
    .obs-inp {
        width: 100%; padding: .4rem .7rem; border-radius: 7px;
        border: 1.5px solid var(--border); background: var(--surface);
        font-size: .82rem; color: var(--text-main); transition: border-color .15s;
    }
    .obs-inp:focus { outline: none; border-color: var(--teal); background: white; }

    .prom-cell { font-size: 1rem; font-weight: 800; color: var(--blue-dark); }
    .bpill { display: inline-flex; align-items: center; gap: .25rem; padding: .25rem .75rem; border-radius: 999px; font-size: .72rem; font-weight: 700; white-space: nowrap; }
    .b-green { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.3); }
    .b-red   { background: rgba(239,68,68,.1);  color: #dc2626; border: 1px solid rgba(239,68,68,.25); }
    .b-amber { background: rgba(245,158,11,.12); color: #92400e; border: 1px solid rgba(245,158,11,.3); }

    .btn-guardar {
        display: inline-flex; align-items: center; gap: .5rem;
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
        color: white; border: none; padding: .6rem 1.4rem;
        border-radius: 9px; font-size: .88rem; font-weight: 700;
        cursor: pointer; transition: opacity .15s; box-shadow: var(--shadow-sm);
    }
    .btn-guardar:hover { opacity: .9; }
    .mat-footer { padding: .85rem 1.25rem; border-top: 1px solid var(--border); text-align: right; background: var(--surface); }

    .cal-empty { text-align: center; padding: 3rem 1rem; }
    .cal-empty i { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }
    .cal-empty p { color: var(--text-muted); font-size: .88rem; margin: 0; }
    .est-nombre { font-weight: 600; color: var(--blue-dark); }
</style>
@endpush

@section('content')
<div>

    {{-- Banner --}}
    <div class="cal-banner">
        <div class="cal-banner-left">
            <div class="cal-banner-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <div class="cal-banner-title">Cuadro de Calificaciones</div>
                <div class="cal-banner-sub">
                    <i class="fas fa-chalkboard-teacher" style="color:var(--teal);margin-right:.3rem;font-size:.75rem;"></i>
                    Prof. {{ $profesor->nombre_completo }}
                </div>
            </div>
        </div>
        <div class="cal-banner-right">
            <a href="{{ route('profesor.dashboard') }}" class="btn-volver">
                <i class="fas fa-arrow-left"></i> Volver al Panel
            </a>
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm"
             style="border-radius:var(--radius-lg);font-size:.88rem;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm"
             style="border-radius:var(--radius-lg);font-size:.88rem;">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    {{-- Filtros --}}
    <form method="GET" class="cal-filtros">
        <div class="cal-filtro-grupo">
            <span class="cal-filtro-label"><i class="fas fa-calendar-alt me-1"></i>Período</span>
            <select name="periodo_id" onchange="this.form.submit()">
                @foreach($periodos as $p)
                    <option value="{{ $p->id }}" @selected($p->id == $periodoId)>{{ $p->nombre_periodo }}</option>
                @endforeach
            </select>
        </div>
        <div class="cal-filtro-grupo">
            <span class="cal-filtro-label"><i class="fas fa-school me-1"></i>Grado / Sección</span>
            <select name="grado_id" onchange="this.form.submit()">
                @foreach($grados as $g)
                    <option value="{{ $g->id }}" @selected($g->id == $gradoId)>{{ $g->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:flex;align-items:flex-end;gap:.5rem;flex-wrap:wrap;padding-bottom:.05rem;">
            <span style="background:var(--teal-light);color:var(--blue-mid);font-size:.72rem;font-weight:700;padding:.3rem .75rem;border-radius:999px;border:1px solid rgba(78,199,210,.3);">
                <i class="fas fa-users me-1"></i>{{ $estudiantes->count() }} estudiantes
            </span>
            <span style="background:rgba(0,59,115,.08);color:var(--blue-dark);font-size:.72rem;font-weight:700;padding:.3rem .75rem;border-radius:999px;border:1px solid rgba(0,59,115,.15);">
                <i class="fas fa-book me-1"></i>{{ $materias->count() }} materias
            </span>
        </div>
    </form>

    {{-- Cards de materias --}}
    @forelse($materias as $materia)
    <div class="mat-card">
        <div class="mat-card-head">
            <div class="mat-card-title">
                <i class="fas fa-book-open"></i> {{ $materia->nombre }}
            </div>
            <button class="btn-pct" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#config-{{ $materia->id }}">
                <i class="fas fa-sliders-h"></i> Porcentajes
            </button>
        </div>

        <div class="collapse" id="config-{{ $materia->id }}">
            <div class="pct-panel">
                <form method="POST" action="{{ route('profesor.cuadro.porcentajes') }}" class="row g-2 align-items-end">
                    @csrf
                    <input type="hidden" name="materia_id" value="{{ $materia->id }}">
                    <input type="hidden" name="periodo_id" value="{{ $periodoId }}">
                    <div class="col-md-3">
                        <label class="cal-filtro-label d-block mb-1">Tarea (%)</label>
                        <input type="number" name="porcentaje_tarea" class="form-control pct-input"
                               data-group="pct-{{ $materia->id }}"
                               value="{{ $porcentajes->get($materia->id)?->porcentaje_tarea ?? 20 }}"
                               min="0" max="100" step="1">
                    </div>
                    <div class="col-md-3">
                        <label class="cal-filtro-label d-block mb-1">Parcial (%)</label>
                        <input type="number" name="porcentaje_parcial" class="form-control pct-input"
                               data-group="pct-{{ $materia->id }}"
                               value="{{ $porcentajes->get($materia->id)?->porcentaje_parcial ?? 30 }}"
                               min="0" max="100" step="1">
                    </div>
                    <div class="col-md-3">
                        <label class="cal-filtro-label d-block mb-1">Final (%)</label>
                        <input type="number" name="porcentaje_final" class="form-control pct-input"
                               data-group="pct-{{ $materia->id }}"
                               value="{{ $porcentajes->get($materia->id)?->porcentaje_final ?? 50 }}"
                               min="0" max="100" step="1">
                    </div>
                    <div class="col-md-3">
                        <div style="font-size:.78rem;margin-bottom:.4rem;color:var(--text-muted);">
                            Suma: <span class="pct-suma-ok" id="suma-{{ $materia->id }}">100</span>%
                        </div>
                        <button type="submit" class="btn-guardar-pct">
                            <i class="fas fa-save me-1"></i> Guardar porcentajes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <form method="POST" action="{{ route('profesor.cuadro.guardar') }}">
            @csrf
            <input type="hidden" name="periodo_id" value="{{ $periodoId }}">
            <input type="hidden" name="grado_id"   value="{{ $gradoId }}">

            <div class="table-responsive">
                <table class="cal-tbl">
                    <thead>
                        <tr>
                            <th style="min-width:220px">Estudiante</th>
                            <th class="tc">Tarea<div style="font-weight:500;color:var(--teal);font-size:.68rem;text-transform:none;letter-spacing:0;">({{ $porcentajes->get($materia->id)?->porcentaje_tarea ?? 20 }}%)</div></th>
                            <th class="tc">Parcial<div style="font-weight:500;color:var(--teal);font-size:.68rem;text-transform:none;letter-spacing:0;">({{ $porcentajes->get($materia->id)?->porcentaje_parcial ?? 30 }}%)</div></th>
                            <th class="tc">Final<div style="font-weight:500;color:var(--teal);font-size:.68rem;text-transform:none;letter-spacing:0;">({{ $porcentajes->get($materia->id)?->porcentaje_final ?? 50 }}%)</div></th>
                            <th class="tc">Promedio</th>
                            <th class="tc">Estado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($estudiantes as $index => $estudiante)
                        @php
                            $key   = $estudiante->id . '_' . $materia->id;
                            $calif = $calificaciones->get($key)?->first() ?? null;
                            $pT    = $porcentajes->get($materia->id)?->porcentaje_tarea   ?? 20;
                            $pP    = $porcentajes->get($materia->id)?->porcentaje_parcial ?? 30;
                            $pF    = $porcentajes->get($materia->id)?->porcentaje_final   ?? 50;
                        @endphp
                        <tr>
                            <td>
                                <input type="hidden" name="calificaciones[{{ $index }}][estudiante_id]" value="{{ $estudiante->id }}">
                                <input type="hidden" name="calificaciones[{{ $index }}][materia_id]"    value="{{ $materia->id }}">
                                <div style="display:flex;align-items:center;gap:.6rem;">
                                    <div style="width:32px;height:32px;border-radius:8px;background:var(--teal-light);color:var(--blue-mid);display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0;">
                                        {{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1 ?? 'S', 0, 1)) }}
                                    </div>
                                    <span class="est-nombre">{{ $estudiante->nombre_completo }}</span>
                                </div>
                            </td>
                            <td class="tc">
                                <input type="number" class="nota-inp nota-input"
                                       name="calificaciones[{{ $index }}][nota_tarea]"
                                       value="{{ $calif?->nota_tarea }}" placeholder="—"
                                       min="0" max="100" step="0.01"
                                       data-row="{{ $materia->id }}-{{ $estudiante->id }}"
                                       data-tipo="tarea" data-pt="{{ $pT }}" data-pp="{{ $pP }}" data-pf="{{ $pF }}">
                            </td>
                            <td class="tc">
                                <input type="number" class="nota-inp nota-input"
                                       name="calificaciones[{{ $index }}][nota_parcial]"
                                       value="{{ $calif?->nota_parcial }}" placeholder="—"
                                       min="0" max="100" step="0.01"
                                       data-row="{{ $materia->id }}-{{ $estudiante->id }}"
                                       data-tipo="parcial">
                            </td>
                            <td class="tc">
                                <input type="number" class="nota-inp nota-input"
                                       name="calificaciones[{{ $index }}][nota_final]"
                                       value="{{ $calif?->nota_final }}" placeholder="—"
                                       min="0" max="100" step="0.01"
                                       data-row="{{ $materia->id }}-{{ $estudiante->id }}"
                                       data-tipo="final">
                            </td>
                            <td class="tc">
                                <span class="prom-cell" id="prom-{{ $materia->id }}-{{ $estudiante->id }}">
                                    {{ $calif?->promedio ?? '—' }}
                                </span>
                            </td>
                            <td class="tc" id="estado-{{ $materia->id }}-{{ $estudiante->id }}">
                                @if($calif?->estado === 'aprobado')
                                    <span class="bpill b-green"><i class="fas fa-check" style="font-size:.6rem;"></i> Aprobado</span>
                                @elseif($calif?->estado === 'reprobado')
                                    <span class="bpill b-red"><i class="fas fa-times" style="font-size:.6rem;"></i> Reprobado</span>
                                @else
                                    <span class="bpill b-amber"><i class="fas fa-clock" style="font-size:.6rem;"></i> Pendiente</span>
                                @endif
                            </td>
                            <td>
                                <input type="text" class="obs-inp"
                                       name="calificaciones[{{ $index }}][observaciones]"
                                       value="{{ $calif?->observaciones }}" placeholder="Opcional...">
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="cal-empty"><i class="fas fa-user-graduate"></i><p>No hay estudiantes en este grado.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($estudiantes->isNotEmpty())
            <div class="mat-footer">
                <button type="submit" class="btn-guardar">
                    <i class="fas fa-save"></i> Guardar — {{ $materia->nombre }}
                </button>
            </div>
            @endif
        </form>
    </div>

    @empty
    <div class="mat-card">
        <div class="cal-empty">
            <i class="fas fa-book-open"></i>
            <p>No tienes materias asignadas para el grado y período seleccionados.</p>
        </div>
    </div>
    @endforelse

</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.nota-input').forEach(input => {
    input.addEventListener('input', function () {
        const row    = this.dataset.row;
        const inputs = document.querySelectorAll(`.nota-input[data-row="${row}"]`);
        const first  = inputs[0];
        const pT = parseFloat(first.dataset.pt) / 100;
        const pP = parseFloat(first.dataset.pp) / 100;
        const pF = parseFloat(first.dataset.pf) / 100;
        const vals = {};
        inputs.forEach(i => vals[i.dataset.tipo] = parseFloat(i.value));
        const [mId, eId] = row.split('-');
        const promEl   = document.getElementById(`prom-${mId}-${eId}`);
        const estadoEl = document.getElementById(`estado-${mId}-${eId}`);
        if (!isNaN(vals.tarea) && !isNaN(vals.parcial) && !isNaN(vals.final)) {
            const prom = (vals.tarea * pT + vals.parcial * pP + vals.final * pF).toFixed(2);
            promEl.textContent = prom;
            estadoEl.innerHTML = prom >= 60
                ? '<span class="bpill b-green"><i class="fas fa-check" style="font-size:.6rem;"></i> Aprobado</span>'
                : '<span class="bpill b-red"><i class="fas fa-times" style="font-size:.6rem;"></i> Reprobado</span>';
        } else {
            promEl.textContent = '—';
            estadoEl.innerHTML = '<span class="bpill b-amber"><i class="fas fa-clock" style="font-size:.6rem;"></i> Pendiente</span>';
        }
    });
});

document.querySelectorAll('.pct-input').forEach(input => {
    input.addEventListener('input', function () {
        const group  = this.dataset.group;
        const inputs = document.querySelectorAll(`.pct-input[data-group="${group}"]`);
        let suma = 0;
        inputs.forEach(i => suma += parseFloat(i.value) || 0);
        const sumaEl = document.getElementById(`suma-${group.replace('pct-', '')}`);
        sumaEl.textContent = suma;
        sumaEl.className   = suma === 100 ? 'pct-suma-ok' : 'pct-suma-err';
    });
    input.dispatchEvent(new Event('input'));
});
</script>
@endpush