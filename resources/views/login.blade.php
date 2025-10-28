<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión - Sistema de Matrícula</title>

  <style>
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
      transition: color 0.3s ease;
    }

    a:hover {
      color: #fdcb6e;
    }

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

    .error, .client-error {
      color: #ffcccc;
      font-size: 14px;
      margin-top: 6px;
      line-height: 1.3;
    }

    .server-error {
      background-color: rgba(255, 0, 0, 0.1);
      border: 1px solid #ffcccc;
      color: #fff;
      padding: 10px;
      border-radius: 8px;
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
    }

    .success-message {
      background-color: rgba(0, 255, 0, 0.1);
      border: 1px solid #8bc34a;
      color: #fff;
      padding: 10px;
      border-radius: 8px;
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Iniciar Sesión</h2>

    {{-- Mensaje de error del servidor --}}
    @if ($errors->any())
      <div class="server-error">
        {{ $errors->first() }}
      </div>
    @endif

    {{-- Mensaje de cierre de sesión exitoso --}}
    @if (session('success'))
      <div class="success-message">
        {{ session('success') }}
      </div>
    @endif

    {{-- FORMULARIO DE LOGIN --}}
    <form >
      @csrf

      <label for="email">Correo electrónico:</label>
      <input type="email" id="email" name="email" placeholder="Ej. juan.perez@gm.hn" required value="{{ old('email') }}">
      @error('email')
        <div class="error">{{ $message }}</div>
      @enderror

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" placeholder="********" required>
      @error('password')
        <div class="error">{{ $message }}</div>
      @enderror

      <div id="clientErrors" class="client-error" style="display:none;"></div>

      <button type="submit">Iniciar Sesión</button>
    </form>

    {{-- BOTÓN DE RECUPERAR CONTRASEÑA --}}
    <p>¿Olvidaste tu contraseña?</p>
    <a href="{{ route('password.solicitar') }}" class="recover-btn">Recuperar Contraseña</a>
  </div>

  <script>
    (function() {
      const form = document.getElementById('loginForm');
      const email = document.getElementById('email');
      const password = document.getElementById('password');
      const clientErrors = document.getElementById('clientErrors');

      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      form.addEventListener('submit', function(e) {
        const errors = [];

        if (!emailRegex.test(email.value.trim())) {
          errors.push('Introduce un correo electrónico válido.');
        }

        if (!passwordRegex.test(password.value)) {
          errors.push('La contraseña debe tener mínimo 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un carácter especial.');
        }

        if (errors.length) {
          e.preventDefault();
          clientErrors.innerHTML = errors.map(err => '<div>• ' + err + '</div>').join('');
          clientErrors.style.display = 'block';
        } else {
          clientErrors.style.display = 'none';
        }
      });
    })();
  </script>
</body>
</html>
<!DOCTYPE html>
