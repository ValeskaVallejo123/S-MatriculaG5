@extends('layouts.app')

@section('title', "Editar Horario {$grado->numero}°{$grado->seccion}")
@section('page-title', "Editar Horario — {$grado->numero}°{$grado->seccion} (" . ucfirst($jornada) . ")")

@push('styles')
<style>
    .celda-horario { cursor:pointer; min-height:70px; }
    .celda-horario .materia { font-weight:700; color:#003b73; }
    .celda-horario .meta { font-size:.85rem; color:#6b7280; }
</style>
@endpush

@section('content')
<div class="container" style="max-width:1150px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between mb-4">
                <h4 class="fw-bold" style="color:#003b73;">Editar Horario — {{ ucfirst($jornada) }}</h4>
                <button id="guardarHorario" class="btn btn-primary">Guardar Cambios</button>
            </div>

            @php
                $estructura = $horarioGrado->horario;
                $dias = array_keys($estructura);
                $horas = array_keys(reset($estructura));
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead style="background:rgba(78,199,210,0.2);">
                        <tr>
                            <th>Hora</th>
                            @foreach($dias as $dia)
                                <th>{{ $dia }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($horas as $hora)
                            <tr>
                                <td class="fw-bold text-start">{{ $hora }}</td>

                                @foreach($dias as $dia)
                                    @php $c = $estructura[$dia][$hora]; @endphp

                                    <td class="celda-horario p-2"
                                        data-dia="{{ $dia }}"
                                        data-hora="{{ $hora }}">
                                        @if($c)
                                            <div class="materia">
                                                {{ optional($materias->find($c['materia_id']))->nombre }}
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

            <!-- FORM **************************************************** -->
            <form id="formGuardar"
                  action="{{ route('horarios_grado.update', [$grado->id, $jornada]) }}"
                  method="POST" style="display:none;">
                @csrf
                <input type="hidden" id="inputHorario" name="horario">
            </form>

            <!-- MODAL **************************************************** -->
            <div class="modal fade" id="modalCelda" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Editar Clase</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <input type="hidden" id="m_dia">
                            <input type="hidden" id="m_hora">

                            <div class="mb-3">
                                <label>Materia</label>
                                <select id="m_materia" class="form-select">
                                    <option value="">---</option>
                                    @foreach($materias as $m)
                                        <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Profesor</label>
                                <select id="m_profesor" class="form-select">
                                    <option value="">---</option>
                                    @foreach($profesores as $p)
                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Aula</label>
                                <input id="m_salon" class="form-control" placeholder="Ej: 2B">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button id="btnEliminarCelda" class="btn btn-outline-danger">Eliminar</button>
                            <button id="btnGuardarCelda" class="btn btn-primary">Guardar</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const modal = new bootstrap.Modal(document.getElementById('modalCelda'));

    // Objeto horario cargado desde la BD
    let estructura = {!! json_encode($estructura) !!};

    // Variable para saber qué celda se está editando
    let celdaSeleccionada = null;

    // ============================================================
    // ABRIR MODAL AL HACER CLIC EN UNA CELDA
    // ============================================================
    document.querySelectorAll('.celda-horario').forEach(td => {
        td.addEventListener('click', () => {

            const dia = td.dataset.dia;
            const hora = td.dataset.hora;
            const c = estructura[dia][hora];

            celdaSeleccionada = td;

            document.getElementById('m_dia').value = dia;
            document.getElementById('m_hora').value = hora;

            document.getElementById('m_materia').value = c?.materia_id ?? '';
            document.getElementById('m_profesor').value = c?.profesor_id ?? '';
            document.getElementById('m_salon').value = c?.salon ?? '';

            modal.show();
        });
    });

    // ============================================================
    // GUARDAR CAMBIO EN CELDA
    // ============================================================
    document.getElementById('btnGuardarCelda').addEventListener('click', function(){

        const dia = document.getElementById('m_dia').value;
        const hora = document.getElementById('m_hora').value;

        estructura[dia][hora] = {
            materia_id: document.getElementById('m_materia').value || null,
            profesor_id: document.getElementById('m_profesor').value || null,
            salon: document.getElementById('m_salon').value || null
        };

        // Obtener textos para mostrar visualmente
        const materiaSelect = document.getElementById('m_materia');
        const profesorSelect = document.getElementById('m_profesor');

        const materiaTexto = materiaSelect.value ? materiaSelect.options[materiaSelect.selectedIndex].text : null;
        const profesorTexto = profesorSelect.value ? profesorSelect.options[profesorSelect.selectedIndex].text : '—';
        const salonTexto = document.getElementById('m_salon').value || '—';

        // Mostrar en tabla inmediatamente
        if (celdaSeleccionada) {
            if (!materiaTexto) {
                celdaSeleccionada.innerHTML = `<span class="text-muted small">Haga clic para asignar</span>`;
            } else {
                celdaSeleccionada.innerHTML = `
                    <div class="materia">${materiaTexto}</div>
                    <div class="meta">${profesorTexto} · Aula: ${salonTexto}</div>
                `;
            }
        }

        modal.hide();
    });

    // ============================================================
    // ELIMINAR ASIGNACIÓN DE CELDA
    // ============================================================
    document.getElementById('btnEliminarCelda').addEventListener('click', function(){

        const dia = document.getElementById('m_dia').value;
        const hora = document.getElementById('m_hora').value;

        estructura[dia][hora] = null;

        if (celdaSeleccionada) {
            celdaSeleccionada.innerHTML = `<span class="text-muted small">Haga clic para asignar</span>`;
        }

        modal.hide();
    });

    // ============================================================
    // GUARDAR TODO EL HORARIO EN LA BD
    // ============================================================
    document.getElementById('guardarHorario').addEventListener('click', function(){
        document.getElementById('inputHorario').value = JSON.stringify(estructura);
        document.getElementById('formGuardar').submit();
    });

});
</script>
@endpush
