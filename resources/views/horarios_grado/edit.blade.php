@extends('layouts.app')

@section('title', "Editar Horario {$grado->numero}°{$grado->seccion}")
@section('page-title', "Editar Horario — {$grado->numero}°{$grado->seccion} (" . ucfirst($jornada) . ")")

@push('styles')
<style>
    .celda-horario {
        cursor: pointer;
        min-height: 70px;
        transition: background 0.2s ease;
    }
    .celda-horario:hover {
        background: rgba(78, 199, 210, 0.08) !important;
    }
    .celda-horario .materia {
        font-weight: 700;
        color: #003b73;
    }
    .celda-horario .meta {
        font-size: 0.82rem;
        color: #6b7280;
    }
</style>
@endpush

@section('content')
<div class="container" style="max-width: 1150px;">

    <a href="{{ url()->previous() }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Volver
    </a>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-white fw-bold mb-0">
                    <i class="fas fa-edit me-2"></i>Editar Horario — {{ ucfirst($jornada) }}
                </h5>
                <button id="guardarHorario" class="btn btn-light btn-sm fw-semibold">
                    <i class="fas fa-save me-1"></i> Guardar Cambios
                </button>
            </div>
        </div>

        <div class="card-body p-4">

            @if(!$horarioGrado || empty($horarioGrado->horario))
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-calendar-times fa-3x mb-3" style="color: #cbd5e1;"></i>
                    <p class="fw-semibold mb-1">No hay estructura de horario disponible.</p>
                    <small>Contacte al administrador del sistema.</small>
                </div>
            @else

                @php
                    $estructura = $horarioGrado->horario;
                    $dias = array_keys($estructura);
                    $horas = array_keys(reset($estructura));
                @endphp

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead style="background: rgba(78, 199, 210, 0.2);">
                            <tr>
                                <th style="color: #003b73;">Hora</th>
                                @foreach($dias as $dia)
                                    <th style="color: #003b73;">{{ $dia }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($horas as $hora)
                                <tr>
                                    <td class="fw-bold text-start" style="color: #003b73;">{{ $hora }}</td>

                                    @foreach($dias as $dia)
                                        {{-- ?? null evita error si la celda no existe --}}
                                        @php $c = $estructura[$dia][$hora] ?? null; @endphp

                                        <td class="celda-horario p-2"
                                            data-dia="{{ $dia }}"
                                            data-hora="{{ $hora }}">
                                            @if($c)
                                                <div class="materia">
                                                    {{ optional($materias->find($c['materia_id']))->nombre ?? '—' }}
                                                </div>
                                                <div class="meta">
                                                    {{ optional($profesores->find($c['profesor_id']))->nombre ?? '—' }}
                                                    · Aula: {{ $c['salon'] ?? '—' }}
                                                </div>
                                            @else
                                                <span class="text-muted small">Haga clic para asignar</span>
                                            @endif
                                        </td>

                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            @endif

            {{-- FORM --}}
            <form id="formGuardar"
                  action="{{ route('horarios_grado.update', [$grado->id, $jornada]) }}"
                  method="POST"
                  style="display: none;">
                @csrf
                <input type="hidden" id="inputHorario" name="horario">
            </form>

        </div>
    </div>

</div>

{{-- MODAL --}}
<div class="modal fade" id="modalCelda" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">

            <div class="modal-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0;">
                <h5 class="modal-title text-white fw-bold">
                    <i class="fas fa-clock me-2"></i>Editar Clase
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <input type="hidden" id="m_dia">
                <input type="hidden" id="m_hora">

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: #003b73;">Materia</label>
                    <select id="m_materia" class="form-select">
                        <option value="">— Sin asignar —</option>
                        @foreach($materias as $m)
                            <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: #003b73;">Profesor</label>
                    <select id="m_profesor" class="form-select">
                        <option value="">— Sin asignar —</option>
                        @foreach($profesores as $p)
                            <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: #003b73;">Aula</label>
                    <input id="m_salon" class="form-control" placeholder="Ej: 2B">
                </div>

            </div>

            <div class="modal-footer border-0 bg-light" style="border-radius: 0 0 12px 12px;">
                <button id="btnEliminarCelda" class="btn btn-outline-danger">
                    <i class="fas fa-trash me-1"></i> Eliminar
                </button>
                <button id="btnGuardarCelda" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = new bootstrap.Modal(document.getElementById('modalCelda'));

    let estructura = {!! json_encode($estructura ?? []) !!};
    let celdaSeleccionada = null;

    // ── Abrir modal al hacer clic en una celda ──────────────────
    document.querySelectorAll('.celda-horario').forEach(td => {
        td.addEventListener('click', () => {

            const dia  = td.dataset.dia;
            const hora = td.dataset.hora;
            const c    = estructura[dia]?.[hora] ?? null;

            celdaSeleccionada = td;

            document.getElementById('m_dia').value      = dia;
            document.getElementById('m_hora').value     = hora;
            document.getElementById('m_materia').value  = c?.materia_id  ?? '';
            document.getElementById('m_profesor').value = c?.profesor_id ?? '';
            document.getElementById('m_salon').value    = c?.salon       ?? '';

            modal.show();
        });
    });

    // ── Guardar cambio en celda ─────────────────────────────────
    document.getElementById('btnGuardarCelda').addEventListener('click', function () {

        const dia  = document.getElementById('m_dia').value;
        const hora = document.getElementById('m_hora').value;

        const materiaSelect  = document.getElementById('m_materia');
        const profesorSelect = document.getElementById('m_profesor');
        const salon          = document.getElementById('m_salon').value;

        estructura[dia][hora] = {
            materia_id:  materiaSelect.value  || null,
            profesor_id: profesorSelect.value || null,
            salon:       salon                || null
        };

        const materiaTexto  = materiaSelect.value  ? materiaSelect.options[materiaSelect.selectedIndex].text  : null;
        const profesorTexto = profesorSelect.value ? profesorSelect.options[profesorSelect.selectedIndex].text : '—';
        const salonTexto    = salon || '—';

        if (celdaSeleccionada) {
            celdaSeleccionada.innerHTML = materiaTexto
                ? `<div class="materia">${materiaTexto}</div>
                   <div class="meta">${profesorTexto} · Aula: ${salonTexto}</div>`
                : `<span class="text-muted small">Haga clic para asignar</span>`;
        }

        modal.hide();
    });

    // ── Eliminar asignación de celda ────────────────────────────
    document.getElementById('btnEliminarCelda').addEventListener('click', function () {

        const dia  = document.getElementById('m_dia').value;
        const hora = document.getElementById('m_hora').value;

        estructura[dia][hora] = null;

        if (celdaSeleccionada) {
            celdaSeleccionada.innerHTML = `<span class="text-muted small">Haga clic para asignar</span>`;
        }

        modal.hide();
    });

    // ── Guardar todo el horario ─────────────────────────────────
    document.getElementById('guardarHorario').addEventListener('click', function () {
        document.getElementById('inputHorario').value = JSON.stringify(estructura);
        document.getElementById('formGuardar').submit();
    });

});
</script>
@endpush
