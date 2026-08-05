<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Académico — Escuela Gabriela Mistral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* Encabezado público */
        .pub-header {
            background: linear-gradient(135deg, #002d5a, #00508f, #0077b6);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .75rem;
        }
        .pub-header-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: #fff;
        }
        .pub-header-brand i { font-size: 1.4rem; color: #4ec7d2; }
        .pub-header-brand span { font-size: 1rem; font-weight: 700; }
        .pub-header-brand small { font-size: .75rem; opacity: .75; display: block; line-height: 1.2; }
        .pub-header-back {
            background: rgba(255,255,255,.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 8px;
            padding: .4rem .9rem;
            text-decoration: none;
            font-size: .82rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: background .15s;
        }
        .pub-header-back:hover { background: rgba(255,255,255,.25); color: #fff; }

        /* Layout pantalla completa */
        html, body { height: 100%; }
        body { display: flex; flex-direction: column; }

        /* Contenido */
        .pub-wrap { flex: 1; width: 100%; padding: 1.25rem 1.5rem; display: flex; flex-direction: column; }

        /* Stats */
        .pub-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        @media(max-width: 768px) { .pub-stats { grid-template-columns: repeat(2, 1fr); } }
        @media(max-width: 480px) { .pub-stats { grid-template-columns: 1fr 1fr; gap: .75rem; } }

        .pub-stat {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.1rem;
            display: flex;
            align-items: center;
            gap: .85rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        .pub-stat-icon {
            width: 42px; height: 42px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .pub-stat-icon i { font-size: 1rem; color: #fff; }
        .pub-stat-lbl { font-size: .7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .1rem; }
        .pub-stat-num { font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1; }

        /* Tarjeta calendario — ocupa todo el espacio restante */
        .pub-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .pub-card-head {
            background: #003b73;
            padding: .9rem 1.25rem;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .pub-card-head i { color: #4ec7d2; }
        .pub-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }

        /* Leyenda */
        .legend-wrap {
            display: flex; gap: .65rem; flex-wrap: wrap;
            padding: .85rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            background: #fafbfc;
        }
        .legend-item { display: flex; align-items: center; gap: .4rem; font-size: .75rem; color: #334155; font-weight: 500; }
        .legend-dot { width: 11px; height: 11px; border-radius: 3px; flex-shrink: 0; }

        /* FullCalendar — se expande al espacio disponible */
        #calendar {
            --fc-border-color: #f1f5f9;
            --fc-today-bg-color: rgba(78,199,210,.07);
            font-family: 'Inter', sans-serif;
            font-size: .82rem;
            padding: 1.25rem;
            flex: 1;
        }
        .fc .fc-toolbar-title { font-size: 1rem; font-weight: 700; color: #0f172a; }
        .fc .fc-button {
            background: #fff; border: 1.5px solid #e2e8f0; color: #00508f;
            font-size: .78rem; font-weight: 600; padding: .32rem .7rem;
            border-radius: 7px; box-shadow: none; transition: all .15s;
        }
        .fc .fc-button:hover { background: #e8f8f9; border-color: #4ec7d2; }
        .fc .fc-button-active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: linear-gradient(135deg,#4ec7d2,#00508f) !important;
            border-color: transparent !important; color: #fff !important;
        }
        .fc .fc-button-primary:focus { box-shadow: none !important; }
        .fc .fc-col-header-cell { background: #f8fafc; }
        .fc .fc-col-header-cell-cushion {
            font-size: .72rem; font-weight: 700; letter-spacing: .06em;
            text-transform: uppercase; color: #64748b; padding: .5rem;
        }
        .fc .fc-daygrid-day-number { font-size: .8rem; font-weight: 600; color: #334155; padding: .4rem; }
        .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number { color: #00508f; font-weight: 700; }
        .fc .fc-event { border-radius: 5px; font-size: .72rem; font-weight: 600; padding: 2px 5px; border: none; cursor: default; }
        .fc .fc-toolbar { flex-wrap: wrap; gap: .5rem; }
        .fc .fc-toolbar-chunk { display: flex; align-items: center; gap: .3rem; }

        /* Pie de página — dentro de la tarjeta del calendario */
        .pub-footer {
            text-align: center;
            padding: .6rem 1.25rem;
            color: #94a3b8;
            font-size: .72rem;
            border-top: 1px solid #f1f5f9;
            background: #fafbfc;
        }
    </style>
</head>
<body>

    {{-- Encabezado --}}
    <div class="pub-header">
        <div class="pub-header-brand">
            <i class="fas fa-school"></i>
            <div>
                <span>Escuela Gabriela Mistral</span>
                <small>Calendario Académico Público</small>
            </div>
        </div>
        <a href="{{ route('inicio') }}" class="pub-header-back">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>
    </div>

    <div class="pub-wrap">

        {{-- Estadísticas --}}
        <div class="pub-stats">
            <div class="pub-stat">
                <div class="pub-stat-icon" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);">
                    <i class="fas fa-chalkboard"></i>
                </div>
                <div>
                    <div class="pub-stat-lbl">Clases</div>
                    <div class="pub-stat-num" id="count-clase">—</div>
                </div>
            </div>
            <div class="pub-stat">
                <div class="pub-stat-icon" style="background:linear-gradient(135deg,#f87171,#dc2626);">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <div class="pub-stat-lbl">Exámenes</div>
                    <div class="pub-stat-num" id="count-examen">—</div>
                </div>
            </div>
            <div class="pub-stat">
                <div class="pub-stat-icon" style="background:linear-gradient(135deg,#9c27b0,#7b1fa2);">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <div class="pub-stat-lbl">Matrículas</div>
                    <div class="pub-stat-num" id="count-matricula">—</div>
                </div>
            </div>
            <div class="pub-stat">
                <div class="pub-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <div class="pub-stat-lbl">Festivos</div>
                    <div class="pub-stat-num" id="count-festivo">—</div>
                </div>
            </div>
        </div>

        {{-- Calendario --}}
        <div class="pub-card">
            <div class="pub-card-head">
                <i class="fas fa-calendar-alt"></i>
                <span>Calendario Académico</span>
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

            <div id="calendar"></div>

            <div class="pub-footer">
                © {{ date('Y') }} Escuela Gabriela Mistral &mdash; Calendario de solo lectura
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const COLORES = {
            clase:        '#3788d8',
            examen:       '#dc3545',
            festivo:      '#28a745',
            evento:       '#ffc107',
            vacaciones:   '#17a2b8',
            prematricula: '#9c27b0',
            matricula:    '#ff5722',
        };

        const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView:     'dayGridMonth',
            locale:          'es',
            height:          '100%',
            expandRows:      true,
            headerToolbar: {
                left:   'prev,next today',
                center: 'title',
                right:  'dayGridMonth,listMonth',
            },
            buttonText: {
                today:      'Hoy',
                month:      'Mes',
                listMonth:  'Lista',
            },
            events: '{{ route("calendario.eventos.public") }}',
            eventClick: function () { /* solo lectura — sin acción */ },
            eventDidMount: function (info) {
                // Asignar color según tipo
                const tipo = (info.event.extendedProps.tipo || '').toLowerCase();
                if (COLORES[tipo]) {
                    info.el.style.backgroundColor = COLORES[tipo];
                }
            },
            eventDisplay: 'block',
            eventsSet: function (events) {
                // Actualizar contadores
                const contadores = { clase: 0, examen: 0, matricula: 0, festivo: 0 };
                events.forEach(function (ev) {
                    const t = (ev.extendedProps.tipo || '').toLowerCase();
                    if (contadores[t] !== undefined) contadores[t]++;
                });
                document.getElementById('count-clase').textContent    = contadores.clase    || '0';
                document.getElementById('count-examen').textContent   = contadores.examen   || '0';
                document.getElementById('count-matricula').textContent = contadores.matricula || '0';
                document.getElementById('count-festivo').textContent  = contadores.festivo  || '0';
            },
        });

        calendar.render();
    });
    </script>
</body>
</html>
