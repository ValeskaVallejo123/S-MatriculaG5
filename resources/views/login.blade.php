<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
      animation: pulse 10s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.8; }
    }

    /* Elementos decorativos flotantes */
    .floating-element {
      position: absolute;
      color: rgba(255, 255, 255, 0.15);
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
      border-radius: 25px;
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
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
      color: #2c3e50;
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
      color: #95a5a6;
      font-size: 1.1rem;
      z-index: 2;
    }

    .input-wrapper input {
      width: 100%;
      padding: 15px 20px 15px 50px;
      border: 2px solid #e0e7ff;
      border-radius: 12px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      outline: none;
      color: #2c3e50;
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
      background: #f8f9ff;
    }

    .input-wrapper input:focus {
      border-color: #667eea;
      background: white;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
      transform: translateY(-2px);
    }

    .input-wrapper input::placeholder {
      color: #bdc3c7;
      font-weight: 400;
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
      color: #5a6c7d;
      cursor: pointer;
      font-weight: 500;
    }

    .remember-me input[type="checkbox"] {
      width: 18px;
      height: 18px;
      accent-color: #667eea;
      cursor: pointer;
    }

    .forgot-password {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .forgot-password:hover {
      color: #764ba2;
      transform: translateX(3px);
    }

    /* Botón de inicio de sesión */
    .login-button {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 1.05rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.4s ease;
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.35);
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
      box-shadow: 0 15px 40px rgba(102, 126, 234, 0.45);
    }

    .login-button:active {
      transform: translateY(-1px);
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
      background: linear-gradient(to right, transparent, #e0e7ff, transparent);
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
      color: #5a6c7d;
      font-size: 0.9rem;
      font-weight: 500;
    }

    .register-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s ease;
    }

    .register-link a:hover {
      color: #764ba2;
      text-decoration: underline;
    }

    /* Footer info */
    .footer-info {
      text-align: center;
      margin-top: 30px;
      padding-top: 25px;
      border-top: 1px solid #e0e7ff;
      color: #95a5a6;
      font-size: 0.82rem;
      font-weight: 500;
    }

    .footer-info i {
      color: #f093fb;
      margin-right: 5px;
    }

    /* Botones sociales opcionales */
    .social-login {
      display: flex;
      gap: 15px;
      margin-top: 25px;
    }

    .social-btn {
      flex: 1;
      padding: 12px;
      border: 2px solid #e0e7ff;
      border-radius: 12px;
      background: white;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 1.2rem;
      color: #667eea;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .social-btn:hover {
      background: #f8f9ff;
      border-color: #667eea;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    }

    .social-btn span {
      font-size: 0.85rem;
      font-weight: 600;
      color: #5a6c7d;
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
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    /* Alerta de error (opcional para validaciones) */
    .error-message {
      background: #fee;
      color: #c33;
      padding: 12px 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 0.88rem;
      border-left: 4px solid #c33;
      display: none;
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
  </style>
</head>
<body>

  <!-- Elementos decorativos flotantes -->
  <i class="fas fa-graduation-cap floating-element element1"></i>
  <i class="fas fa-book floating-element element2"></i>
  <i class="fas fa-pencil-alt floating-element element3"></i>
  <i class="fas fa-atom floating-element element4"></i>

  <!-- Contenedor del login -->
  <div class="login-container">
    
    <!-- Header -->
    <div class="login-header">
      <div class="logo">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <h1>Sistema Escolar</h1>
      <p>Escuela Gabriela Mistral</p>
    </div>

    <!-- Body del formulario -->
    <div class="login-body">
      
      <!-- Mensaje de error (oculto por defecto) -->
      <div class="error-message" id="errorMessage">
        <i class="fas fa-exclamation-circle"></i> Credenciales incorrectas
      </div>

      <form id="loginForm">
        
        <!-- Email -->
        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope input-icon"></i>
            <input 
              type="email" 
              id="email" 
              name="email"
              placeholder="correo@ejemplo.com" 
              required
              autocomplete="email"
            >
          </div>
        </div>

        <!-- Contraseña -->
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
            >
          </div>
        </div>

        <!-- Recordarme y Olvidé contraseña -->
        <div class="remember-forgot">
          <label class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <span>Recordarme</span>
          </label>
          <a href="#" class="forgot-password">
            ¿Olvidaste tu contraseña?
          </a>
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
        ¿No tienes cuenta? <a href="#">Solicitar acceso</a>
      </div>

      <!-- Footer info -->
      <div class="footer-info">
        <i class="fas fa-shield-alt"></i>
        © 2026 Escuela Gabriela Mistral - Danlí, El Paraíso
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
    });

    // Validación del formulario (ejemplo básico)
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const errorMessage = document.getElementById('errorMessage');

      // Simulación de validación
      if (email && password) {
        // Aquí iría la lógica de autenticación real
        console.log('Iniciando sesión...', { email, password });
        
        // Simular éxito después de 1 segundo
        this.querySelector('.login-button').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Iniciando...';
        
        setTimeout(() => {
          // Redirigir al dashboard o página principal
          window.location.href = 'sistema_escolar_educature.html'; // Ajusta la ruta según tu estructura
        }, 1500);
      } else {
        // Mostrar error
        errorMessage.classList.add('show');
        setTimeout(() => {
          errorMessage.classList.remove('show');
        }, 3000);
      }
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

    // Efecto hover en el logo
    const logo = document.querySelector('.logo');
    logo.addEventListener('mouseenter', function() {
      this.style.transform = 'scale(1.1) rotate(5deg)';
      this.style.transition = 'all 0.3s ease';
    });

    logo.addEventListener('mouseleave', function() {
      this.style.transform = 'scale(1) rotate(0deg)';
    });
  </script>

</body>
</html>