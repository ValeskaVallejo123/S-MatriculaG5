<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Documento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Subir Documento</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            Documento subido: <strong>{{ session('success') }}</strong>
        </div>
    @endif

    {{-- Previsualización del documento seleccionado --}}
    @isset($nombreArchivo)
        <div class="alert alert-info">
            <p>Documento seleccionado: <strong>{{ $nombreArchivo }}</strong></p>
            <form action="{{ route('documentos.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Aceptar y Subir Documento</button>
                <a href="{{ route('documentos.create') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    @endisset

    {{-- Formulario para seleccionar archivo y escribir correos --}}
    @empty($nombreArchivo)
        <form action="{{ route('documentos.preview') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="padre_email" class="form-label">Correo del Padre</label>
                <input type="email" name="padre_email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="estudiante_email" class="form-label">Correo del Estudiante</label>
                <input type="email" name="estudiante_email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="archivo" class="form-label">Archivo</label>
                <input type="file" name="archivo" class="form-control" accept=".jpg,.png,.pdf" required>
                <div class="form-text">Formatos permitidos: JPG, PNG, PDF. Máx. 5MB.</div>
            </div>

            <button type="submit" class="btn btn-primary">Ver Documento Seleccionado</button>
        </form>
    @endempty

    {{-- Último documento subido --}}
    @isset($ultimoDocumento)
        <hr>
        <h2>Documento Subido</h2>
        <p><strong>{{ $ultimoDocumento->nombre }}</strong> ({{ strtoupper($ultimoDocumento->tipo) }})</p>
    @endisset
</div>
</body>
</html>




