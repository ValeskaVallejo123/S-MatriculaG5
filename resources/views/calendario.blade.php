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
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="calendar-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">📅 Calendario Académico</h1>
                <a href="{{ ($soloLectura ?? false) ? route('plantilla') : route('app') }}" class="btn btn-secondary">Volver</a>
            </div>

            @if($soloLectura ?? false)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Este calendario es de **solo lectura**.
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

    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detalles del Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="eventDetails">
                        </div>
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
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        const soloLectura = {{ $soloLectura ?? 'false' ? 'true' : 'false' }};

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

            // Event listeners de Guardar y Eliminar (Solo si no es solo lectura)
            if (!soloLectura) {
                // Se agregan listeners al cargar la página para evitar múltiples asignaciones
                // al abrir el modal, aunque los botones se añadan y quiten del DOM.
                // Es un enfoque menos voluminoso que añadir/quitar en cada 'abrirModal'.
                // La lógica dentro de `abrirModal` asegura que solo se llamen si los botones existen.
            }
            
            // Cargar y Renderizar
            await cargarEventos();
            renderizarVistaAño();
            inicializarFullCalendar();
        });

        // --- Funciones de Fetch/API ---

        async function cargarEventos() {
            try {
                const respuesta = await fetch('/calendario/eventos');
                eventos = await respuesta.json();
            } catch (error) {
                console.error('Error al cargar eventos:', error);
                eventos = [];
            }
        }

        // Se usa `updateCalendar` en lugar de `refetchEvents` en las funciones
        function updateCalendar() {
            if (calendario) {
                calendario.refetchEvents();
            }
        }

        // ... (el resto de las funciones: inicializarFullCalendar, cambiarVista, renderizarVistaAño, crearTarjetaMes, obtenerEventosPorFecha, mostrarEventosSoloLectura) ...
        
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
                events: eventos,
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

                // Normaliza fechas para comparación de día completo (si no tienen hora)
                inicio.setHours(0, 0, 0, 0);
                fin.setHours(0, 0, 0, 0);
                fechaBuscada.setHours(0, 0, 0, 0);

                // En FullCalendar, los eventos de día completo la fecha final es el día después del evento,
                // por lo que se ajusta la fecha final para abarcar el día completo de FullCalendar.
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
                    <div class="mb-3 p-3" style="border-left: 4px solid ${color}; background: #f8f9fa;">
                        <h6 style="color: ${color};">${evento.title}</h6>
                        <p class="mb-1"><strong>Tipo:</strong> ${tipoTextoMap[tipo] || 'Evento'}</p>
                        ${evento.description ? `<p class="mb-0"><strong>Descripción:</strong> ${evento.description}</p>` : ''}
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

            // Resetear el formulario para nuevos eventos o edición
            form.reset();
            document.getElementById('eventId').value = '';

            // Limpiar listeners antiguos antes de establecer el HTML del footer
            if (document.getElementById('saveBtn')) {
                 document.getElementById('saveBtn').removeEventListener('click', guardarEvento);
            }
            if (document.getElementById('deleteBtn')) {
                 document.getElementById('deleteBtn').removeEventListener('click', eliminarEvento);
            }

            if (soloLectura) {
                // MODO SOLO LECTURA
                form.style.display = 'none';
                detalles.style.display = 'block';
                document.getElementById('modalTitle').textContent = 'Detalles del Evento';
                footer.innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';

                if (evento) {
                    const tipo = evento.extendedProps?.type || 'evento';
                    const start = evento.start.toLocaleDateString('es-ES');
                    // FullCalendar tiene el día final excluyente, se ajusta para mostrar el rango correcto.
                    const end = evento.end ? new Date(evento.end.setDate(evento.end.getDate() - 1)).toLocaleDateString('es-ES') : start;

                    detalles.innerHTML = `
                        <div style="border-left: 4px solid ${evento.backgroundColor}; padding-left: 15px;">
                            <h5 style="color: ${evento.backgroundColor};">${evento.title}</h5>
                            <p><strong>Tipo:</strong> ${tipoTextoMap[tipo]}</p>
                            <p><strong>Fecha:</strong> ${start} ${end !== start ? ' - ' + end : ''}</p>
                            ${evento.extendedProps?.description ? `<p><strong>Descripción:</strong> ${evento.extendedProps.description}</p>` : ''}
                        </div>
                    `;
                } else {
                    detalles.innerHTML = 'No se puede crear un evento en modo solo lectura.';
                }
            } else {
                // MODO ADMINISTRADOR (EDICIÓN/CREACIÓN)
                detalles.style.display = 'none';
                form.style.display = 'block';

                if (evento) {
                    document.getElementById('modalTitle').textContent = 'Editar Evento';
                    document.getElementById('eventId').value = evento.id;
                    document.getElementById('title').value = evento.title;
                    document.getElementById('description').value = evento.extendedProps?.description || '';
                    document.getElementById('type').value = evento.extendedProps?.type || 'evento';

                    const start = evento.start.toISOString().split('T')[0];
                    // Para FullCalendar, el final de un evento 'allDay' es un día después del final real
                    let endDate = evento.end ? new Date(evento.end) : new Date(evento.start);
                    if (evento.end) endDate.setDate(endDate.getDate() - 1); // Ajuste
                    const end = endDate.toISOString().split('T')[0];
                    
                    document.getElementById('start_date').value = start;
                    document.getElementById('end_date').value = end;

                    footer.innerHTML = `
                        <button type="button" class="btn btn-danger" id="deleteBtn">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">Guardar</button>
                    `;
                    document.getElementById('deleteBtn').addEventListener('click', eliminarEvento);
                } else {
                    document.getElementById('modalTitle').textContent = 'Nuevo Evento';
                    document.getElementById('start_date').value = fechaInicio;
                    document.getElementById('end_date').value = fechaFin;

                    footer.innerHTML = `
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">Guardar</button>
                    `;
                }
                
                // El listener de guardar se añade siempre en modo admin
                document.getElementById('saveBtn').addEventListener('click', guardarEvento);
            }

            modalEvento.show();
        }

        // --- Funciones de Persistencia ---

        async function guardarEvento() {
            const eventoId = document.getElementById('eventId').value;
            const titulo = document.getElementById('title').value;
            const tipo = document.getElementById('type').value;

            // Validación simple
            if (!titulo || !document.getElementById('start_date').value || !document.getElementById('end_date').value) {
                alert('El título y las fechas de inicio/fin son obligatorios.');
                return;
            }

            // FullCalendar espera que la fecha final sea EXCLUSIVA (el día después del último día)
            let fechaFin = new Date(document.getElementById('end_date').value);
            fechaFin.setDate(fechaFin.getDate() + 1); // Añade un día
            
            const datos = {
                titulo: titulo,
                descripcion: document.getElementById('description').value,
                fecha_inicio: document.getElementById('start_date').value,
                // Se envía la fecha ajustada (un día después) para FullCalendar
                fecha_fin: fechaFin.toISOString().split('T')[0], 
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
                    await cargarEventos();
                    renderizarVistaAño();
                    updateCalendar();
                } else {
                    alert('Error al guardar el evento. Revise la consola para más detalles.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al guardar el evento.');
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
                    await cargarEventos();
                    renderizarVistaAño();
                    updateCalendar();
                } else {
                    alert('Error al eliminar el evento. Revise la consola para más detalles.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al eliminar el evento.');
            }
        }

        async function actualizarFechasEvento(evento) {
            const tipo = evento.extendedProps?.type || 'evento';
            
            // FullCalendar ajusta la fecha final automáticamente, aquí solo se prepara el payload
            const datos = {
                titulo: evento.title,
                descripcion: evento.extendedProps?.description || '',
                fecha_inicio: evento.startStr,
                // FullCalendar endStr ya está ajustado (es el día siguiente, lo que se espera en el backend para allDay)
                fecha_fin: evento.endStr || evento.startStr, 
                tipo: tipo,
                color: evento.backgroundColor,
                todo_el_dia: true
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

                await cargarEventos();
                renderizarVistaAño();
                updateCalendar();
            } catch (error) {
                console.error('Error al actualizar fechas del evento:', error);
                evento.revert(); // Revierte el cambio visual si el fetch falla
                alert('Error al actualizar fechas del evento.');
            }
        }
    </script>
</body>
</html>