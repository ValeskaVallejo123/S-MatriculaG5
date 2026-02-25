<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Académico - Gabriela Mistral</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <!-- FullCalendar (v6 global incluye CSS automáticamente) -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js"></script>

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

        .calendar-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin: 40px auto;
            max-width: 1200px;
        }

        .calendar-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #003b73;
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
        }

        .btn-volver:hover {
            background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
            color: white;
        }
    </style>
</head>

<body>

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

        <div class="calendar-header text-center mb-4">
            <h1>📅 Calendario Académico 2025</h1>
            <p>Consulta fechas importantes, eventos y períodos académicos</p>
        </div>

        <div class="text-center mb-4">
            <a href="{{ url('/') }}" class="btn-volver">
                <i class="fas fa-arrow-left"></i>
                Volver al Inicio
            </a>
        </div>

        <div id="calendar"></div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
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

        events: '/calendario/eventos/public',

        editable: false,
        selectable: false,
        dayMaxEvents: true,

        eventClick: function(info) {
            alert(
                'Evento: ' + info.event.title + '\n' +
                'Tipo: ' + (info.event.extendedProps.type || 'N/A') + '\n' +
                'Fecha: ' + info.event.start.toLocaleDateString('es-ES') + '\n' +
                (info.event.extendedProps.description 
                    ? 'Descripción: ' + info.event.extendedProps.description 
                    : '')
            );
        },

        eventMouseEnter: function(info) {
            info.el.title = info.event.title +
                (info.event.extendedProps.description 
                    ? '\n' + info.event.extendedProps.description 
                    : '');
        }

    });

    calendar.render();
});
</script>

</body>
</html>