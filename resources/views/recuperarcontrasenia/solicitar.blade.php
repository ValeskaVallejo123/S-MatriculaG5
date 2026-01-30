<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Contraseña - Escuela Gabriela Mistral</title>
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
            /* Usamos el color principal de fondo del login para el body */
            background: linear-gradient(135deg, #f0f4f7 0%, #ffffff 100%);
        }

        .recovery-container {
            width: 100%;
            max-width: 420px;
            padding: 30px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 59, 115, 0.1); /* Sombra similar al login */
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .recovery-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .recovery-header h2 {
            font-size: 1.8rem;
            color: #003b73; /* Azul oscuro */
            font-weight: 700;
            margin-bottom: 10px;
        }

        .recovery-header p {
            color: #00508f; /* Azul medio */
            font-size: 0.95rem;
            font-weight: 400;
            line-height: 1.4;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #003b73;
            font-size: 0.9rem;
            font-weight: 600;
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
            padding: 14px 16px 14px 48px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            outline: none;
            color: #003b73;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            background: #f8f9fa;
        }

        .input-wrapper input:focus {
            border-color: #4ec7d2; /* Accent cyan */
            background: white;
            box-shadow: 0 0 0 4px rgba(78, 199, 210, 0.1);
        }

        /* Botón con degradado y efecto hover del login */
        .submit-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #1e5a8e 0%, #0d3d66 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(30, 90, 142, 0.3);
            position: relative;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.5px;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(30, 90, 142, 0.4);
            background: linear-gradient(135deg, #0d3d66 0%, #003153 100%);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .submit-button i {
            margin-right: 8px;
        }

        /* Estilo de alertas (éxito y error) */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.88rem;
            animation: slideDown 0.5s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .alert i {
            font-size: 1.1rem;
        }

        .alert-danger {
            background: #fff5f5; /* Más suave que el rojo puro */
            color: #e74c3c;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: rgba(78, 199, 210, 0.1); /* Fondo con el accent cyan */
            color: #00508f;
            border: 1px solid rgba(78, 199, 210, 0.3);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
        }

        .back-link a {
            color: #4ec7d2; /* Accent cyan */
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #00508f;
            text-decoration: underline;
        }

        /* Estilo para los mensajes de error de validación de Laravel */
        .invalid-feedback {
            color: #e74c3c;
            font-size: 0.82rem;
            margin-top: 6px;
            display: block;
            font-weight: 500;
        }

    </style>
</head>
<body>

<div class="recovery-container">

    <div class="recovery-header">
        <i class="fas fa-key" style="font-size: 2.5rem; color: #4ec7d2; margin-bottom: 10px;"></i>
        <h2>Restablecer Contraseña</h2>
        <p>Ingresa la dirección de correo electrónico asociada a tu cuenta y te enviaremos un enlace para restablecer tu contraseña.</p>
    </div>
</div>

    {{-- Manejo de mensaje de éxito (ej: el enlace ha sido enviado) --}}
    @if (session('status'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('status') }}</span>
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
                    required
                    autofocus
                    class="@error('email') is-invalid @enderror"
                >
            </div>
            @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="submit-button">
            <i class="fas fa-paper-plane"></i> Enviar Enlace de Recuperación
        </button>
    </form>

    <div class="back-link">
        {{-- Usamos url('/login') o route('login') si la tienes definida --}}
        <a href="{{ url('/login') }}">← Volver al inicio de sesión</a>
    </div>

</div>

</body>
</html>
