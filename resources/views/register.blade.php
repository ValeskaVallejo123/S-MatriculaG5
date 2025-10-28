<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Sistema de Matrícula</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #ffffff, #a29bfe);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      color: #2d3436;
    }

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
      text-align: center;
      color: white;
      margin-bottom: 25px;
      font-weight: 600;
    }

    label {
      display: block;
      margin-top: 20px;
      font-size: 15px;
    }

    input {
      width: 100%;
      padding: 10px 12px;
      margin-top: 6px;
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

    p {
      text-align: center;
      margin-top: 20px;
      font-size: 15px;
      color: white;
    }

    a {
      color: #ffeaa7;
      text-decoration: underline;
    }

    a:hover {
      color: #fdcb6e;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Registro de Usuario</h2>

    <form method="POST" action="{{ route('register.post') }}">
      @csrf

      <label for="name">Nombre completo:</label>
      <input type="text" id="name" name="name" placeholder="Ej. Ana López" required>
      @error('name') <div style="color:#ffcccc">{{ $message }}</div> @enderror

      <label for="email">Correo electrónico:</label>
      <input type="email" id="email" name="email" placeholder="Ej. usuario@gm.hn o usuario@adm.hn" required>
      @error('email') <div style="color:#ffcccc">{{ $message }}</div> @enderror

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" placeholder="********" required>
      @error('password') <div style="color:#ffcccc">{{ $message }}</div> @enderror

      <label for="password_confirmation">Confirmar contraseña:</label>
      <input type="password" id="password_confirmation" name="password_confirmation" placeholder="********" required>

      <button type="submit">Registrar</button>
    </form>

    <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
  </div>
</body>
</html>

