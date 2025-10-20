<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario - Sistema de Matrícula</title>

  <style>
    /* ======== ESTILOS GENERALES ======== */
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #ffffff, #a29bfe);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 20px;
      color: #2d3436;
    }

    /* ======== CONTENEDOR DEL FORMULARIO ======== */
    .form-container {
      background-color: rgb(110, 26, 189);
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      width: 400px;
      color: white;
      text-align: left;
    }

    .form-container h2 {
      color: white;
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
    }

    label {
      display: block;
      margin-top: 20px;
      color: white;
      font-size: 15px;
    }

    input {
      width: 100%;
      padding: 10px 12px;
      margin-top: 6px;
      box-sizing: border-box;
      border: 2px solid #dfe6e9;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    input:focus {
      border-color: #0984e3;
      outline: none;
      box-shadow: 0 0 6px rgba(9, 132, 227, 0.4);
    }

    /* ======== BOTÓN DE REGISTRO ======== */
    button {
      width: 100%;
      padding: 12px;
      margin-top: 25px;
      background-color: #ffb703;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    button:hover {
      background-color: #f4a100;
      transform: scale(1.03);
    }

    /* ======== ENLACES Y MENSAJES ======== */
    p {
      text-align: center;
      margin-top: 20px;
      font-size: 15px;
      color: white;
    }

    a {
      color: #ffeaa7;
      text-decoration: underline;
      transition: color 0.3s ease;
    }

    a:hover {
      color: #fdcb6e;
    }

    /* ======== BOTÓN DE RECUPERACIÓN ======== */
    .recover-btn {
      display: inline-block;
      width: 100%;
      text-align: center;
      background-color: #6c5ce7;
      color: white;
      padding: 10px;
      border-radius: 8px;
      margin-top: 10px;
      text-decoration: none;
      font-weight: bold;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .recover-btn:hover {
      background-color: #5a4edb;
      transform: scale(1.03);
    }

    /* ======== MENSAJE DE ERROR ======== */
    .error {
      color: #ffcccc;
      font-size: 14px;
      margin-top: 6px;
      line-height: 1.3;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Registrarme</h2>

    <!-- ======== FORMULARIO DE REGISTRO ======== -->
    <form id="registerForm">
      <label for="name">Nombre completo:</label>
      <input type="text" id="name" name="name" placeholder="Ej. María López" required>

      <label for="email">Correo electrónico:</label>
      <input type="email" id="email" name="email" placeholder="Ej. maria@gmail.com" required>

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" placeholder="********" required>

      <div id="passwordError" class="error"></div>

      <button type="submit">Registrarme</button>
    </form>

    <!-- ======== ENLACES ======== -->
    <p>¿Ya tienes una cuenta?
      <a href="{{ url('/login') }}">Iniciar sesión</a>
    </p>

    <p>¿Olvidaste tu contraseña?</p>
    <a href="{{ url('/password/reset') }}" class="recover-btn">Recuperar contraseña</a>
  </div>

  <script>
    /* ======== VALIDACIÓN DE CONTRASEÑA SEGURA ======== */
    function validarContrasena(password, name, email) {
      const errors = [];

      if (password.length < 8) {
        errors.push("Debe tener al menos 8 caracteres.");
      }
      if (!/[A-Z]/.test(password)) {
        errors.push("Debe tener al menos una letra mayúscula.");
      }
      if (!/[a-z]/.test(password)) {
        errors.push("Debe tener al menos una letra minúscula.");
      }
      if (!/[0-9]/.test(password)) {
        errors.push("Debe incluir al menos un número.");
      }
      if (!/[!@#$%^&*(),.?\":{}|<>]/.test(password)) {
        errors.push("Debe incluir al menos un carácter especial.");
      }
      if (password.toLowerCase().includes(name.toLowerCase()) ||
          password.toLowerCase().includes(email.toLowerCase())) {
        errors.push("No debe contener tu nombre o correo electrónico.");
      }

      return errors;
    }

    /* ======== EVENTO DE ENVÍO DEL FORMULARIO ======== */
    document.getElementById('registerForm').addEventListener('submit', function(event) {
      event.preventDefault();

      const name = document.getElementById('name').value.trim();
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();
      const errorDiv = document.getElementById('passwordError');

      const errores = validarContrasena(password, name, email);

      if (errores.length > 0) {
        errorDiv.innerHTML = errores.join("<br>");
      } else {
        errorDiv.innerHTML = "";
        alert('✅ Registro exitoso. Contraseña segura.');
        // Aquí puedes conectar con Laravel o tu API backend
        // Ejemplo: enviar datos con fetch('/register', { method: 'POST', body: new FormData(this) })
      }
    });
  </script>
</body>
</html>
