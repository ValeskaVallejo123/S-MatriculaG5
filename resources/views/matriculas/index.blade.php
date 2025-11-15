@extends('layouts.app')

@section('title', 'Matrículas')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Encabezado con Acción -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Matrículas</h1>
            <p class="text-sm text-gray-600 mt-0.5">Gestión de matrículas de estudiantes</p>
        </div>
        <a href="{{ route('matriculas.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-teal-600 text-white px-4 py-2.5 rounded-lg hover:bg-teal-700 font-medium transition text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Matrícula
        </a>
    </div>

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
                        </div>
                    </div>
                </div>
            </div>
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
        </div>
        <div class="px-6 py-4">
            <p class="text-gray-700">¿Está seguro que desea eliminar la matrícula con código <span id="matriculaCode" class="font-mono font-semibold"></span>?</p>
        </div>
        <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end gap-3">
            <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                Cancelar
            </button>
            <button id="confirmDeleteBtn"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                Eliminar
            </button>
        </div>
    </div>
</div>

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
