<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - Escuela Gabriela Mistral</title>
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
      background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #07196b 100%);
      position: relative;
      overflow: auto;
      padding: 20px;
    }

    /* Fondo decorativo con texto */
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image:
        radial-gradient(circle at 20% 80%, rgba(78, 199, 210, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(78, 199, 210, 0.12) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(191, 217, 234, 0.08) 0%, transparent 50%);
    }

    /* Patrón de grid */
    body::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image:
        linear-gradient(rgba(78, 199, 210, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(78, 199, 210, 0.03) 1px, transparent 1px);
      background-size: 50px 50px;
      opacity: 0.4;
    }

    /* Texto de fondo grande */
    .background-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 3.5rem;
      font-weight: 900;
      color: rgba(78, 199, 210, 0.08);
      text-align: center;
      line-height: 1.4;
      letter-spacing: 2px;
      white-space: nowrap;
      pointer-events: none;
      z-index: 1;
    }

    .background-text-top {
      font-size: 2.5rem;
      display: block;
      color: rgba(78, 199, 210, 0.06);
      margin-bottom: 10px;
    }

    .background-text-main {
      font-size: 4.5rem;
      display: block;
      background: linear-gradient(135deg, rgba(78, 199, 210, 0.12), rgba(191, 217, 234, 0.08));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Elementos flotantes decorativos */
    .floating-element {
      position: absolute;
      color: rgba(78, 199, 210, 0.15);
      animation: float 8s ease-in-out infinite;
      font-size: 3rem;
      z-index: 1;
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

    .element1 { top: 10%; left: 10%; animation-delay: 0s; }
    .element2 { top: 20%; right: 15%; font-size: 2.5rem; animation-delay: 1.5s; }
    .element3 { bottom: 15%; left: 8%; font-size: 3.5rem; animation-delay: 2.5s; }
    .element4 { bottom: 25%; right: 10%; animation-delay: 1s; }

    /* Formas geométricas de fondo */
    .shape {
      position: absolute;
      opacity: 0.05;
      z-index: 1;
    }

    .shape-circle {
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: linear-gradient(135deg, #4ec7d2, #00508f);
      top: -10%;
      right: -10%;
      filter: blur(60px);
    }

    .shape-circle-2 {
      width: 350px;
      height: 350px;
      border-radius: 50%;
      background: linear-gradient(135deg, #bfd9ea, #4ec7d2);
      bottom: -10%;
      left: -10%;
      filter: blur(50px);
    }

    .login-container {
      background: white;
      width: 90%;
      max-width: 450px;
      max-height: 95vh;
      border-radius: 25px;
      box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      position: relative;
      z-index: 10;
      animation: slideUp 0.8s ease-out;
      display: flex;
      flex-direction: column;
      margin: auto;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-header {
      background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
      padding: 35px 30px;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
      flex-shrink: 0;
    }

    .login-header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(78, 199, 210, 0.15) 0%, transparent 70%);
      animation: rotate 15s linear infinite;
    }

    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .logo {
      width: 80px;
      height: 80px;
      background: rgba(78, 199, 210, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 18px;
      border: 3px solid rgba(78, 199, 210, 0.4);
      position: relative;
      z-index: 2;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .logo i {
      font-size: 2.5rem;
      color: #4ec7d2;
    }

    .login-header h1 {
      font-size: 1.6rem;
      font-weight: 700;
      margin-bottom: 8px;
      position: relative;
      z-index: 2;
      letter-spacing: -0.5px;
    }

    .login-header p {
      font-size: 0.9rem;
      opacity: 0.95;
      position: relative;
      z-index: 2;
      font-weight: 400;
      color: #bfd9ea;
    }

    /* Contenedor con scroll */
    .login-body {
      padding: 30px 35px;
      overflow-y: auto;
      overflow-x: hidden;
      flex: 1;
    }

    /* Estilos del scrollbar */
    .login-body::-webkit-scrollbar {
      width: 6px;
    }

    .login-body::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .login-body::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
      border-radius: 10px;
    }

    .login-body::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
    }

    /* Para Firefox */
    .login-body {
      scrollbar-width: thin;
      scrollbar-color: #4ec7d2 #f1f1f1;
    }

    .form-group {
      margin-bottom: 22px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #003b73;
      font-size: 0.88rem;
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #00508f;
      font-size: 1rem;
      z-index: 2;
    }

    .input-wrapper input {
      width: 100%;
      padding: 13px 18px 13px 45px;
      border: 2px solid #bfd9ea;
      border-radius: 12px;
      font-size: 0.92rem;
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

    .input-wrapper input.is-invalid {
      border-color: #e74c3c;
    }

    .invalid-feedback {
      color: #e74c3c;
      font-size: 0.82rem;
      margin-top: 6px;
      display: block;
      font-weight: 500;
    }

    .remember-forgot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      font-size: 0.85rem;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 7px;
      color: #00508f;
      cursor: pointer;
      font-weight: 500;
    }

    .remember-me input[type="checkbox"] {
      width: 17px;
      height: 17px;
      accent-color: #4ec7d2;
      cursor: pointer;
    }

    .forgot-password {
      color: #4ec7d2;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .forgot-password:hover {
      color: #00508f;
    }

    .login-button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.4s ease;
      box-shadow: 0 8px 25px rgba(78, 199, 210, 0.35);
      position: relative;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
      letter-spacing: 0.5px;
    }

    .login-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(78, 199, 210, 0.45);
      background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
    }

    .login-button:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }

    .alert {
      padding: 11px 14px;
      border-radius: 10px;
      margin-bottom: 18px;
      font-size: 0.86rem;
      animation: slideDown 0.5s ease;
    }

    .alert-danger {
      background: #fee;
      color: #c33;
      border-left: 4px solid #c33;
    }

    .alert-success {
      background: rgba(78, 199, 210, 0.1);
      color: #00508f;
      border-left: 4px solid #4ec7d2;
    }

    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .divider {
      text-align: center;
      margin: 25px 0;
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
      padding: 0 18px;
      color: #00508f;
      font-size: 0.82rem;
      position: relative;
      font-weight: 600;
    }

    .register-link {
      text-align: center;
      color: #00508f;
      font-size: 0.88rem;
      font-weight: 500;
      margin-bottom: 25px;
    }

    .register-link a {
      color: #4ec7d2;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s ease;
    }

    .register-link a:hover {
      color: #00508f;
      text-decoration: underline;
    }

    .footer-info {
      text-align: center;
      padding-top: 20px;
      border-top: 1px solid #bfd9ea;
      color: #00508f;
      font-size: 0.8rem;
      font-weight: 500;
    }

    /* Indicador de scroll */
    .scroll-indicator {
      position: absolute;
      bottom: 8px;
      left: 50%;
      transform: translateX(-50%);
      color: #4ec7d2;
      font-size: 0.7rem;
      animation: bounce 2s infinite;
      opacity: 0.7;
      pointer-events: none;
      z-index: 5;
    }

    @keyframes bounce {
      0%, 100% { transform: translateX(-50%) translateY(0); }
      50% { transform: translateX(-50%) translateY(5px); }
    }

    @media (max-width: 768px) {
      body {
        padding: 15px;
      }

      .login-container {
        width: 95%;
        max-height: 92vh;
      }

      .login-header {
        padding: 30px 25px;
      }

      .login-body {
        padding: 25px 25px;
      }

      .floating-element {
        font-size: 2rem;
      }

      .background-text-main {
        font-size: 2.5rem;
      }

      .background-text-top {
        font-size: 1.5rem;
      }

      .background-text {
        white-space: normal;
        max-width: 90%;
      }

      .logo {
        width: 70px;
        height: 70px;
      }

      .logo i {
        font-size: 2.2rem;
      }

      .login-header h1 {
        font-size: 1.4rem;
      }

      .login-header p {
        font-size: 0.85rem;
      }
    }

    @media (max-width: 480px) {
      .background-text-main {
        font-size: 1.8rem;
      }

      .background-text-top {
        font-size: 1.2rem;
      }

      .login-body {
        padding: 20px;
      }

      .form-group {
        margin-bottom: 18px;
      }
    }

    @media (min-height: 700px) {
      .login-container {
        max-height: 85vh;
      }
    }
  </style>
</head>
<body>

  <!-- Formas geométricas de fondo -->
  <div class="shape shape-circle"></div>
  <div class="shape shape-circle-2"></div>

  <!-- Texto de fondo grande -->
  <div class="background-text">
    <span class="background-text-top">CENTRO DE EDUCACIÓN BÁSICO</span>
    <span class="background-text-main">GABRIELA MISTRAL</span>
  </div>

  <!-- Elementos flotantes -->
  <i class="fas fa-graduation-cap floating-element element1"></i>
  <i class="fas fa-book floating-element element2"></i>
  <i class="fas fa-pencil-alt floating-element element3"></i>
  <i class="fas fa-atom floating-element element4"></i>

  <div class="login-container">

    <div class="login-header">
      <div class="logo">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <h1>Sistema Escolar</h1>
      <p>Escuela Gabriela Mistral</p>
    </div>

    <div class="login-body" id="loginBody">

      @if ($errors->any())
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle"></i>
          {{ $errors->first() }}
        </div>
      @endif

      @if (session('status'))
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i>
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope input-icon"></i>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="correo@ejemplo.com"
              required
              autofocus
              autocomplete="email"
              class="@error('email') is-invalid @enderror"
            >
            @error('email')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <div class="input-wrapper">
            <i class="fas fa-lock input-icon"></i>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="••••••••"
              required
              autocomplete="current-password"
              class="@error('password') is-invalid @enderror"
            >
            @error('password')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

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

        <button type="submit" class="login-button">
          <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
        </button>
      </form>

      <div class="divider">
        <span>O</span>
      </div>

      <div class="register-link">
        ¿No tienes cuenta? <a href="{{ url('/') }}">Volver al inicio</a>
      </div>

      <div class="footer-info">
        <i class="fas fa-shield-alt"></i>
        © 2025 Escuela Gabriela Mistral - Danlí, El Paraíso
      </div>
    </div>

    <!-- Indicador de scroll -->
    <div class="scroll-indicator" id="scrollIndicator">
      <i class="fas fa-chevron-down"></i>
    </div>

  </div>

  <script>
    // Detectar scroll para ocultar indicador
    const loginBody = document.getElementById('loginBody');
    const scrollIndicator = document.getElementById('scrollIndicator');

    if (loginBody && scrollIndicator) {
      // Ocultar indicador si el contenido no tiene scroll
      if (loginBody.scrollHeight <= loginBody.clientHeight) {
        scrollIndicator.style.display = 'none';
      }

      loginBody.addEventListener('scroll', function() {
        if (this.scrollTop > 10) {
          scrollIndicator.style.display = 'none';
        } else {
          if (this.scrollHeight > this.clientHeight) {
            scrollIndicator.style.display = 'block';
          }
        }
      });
    }
  </script>

</body>
</html>
