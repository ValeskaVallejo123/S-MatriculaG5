<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Recuperar Contraseña - Escuela Gabriela Mistral</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      background: #ffffff;
      overflow: hidden;
    }

    /* ── Lado izquierdo decorativo ── */
    .left-section {
      flex: 1;
      background: linear-gradient(135deg, #1e5a8e 0%, #0d3d66 50%, #003153 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .hexagon-pattern { position: absolute; width: 100%; height: 100%; opacity: 0.15; }

    .hex {
      position: absolute;
      background: #4ec7d2;
      clip-path: polygon(30% 0%, 70% 0%, 100% 50%, 70% 100%, 30% 100%, 0% 50%);
    }

    .hex-1 { top: 5%;  left: 10%;  width: 150px; height: 150px; opacity: .6; animation: float 8s  ease-in-out infinite; }
    .hex-2 { top: 15%; right: 15%; width: 100px; height: 100px; opacity: .4; animation: float 10s ease-in-out infinite 1s; }
    .hex-3 { bottom: 20%; left: 5%;  width: 180px; height: 180px; opacity: .5; animation: float 12s ease-in-out infinite 2s; }
    .hex-4 { bottom: 10%; right: 10%; width: 130px; height: 130px; opacity: .7; animation: float 9s  ease-in-out infinite 1.5s; }
    .hex-5 { top: 40%; left: 20%;  width: 90px;  height: 90px;  opacity: .3; animation: float 11s ease-in-out infinite .5s; }
    .hex-6 { top: 60%; right: 25%; width: 110px; height: 110px; opacity: .5; animation: float 10s ease-in-out infinite 3s; }

    @keyframes float {
      0%,100% { transform: translateY(0)   translateX(0)   rotate(0deg); }
      25%      { transform: translateY(-20px) translateX(10px)  rotate(5deg); }
      50%      { transform: translateY(-15px) translateX(-10px) rotate(-3deg); }
      75%      { transform: translateY(-25px) translateX(5px)   rotate(2deg); }
    }

    .left-content {
      position: relative; z-index: 10;
      text-align: center; color: white; padding: 40px;
    }

    .school-logo {
      width: 140px; height: 140px;
      background: rgba(255,255,255,.15);
      border-radius: 50%; margin: 0 auto 20px;
      display: flex; align-items: center; justify-content: center;
      border: 4px solid rgba(78,199,210,.4);
      backdrop-filter: blur(10px);
      box-shadow: 0 15px 50px rgba(0,0,0,.3);
    }

    .school-logo i { font-size: 4rem; color: #4ec7d2; filter: drop-shadow(0 5px 15px rgba(0,0,0,.3)); }

    .left-content h1 { font-size: 2rem; font-weight: 800; margin-bottom: 10px; line-height: 1.2; text-shadow: 0 4px 15px rgba(0,0,0,.3); }
    .left-content p  { font-size: 1rem; opacity: .95; font-weight: 400; color: #bfd9ea; text-shadow: 0 2px 10px rgba(0,0,0,.2); }
    .left-content .subtitle { font-size: .85rem; margin-top: 8px; opacity: .8; font-weight: 300; letter-spacing: 1px; }

    /* ── Lado derecho ── */
    .right-section {
      flex: 1;
      display: flex; align-items: center; justify-content: center;
      padding: 30px; background: #ffffff;
      overflow-y: auto; max-height: 100vh;
    }

    .right-section::-webkit-scrollbar { width: 8px; }
    .right-section::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .right-section::-webkit-scrollbar-thumb { background: #4ec7d2; border-radius: 10px; }

    .form-container {
      width: 100%; max-width: 420px;
      animation: slideIn .8s ease-out;
      padding: 10px 0;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateX(30px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    /* Ícono circular superior */
    .icon-circle {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, rgba(78,199,210,.15), rgba(0,80,143,.1));
      border: 2px solid rgba(78,199,210,.35);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 18px;
    }
    .icon-circle i { font-size: 1.8rem; color: #4ec7d2; }

    .form-header { text-align: center; margin-bottom: 28px; }
    .form-header h2 { font-size: 1.75rem; color: #003b73; font-weight: 700; margin-bottom: 8px; }
    .form-header p  { color: #00508f; font-size: .85rem; font-weight: 400; line-height: 1.5; }

    .form-group { margin-bottom: 18px; }

    .form-group label {
      display: block; margin-bottom: 6px;
      color: #003b73; font-size: .85rem; font-weight: 600;
    }

    .input-wrapper { position: relative; }

    .input-icon {
      position: absolute; left: 14px; top: 50%;
      transform: translateY(-50%);
      color: #00508f; font-size: .95rem; z-index: 2;
    }

    .input-wrapper input {
      width: 100%;
      padding: 12px 14px 12px 44px;
      border: 2px solid #e1e8ed; border-radius: 10px;
      font-size: .9rem; outline: none;
      color: #003b73; font-family: 'Poppins', sans-serif; font-weight: 500;
      background: #f8f9fa; transition: all .3s ease;
    }

    .input-wrapper input:focus {
      border-color: #4ec7d2; background: white;
      box-shadow: 0 0 0 4px rgba(78,199,210,.1);
    }

    .input-wrapper input.is-invalid { border-color: #e74c3c; background: #fff5f5; }

    .invalid-feedback { color: #e74c3c; font-size: .78rem; margin-top: 5px; display: block; font-weight: 500; }

    .alert {
      padding: 10px 14px; border-radius: 8px; margin-bottom: 18px;
      font-size: .82rem; display: flex; align-items: center; gap: 8px;
      animation: slideDown .5s ease; font-weight: 500;
    }
    .alert-danger  { background: #fee; color: #c33; border: 1px solid #fcc; }
    .alert-success { background: rgba(78,199,210,.1); color: #00508f; border: 1px solid rgba(78,199,210,.3); }

    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .submit-button {
      width: 100%; padding: 12px;
      background: linear-gradient(135deg, #1e5a8e 0%, #0d3d66 100%);
      color: white; border: none; border-radius: 10px;
      font-size: .95rem; font-weight: 700; cursor: pointer;
      transition: all .4s ease;
      box-shadow: 0 8px 25px rgba(30,90,142,.3);
      font-family: 'Poppins', sans-serif; letter-spacing: .5px;
    }
    .submit-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 35px rgba(30,90,142,.4);
      background: linear-gradient(135deg, #0d3d66 0%, #003153 100%);
    }
    .submit-button i { margin-right: 6px; }

    .divider {
      text-align: center; margin: 20px 0; position: relative;
    }
    .divider::before {
      content: ''; position: absolute; left: 0; top: 50%;
      width: 100%; height: 1px;
      background: linear-gradient(to right, transparent, #e1e8ed, transparent);
    }
    .divider span {
      background: white; padding: 0 15px;
      color: #00508f; font-size: .8rem; position: relative; font-weight: 600;
    }

    .btn-back {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      width: 100%; padding: 11px 20px;
      background: white; color: #00508f;
      border: 2px solid #4ec7d2; border-radius: 10px;
      font-size: .88rem; font-weight: 600; cursor: pointer;
      transition: all .4s ease;
      box-shadow: 0 4px 15px rgba(78,199,210,.2);
      text-decoration: none; font-family: 'Poppins', sans-serif;
    }
    .btn-back:hover {
      background: linear-gradient(135deg, #4ec7d2 0%, #3ab0bc 100%);
      color: white; border-color: #3ab0bc;
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(78,199,210,.35);
    }

    .footer-info {
      text-align: center; padding-top: 15px; margin-top: 15px;
      border-top: 1px solid #e1e8ed;
      color: #00508f; font-size: .75rem; font-weight: 500;
      display: flex; align-items: center; justify-content: center; gap: 6px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .left-section { display: none; }
      .right-section { flex: 1; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); }
    }
    @media (max-width: 480px) {
      .right-section { padding: 18px 14px; }
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
        <i class="fas fa-graduation-cap"></i>
      </div>
      <h1>Recuperar Acceso</h1>
      <p>Sistema de Gestión Escolar</p>
      <p class="subtitle">ESCUELA GABRIELA MISTRAL</p>
    </div>
  </div>

  <!-- Lado derecho con formulario -->
  <div class="right-section">
    <div class="form-container">

      <div class="icon-circle">
        <i class="fas fa-key"></i>
      </div>

      <div class="form-header">
        <h2>¿Olvidaste tu contraseña?</h2>
        <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
      </div>

      @if (session('status'))
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i>
          <span>{{ session('status') }}</span>
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      <form method="POST" action="{{ route('password.enviar') }}">
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
              placeholder="tu-correo@ejemplo.com"
              required autofocus autocomplete="email"
              class="@error('email') is-invalid @enderror"
            >
          </div>
          @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit" class="submit-button">
          <i class="fas fa-paper-plane"></i> Enviar enlace de recuperación
        </button>
      </form>

      <div class="divider"><span>O</span></div>

      <a href="{{ route('login') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al inicio de sesión
      </a>

      <div class="footer-info">
        <i class="fas fa-shield-alt"></i>
        <span>© 2025 Escuela Gabriela Mistral - Danlí, El Paraíso</span>
      </div>

    </div>
  </div>

</body>
</html>
