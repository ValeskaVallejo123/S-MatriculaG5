<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Estudiantes - Gabriela Mistral</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Estudiantes Matriculados</h1>
    <a href="{{ route('estudiantes.create') }}" class="btn btn-primary mb-3">Nueva Matrícula</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Grado</th>
                <th>Sección</th>
                <th>Padre/Tutor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($estudiantes as $est)
                <tr>
                    <td>{{ $est->nombre }}</td>
                    <td>{{ $est->apellido }}</td>
                    <td>{{ $est->grado }}</td>
                    <td>{{ $est->seccion }}</td>
                    <td>{{ $est->nombre_padre ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No hay estudiantes registrados</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $estudiantes->links() }}
</div>
</body>
</html>
