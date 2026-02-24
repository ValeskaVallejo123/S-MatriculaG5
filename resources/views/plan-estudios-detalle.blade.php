<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $grado->numero }}° Grado - Plan de Estudios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-5">

    <a href="{{ route('plan-estudios.index') }}" class="btn btn-outline-primary mb-4">
        <i class="fas fa-arrow-left"></i> Volver al Plan de Estudios
    </a>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header text-white rounded-top-4" 
             style="background: linear-gradient(135deg, #4ec7d2, #00508f);">
            <h3 class="mb-0">
                {{ $grado->numero }}° Grado
                @if($grado->seccion) · {{ $grado->seccion }} @endif
            </h3>
            <small>{{ ucfirst($grado->nivel) }} · {{ $grado->anio_lectivo }}</small>
        </div>

        <div class="card-body p-4">
            <h5 class="mb-3 text-primary">
                <i class="fas fa-book me-2"></i>Materias ({{ $grado->materias->count() }})
            </h5>

            @if($grado->materias->isEmpty())
                <p class="text-muted">No hay materias asignadas a este grado.</p>
            @else
                <div class="row g-3">
                    @foreach($grado->materias as $materia)
                    <div class="col-md-4">
                        <div class="card border-0 bg-light rounded-3 p-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                                     style="width:38px;height:38px;background:linear-gradient(135deg,#4ec7d2,#00508f);flex-shrink:0">
                                    <i class="fas fa-book-open" style="font-size:.85rem"></i>
                                </div>
                                <span class="fw-600">{{ $materia->nombre }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
</body>
</html>