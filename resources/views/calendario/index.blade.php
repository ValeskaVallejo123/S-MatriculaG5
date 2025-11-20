<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Calendario Académico {{ $soloLectura ? '- Consulta Pública' : '- Administración' }}</title>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .calendar-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 1400px;
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

        .year-view-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .month-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .month-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .month-header {
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
            color: #00508f;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ec7d2;
        }

        .mini-calendar {
            width: 100%;
        }

        .mini-calendar table {
            width: 100%;
            border-collapse: collapse;
        }

        .mini-calendar th {
            text-align: center;
            padding: 8px 4px;
            font-size: 0.75rem;
            color: #666;
            font-weight: 600;
        }

        .mini-calendar td {
            text-align: center;
            padding: 8px 4px;
            font-size: 0.85rem;
            position: relative;
            border: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        .mini-calendar td:not(.other-month):not(.solo-lectura) {
            cursor: pointer;
        }

        .mini-calendar td:not(.other-month):not(.solo-lectura):hover {
            background-color: #f5f5f5;
        }

        .mini-calendar .other-month {
            color: #ccc;
        }

        .mini-calendar .today {
            background-color: #4ec7d2;
            color: white;
            font-weight: bold;
            border-radius: 4px;
        }

        .mini-calendar .has-event {
            background-color: #e3f2fd;
            font-weight: 600;
        }

        .event-dot {
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .event-dots-container {
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 2px;
        }

        #calendar {
            margin-top: 20px;
        }

        .view-toggle {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .view-toggle .btn {
            padding: 8px 16px;
            font-weight: 600;
            border-radius: 8px;
        }

        .view-toggle .btn.active {
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white;
            border: none;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .solo-lectura {
            cursor: default !important;
        }

        .btn-volver {
            background: #e2e8f0;
            color: #00508f;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid #bfd9ea;
        }

        .btn-volver:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="calendar-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">
                    <i class="fas fa-calendar-alt"></i> 
                    Calendario Académico
                    @if($soloLectura)
                        <span class="badge bg-info ms-2">Solo Lectura</span>
                    @else
                        <span class="badge bg-success ms-2">Modo Administrador</span>
                    @endif
                </h1>
                <a href="{{ $soloLectura ? route('plantilla') : url()->previous() }}" class="btn-volver">
    <i class="fas fa-arrow-left"></i> Volver
</a>
            </div>

            @if($soloLectura)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Este calendario es de <strong>solo lectura</strong>.
                    Para editar eventos debe iniciar sesión como administrador.
                </div>
            @endif

            <div class="view-toggle">
                <button class="btn active" id="viewYearBtn" onclick="cambiarVista('year')">
                    <i class="fas fa-calendar-alt"></i> Vista Anual
                </button>
                <button class="btn" id="viewMonthBtn" onclick="cambiarVista('month')">
                    <i class="fas fa-calendar"></i> Vista Mensual
                </button>
                <button class="btn" id="viewWeekBtn" onclick="cambiarVista('week')">
                    <i class="fas fa-calendar-week"></i> Vista Semanal
                </button>
            </div>

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

            <div id="yearView" class="year-view-container"></div>

            <div id='calendar' style="display: none;"></div>
        </div>
    </div>

    <!-- Modal para eventos -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detalles del Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="eventDetails"></div>
                    <form id="eventForm" style="display: none;">
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
                <div class="modal-footer" id="modalFooter">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Variable global desde Blade
        const soloLectura = {{ $soloLectura ? 'true' : 'false' }};
        
        // URL de la API según el modo
        const API_URL = soloLectura ? '/calendario/eventos/publico' : '/calendario/eventos';
        const API_BASE = soloLectura ? '' : '/admin/calendario/eventos';

        const coloresPorTipo = {
            'clase': '#3788d8',
            'examen': '#dc3545',
            'festivo': '#28a745',
            'evento': '#ffc107',
            'vacaciones': '#17a2b8',
            'prematricula': '#9c27b0',
            'matricula': '#ff5722'
        };

        const tipoTextoMap = {
            'clase': 'Clase',
            'examen': 'Examen',
            'festivo': 'Festivo',
            'evento': 'Evento',
            'vacaciones': 'Vacaciones',
            'prematricula': 'Prematrícula',
            'matricula': 'Matrícula'
        };

        let calendario;
        let modalEvento;
        let eventos = [];
        let vistaActual = 'year';
        let añoActual = new Date().getFullYear();

        const mesesNombres = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        const diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

        document.addEventListener('DOMContentLoaded', async function () {
            modalEvento = new bootstrap.Modal(document.getElementById('eventModal'));
            
            await cargarEventos();
            renderizarVistaAño();
            inicializarFullCalendar();
        });

        async function cargarEventos() {
            try {
                const respuesta = await fetch(API_URL);
                eventos = await respuesta.json();
            } catch (error) {
                console.error('Error al cargar eventos:', error);
                eventos = [];
            }
        }

        function updateCalendar() {
            if (calendario) {
                calendario.refetchEvents();
            }
        }

        function inicializarFullCalendar() {
            const elementoCalendario = document.getElementById('calendar');

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
                events: function(info, successCallback, failureCallback) {
                    fetch(API_URL)
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                },
                editable: !soloLectura,
                selectable: !soloLectura,
                selectMirror: !soloLectura,
                dayMaxEvents: true,

                select: function (info) {
                    if (!soloLectura) {
                        abrirModal(null, info.startStr, info.endStr);
                    }
                },

                eventClick: function (info) {
                    abrirModal(info.event);
                },

                eventDrop: function (info) {
                    if (!soloLectura) {
                        actualizarFechasEvento(info.event);
                    } else {
                        info.revert();
                    }
                },

                eventResize: function (info) {
                    if (!soloLectura) {
                        actualizarFechasEvento(info.event);
                    } else {
                        info.revert();
                    }
                }
            });

            calendario.render();
        }

        function cambiarVista(vista) {
            vistaActual = vista;

            document.querySelectorAll('.view-toggle .btn').forEach(btn => {
                btn.classList.remove('active');
            });

            if (vista === 'year') {
                document.getElementById('viewYearBtn').classList.add('active');
                document.getElementById('yearView').style.display = 'grid';
                document.getElementById('calendar').style.display = 'none';
            } else {
                if (vista === 'month') {
                    document.getElementById('viewMonthBtn').classList.add('active');
                    calendario.changeView('dayGridMonth');
                } else if (vista === 'week') {
                    document.getElementById('viewWeekBtn').classList.add('active');
                    calendario.changeView('dayGridWeek');
                }
                document.getElementById('yearView').style.display = 'none';
                document.getElementById('calendar').style.display = 'block';
            }
        }

        function renderizarVistaAño() {
            const contenedor = document.getElementById('yearView');
            contenedor.innerHTML = '';

            for (let mes = 0; mes < 12; mes++) {
                const tarjetaMes = crearTarjetaMes(añoActual, mes);
                contenedor.appendChild(tarjetaMes);
            }
        }

        function crearTarjetaMes(año, mes) {
            const tarjeta = document.createElement('div');
            tarjeta.className = 'month-card';

            const header = document.createElement('div');
            header.className = 'month-header';
            header.textContent = `${mesesNombres[mes]} ${año}`;
            tarjeta.appendChild(header);

            const calendarioMini = document.createElement('div');
            calendarioMini.className = 'mini-calendar';

            const tabla = document.createElement('table');

            const thead = document.createElement('thead');
            const filaDias = document.createElement('tr');
            diasSemana.forEach(dia => {
                const th = document.createElement('th');
                th.textContent = dia;
                filaDias.appendChild(th);
            });
            thead.appendChild(filaDias);
            tabla.appendChild(thead);

            const tbody = document.createElement('tbody');
            const primerDia = new Date(año, mes, 1);
            const ultimoDia = new Date(año, mes + 1, 0);
            const diasEnMes = ultimoDia.getDate();
            const diaSemanaInicio = primerDia.getDay();

            let diaActual = 1;
            let diasMesAnterior = new Date(año, mes, 0).getDate();
            let diasMostradosMesAnterior = diaSemanaInicio;

            for (let semana = 0; semana < 6; semana++) {
                const fila = document.createElement('tr');

                for (let diaSemana = 0; diaSemana < 7; diaSemana++) {
                    const celda = document.createElement('td');
                    celda.style.position = 'relative';

                    let dia, esMesActual = true;

                    if (semana === 0 && diaSemana < diaSemanaInicio) {
                        dia = diasMesAnterior - diasMostradosMesAnterior + diaSemana + 1;
                        celda.classList.add('other-month');
                        esMesActual = false;
                    } else if (diaActual > diasEnMes) {
                        dia = diaActual - diasEnMes;
                        celda.classList.add('other-month');
                        esMesActual = false;
                        diaActual++;
                    } else {
                        dia = diaActual;
                        diaActual++;
                    }

                    celda.textContent = dia;

                    if (esMesActual) {
                        const fechaStr = `${año}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;

                        const hoy = new Date();
                        if (año === hoy.getFullYear() && mes === hoy.getMonth() && dia === hoy.getDate()) {
                            celda.classList.add('today');
                        }

                        const eventosDia = obtenerEventosPorFecha(fechaStr);
                        if (eventosDia.length > 0) {
                            celda.classList.add('has-event');
                            const dotsContainer = document.createElement('div');
                            dotsContainer.className = 'event-dots-container';

                            eventosDia.slice(0, 3).forEach(evento => {
                                const dot = document.createElement('span');
                                dot.className = 'event-dot';
                                dot.style.backgroundColor = evento.color || coloresPorTipo[evento.type];
                                dot.title = evento.title;
                                dotsContainer.appendChild(dot);
                            });

                            celda.appendChild(dotsContainer);
                        }

                        if (soloLectura) {
                            celda.classList.add('solo-lectura');
                            if (eventosDia.length > 0) {
                                celda.style.cursor = 'pointer';
                                celda.addEventListener('click', () => {
                                    mostrarEventosSoloLectura(eventosDia, fechaStr);
                                });
                            }
                        } else {
                            celda.addEventListener('click', () => {
                                abrirModal(null, fechaStr, fechaStr);
                            });
                        }
                        }

                    fila.appendChild(celda);
                }

                tbody.appendChild(fila);

                if (diaActual > diasEnMes) break;
            }

            tabla.appendChild(tbody);
            calendarioMini.appendChild(tabla);
            tarjeta.appendChild(calendarioMini);

            return tarjeta;
        }

        function obtenerEventosPorFecha(fecha) {
            return eventos.filter(evento => {
                const inicio = new Date(evento.start);
                const fin = evento.end ? new Date(evento.end) : inicio;
                const fechaBuscada = new Date(fecha);

                inicio.setHours(0, 0, 0, 0);
                fin.setHours(0, 0, 0, 0);
                fechaBuscada.setHours(0, 0, 0, 0);

                if (evento.allDay && evento.end) {
                    fin.setDate(fin.getDate() - 1);
                }

                return fechaBuscada >= inicio && fechaBuscada <= fin;
            });
        }

        function mostrarEventosSoloLectura(eventosDia, fecha) {
            const detalles = document.getElementById('eventDetails');
            const form = document.getElementById('eventForm');
            const footer = document.getElementById('modalFooter');

            form.style.display = 'none';
            detalles.style.display = 'block';

            let html = `<h6 class="mb-3">Eventos del ${fecha}</h6>`;

            eventosDia.forEach(evento => {
                const tipo = evento.type || 'evento';
                const color = evento.color || coloresPorTipo[tipo];

                html += `
                    <div class="mb-3 p-3" style="border-left: 4px solid ${color}; background: #f8f9fa; border-radius: 4px;">
                        <h6 style="color: ${color}; margin-bottom: 8px;">
                            <i class="fas fa-calendar-day"></i> ${evento.title}
                        </h6>
                        <p class="mb-1 small">
                            <strong><i class="fas fa-tag"></i> Tipo:</strong> 
                            <span class="badge" style="background: ${color}; color: white;">
                                ${tipoTextoMap[tipo] || 'Evento'}
                            </span>
                        </p>
                        ${evento.description ? `
                            <p class="mb-0 small">
                                <strong><i class="fas fa-info-circle"></i> Descripción:</strong> 
                                ${evento.description}
                            </p>
                        ` : ''}
                    </div>
                `;
            });

            detalles.innerHTML = html;
            footer.innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';

            document.getElementById('modalTitle').textContent = 'Eventos del Día';
            modalEvento.show();
        }

        function abrirModal(evento = null, fechaInicio = null, fechaFin = null) {
            const detalles = document.getElementById('eventDetails');
            const form = document.getElementById('eventForm');
            const footer = document.getElementById('modalFooter');

            form.reset();
            document.getElementById('eventId').value = '';

            // Limpiar listeners previos
            const saveBtn = document.getElementById('saveBtn');
            const deleteBtn = document.getElementById('deleteBtn');
            
            if (saveBtn) {
                const newSaveBtn = saveBtn.cloneNode(true);
                saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);
            }
            
            if (deleteBtn) {
                const newDeleteBtn = deleteBtn.cloneNode(true);
                deleteBtn.parentNode.replaceChild(newDeleteBtn, deleteBtn);
            }

            if (soloLectura) {
                // ===== MODO SOLO LECTURA =====
                form.style.display = 'none';
                detalles.style.display = 'block';
                document.getElementById('modalTitle').textContent = 'Detalles del Evento';
                footer.innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';

                if (evento) {
                    const tipo = evento.extendedProps?.type || 'evento';
                    const start = evento.start.toLocaleDateString('es-ES');
                    const end = evento.end ? new Date(evento.end.setDate(evento.end.getDate() - 1)).toLocaleDateString('es-ES') : start;

                    detalles.innerHTML = `
                        <div style="border-left: 4px solid ${evento.backgroundColor}; padding-left: 15px; background: #f8f9fa; padding: 15px; border-radius: 4px;">
                            <h5 style="color: ${evento.backgroundColor}; margin-bottom: 15px;">
                                <i class="fas fa-calendar-check"></i> ${evento.title}
                            </h5>
                            <p class="mb-2">
                                <strong><i class="fas fa-tag"></i> Tipo:</strong> 
                                <span class="badge" style="background: ${evento.backgroundColor}; color: white;">
                                    ${tipoTextoMap[tipo]}
                                </span>
                            </p>
                            <p class="mb-2">
                                <strong><i class="fas fa-calendar-alt"></i> Fecha:</strong> 
                                ${start} ${end !== start ? ' → ' + end : ''}
                            </p>
                            ${evento.extendedProps?.description ? `
                                <p class="mb-0">
                                    <strong><i class="fas fa-info-circle"></i> Descripción:</strong><br>
                                    ${evento.extendedProps.description}
                                </p>
                            ` : ''}
                        </div>
                    `;
                } else {
                    detalles.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="fas fa-lock"></i> No se puede crear un evento en modo solo lectura.
                        </div>
                    `;
                }
            } else {
                // ===== MODO ADMINISTRADOR =====
                detalles.style.display = 'none';
                form.style.display = 'block';

                if (evento) {
                    // EDITAR EVENTO
                    document.getElementById('modalTitle').textContent = '✏️ Editar Evento';
                    document.getElementById('eventId').value = evento.id;
                    document.getElementById('title').value = evento.title;
                    document.getElementById('description').value = evento.extendedProps?.description || '';
                    document.getElementById('type').value = evento.extendedProps?.type || 'evento';

                    const start = evento.start.toISOString().split('T')[0];
                    let endDate = evento.end ? new Date(evento.end) : new Date(evento.start);
                    if (evento.end) endDate.setDate(endDate.getDate() - 1);
                    const end = endDate.toISOString().split('T')[0];
                    
                    document.getElementById('start_date').value = start;
                    document.getElementById('end_date').value = end;

                    footer.innerHTML = `
                        <button type="button" class="btn btn-danger" id="deleteBtn">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    `;
                    
                    document.getElementById('deleteBtn').addEventListener('click', eliminarEvento);
                    document.getElementById('saveBtn').addEventListener('click', guardarEvento);
                } else {
                    // CREAR EVENTO
                    document.getElementById('modalTitle').textContent = '➕ Nuevo Evento';
                    document.getElementById('start_date').value = fechaInicio;
                    document.getElementById('end_date').value = fechaFin;

                    footer.innerHTML = `
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    `;
                    
                    document.getElementById('saveBtn').addEventListener('click', guardarEvento);
                }
            }

            modalEvento.show();
        }

        // ===== FUNCIONES DE PERSISTENCIA =====

        async function guardarEvento() {
            const eventoId = document.getElementById('eventId').value;
            const titulo = document.getElementById('title').value.trim();
            const tipo = document.getElementById('type').value;
            const fechaInicio = document.getElementById('start_date').value;
            const fechaFin = document.getElementById('end_date').value;

            // Validación
            if (!titulo) {
                alert('⚠️ El título es obligatorio.');
                return;
            }

            if (!fechaInicio || !fechaFin) {
                alert('⚠️ Las fechas de inicio y fin son obligatorias.');
                return;
            }

            // FullCalendar espera fecha final exclusiva (día después)
            let fechaFinAjustada = new Date(fechaFin);
            fechaFinAjustada.setDate(fechaFinAjustada.getDate() + 1);
            
            const datos = {
                titulo: titulo,
                descripcion: document.getElementById('description').value.trim(),
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFinAjustada.toISOString().split('T')[0],
                tipo: tipo,
                color: coloresPorTipo[tipo],
                todo_el_dia: true
            };

            const url = eventoId ? `${API_BASE}/${eventoId}` : API_BASE;
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
                    await cargarEventos();
                    renderizarVistaAño();
                    updateCalendar();
                    
                    // Notificación de éxito
                    mostrarNotificacion('✅ Evento guardado exitosamente', 'success');
                } else {
                    const error = await respuesta.json();
                    console.error('Error del servidor:', error);
                    alert('❌ Error al guardar el evento. Verifique los datos e intente nuevamente.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Error de conexión al guardar el evento.');
            }
        }

        async function eliminarEvento() {
            const eventoId = document.getElementById('eventId').value;

            if (!confirm('⚠️ ¿Está seguro de eliminar este evento?\n\nEsta acción no se puede deshacer.')) {
                return;
            }

            try {
                const respuesta = await fetch(`${API_BASE}/${eventoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (respuesta.ok) {
                    modalEvento.hide();
                    await cargarEventos();
                    renderizarVistaAño();
                    updateCalendar();
                    
                    mostrarNotificacion('🗑️ Evento eliminado exitosamente', 'danger');
                } else {
                    alert('❌ Error al eliminar el evento.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Error de conexión al eliminar el evento.');
            }
        }

        async function actualizarFechasEvento(evento) {
            const tipo = evento.extendedProps?.type || 'evento';
            
            const datos = {
                titulo: evento.title,
                descripcion: evento.extendedProps?.description || '',
                fecha_inicio: evento.startStr,
                fecha_fin: evento.endStr || evento.startStr,
                tipo: tipo,
                color: evento.backgroundColor,
                todo_el_dia: true
            };

            try {
                const respuesta = await fetch(`${API_BASE}/${evento.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(datos)
                });

                if (respuesta.ok) {
                    await cargarEventos();
                    renderizarVistaAño();
                    updateCalendar();
                    
                    mostrarNotificacion('📅 Fechas actualizadas', 'info');
                } else {
                    evento.revert();
                    alert('❌ Error al actualizar las fechas del evento.');
                }
            } catch (error) {
                console.error('Error al actualizar fechas:', error);
                evento.revert();
                alert('❌ Error de conexión al actualizar fechas.');
            }
        }

        // ===== FUNCIÓN DE NOTIFICACIONES =====
        function mostrarNotificacion(mensaje, tipo = 'success') {
            const colores = {
                success: '#28a745',
                danger: '#dc3545',
                info: '#17a2b8',
                warning: '#ffc107'
            };

            const notificacion = document.createElement('div');
            notificacion.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${colores[tipo]};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                font-weight: 600;
                animation: slideIn 0.3s ease;
            `;
            notificacion.textContent = mensaje;
            
            document.body.appendChild(notificacion);
            
            setTimeout(() => {
                notificacion.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notificacion.remove(), 300);
            }, 3000);
        }

        // Estilos para animaciones de notificaciones
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>