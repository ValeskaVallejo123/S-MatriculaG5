<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña - Escuela Gabriela Mistral</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Poppins', sans-serif; background-color: #f5f7ff; padding: 30px;">

<div style="max-width: 600px; margin: auto; background: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); padding: 30px;">
    <h2 style="color: #3f51b5; text-align: center;">Escuela Gabriela Mistral</h2>

    <p style="color: #333;">Hola,</p>
    <p style="color: #333;">
        Has solicitado recuperar tu contraseña en el <strong>Sistema de Matrícula</strong>.
        Para continuar, haz clic en el siguiente botón:
    </p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $link }}" style="background-color: #ffb703; color: white; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-weight: 600;">
            Restablecer contraseña
        </a>
    </div>

    <p style="font-size: 14px; color: #555;">
        Si no solicitaste este cambio, puedes ignorar este mensaje.
    </p>

    <p style="text-align: center; font-size: 13px; color: #888; margin-top: 20px;">
        © {{ date('Y') }} Escuela Gabriela Mistral. Todos los derechos reservados.
    </p>
</div>
</body>
</html>

