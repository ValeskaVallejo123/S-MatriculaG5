<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula Exitosa - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .success-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 59, 115, 0.1);
            text-align: center;
        }

        .success-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            box-shadow: 0 10px 30px rgba(78, 199, 210, 0.3);
            animation: scaleIn 0.5s ease;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #003b73;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1rem;
            color: #00508f;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .info-box {
            background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%);
            padding: 30px;
            border-radius: 15px;
            margin: 30px 0;
            border-left: 4px solid #4ec7d2;
        }

        .info-box h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #003b73;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0, 80, 143, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #00508f;
        }

        .info-value {
            font-weight: 700;
            color: #003b73;
            font-size: 1.1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            margin: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(78, 199, 210, 0.5);
            color: white;
        }

        .btn-secondary {
            background: white;
            color: #003b73;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
            border: 2px solid #bfd9ea;
            margin: 10px;
        }

        .btn-secondary:hover {
            background: #f8f9fa;
            color: #003b73;
            border-color: #4ec7d2;
            transform: translateY(-2px);
        }

        .alert-info {
            background: rgba(78, 199, 210, 0.1);
            border: 2px solid #4ec7d2;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }

        .alert-info ul {
            margin: 15px 0 0 20px;
            color: #00508f;
        }

        .alert-info ul li {
            margin: 10px 0;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>¡Matrícula Registrada Exitosamente!</h1>
        <p>Tu solicitud de matrícula ha sido recibida y está siendo procesada por nuestro equipo administrativo.</p>

        <div class="info-box">
            <h3><i class="fas fa-info-circle me-2"></i>Información de tu Solicitud</h3>
            
            <div class="info-item">
                <span class="info-label">Código de Matrícula:</span>
                <span class="info-value">{{ session('codigo') }}</span>
            </div>

            @if(session('email'))
            <div class="info-item">
                <span class="info-label">Correo Electrónico:</span>
                <span class="info-value">{{ session('email') }}</span>
            </div>
            @endif

            <div class="info-item">
                <span class="info-label">DNI del Tutor:</span>
                <span class="info-value">{{ session('identidad') }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Estado:</span>
                <span class="badge bg-warning text-dark" style="padding: 8px 15px; font-size: 0.95rem;">Pendiente de Aprobación</span>
            </div>
        </div>

        <div class="alert-info">
            <h6 style="color: #003b73; font-weight: 700; margin-bottom: 10px;">
                <i class="fas fa-lightbulb me-2"></i>Próximos Pasos
            </h6>
            <ul>
                <li>Tu solicitud será revisada en un plazo máximo de <strong>48 horas</strong></li>
                <li>Recibirás una notificación cuando tu matrícula sea aprobada</li>
                @if(session('email'))
                <li>Podrás acceder al sistema con tu correo y contraseña (tu DNI)</li>
                @else
                <li>Podrás acceder al sistema con tu código de matrícula y contraseña (tu DNI)</li>
                @endif
                <li>Guarda tu <strong>código de matrícula</strong> para consultar el estado de tu solicitud</li>
            </ul>
        </div>

        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
            </a>
            <a href="{{ route('estado-solicitud') }}" class="btn-secondary">
                <i class="fas fa-search me-2"></i>Consultar Estado
            </a>
            <a href="{{ route('plantilla') }}" class="btn-secondary">
                <i class="fas fa-home me-2"></i>Volver al Inicio
            </a>
        </div>
    </div>

</body>
</html>