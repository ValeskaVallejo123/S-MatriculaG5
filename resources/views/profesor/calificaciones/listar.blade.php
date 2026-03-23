@extends('layouts.app')

@section('title', 'Calificaciones — ' . ($asignacion->materia->nombre ?? ''))
@section('page-title', 'Calificaciones')


@push('styles')
<style>
/* ── Badges header ── */
.info-badge {
    display:inline-flex;align-items:center;gap:.35rem;
    padding:.28rem .85rem;border-radius:999px;font-size:.72rem;font-weight:700;
    background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.35);
}

/* ── Período pills ── */
.periodo-pill {
    display:inline-flex;align-items:center;gap:.3rem;
    padding:.32rem .9rem;border-radius:999px;font-size:.78rem;font-weight:600;
    text-decoration:none;transition:all .2s;white-space:nowrap;
}
.periodo-pill.activo {
    background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;
    box-shadow:0 2px 8px rgba(78,199,210,.35);border:none;
}
.periodo-pill.inactivo {
    background:white;color:#00508f;border:1.5px solid #00508f;
}
.periodo-pill.inactivo:hover { background:#f0f7ff; }

/* ── Tabla calificaciones ── */
.cal-table { width:100%;border-collapse:collapse; }
.cal-table thead th {
    font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
    color:#6b7a90;background:#f5f8fc;padding:.65rem .85rem;
    border:1px solid #e8edf4;white-space:nowrap;text-align:center;
}
.cal-table thead th.th-nombre { text-align:left; }
.cal-table tbody td {
    border:1px solid #e8edf4;padding:.55rem .85rem;
    vertical-align:middle;text-align:center;
}
.cal-table tbody tr:hover td { background:rgba(78,199,210,.03); }

/* ── Inputs notas ── */
.nota-input {
    width:72px;padding:.3rem .4rem;text-align:center;
    border:1.5px solid #e2e8f0;border-radius:7px;
    font-size:.82rem;font-weight:600;color:#003b73;
    outline:none;transition:border-color .2s;
    background:#fafcff;
}
.nota-input:focus { border-color:#4ec7d2;box-shadow:0 0 0 3px rgba(78,199,210,.15); }

/* ── Obs input ── */
.obs-input {
    width:100%;min-width:130px;padding:.3rem .6rem;
    border:1.5px solid #e2e8f0;border-radius:7px;
    font-size:.78rem;color:#475569;outline:none;transition:border-color .2s;
}
.obs-input:focus { border-color:#4ec7d2;box-shadow:0 0 0 3px rgba(78,199,210,.15); }

/* ── Botón guardar ── */
.btn-guardar {
    display:inline-flex;align-items:center;gap:.45rem;
    padding:.55rem 1.6rem;border-radius:9px;font-size:.85rem;font-weight:700;
    background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;
    border:none;cursor:pointer;transition:all .2s;
    box-shadow:0 2px 10px rgba(78,199,210,.3);
}
.btn-guardar:hover { opacity:.9;transform:translateY(-1px);box-shadow:0 4px 14px rgba(78,199,210,.4); }

/* ── Acciones ── */
.btn-accion {
    display:inline-flex;align-items:center;justify-content:center;
    width:28px;height:28px;border-radius:6px;border:1px solid;
    text-decoration:none;transition:all .15s;font-size:.72rem;
}
</style>
@endpush

@section('content')
<div style="width:100%;">

    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #86efac;border-left:4px solid #16a34a;
                    border-radius:10px;padding:.75rem 1rem;margin-bottom:1rem;
                    font-size:.85rem;color:#15803d;display:flex;align-items:center;gap:.5rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;border-left:4px solid #dc2626;
                    border-radius:10px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.83rem;color:#b91c1c;">
            <i class="fas fa-exclamation-circle me-1"></i>
            @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        </div>
    @endif

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:1.8rem 1.7rem;position:relative;overflow:hidden;">

        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.2rem;flex-wrap:wrap;">
            <div style="width:66px;height:66px;border-radius:14px;
                        border:3px solid rgba(78,199,210,.7);background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-clipboard-list" style="color:white;font-size:1.7rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.25rem;font-weight:800;color:white;margin:0 0 .45rem;
                           text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    {{ $asignacion->materia->nombre ?? 'Materia' }}
                </h2>
                <div style="display:flex;gap:.45rem;flex-wrap:wrap;">
                    <span class="info-badge">
                        <i class="fas fa-school"></i>
                        {{ $nombreGrado }} · Sección {{ $seccion }}
                    </span>
                    <span class="info-badge">
                        <i class="fas fa-users"></i>
                        {{ $estudiantes->count() }} estudiantes
                    </span>
                    <span class="info-badge">
                        <i class="fas fa-calendar-alt"></i>
                        Año {{ date('Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        {{-- Selector período --}}
        <div style="padding:1rem 1.7rem;border-bottom:1px solid #e8edf4;
                    display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
            <span style="font-size:.78rem;font-weight:700;color:#003b73;white-space:nowrap;">
                <i class="fas fa-calendar-alt me-1" style="color:#4ec7d2;"></i> Período:
            </span>
            @foreach($periodos as $periodo)
                <a href="{{ route('profesor.calificaciones.listar', [
                        'gradoId'   => $gradoId,
                        'seccion'   => $seccion,
                        'materiaId' => $materiaId,
                    ]) }}?periodo_id={{ $periodo->id }}"
                   class="periodo-pill {{ $periodoId == $periodo->id ? 'activo' : 'inactivo' }}">
                    {{ $periodo->nombre_periodo ?? $periodo->nombre }}
                </a>
            @endforeach
        </div>

        {{-- Sin estudiantes --}}
        @if($estudiantes->isEmpty())
            <div style="text-align:center;padding:3.5rem 1rem;color:#94a3b8;">
                <i class="fas fa-user-slash" style="font-size:3rem;display:block;margin-bottom:.75rem;color:#bfd9ea;"></i>
                <p style="font-size:.9rem;font-weight:600;margin:0 0 .3rem;color:#64748b;">
                    No hay estudiantes activos en este grupo
                </p>
                <small>Verifica que los estudiantes estén asignados a este grado y sección.</small>
            </div>
        @else

        <form method="POST" action="{{ route('profesor.calificaciones.guardar', [
            'gradoId'   => $gradoId,
            'seccion'   => $seccion,
            'materiaId' => $materiaId,
        ]) }}">
            @csrf
            <input type="hidden" name="periodo_id" value="{{ $periodoId }}">

            <div style="padding:1.2rem 1.7rem;">
                <div style="overflow-x:auto;">
                    <table class="cal-table">
                        <thead>
                            <tr>
                                <th style="width:2.5rem;">#</th>
                                <th class="th-nombre" style="text-align:left;min-width:200px;">
                                    <i class="fas fa-user-graduate me-1" style="color:#4ec7d2;"></i> Estudiante
                                </th>
                                <th><i class="fas fa-star me-1" style="color:#4ec7d2;"></i>1er Parcial</th>
                                <th>2do Parcial</th>
                                <th>3er Parcial</th>
                                <th>Recuperación</th>
                                <th style="background:linear-gradient(135deg,rgba(0,80,143,.07),rgba(78,199,210,.07));color:#003b73;">
                                    Nota Final
                                </th>
                                <th>Estado</th>
                                <th style="text-align:left;min-width:140px;">Observación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $i => $estudiante)
                                @php $cal = $calificaciones->get($estudiante->id); @endphp
                                <tr>
                                    <td style="color:#94a3b8;font-size:.73rem;font-weight:600;">{{ $i + 1 }}</td>

                                    <td style="text-align:left;">
                                        <span style="font-weight:700;color:#003b73;font-size:.83rem;">
                                            {{ $estudiante->nombre_completo }}
                                        </span>
                                        <input type="hidden" name="calificaciones[{{ $i }}][estudiante_id]" value="{{ $estudiante->id }}">
                                    </td>

                                    {{-- Parciales --}}
                                    @foreach(['primer_parcial','segundo_parcial','tercer_parcial','recuperacion'] as $campo)
                                    <td>
                                        <input type="number"
                                               name="calificaciones[{{ $i }}][{{ $campo }}]"
                                               value="{{ old("calificaciones.{$i}.{$campo}", $cal?->{$campo}) }}"
                                               min="0" max="100" step="0.01"
                                               class="nota-input"
                                               placeholder="—">
                                    </td>
                                    @endforeach

                                    {{-- Nota Final --}}
                                    <td style="background:linear-gradient(135deg,rgba(0,80,143,.03),rgba(78,199,210,.03));">
                                        <span class="nota-final" style="font-size:.95rem;font-weight:800;
                                            {{ $cal && $cal->nota_final !== null
                                                ? ($cal->nota_final >= 60 ? 'color:#16a34a;' : 'color:#dc2626;')
                                                : 'color:#c0cad6;' }}">
                                            {{ $cal && $cal->nota_final !== null ? number_format($cal->nota_final,1) : '—' }}
                                        </span>
                                    </td>

                                    {{-- Estado --}}
                                    <td>
                                        @if($cal)
                                            @php
                                                $nf    = $cal->nota_final;
                                                $bg    = $nf===null?'rgba(200,200,200,.12)':($nf>=60?'rgba(22,163,74,.1)':'rgba(220,38,38,.1)');
                                                $color = $nf===null?'#94a3b8':($nf>=60?'#16a34a':'#dc2626');
                                                $txt   = $nf===null?'Pendiente':($nf>=60?'Aprobado':'Reprobado');
                                                $icon  = $nf===null?'fa-clock':($nf>=60?'fa-check-circle':'fa-times-circle');
                                            @endphp
                                            <span class="estado-badge" style="display:inline-flex;align-items:center;gap:.25rem;
                                                  padding:.25rem .65rem;border-radius:999px;font-size:.72rem;font-weight:700;
                                                  background:{{ $bg }};color:{{ $color }};border:1px solid {{ $color }};">
                                                <i class="fas {{ $icon }}" style="font-size:.6rem;"></i>{{ $txt }}
                                            </span>
                                        @else
                                            <span style="display:inline-flex;align-items:center;gap:.25rem;
                                                  padding:.25rem .65rem;border-radius:999px;font-size:.72rem;font-weight:600;
                                                  background:rgba(200,200,200,.12);color:#94a3b8;border:1px solid #e2e8f0;">
                                                <i class="fas fa-minus" style="font-size:.6rem;"></i>Sin nota
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Observación --}}
                                    <td style="text-align:left;">
                                        <input type="text"
                                               name="calificaciones[{{ $i }}][observacion]"
                                               value="{{ old("calificaciones.{$i}.observacion", $cal?->observacion) }}"
                                               maxlength="500"
                                               class="obs-input"
                                               placeholder="Opcional…">
                                    </td>

                                    {{-- Acciones --}}
                                    <td>
                                        @if($cal)
                                            <div style="display:flex;align-items:center;justify-content:center;gap:.35rem;">
                                                <a href="{{ route('profesor.calificaciones.edit', $cal->id) }}"
                                                   class="btn-accion"
                                                   title="Editar"
                                                   style="background:rgba(78,199,210,.1);color:#00508f;border-color:#4ec7d2;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST"
                                                      action="{{ route('profesor.calificaciones.destroy', $cal->id) }}"
                                                      onsubmit="return confirm('¿Eliminar la calificación de {{ addslashes($estudiante->nombre1 ?? $estudiante->nombre_completo) }}?')"
                                                      style="margin:0;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="btn-accion"
                                                            title="Eliminar"
                                                            style="background:rgba(220,38,38,.08);color:#dc2626;border-color:#fca5a5;cursor:pointer;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span style="font-size:.72rem;color:#94a3b8;font-style:italic;">Nueva</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer guardar --}}
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;
                        padding:.9rem 1.7rem;background:#f5f8fc;border-top:1px solid #e8edf4;
                        border-radius:0 0 14px 14px;">
                <span style="font-size:.75rem;color:#94a3b8;">
                    <i class="fas fa-info-circle me-1" style="color:#4ec7d2;"></i>
                    La nota final se calcula automáticamente al guardar.
                </span>
                <button type="submit" class="btn-guardar">
                    <i class="fas fa-save"></i> Guardar Calificaciones
                </button>
            </div>

        </form>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('tbody tr').forEach(row => {
        row.querySelectorAll('.nota-input').forEach(input => {
            input.addEventListener('input', () => recalcular(row));
        });
    });

    function recalcular(row) {
        const get = name => {
            const el = row.querySelector(`input[name$="[${name}]"]`);
            return el && el.value !== '' ? parseFloat(el.value) : null;
        };

        const p1  = get('primer_parcial');
        const p2  = get('segundo_parcial');
        const p3  = get('tercer_parcial');
        const rec = get('recuperacion');

        const parciales = [p1, p2, p3].filter(v => v !== null);
        const display   = row.querySelector('.nota-final');
        const badge     = row.querySelector('.estado-badge');

        if (!display) return;

        if (parciales.length === 0) {
            display.textContent = '—';
            display.style.color = '#c0cad6';
            return;
        }

        const promedio  = parciales.reduce((a, b) => a + b, 0) / parciales.length;
        const notaFinal = (promedio < 60 && rec !== null) ? Math.max(promedio, rec) : promedio;
        const aprobado  = notaFinal >= 60;

        display.textContent = notaFinal.toFixed(1);
        display.style.color = aprobado ? '#16a34a' : '#dc2626';

        if (badge) {
            const bg    = aprobado ? 'rgba(22,163,74,.1)'   : 'rgba(220,38,38,.1)';
            const color = aprobado ? '#16a34a'               : '#dc2626';
            const txt   = aprobado ? 'Aprobado'             : 'Reprobado';
            const icon  = aprobado ? 'fa-check-circle'      : 'fa-times-circle';
            badge.style.background  = bg;
            badge.style.color       = color;
            badge.style.borderColor = color;
            badge.innerHTML = `<i class="fas ${icon}" style="font-size:.6rem;"></i>${txt}`;
        }
    }
});
</script>
@endpush
