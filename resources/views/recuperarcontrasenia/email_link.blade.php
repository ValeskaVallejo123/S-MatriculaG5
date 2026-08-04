<!DOCTYPE html>
<html>
<head>
    <style>
        .boton {
            background-color: #4ec7d2;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            display: inline-block;
            font-weight: bold;
        }
    </style>
</head>
<body style="font-family: sans-serif;">
    <h2>Restablecer Contraseña</h2>
    <p>Hola,</p>
    <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta en el sistema de la <strong>Escuela Gabriela Mistral</strong>.</p>
    <p>Para continuar, haz clic en el siguiente botón:</p>
    
    <a href="{{ route('password.restablecer', ['token' => $token, 'email' => $email]) }}" class="boton">
        Restablecer mi contraseña
    </a>

    <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
    <hr>
    <p style="font-size: 0.8em; color: #666;">Este enlace expirará en 60 minutos.</p>
</body>
</html>