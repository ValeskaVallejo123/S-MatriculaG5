<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Sistema de Matrícula</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #ffffff, #a29bfe);
      color: #2d3436;
    }
    .form-container {
      background-color: #89a6f8;
      padding: 25px;
      border-radius: 12px;
      max-width: 600px;
      margin: auto;
      color: white;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: 600;
    }
    label {
    margin-top: 15px;
    display: block;
    font-size: 16px;
    color: white; }
    input {
    width: 100%;
    height: 50px;
    padding: 12px;
    border-radius: 10px;
    border: 2px solid #dfe6e9;
    margin-top: 5px;
    font-size: 16px; }
    .btn-oval {
    border-radius: 50px;
    padding: 12px 30px;
    background-color: #4d6dc7;
    border: none;
    width: 100%;
    color: white;
    margin-top: 20px; }
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

                <h2>Registrarse</h2>

                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                  @csrf

                  <label for="name">Nombre:</label>
                  <input type="text" id="name" name="name" required>

                  <label for="email">Correo electrónico:</label>
                  <input type="email" id="email" name="email" required>

                  <label for="password">Contraseña:</label>
                  <input type="password" id="password" name="password" required>

                  <label for="password_confirmation">Confirmar Contraseña:</label>
                  <input type="password" id="password_confirmation" name="password_confirmation" required>

                  <button type="submit" class="btn-oval">Registrarse</button>
                </form>

                <p class="text-center mt-3">
                  ¿Ya tienes cuenta? <a href="{{ route('login.show') }}" class="recover-btn">Iniciar Sesión</a>
                </p>

              </div>

              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center">
                <img src="{{ asset('imagenes/sesion.png') }}" class="img-fluid" alt="Imagen de registro">
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Guardar correo y contraseña en localStorage al registrarse
  document.querySelector('form').addEventListener('submit', function() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    localStorage.setItem('ultimoEmail', email);
    localStorage.setItem('ultimoPassword', password);
  });
</script>
</body>
</html>
