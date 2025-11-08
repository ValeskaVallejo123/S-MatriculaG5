<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Calendario Académico</title>
    
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .calendar-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 1200px;
        }
        .legend {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="calendar-container">
            <h1 class="mb-4">📅 Calendario Académico</h1>
            
            <div class="legend mb-3">
                <div class="legend-item">
                    <div class="legend-color" style="background: #3788d8"></div>
                    <span>Clase</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #dc3545"></div>
                    <span>Examen</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #28a745"></div>
                    <span>Festivo</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #ffc107"></div>
                    <span>Evento</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #17a2b8"></div>
                    <span>Vacaciones</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #9c27b0"></div>
                    <span>Prematrícula</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #ff5722"></div>
                    <span>Matrícula</span>
                </div>
            </div>

            <div id='calendar'></div>
        </div>
    </div>

    <!-- Modal para agregar/editar evento -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Agregar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" id="eventId">
                        
                        <div class="mb-3">
                            <label class="form-label">Título *</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" rows="3"></textarea>
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha Inicio *</label>
                                <input type="date" class="form-control" id="start_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha Fin *</label>
                                <input type="date" class="form-control" id="end_date" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deleteBtn" style="display:none;">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveBtn">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const coloresPorTipo = {
            'clase': '#3788d8',
            'examen': '#dc3545',
            'festivo': '#28a745',
            'evento': '#ffc107',
            'vacaciones': '#17a2b8',
            'prematricula': '#9c27b0',
            'matricula': '#ff5722'
        };

        let calendario;
        let modalEvento;

        document.addEventListener('DOMContentLoaded', function() {
            const elementoCalendario = document.getElementById('calendar');
            modalEvento = new bootstrap.Modal(document.getElementById('eventModal'));

            calendario = new FullCalendar.Calendar(elementoCalendario, {
                locale: 'es',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,listMonth'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    list: 'Lista'
                },
                events: '/calendario/eventos',
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                
                select: function(info) {
                    abrirModal(null, info.startStr, info.endStr);
                },
                
                eventClick: function(info) {
                    const evento = info.event;
                    abrirModal(evento);
                },
                
                eventDrop: function(info) {
                    actualizarFechasEvento(info.event);
                },
                
                eventResize: function(info) {
                    actualizarFechasEvento(info.event);
                }
            });

            calendario.render();

            // Escuchadores de eventos
            document.getElementById('type').addEventListener('change', function() {
                // Color automático según tipo
            });

            document.getElementById('saveBtn').addEventListener('click', guardarEvento);
            document.getElementById('deleteBtn').addEventListener('click', eliminarEvento);
        });

        function abrirModal(evento = null, fechaInicio = null, fechaFin = null) {
            document.getElementById('eventForm').reset();
            document.getElementById('eventId').value = '';
            
            if (evento) {
                document.getElementById('modalTitle').textContent = 'Editar Evento';
                document.getElementById('deleteBtn').style.display = 'block';
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
                todo_el_dia: true
            };

            const url = eventoId ? `/calendario/eventos/${eventoId}` : '/calendario/eventos';
            const metodo = eventoId ? 'PUT' : 'POST';

            try {
                const respuesta = await fetch(url, {
                    method: metodo,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(datos)
                });

                if (respuesta.ok) {
                    modalEvento.hide();
                    calendario.refetchEvents();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al guardar el evento');
            }
        }

        async function eliminarEvento() {
            const eventoId = document.getElementById('eventId').value;
            
            if (!confirm('¿Estás seguro de eliminar este evento?')) return;

            try {
                const respuesta = await fetch(`/calendario/eventos/${eventoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (respuesta.ok) {
                    modalEvento.hide();
                    calendario.refetchEvents();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al eliminar el evento');
            }
        }

        async function actualizarFechasEvento(evento) {
            const datos = {
                titulo: evento.title,
                descripcion: evento.extendedProps.description,
                fecha_inicio: evento.startStr,
                fecha_fin: evento.endStr || evento.startStr,
                tipo: evento.extendedProps.type,
                color: evento.backgroundColor
            };

            try {
                await fetch(`/calendario/eventos/${evento.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(datos)
                });
            } catch (error) {
                console.error('Error:', error);
                calendario.refetchEvents();
            }
        }
    </script>
</body>
</html>