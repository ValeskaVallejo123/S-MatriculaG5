<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Sistema de Matrícula</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

  <style>
    body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #ffffff, #a29bfe); color: #2d3436; }
    .form-container { background-color: #6e1abd; padding: 25px; border-radius: 12px; max-width: 600px; margin: auto; color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .form-container h2 { text-align: center; margin-bottom: 20px; font-weight: 600; }
    label { display: block; margin-top: 15px; font-size: 16px; color: white; }
    input { width: 100%; height: 50px; padding: 15px; margin-top: 5px; border: 2px solid #dfe6e9; border-radius: 10px; font-size: 16px; transition: all 0.3s ease; }
    input:focus { border-color: #0984e3; outline: none; box-shadow: 0 0 6px rgba(9,132,227,0.4); }
    .btn-oval { border-radius: 50px; padding: 12px 30px; font-weight: 600; font-size: 16px; color: #f5dfdf; background-color: #e155d1; border: none; transition: all 0.3s ease; width: 100%; }
    .btn-oval:hover { background-color: #7e57c2; transform: translateY(-2px); }
    .recover-btn { color: white; font-weight: bold; text-decoration: none; }
    .recover-btn:hover { text-decoration: underline; }
    .alert-custom { margin-top: 10px; display: none; }
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

                <!-- Contenedor de errores -->
                <div id="formErrors" class="alert alert-danger alert-custom"></div>

                <form id="registrationForm" method="POST" action="{{ route('register') }}" autocomplete="off">
                  @csrf

                  <label for="name">Nombre:</label>
                  <input type="text" id="name" name="name" placeholder="Tu Nombre" required autocomplete="off"/>

                  <label for="email">Correo electrónico:</label>
                  <input type="email" id="email" name="email" placeholder="Tu Correo" required autocomplete="off"/>

                  <label for="password">Contraseña:</label>
                  <input type="password" id="password" name="password" placeholder="Contraseña" required autocomplete="new-password"/>

                  <label for="password_confirmation">Confirmar Contraseña:</label>
                  <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required autocomplete="new-password"/>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4 mt-4">
                    <button type="submit" class="btn-oval">Registrarse</button>
                  </div>
                </form>

                <p class="text-center mt-3">
                  ¿Ya tienes una cuenta? <a href="{{ route('login.show') }}" class="recover-btn">Iniciar Sesión</a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('registrationForm').addEventListener('submit', function(event) {
    const errors = [];
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(name === '') errors.push('El nombre es obligatorio.');
    if(!emailRegex.test(email)) errors.push('Correo no válido.');
    if(!passwordRegex.test(password)) errors.push('La contraseña debe tener al menos 6 caracteres, una mayúscula, una minúscula y un número.');
    if(password !== confirmPassword) errors.push('Las contraseñas no coinciden.');

    const errorDiv = document.getElementById('formErrors');
    if(errors.length > 0){
        event.preventDefault();
        errorDiv.innerHTML = errors.join('<br>');
        errorDiv.style.display = 'block';
        return;
    } else {
        errorDiv.style.display = 'none';
        // Guardamos temporalmente para pasar al login
        localStorage.setItem('email', email);
        localStorage.setItem('password', password);
    }
});
</script>

</body>
</html>
