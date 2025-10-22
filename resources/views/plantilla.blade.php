<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistema de Matrícula - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Estilos del sistema de matrícula original */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
        }

        /* ======= SECCIÓN HERO ======= */
        .hero {
            /* Usamos una imagen de placeholder para garantizar que el archivo compile sin un servidor local */
            background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
                url('https://placehold.co/1200x400/3f51b5/ffffff?text=ESCUELA+GABRIELA+MISTRAL') center/cover no-repeat;
            color: white;
            padding: 80px 0 60px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
        }

        .hero span {
            color: #ffd700;
            font-family: 'Pacifico', cursive;
            font-size: 2rem;
        }

        .hero p {
            max-width: 600px;
            margin-top: 10px;
        }

        .btn-yellow {
            background-color: #ffb703;
            border: none;
            color: #fff;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-yellow:hover {
            background-color: #f4a100;
            color: white;
            transform: translateY(-2px);
        }

        .stats {
            margin-top: -40px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Contenedor del Calendario: Púrpura */
        .calendar-container {
            background-color: #673ab7;
            color: white;
            border-radius: 10px;
            padding: 25px;
            margin-top: 40px;
            box-shadow: 0 5px 15px rgba(103, 58, 183, 0.5);
        }

        /* Diseño de la lista de fechas dentro del calendario */
        #schedule-list {
            margin-top: 20px;
            padding: 10px 0;
            border-top: 1px dashed rgba(255, 255, 255, 0.4);
        }

        .schedule-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .schedule-item:last-child {
            border-bottom: none;
        }

        .schedule-grade {
            font-weight: 600;
            color: #ffd700;
            /* Amarillo */
        }

        .schedule-dates {
            font-size: 0.95rem;
        }

        .btn-calendar {
            background-color: #9575cd;
            color: white;
            border: none;
            transition: 0.3s;
        }

        .btn-calendar:hover {
            background-color: #7e57c2;
        }

        /* ======= PROCESO DE MATRÍCULA (Se mantiene igual) ======= */
        .process {
            background-color: #fff;
            padding: 70px 0;
        }

        .process h2 {
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
        }

        .process p {
            text-align: center;
            margin-bottom: 40px;
            color: #666;
        }

        .process-step {
            text-align: center;
        }

        .step-number {
            width: 45px;
            height: 45px;
            line-height: 45px;
            background-color: #e3e2ff;
            color: #3f51b5;
            border-radius: 50%;
            font-weight: 600;
            margin: 0 auto 10px;
        }

        .process-step h5 {
            font-weight: 600;
        }

        /* Estilos para la nueva vista de Cronograma (adaptada a Bootstrap/Tema claro) */
        #cronograma-view {
            display: none;
            /* Inicialmente oculto */
            padding: 40px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        .cronograma-title {
            color: #3f51b5;
            font-weight: 700;
        }

        .form-label-cronograma {
            font-weight: 600;
            color: #673ab7;
        }

        .form-control-cronograma {
            border-color: #9575cd;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control-cronograma:focus {
            border-color: #673ab7;
            box-shadow: 0 0 0 0.25rem rgba(103, 58, 183, 0.25);
        }

        .btn-save-cronograma {
            background-color: #3f51b5;
            border: none;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-save-cronograma:hover {
            background-color: #303f9f;
            color: white;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

    <div id="main-view">

        <section class="hero">
            <div class="container">
                <h1>Sistema de Matrícula <br><span>Escuela Gabriela Mistral</span></h1>
                <p>Plataforma integral para el registro y gestión de matrículas estudiantiles.
                    Simplificamos el proceso de inscripción para padres de familia y administradores en Danlí, El
                    Paraíso.</p>

                <div class="mt-4">
                    <button class="btn btn-yellow me-2">🔑 Iniciar Matrícula</button>
                    <button class="btn btn-outline-light" onclick=""> Panel Administrativo /
                        Fechas</button>
                </div>
            </div>
        </section>

        <section class="stats container text-center">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3>0</h3>
                        <p>Estudiantes Matriculados</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3>0</h3>
                        <p>Profesores Activos</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3>0</h3>
                        <p>Aulas Disponibles</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3>0</h3>
                        <p>Grados Ofrecidos</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="calendar-container">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4>Calendario Académico 2026</h4>
                        <p>Fechas importantes del año escolar</p>
                    </div>
                    <button class="btn btn-calendar" onclick="showCronogramaView()">📅 Configurar Fechas</button>
                </div>

                <div id="schedule-list">
                    <p class="text-center mt-3 text-white-50" id="no-dates-message">
                        Cargando cronograma... (Presiona "Configurar Fechas" para ingresar los datos)
                    </p>
                </div>
            </div>
        </section>

        <section class="process">
            <div class="container">
                <h2>Proceso de Matrícula</h2>
                <p>Sigue estos simples pasos para completar la matrícula</p>

                <div class="row justify-content-center">
                    <div class="col-md-4 process-step">
                        <div class="step-number">1</div>
                        <h5>Matrícula Completa</h5>
                        <p>Completa toda la información del estudiante, datos del responsable, selección de grado y
                            profesor en un solo paso.</p>
                    </div>
                    <div class="col-md-4 process-step">
                        <div class="step-number" style="background-color:#d4fcd4; color:#2e7d32;">2</div>
                        <h5>Confirmación</h5>
                        <p>Revisa toda la información y recibe la confirmación de matrícula con el número de registro.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-section">
            <div class="container">
                <h3>Ubicación y Contacto</h3>
                <div class="row g-4 align-items-stretch">
                    <div class="col-md-6">
                        <img src="https://placehold.co/600x350/9575cd/ffffff?text=ESC+GABRIELA+MISTRAL"
                            alt="Centro Educativo" class="img-fluid rounded mb-3">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15582.52041285406!2d-86.5866779!3d14.0458631!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f780e9a7e6d2b59%3A0x67623328e4414522!2sDanl%C3%AD%2C%20El%20Para%C3%ADso%2C%20Honduras!5e0!3m2!1sen!2sus!4v1633512000000"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-box">
                            <h5>Escuela Gabriela Mistral</h5>
                            <div class="contact-info mt-3">
                                <p><strong>Dirección:</strong> Barrio El Centro, Calle Principal, Danlí, El Paraíso,
                                    Honduras</p>
                                <p><strong>Teléfono:</strong> +504 2763-4567</p>
                                <p><strong>Celular:</strong> +504 9876-5432</p>
                                <p><strong>Horarios de Atención:</strong><br>
                                    Lunes a Viernes: 7:00 AM - 4:00 PM<br>
                                </p>
                                <hr>
                                <p><strong>Horarios Específicos:</strong><br>
                                    Secretaría Académica: 8:00 AM - 4:00 PM<br>
                                    Matrículas (Enero-Febrero): 8:00 AM - 4:00 PM<br>
                                    Dirección: 9:00 AM - 3:00 PM
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <div id="cronograma-view" class="container max-w-4xl">
        <h2 class="cronograma-title text-center mb-4">Configuración del Cronograma de Matrícula 2026 📅</h2>
        <p class="text-center text-muted mb-5">Ingresa las fechas de inicio y fin para cada grado escolar.</p>

        <form id="cronograma-form">
            <div class="row g-4">

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">LUNES (1er grado)</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="lunes-inicio" class="form-label small">Inicio:</label>
                                <input type="date" id="lunes-inicio" name="lunes_inicio"
                                    class="form-control form-control-cronograma" required value="2026-01-05">
                            </div>
                            <div class="col">
                                <label for="lunes-fin" class="form-label small">Fin:</label>
                                <input type="date" id="lunes-fin" name="lunes_fin"
                                    class="form-control form-control-cronograma" required value="2026-01-09">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">MARTES (2do grado)</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="martes-inicio" class="form-label small">Inicio:</label>
                                <input type="date" id="martes-inicio" name="martes_inicio"
                                    class="form-control form-control-cronograma" required value="2026-01-12">
                            </div>
                            <div class="col">
                                <label for="martes-fin" class="form-label small">Fin:</label>
                                <input type="date" id="martes-fin" name="martes_fin"
                                    class="form-control form-control-cronograma" required value="2026-01-16">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">MIÉRCOLES (3er grado)</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="miercoles-inicio" class="form-label small">Inicio:</label>
                                <input type="date" id="miercoles-inicio" name="miercoles_inicio"
                                    class="form-control form-control-cronograma" required value="2026-01-19">
                            </div>
                            <div class="col">
                                <label for="miercoles-fin" class="form-label small">Fin:</label>
                                <input type="date" id="miercoles-fin" name="miercoles_fin"
                                    class="form-control form-control-cronograma" required value="2026-01-23">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">JUEVES (4to grado)</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="jueves-inicio" class="form-label small">Inicio:</label>
                                <input type="date" id="jueves-inicio" name="jueves_inicio"
                                    class="form-control form-control-cronograma" required value="2026-01-26">
                            </div>
                            <div class="col">
                                <label for="jueves-fin" class="form-label small">Fin:</label>
                                <input type="date" id="jueves-fin" name="jueves_fin"
                                    class="form-control form-control-cronograma" required value="2026-01-30">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">VIERNES (5to grado)</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="viernes-inicio" class="form-label small">Inicio:</label>
                                <input type="date" id="viernes-inicio" name="viernes_inicio"
                                    class="form-control form-control-cronograma" required value="2026-02-02">
                            </div>
                            <div class="col">
                                <label for="viernes-fin" class="form-label small">Fin:</label>
                                <input type="date" id="viernes-fin" name="viernes_fin"
                                    class="form-control form-control-cronograma" required value="2026-02-06">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">SÁBADO (6to grado)</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="sabado-inicio" class="form-label small">Inicio:</label>
                                <input type="date" id="sabado-inicio" name="sabado_inicio"
                                    class="form-control form-control-cronograma" required value="2026-02-09">
                            </div>
                            <div class="col">
                                <label for="sabado-fin" class="form-label small">Fin:</label>
                                <input type="date" id="sabado-fin" name="sabado_fin"
                                    class="form-control form-control-cronograma" required value="2026-02-13">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">LUNES (7mo grado)</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="septimo-inicio" class="form-label small">Inicio:</label>
                                <input type="date" id="septimo-inicio" name="septimo_inicio"
                                    class="form-control form-control-cronograma" required value="2026-02-16">
                            </div>
                            <div class="col">
                                <label for="septimo-fin" class="form-label small">Fin:</label>
                                <input type="date" id="septimo-fin" name="septimo_fin"
                                    class="form-control form-control-cronograma" required value="2026-02-20">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">MARTES (8vo grado)</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="octavo-inicio" class="form-label small">Inicio:</label>
                                <input type="date" id="octavo-inicio" name="octavo_inicio"
                                    class="form-control form-control-cronograma" required value="2026-02-23">
                            </div>
                            <div class="col">
                                <label for="octavo-fin" class="form-label small">Fin:</label>
                                <input type="date" id="octavo-fin" name="octavo_fin"
                                    class="form-control form-control-cronograma" required value="2026-02-27">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">MIÉRCOLES (9no grado)</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="noveno-inicio" class="form-label small">Inicio:</label>
                                <input type="date" id="noveno-inicio" name="noveno_inicio"
                                    class="form-control form-control-cronograma" required value="2026-03-02">
                            </div>
                            <div class="col">
                                <label for="noveno-fin" class="form-label small">Fin:</label>
                                <input type="date" id="noveno-fin" name="noveno_fin"
                                    class="form-control form-control-cronograma" required value="2026-03-06">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-save-cronograma w-100 p-3 mt-4">
                💾 Guardar Cronograma y Regresar
            </button>
            <button type="button" class="btn btn-outline-secondary w-100 p-3 mt-2" onclick="showMainView()">
                🔙 Cancelar y Volver
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Función para formatear la fecha a un formato legible (ej: 10 de enero de 2026)
        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const date = new Date(dateString + 'T00:00:00'); // Añadir T00:00:00 para evitar problemas de zona horaria
            return date.toLocaleDateString('es-ES', options);
        }

        // Datos clave-valor de Grado a Día para el Cronograma
        const scheduleMap = [
            { key: 'lunes', label: '1er Grado (Lunes)' },
            { key: 'martes', label: '2do Grado (Martes)' },
            { key: 'miercoles', label: '3er Grado (Miércoles)' },
            { key: 'jueves', label: '4to Grado (Jueves)' },
            { key: 'viernes', label: '5to Grado (Viernes)' },
            { key: 'sabado', label: '6to Grado (Sábado)' },
            { key: 'septimo', label: '7mo Grado (Lunes)' }, // AÑADIDO
            { key: 'octavo', label: '8vo Grado (Martes)' }, // AÑADIDO
            { key: 'noveno', label: '9no Grado (Miércoles)' }, // AÑADIDO
        ];

        // Función para cargar los datos del cronograma en la vista principal
        function loadScheduleToMainView() {
            const listContainer = document.getElementById('schedule-list');
            const noDatesMessage = document.getElementById('no-dates-message');
            // Obtener datos de localStorage o usar datos por defecto (si no hay datos)
            const savedDates = JSON.parse(localStorage.getItem('enrollmentDates'));

            listContainer.innerHTML = ''; // Limpiar lista

            if (!savedDates || Object.keys(savedDates).length === 0) {
                listContainer.innerHTML = `
                    <p class="text-center mt-3 text-white-50">
                        Aún no se ha cargado el cronograma de matrícula. Por favor, configura las fechas.
                    </p>
                `;
                return;
            }

            // Ocultar el mensaje de "no-dates" si hay datos
            if (noDatesMessage) noDatesMessage.style.display = 'none';

            // Iterar sobre el mapa para generar la lista
            scheduleMap.forEach(item => {
                const startKey = item.key + '_inicio';
                const endKey = item.key + '_fin';

                const startDate = formatDate(savedDates[startKey]);
                const endDate = formatDate(savedDates[endKey]);

                const listItem = document.createElement('div');
                listItem.className = 'schedule-item';
                listItem.innerHTML = `
                    <div class="schedule-grade">${item.label}</div>
                    <div class="schedule-dates">
                        Del <strong class="text-white">${startDate}</strong>
                        al <strong class="text-white">${endDate}</strong>
                    </div>
                `;
                listContainer.appendChild(listItem);
            });
        }

        // Función para guardar los datos del formulario
        function saveSchedule(event) {
            event.preventDefault(); // Detener el envío normal del formulario

            const form = event.target;
            const formData = new FormData(form);
            const dates = {};

            // Mapear los datos del formulario a un objeto simple
            for (const [key, value] of formData.entries()) {
                dates[key] = value;
            }

            // Guardar el objeto en localStorage
            localStorage.setItem('enrollmentDates', JSON.stringify(dates));

            // Opcional: Cargar los datos guardados de nuevo en el formulario por si el usuario vuelve
            loadScheduleToForm();

            // Mostrar un mensaje de éxito (simulando un modal o alerta elegante)
            alert("✅ Cronograma de matrícula guardado con éxito y actualizado en la vista principal.");

            // Regresar a la vista principal para ver los cambios
            showMainView();
        }

        // Función para cargar los datos guardados en el formulario de Cronograma
        function loadScheduleToForm() {
            const savedDates = JSON.parse(localStorage.getItem('enrollmentDates'));
            if (savedDates) {
                scheduleMap.forEach(item => {
                    const startKey = item.key + '_inicio';
                    const endKey = item.key + '_fin';

                    // Si el dato existe en el almacenamiento, lo cargamos
                    // Se usa un try-catch para evitar errores si no se encuentran los IDs (aunque no debería pasar con el código corregido)
                    try {
                        if (savedDates[startKey]) {
                            document.getElementById(item.key + '-inicio').value = savedDates[startKey];
                        }
                        if (savedDates[endKey]) {
                            document.getElementById(item.key + '-fin').value = savedDates[endKey];
                        }
                    } catch (e) {
                        console.error(`Error al cargar datos para ${item.key}: ${e.message}`);
                    }
                });
            }
        }

        // Funciones de navegación (simulación de cambio de página)
        function showCronogramaView() {
            loadScheduleToForm(); // Cargar datos antes de mostrar el formulario
            document.getElementById('main-view').style.display = 'none';
            document.getElementById('cronograma-view').style.display = 'block';
        }

        function showMainView() {
            loadScheduleToMainView(); // Recargar datos antes de mostrar la vista principal
            document.getElementById('main-view').style.display = 'block';
            document.getElementById('cronograma-view').style.display = 'none';
        }

        // --- Inicialización ---
        window.onload = function () {
            // Asignar el listener al formulario
            document.getElementById('cronograma-form').addEventListener('submit', saveSchedule);

            // Cargar los datos al inicio y mostrar la vista principal
            showMainView();
        };

        // Simular una carga inicial de datos por defecto si no existen
        if (!localStorage.getItem('enrollmentDates')) {
            const defaultDates = {
                "lunes_inicio": "2026-01-05", "lunes_fin": "2026-01-09",
                "martes_inicio": "2026-01-12", "martes_fin": "2026-01-16",
                "miercoles_inicio": "2026-01-19", "miercoles_fin": "2026-01-23",
                "jueves_inicio": "2026-01-26", "jueves_fin": "2026-01-30",
                "viernes_inicio": "2026-02-02", "viernes_fin": "2026-02-06",
                "sabado_inicio": "2026-02-09", "sabado_fin": "2026-02-13",
                // FECHAS POR DEFECTO PARA LOS NUEVOS GRADOS
                "septimo_inicio": "2026-02-16", "septimo_fin": "2026-02-20",
                "octavo_inicio": "2026-02-23", "octavo_fin": "2026-02-27",
                "noveno_inicio": "2026-03-02", "noveno_fin": "2026-03-06"
            };
            localStorage.setItem('enrollmentDates', JSON.stringify(defaultDates));
        }

    </script>
</body>

</html>