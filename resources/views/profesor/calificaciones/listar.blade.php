@extends('layouts.app')

@section('title', 'Calificaciones — ' . ($asignacion->materia->nombre ?? ''))

@section('page-title', 'Calificaciones')

@section('topbar-actions')
    <a href="{{ route('profesor.calificaciones.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Mis Grupos
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3" style="border-radius: 10px; border-left: 4px solid #388e3c !important;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-3" style="border-radius: 10px; border-left: 4px solid #d32f2f !important;">
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Resumen del grupo --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-book" style="color: #00508f; font-size: 0.9rem;"></i>
                        <span class="small"><strong style="color: #00508f;">{{ $asignacion->materia->nombre ?? 'Materia' }}</strong></span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-school" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                        <span class="small text-muted">{{ $nombreGrado }} · Sección {{ $seccion }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-users" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                        <span class="small"><strong style="color: #4ec7d2;">{{ $estudiantes->count() }}</strong> <span class="text-muted">estudiantes</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Selector de período --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <span class="small fw-semibold" style="color: #003b73;">
                    <i class="fas fa-calendar-alt me-1" style="color: #4ec7d2;"></i>
                    Período:
                </span>
                @foreach($periodos as $periodo)
                    <a href="{{ route('profesor.calificaciones.listar', [
                            'gradoId'   => $gradoId,
                            'seccion'   => $seccion,
                            'materiaId' => $materiaId,
                        ]) }}?periodo_id={{ $periodo->id }}"
                       class="btn btn-sm {{ $periodoId == $periodo->id ? 'periodo-activo' : 'periodo-inactivo' }}"
                       style="border-radius: 20px; font-size: 0.8rem; font-weight: 600; padding: 0.3rem 0.9rem; transition: all 0.3s ease;
                              {{ $periodoId == $periodo->id
                                  ? 'background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78,199,210,0.3);'
                                  : 'background: white; color: #00508f; border: 1.5px solid #00508f;' }}">
                        {{ $periodo->nombre_periodo ?? $periodo->nombre }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sin estudiantes --}}
    @if($estudiantes->isEmpty())
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body text-center py-5">
                <i class="fas fa-user-slash fa-3x mb-3" style="color: #00508f; opacity: 0.4;"></i>
                <h5 style="color: #003b73;">No hay estudiantes activos en este grupo</h5>
                <p class="text-muted small mb-0">Verifica que los estudiantes estén asignados a este grado y sección.</p>
            </div>
        </div>
    @else
        <form method="POST" action="{{ route('profesor.calificaciones.guardar', [
            'gradoId'   => $gradoId,
            'seccion'   => $seccion,
            'materiaId' => $materiaId,
        ]) }}">
            @csrf
            <input type="hidden" name="periodo_id" value="{{ $periodoId }}">

            {{-- Tabla de calificaciones --}}
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="calificacionesTable">
                            <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                <tr>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">#</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Estudiante</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">1er Parcial</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">2do Parcial</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">3er Parcial</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Recuperación</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Nota Final</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Estado</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Observación</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $i => $estudiante)
                                    @php $cal = $calificaciones->get($estudiante->id); @endphp
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;">
                                        {{-- # --}}
                                        <td class="px-3 py-2 text-muted small">{{ $i + 1 }}</td>

                                        {{-- Nombre --}}
                                        <td class="px-3 py-2">
                                            <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                                {{ $estudiante->nombre_completo }}
                                            </div>
                                            <input type="hidden" name="calificaciones[{{ $i }}][estudiante_id]" value="{{ $estudiante->id }}">
                                        </td>

                                        {{-- 1er Parcial --}}
                                        <td class="px-3 py-2 text-center">
                                            <input type="number"
                                                   name="calificaciones[{{ $i }}][primer_parcial]"
                                                   value="{{ old("calificaciones.{$i}.primer_parcial", $cal?->primer_parcial) }}"
                                                   min="0" max="100" step="0.01"
                                                   class="form-control form-control-sm text-center nota-input"
                                                   style="width: 80px; margin: 0 auto; border: 1.5px solid #e2e8f0; border-radius: 8px;"
                                                   placeholder="—">
                                        </td>

                                        {{-- 2do Parcial --}}
                                        <td class="px-3 py-2 text-center">
                                            <input type="number"
                                                   name="calificaciones[{{ $i }}][segundo_parcial]"
                                                   value="{{ old("calificaciones.{$i}.segundo_parcial", $cal?->segundo_parcial) }}"
                                                   min="0" max="100" step="0.01"
                                                   class="form-control form-control-sm text-center nota-input"
                                                   style="width: 80px; margin: 0 auto; border: 1.5px solid #e2e8f0; border-radius: 8px;"
                                                   placeholder="—">
                                        </td>

                                        {{-- 3er Parcial --}}
                                        <td class="px-3 py-2 text-center">
                                            <input type="number"
                                                   name="calificaciones[{{ $i }}][tercer_parcial]"
                                                   value="{{ old("calificaciones.{$i}.tercer_parcial", $cal?->tercer_parcial) }}"
                                                   min="0" max="100" step="0.01"
                                                   class="form-control form-control-sm text-center nota-input"
                                                   style="width: 80px; margin: 0 auto; border: 1.5px solid #e2e8f0; border-radius: 8px;"
                                                   placeholder="—">
                                        </td>

                                        {{-- Recuperación --}}
                                        <td class="px-3 py-2 text-center">
                                            <input type="number"
                                                   name="calificaciones[{{ $i }}][recuperacion]"
                                                   value="{{ old("calificaciones.{$i}.recuperacion", $cal?->recuperacion) }}"
                                                   min="0" max="100" step="0.01"
                                                   class="form-control form-control-sm text-center nota-input"
                                                   style="width: 80px; margin: 0 auto; border: 1.5px solid #e2e8f0; border-radius: 8px;"
                                                   placeholder="—">
                                        </td>

                                        {{-- Nota Final --}}
                                        <td class="px-3 py-2 text-center">
                                            <span class="nota-final fw-bold" style="font-size: 1rem;
                                                {{ $cal && $cal->nota_final !== null
                                                    ? ($cal->nota_final >= 60 ? 'color: #388e3c;' : 'color: #d32f2f;')
                                                    : 'color: #c0c0c0;' }}">
                                                {{ $cal && $cal->nota_final !== null ? number_format($cal->nota_final, 1) : '—' }}
                                            </span>
                                        </td>

                                        {{-- Estado --}}
                                        <td class="px-3 py-2 text-center">
                                            @if($cal)
                                                @php
                                                    $nf = $cal->nota_final;
                                                    $bg    = $nf === null ? 'rgba(200,200,200,0.15)' : ($nf >= 60 ? 'rgba(76,175,80,0.1)' : 'rgba(244,67,54,0.1)');
                                                    $color = $nf === null ? '#999' : ($nf >= 60 ? '#388e3c' : '#d32f2f');
                                                    $txt   = $nf === null ? 'Pendiente' : ($nf >= 60 ? 'Aprobado' : 'Reprobado');
                                                    $icon  = $nf === null ? 'fa-clock' : ($nf >= 60 ? 'fa-check-circle' : 'fa-times-circle');
                                                @endphp
                                                <span class="badge rounded-pill estado-badge"
                                                      style="background: {{ $bg }}; color: {{ $color }}; border: 1px solid {{ $color }}; padding: 0.3rem 0.7rem; font-weight: 600; font-size: 0.75rem;">
                                                    <i class="fas {{ $icon }} me-1" style="font-size: 0.65rem;"></i>{{ $txt }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill"
                                                      style="background: rgba(200,200,200,0.15); color: #999; border: 1px solid #ccc; padding: 0.3rem 0.7rem; font-size: 0.75rem;">
                                                    Sin nota
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Observación --}}
                                        <td class="px-3 py-2">
                                            <input type="text"
                                                   name="calificaciones[{{ $i }}][observacion]"
                                                   value="{{ old("calificaciones.{$i}.observacion", $cal?->observacion) }}"
                                                   maxlength="500"
                                                   class="form-control form-control-sm"
                                                   style="min-width: 140px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.82rem;"
                                                   placeholder="Opcional…">
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="px-3 py-2 text-center">
                                            @if($cal)
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <a href="{{ route('profesor.calificaciones.edit', $cal->id) }}"
                                                       class="btn btn-sm"
                                                       title="Editar"
                                                       style="background: rgba(78,199,210,0.1); color: #00508f; border: 1px solid #4ec7d2; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                                        <i class="fas fa-edit" style="font-size: 0.75rem;"></i>
                                                    </a>
                                                    <form method="POST"
                                                          action="{{ route('profesor.calificaciones.destroy', $cal->id) }}"
                                                          onsubmit="return confirm('¿Eliminar la calificación de {{ addslashes($estudiante->nombre1) }}?')"
                                                          class="m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm"
                                                                title="Eliminar"
                                                                style="background: rgba(244,67,54,0.08); color: #d32f2f; border: 1px solid #ef9a9a; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                                            <i class="fas fa-trash" style="font-size: 0.75rem;"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="small text-muted">Nueva</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Footer con botón guardar --}}
                <div class="card-footer bg-white border-0 py-3 px-3" style="border-top: 1px solid #f1f5f9;">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="small text-muted">
                            <i class="fas fa-info-circle me-1" style="color: #4ec7d2;"></i>
                            La nota final se calcula automáticamente al guardar.
                        </span>
                        <button type="submit" class="btn fw-semibold"
                                style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78,199,210,0.3); padding: 0.5rem 1.5rem; border-radius: 8px;">
                            <i class="fas fa-save me-2"></i>Guardar Calificaciones
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endif

</div>

@push('styles')
<style>
    .form-control:focus {
        border-color: #4ec7d2 !important;
        box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.2) !important;
    }
    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
        transform: translateY(-2px);
    }
    .table tbody tr:hover {
        background-color: rgba(191, 217, 234, 0.08);
    }
    button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('tr').forEach(row => {
        const inputs = row.querySelectorAll('.nota-input');
        inputs.forEach(input => input.addEventListener('input', () => recalcular(row)));
    });

    function recalcular(row) {
        const get = cls => {
            const el = row.querySelector(`input[name$="[${cls}]"]`);
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
            display.style.color = '#c0c0c0';
            return;
        }

        const promedio  = parciales.reduce((a, b) => a + b, 0) / parciales.length;
        const notaFinal = (promedio < 60 && rec !== null) ? Math.max(promedio, rec) : promedio;
        const aprobado  = notaFinal >= 60;

        display.textContent = notaFinal.toFixed(1);
        display.style.color = aprobado ? '#388e3c' : '#d32f2f';

        if (badge) {
            const bg    = aprobado ? 'rgba(76,175,80,0.1)'   : 'rgba(244,67,54,0.1)';
            const color = aprobado ? '#388e3c'                : '#d32f2f';
            const txt   = aprobado ? 'Aprobado'              : 'Reprobado';
            const icon  = aprobado ? 'fa-check-circle'       : 'fa-times-circle';
            badge.style.background = bg;
            badge.style.color      = color;
            badge.style.borderColor = color;
            badge.innerHTML = `<i class="fas ${icon} me-1" style="font-size:0.65rem;"></i>${txt}`;
        }
    }
});
</script>
@endpush
@endsection
