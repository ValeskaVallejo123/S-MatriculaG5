<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrar Curso - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e6f0ff;
        }

        .navbar-brand {
            font-family: 'Pacifico', cursive;
        }

        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 40px auto;
        }

        .btn-yellow {
            background-color: #ffb703;
            border: none;
            color: #fff;
            font-weight: bold;
        }

        .btn-yellow:hover {
            background-color: #f4a100;
            color: white;
        }

        .btn-red {
            background-color: #d90429;
            border: none;
            color: #fff;
        }

        .btn-red:hover {
            background-color: #a1031f;
            color: #fff;
        }

        .btn-blue {
            background-color: #4361ee;
            border: none;
            color: #fff;
        }

        .btn-blue:hover {
            background-color: #1a42d2;
            color: #fff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #0A1F44;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}" style="color: #ffb703;">
            Escuela Gabriela Mistral
        </a>
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
        <h4 class="text-center mb-4 fw-bold">Registrar nuevos cupos</h4>

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

        <form id="cursoForm" method="POST" action="{{ route('cupos_maximos.store') }}">
            @csrf

            <!-- Nombre del curso y cupo juntos -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label fw-bold">Nombre del curso:</label>
                    <select name="nombre" id="nombre" class="form-select form-select-sm" required>
                        <option value="">Seleccione un curso...</option>
                        <option value="1ro Primaria" {{ old('nombre') == '1ro Primaria' ? 'selected' : '' }}>1ro Primaria</option>
                        <option value="2do Primaria" {{ old('nombre') == '2do Primaria' ? 'selected' : '' }}>2do Primaria</option>
                        <option value="3ro Primaria" {{ old('nombre') == '3ro Primaria' ? 'selected' : '' }}>3ro Primaria</option>
                        <option value="4to Primaria" {{ old('nombre') == '4to Primaria' ? 'selected' : '' }}>4to Primaria</option>
                        <option value="5to Primaria" {{ old('nombre') == '5to Primaria' ? 'selected' : '' }}>5to Primaria</option>
                        <option value="6to Primaria" {{ old('nombre') == '6to Primaria' ? 'selected' : '' }}>6to Primaria</option>
                        <option value="1ro Secundaria" {{ old('nombre') == '1ro Secundaria' ? 'selected' : '' }}>1ro Secundaria</option>
                        <option value="2do Secundaria" {{ old('nombre') == '2do Secundaria' ? 'selected' : '' }}>2do Secundaria</option>
                        <option value="3ro Secundaria" {{ old('nombre') == '3ro Secundaria' ? 'selected' : '' }}>3ro Secundaria</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="cupo_maximo" class="form-label fw-bold">Cupo de estudiantes:</label>
                    <input type="number" name="cupo_maximo" class="form-control form-control-sm" required
                           value="{{ old('cupo_maximo') }}">
                    <small class="form-text text-muted">Ingrese un número de estudiantes (máximo 35)</small>
                </div>
            </div>

            <!-- Jornada y Sección juntos -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jornada" class="form-label fw-bold">Jornada:</label>
                    <select name="jornada" id="jornada" class="form-select form-select-sm" required>
                        <option value="">Seleccione una jornada</option>
                        <option value="Matutina" {{ old('jornada') == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                        <option value="Vespertina" {{ old('jornada') == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="seccion" class="form-label fw-bold">Sección:</label>
                    <select name="seccion" id="seccion" class="form-select form-select-sm" required>
                        <option value="">Seleccione una sección...</option>
                        <option value="A" {{ old('seccion') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('seccion') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('seccion') == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ old('seccion') == 'D' ? 'selected' : '' }}>D</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('cupos_maximos.index') }}" class="btn btn-red me-2">Cancelar</a>
                <div>
                    <button type="button" class="btn btn-yellow" id="btnLimpiar">Limpiar</button>
                    <button type="submit" class="btn btn-blue">Guardar curso</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Botón Volver a los administradores -->
    <div class="text-center mt-4 mb-5">
        <a href="{{ route('admins.index') }}" class="btn btn-secondary px-4 py-2 fw-semibold">
            <i class="bi bi-arrow-left-circle"></i> Volver a los administradores
        </a>
    </div>
</div>

<script>
    document.getElementById('btnLimpiar').addEventListener('click', function () {
        const form = document.getElementById('cursoForm');

        // Limpiar campos de texto y número
        form.querySelectorAll('input').forEach(input => input.value = '');

        // Resetear selects a la opción por defecto (primer opción)
        form.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

        // Eliminar alertas
        document.querySelectorAll('.alert').forEach(alert => alert.remove());

        // Reiniciar clases de validación
        form.querySelectorAll('input, select').forEach(el => el.classList.remove('is-invalid'));
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
