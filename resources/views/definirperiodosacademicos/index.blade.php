@extends('layouts.app')

@section('title', 'Períodos Académicos')
@section('page-title', 'Períodos Académicos')

@section('topbar-actions')
    <a href="{{ route('periodos-academicos.create') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.45rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1200px;">

        <!-- Header compacto -->
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calendar-alt text-white" style="font-size: 1.2rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.05rem;">Períodos Académicos</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.82rem;">Administra los períodos escolares</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenedor principal -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">

                <!-- BOTONES alineados a la IZQUIERDA (estilo del template) -->
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('periodos-academicos.create') }}"
                       class="btn btn-sm fw-semibold d-inline-flex align-items-center"
                       style="background: linear-gradient(135deg,#004191 0%,#0b96b6 100%); color: white; padding: 0.5rem 1rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(4,64,120,0.12); text-decoration: none;">
                        <i class="fas fa-plus me-2"></i> Crear nuevo período
                    </a>


                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto rounded-xl shadow-sm">
                    <table class="table" style="width:100%; border-collapse:collapse;">
                        <thead>
                        <tr style="background:#4E8EA2; color:white; text-transform:uppercase; font-size:0.82rem;">
                            <th class="px-4 py-3 text-start">Nombre</th>
                            <th class="px-4 py-3 text-start">Tipo</th>
                            <th class="px-4 py-3 text-start">Inicio</th>
                            <th class="px-4 py-3 text-start">Fin</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody style="font-size:0. nine rem; color:#374151;">
                        @forelse($periodos as $periodo)
                            <tr style="border-bottom:1px solid #e6eef3;">
                                <td class="px-4 py-3" style="font-weight:600;">{{ $periodo->nombre_periodo }}</td>
                                <td class="px-4 py-3">{{ ucfirst($periodo->tipo) }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($periodo->fecha_inicio)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($periodo->fecha_fin)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('periodos-academicos.edit', $periodo->id) }}"
                                           class="btn btn-sm d-inline-flex align-items-center"
                                           style="background:#4E8EA2; color:white; padding:0.4rem 0.75rem; border-radius:6px; text-decoration:none; box-shadow:0 1px 6px rgba(63,124,145,0.12);">
                                            <i class="fas fa-edit me-2"></i>Editar
                                        </a>

                                        <form method="POST" action="{{ route('periodos-academicos.destroy', $periodo->id) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este período académico?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm d-inline-flex align-items-center"
                                                    style="background:#6EA2B3; color:white; padding:0.4rem 0.75rem; border-radius:6px; border:none; box-shadow:0 1px 6px rgba(90,144,161,0.12);">
                                                <i class="fas fa-trash me-2"></i>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center" style="color:#003b73; font-weight:600; font-style:italic;">
                                    No hay períodos académicos registrados aún.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Nota compacta -->
        <div class="alert border-0 mt-3 py-2 px-3" style="border-radius:8px; background:rgba(78,199,210,0.08); border-left:3px solid #4ec7d2; font-size:0. nine rem;">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1" style="color:#00508f;"></i>
                <div>
                    <strong style="color:#00508f;">Información importante:</strong>
                    <span class="text-muted"> Verifique las fechas y evite duplicados en nombres de período.</span>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .btn:hover { transform: translateY(-3px); transition: all 0.25s ease; }
        .btn-back:hover { background:#00508f !important; color:#fff !important; transform:translateY(-3px); }
        .table th, .table td { vertical-align: middle; }
        @media (max-width: 768px) {
            .d-flex.gap-3 { gap:0.5rem !important; }
        }
    </style>
@endpush
