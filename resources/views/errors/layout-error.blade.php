<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>@yield('title') - Sistema de Matrícula</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: #f0f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #333;
    }

    .error-box {
        background: #ffffff;
        padding: 60px 50px;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 480px;
        position: relative;
        overflow: hidden;
    }

    .error-box::before {
        content: "";
        position: absolute;
        top: -40%;
        left: -40%;
        width: 180%;
        height: 180%;
        background: linear-gradient(135deg, #0a3d62, #1e3799, #3c40c6);
        opacity: 0.05;
        z-index: 0;
        transform: rotate(25deg);
    }

    .error-content {
        position: relative;
        z-index: 1;
    }

    .error-code {
        font-size: 72px;
        font-weight: 700;
        color: #1e3799; /* Azul fuerte */
        margin-bottom: 20px;
        animation: bounce 1.2s ease infinite alternate;
    }

    @keyframes bounce {
        0% { transform: translateY(0); }
        100% { transform: translateY(-8px); }
    }

    h1 {
        font-size: 28px;
        margin-bottom: 15px;
        font-weight: 600;
        color: #0a3d62; /* Azul oscuro */
    }

    p {
        font-size: 16px;
        margin-bottom: 30px;
        color: #555;
    }

    a {
        display: inline-block;
        background: linear-gradient(135deg, #f39c12, #e67e22); /* Detalle elegante */
        color: #fff;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
    }

    a:hover {
        background: linear-gradient(135deg, #d35400, #e67e22);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(230, 126, 34, 0.4);
    }

    @media (max-width: 480px) {
        .error-box {
            padding: 40px 20px;
        }
        .error-code {
            font-size: 60px;
        }
        h1 {
            font-size: 26px;
        }
    }
</style>
</head>
<body>
<div class="error-box">
    <div class="error-content">
        <div class="error-code">@yield('code')</div>
        <h1>Error</h1>
        <p>@yield('message', 'La página que buscas no existe.')</p>
        <a href="{{ url('/') }}">Regresar al inicio</a>
    </div>
</div>
</body>
</html>
