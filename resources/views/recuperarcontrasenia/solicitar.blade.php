<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Acceso - Escuela Gabriela Mistral</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Variables basadas en tu plantilla */
        :root {
            --azul-oscuro: #1e5a8e;
            --azul-profundo: #003b73;
            --celeste-mistral: #4ec7d2;
            --degradado-portal: linear-gradient(135deg, #1e5a8e 0%, #0d3d66 50%, #003153 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #ffffff;
        }

        /* Lado izquierdo: Degradado igual al Hero de la plantilla */
        .left-section {
            flex: 1;
            background: var(--degradado-portal);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Hexágonos con el celeste de tus botones de servicio */
        .hex {
            position: absolute;
            background: var(--celeste-mistral);
            clip-path: polygon(30% 0%, 70% 0%, 100% 50%, 70% 100%, 30% 100%, 0% 50%);
            opacity: 0.1;
        }
        
        .hex-1 { top: 10%; left: 10%; width: 120px; height: 120px; animation: float 8s infinite; }
        .hex-2 { bottom: 15%; right: 10%; width: 150px; height: 150px; animation: float 10s infinite; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .left-content { position: relative; z-index: 10; text-align: center; color: white; }
        .school-logo i { font-size: 5rem; color: var(--celeste-mistral); margin-bottom: 20px; }

        /* Lado derecho: Formulario */
        .right-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .form-container { width: 100%; max-width: 400px; }

        h2 { color: var(--azul-profundo); font-weight: 700; margin-bottom: 10px; }
        
        /* Botón estilo "Matrícula en Línea" de tu plantilla */
        .submit-button {
            width: 100%;
            padding: 14px;
            background: transparent;
            color: var(--azul-oscuro);
            border: 2px solid var(--celeste-mistral);
            border-radius: 30px; /* Redondeado como tus botones del portal */
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-button:hover {
            background: var(--celeste-mistral);
            color: white;
            box-shadow: 0 5px 15px rgba(78, 199, 210, 0.4);
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            margin-top: 5px;
            outline: none;
        }

        .input-wrapper input:focus { border-color: var(--celeste-mistral); }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--azul-oscuro);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="left-section">
    <div class="hex hex-1"></div>
    <div class="hex hex-2"></div>
    <div class="left-content">
        <div class="school-logo"><i class="fas fa-graduation-cap"></i></div>
        <h1>Escuela Gabriela Mistral</h1>
        <p>Gestión Administrativa</p>
    </div>
</div>

<div class="right-section">
    <div class="form-container">
        <h2>Recuperar Acceso</h2>
        <p style="color: #666; margin-bottom: 25px;">Ingresa tu correo para recibir el enlace.</p>

        @if (session('status'))
            <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.enviar') }}">
            @csrf
            <div class="form-group">
                <label style="color: var(--azul-profundo); font-weight: 600;">Correo Electrónico</label>
                <div class="input-wrapper">
                    <input type="email" name="email" placeholder="ejemplo@correo.com" required>
                </div>
            </div>
            <br>
            <button type="submit" class="submit-button">Enviar Enlace</button>
        </form>

        <a href="{{ route('login') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Regresar al Login
        </a>
    </div>
</div>

</body>
</html>