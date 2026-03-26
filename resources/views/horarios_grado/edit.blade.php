@extends('layouts.app')

@section('title', "Editar Horario {$grado->numero}°{$grado->seccion}")
@section('page-title', "Editar Horario — {$grado->numero}°{$grado->seccion}")

@section('topbar-actions')
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
        <button id="guardarHorario"
                style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;
                       padding:.6rem .75rem;border-radius:9px;font-size:.83rem;font-weight:600;
                       display:inline-flex;align-items:center;gap:.4rem;
                       border:none;cursor:pointer;transition:all .2s;">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
        <a href="{{ route('horarios_grado.show', [$grado->id, $jornada]) }}"
           style="background:white;color:#00508f;
                  padding:.6rem .75rem;border-radius:9px;font-size:.83rem;font-weight:600;
                  display:inline-flex;align-items:center;gap:.4rem;
                  text-decoration:none;border:1.5px solid #00508f;transition:all .2s;">
            <i class="fas fa-eye"></i> Ver Horario
        </a>
        <a href="{{ url()->previous() }}"
           style="background:white;color:#00508f;
                  padding:.6rem .75rem;border-radius:9px;font-size:.83rem;font-weight:600;
                  display:inline-flex;align-items:center;gap:.4rem;
                  text-decoration:none;border:1.5px solid #00508f;transition:all .2s;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@endsection

@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */

/* ── Jornada badge ── */
.jornada-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .7rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.15); color: white;
}

/* ── Título sección ── */
.sm-sec-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;          /* ← TAMAÑO título sección */
    text-transform: uppercase; letter-spacing: .08em;
    color: #00508f;
    margin-bottom: .95rem; padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.1);
}
.sm-sec-title i { color: #4ec7d2; font-size: .88rem; }

/* ── Tabla ── */
.ht-table { width: 100%; border-collapse: collapse; }

.ht-table thead th {
    font-size: .63rem;                            /* ← TAMAÑO encabezados tabla */
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #6b7a90;
    background: #f5f8fc;
    padding: .7rem .85rem;
    border: 1px solid #e8edf4;
    text-align: center;
    white-space: nowrap;
}
.ht-table thead th.th-hora {
    background: linear-gradient(135deg,rgba(0,80,143,.08),rgba(78,199,210,.08));
    color: #003b73;
    width: 130px;
}

.ht-table tbody td {
    border: 1px solid #e8edf4;
    padding: .55rem .7rem;                       /* ← PADDING celdas */
    vertical-align: middle;
    text-align: center;
    min-width: 130px;
}

/* ── Celda hora ── */
.td-hora {
    font-size: .72rem;                            /* ← TAMAÑO texto hora */
    font-weight: 700;
    color: #00508f;
    background: linear-gradient(135deg,rgba(0,80,143,.05),rgba(78,199,210,.05));
    text-align: left !important;
    white-space: nowrap;
}

/* ── Celda editable ── */
.celda-horario {
    cursor: pointer;
    transition: background .15s;
}
.celda-horario:hover { background: rgba(78,199,210,.07) !important; }

.celda-horario .materia {
    font-size: .8rem;                             /* ← TAMAÑO nombre materia */
    font-weight: 700;
    color: #003b73;
    display: block;
    margin-bottom: .1rem;
}
.celda-horario .meta {
    font-size: .7rem;                             /* ← TAMAÑO meta (profesor/aula) */
    color: #6b7a90;
    display: block;
}
.celda-horario .td-vacia {
    font-size: .72rem;
    color: #bfd9ea;
    font-style: italic;
}

/* ── Modal labels ── */
.modal-label {
    font-size: .63rem;                            /* ← TAMAÑO labels modal */
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #003b73;
    margin-bottom: .3rem;
    display: block;
}

/* ── Modal inputs ── */
.modal-input,
.modal-select {
    width: 100%;
    border: 2px solid #bfd9ea;
    border-radius: 10px;                          /* ← REDONDEZ inputs modal */
    padding: 0.68rem 1rem;                       /* ← ALTO inputs modal */
    font-size: .88rem;                            /* ← TEXTO inputs modal */
    color: #0d2137;
    transition: border-color .2s, box-shadow .2s;
    appearance: none;
    font-family: inherit;
}
.modal-input:focus, .modal-select:focus {
    outline: none;
    border-color: #4ec7d2;
    box-shadow: 0 0 0 .15rem rgba(78,199,210,.15);
}
.modal-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    padding-right: 2.5rem;
}

/* ── Botón guardar celda ── */
.btn-guardar-celda {
    flex: 1; min-width: 120px;
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .6rem .75rem;                       /* ← TAMAÑO botón guardar celda */
    border-radius: 9px;
    font-size: .83rem; font-weight: 600;          /* ← TEXTO botón guardar celda */
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none; cursor: pointer;
    transition: all .2s;
}
.btn-guardar-celda:hover { opacity: .9; transform: translateY(-1px); }

/* ── Botón eliminar celda ── */
.btn-eliminar-celda {
    flex: 1; min-width: 100px;
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .6rem .75rem;                       /* ← TAMAÑO botón eliminar celda */
    border-radius: 9px;
    font-size: .83rem; font-weight: 600;          /* ← TEXTO botón eliminar celda */
    background: white; color: #ef4444;
    border: 1.5px solid #ef4444; cursor: pointer;
    transition: all .2s;
}
.btn-eliminar-celda:hover { background: #fef2f2; transform: translateY(-1px); }

/* ── Empty state ── */
.empty-state {
    text-align: center; padding: 3.5rem 1rem; color: #94a3b8;
}
.empty-state i { font-size: 3rem; display: block; margin-bottom: .75rem; color: #bfd9ea; }
.empty-state p { font-size: .88rem; font-weight: 600; margin: 0 0 .25rem; }
.empty-state small { font-size: .75rem; }
</style>
@endpush

@section('content')
<div style="width:100%;">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem 1.7rem; position:relative; overflow:hidden;">

        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px;height:80px;
                        border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-edit" style="color:white;font-size:2rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white;
                           margin:0 0 .5rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Editar Horario — {{ $grado->numero }}° {{ $grado->seccion }}
                </h2>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                    <span class="jornada-badge">
                        @if($jornada === 'matutina')
                            <i class="fas fa-sun"></i>
                        @else
                            <i class="fas fa-moon"></i>
                        @endif
                        Jornada {{ ucfirst($jornada) }}
                    </span>
                    <span class="jornada-badge">
                        <i class="fas fa-calendar"></i> {{ $grado->anio_lectivo }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <div style="padding:1.4rem 1.7rem;">

            <div class="sm-sec-title">
                <i class="fas fa-table"></i> Haz clic en una celda para editar la clase
            </div>

            @if(!$horarioGrado || empty($horarioGrado->horario))

                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No hay estructura de horario disponible.</p>
                    <small>Contacte al administrador del sistema.</small>
                </div>

            @else
                @php
                    $estructura = $horarioGrado->horario;
                    $dias       = array_keys($estructura);
                    $horas      = array_keys(reset($estructura));
                @endphp

                <div style="overflow-x:auto;">
                    <table class="ht-table">
                        <thead>
                            <tr>
                                <th class="th-hora">
                                    <i class="fas fa-clock" style="margin-right:.3rem;color:#4ec7d2;"></i>
                                    Hora
                                </th>
                                @foreach($dias as $dia)
                                    <th>{{ $dia }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($horas as $hora)
                                <tr>
                                    <td class="td-hora">
                                        <i class="fas fa-circle"
                                           style="font-size:.4rem;color:#4ec7d2;
                                                  vertical-align:middle;margin-right:.3rem;"></i>
                                        {{ $hora }}
                                    </td>

                                    @foreach($dias as $dia)
                                        @php $c = $estructura[$dia][$hora] ?? null; @endphp
                                        <td class="celda-horario"
                                            data-dia="{{ $dia }}"
                                            data-hora="{{ $hora }}">
                                            @if($c && ($c['materia_id'] || $c['profesor_id']))
                                                <span class="materia">
                                                    {{ optional($materias->find($c['materia_id']))->nombre ?? '—' }}
                                                </span>
                                                <span class="meta">
                                                    {{ optional($profesores->find($c['profesor_id']))->nombre ?? '—' }}
                                                    · Aula: {{ $c['salon'] ?? '—' }}
                                                </span>
                                            @else
                                                <span class="td-vacia">Clic para asignar</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif

            {{-- FORM oculto --}}
            <form id="formGuardar"
                  action="{{ route('horarios_grado.update', [$grado->id, $jornada]) }}"
                  method="POST"
                  style="display:none;">
                @csrf
                @method('PUT')
                <input type="hidden" id="inputHorario" name="horario">
            </form>

        </div>

        {{-- Footer info ── --}}
        <div style="display:flex;align-items:center;justify-content:space-between;
                    flex-wrap:wrap;gap:.5rem;
                    padding:.85rem 1.7rem;
                    background:#f5f8fc;border-top:1px solid #e8edf4;
                    border-radius:0 0 14px 14px;
                    font-size:.72rem;color:#94a3b8;">
            <span>
                <i class="fas fa-info-circle me-1" style="color:#4ec7d2;"></i>
                Haz clic en cualquier celda de la tabla para editar esa clase
            </span>
            <span>
                <i class="fas fa-calendar me-1" style="color:#4ec7d2;"></i>
                {{ $grado->numero }}° {{ $grado->seccion }} · {{ ucfirst($jornada) }} · {{ $grado->anio_lectivo }}
            </span>
        </div>

    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}

{{-- ══════════════════════════════════════
     MODAL — Editar Celda
══════════════════════════════════════ --}}
<div class="modal fade" id="modalCelda" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content" style="border-radius:14px;border:1px solid #e8edf4;
                                          box-shadow:0 8px 32px rgba(0,59,115,.15);overflow:hidden;">

            {{-- Header modal --}}
            <div style="background:linear-gradient(135deg,#002d5a,#00508f,#0077b6);
                        padding:1.2rem 1.4rem;position:relative;overflow:hidden;">
                <div style="position:absolute;right:-30px;top:-30px;width:100px;height:100px;
                            border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
                <div style="display:flex;align-items:center;justify-content:space-between;
                            position:relative;z-index:1;">
                    <div style="display:flex;align-items:center;gap:.7rem;">
                        <div style="width:38px;height:38px;border-radius:9px;
                                    background:rgba(255,255,255,.15);
                                    display:flex;align-items:center;justify-content:center;
                                    border:1.5px solid rgba(78,199,210,.5);">
                            <i class="fas fa-clock" style="color:white;font-size:.9rem;"></i>
                        </div>
                        <div>
                            <div style="font-size:.88rem;font-weight:700;color:white;">
                                Editar Clase
                            </div>
                            <div style="font-size:.68rem;color:rgba(255,255,255,.75);"
                                 id="modal-subtitle">Selecciona día y hora</div>
                        </div>
                    </div>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"
                            style="opacity:.8;"></button>
                </div>
            </div>

            {{-- Body modal --}}
            <div style="padding:1.3rem 1.4rem;background:white;">

                <input type="hidden" id="m_dia">
                <input type="hidden" id="m_hora">

                <div style="margin-bottom:.9rem;">
                    <label class="modal-label">
                        <i class="fas fa-book" style="color:#4ec7d2;margin-right:.3rem;"></i>
                        Materia
                    </label>
                    <select id="m_materia" class="modal-select">
                        <option value="">— Sin asignar —</option>
                        @foreach($materias as $m)
                            <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom:.9rem;">
                    <label class="modal-label">
                        <i class="fas fa-user-tie" style="color:#4ec7d2;margin-right:.3rem;"></i>
                        Profesor
                    </label>
                    <select id="m_profesor" class="modal-select">
                        <option value="">— Sin asignar —</option>
                        @foreach($profesores as $p)
                            <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="modal-label">
                        <i class="fas fa-door-open" style="color:#4ec7d2;margin-right:.3rem;"></i>
                        Aula
                    </label>
                    <input id="m_salon" class="modal-input" placeholder="Ej: 2B">
                </div>

            </div>

            {{-- Footer modal --}}
            <div style="display:flex;gap:.6rem;padding:1rem 1.4rem;
                        background:#f5f8fc;border-top:1px solid #e8edf4;">
                <button id="btnEliminarCelda" class="btn-eliminar-celda">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
                <button id="btnGuardarCelda" class="btn-guardar-celda">
                    <i class="fas fa-save"></i> Guardar
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

    // ── Abrir modal al hacer clic en celda ──
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
            document.getElementById('modal-subtitle').textContent = `${dia} · ${hora}`;

            modal.show();
        });
    });

    // ── Guardar celda ──
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

        const materiaTexto  = materiaSelect.value
            ? materiaSelect.options[materiaSelect.selectedIndex].text : null;
        const profesorTexto = profesorSelect.value
            ? profesorSelect.options[profesorSelect.selectedIndex].text : '—';
        const salonTexto    = salon || '—';

        if (celdaSeleccionada) {
            celdaSeleccionada.innerHTML = materiaTexto
                ? `<span class="materia">${materiaTexto}</span>
                   <span class="meta">${profesorTexto} · Aula: ${salonTexto}</span>`
                : `<span class="td-vacia">Clic para asignar</span>`;
        }

        modal.hide();
    });

    // ── Eliminar celda ──
    document.getElementById('btnEliminarCelda').addEventListener('click', function () {

        const dia  = document.getElementById('m_dia').value;
        const hora = document.getElementById('m_hora').value;

        estructura[dia][hora] = null;

        if (celdaSeleccionada) {
            celdaSeleccionada.innerHTML = `<span class="td-vacia">Clic para asignar</span>`;
        }

        modal.hide();
    });

    // ── Guardar todo ──
    document.getElementById('guardarHorario').addEventListener('click', function () {
        document.getElementById('inputHorario').value = JSON.stringify(estructura);
        document.getElementById('formGuardar').submit();
    });

});
</script>
@endpush
