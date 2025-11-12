<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión - Sistema de Matrícula</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <style>
    body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ffffff, #a29bfe);
     color: #2d3436; }
    .form-container {
    background-color: #89a6f8;
    padding: 25px;
     border-radius: 12px;
      max-width: 600px;
      margin: auto;
       color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .form-container h2 {
    text-align: center;
    margin-bottom: 20px;
    font-weight: 600; }
    label {
    display: block;
    margin-top: 15px;
    font-size: 16px;
    color: white; }
    input {
    width: 100%;
    height: 50px;
    padding: 15px;
    margin-top: 5px;
    border: 2px solid #dfe6e9;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease; }
    .btn-oval {
    border-radius: 50px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 16px;
    color: #f5dfdf;
    background-color: #4d6dc7;
    border: none;
    transition: all 0.3s ease;
    width: 100%; margin-top: 20px; }
    .btn-oval:hover {
    background-color: #7e57c2;
    transform: translateY(-2px); }
    .recover-btn {
    color: #ffe9ff;
    font-weight: bold;
    text-decoration: none; }
    .recover-btn:hover {
    text-decoration: underline;
     }
  </style>
</head>
<body>
<section class="vh-100">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 form-container">

                <h2>Iniciar Sesión</h2>

                @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @error('email')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                  @csrf
                  <label for="email">Correo electrónico:</label>
                  <input type="email" id="email" name="email" placeholder="Tu Correo" required>

                  <label for="password">Contraseña:</label>
                  <input type="password" id="password" name="password" placeholder="Tu Contraseña" required>

                  <button type="submit" class="btn-oval">Ingresar</button>
                </form>

                <p class="text-center mt-3">
                  ¿No tienes cuenta? <a href="{{ route('register') }}" class="recover-btn">Registrarse</a>

                </p>

                <p class="text-center mt-1">
                  <a href="{{ route('password.solicitar') }}" class="recover-btn">¿Olvidaste tu contraseña?</a>
                </p>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center">
                <img src="{{ asset('imagenes/sesion.png') }}" class="img-fluid" alt="Imagen de sesión">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    const ultimoEmail = localStorage.getItem('ultimoEmail');
    const ultimoPassword = localStorage.getItem('ultimoPassword');

    if (ultimoEmail) emailInput.value = ultimoEmail;
    if (ultimoPassword) passwordInput.value = ultimoPassword;
  });
</script>
</body>
</html>
