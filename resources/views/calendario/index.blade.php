@extends('layouts.app')

@section('title', 'Calendario Académico')
@section('page-title', 'Calendario Académico')

@php
    $esSuperAdmin = auth()->user()->user_type === 'super_admin' || auth()->user()->is_super_admin;
@endphp

@section('topbar-actions')
    <a href="{{ $esSuperAdmin ? route('superadmin.dashboard') : route('admin.dashboard') }}"
       class="adm-btn-outline">
        <i class="fas fa-arrow-left"></i> Volver al Dashboard
    </a>
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
.adm-wrap { font-family: 'Inter', sans-serif; }
.adm-btn-outline {
    display:inline-flex;align-items:center;gap:.4rem;padding:.42rem 1rem;
    border-radius:7px;font-size:.82rem;font-weight:600;background:#fff;
    color:#00508f;border:1.5px solid #4ec7d2;text-decoration:none;transition:background .15s;
}
.adm-btn-outline:hover { background:#e8f8f9;color:#00508f; }
.adm-card { background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.05); }
.adm-card-head { background:#003b73;padding:.85rem 1.25rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem; }
.adm-card-head-left { display:flex;align-items:center;gap:.6rem; }
.adm-card-head-left i { color:#4ec7d2;font-size:1rem; }
.adm-card-head-left span { color:#fff;font-weight:700;font-size:.95rem; }
.adm-card-body { padding:1.25rem; }
.legend { display:flex;gap:.5rem;flex-wrap:wrap;margin:0; }
.legend-item { display:inline-flex;align-items:center;gap:.35rem;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.85); }
.legend-dot { width:9px;height:9px;border-radius:50%;flex-shrink:0; }
.cal-hint { display:inline-flex;align-items:center;gap:.4rem;font-size:.73rem;color:#94a3b8;margin-bottom:.85rem;font-style:italic; }
.cal-hint i { color:#4ec7d2; }

/* FullCalendar */
.fc { font-family:'Inter',sans-serif;font-size:.82rem; }
.fc .fc-toolbar-title { font-size:1rem;font-weight:700;color:#0f172a; }
.fc .fc-button { background:#fff!important;color:#00508f!important;border:1.5px solid #e2e8f0!important;border-radius:7px!important;font-size:.78rem!important;font-weight:600!important;padding:.3rem .7rem!important;box-shadow:none!important;transition:all .15s!important; }
.fc .fc-button:hover { background:#e8f8f9!important;border-color:#4ec7d2!important; }
.fc .fc-button-active,
.fc .fc-button-primary:not(:disabled).fc-button-active { background:linear-gradient(135deg,#4ec7d2,#00508f)!important;color:#fff!important;border-color:#4ec7d2!important; }
.fc .fc-col-header-cell { background:#f8fafc; }
.fc .fc-col-header-cell-cushion { color:#64748b;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;text-decoration:none; }
.fc .fc-daygrid-day-number { color:#334155;font-size:.78rem;font-weight:500;text-decoration:none; }
.fc .fc-daygrid-day.fc-day-today { background:#f0f9ff!important; }
.fc .fc-event { border-radius:5px!important;border:none!important;font-size:.72rem!important;font-weight:600!important;padding:.1rem .35rem!important;cursor:pointer!important; }
.fc .fc-toolbar { margin-bottom:1rem!important; }
.fc .fc-scrollgrid { border-radius:8px;overflow:hidden; }
.can-edit .fc-daygrid-day { cursor:pointer!important;transition:background .12s!important; }
.can-edit .fc-daygrid-day:hover { background:#eef9fb!important; }

/* Modal */
.cal-modal-overlay { position:fixed;inset:0;background:rgba(0,0,0,.5);backdrop-filter:blur(3px);display:none;align-items:center;justify-content:center;z-index:9999; }
.cal-modal-overlay.show { display:flex; }
.cal-modal { background:#fff;border-radius:12px;width:100%;max-width:490px;margin:1rem;box-shadow:0 10px 40px rgba(0,0,0,.2);overflow:hidden;animation:slideUp .22s ease; }
@keyframes slideUp { from{transform:translateY(18px);opacity:0;}to{transform:translateY(0);opacity:1;} }
.cal-modal-head { background:#003b73;padding:.85rem 1.25rem;display:flex;align-items:center;justify-content:space-between; }
.cal-modal-head span { color:#fff;font-weight:700;font-size:.95rem; }
.cal-modal-close { background:none;border:none;color:rgba(255,255,255,.7);cursor:pointer;font-size:1rem;padding:0;line-height:1;transition:color .15s; }
.cal-modal-close:hover { color:#fff; }
.cal-modal-body { padding:1.25rem; }
.cal-modal-footer { padding:.85rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:.5rem;flex-wrap:wrap; }
.tipo-indicator { display:flex;align-items:center;gap:.5rem;padding:.4rem .75rem;border-radius:8px;background:#f8fafc;border:1.5px solid #e2e8f0;font-size:.78rem;font-weight:600;color:#334155;margin-bottom:.85rem;transition:border-color .2s; }
.tipo-dot { width:10px;height:10px;border-radius:50%;flex-shrink:0;transition:background .2s; }
.frm-label { display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:.35rem; }
.frm-label i { color:#4ec7d2;margin-right:.25rem; }
.frm-control { width:100%;padding:.42rem .75rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.82rem;color:#0f172a;background:#f8fafc;outline:none;transition:border-color .15s,box-shadow .15s;font-family:'Inter',sans-serif; }
.frm-control:focus { border-color:#4ec7d2;box-shadow:0 0 0 3px rgba(78,199,210,.12);background:#fff; }
.frm-row-2 { display:grid;grid-template-columns:1fr 1fr;gap:.75rem; }
@media(max-width:420px){ .frm-row-2 { grid-template-columns:1fr; } }
.frm-group { display:flex;flex-direction:column;margin-bottom:.85rem; }
.frm-group:last-child { margin-bottom:0; }
.btn-modal-cancel { display:inline-flex;align-items:center;gap:.3rem;padding:.42rem 1rem;border-radius:7px;font-size:.82rem;font-weight:600;background:#fff;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;transition:all .15s;font-family:'Inter',sans-serif; }
.btn-modal-cancel:hover { background:#f8fafc;border-color:#94a3b8; }
.btn-modal-delete { display:inline-flex;align-items:center;gap:.3rem;padding:.42rem 1rem;border-radius:7px;font-size:.82rem;font-weight:600;background:#fff;color:#ef4444;border:1.5px solid #fecaca;cursor:pointer;transition:all .15s;font-family:'Inter',sans-serif; }
.btn-modal-delete:hover { background:#fef2f2;border-color:#ef4444; }
.btn-modal-save { display:inline-flex;align-items:center;gap:.3rem;padding:.42rem 1.1rem;border-radius:7px;font-size:.82rem;font-weight:600;background:linear-gradient(135deg,#4ec7d2,#00508f);color:#fff;border:none;cursor:pointer;box-shadow:0 4px 10px rgba(0,80,143,.25);transition:opacity .15s;font-family:'Inter',sans-serif; }
.btn-modal-save:hover { opacity:.88; }
.btn-modal-save:disabled { opacity:.6;cursor:not-allowed; }
.cal-toast { position:fixed;bottom:1.5rem;right:1.5rem;z-index:99999;background:#0f172a;color:#fff;border-radius:10px;padding:.65rem 1.1rem;font-size:.82rem;font-weight:600;display:flex;align-items:center;gap:.5rem;box-shadow:0 4px 20px rgba(0,0,0,.25);transform:translateY(20px);opacity:0;transition:all .3s ease;pointer-events:none; }
.cal-toast.show { transform:translateY(0);opacity:1; }
.cal-toast.success i { color:#4ec7d2; }
.cal-toast.error i { color:#ef4444; }
</style>
@endpush

@section('content')
<div class="adm-wrap">
    <div class="adm-card">

        <div class="adm-card-head">
            <div class="adm-card-head-left">
                <i class="fas fa-calendar-alt"></i>
                <span>Calendario Académico</span>
            </div>
            <div class="legend">
                <div class="legend-item"><div class="legend-dot" style="background:#3788d8"></div> Clase</div>
                <div class="legend-item"><div class="legend-dot" style="background:#dc3545"></div> Examen</div>
                <div class="legend-item"><div class="legend-dot" style="background:#28a745"></div> Festivo</div>
                <div class="legend-item"><div class="legend-dot" style="background:#ffc107"></div> Evento</div>
                <div class="legend-item"><div class="legend-dot" style="background:#17a2b8"></div> Vacaciones</div>
                <div class="legend-item"><div class="legend-dot" style="background:#9c27b0"></div> Prematrícula</div>
                <div class="legend-item"><div class="legend-dot" style="background:#ff5722"></div> Matrícula</div>
            </div>
        </div>

        <div class="adm-card-body {{ $esSuperAdmin ? 'can-edit' : '' }}">
            @if($esSuperAdmin)
                <div class="cal-hint">
                    <i class="fas fa-hand-pointer"></i>
                    Clic en un día para crear un evento &middot; Clic en un evento para editarlo &middot; Arrastra para mover
                </div>
            @endif
            <div id="calendar"></div>
        </div>

    </div>
</div>

<div class="cal-toast" id="calToast">
    <i class="fas fa-check-circle"></i>
    <span id="calToastMsg">Evento guardado</span>
</div>

@if($esSuperAdmin)
<div class="cal-modal-overlay" id="calModalOverlay">
    <div class="cal-modal">
        <div class="cal-modal-head">
            <span id="modalTitle"><i class="fas fa-calendar-plus me-2"></i>Nuevo Evento</span>
            <button class="cal-modal-close" onclick="cerrarModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="cal-modal-body">
            <div class="tipo-indicator" id="tipoIndicator">
                <div class="tipo-dot" id="tipoDot" style="background:#3788d8"></div>
                <span id="tipoLabel">Clase</span>
            </div>
            <form id="eventForm" onsubmit="return false;">
                <input type="hidden" id="eventId">
                <div class="frm-group">
                    <label class="frm-label"><i class="fas fa-heading"></i> Título</label>
                    <input type="text" id="title" class="frm-control" placeholder="Nombre del evento" required autocomplete="off">
                </div>
                <div class="frm-group">
                    <label class="frm-label"><i class="fas fa-align-left"></i> Descripción</label>
                    <textarea id="description" class="frm-control" rows="2" placeholder="Descripción opcional..."></textarea>
                </div>
                <div class="frm-group">
                    <label class="frm-label"><i class="fas fa-tag"></i> Tipo</label>
                    <select id="type" class="frm-control" required onchange="actualizarTipoIndicator()">
                        <option value="clase">📘 Clase</option>
                        <option value="examen">📝 Examen</option>
                        <option value="festivo">🎉 Festivo</option>
                        <option value="evento">📅 Evento</option>
                        <option value="vacaciones">🏖️ Vacaciones</option>
                        <option value="prematricula">📋 Prematrícula</option>
                        <option value="matricula">✏️ Matrícula</option>
                    </select>
                </div>
                <div class="frm-row-2">
                    <div class="frm-group">
                        <label class="frm-label"><i class="fas fa-calendar"></i> Fecha inicio</label>
                        <input type="date" id="start_date" class="frm-control" required>
                    </div>
                    <div class="frm-group">
                        <label class="frm-label"><i class="fas fa-calendar-check"></i> Fecha fin</label>
                        <input type="date" id="end_date" class="frm-control" required>
                    </div>
                </div>
            </form>
        </div>
        <div class="cal-modal-footer">
            <button class="btn-modal-delete" id="deleteBtn" style="display:none;" onclick="eliminarEvento()">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
            <div style="display:flex;gap:.5rem;margin-left:auto;">
                <button class="btn-modal-cancel" onclick="cerrarModal()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button class="btn-modal-save" id="saveBtn" onclick="guardarEvento()">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js'></script>
<script>
// Usando user_type e is_super_admin de la migración
const esSuperAdmin = {{ ($esSuperAdmin ? 'true' : 'false') }};

const coloresPorTipo = {
    'clase':        '#3788d8',
    'examen':       '#dc3545',
    'festivo':      '#28a745',
    'evento':       '#ffc107',
    'vacaciones':   '#17a2b8',
    'prematricula': '#9c27b0',
    'matricula':    '#ff5722',
};

const nombresPorTipo = {
    'clase':'Clase','examen':'Examen','festivo':'Festivo',
    'evento':'Evento','vacaciones':'Vacaciones',
    'prematricula':'Prematrícula','matricula':'Matrícula',
};

let calendario;

document.addEventListener('DOMContentLoaded', function () {
    calendario = new FullCalendar.Calendar(document.getElementById('calendar'), {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,dayGridWeek,listMonth',
        },
        buttonText: { today:'Hoy', month:'Mes', week:'Semana', list:'Lista' },
        events:       '/calendario/eventos',
        editable:     esSuperAdmin,
        selectable:   esSuperAdmin,
        selectMirror: false,
        dayMaxEvents: true,

        // Clic simple en un día → abrir modal con esa fecha
        dateClick: function (info) {
            if (!esSuperAdmin) return;
            abrirModal(null, info.dateStr, info.dateStr);
        },

        // Arrastrar rango → abrir modal con fechas
        select: function (info) {
            if (!esSuperAdmin) return;
            const fin = new Date(info.endStr);
            fin.setDate(fin.getDate() - 1);
            abrirModal(null, info.startStr, fin.toISOString().split('T')[0]);
        },

        // Clic en evento existente → editar
        eventClick: function (info) {
            if (!esSuperAdmin) return;
            info.jsEvent.stopPropagation();
            abrirModal(info.event);
        },

        eventDrop: function (info) {
            if (!esSuperAdmin) { info.revert(); return; }
            actualizarFechasEvento(info.event);
        },

        eventResize: function (info) {
            if (!esSuperAdmin) { info.revert(); return; }
            actualizarFechasEvento(info.event);
        },
    });

    calendario.render();
});

function actualizarTipoIndicator() {
    const tipo  = document.getElementById('type').value;
    const color = coloresPorTipo[tipo] || '#3788d8';
    document.getElementById('tipoDot').style.background        = color;
    document.getElementById('tipoLabel').textContent           = nombresPorTipo[tipo] || tipo;
    document.getElementById('tipoIndicator').style.borderColor = color + '66';
}

function abrirModal(evento, fechaInicio, fechaFin) {
    document.getElementById('eventForm').reset();
    document.getElementById('eventId').value = '';

    if (evento) {
        document.getElementById('modalTitle').innerHTML =
            '<i class="fas fa-pen me-2" style="color:#4ec7d2;"></i>Editar Evento';
        document.getElementById('deleteBtn').style.display = 'flex';
        document.getElementById('eventId').value     = evento.id;
        document.getElementById('title').value       = evento.title;
        document.getElementById('description').value = evento.extendedProps.description || '';
        document.getElementById('type').value        = evento.extendedProps.type || 'clase';
        document.getElementById('start_date').value  = evento.startStr.split('T')[0];
        document.getElementById('end_date').value    = evento.endStr
            ? new Date(new Date(evento.endStr) - 86400000).toISOString().split('T')[0]
            : evento.startStr.split('T')[0];
    } else {
        document.getElementById('modalTitle').innerHTML =
            '<i class="fas fa-calendar-plus me-2" style="color:#4ec7d2;"></i>Nuevo Evento';
        document.getElementById('deleteBtn').style.display = 'none';
        document.getElementById('type').value = 'clase';
        if (fechaInicio) document.getElementById('start_date').value = fechaInicio;
        if (fechaFin)    document.getElementById('end_date').value   = fechaFin;
    }

    actualizarTipoIndicator();
    document.getElementById('calModalOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
    setTimeout(function () { document.getElementById('title').focus(); }, 200);
}

function cerrarModal() {
    document.getElementById('calModalOverlay').classList.remove('show');
    document.body.style.overflow = '';
}

document.getElementById('calModalOverlay')?.addEventListener('click', function (e) {
    if (e.target === this) cerrarModal();
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') cerrarModal();
});

function mostrarToast(msg, tipo) {
    tipo = tipo || 'success';
    const toast = document.getElementById('calToast');
    document.getElementById('calToastMsg').textContent = msg;
    toast.className = 'cal-toast ' + tipo;
    toast.querySelector('i').className = tipo === 'success'
        ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
    toast.classList.add('show');
    setTimeout(function () { toast.classList.remove('show'); }, 3000);
}

async function guardarEvento() {
    const titulo = document.getElementById('title').value.trim();
    if (!titulo) { document.getElementById('title').focus(); return; }

    const saveBtn  = document.getElementById('saveBtn');
    const eventoId = document.getElementById('eventId').value;
    const tipo     = document.getElementById('type').value;

    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

    const datos = {
        titulo:       titulo,
        descripcion:  document.getElementById('description').value,
        fecha_inicio: document.getElementById('start_date').value,
        fecha_fin:    document.getElementById('end_date').value,
        tipo:         tipo,
        color:        coloresPorTipo[tipo],
        todo_el_dia:  1,
    };

    const url    = eventoId ? '/calendario/eventos/' + eventoId : '/calendario/eventos';
    const metodo = eventoId ? 'PUT' : 'POST';

    try {
        const resp = await fetch(url, {
            method: metodo,
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(datos),
        });

        const resultado = await resp.json();

        if (resp.ok && resultado.exito) {
            cerrarModal();
            calendario.refetchEvents();
            mostrarToast(eventoId ? 'Evento actualizado correctamente' : 'Evento creado correctamente');
        } else {
            let msg = resultado.mensaje || 'Error de validación';
            if (resultado.errores) msg = Object.values(resultado.errores).flat().join('\n');
            mostrarToast(msg, 'error');
        }
    } catch (err) {
        console.error(err);
        mostrarToast('Error al guardar el evento.', 'error');
    } finally {
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<i class="fas fa-save"></i> Guardar';
    }
}

async function eliminarEvento() {
    const eventoId  = document.getElementById('eventId').value;
    if (!eventoId) return;

    const deleteBtn = document.getElementById('deleteBtn');

    if (deleteBtn.dataset.confirm !== 'true') {
        deleteBtn.dataset.confirm = 'true';
        deleteBtn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ¿Confirmar?';
        setTimeout(function () {
            if (deleteBtn.dataset.confirm === 'true') {
                deleteBtn.dataset.confirm = 'false';
                deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Eliminar';
            }
        }, 3000);
        return;
    }

    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    try {
        const resp = await fetch('/calendario/eventos/' + eventoId, {
            method: 'DELETE',
            headers: {
                'Accept':       'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        if (resp.ok) {
            cerrarModal();
            calendario.refetchEvents();
            mostrarToast('Evento eliminado correctamente');
        } else {
            mostrarToast('Error al eliminar el evento.', 'error');
        }
    } catch (err) {
        mostrarToast('Error al eliminar el evento.', 'error');
    } finally {
        deleteBtn.dataset.confirm = 'false';
        deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Eliminar';
    }
}

async function actualizarFechasEvento(evento) {
    const datos = {
        titulo:       evento.title,
        descripcion:  evento.extendedProps.description || '',
        fecha_inicio: evento.startStr.split('T')[0],
        fecha_fin:    evento.endStr
            ? new Date(new Date(evento.endStr) - 86400000).toISOString().split('T')[0]
            : evento.startStr.split('T')[0],
        tipo:         evento.extendedProps.type || 'evento',
        color:        evento.backgroundColor,
        todo_el_dia:  evento.allDay ? 1 : 0,
    };

    try {
        await fetch('/calendario/eventos/' + evento.id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(datos),
        });
        mostrarToast('Evento movido correctamente');
    } catch (err) {
        console.error(err);
        calendario.refetchEvents();
    }
}
</script>
@endpush
