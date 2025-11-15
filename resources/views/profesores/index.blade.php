@extends('layouts.app')

@section('title', 'Profesores')

@section('page-title', 'Gestión de Profesores')

@section('topbar-actions')
    <a href="{{ route('profesores.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo Profesor
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1400px;">

        <!-- Barra de búsqueda y resumen compacto -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="row align-items-center g-2">
                    <!-- Buscador -->
                    <div class="col-md-6">
                        <form action="{{ route('profesores.index') }}" method="GET" class="d-flex gap-2">
                            <div class="position-relative flex-grow-1">
                                <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                                <input type="text"
                                       name="busqueda"
                                       value="{{ request('busqueda') }}"
                                       id="searchInput"
                                       class="form-control form-control-sm ps-5"
                                       placeholder="Buscar por nombre, DNI, email..."
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                            </div>
                            <button type="submit" class="btn btn-sm" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem;">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('busqueda'))
                                <a href="{{ route('profesores.index') }}" class="btn btn-sm" style="border: 2px solid #ef4444; color: #ef4444; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem;">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Resumen compacto -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-md-end gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-chalkboard-teacher" style="color: #00508f; font-size: 0.9rem;"></i>
                                <span class="small"><strong style="color: #00508f;">{{ $profesores->total() }}</strong> <span class="text-muted">Total</span></span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                                <span class="small"><strong style="color: #4ec7d2;">{{ $profesores->where('estado', 'activo')->count() }}</strong> <span class="text-muted">Activos</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(request('busqueda'))
                    <div class="mt-2 pt-2 border-top">
                        <p class="small mb-0">
                            @if($profesores->total() > 0)
                                <span class="text-muted">Mostrando <strong>{{ $profesores->total() }}</strong> resultado(s) para:</span>
                                <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; font-size: 0.75rem;">{{ request('busqueda') }}</span>
                            @else
                                <span class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>No se encontraron resultados para: <strong>"{{ request('busqueda') }}"</strong></span>
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Lista de Profesores -->
        @forelse($profesores as $profesor)
            <div class="card border-0 shadow-sm mb-2" style="border-radius: 10px; transition: all 0.2s ease;">
                <div class="card-body p-2">
                    <div class="row align-items-center g-2">

                        <!-- Avatar y Datos -->
                        <div class="col-lg-5">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #4ec7d2;">
                            <span class="text-white fw-bold" style="font-size: 0.95rem;">
                                {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
                            </span>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="mb-0 fw-semibold text-truncate" style="color: #003b73; font-size: 0.9rem;">{{ $profesor->nombre_completo }}</h6>
                                    <div class="d-flex flex-wrap gap-2 align-items-center">
                                        @if($profesor->email)
                                            <small class="text-muted text-truncate" style="max-width: 180px; font-size: 0.75rem;">
                                                <i class="fas fa-envelope me-1" style="font-size: 0.7rem;"></i>{{ $profesor->email }}
                                            </small>
                                        @endif
                                        @if($profesor->dni)
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                <i class="fas fa-id-card me-1" style="font-size: 0.7rem;"></i>{{ $profesor->dni }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Especialidad y Tipo de Contrato -->
                        <div class="col-lg-4">
                            <div class="d-flex flex-wrap gap-1">
                                @if($profesor->especialidad)
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.7rem;">
                            <i class="fas fa-book me-1" style="font-size: 0.65rem;"></i>{{ $profesor->especialidad }}
                        </span>
                                @endif
                                @if($profesor->tipo_contrato)
                                    <span class="badge" style="background: rgba(0, 59, 115, 0.1); color: #003b73; border: 1px solid #00508f; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.7rem;">
                            <i class="fas fa-file-contract me-1" style="font-size: 0.65rem;"></i>{{ ucwords(str_replace('_', ' ', $profesor->tipo_contrato)) }}
                        </span>
                                @endif
                            </div>
                        </div>

                        <!-- Estado y Acciones -->
                        <div class="col-lg-3">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <!-- Badge de Estado -->
                                @if($profesor->estado === 'activo')
                                    <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.7rem;">
                                <i class="fas fa-circle" style="font-size: 0.4rem; color: #4ec7d2;"></i> Activo
                            </span>
                                @elseif($profesor->estado === 'licencia')
                                    <span class="badge rounded-pill" style="background: #fef3c7; color: #92400e; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #fde68a; font-size: 0.7rem;">
                                <i class="fas fa-clock" style="font-size: 0.4rem;"></i> Licencia
                            </span>
                                @else
                                    <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.7rem;">
                                <i class="fas fa-circle" style="font-size: 0.4rem;"></i> Inactivo
                            </span>
                                @endif

                                <!-- Botones de Acción -->
                                <div class="btn-group" role="group">
                                    <a href="{{ route('profesores.show', $profesor) }}"
                                       class="btn btn-sm"
                                       style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                       title="Ver"
                                       onmouseover="this.style.background='#00508f'; this.style.color='white';"
                                       onmouseout="this.style.background='white'; this.style.color='#00508f';">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('profesores.edit', $profesor) }}"
                                       class="btn btn-sm"
                                       style="border-radius: 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                       title="Editar"
                                       onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                       onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ $profesor->id }}', '{{ $profesor->nombre_completo }}')"
                                            class="btn btn-sm"
                                            style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                            title="Eliminar"
                                            onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                            onmouseout="this.style.background='white'; this.style.color='#ef4444';">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Form oculto para eliminar -->
                                <form id="delete-form-{{ $profesor->id }}"
                                      action="{{ route('profesores.destroy', $profesor) }}"
                                      method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <!-- Mensaje sin resultados -->
            @if(request('busqueda'))
                <div class="card border-0 shadow-sm" style="border-radius: 10px; background: rgba(239, 68, 68, 0.05); border-left: 3px solid #ef4444 !important;">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-search mb-2" style="font-size: 2rem; color: #ef4444; opacity: 0.5;"></i>
                        <h6 class="fw-bold mb-1" style="color: #991b1b;">Profesor no encontrado</h6>
                        <p class="text-muted small mb-3">No se encontró ningún profesor con: <strong class="text-danger">"{{ request('busqueda') }}"</strong></p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('profesores.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem 1rem;">
                                <i class="fas fa-list me-1"></i>Ver todos
                            </a>
                            <a href="{{ route('profesores.create') }}" class="btn btn-sm" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 8px; padding: 0.5rem 1rem;">
                                <i class="fas fa-plus me-1"></i>Crear nuevo
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-chalkboard-teacher mb-2" style="font-size: 2rem; color: #00508f; opacity: 0.5;"></i>
                        <h6 style="color: #003b73;">No hay profesores registrados</h6>
                        <p class="text-muted small mb-3">Comienza agregando el primer profesor</p>
                        <a href="{{ route('profesores.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem 1.2rem; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                            <i class="fas fa-plus me-1"></i>Crear Profesor
                        </a>
                    </div>
                </div>
            @endif
        @endforelse

        <!-- Paginación compacta -->
        @if($profesores->hasPages())
            <div class="card border-0 shadow-sm mt-2" style="border-radius: 10px;">
                <div class="card-body py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small" style="font-size: 0.8rem;">
                            {{ $profesores->firstItem() }} - {{ $profesores->lastItem() }} de {{ $profesores->total() }}
                        </div>
                        <div>
                            {{ $profesores->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
                <div class="modal-header border-0" style="background: rgba(239, 68, 68, 0.1); padding: 1.2rem;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 40px; height: 40px; background: rgba(239, 68, 68, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle" style="color: #ef4444; font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0 fw-bold" style="color: #003b73;">Confirmar Eliminación</h5>
                            <p class="mb-0 small text-muted">Esta acción no se puede deshacer</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <p class="mb-2" style="color: #003b73; font-size: 0.95rem;">
                        ¿Está seguro que desea eliminar al profesor <strong id="profesorNombre" style="color: #ef4444;"></strong>?
                    </p>
                    <p class="text-muted small mb-0">Se perderán todos los datos asociados a este profesor.</p>
                </div>
                <div class="modal-footer border-0" style="background: #f8f9fa; padding: 1rem 1.5rem;">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600;">
                        Cancelar
                    </button>
                    <button type="button" onclick="submitDelete()" class="btn btn-sm" style="background: #ef4444; color: white; border: none; padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);">
                        Sí, Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
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

        .card:hover {
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        #searchInput:focus {
            border-color: #4ec7d2;
            box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
            outline: none;
        }

        button[style*="border: 2px solid #4ec7d2"]:hover {
            background: #4ec7d2 !important;
            color: white !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let currentDeleteId = null;
        let deleteModal = null;

        document.addEventListener('DOMContentLoaded', function() {
            deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        });

        function confirmDelete(id, nombre) {
            currentDeleteId = id;
            document.getElementById('profesorNombre').textContent = nombre;
            deleteModal.show();
        }

        function submitDelete() {
            if (currentDeleteId) {
                document.getElementById('delete-form-' + currentDeleteId).submit();
            }
        }
    </script>
@endpush
