<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('titulo'  )Sistema de Matrícula - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script> 
    
    <style>
        /* Estilos principales */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
        }

        /* ======= SECCIÓN HERO ======= */
        .hero {
            /* Se asume que '{{ asset('imagenes/centroEd.jpg') }}' es una ruta válida en tu entorno de desarrollo/framework (ej. Laravel) */
            background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
                        url('{{ asset('imagenes/centroEd.jpg') }}') center/cover no-repeat;
            color: white;
            padding: 80px 0 60px;
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

        .btn-yellow {
            background-color: #ffb703;
            border: none;
            color: #fff;
            font-weight: bold;
        }

        .btn-yellow:hover {
            background-color: #f4a100;
            color: white;
        }
=======
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistema de Matrícula - Escuela Gabriela Mistral</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7ff;
    }

    /* ======= SECCIÓN HERO ======= */
   .hero {
    background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45));
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: rgb(14, 13, 13);
    padding: 80px 0 60px;
}

.hero[style*="background-image"] {
    background-image: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)), var(--bg-url);
}
    .hero h1 { // Estilo para el título principal
      font-size: 2.8rem;
      font-weight: 700;
      color:rgb(240, 247, 240)
    }

    .hero span {
      color: #080800;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 2rem;
    }

    .hero p {
      max-width: 600px;
      margin-top: 10px;
     font-size: 1.2rem;
     color: rgb(12, 12, 12);
     line-height: 1.6;
    }

    .btn-yellow {
      background-color: #130e01;
      border: none;
      color: #fff;
      font-weight: bold;
    }

        .stats {
            margin-top: -40px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        /* Estilos del Calendario (si no se usa la estructura antigua) */
        .calendar-container {
            background-color: #673ab7;
            color: white;
            border-radius: 10px;
            padding: 25px;
            margin-top: 40px;
            box-shadow: 0 5px 15px rgba(103, 58, 183, 0.5);
        }
        
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
        
        .schedule-grade {
            font-weight: 600;
            color: #ffd700;
        }
        
        .btn-calendar {
            background-color: #9575cd;
            color: white;
            border: none;
            transition: 0.3s;
        }

        /* ======= PROCESO DE MATRÍCULA ======= */
        .process {
            background-color: #fff;
            padding: 70px 0;
        }

        .process h2 {
            font-weight: 700;
            margin-bottom: 10px;
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

        /* ======= UBICACIÓN Y CONTACTO ======= */
        .contact-section {
            background-color: #f9faff;
            padding: 60px 0;
        }

        .contact-box {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        iframe {
            border: 0;
            border-radius: 10px;
            width: 100%;
            height: 350px;
        }
        
        /* Estilos necesarios para la vista del cronograma (si se implementa) */
        #cronograma-view {
            display: none; /* Oculto por defecto */
            padding: 40px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin: 20px auto;
            max-width: 800px;
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
        }
    </style>
</head>
<body>
  <div class="container">
    @yield('contenido')


    <div id="main-view">
        <section class="hero">
            <div class="container">
                <h1>Sistema de Matrícula <br><span>Escuela Gabriela Mistral</span></h1>
                <p>Plataforma integral para el registro y gestión de matrículas estudiantiles.
                Simplificamos el proceso de inscripción para padres de familia y administradores en Danlí, El Paraíso.</p>
        
                <div class="mt-4">
                    <button class="btn btn-yellow me-2">🔑 Iniciar Matrícula</button>
                    <button class="btn btn-outline-light" onclick="showCronogramaView()">⚙️ Panel Administrativo / Fechas</button>
                </div>
<!-- HERO -->
<section class="hero" style="
    position: relative;
    background-image: url('{{ asset('imagenes/fondo.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 100px 20px;
    color: white;
    overflow: hidden;
">

  <!-- Capa semitransparente -->
  <div style="
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4); /* Negro con 40% transparencia */
      z-index: 1;
  "></div>

  <div class="container" style="
      max-width: 1200px;
      margin: 0 auto;
      text-align: left;
      position: relative;
      z-index: 2;
      font-family: Arial, sans-serif; /* fuente del sistema */
  ">
    <h1 style="color: #f9f9f9;">Sistema de Matrícula <br><span>Escuela Gabriela Mistral</span></h1>
    <p style="color: #f9f9f9;">
      Plataforma integral para el registro y gestión de matrículas estudiantiles.
      Simplificamos el proceso de inscripción para padres de familia y administradores en Danlí, El Paraíso.
    </p>

    <div class="mt-4">
      <a href="{{ url('/login') }}"
         class="btn"
         style="background-color: rgb(235, 82, 214); color: rgb(13, 14, 13); font-size: 18px; border: 1px solid rgb(247, 243, 243);">
        Iniciar sesión
      </a>
    </div>
  </div>
</section>

  <!-- CALENDARIO -->
  <section class="container">
    <div class="calendar mt-5">
      <div>
        <h4>Calendario Académico 2026</h4>
        <p>Fechas importantes del año escolar</p>
      </div>
      <button class="btn btn-calendar">Ver Calendario</button>
    </div>
  </section>

 <!-- PROCESO DE MATRÍCULA -->
<section class="process">
  <div class="container text-center">
    <h2>Proceso de Matrícula</h2>
    <p>Sigue estos simples pasos para completar la matrícula</p>

    <div class="row justify-content-center mt-4">

      <!-- Paso 1: Matrícula Completa -->
      <div class="col-md-4 process-step">
        <div class="step-number">1</div>
        <h5>Matrícula Completa</h5>
        <p>Completa toda la información del estudiante, datos del responsable, selección de grado y profesor en un solo paso.</p>

        <!-- BOTÓN PARA FORMULARIO DE MATRÍCULA -->
        <a href="{{ route('estudiantes.create') }}" class="btn btn-success mt-2">
          Ir al formulario
        </a>
      </div>

      <!-- Paso 2: Confirmación -->
      <div class="col-md-4 process-step">
        <div class="step-number" style="background-color:#d4fcd4; color:#2e7d32;">2</div>
        <h5>Confirmación</h5>
        <p>Revisa toda la información y recibe la confirmación de matrícula con el número de registro.</p>
    </div>
  </div>
</section>


  <!-- UBICACIÓN Y CONTACTO -->
<section class="contact-section">
  <div class="container">
    <h3>Ubicación y Contacto</h3>
    <div class="row g-4 align-items-stretch">
      <!-- Imagen de la escuela -->
      <div class="col-md-6">

        <iframe src="https://www.google.com/maps?q=Danlí,%20El%20Paraíso&output=embed"></iframe>
      </div>
        <div class="col-md-6">
          <div class="contact-box">
            <h5>Escuela Gabriela Mistral</h5>
            <div class="contact-info mt-3">
              <p><strong>Dirección:</strong> Barrio El Centro, Calle Principal, Danlí, El Paraíso, Honduras</p>
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
        </section>

        <section class="stats container text-center">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="stat-card"><h3>0</h3><p>Estudiantes Matriculados</p></div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card"><h3>0</h3><p>Profesores Activos</p></div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card"><h3>0</h3><p>Aulas Disponibles</p></div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card"><h3>0</h3><p>Grados Ofrecidos</p></div>
                </div>
            </div>
        </section>

        <section class="container">
    <div class="calendar-container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4>Cronograma de Matrícula 2026</h4>
                <p>Fechas importantes del proceso de inscripción</p>
            </div>
            <div class="d-flex align-items-center gap-2"> 
                <button class="btn btn-calendar" onclick="showCronogramaView()">📅 Configurar Fechas</button>
                <button class="btn btn-danger" onclick="clearSchedule()">🗑️ Quitar Cronograma</button>
            </div>
            </div>
        
        <div id="schedule-list">
            <p class="text-center mt-3 text-white-50" id="no-dates-message">
                Cargando cronograma...
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
                        <p>Completa toda la información del estudiante, datos del responsable, selección de grado y profesor en un solo paso.</p>
                    </div>
                    <div class="col-md-4 process-step">
                        <div class="step-number" style="background-color:#d4fcd4; color:#2e7d32;">2</div>
                        <h5>Confirmación</h5>
                        <p>Revisa toda la información y recibe la confirmación de matrícula con el número de registro.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-section">
            <div class="container">
                <h3>Ubicación y Contacto</h3>
                <div class="row g-4 align-items-stretch">
                    <div class="col-md-6">
                        <img src="{{ asset('imagenes/centroEd.jpg') }}" alt="Centro Educativo" class="img-fluid rounded mb-3">
                        <iframe src="https://www.google.com/maps?q=Danlí,%20El%20Paraíso&output=embed"></iframe>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-box">
                            <h5>Escuela Gabriela Mistral</h5>
                            <div class="contact-info mt-3">
                                <p><strong>Dirección:</strong> Barrio El Centro, Calle Principal, Danlí, El Paraíso, Honduras</p>
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

    
    <div id="cronograma-view" class="container">
        <h2 class="cronograma-title text-center mb-4">Configuración del Cronograma de Matrícula 2026 📅</h2>
        <p class="text-center text-muted mb-5">Ingresa las fechas de inicio y fin para cada grado escolar.</p>

        <form id="cronograma-form">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">1er grado</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="lunes-inicio" class="form-label small">Inicio (Lunes):</label>
                                <input type="date" id="lunes-inicio" name="lunes_inicio" class="form-control form-control-cronograma" required value="2026-01-05">
                            </div>
                            <div class="col">
                                <label for="lunes-fin" class="form-label small">Fin (lunes):</label>
                                <input type="date" id="lunes-fin" name="lunes_fin" class="form-control form-control-cronograma" required value="2026-01-09">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">2do grado</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="martes-inicio" class="form-label small">Inicio (Martes):</label>
                                <input type="date" id="martes-inicio" name="martes_inicio" class="form-control form-control-cronograma" required value="2026-01-12">
                            </div>
                            <div class="col">
                                <label for="martes-fin" class="form-label small">Fin (Martes):</label>
                                <input type="date" id="martes-fin" name="martes_fin" class="form-control form-control-cronograma" required value="2026-01-16">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">3er grado</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="miercoles-inicio" class="form-label small">Inicio (miercoles):</label>
                                <input type="date" id="miercoles-inicio" name="miercoles_inicio" class="form-control form-control-cronograma" required value="2026-01-19">
                            </div>
                            <div class="col">
                                <label for="miercoles-fin" class="form-label small">Fin (Miercoles):</label>
                                <input type="date" id="miercoles-fin" name="miercoles_fin" class="form-control form-control-cronograma" required value="2026-01-23">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">4to grado</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="jueves-inicio" class="form-label small">Inicio (Jueves):</label>
                                <input type="date" id="jueves-inicio" name="jueves_inicio" class="form-control form-control-cronograma" required value="2026-01-26">
                            </div>
                            <div class="col">
                                <label for="jueves-fin" class="form-label small">Fin (Jueves):</label>
                                <input type="date" id="jueves-fin" name="jueves_fin" class="form-control form-control-cronograma" required value="2026-01-30">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">5to grado</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="viernes-inicio" class="form-label small">Inicio (Viernes):</label>
                                <input type="date" id="viernes-inicio" name="viernes_inicio" class="form-control form-control-cronograma" required value="2026-02-02">
                            </div>
                            <div class="col">
                                <label for="viernes-fin" class="form-label small">Fin (Viernes):</label>
                                <input type="date" id="viernes-fin" name="viernes_fin" class="form-control form-control-cronograma" required value="2026-02-06">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">6to grado</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="sabado-inicio" class="form-label small">Inicio (Savado):</label>
                                <input type="date" id="sabado-inicio" name="sabado_inicio" class="form-control form-control-cronograma" required value="2026-02-09">
                            </div>
                            <div class="col">
                                <label for="sabado-fin" class="form-label small">Fin (Savado):</label>
                                <input type="date" id="sabado-fin" name="sabado_fin" class="form-control form-control-cronograma" required value="2026-02-13">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">7mo grado</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="lunes2-inicio" class="form-label small">Inicio (Lunes):</label>
                                <input type="date" id="lunes2-inicio" name="lunes2_inicio" class="form-control form-control-cronograma" required value="2026-02-09">
                            </div>
                            <div class="col">
                                <label for="lunes2-fin" class="form-label small">Fin (Lunes):</label>
                                <input type="date" id="lunes2-fin" name="lunes2-fin" class="form-control form-control-cronograma" required value="2026-02-13">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">8vo grado</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="martes2-inicio" class="form-label small">Inicio (Martes):</label>
                                <input type="date" id="martes2-inicio" name="martes2_inicio" class="form-control form-control-cronograma" required value="2026-02-09">
                            </div>
                            <div class="col">
                                <label for="martes2-fin" class="form-label small">Fin (Martes):</label>
                                <input type="date" id="martes2-fin" name="martes2_fin" class="form-control form-control-cronograma" required value="2026-02-13">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3 p-3 border rounded">
                        <label class="form-label form-label-cronograma">9no grado</label>
                        <div class="row g-2">
                            <div class="col">
                                <label for="miercoles2-inicio" class="form-label small">Inicio (Miercoles):</label>
                                <input type="date" id="miercoles2-inicio" name="miercoles2_inicio" class="form-control form-control-cronograma" required value="2026-02-09">
                            </div>
                            <div class="col">
                                <label for="miercoles2-fin" class="form-label small">Fin (Miercoles):</label>
                                <input type="date" id="miercoles2-fin" name="miercoles2_fin" class="form-control form-control-cronograma" required value="2026-02-13">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <button type="submit" class="btn btn-primary w-100 p-3 mt-4">
                💾 Guardar Cronograma y Regresar
            </button>
            <button type="button" class="btn btn-outline-secondary w-100 p-3 mt-2" onclick="showMainView()">
                🔙 Cancelar y Volver
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        /**
         * Función para formatear una fecha de 'YYYY-MM-DD' a un formato legible en español.
         * @param {string} dateString - La cadena de fecha en formato 'YYYY-MM-DD'.
         * @returns {string} La fecha formateada o 'N/A'.
         */
        // ... (dentro de la etiqueta <script>)
/**
 * Elimina las fechas del cronograma del almacenamiento local.
 */
function clearSchedule() {
    if (confirm("¿Estás seguro que deseas eliminar el cronograma de matrícula? Esta acción es irreversible.")) {
        localStorage.removeItem('enrollmentDates');
        alert("🗑️ Cronograma eliminado con éxito.");
        showMainView(); // Recargar la vista principal para mostrar el cambio
    }
}

// ... (El resto de tu script existente, incluyendo window.onload)

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            // Añadir T00:00:00 para evitar problemas de zona horaria con las fechas ISO
            const date = new Date(dateString + 'T00:00:00');
            return date.toLocaleDateString('es-ES', options);
        }

        /**
         * Mapeo de grados a claves de almacenamiento, esencial para la lógica.
         * Se adaptan las etiquetas a los días que usaste en el formulario anterior.
         */
        const scheduleMap = [
            { key: 'lunes', label: '1er Grado (Semana 1)' },
            { key: 'martes', label: '2do Grado (Semana 2)' },
            { key: 'miercoles', label: '3er Grado (Semana 3)' },
            { key: 'jueves', label: '4to Grado (Semana 4)' },
            { key: 'viernes', label: '5to Grado (Semana 5)' },
            { key: 'sabado', label: '6to Grado (Semana 6)' },
            { key: 'lunes2', label: '7mo Grado (Semana 7)' },
            { key: 'martes2', label: '8vo Grado (Semana 8)' },
            { key: 'miercoles2', label: '9no Grado (Semana 9)' }    
        ];

        /**
         * Carga las fechas de matrícula desde el almacenamiento local (localStorage)
         * y las renderiza en el contenedor principal ('schedule-list').
         */
        function loadScheduleToMainView() {
            const listContainer = document.getElementById('schedule-list');
            const noDatesMessage = document.getElementById('no-dates-message');
            const savedDates = JSON.parse(localStorage.getItem('enrollmentDates'));

            if (listContainer) listContainer.innerHTML = ''; // Limpiar lista

            if (!savedDates || Object.keys(savedDates).length === 0) {
                if (listContainer) {
                    listContainer.innerHTML = `<p class="text-center mt-3 text-white-50">Aún no se ha cargado el cronograma de matrícula.</p>`;
                }
                return;
            }

            if (noDatesMessage) noDatesMessage.style.display = 'none';

            scheduleMap.forEach(item => {
                const startKey = item.key + '_inicio';
                const endKey = item.key + '_fin';

                const startDate = formatDate(savedDates[startKey]);
                const endDate = formatDate(savedDates[endKey]);

                if (listContainer) {
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
                }
            });
        }

        /**
         * Guarda los datos del formulario de cronograma en el almacenamiento local.
         * @param {Event} event - El evento de envío del formulario.
         */
        function saveSchedule(event) {
            event.preventDefault(); // Detener el envío normal del formulario

            const form = event.target;
            const formData = new FormData(form);
            const dates = {};

            for (const [key, value] of formData.entries()) {
                dates[key] = value;
            }

            localStorage.setItem('enrollmentDates', JSON.stringify(dates));
            
            alert("✅ Cronograma de matrícula guardado con éxito.");
            
            showMainView(); // Regresar a la vista principal para ver los cambios
        }

        /**
         * Carga las fechas guardadas en el almacenamiento local de vuelta al formulario de Cronograma.
         */
        function loadScheduleToForm() {
            const savedDates = JSON.parse(localStorage.getItem('enrollmentDates'));
            if (savedDates) {
                scheduleMap.forEach(item => {
                    const startKey = item.key + '_inicio';
                    const endKey = item.key + '_fin';
                    
                    if (savedDates[startKey]) {
                        document.getElementById(item.key + '-inicio').value = savedDates[startKey];
                    }
                    if (savedDates[endKey]) {
                        document.getElementById(item.key + '-fin').value = savedDates[endKey];
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

        // --- Inicialización y Carga de Datos por Defecto ---
        
        // Simular una carga inicial de datos por defecto si no existen
        if (!localStorage.getItem('enrollmentDates')) {
             const defaultDates = {
                "lunes_inicio": "2026-01-05", "lunes_fin": "2026-01-09",
                "martes_inicio": "2026-01-12", "martes_fin": "2026-01-16",
                "miercoles_inicio": "2026-01-19", "miercoles_fin": "2026-01-23",
                "jueves_inicio": "2026-01-26", "jueves_fin": "2026-01-30",
                "viernes_inicio": "2026-02-02", "viernes_fin": "2026-02-06",
                "sabado_inicio": "2026-02-09", "sabado_fin": "2026-02-13",
                "lunes2_inicio": "2026-02-16", "lunes2_fin": "2026-02-20",
                "martes2_inicio": "2026-02-23", "martes2_fin": "2026-02-27",
                "miercoles2_inicio": "2026-03-02", "miercoles2_fin": "2026-03-06"
             };
             localStorage.setItem('enrollmentDates', JSON.stringify(defaultDates));
        }

        window.onload = function() {
            // Asignar el listener al formulario
            document.getElementById('cronograma-form').addEventListener('submit', saveSchedule);
            
            // Cargar los datos al inicio y mostrar la vista principal
            showMainView();
        };

    </script>
    </div>
</body>
</html>

  </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

