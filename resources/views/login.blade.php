<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistema de Matrícula</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #00508f 0%, #003b73 50%, #4ec7d2 100%);
      position: relative;
      overflow: auto;
      padding: 40px 20px;
    }

    /* Patrón de fondo animado */
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: 
        radial-gradient(circle at 20% 80%, rgba(78, 199, 210, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(78, 199, 210, 0.08) 0%, transparent 50%);
      animation: pulse 10s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.8; }
    }

    /* Elementos decorativos flotantes */
    .floating-element {
      position: absolute;
      color: rgba(78, 199, 210, 0.2);
      animation: float 8s ease-in-out infinite;
      font-size: 3rem;
    }

    @keyframes float {
      0%, 100% { 
        transform: translateY(0px) rotate(0deg); 
        opacity: 0.15;
      }
      50% { 
        transform: translateY(-25px) rotate(5deg); 
        opacity: 0.25;
      }
    }

    .element1 {
      top: 10%;
      left: 10%;
      animation-delay: 0s;
    }

    .element2 {
      top: 20%;
      right: 15%;
      font-size: 2.5rem;
      animation-delay: 1.5s;
    }

    .element3 {
      bottom: 15%;
      left: 8%;
      font-size: 3.5rem;
      animation-delay: 2.5s;
    }

    .element4 {
      bottom: 25%;
      right: 10%;
      animation-delay: 1s;
    }

    /* Contenedor principal */
    .login-container {
      background: white;
      width: 90%;
      max-width: 450px;
      border-radius: 20px;
      box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      position: relative;
      z-index: 10;
      animation: slideUp 0.8s ease-out;
    }

    @keyframes slideUp {
      from { 
        opacity: 0; 
        transform: translateY(30px); 
      }
      to { 
        opacity: 1; 
        transform: translateY(0); 
      }
    }

    /* Header del login */
    .login-header {
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
      padding: 45px 35px;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .login-header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
      animation: rotate 15s linear infinite;
    }

    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .logo {
      width: 90px;
      height: 90px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      position: relative;
      z-index: 2;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.05);
    }

    .logo i {
      font-size: 2.8rem;
      color: white;
    }

    .login-header h1 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 10px;
      position: relative;
      z-index: 2;
      letter-spacing: -0.5px;
    }

    .login-header p {
      font-size: 0.95rem;
      opacity: 0.95;
      position: relative;
      z-index: 2;
      font-weight: 400;
    }

    /* Body del formulario */
    .login-body {
      padding: 40px 35px;
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-group label {
      display: block;
      margin-bottom: 10px;
      color: #003b73;
      font-size: 0.9rem;
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #00508f;
      font-size: 1.1rem;
      z-index: 2;
      transition: all 0.3s ease;
    }

    .input-wrapper input:focus ~ .input-icon {
      color: #4ec7d2;
    }

    .input-wrapper input {
      width: 100%;
      padding: 15px 20px 15px 50px;
      border: 2px solid #bfd9ea;
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      outline: none;
      color: #003b73;
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
      background: #f8f9fa;
    }

    .input-wrapper input:focus {
      border-color: #4ec7d2;
      background: white;
      box-shadow: 0 0 0 4px rgba(78, 199, 210, 0.15);
      transform: translateY(-2px);
    }

    .input-wrapper input::placeholder {
      color: #95a5a6;
      font-weight: 400;
    }

    .input-error {
      color: #ef4444;
      font-size: 0.8rem;
      margin-top: 5px;
      display: block;
      font-weight: 500;
    }

    /* Recordarme y olvidé contraseña */
    .remember-forgot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      font-size: 0.88rem;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #003b73;
      cursor: pointer;
      font-weight: 500;
    }

    .remember-me input[type="checkbox"] {
      width: 18px;
      height: 18px;
      accent-color: #4ec7d2;
      cursor: pointer;
    }

    .forgot-password {
      color: #00508f;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .forgot-password:hover {
      color: #4ec7d2;
      transform: translateX(3px);
    }

    /* Botón de inicio de sesión */
    .login-button {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.05rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.4s ease;
      box-shadow: 0 8px 25px rgba(78, 199, 210, 0.35);
      position: relative;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
      letter-spacing: 0.5px;
    }

    .login-button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.6s ease;
    }

    .login-button:hover::before {
      left: 100%;
    }

    .login-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(78, 199, 210, 0.45);
    }

    .login-button:active {
      transform: translateY(-1px);
    }

    .login-button:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }

    /* Divisor */
    .divider {
      text-align: center;
      margin: 30px 0;
      position: relative;
    }

    .divider::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      width: 100%;
      height: 1px;
      background: linear-gradient(to right, transparent, #bfd9ea, transparent);
    }

    .divider span {
      background: white;
      padding: 0 20px;
      color: #95a5a6;
      font-size: 0.85rem;
      position: relative;
      font-weight: 600;
      letter-spacing: 1px;
    }

    /* Link de registro */
    .register-link {
      text-align: center;
      color: #003b73;
      font-size: 0.9rem;
      font-weight: 500;
    }

    .register-link a {
      color: #00508f;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s ease;
    }

    .register-link a:hover {
      color: #4ec7d2;
      text-decoration: underline;
    }

    /* Footer info */
    .footer-info {
      text-align: center;
      margin-top: 30px;
      padding-top: 25px;
      border-top: 1px solid #bfd9ea;
      color: #95a5a6;
      font-size: 0.82rem;
      font-weight: 500;
    }

    .footer-info i {
      color: #4ec7d2;
      margin-right: 5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .login-container {
        width: 95%;
        margin: 20px auto;
      }

      .login-header {
        padding: 35px 25px;
      }

      .login-body {
        padding: 30px 25px;
      }

      .floating-element {
        font-size: 2rem;
      }

      .login-header h1 {
        font-size: 1.5rem;
      }

      body {
        padding: 20px 10px;
      }
    }

    /* Scrollbar personalizado */
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f3f5;
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%);
    }

    /* Alerta de error */
    .error-message {
      background: #fee2e2;
      color: #991b1b;
      padding: 12px 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 0.88rem;
      border-left: 4px solid #ef4444;
      display: none;
      font-weight: 500;
    }

    .error-message.show {
      display: block;
      animation: shake 0.5s ease;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-10px); }
      75% { transform: translateX(10px); }
    }

    /* Alerta de éxito */
    .success-message {
      background: rgba(78, 199, 210, 0.1);
      color: #00508f;
      padding: 12px 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 0.88rem;
      border-left: 4px solid #4ec7d2;
      display: none;
      font-weight: 500;
    }

    .success-message.show {
      display: block;
      animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
      from { 
        opacity: 0;
        transform: translateY(-10px); 
      }
      to { 
        opacity: 1;
        transform: translateY(0); 
      }
    }
  </style>
</head>
<body>

  <!-- Elementos decorativos flotantes -->
  <i class="fas fa-graduation-cap floating-element element1"></i>
  <i class="fas fa-book floating-element element2"></i>
  <i class="fas fa-user-graduate floating-element element3"></i>
  <i class="fas fa-chalkboard-teacher floating-element element4"></i>

  <!-- Contenedor del login -->
  <div class="login-container">
    
    <!-- Header -->
    <div class="login-header">
      <div class="logo">
        <i class="fas fa-school"></i>
      </div>
      <h1>Sistema de Matrícula</h1>
      <p>Escuela Gabriela Mistral</p>
    </div>

    <!-- Body del formulario -->
    <div class="login-body">
      
      <!-- Mensaje de éxito (oculto por defecto) -->
      <div class="success-message" id="successMessage">
        <i class="fas fa-check-circle"></i> Iniciando sesión...
      </div>

      <!-- Mensaje de error (oculto por defecto) -->
      <div class="error-message" id="errorMessage">
        <i class="fas fa-exclamation-circle"></i> Credenciales incorrectas
      </div>

      <form action="{{ route('login') }}" method="POST" id="loginForm">
        @csrf
        
        <!-- Email -->
        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <div class="input-wrapper">
            <input 
              type="email" 
              id="email" 
              name="email"
              value="{{ old('email') }}"
              placeholder="correo@ejemplo.com" 
              required
              autocomplete="email"
            >
            <i class="fas fa-envelope input-icon"></i>
          </div>
          @error('email')
            <small class="input-error">
              <i class="fas fa-exclamation-circle"></i> {{ $message }}
            </small>
          @enderror
        </div>

        <!-- Contraseña -->
        <div class="form-group">
          <label for="password">Contraseña</label>
          <div class="input-wrapper">
            <input 
              type="password" 
              id="password" 
              name="password"
              placeholder="••••••••" 
              required
              autocomplete="current-password"
            >
            <i class="fas fa-lock input-icon"></i>
          </div>
          @error('password')
            <small class="input-error">
              <i class="fas fa-exclamation-circle"></i> {{ $message }}
            </small>
          @enderror
        </div>

        <!-- Recordarme y Olvidé contraseña -->
        <div class="remember-forgot">
          <label class="remember-me">
            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <span>Recordarme</span>
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-password">
              ¿Olvidaste tu contraseña?
            </a>
          @endif
        </div>

        <!-- Botón de login -->
        <button type="submit" class="login-button">
          <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
        </button>
      </form>

      <!-- Divisor -->
      <div class="divider">
        <span>O</span>
      </div>

      <!-- Link de registro -->
      <div class="register-link">
        ¿No tienes cuenta? 
        @if (Route::has('register'))
          <a href="{{ route('register') }}">Solicitar acceso</a>
        @else
          <a href="#">Solicitar acceso</a>
        @endif
      </div>

      <!-- Footer info -->
      <div class="footer-info">
        <i class="fas fa-shield-alt"></i>
        © {{ date('Y') }} Escuela Gabriela Mistral - Danlí, El Paraíso
      </div>
    </div>

  </div>

 <script>
    // Animación de entrada de los inputs
    document.addEventListener('DOMContentLoaded', function() {
      const inputs = document.querySelectorAll('input');
      
      inputs.forEach((input, index) => {
        input.style.opacity = '0';
        input.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
          input.style.transition = 'all 0.5s ease';
          input.style.opacity = '1';
          input.style.transform = 'translateX(0)';
        }, 300 + (index * 100));
      });

      // Mostrar mensajes si existen
      const errorMsg = document.getElementById('errorMessage');
      const successMsg = document.getElementById('successMessage');

      // Si el mensaje de error tiene contenido, mostrarlo
      if (errorMsg && errorMsg.textContent.trim() !== '') {
        errorMsg.classList.add('show');
        setTimeout(() => errorMsg.classList.remove('show'), 5000);
      }

      // Si el mensaje de éxito tiene contenido, mostrarlo
      if (successMsg && successMsg.textContent.trim() !== '') {
        successMsg.classList.add('show');
        setTimeout(() => successMsg.classList.remove('show'), 5000);
      }
    });

    // Efecto de loading al enviar el formulario
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const button = this.querySelector('.login-button');
      button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Iniciando...';
      button.disabled = true;
    });

    // Efecto en los inputs al escribir
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
    inputs.forEach(input => {
      input.addEventListener('input', function() {
        if (this.value.length > 0) {
          this.style.fontWeight = '600';
        } else {
          this.style.fontWeight = '500';
        }
      });
    });
  </script>
</body>
</html>