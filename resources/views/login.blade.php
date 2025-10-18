<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario</title>

  <style>
    body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #ffffff, #a29bfe); /* 💙 Degradado suave */
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
  padding: 20px;
  font-size: 18px; /* 🔹 Aumenta el tamaño general del texto */
  color: #2d3436;
}

    .form-container {
      background-color: rgb(110, 26, 189);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 400px;
    }

    .form-container h2 {
        color: white;
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 50px;
        color: white;
         padding: 8px;
      margin-top: 5px;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      padding: 10px;
      margin-top: 20px;
      background-color: #ffb703;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
   input {
  width: 100%;
  padding: 10px 12px;
  margin-top: 5px;
  box-sizing: border-box;
  border: 2px solid #dfe6e9;     /* Borde gris claro */
  border-radius: 12px;           /* 🔹 Hace los bordes redondeados */
  font-size: 15px;
  transition: all 0.3s ease;
}

input:focus {
  border-color: #0984e3;         /* Color azul al enfocar */
  outline: none;
  box-shadow: 0 0 6px rgba(9, 132, 227, 0.4);
}


    button:hover {
      background-color: #f4a100;
    }

    p {
      text-align: center;
      margin-top: 15px;
    color: white;
    }

    a {
      color: #00ffea;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;

    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Registrarme</h2>
    <form id="registerForm">
      <label for="name">Nombre:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Correo electrónico:</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Registrarme</button>
    </form>

    <p>¿Ya tienes una cuenta?
    <a href="{{ url('/login') }}">Iniciar sesión</a>

    </p>
  </div>

  <script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      if (name && email && password) {
        alert('Registro exitoso');
      } else {
        alert('Por favor, completa todos los campos');
      }
    });
  </script>
</body>
</html>
