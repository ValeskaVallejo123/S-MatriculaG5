@extends('layouts.app')

@section('title', 'Calendario Académico')
@section('page-title', 'Calendario Académico')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.adm-wrap { font-family: 'Inter', sans-serif; }

/* Stats */
.adm-stats {
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
@media(max-width:768px){ .adm-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .adm-stats { grid-template-columns: 1fr; } }

.adm-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.adm-stat-icon i { font-size: 1.15rem; color: #fff; }
.adm-stat-lbl { font-size: .72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .15rem; }
.adm-stat-num { font-size: 1.75rem; font-weight: 700; color: #0f172a; line-height: 1; }

/* Card */
.adm-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 1.25rem;
}
.adm-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
}
.adm-card-head-left { display: flex; align-items: center; gap: .6rem; }
.adm-card-head i { color: #4ec7d2; font-size: 1rem; }
.adm-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }
.adm-card-body { padding: 1.5rem; }

/* Leyenda */
.legend-wrap { display: flex; gap: .65rem; flex-wrap: wrap; padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; }
.legend-item { display: flex; align-items: center; gap: .4rem; font-size: .75rem; color: #334155; font-weight: 500; }
.legend-dot { width: 12px; height: 12px; border-radius: 3px; flex-shrink: 0; }

/* FullCalendar overrides */
#calendar {
    --fc-border-color: #f1f5f9;
    --fc-today-bg-color: rgba(78,199,210,.07);
    --fc-page-bg-color: #fff;
    font-family: 'Inter', sans-serif;
    font-size: .82rem;
}
.fc .fc-toolbar-title { font-size: 1rem; font-weight: 700; color: #0f172a; }
.fc .fc-button {
    background: #fff; border: 1.5px solid #e2e8f0; color: #00508f;
    font-size: .78rem; font-weight: 600; padding: .32rem .7rem; border-radius: 7px;
    box-shadow: none; transition: all .15s;
}
.fc .fc-button:hover { background: #e8f8f9; border-color: #4ec7d2; }
.fc .fc-button-active, .fc .fc-button-primary:not(:disabled).fc-button-active {
    background: linear-gradient(135deg,#4ec7d2,#00508f) !important;
    border-color: transparent !important; color: #fff !important;
}
.fc .fc-button-primary:focus { box-shadow: none !important; }
.fc .fc-col-header-cell { background: #f8fafc; }
.fc .fc-col-header-cell-cushion { font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #64748b; padding: .5rem; }
.fc .fc-daygrid-day-number { font-size: .8rem; font-weight: 600; color: #334155; padding: .4rem; }
.fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number { color: #00508f; font-weight: 700; }
.fc .fc-event { border-radius: 5px; font-size: .72rem; font-weight: 600; padding: 2px 5px; border: none; }
.fc .fc-toolbar { flex-wrap: wrap; gap: .5rem; }
.fc .fc-toolbar-chunk { display: flex; align-items: center; gap: .3rem; }

/* Modal */
.modal-content { border-radius: 12px; border: none; overflow: hidden; }
.modal-header { background: #003b73; padding: 1rem 1.25rem; border-bottom: none; }
.modal-header .modal-title { color: #fff; font-size: .95rem; font-weight: 700; display: flex; align-items: center; gap: .5rem; }
.modal-header .btn-close { filter: invert(1) brightness(2); }
.modal-body { padding: 1.25rem 1.5rem; }
.modal-footer { background: #f8fafc; border-top: 1px solid #f1f5f9; padding: .85rem 1.5rem; gap: .5rem; }

.form-label { font-size: .78rem; font-weight: 600; color: #334155; margin-bottom: .35rem; }
.form-control, .form-select {
    border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: .84rem;
    padding: .45rem .85rem; color: #0f172a; background: #f8fafc;
}
.form-control:focus, .form-select:focus {
    border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.12); background: #fff;
}

.btn-cancel-modal {
    padding: .42rem 1rem; border-radius: 7px; border: 1.5px solid #e2e8f0;
    background: #fff; color: #64748b; font-size: .82rem; font-weight: 600; cursor: pointer;
}
.btn-cancel-modal:hover { background: #f1f5f9; }
.btn-save-modal {
    padding: .42rem 1rem; border-radius: 7px; border: none;
    background: linear-gradient(135deg,#4ec7d2,#00508f); color: #fff;
    font-size: .82rem; font-weight: 600; cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,80,143,.2);
}
.btn-save-modal:hover { opacity: .88; }
.btn-del-modal {
    padding: .42rem 1rem; border-radius: 7px; border: none;
    background: #fef2f2; color: #ef4444; font-size: .82rem; font-weight: 600; cursor: pointer;
}
.btn-del-modal:hover { background: #ef4444; color: #fff; }
</style>
@endpush

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="adm-wrap">

    {{-- Stats dinámicas (opcionales, si pasas contadores desde el controller) --}}
    <div class="adm-stats">
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Clases</div>
                <div class="adm-stat-num" id="count-clase">—</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#f87171,#dc2626);">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Exámenes</div>
                <div class="adm-stat-num" id="count-examen">—</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#9c27b0,#7b1fa2);">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Matrículas</div>
                <div class="adm-stat-num" id="count-matricula">—</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Festivos</div>
                <div class="adm-stat-num" id="count-festivo">—</div>
            </div>
        </div>
    </div>

    {{-- Calendario --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <div class="adm-card-head-left">
                <i class="fas fa-calendar-alt"></i>
                <span>Calendario Académico</span>
            </div>
        </div>

        {{-- Leyenda --}}
        <div class="legend-wrap">
            <div class="legend-item"><div class="legend-dot" style="background:#3788d8"></div> Clase</div>
            <div class="legend-item"><div class="legend-dot" style="background:#dc3545"></div> Examen</div>
            <div class="legend-item"><div class="legend-dot" style="background:#28a745"></div> Festivo</div>
            <div class="legend-item"><div class="legend-dot" style="background:#ffc107"></div> Evento</div>
            <div class="legend-item"><div class="legend-dot" style="background:#17a2b8"></div> Vacaciones</div>
            <div class="legend-item"><div class="legend-dot" style="background:#9c27b0"></div> Prematrícula</div>
            <div class="legend-item"><div class="legend-dot" style="background:#ff5722"></div> Matrícula</div>
        </div>

        <div class="adm-card-body">
            <div id='calendar'></div>
        </div>
    </div>

</div>

{{-- Modal Agregar/Editar --}}
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-plus"></i>
                    <span id="modalTitle">Agregar Evento</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <input type="hidden" id="eventId">
                    <div class="mb-3">
                        <label class="form-label">Título *</label>
                        <input type="text" class="form-control" id="title" required placeholder="Nombre del evento">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" rows="2" placeholder="Descripción opcional"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo *</label>
                        <select class="form-select" id="type" required>
                            <option value="clase">Clase</option>
                            <option value="examen">Examen</option>
                            <option value="festivo">Festivo</option>
                            <option value="evento">Evento</option>
                            <option value="vacaciones">Vacaciones</option>
                            <option value="prematricula">Prematrícula</option>
                            <option value="matricula">Matrícula</option>
                        </select>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Fecha Inicio *</label>
                            <input type="date" class="form-control" id="start_date" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Fecha Fin *</label>
                            <input type="date" class="form-control" id="end_date" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-del-modal" id="deleteBtn" style="display:none;">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
                <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-save-modal" id="saveBtn">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js'></script>
@endsection

@push('scripts')
<script>
const coloresPorTipo = {
    'clase'        : '#3788d8',
    'examen'       : '#dc3545',
    'festivo'      : '#28a745',
    'evento'       : '#ffc107',
    'vacaciones'   : '#17a2b8',
    'prematricula' : '#9c27b0',
    'matricula'    : '#ff5722'
};

let calendario;
let modalEvento;

document.addEventListener('DOMContentLoaded', function () {

    modalEvento = new bootstrap.Modal(document.getElementById('eventModal'));

    calendario = new FullCalendar.Calendar(document.getElementById('calendar'), {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,listMonth'
        },
        buttonText: { today:'Hoy', month:'Mes', week:'Semana', list:'Lista' },
        events: '/calendario/eventos',
        editable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,

        select: (info) => abrirModal(null, info.startStr, info.endStr),
        eventClick: (info) => abrirModal(info.event),
        eventDrop: (info) => actualizarFechasEvento(info.event),
        eventResize: (info) => actualizarFechasEvento(info.event),

        // Actualizar contadores al cargar eventos
        eventsSet: function(events) {
            const tipos = ['clase','examen','festivo','matricula'];
            tipos.forEach(t => {
                const el = document.getElementById('count-' + t);
                if(el) el.textContent = events.filter(e => e.extendedProps.type === t).length;
            });
        }
    });

    calendario.render();

    document.getElementById('saveBtn').addEventListener('click', guardarEvento);
    document.getElementById('deleteBtn').addEventListener('click', eliminarEvento);
});

function abrirModal(evento = null, fechaInicio = null, fechaFin = null) {
    document.getElementById('eventForm').reset();
    document.getElementById('eventId').value = '';

    if (evento) {
        document.getElementById('modalTitle').textContent = 'Editar Evento';
        document.getElementById('deleteBtn').style.display = 'inline-flex';
        document.getElementById('eventId').value = evento.id;
        document.getElementById('title').value = evento.title;
        document.getElementById('description').value = evento.extendedProps.description || '';
        document.getElementById('type').value = evento.extendedProps.type;
        document.getElementById('start_date').value = evento.startStr;
        document.getElementById('end_date').value = evento.endStr ? evento.endStr : evento.startStr;
    } else {
        document.getElementById('modalTitle').textContent = 'Agregar Evento';
        document.getElementById('deleteBtn').style.display = 'none';
        if (fechaInicio) document.getElementById('start_date').value = fechaInicio;
        if (fechaFin) {
            const fin = new Date(fechaFin);
            fin.setDate(fin.getDate() - 1);
            document.getElementById('end_date').value = fin.toISOString().split('T')[0];
        }
    }
    modalEvento.show();
}

async function guardarEvento() {
    const eventoId = document.getElementById('eventId').value;
    const tipo = document.getElementById('type').value;
    const datos = {
        titulo: document.getElementById('title').value,
        descripcion: document.getElementById('description').value,
        fecha_inicio: document.getElementById('start_date').value,
        fecha_fin: document.getElementById('end_date').value,
        tipo: tipo,
        color: coloresPorTipo[tipo],
        todo_el_dia: 1
    };
    const url    = eventoId ? `/calendario/eventos/${eventoId}` : '/calendario/eventos';
    const metodo = eventoId ? 'PUT' : 'POST';
    try {
        const resp = await fetch(url, {
            method: metodo,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(datos)
        });
        const result = await resp.json();
        if (resp.ok) {
            modalEvento.hide();
            calendario.refetchEvents();
        } else {
            const msg = result.errores
                ? Object.values(result.errores).flat().join('\n')
                : (result.mensaje || 'Error de validación');
            alert('Atención:\n' + msg);
        }
    } catch(e) { console.error(e); alert('Error crítico. Revisa la consola.'); }
}

async function eliminarEvento() {
    const eventoId = document.getElementById('eventId').value;
    if (!confirm('¿Eliminar este evento?')) return;
    try {
        const resp = await fetch(`/calendario/eventos/${eventoId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        if (resp.ok) { modalEvento.hide(); calendario.refetchEvents(); }
    } catch(e) { console.error(e); alert('Error al eliminar el evento.'); }
}

async function actualizarFechasEvento(evento) {
    const datos = {
        titulo: evento.title,
        descripcion: evento.extendedProps.description,
        fecha_inicio: evento.startStr,
        fecha_fin: evento.endStr || evento.startStr,
        tipo: evento.extendedProps.type,
        color: evento.backgroundColor,
        todo_el_dia: evento.allDay ? 1 : 0
    };
    try {
        await fetch(`/calendario/eventos/${evento.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(datos)
        });
    } catch(e) { console.error(e); calendario.refetchEvents(); }
}
</script>
@endpush
