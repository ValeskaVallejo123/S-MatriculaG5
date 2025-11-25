<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula Exitosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-container {
            max-width: 650px;
            background: white;
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }

        .success-icon i {
            font-size: 3rem;
            color: white;
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #003b73;
            margin-bottom: 20px;
        }

        .info-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            border: 2px solid #4ec7d2;
        }

        .info-box h4 {
            color: #00508f;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .info-item {
            margin: 10px 0;
            font-size: 1.05rem;
        }

        .info-item strong {
            color: #003b73;
        }

        .estado-badge {
            display: inline-block;
            padding: 8px 20px;
            background: #ffc107;
            color: #856404;
            border-radius: 20px;
            font-weight: 700;
            margin: 20px 0;
        }

        .btn {
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 700;
            margin: 10px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-login {
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white;
        }

        .btn-login:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(78, 199, 210, 0.5);
        }

        .btn-home {
            background: #6c757d;
            color: white;
        }

        .btn-home:hover {
            background: #5a6268;
            color: white;
            transform: translateY(-3px);
        }

        .alert-info {
            text-align: left;
            border-radius: 15px;
            border: none;
            background: rgba(78, 199, 210, 0.1);
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>¡Solicitud de Matrícula Enviada!</h1>
        <p>Tu solicitud ha sido recibida y está en proceso de revisión.</p>

        <div class="estado-badge">
            <i class="fas fa-clock me-2"></i>ESTADO: PENDIENTE
        </div>

        @if(session('codigo'))
        <div class="info-box">
            <h4><i class="fas fa-file-alt me-2"></i>Información de tu Solicitud</h4>
            <div class="info-item"><strong>Código:</strong> {{ session('codigo') }}</div>
            @if(session('email'))
            <div class="info-item"><strong>Usuario:</strong> {{ session('email') }}</div>
            @endif
            @if(session('identidad'))
            <div class="info-item"><strong>Contraseña:</strong> {{ session('identidad') }}</div>
            <small class="text-muted">Guarda esta información en un lugar seguro</small>
            @endif
        </div>
        @endif

        <div class="alert alert-info">
            <h6><i class="fas fa-info-circle me-2"></i>¿Qué sigue?</h6>
            <ol class="mb-0">
                <li>Tu solicitud será revisada por nuestro equipo</li>
                <li>El Super Administrador aprobará tu matrícula</li>
                <li>Recibirás una notificación cuando sea aprobada</li>
                <li>Podrás acceder al sistema con tus credenciales</li>
            </ol>
        </div>

        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
            </a>
            <a href="{{ url('/') }}" class="btn btn-home">
                <i class="fas fa-home me-2"></i>Volver al Inicio
            </a>
        </div>
    </div>
</body>
</html>