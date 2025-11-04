<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistema de Matrícula - Escuela Gabriela Mistral</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7ff;
    }

    /* ======= BOTONES PROFESIONALES OVALADOS ======= */
    .btn-oval {
      border-radius: 50px;
      padding: 12px 30px;
      font-weight: 600;
      font-size: 16px;
      transition: 0.3s;
      border: none;
      color: #0f0202;
      background-color: #d2bdf5;
      text-decoration: none;
      display: inline-block;
    }

    .btn-oval:hover {
      background-color: #d2bdf5;
      transform: translateY(-2px);
      text-decoration: none;
      color: #0f0202;
    }

    /* ======= SECCIÓN HERO ======= */
    .hero {
      position: relative;
      background-image: url('{{ asset('imagenes/fondo.jpg') }}');
      background-size: cover;
      background-position: center;
      padding: 100px 20px;
      color: white;
      overflow: hidden;
    }

    .hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .hero .container {
      position: relative;
      z-index: 2;
      font-family: Arial, sans-serif;
    }

    .hero h1 {
      font-size: 2.8rem;
      font-weight: 700;
      color: #f9f9f9;
    }

    .hero span {
      color: #ffd700;
      font-family: 'Pacifico', cursive;
      font-size: 2rem;
    }

    .hero p {
      max-width: 600px;
      margin-top: 10px;
      font-size: 1.2rem;
      color: #f9f9f9;
      line-height: 1.6;
    }

    .hero .hero-buttons {
      margin-top: 30px;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    /* CALENDARIO */
    .calendar {
      background-color: #673ab7;
      color: white;
      border-radius: 10px;
      padding: 25px;
      margin-top: 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* PROCESO DE MATRÍCULA */
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

    /* UBICACIÓN Y CONTACTO */
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
<section class="hero">
  <div class="container">
    <h1>Sistema de Matrícula <br><span>Escuela Gabriela Mistral</span></h1>
    <p>
      Plataforma integral para el registro y gestión de matrículas estudiantiles.
      Simplificamos el proceso de inscripción para padres de familia y administradores en Danlí, El Paraíso.
    </p>

    <!-- Botones Ovalados -->
    <div class="hero-buttons">
      <a href="{{ url('/register') }}" class="btn-oval">Registrarse</a>
      <a href="{{ url('/login') }}" class="btn-oval">Iniciar Sesión</a>
    </div>
  </div>
</section>

<!-- CALENDARIO -->
<section class="container">
  <div class="calendar">
    <div>
      <h4>Calendario Académico 2026</h4>
      <p>Fechas importantes del año escolar</p>
    </div>
    <a href="#" class="btn-oval">Ver Calendario</a>
  </div>
</section>

<!-- PROCESO DE MATRÍCULA -->
<section class="process">
  <div class="container text-center">
    <h2>Proceso de Matrícula</h2>
    <p>Sigue estos simples pasos para completar la matrícula</p>

    <div class="row justify-content-center mt-4">
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
            <p><strong>Horarios de Atención:</strong><br>Lunes a Viernes: 7:00 AM - 4:00 PM</p>
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
