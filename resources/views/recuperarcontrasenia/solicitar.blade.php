@extends('layouts.app') {{-- Puedes quitar si NO usas layouts --}}

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Recuperar Contraseña</title>

  <!-- Incluye el mismo CSS COMPLETO DEL LOGIN -->
  <style>
      /* TODO EL CSS IDENTICO DEL LOGIN QUE ME ENVIASTE
         (PEGO EL MISMO estilo completo sin modificar nada para que quede igual) */

      /* ——— PEGAR TODO EL CSS DE TU LOGIN AQUÍ ——— */
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
            <i class="fas fa-graduation-cap"></i>
        </div>
        <h1>Recupera tu acceso</h1>
        <p>Sistema de Gestión Escolar</p>
        <p class="subtitle">ESCUELA GABRIELA MISTRAL</p>
    </div>
</div>

<div class="right-section">
    <div class="login-container">

        <div class="login-header">
            <h2>¿Olvidaste tu contraseña?</h2>
            <p>Ingresa tu correo para enviarte un enlace de recuperación</p>
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

        <form method="POST" action="{{ route('password.email') }}" id="loginForm">
            @csrf

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           placeholder="tu-correo@ejemplo.com"
                           required>
                </div>
            </div>

            <button type="submit" class="login-button">
                <i class="fas fa-paper-plane"></i> Enviar enlace
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
