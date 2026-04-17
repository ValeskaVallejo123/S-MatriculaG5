<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Académico — Escuela Gabriela Mistral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            display: flex; flex-direction: column;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #4ec7d2 100%);
            padding: 14px 0;
            box-shadow: 0 4px 20px rgba(0,59,115,0.3);
            position: fixed; width: 100%; top: 0; z-index: 1000;
        }
        .navbar-custom .navbar-brand {
            display: flex; align-items: center; gap: 10px;
            color: white; font-weight: 700; font-size: 1.25rem; text-decoration: none;
        }
        .navbar-custom .navbar-brand i { font-size: 1.6rem; color: #4ec7d2; }
        .navbar-custom .nav-link {
            color: white !important; font-weight: 500; margin: 0 8px;
            transition: all 0.3s ease; position: relative; font-size: 0.9rem;
        }
        .navbar-custom .nav-link:hover { color: #4ec7d2 !important; }
        .navbar-custom .nav-link.active-nav { color: #4ec7d2 !important; font-weight: 600; }
        .navbar-custom .nav-link::after {
            content: ''; position: absolute; bottom: -5px; left: 0;
            width: 0; height: 2px; background: #4ec7d2; transition: width 0.3s ease;
        }
        .navbar-custom .nav-link:hover::after,
        .navbar-custom .nav-link.active-nav::after { width: 100%; }
        .btn-login {
            background: rgba(78,199,210,0.2); color: white !important;
            padding: 7px 20px; border-radius: 25px; border: 2px solid #4ec7d2;
            font-weight: 600; transition: all 0.3s ease; text-decoration: none;
            display: inline-flex; align-items: center; gap: 7px; font-size: 0.88rem;
        }
        .btn-login:hover { background: #4ec7d2; color: #003b73 !important; }

        .btn-volver {
            background: white; color: #00508f;
            border: 1.5px solid #00508f;
            padding: 0.4rem 0.85rem; border-radius: 8px;
            font-size: 0.82rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 0.4rem;
            text-decoration: none; transition: all 0.2s ease; flex-shrink: 0;
        }
        .btn-volver:hover { background: #00508f; color: white; transform: translateY(-1px); }

        /* ===== WRAPPER PRINCIPAL ===== */
        .page-wrapper {
            margin-top: 62px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .content-area {
            flex: 1;
            padding: 1.5rem 2rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* ===== HEADER CARD (título + leyenda + volver) ===== */
        .header-card {
            background: white;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .header-card-top {
            padding: 1rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            gap: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .header-card-title {
            display: flex; align-items: center; gap: 0.6rem;
        }
        .header-card-title i { color: #4ec7d2; font-size: 1.05rem; }
        .header-card-title h5 {
            margin: 0; font-size: 0.95rem; font-weight: 700; color: #003b73;
        }
        .header-card-title small {
            font-size: 0.75rem; color: #94a3b8; display: block; margin-top: 1px;
        }
        .legend-row {
            padding: 0.85rem 1.5rem;
            display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;
        }
        .legend-label {
            font-size: 0.72rem; font-weight: 700; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 0.05em; flex-shrink: 0;
        }
        .legend-items {
            display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;
        }
        .legend-item {
            display: flex; align-items: center; gap: 0.4rem;
            font-size: 0.78rem; color: #475569; font-weight: 500;
        }
        .legend-dot {
            width: 11px; height: 11px; border-radius: 3px; flex-shrink: 0;
        }

        /* ===== TARJETA CALENDARIO ===== */
        .cal-card {
            background: white;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(0,0,0,0.04);
            overflow: hidden;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 580px;
        }
        .cal-card-head {
            background: linear-gradient(135deg, #003b73 0%, #00508f 70%, #4ec7d2 100%);
            padding: 1rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .cal-card-head::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(78,199,210,0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(78,199,210,0.08) 1px, transparent 1px);
            background-size: 30px 30px;
            pointer-events: none;
        }
        .cal-head-left {
            display: flex; align-items: center; gap: 0.75rem;
            position: relative; z-index: 1;
        }
        .cal-head-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .cal-head-icon i { color: #4ec7d2; font-size: 1.1rem; }
        .cal-head-left h5 { color: white; font-weight: 700; font-size: 1rem; margin: 0; }
        .cal-head-left small { color: rgba(255,255,255,0.7); font-size: 0.75rem; display: block; }
        .cal-head-badge {
            background: rgba(78,199,210,0.2);
            border: 1px solid rgba(78,199,210,0.4);
            color: #4ec7d2;
            padding: 4px 14px; border-radius: 20px;
            font-size: 0.78rem; font-weight: 600;
            position: relative; z-index: 1;
        }

        /* ===== FULLCALENDAR ===== */
        #calendar {
            --fc-border-color: #f1f5f9;
            --fc-today-bg-color: rgba(78,199,210,0.07);
            font-family: 'Inter', sans-serif;
            font-size: 0.82rem;
            padding: 1.25rem;
            flex: 1;
        }
        .fc .fc-toolbar-title { font-size: 1rem; font-weight: 700; color: #0f172a; }
        .fc .fc-button {
            background: white; border: 1.5px solid #e2e8f0; color: #00508f;
            font-size: 0.78rem; font-weight: 600; padding: 0.32rem 0.7rem;
            border-radius: 7px; box-shadow: none; transition: all 0.15s;
        }
        .fc .fc-button:hover { background: #e8f8f9; border-color: #4ec7d2; }
        .fc .fc-button-active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: linear-gradient(135deg, #4ec7d2, #00508f) !important;
            border-color: transparent !important; color: white !important;
        }
        .fc .fc-button-primary:focus { box-shadow: none !important; }
        .fc .fc-col-header-cell { background: #f8fafc; }
        .fc .fc-col-header-cell-cushion {
            font-size: 0.72rem; font-weight: 700; letter-spacing: 0.06em;
            text-transform: uppercase; color: #64748b; padding: 0.5rem;
        }
        .fc .fc-daygrid-day-number { font-size: 0.8rem; font-weight: 600; color: #334155; padding: 0.4rem; }
        .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number { color: #00508f; font-weight: 700; }
        .fc .fc-event { border-radius: 5px; font-size: 0.72rem; font-weight: 600; padding: 2px 5px; border: none; cursor: default; }
        .fc .fc-toolbar { flex-wrap: wrap; gap: 0.5rem; }
        .fc .fc-toolbar-chunk { display: flex; align-items: center; gap: 0.3rem; }

        /* ===== FOOTER ===== */
        .cal-footer {
            text-align: center;
            padding: 0.65rem 1.25rem;
            color: #94a3b8; font-size: 0.72rem;
            border-top: 1px solid #f1f5f9;
            background: #fafbfc;
            flex-shrink: 0;
        }
        .page-footer {
            background: #003b73; color: rgba(255,255,255,0.6);
            text-align: center; padding: 1rem;
            font-size: 0.8rem; flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .content-area { padding: 1rem; }
            .inner-topbar { padding: 0 1rem; }
            .breadcrumb-inline { display: none; }
            .legend-items { gap: 0.6rem; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('inicio') }}">
            <i class="fas fa-graduation-cap"></i>
            Escuela Gabriela Mistral
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="background-color: rgba(78,199,210,0.3); border: none;">
            <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('inicio') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portal.plan-estudios.index') }}">Plan de Estudios</a></li>
                <li class="nav-item"><a class="nav-link active-nav" href="{{ route('calendario.publico') }}">Calendario</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('matriculas.public.create') }}">Matrícula</a></li>
                <li class="nav-item ms-3">
                    <a class="btn-login" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Acceso Sistema
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="page-wrapper">

    <div class="content-area">

        {{-- HEADER + LEYENDA --}}
        <div class="header-card">
            <div class="header-card-top">
                <div class="header-card-title">
                    <i class="fas fa-calendar-alt"></i>
                    <div>
                        <h5>Calendario Académico</h5>
                        <small>Año lectivo {{ date('Y') }} · Solo lectura</small>
                    </div>
                </div>
                <a href="{{ route('inicio') }}" class="btn-volver">
                    <i class="fas fa-arrow-left"></i> Volver al inicio
                </a>
            </div>
            <div class="legend-row">
                <span class="legend-label">Tipos de eventos</span>
                <div class="legend-items">
                    <div class="legend-item"><div class="legend-dot" style="background:#3788d8"></div> Clase</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#dc3545"></div> Examen</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#28a745"></div> Festivo</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#ffc107"></div> Evento</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#17a2b8"></div> Vacaciones</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#9c27b0"></div> Prematrícula</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#ff5722"></div> Matrícula</div>
                </div>
            </div>
        </div>

        {{-- CALENDARIO --}}
        <div class="cal-card">
            <div class="cal-card-head">
                <div class="cal-head-left">
                    <div class="cal-head-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h5>Eventos del año {{ date('Y') }}</h5>
                        <small>Navega entre meses o usa la vista de lista</small>
                    </div>
                </div>
                <span class="cal-head-badge">
                    <i class="fas fa-eye me-1"></i> Solo lectura
                </span>
            </div>

            <div id="calendar"></div>

            <div class="cal-footer">
                © {{ date('Y') }} Escuela Gabriela Mistral — Calendario de solo lectura
            </div>
        </div>

    </div>

    <footer class="page-footer">
        <p>© {{ date('Y') }} Escuela Gabriela Mistral. Todos los derechos reservados.</p>
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        initialView:  'dayGridMonth',
        locale:       'es',
        height:       '100%',
        expandRows:   true,
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,listMonth',
        },
        buttonText: {
            today:     'Hoy',
            month:     'Mes',
            listMonth: 'Lista',
        },
        events: '{{ route("calendario.eventos.public") }}',
        eventClick: function () { /* solo lectura */ },
        eventDidMount: function (info) {
            const tipo = (info.event.extendedProps.tipo || '').toLowerCase();
            if (COLORES[tipo]) info.el.style.backgroundColor = COLORES[tipo];
        },
        eventDisplay: 'block',
    });

    calendar.render();
});
</script>
</body>
</html>
