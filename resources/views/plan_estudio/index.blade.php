<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes de Estudio - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ/AH0/N0R4YkY9tGjE8x7/A/1N+Xm0NnE8/N8Y5rE8L+L3S5U1g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Planes de Estudio</h2>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Botón nuevo plan --}}
    <a href="{{ route('plan_estudios.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle me-2"></i>Agregar Plan de Estudio
    </a>

    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre del Plan</th>
                    <th>Nivel Educativo</th>
                    <th>Grado</th>
                    <th>Año Vigente</th>
                    <th>Duración</th>
                    <th>Jornada</th>
                    <th>Fecha de Aprobación</th>
                    <th>Centro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($planes as $plan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('plan_estudios.show', $plan->id) }}" class="text-white text-decoration-none">
                                {{ $plan->nombre }}
                            </a>
                        </td>
                        <td>{{ $plan->nivel_educativo }}</td>
                        <td>{{ $plan->grado ?? 'N/A' }}</td>
                        <td>{{ $plan->anio ?? 'N/A' }}</td>
                        <td>{{ $plan->duracion }} año(s)</td>
                        <td>{{ $plan->jornada }}</td>
                        <td>{{ $plan->fecha_aprobacion ? $plan->fecha_aprobacion->format('d/m/Y') : '—' }}</td>
                        <td>{{ $plan->centro->nombre ?? 'Sin centro asignado' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('plan_estudios.show', $plan->id) }}" class="btn btn-info btn-sm" title="Ver Detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('plan_estudios.edit', $plan->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar{{$plan->id}}" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                {{-- Modal de eliminación --}}
                                <div class="modal fade" id="modalEliminar{{$plan->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$plan->id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark" id="deleteModalLabel{{$plan->id}}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body text-dark">
                                                ¿Seguro que deseas eliminar el plan <strong>{{ $plan->nombre }}</strong>? Esta acción no se puede deshacer.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form method="POST" action="{{ route('plan_estudios.destroy', $plan->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-white py-4">No hay planes de estudio registrados aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if ($planes->hasPages())
        <div class="d-flex justify-content-center mt-4 mb-4">
            {{ $planes->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <div class="d-flex gap-2 align-items-center mt-3 mb-4">
        <a href="{{ url('/') }}" class="btn btn-outline-dark">Inicio</a>
        <button type="button" class="btn btn-outline-dark" onclick="window.history.back();">Volver</button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>