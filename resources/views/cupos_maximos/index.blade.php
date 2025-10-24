<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Listado de Cursos - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #e6f0ff; }
        .navbar-brand { font-family: 'Pacifico', cursive; }
        .btn-yellow { background-color: #ffb703; border: none; color: #fff; font-weight: bold; }
        .btn-yellow:hover { background-color: #f4a100; color: white; }
        .btn-blue { background-color: #4361ee; border: none; color: #fff; }
        .btn-blue:hover { background-color: #1a42d2; color: #fff; }
        .btn-red { background-color: #d90429; border: none; color: #fff; }
        .btn-red:hover { background-color: #a1031f; color: #fff; }
        .table th, .table td { vertical-align: middle !important; }
        .table-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: 40px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #0A1F44;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}" style="color: #ffb703;">Escuela Gabriela Mistral</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cupos Máximos
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('cupos_maximos.create') }}">Registrar cupo</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('cupos_maximos.index') }}">Listado de cupos</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="table-container">
        <h2 class="mb-4 text-center">Listado de cupos</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <div class="mb-3 text-end">
            <a href="{{ route('cupos_maximos.create') }}" class="btn btn-blue">Registrar un nuevo cupo</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Cupo Máximo</th>
                    <th>Jornada</th>
                    <th>Sección</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($cursos as $curso)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $curso->nombre }}</td>
                        <td>{{ $curso->cupo_maximo }}</td>
                        <td>{{ $curso->jornada ?? '-' }}</td>
                        <td>{{ $curso->seccion ?? '-' }}</td>
                        <td>
                            <a href="{{ route('cupos_maximos.edit', $curso->id) }}" class="btn btn-sm btn-yellow">Actualizar
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if(alert) alert.remove();
    }, 5000);
</script>
</body>
</html>
