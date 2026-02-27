<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña - Escuela Gabriela Mistral</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

</head>

<body style="font-family: 'Poppins', sans-serif; background-color: #f5f7ff; padding: 30px;">

<div style="
    max-width: 600px;
    margin: auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    padding: 30px;
">

    <h2 style="color: #3f51b5; text-align: center; margin-top: 0;">
        Escuela Gabriela Mistral
    </h2>

    <p style="color: #333; font-size: 15px;">Hola,</p>

    <p style="color: #333; font-size: 15px; line-height: 1.6;">
        Has solicitado cambiar la contraseña de tu cuenta en el
        <strong>Sistema de Matrícula</strong>.
        Para continuar con el proceso, haz clic en el siguiente botón:
    </p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $link }}"
           style="
               background-color: #ffb703;
               color: #ffffff;
               text-decoration: none;
               padding: 12px 28px;
               border-radius: 6px;
               font-weight: 600;
               display: inline-block;
           ">
            Restablecer contraseña
        </a>
    </div>

    <p style="font-size: 14px; color: #555; line-height: 1.6;">
        Este enlace es válido por <strong>60 minutos</strong>.
        Si tú no solicitaste este cambio, simplemente ignora este mensaje.
    </p>

    <hr style="border: none; border-top: 1px solid #eee; margin: 25px 0;">

    <p style="text-align: center; font-size: 12px; color: #888; margin-top: 10px;">
         © {{ date('Y') }} Escuela Gabriela Mistral. Todos los derechos reservados.
    </p>

</div>

</body>
</html>
