<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrar Cupos - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e6f0ff;
        }

        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 40px auto;
        }

        /* Botón Azul Degradado (Igual al de tu lista) */
        .btn-primary-gradient {
            background: linear-gradient(135deg, #1E5A8E 0%, #4C98B6 100%);
            border: none;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(30, 90, 142, 0.4);
            transition: all 0.2s ease-in-out;
        }

        .btn-primary-gradient:hover {
            background: linear-gradient(135deg, #1A4E78 0%, #4288A5 100%);
            color: white;
        }

        .btn-yellow { background-color: #ffb703; border: none; color: #fff; font-weight: bold; }
        .btn-red { background-color: #d90429; border: none; color: #fff; }
        .btn-blue { background-color: #4361ee; border: none; color: #fff; }

        .btn-yellow:hover, .btn-red:hover, .btn-blue:hover { color: white; opacity: 0.9; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #0A1F44;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}" style="color: #ffb703; font-weight: bold;">
            Escuela Gabriela Mistral
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                        Cupos Máximos
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('cupos_maximos.index') }}">Listado de cupos</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="form-container">
        <h4 class="text-center mb-4 fw-bold">Registrar nuevos cupos</h4>

        {{-- Alertas --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form id="cursoForm" method="POST" action="{{ route('cupos_maximos.store') }}">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nombre del curso:</label>
                    <select name="nombre" class="form-select" required>
                        <option value="">Seleccione...</option>
                        @foreach(['1ro Primaria', '2do Primaria', '3ro Primaria', '4to Primaria', '5to Primaria', '6to Primaria', '1ro Secundaria', '2do Secundaria', '3ro Secundaria'] as $grado)
                            <option value="{{ $grado }}" {{ old('nombre') == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Cupo máximo:</label>
                    <input type="number" name="cupo_maximo" class="form-control" required value="{{ old('cupo_maximo') }}" max="35">
                    <small class="text-muted">Máximo 35 estudiantes</small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Jornada:</label>
                    <select name="jornada" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <option value="Matutina" {{ old('jornada') == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                        <option value="Vespertina" {{ old('jornada') == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Sección:</label>
                    <select name="seccion" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <option value="A" {{ old('seccion') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('seccion') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('seccion') == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ old('seccion') == 'D' ? 'selected' : '' }}>D</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('cupos_maximos.index') }}" class="btn btn-red">Cancelar</a>
                <div>
                    <button type="button" class="btn btn-yellow" id="btnLimpiar">Limpiar</button>
                    <button type="submit" class="btn btn-primary-gradient px-4">Guardar curso</button>
                </div>
            </div>
        </form>
    </div>

    <div class="text-center mt-2 mb-5">
        <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Volver al Panel
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('btnLimpiar').addEventListener('click', function () {
        document.getElementById('cursoForm').reset();
    });
</script>
</body>
</html>
