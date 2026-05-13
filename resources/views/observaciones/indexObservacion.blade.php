@extends('layouts.app')

@section('title', 'Observaciones Conductuales')
@section('page-title', 'Gestión de Observaciones')

@section('topbar-actions')
    <a href="{{ route('observaciones.create') }}"
       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem;
              border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex;
              align-items: center; gap: 0.5rem; border: none; font-size: 0.9rem;">
        <i class="fas fa-plus"></i> Nueva Observacion
    </a>
@endsection

@section('content')

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert border-0 mb-3" style="background: rgba(76, 175, 80, 0.1); border-left: 3px solid #4caf50 !important; border-radius: 8px;">
            <div class="d-flex align-items-start">
                <i class="fas fa-check-circle me-2 mt-1" style="font-size: 0.9rem; color: #4caf50;"></i>
                <strong style="color: #2e7d32;">{{ session('success') }}</strong>
            </div>
        </div>
    @endif

    {{-- Filtros --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('observaciones.index') }}">
                <div class="row align-items-end g-2">

                    <div class="col-md-3">
                        <label class="form-label small fw-semibold" style="color: #003b73;">Estudiante</label>
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                            <input type="text" name="nombre" value="{{ $filtros['nombre'] ?? '' }}"
                                   placeholder="Buscar por nombre"
                                   class="form-control form-control-sm ps-5"
                                   style="border: 2px solid #bfd9ea; border-radius: 8px; height: 38px;">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold" style="color: #003b73;">Tipo</label>
                        <select name="tipo" class="form-select form-select-sm"
                                style="border: 2px solid #bfd9ea; border-radius: 8px; height: 38px;">
                            <option value="">Todos</option>
                            <option value="academica"  @selected(($filtros['tipo'] ?? '') === 'academica')>Academica</option>
                            <option value="conductual" @selected(($filtros['tipo'] ?? '') === 'conductual')>Conductual</option>
                            <option value="salud"      @selected(($filtros['tipo'] ?? '') === 'salud')>Salud</option>
                            <option value="otro"       @selected(($filtros['tipo'] ?? '') === 'otro')>Otro</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold" style="color: #003b73;">Fecha Inicio</label>
                        <input type="date" name="fecha_desde" value="{{ $filtros['fecha_desde'] ?? '' }}"
                               class="form-control form-control-sm"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; height: 38px;">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold" style="color: #003b73;">Fecha Fin</label>
                        <input type="date" name="fecha_hasta" value="{{ $filtros['fecha_hasta'] ?? '' }}"
                               class="form-control form-control-sm"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; height: 38px;">
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill"
                                style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none;
                                       border-radius: 8px; height: 38px;">
                            <i class="fas fa-filter me-1"></i>Filtrar
                        </button>
                        <a href="{{ route('observaciones.index') }}" class="btn btn-sm fw-semibold flex-fill"
                           style="border: 2px solid #00508f; color: #00508f; background: white; border-radius: 8px; height: 38px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-times me-1"></i>Limpiar
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Barra resumen --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list" style="color: #00508f; font-size: 0.9rem;"></i>
                <span class="small">
                    <strong style="color: #00508f;">{{ $observaciones->total() }}</strong>
                    <span class="text-muted">registros totales</span>
                </span>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73; width: 20%;">Estudiante</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73; width: 15%;">Profesor</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73; width: 35%;">Descripcion</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73; width: 10%;">Tipo</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73; width: 10%;">Fecha</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem; color: #003b73; width: 10%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($observaciones as $obs)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td class="px-3 py-2">
                                <div class="fw-semibold" style="color: #003b73; font-size: 0.875rem;">
                                    {{ $obs->estudiante->nombreCompleto ?? '—' }}
                                </div>
                            </td>
                            <td class="px-3 py-2">
                                <span style="color: #00508f; font-size: 0.875rem;">
                                    {{ $obs->profesor->nombreCompleto ?? '—' }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                <span style="color: #003b73; font-size: 0.875rem;">
                                    {{ Str::limit($obs->descripcion, 80) }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                @php
                                    $tipoConfig = match($obs->tipo) {
                                        'academica'  => ['label' => 'Academica',  'bg' => 'rgba(33,150,243,0.12)',  'color' => '#0d47a1', 'border' => '#2196f3'],
                                        'conductual' => ['label' => 'Conductual', 'bg' => 'rgba(239,68,68,0.12)',   'color' => '#991b1b', 'border' => '#ef4444'],
                                        'salud'      => ['label' => 'Salud',      'bg' => 'rgba(76,175,80,0.12)',   'color' => '#2e7d32', 'border' => '#4caf50'],
                                        default      => ['label' => 'Otro',       'bg' => 'rgba(158,158,158,0.12)', 'color' => '#424242', 'border' => '#9e9e9e'],
                                    };
                                @endphp
                                <span class="badge rounded-pill"
                                      style="background: {{ $tipoConfig['bg'] }}; color: {{ $tipoConfig['color'] }};
                                             border: 1px solid {{ $tipoConfig['border'] }};
                                             padding: 0.3rem 0.7rem; font-weight: 600; font-size: 0.75rem;">
                                    {{ $tipoConfig['label'] }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                <span class="text-muted" style="font-size: 0.875rem;">
                                    {{ $obs->created_at->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-end">
                                {{-- Reemplaza el btn-group completo en cada fila --}}
<div class="btn-group" role="group">
    <a href="{{ route('observaciones.edit', $obs) }}"
       class="btn btn-sm"
       style="border-radius: 6px 0 0 6px; border: 1.5px solid #4ec7d2; color: #4ec7d2; background: white; padding: 0.3rem 0.65rem; font-size: 0.8rem;"
       title="Editar"
       onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
       onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button"
            class="btn btn-sm"
            style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.65rem; font-size: 0.8rem;"
            title="Eliminar"
            onmouseover="this.style.background='#ef4444'; this.style.color='white';"
            onmouseout="this.style.background='white'; this.style.color='#ef4444';"
            onclick="mostrarModalDelete(
                '{{ route('observaciones.destroy', $obs) }}',
                '¿Estas seguro de eliminar esta observacion? Esta accion no se puede deshacer.',
                '{{ Str::limit($obs->descripcion, 40) }}'
            )">
        <i class="fas fa-trash"></i>
    </button>
</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-2x mb-2 d-block" style="color: #00508f; opacity: 0.5;"></i>
                                <h6 style="color: #003b73;">No hay observaciones registradas</h6>
                                <p class="small text-muted mb-3">Comienza registrando la primera observacion</p>
                                <a href="{{ route('observaciones.create') }}" class="btn btn-sm"
                                   style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem;">
                                    <i class="fas fa-plus me-1"></i>Nueva Observacion
                                </a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginacion --}}
        @if($observaciones->count())
            <div class="card-footer bg-white border-0 py-2 px-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small" style="font-size: 0.8rem;">
                        Mostrando {{ $observaciones->firstItem() }} - {{ $observaciones->lastItem() }}
                        de {{ $observaciones->total() }} registros
                    </div>
                    <div>{{ $observaciones->links() }}</div>
                </div>
            </div>
        @endif
    </div>

@push('styles')
<style>
    .pagination { margin-bottom: 0; }
    .pagination .page-link {
        border-radius: 6px; margin: 0 2px;
        border: 1px solid #e2e8f0; color: #00508f;
        transition: all 0.3s ease; padding: 0.3rem 0.6rem; font-size: 0.85rem;
    }
    .pagination .page-link:hover { background: #bfd9ea; border-color: #4ec7d2; color: #003b73; }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        border-color: #4ec7d2; color: white;
    }
    .table tbody tr:hover { background-color: rgba(191, 217, 234, 0.08); }
    .form-control-sm:focus, .form-select-sm:focus {
        border-color: #4ec7d2 !important;
        box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.15) !important;
    }
    .btn-group .btn:hover { transform: translateY(-1px); z-index: 1; }
</style>
@endpush

@endsection
