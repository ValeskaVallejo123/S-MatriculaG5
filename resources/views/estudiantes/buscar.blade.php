<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h2 class="text-center mb-4"> Buscar estudiante</h2>

                <form action="{{ route('estudiantes.buscar') }}" method="GET" class="mb-4">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Carlos Andrés Ramírez Gómez" value="{{ old('nombre') }}">
                    </div>

                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI:</label>
                        <input type="text" name="dni" id="dni" class="form-control" placeholder="Ej. 0801199912345" value="{{ old('dni') }}">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Buscar</button>
                    </div>
                </form>

                @if(isset($busquedaRealizada) && $busquedaRealizada)
                    @if($resultados->isEmpty())
                        <div class="alert alert-warning text-center">⚠ Estudiante no encontrado.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                <tr>
                                    <th>Nombre 1</th>
                                    <th>Nombre 2</th>
                                    <th>Apellido 1</th>
                                    <th>Apellido 2</th>
                                    <th>DNI</th>
                                    <th>Fecha de nacimiento</th>
                                    <th>Nacionalidad</th>
                                    <th>Sexo</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($resultados as $e)
                                    <tr>
                                        <td>{{ $e->nombre1 }}</td>
                                        <td>{{ $e->nombre2 ?? '-' }}</td>
                                        <td>{{ $e->apellido1 }}</td>
                                        <td>{{ $e->apellido2 ?? '-' }}</td>
                                        <td>{{ $e->dni }}</td>
                                        <td>{{ $e->fecha_nacimiento }}</td>
                                        <td>{{ $e->nacionalidad }}</td>
                                        <td>{{ $e->sexo }}</td>
                                        <td>{{ $e->direccion }}</td>
                                        <td>{{ $e->telefono ?? '-' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>
