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
            background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
            url('{{ asset('imagenes/centroEd.jpg') }}') center/cover no-repeat;
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        .hero h1 { font-size: 2.5rem; font-weight: 700; margin-bottom: 10px; }
        .hero span { color: #ffd700; font-family: 'Pacifico', cursive; }
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 40px;
            max-width: 500px;
            margin: 40px auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-green { background-color: #4caf50; border: none; color: white; font-weight: 600; }
        .btn-green:hover { background-color: #43a047; }
        .text-small { font-size: 0.9rem; color: #555; }
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

        {{-- Alerta de éxito --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        {{-- Alerta de errores (solo una vez cada mensaje) --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <ul class="mb-0">
                    @foreach (collect($errors->all())->unique() as $error)
                        @php
                            // Traducciones específicas de mensajes
                            switch ($error) {
                                case 'The password field confirmation does not match.':
                                    $error = 'La confirmación de la contraseña no coincide.';
                                    break;
                                case 'The password must be at least 6 characters.':
                                case 'The password must be at least 8 characters.': // por si Laravel cambia el mínimo
                                    $error = 'La contraseña debe tener al menos 6 caracteres.';
                                    break;
                                case 'The email must be a valid email address.':
                                    $error = 'El correo electrónico debe ser una dirección válida.';
                                    break;
                                // Puedes agregar más traducciones según tus necesidades
                            }
                        @endphp
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif


        <form method="POST" action="{{ route('password.actualizar') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control"
                       placeholder="ejemplo@correo.com" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input type="password" name="password" id="password" class="form-control"
                       placeholder="********" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control" placeholder="********" required>
            </div>

            <button type="submit" class="btn btn-green w-100">Restablecer contraseña</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ url('/login') }}" class="text-small">← Volver al inicio de sesión</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
