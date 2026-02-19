@extends('layouts.app')

@section('title', 'Observaciones Conductuales')

@section('page-title', 'Gestión de Observaciones')
@section('content')
    <div class="container" style="max-width: 1400px;">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert border-0 mb-3" style="background: rgba(76, 175, 80, 0.1); border-left: 3px solid #4caf50 !important; border-radius: 8px;">
                <div class="d-flex align-items-start">
                    <i class="fas fa-check-circle me-2 mt-1" style="font-size: 0.9rem; color: #4caf50;"></i>
                    <div>
                        <strong style="color: #2e7d32;">{{ session('success') }}</strong>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filtros -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('observaciones.index') }}">
                    <div class="row align-items-end g-2">
                        <!-- Filtro Nombre -->
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold" style="color: #003b73;">Estudiante</label>
                            <div class="position-relative">
                                <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="text" name="nombre" value="{{ $filtros['nombre'] ?? '' }}"
                                       placeholder="Buscar por nombre"
                                       class="form-control form-control-sm ps-5"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px;">
                            </div>
                        </div>

                        <!-- Filtro Tipo -->
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold" style="color: #003b73;">Tipo</label>
                            <select name="tipo" class="form-select form-select-sm" style="border: 2px solid #bfd9ea; border-radius: 8px;">
                                <option value="">Todos</option>
                                <option value="positivo" @selected(($filtros['tipo'] ?? '') === 'positivo')>Positivo</option>
                                <option value="negativo" @selected(($filtros['tipo'] ?? '') === 'negativo')>Negativo</option>
                            </select>
                        </div>

                        <!-- Filtro Fecha Inicio -->
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold" style="color: #003b73;">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" value="{{ $filtros['fecha_inicio'] ?? '' }}"
                                   class="form-control form-control-sm"
                                   style="border: 2px solid #bfd9ea; border-radius: 8px;">
                        </div>

                        <!-- Filtro Fecha Fin -->
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold" style="color: #003b73;">Fecha Fin</label>
                            <input type="date" name="fecha_fin" value="{{ $filtros['fecha_fin'] ?? '' }}"
                                   class="form-control form-control-sm"
                                   style="border: 2px solid #bfd9ea; border-radius: 8px;">
                        </div>

                        <!-- Botones -->
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); border-radius: 8px;">
                                <i class="fas fa-filter me-1"></i>Filtrar
                            </button>
                            <a href="{{ route('observaciones.index') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; border-radius: 8px;">
                                <i class="fas fa-times me-1"></i>Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Barra de resumen compacto -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-list" style="color: #00508f; font-size: 0.9rem;"></i>
                        <span class="small"><strong style="color: #00508f;">{{ $observaciones->total() }}</strong> <span class="text-muted">registros totales</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Observaciones -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Estudiante</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Profesor</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Descripción</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Tipo</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Fecha</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($observaciones as $obs)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;">
                                <td class="px-3 py-2">
                                    <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $obs->estudiante->nombreCompleto }}</div>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="small" style="color: #00508f; font-size: 0.85rem;">{{ $obs->profesor->nombreCompleto }}</span>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="small" style="color: #003b73; font-size: 0.85rem;">{{ $obs->descripcion }}</span>
                                </td>
                                <td class="px-3 py-2">
                                    @if($obs->tipo === 'positivo')
                                        <span class="badge rounded-pill" style="background: rgba(76, 175, 80, 0.2); color: #2e7d32; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4caf50; font-size: 0.75rem;">
                                            <i class="fas fa-circle" style="font-size: 0.4rem; color: #4caf50;"></i> Positivo
                                        </span>
                                    @else
                                        <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.75rem;">
                                            <i class="fas fa-circle" style="font-size: 0.4rem;"></i> Negativo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    <span class="small text-muted" style="font-size: 0.85rem;">{{ $obs->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="px-3 py-2 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('observaciones.edit', $obs) }}"
                                           class="btn btn-sm"
                                           style="border-radius: 6px 0 0 6px; border: 1.5px solid #4ec7d2; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                           title="Editar"
                                           onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                           onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('observaciones.destroy', $obs) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar esta observación?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm"
                                                    style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                                    title="Eliminar"
                                                    onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                                    onmouseout="this.style.background='white'; this.style.color='#ef4444';">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                        <h6 style="color: #003b73;">No hay observaciones registradas</h6>
                                        <p class="small mb-3">Comienza registrando la primera observación</p>
                                        <a href="{{ route('observaciones.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem; text-decoration: none; display: inline-block;">
                                            <i class="fas fa-plus me-1"></i>Nueva Observación
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación compacta -->
            @if($observaciones->hasPages())
                <div class="card-footer bg-white border-0 py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small" style="font-size: 0.8rem;">
                            {{ $observaciones->firstItem() }} - {{ $observaciones->lastItem() }} de {{ $observaciones->total() }}
                        </div>
                        <div>
                            {{ $observaciones->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

    @push('styles')
        <style>
            .table > :not(caption) > * > * {
                padding: 0.6rem 0.75rem;
            }

            .btn-group .btn:hover {
                transform: translateY(-1px);
                z-index: 1;
            }

            .pagination {
                margin-bottom: 0;
            }

            .pagination .page-link {
                border-radius: 6px;
                margin: 0 2px;
                border: 1px solid #e2e8f0;
                color: #00508f;
                transition: all 0.3s ease;
                padding: 0.3rem 0.6rem;
                font-size: 0.85rem;
            }

            .pagination .page-link:hover {
                background: #bfd9ea;
                border-color: #4ec7d2;
                color: #003b73;
            }

            .pagination .page-item.active .page-link {
                background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                border-color: #4ec7d2;
                color: white;
            }

            .table tbody tr:hover {
                background-color: rgba(191, 217, 234, 0.08);
            }

            .btn-back:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
            }

            .form-control-sm, .form-select-sm {
                border-radius: 6px;
                border: 2px solid #bfd9ea;
                padding: 0.5rem 0.75rem;
                transition: all 0.3s ease;
                font-size: 0.875rem;
            }

            .form-control-sm:focus, .form-select-sm:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.15);
            }

            .form-label {
                color: #003b73;
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }
        </style>
    @endpush
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> dev/valeska
