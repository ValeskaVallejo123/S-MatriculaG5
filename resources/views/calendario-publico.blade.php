<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Académico - Gabriela Mistral</title>
    
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #4ec7d2 100%);
            padding: 18px 0;
            box-shadow: 0 4px 20px rgba(0, 59, 115, 0.3);
        }

        .navbar-custom .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .navbar-custom .navbar-brand i {
            font-size: 2rem;
            color: #4ec7d2;
        }

        .calendar-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin: 40px auto;
            max-width: 1200px;
        }

        .calendar-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .calendar-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #003b73;
            margin-bottom: 10px;
        }

        .calendar-header p {
            font-size: 1.1rem;
            color: #00508f;
        }

        .legend {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, rgba(78, 199, 210, 0.05), rgba(191, 217, 234, 0.08));
            border-radius: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: white;
            border-radius: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .legend-item:hover {
            transform: translateY(-2px);
        }

        .legend-color {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .legend-item span {
            font-weight: 600;
            color: #003b73;
            font-size: 0.9rem;
        }

        .btn-volver {
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(78, 199, 210, 0.3);
        }

        .btn-volver:hover {
            background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(78, 199, 210, 0.4);
            color: white;
        }

        /* Estilos del calendario */
        .fc {
            border-radius: 10px;
            overflow: hidden;
        }

        .fc-toolbar-title {
            font-size: 1.8rem !important;
            font-weight: 700 !important;
            color: #003b73 !important;
        }

        .fc-button {
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%) !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        .fc-button:hover {
            background: linear-gradient(135deg, #00508f 0%, #003b73 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 80, 143, 0.3) !important;
        }

        .fc-event {
            cursor: default !important;
            border: none !important;
            padding: 4px 8px !important;
            border-radius: 5px !important;
            font-weight: 500 !important;
        }

        /* Tooltip personalizado */
        .fc-event:hover {
            opacity: 0.9;
        }

        .info-banner {
            background: linear-gradient(135deg, rgba(78, 199, 210, 0.1), rgba(191, 217, 234, 0.15));
            border-left: 4px solid #4ec7d2;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .info-banner i {
            font-size: 1.5rem;
            color: #00508f;
        }

        .info-banner p {
            margin: 0;
            color: #003b73;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap"></i>
                Escuela Gabriela Mistral
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="calendar-container">
            
            <!-- Header -->
            <div class="calendar-header">
                <h1>📅 Calendario Académico 2025</h1>
                <p>Consulta fechas importantes, eventos y períodos académicos</p>
            </div>

            <!-- Botón volver -->
            <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="btn-volver">
                    <i class="fas fa-arrow-left"></i>
                    Volver al Inicio
                </a>
            </div>

            <!-- Banner informativo -->
            <div class="info-banner">
                <i class="fas fa-info-circle"></i>
                <p>Este calendario es de solo consulta. Para más información contacta a la administración.</p>
            </div>
            
            <!-- Leyenda -->
            <div class="legend">
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

            <!-- Calendario -->
            <div id='calendar'></div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const elementoCalendario = document.getElementById('calendar');

            const calendario = new FullCalendar.Calendar(elementoCalendario, {
                locale: 'es',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    list: 'Lista'
                },
            events: '/calendario/eventos/public', // Cambiar esta línea                
                // DESHABILITAR TODAS LAS INTERACCIONES
                editable: false,           // No se puede arrastrar
                selectable: false,         // No se puede seleccionar
                selectMirror: false,
                dayMaxEvents: true,
                
                // Deshabilitar click en eventos
                eventClick: function(info) {
                    // Mostrar solo información en tooltip
                    alert(
                        'Evento: ' + info.event.title + '\n' +
                        'Tipo: ' + (info.event.extendedProps.type || 'N/A') + '\n' +
                        'Fecha: ' + info.event.start.toLocaleDateString('es-ES') + '\n' +
                        (info.event.extendedProps.description ? 'Descripción: ' + info.event.extendedProps.description : '')
                    );
                    return false; // Prevenir comportamiento por defecto
                },
                
                // Deshabilitar selección de fechas
                select: function(info) {
                    return false;
                },

                // Opcional: Mostrar tooltip al pasar el mouse
                eventMouseEnter: function(info) {
                    info.el.title = info.event.title + 
                        (info.event.extendedProps.description ? '\n' + info.event.extendedProps.description : '');
                }
            });

            calendario.render();
        });
    </script>
</body>
</html>