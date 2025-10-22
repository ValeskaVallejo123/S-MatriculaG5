<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistema de Matrícula - Escuela Gabriela Mistral</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
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
    .hero h1 {
      font-size: 2.8rem;
      font-weight: 700;
    }

    .hero span {
      color: #f7f746;
      font-family: 'Pacifico', cursive;
      font-size: 2rem;
    }

    .hero p {
      max-width: 600px;
      margin-top: 10px;
    }

    .btn-yellow {
      background-color: #130e01;
      border: none;
      color: #fff;
      font-weight: bold;
    }

    .btn-yellow:hover {
      background-color: #f4a100;
      color: white;
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

    .calendar {
      background-color: #673ab7;
      color: white;
      border-radius: 10px;
      padding: 25px;
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .calendar h4 {
      font-weight: 600;
      margin-bottom: 5px;
    }

    .btn-calendar {
      background-color: #9575cd;
      color: white;
      border: none;
    }

    .btn-calendar:hover {
      background-color: #7e57c2;
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

    /* ======= UBICACIÓN Y CONTACTO ======= */
    .contact-section {
      background-color: #f9faff;
      padding: 60px 0;
    }

    .contact-section h3 {
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
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

    .contact-info p {
      margin-bottom: 8px;
    }

    .contact-info strong {
      color: #333;
    }
  </style>
</head>
<body>

<!-- HERO -->
<section class="hero" style="
    background-image: url('{{ asset('imagenes/centroEd.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 100px 0;
    color: white;
">
  <div class="container" style="max-width: 1200px; margin: 0 auto; text-align: left;">
    <h1>Sistema de Matrícula <br><span>Escuela Gabriela Mistral</span></h1>
    <p>
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


  <!-- ESTADÍSTICAS -->
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

  <!-- MISIÓN Y VISIÓN -->
  <section class="mision-vision container my-5">
    <div class="row justify-content-center text-center">
      <div class="col-md-8 mb-4">
        <h3 class="fw-bold text-primary">Misión</h3>
        <p>
          Somos una institución pionera responsable de formar y transformar a la niñez municipal,
          Departamental y Nacional, ofreciendo una Educación Básica de calidad en un clima de
          respeto, disciplina y compañerismo, con el propósito de lograr en los alumnos las competencias
          necesarias para adaptarse a la época de cambios que exige la sociedad y el mundo actual.
        </p>
      </div>
      <div class="col-md-8">
        <h3 class="fw-bold text-success">Visión</h3>
        <p>
          Ser una institución líder en la formación de la niñez Hondureña;
          incorporando diversos conocimientos y tecnología de acorde con las necesidades básicas;
          con el fin de lograr en los educandos: "Excelente calidad educativa, valores éticos, morales y espirituales",
          capacidad de análisis, sentimientos de identidad nacional y una actitud crítica positiva
          que les permita enfrentar los actuales y futuros retos que el mundo y la sociedad demandan.
        </p>
      </div>
    </div>
  </section>

  <!-- PROCESO DE MATRÍCULA -->
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

  <!-- UBICACIÓN Y CONTACTO -->
<section class="contact-section">
  <div class="container">
    <h3>Ubicación y Contacto</h3>
    <div class="row g-4 align-items-stretch">
      <!-- Imagen de la escuela -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

