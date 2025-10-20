<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restablecer Contraseña - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.55)),
            url('{{ asset('imagenes/centroEd.jpg') }}') center/cover no-repeat;
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .hero span {
            color: #ffd700;
            font-family: 'Pacifico', cursive;
        }

        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 40px;
            max-width: 500px;
            margin: 40px auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .btn-green {
            background-color: #4caf50;
            border: none;
            color: white;
            font-weight: 600;
        }

        .btn-green:hover {
            background-color: #43a047;
        }

        .text-small {
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>
<body>

<section class="hero">
    <div class="container">
        <h1>Restablecer Contraseña</h1>
        <p>Escuela <span>Gabriela Mistral</span></p>
    </div>
</section>

<div class="container">
    <div class="form-container">
        <h4 class="text-center mb-4">Crea tu nueva contraseña</h4>

        <form method="POST" action="{{ route('password.actualizar') }}">

        @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="ejemplo@correo.com" required>
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
                @error('password')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="********" required>
            </div>

            <button type="submit" class="btn btn-green w-100">Restablecer contraseña</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ url('/login') }}" class="text-small">← Volver al inicio de sesión</a>
        </div>
    </div>
</div>

</body>
</html>

