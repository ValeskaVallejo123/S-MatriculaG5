@extends('layouts.app')

@section('title', 'Visualización de Calificaciones')

@section('page-title', 'Calificaciones')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1400px;">

        <!-- Barra de resumen compacto -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="row align-items-center g-2">
                    <!-- Resumen compacto -->
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-4">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-book" style="color: #00508f; font-size: 0.9rem;"></i>
                                    <span class="small"><strong style="color: #00508f;">{{ count($calificaciones) }}</strong> <span class="text-muted">Calificaciones</span></span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-chart-line" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                                    <span class="small"><strong style="color: #4ec7d2;">{{ $promedio ? number_format($promedio, 2) : 'N/A' }}</strong> <span class="text-muted">Promedio</span></span>
                                </div>
                            </div>
                            <button class="btn btn-sm" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem;">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros compactos -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('calificaciones.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label for="periodo_id" class="form-label fw-semibold small mb-1" style="color: #003b73; font-size: 0.85rem;">Período académico</label>
                        <div class="position-relative">
                            <i class="fas fa-calendar-alt position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #4ec7d2; font-size: 0.9rem;"></i>
                            <select name="periodo_id" id="periodo_id" class="form-select form-select-sm ps-5" style="border: 1.5px solid #e2e8f0; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                                <option value="">Todos</option>
                                @foreach($periodos as $p)
                                    <option value="{{ $p->id }}" {{ request('periodo_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nombre_periodo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label for="materia_id" class="form-label fw-semibold small mb-1" style="color: #003b73; font-size: 0.85rem;">Materia</label>
                        <div class="position-relative">
                            <i class="fas fa-book-open position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #4ec7d2; font-size: 0.9rem;"></i>
                            <select name="materia_id" id="materia_id" class="form-select form-select-sm ps-5" style="border: 1.5px solid #e2e8f0; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                                <option value="">Todas</option>
                                @foreach($materias as $m)
                                    <option value="{{ $m->id }}" {{ request('materia_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm w-100 fw-semibold" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.5rem; border-radius: 8px;">
                            <i class="fas fa-filter me-1"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla compacta de Calificaciones -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="calificacionesTable">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Materia</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Período</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Nota</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Rendimiento</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($calificaciones as $c)
                            @php
                                $rendimiento = $c->nota >= 85 ? 'Excelente' : ($c->nota >= 70 ? 'Bueno' : 'Bajo');
                                $estadoBg = $c->nota < 70 ? 'rgba(244, 67, 54, 0.1)' : ($c->nota >= 85 ? 'rgba(76, 175, 80, 0.1)' : 'rgba(255, 193, 7, 0.1)');
                                $estadoColor = $c->nota < 70 ? '#d32f2f' : ($c->nota >= 85 ? '#388e3c' : '#f57f17');
                                $estadoIcon = $c->nota < 70 ? 'fa-times-circle' : ($c->nota >= 85 ? 'fa-check-circle' : 'fa-minus-circle');
                            @endphp
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;" class="calificacion-row">
                                <td class="px-3 py-2">
                                    <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $c->materia->nombre }}</div>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">{{ $c->periodo->nombre_periodo }}</span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="fw-bold" style="font-size: 1rem; color: #003b73;">{{ $c->nota }}</span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="small" style="color: #666; font-weight: 500;">{{ $rendimiento }}</span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="badge rounded-pill" style="background: {{ $estadoBg }}; color: {{ $estadoColor }}; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid {{ $estadoColor }}; font-size: 0.75rem;">
                                        <i class="fas {{ $estadoIcon }}" style="font-size: 0.4rem;"></i> {{ $c->nota }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                        <h6 style="color: #003b73;">No hay calificaciones registradas</h6>
                                        <p class="small mb-0">Intenta seleccionar otro período o materia</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Promedio general -->
            <div class="card-footer bg-white border-0 py-3 px-3" style="border-top: 1px solid #f1f5f9;">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-chart-pie" style="color: #00508f; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #003b73;">Promedio General:</strong></span>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        @php
                            $promedioColor = $promedio >= 85 ? '#388e3c' : ($promedio >= 70 ? '#f57f17' : '#d32f2f');
                        @endphp
                        <span class="fw-bold" style="font-size: 1.1rem; color: {{ $promedioColor }};">
                            {{ $promedio ? number_format($promedio, 2) : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .form-select-sm {
                border-radius: 8px;
                border: 1.5px solid #e2e8f0;
                padding: 0.5rem 0.75rem;
                transition: all 0.3s ease;
                font-size: 0.875rem;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2300508f' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right 0.5rem center;
                background-size: 1.5em 1.5em;
                padding-right: 2.5rem;
            }

            .form-select-sm:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.15);
                outline: none;
            }

            .form-label {
                color: #003b73;
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }

            .table > :not(caption) > * > * {
                padding: 0.6rem 0.75rem;
            }

            .table tbody tr:hover {
                background-color: rgba(191, 217, 234, 0.08);
            }

            .btn-back:hover {
                background: #00508f !important;
                color: white !important;
                transform: translateY(-2px);
            }

            button[type="submit"]:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
            }

            .badge {
                font-weight: 600;
                transition: all 0.2s ease;
            }

            .badge:hover {
                transform: scale(1.05);
            }

            .no-results {
                display: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.querySelector('form');
                const table = document.getElementById('calificacionesTable');

                filterForm.addEventListener('change', function() {
                    filterForm.submit();
                });
            });
        </script>
    @endpush
@endsection
