@extends('layouts.app')

@section('title', 'Matrículas')

@section('page-title', 'Gestión de Matrículas')

@section('topbar-actions')
    <a href="{{ route('matriculas.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nueva Matrícula
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

<<<<<<< HEAD
    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <!-- Total -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Total</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $counts['total'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">Matrículas</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pendientes -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Pendientes</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $counts['pendiente'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">En proceso</p>
                </div>
                <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Aprobadas -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Aprobadas</p>
                    <p class="text-3xl font-bold text-green-600">{{ $counts['aprobada'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">Confirmadas</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Rechazadas -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Rechazadas</p>
                    <p class="text-3xl font-bold text-red-600">{{ $counts['rechazada'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">No aprobadas</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado de Matrículas -->
    <div class="space-y-3">
        <!-- Header del Listado -->
        <div class="bg-white rounded-lg shadow-sm px-5 py-3 border border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-800">Listado Completo</h2>
                <span class="text-xs font-medium text-gray-600">{{ $matriculas?->total() ?? 0 }} matrículas</span>
            </div>
        </div>

        <!-- Lista de Matrículas en Cards -->
        @forelse($matriculas ?? [] as $matricula)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-teal-300 transition-all">
                <div class="p-4">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        <!-- Información del Estudiante -->
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                <span class="text-white font-bold text-base">
                                    @if($matricula->estudiante)
                                        {{ strtoupper(substr($matricula->estudiante->nombre,0,1) . substr($matricula->estudiante->apellido ?? '',0,1)) }}
                                    @else
                                        ?
                                    @endif
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 truncate">
                                    {{ $matricula->estudiante->nombre_completo ?? 'N/A' }}
                                </h3>
                                <div class="flex flex-wrap items-center gap-3 mt-1">
                                    <span class="text-xs text-gray-600 flex items-center gap-1">
                                        Código: <span class="font-mono font-semibold">{{ $matricula->codigo ?? 'N/A' }}</span>
                                    </span>
                                    @if($matricula->estudiante && $matricula->estudiante->dni)
                                        <span class="text-xs text-gray-500">•</span>
                                        <span class="text-xs text-gray-600">DNI: {{ $matricula->estudiante->dni }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div>
                            @php
                                $estadoColor = match($matricula->estado ?? 'pendiente') {
                                    'pendiente' => 'yellow',
                                    'aprobada' => 'green',
                                    'rechazada' => 'red',
                                    default => 'gray'
                                };
                            @endphp
                            <span class="inline-block px-3 py-1 bg-{{ $estadoColor }}-50 text-{{ $estadoColor }}-700 rounded-full text-xs font-semibold border border-{{ $estadoColor }}-200">
                                {{ ucfirst($matricula->estado ?? 'Pendiente') }}
                            </span>
                        </div>

                        <!-- Acciones -->
                        <div class="flex items-center gap-2 lg:justify-end">
                            <a href="{{ route('matriculas.show', $matricula) }}" class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-xs font-medium border border-blue-200">Ver</a>
                            <a href="{{ route('matriculas.edit', $matricula) }}" class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-lg hover:bg-amber-100 transition text-xs font-medium border border-amber-200">Editar</a>

                            @if(($matricula->estado ?? 'pendiente') === 'pendiente')
                                <form action="{{ route('matriculas.confirm', $matricula) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="px-3 py-1.5 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition text-xs font-medium border border-green-200">
                                        Confirmar
                                    </button>
                                </form>
                            @endif

                            <button onclick="confirmDelete('{{ $matricula->id }}', '{{ $matricula->codigo ?? '' }}')"
                                    class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition text-xs font-medium border border-red-200">
                                Eliminar
                            </button>

                            <form id="delete-form-{{ $matricula->id ?? 0 }}"
                                  action="{{ route('matriculas.destroy', $matricula ?? 0) }}"
                                  method="POST"
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
=======
    <!-- Resumen de matrículas -->
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clipboard-check" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Total Matriculados</p>
                            <h4 class="mb-0 fw-bold" style="color: #003b73;">{{ $matriculas->total() }}</h4>
>>>>>>> origin/dev/valeska
                        </div>
                    </div>
                </div>
            </div>
<<<<<<< HEAD
        @empty
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <h3 class="text-base font-semibold text-gray-900 mb-1">No hay matrículas</h3>
                <p class="text-gray-500 text-sm mb-4">Registre la primera matrícula al sistema</p>
            </div>
        @endforelse

        
    </div>
</div>

<!-- Modal de Confirmación -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
        <div class="bg-red-50 px-6 py-4 border-b border-red-100 rounded-t-xl flex items-center gap-3">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Confirmar Eliminación</h3>
                <p class="text-xs text-gray-600 mt-1">Esta acción no se puede deshacer.</p>
            </div>
=======
        </div>
    </div>

    <!-- Lista de matrículas -->
    @forelse($matriculas as $matricula)
    <div class="card border-0 shadow-sm mb-2" style="border-radius: 10px; transition: all 0.2s ease;">
        <div class="card-body p-2">
            <div class="row align-items-center g-2">
                
                <!-- Avatar y Datos -->
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #4ec7d2;">
                            <span class="text-white fw-bold" style="font-size: 0.95rem;">
                                {{ strtoupper(substr($matricula->nombre, 0, 1) . substr($matricula->apellido ?? '', 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="mb-0 fw-semibold text-truncate" style="color: #003b73; font-size: 0.9rem;">
                                {{ $matricula->nombre }} {{ $matricula->apellido }}
                            </h6>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="fas fa-id-card me-1"></i>{{ $matricula->dni ?? 'Sin DNI' }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Grado y Sección -->
                <div class="col-lg-4">
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.7rem;">
                            <i class="fas fa-graduation-cap me-1"></i>{{ $matricula->grado }}
                        </span>
                        <span class="badge" style="background: rgba(0, 59, 115, 0.1); color: #003b73; border: 1px solid #00508f; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.7rem;">
                            Sección {{ $matricula->seccion }}
                        </span>
                    </div>
                </div>

                <!-- Estado y Acciones -->
                <div class="col-lg-3">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.7rem;">
                            <i class="fas fa-circle" style="font-size: 0.4rem; color: #4ec7d2;"></i> Activo
                        </span>

                        <div class="btn-group" role="group">
                            <a href="{{ route('matriculas.show', $matricula) }}" 
                               class="btn btn-sm" 
                               style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                               title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('matriculas.edit', $matricula) }}" 
                               class="btn btn-sm" 
                               style="border-radius: 0 6px 6px 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @empty
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body text-center py-4">
                <i class="fas fa-clipboard-list mb-2" style="font-size: 2rem; color: #00508f; opacity: 0.5;"></i>
                <h6 style="color: #003b73;">No hay matrículas registradas</h6>
                <p class="text-muted small mb-3">Comienza registrando la primera matrícula</p>
                <a href="{{ route('matriculas.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem 1.2rem; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                    <i class="fas fa-plus me-1"></i>Nueva Matrícula
                </a>
            </div>
>>>>>>> origin/dev/valeska
        </div>
    @endforelse

    <!-- Paginación -->
    @if($matriculas->hasPages())
    <div class="card border-0 shadow-sm mt-2" style="border-radius: 10px;">
        <div class="card-body py-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small" style="font-size: 0.8rem;">
                    {{ $matriculas->firstItem() }} - {{ $matriculas->lastItem() }} de {{ $matriculas->total() }}
                </div>
                <div>
                    {{ $matriculas->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
<<<<<<< HEAD

<script>
function confirmDelete(id, code) {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    document.getElementById('matriculaCode').innerText = code ?? '';

    const btn = document.getElementById('confirmDeleteBtn');
    btn.onclick = function() {
        document.getElementById('delete-form-' + id).submit();
    }
}

function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
=======
@endsection
>>>>>>> origin/dev/valeska
