<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Contraseña - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5e6ff, #ffffff);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-box {
            background-color: #6a0dad;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 400px;
            color: #fff;
        }

        .form-box h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
        }

        label {
            font-weight: 500;
            color: #fff;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px;
            border: none;
            padding: 12px;
            margin-bottom: 15px;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .btn-rosa {
            background-color: #f062c0;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 20px;
            padding: 10px 0;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-rosa:hover {
            background-color: #e156b4;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
            text-align: center;
        }

        .links {
            text-align: center;
            margin-top: 15px;
        }

        .links a {
            color: #fff;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<div class="form-box">
    <h2>Recuperar Contraseña</h2>

    @if (session('status'))
        <div class="alert alert-success text-dark bg-light">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.enviar') }}">
        @csrf
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Tu Correo">
        @error('email')
        <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn-rosa">Enviar enlace de recuperación</button>
    </form>

    <div class="links mt-3">
        <a href="{{ url('/login') }}">← Volver al inicio de sesión</a>
    </div>
</div>

</body>
</html>
