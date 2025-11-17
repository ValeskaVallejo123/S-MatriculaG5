<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Restablecer Contraseña</title>

  <!-- MISMO CSS DEL LOGIN -->
  <style>
      /* ——— PEGAR TODO EL CSS DEL LOGIN AQUÍ TAMBIÉN ——— */
  </style>
</head>

<body>

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
            <i class="fas fa-lock"></i>
        </div>
        <h1>Restablecer</h1>
        <p>Ingresa tu nueva contraseña</p>
        <p class="subtitle">ESCUELA GABRIELA MISTRAL</p>
    </div>
</div>

<div class="right-section">
    <div class="login-container">

        <div class="login-header">
            <h2>Crear nueva contraseña</h2>
            <p>Asegúrate de recordarla bien</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" id="loginForm">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label>Nueva contraseña</label>
                <div class="input-wrapper">
                    <i class="fas fa-key input-icon"></i>
                    <input type="password" name="password" required placeholder="Nueva contraseña">
                </div>
            </div>

            <div class="form-group">
                <label>Confirmar contraseña</label>
                <div class="input-wrapper">
                    <i class="fas fa-key input-icon"></i>
                    <input type="password" name="password_confirmation" required placeholder="Repetir contraseña">
                </div>
            </div>

            <button type="submit" class="login-button">
                <i class="fas fa-save"></i> Guardar nueva contraseña
            </button>
        </form>

        <div class="divider">
            <span>O</span>
        </div>

        <div class="register-link">
            <a href="{{ route('login.show') }}">Volver al inicio de sesión</a>
        </div>

        <div class="footer-info">
            <i class="fas fa-shield-alt"></i>
            <span>© 2025 Escuela Gabriela Mistral - Danlí</span>
        </div>

    </div>
</div>

</body>
</html>
