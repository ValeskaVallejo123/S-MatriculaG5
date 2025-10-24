<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Actualizar cupos - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e6f0ff;
        }
        .navbar-brand { font-family: 'Pacifico', cursive; }
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 40px auto;
        }
        .btn-yellow { background-color: #ffb703; border: none; color: #fff; font-weight: bold; }
        .btn-yellow:hover { background-color: #f4a100; color: white; }
        .btn-red { background-color: #d90429; border: none; color: #fff; }
        .btn-red:hover { background-color: #a1031f; color: #fff; }
        .btn-blue { background-color: #4361ee; border: none; color: #fff; }
        .btn-blue:hover { background-color: #1a42d2; color: #fff; }
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
    <div class="form-container">
        <h4 class="text-center mb-4 fw-bold">Actualizar cupos</h4>


    @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <ul class="mb-0">
                    @foreach (collect($errors->all())->unique() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <form id="cursoForm" method="POST" action="{{ route('cupos_maximos.update', $curso->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre del curso:</label>
                <select name="nombre" id="nombre" class="form-select" required>
                    <option value="">Seleccione un curso...</option>
                    @foreach(['1ro Primaria','2do Primaria','3ro Primaria','4to Primaria','5to Primaria','6to Primaria','1ro Secundaria','2do Secundaria','3ro Secundaria'] as $grado)
                        <option value="{{ $grado }}" {{ old('nombre', $curso->nombre) == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="cupo_maximo" class="form-label fw-bold">Cupo de estudiantes:</label>
                <input type="number" name="cupo_maximo" id="cupo_maximo" class="form-control" min="1" required
                       value="{{ old('cupo_maximo', $curso->cupo_maximo) }}">
                <small class="form-text text-muted">Ingrese un número de estudiantes (máximo 35)</small>
            </div>

            <div class="mb-3">
                <label for="jornada" class="form-label fw-bold">Jornada:</label>
                <select name="jornada" id="jornada" class="form-select" required>
                    <option value="">Seleccione una jornada</option>
                    <option value="Matutina" {{ old('jornada', $curso->jornada) == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                    <option value="Vespertina" {{ old('jornada', $curso->jornada) == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="seccion" class="form-label fw-bold">Sección:</label>
                <select name="seccion" id="seccion" class="form-select" required>
                    <option value="">Seleccione una sección...</option>
                    @foreach(['A','B','C','D'] as $sec)
                        <option value="{{ $sec }}" {{ old('seccion', $curso->seccion) == $sec ? 'selected' : '' }}>{{ $sec }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('cupos_maximos.index') }}" class="btn btn-red">Cancelar</a>

                <button type="submit" class="btn btn-blue">Guardar cambios</button>
            </div>
        </form>

        <form class="text-center mt-3" action="{{ route('cupos_maximos.destroy', $curso->id) }}" method="POST"
              onsubmit="return confirm('¿Estás seguro de eliminar este curso? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-yellow">Eliminar curso
            </button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
