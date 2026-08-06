<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Escuela Gabriela Mistral</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; margin: 0; }
        .contenedor-perfil { max-width: 600px; margin: 60px auto; background: #fff;
            padding: 30px; border-radius: 12px; box-shadow: 0 5px 30px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #003b73; margin-bottom: 20px; }
        .perfil-item { margin-bottom: 15px; }
        .etiqueta { font-weight: bold; color: #00508f; }
        .valor { color: #333; }
        .btn-salir { background: #d9534f; padding: 10px 20px; color: white;
            border-radius: 6px; text-decoration: none; display: inline-block; margin-top: 20px; }
        .btn-volver { background: #00508f; padding: 10px 20px; color: white;
            border-radius: 6px; text-decoration: none; margin-right: 10px; }
    </style>
</head>
<body>

<div class="contenedor-perfil">
    <h2>Mi Perfil</h2>

    <div class="perfil-item">
        <span class="etiqueta">Nombre:</span>
        <span class="valor">{{ $usuario->name }}</span>
    </div>

    <div class="perfil-item">
        <span class="etiqueta">Correo:</span>
        <span class="valor">{{ $usuario->email }}</span>
    </div>

    <div class="perfil-item">
        <span class="etiqueta">Rol:</span>
        <span class="valor">{{ $usuario->getRoleName() }}</span>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="/" class="btn-volver">Inicio</a>
        <button type="submit" class="btn-salir">Cerrar Sesión</button>
    </form>
</div>

</body>
</html>
