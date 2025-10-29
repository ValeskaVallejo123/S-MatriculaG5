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
            background-color: #f5f7ff;
            color: #333;
        }

        /* ---- HERO ---- */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.55)),
            url('{{ asset('imagenes/fondo.jpg') }}') center/cover no-repeat;
            color: #fff;
            padding: 90px 0 70px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .hero h1 {
            font-size: 2.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .hero span {
            color: #ffcc33;
            font-weight: bold;
        }

        /* ---- FORMULARIO ---- */
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 45px 40px;
            max-width: 500px;
            margin: 50px auto;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        }

        .form-container h4 {
            font-weight: 700;
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .form-control {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
            width: 100%;
        }

        .form-control:focus {
            border-color: #ffb703;
            box-shadow: 0 0 0 0.2rem rgba(255, 183, 3, 0.25);
        }

        .btn-yellow {
            background-color: #ffb703;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px 0;
            width: 100%;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .btn-yellow:hover {
            background-color: #f4a100;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(244, 161, 0, 0.3);
        }

        .alert-success {
            border-radius: 8px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            margin-bottom: 15px;
        }

        .alert-danger {
            border-radius: 8px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            margin-bottom: 15px;
        }

        .text-small {
            font-size: 0.9rem;
            color: #666;
        }

        a.text-small {
            text-decoration: none;
        }

        a.text-small:hover {
            text-decoration: underline;
            color: #333;
        }
    </style>
</head>
<body>

    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <h1>Recuperar Contraseña</h1>
            <p>Escuela <span>Gabriela Mistral</span></p>
        </div>
    </section>

    <!-- FORMULARIO -->
    <div class="container">
        <div class="form-container">
            <h4>¿Olvidaste tu contraseña?</h4>

            @if (session('status'))
                <div class="alert alert-success text-center">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.enviar') }}">
                @csrf
                <div class="mb-3">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Ingresa tu correo">
                    @error('email')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-yellow">Enviar enlace de recuperación</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ url('/login') }}" class="text-small">← Volver al inicio de sesión</a>
            </div>
        </div>
    </div>

</body>
</html>

