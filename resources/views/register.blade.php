<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Registro - Escuela Gabriela Mistral</title>
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
      height: 100vh;
      display: flex;
      background: #ffffff;
      position: relative;
      overflow: hidden;
    }

    /* Lado izquierdo - Decorativo con hexágonos */
    .left-section {
      flex: 1;
      background: linear-gradient(135deg, #1e5a8e 0%, #0d3d66 50%, #003153 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    /* Patrón de hexágonos */
    .hexagon-pattern {
      position: absolute;
      width: 100%;
      height: 100%;
      opacity: 0.15;
    }

    .hex {
      position: absolute;
      width: 120px;
      height: 120px;
      background: #4ec7d2;
      clip-path: polygon(30% 0%, 70% 0%, 100% 50%, 70% 100%, 30% 100%, 0% 50%);
      opacity: 0.8;
    }

    .hex-1 { top: 5%; left: 10%; width: 150px; height: 150px; opacity: 0.6; animation: float 8s ease-in-out infinite; }
    .hex-2 { top: 15%; right: 15%; width: 100px; height: 100px; opacity: 0.4; animation: float 10s ease-in-out infinite 1s; }
    .hex-3 { bottom: 20%; left: 5%; width: 180px; height: 180px; opacity: 0.5; animation: float 12s ease-in-out infinite 2s; }
    .hex-4 { bottom: 10%; right: 10%; width: 130px; height: 130px; opacity: 0.7; animation: float 9s ease-in-out infinite 1.5s; }
    .hex-5 { top: 40%; left: 20%; width: 90px; height: 90px; opacity: 0.3; animation: float 11s ease-in-out infinite 0.5s; }
    .hex-6 { top: 60%; right: 25%; width: 110px; height: 110px; opacity: 0.5; animation: float 10s ease-in-out infinite 3s; }

    @keyframes float {
      0%, 100% { 
        transform: translateY(0px) translateX(0px) rotate(0deg); 
      }
      25% { 
        transform: translateY(-20px) translateX(10px) rotate(5deg); 
      }
      50% { 
        transform: translateY(-15px) translateX(-10px) rotate(-3deg); 
      }
      75% { 
        transform: translateY(-25px) translateX(5px) rotate(2deg); 
      }
    }

    /* Logo y texto central izquierda */
    .left-content {
      position: relative;
      z-index: 10;
      text-align: center;
      color: white;
      padding: 40px;
    }

    .school-logo {
      width: 160px;
      height: 160px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 50%;
      margin: 0 auto 25px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 4px solid rgba(78, 199, 210, 0.4);
      backdrop-filter: blur(10px);
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
    }

    .school-logo i {
      font-size: 4.5rem;
      color: #4ec7d2;
      filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
    }

    .left-content h1 {
      font-size: 2.2rem;
      font-weight: 800;
      margin-bottom: 12px;
      line-height: 1.2;
      text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .left-content p {
      font-size: 1.05rem;
      opacity: 0.95;
      font-weight: 400;
      color: #bfd9ea;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .left-content .subtitle {
      font-size: 0.9rem;
      margin-top: 10px;
      opacity: 0.8;
      font-weight: 300;
      letter-spacing: 1px;
    }

    /* Lado derecho - Formulario de registro CON SCROLL */
    .right-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #ffffff;
      overflow-y: auto;
      overflow-x: hidden;
      height: 100vh;
      padding: 40px 20px;
    }

    /* Estilos personalizados del scrollbar */
    .right-section::-webkit-scrollbar {
      width: 10px;
    }

    .right-section::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 10px;
    }

    .right-section::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, #4ec7d2 0%, #00508f 100%);
      border-radius: 10px;
      border: 2px solid #f1f5f9;
    }

    .right-section::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(180deg, #00508f 0%, #003153 100%);
    }

    .register-container {
      width: 100%;
      max-width: 460px;
      margin: auto;
      animation: slideIn 0.8s ease-out;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateX(30px); }
      to { opacity: 1; transform: translateX(0); }
    }

    .register-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .register-header h2 {
      font-size: 1.9rem;
      color: #003b73;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .register-header p {
      color: #00508f;
      font-size: 0.92rem;
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 7px;
      color: #003b73;
      font-size: 0.88rem;
      font-weight: 600;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #00508f;
      font-size: 0.95rem;
      z-index: 2;
    }

    .input-wrapper input {
      width: 100%;
      padding: 13px 15px 13px 46px;
      border: 2px solid #e1e8ed;
      border-radius: 10px;
      font-size: 0.9rem;
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
      box-shadow: 0 0 0 4px rgba(78, 199, 210, 0.1);
    }

    .input-wrapper input::placeholder {
      color: #a0aec0;
      font-weight: 400;
      font-size: 0.86rem;
    }

    .input-wrapper input.is-invalid {
      border-color: #e74c3c;
      background: #fff5f5;
    }

    .invalid-feedback {
      color: #e74c3c;
      font-size: 0.78rem;
      margin-top: 5px;
      display: block;
      font-weight: 500;
    }

    .register-button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #1e5a8e 0%, #0d3d66 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 0.98rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.4s ease;
      box-shadow: 0 10px 30px rgba(30, 90, 142, 0.3);
      position: relative;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
      letter-spacing: 0.5px;
      margin-top: 8px;
    }

    .register-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 40px rgba(30, 90, 142, 0.4);
      background: linear-gradient(135deg, #0d3d66 0%, #003153 100%);
    }

    .register-button:active {
      transform: translateY(0);
    }

    .register-button i {
      margin-right: 8px;
    }

    .alert {
      padding: 11px 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 0.86rem;
      animation: slideDown 0.5s ease;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alert i {
      font-size: 1rem;
    }

    .alert-danger {
      background: #fee;
      color: #c33;
      border: 1px solid #fcc;
    }

    .alert-success {
      background: rgba(78, 199, 210, 0.1);
      color: #00508f;
      border: 1px solid rgba(78, 199, 210, 0.3);
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
      background: linear-gradient(to right, transparent, #e1e8ed, transparent);
    }

    .divider span {
      background: white;
      padding: 0 18px;
      color: #00508f;
      font-size: 0.84rem;
      position: relative;
      font-weight: 600;
    }

    .login-link {
      text-align: center;
      color: #00508f;
      font-size: 0.9rem;
      font-weight: 500;
      margin-bottom: 25px;
    }

    .login-link a {
      color: #4ec7d2;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s ease;
    }

    .login-link a:hover {
      color: #00508f;
      text-decoration: underline;
    }

    .footer-info {
      text-align: center;
      padding-top: 20px;
      border-top: 1px solid #e1e8ed;
      color: #00508f;
      font-size: 0.78rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      margin-bottom: 30px;
    }

    .password-requirements {
      background: rgba(78, 199, 210, 0.08);
      border: 1px solid rgba(78, 199, 210, 0.2);
      border-radius: 9px;
      padding: 11px 15px;
      margin-top: 16px;
      margin-bottom: 16px;
    }

    .password-requirements h4 {
      color: #00508f;
      font-size: 0.84rem;
      font-weight: 600;
      margin-bottom: 7px;
      display: flex;
      align-items: center;
      gap: 7px;
    }

    .password-requirements ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .password-requirements li {
      color: #00508f;
      font-size: 0.78rem;
      padding: 3px 0;
      display: flex;
      align-items: center;
      gap: 7px;
    }

    .password-requirements li i {
      font-size: 0.68rem;
      color: #4ec7d2;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .left-section {
        display: none;
      }
      
      .right-section {
        flex: 1;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
      }
    }

    @media (max-width: 768px) {
      .right-section {
        padding: 30px 20px;
      }

      .register-container {
        max-width: 100%;
      }

      .register-header h2 {
        font-size: 1.6rem;
      }

      .register-header p {
        font-size: 0.88rem;
      }
    }

    @media (max-width: 480px) {
      .right-section {
        padding: 25px 16px;
      }

      .register-header {
        margin-bottom: 25px;
      }

      .register-header h2 {
        font-size: 1.4rem;
      }

      .form-group {
        margin-bottom: 18px;
      }

      .input-wrapper input {
        padding: 12px 14px 12px 44px;
        font-size: 0.88rem;
      }

      .register-button {
        padding: 13px;
        font-size: 0.95rem;
      }
    }

    /* Animación de carga */
    .register-button:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }

    .register-button.loading::after {
      content: '';
      position: absolute;
      width: 16px;
      height: 16px;
      top: 50%;
      left: 50%;
      margin-left: -8px;
      margin-top: -8px;
      border: 2px solid #ffffff;
      border-radius: 50%;
      border-top-color: transparent;
      animation: spinner 0.6s linear infinite;
    }

    @keyframes spinner {
      to { transform: rotate(360deg); }
    }

    /* Mejora visual para dispositivos móviles */
    @media (hover: none) {
      .input-wrapper input:focus {
        transform: none;
      }
      
      .register-button:hover {
        transform: none;
      }
      
      .register-button:active {
        transform: scale(0.98);
      }
    }

    /* Smooth scroll behavior */
    .right-section {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body>

  <!-- Lado izquierdo decorativo -->
  <div class="left-section">
    <div class="hexagon-pattern">
      <div class="hex hex-1"></div>
      <div class="hex hex-2"></div>
      <div class="hex hex-3"></div>
      <div class="hex hex-4"></div>
      <div class="hex hex-5"></div>
      <div class="hex hex-6"></div>
    </div>

    <div class="left-content">
      <div class="school-logo">
        <i class="fas fa-user-plus"></i>
      </div>
      <h1>¡Únete a Nosotros!</h1>
      <p>Crea tu cuenta en el Sistema</p>
      <p class="subtitle">ESCUELA GABRIELA MISTRAL</p>
    </div>
  </div>

  <!-- Lado derecho con formulario -->
  <div class="right-section">
    <div class="register-container">
      
      <div class="register-header">
        <h2>Crear Cuenta</h2>
        <p>Completa el formulario para registrarte</p>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle"></i> 
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      @if (session('status'))
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i> 
          <span>{{ session('status') }}</span>
        </div>
      @endif

      <form method="POST" action="{{ route('register.post') }}" id="registerForm">
        @csrf
        
        <div class="form-group">
          <label for="name">Nombre completo</label>
          <div class="input-wrapper">
            <i class="fas fa-user input-icon"></i>
            <input 
              type="text" 
              id="name" 
              name="name"
              value="{{ old('name') }}"
              placeholder="Ej. Ana María López" 
              required
              autofocus
              autocomplete="name"
              class="@error('name') is-invalid @enderror"
            >
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope input-icon"></i>
            <input 
              type="email" 
              id="email" 
              name="email"
              value="{{ old('email') }}"
              placeholder="usuario@gm.hn o usuario@adm.hn" 
              required
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
              placeholder="Crea una contraseña segura" 
              required
              autocomplete="new-password"
              class="@error('password') is-invalid @enderror"
            >
            @error('password')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmar contraseña</label>
          <div class="input-wrapper">
            <i class="fas fa-lock input-icon"></i>
            <input 
              type="password" 
              id="password_confirmation" 
              name="password_confirmation"
              placeholder="Repite tu contraseña" 
              required
              autocomplete="new-password"
            >
          </div>
        </div>

        <div class="password-requirements">
          <h4>
            <i class="fas fa-info-circle"></i>
            Requisitos de la contraseña:
          </h4>
          <ul>
            <li><i class="fas fa-circle"></i> Mínimo 8 caracteres</li>
            <li><i class="fas fa-circle"></i> Incluir mayúsculas y minúsculas</li>
            <li><i class="fas fa-circle"></i> Al menos un número</li>
          </ul>
        </div>

        <button type="submit" class="register-button">
          <i class="fas fa-user-plus"></i> Crear Cuenta
        </button>
      </form>

      <div class="divider">
        <span>O</span>
      </div>

      <div class="login-link">
        ¿Ya tienes una cuenta? 
        <a href="{{ route('login') }}">Inicia sesión aquí</a>
      </div>

      <div class="footer-info">
        <i class="fas fa-shield-alt"></i>
        <span>© 2025 Escuela Gabriela Mistral - Danlí, El Paraíso</span>
      </div>

    </div>
  </div>

  <script>
    // Animación de carga al enviar formulario
    const registerForm = document.getElementById('registerForm');
    const registerButton = registerForm.querySelector('.register-button');

    registerForm.addEventListener('submit', function() {
      registerButton.classList.add('loading');
      registerButton.disabled = true;
    });

    // Limpiar mensajes de error al escribir
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
      input.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        const feedback = this.parentElement.querySelector('.invalid-feedback');
        if (feedback) {
          feedback.style.display = 'none';
        }
      });
    });

    // Validación de contraseñas en tiempo real
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    passwordConfirmation.addEventListener('input', function() {
      if (password.value !== passwordConfirmation.value) {
        passwordConfirmation.setCustomValidity('Las contraseñas no coinciden');
      } else {
        passwordConfirmation.setCustomValidity('');
      }
    });
  </script>

</body>
</html>