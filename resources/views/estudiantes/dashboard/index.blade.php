@extends('layouts.app')

@section('title', 'Mi Dashboard')

@section('page-title', 'Mi Dashboard')

@section('content')
<div class="container-fluid" style="max-width: 1400px;">

    <!-- Mensaje de bienvenida -->
    <div class="welcome-card mb-4" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 15px; padding: 2rem; color: white; box-shadow: 0 10px 30px rgba(78, 199, 210, 0.3);">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="mb-2" style="font-weight: 700;">
                    <i class="fas fa-graduation-cap"></i>
                    ¡Hola, {{ auth()->user()->name }}!
                </h3>
                <p class="mb-1" style="font-size: 1rem; opacity: 0.95;">
                    <i class="far fa-calendar"></i>
                    {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </p>
                @if($estudiante)
                <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">
                    <i class="fas fa-school"></i>
                    {{ $estudiante->grado }} - Sección {{ $estudiante->seccion }}
                </p>
                @endif
            </div>
            <div class="col-md-4 text-end">
                <div class="p-3" style="background: rgba(255, 255, 255, 0.15); border-radius: 12px; backdrop-filter: blur(10px);">
                    <h2 class="mb-0" style="font-weight: 800;">{{ $promedioGeneral }}%</h2>
                    <p class="mb-0" style="font-size: 0.9rem;">Promedio General</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="row g-3 mb-4">
        <!-- Mis Materias -->
        <div class="col-lg-3 col-md-6">
            <div class="summary-card" style="background: white; border-radius: 12px; padding: 1.5rem; border-left: 4px solid #4ec7d2; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Mis Materias</p>
                        <h2 class="mb-0" style="color: #4ec7d2; font-weight: 800;">{{ $misClases }}</h2>
                        <small class="text-muted">Materias cursando</small>
                    </div>
                    <div class="icon-circle" style="width: 55px; height: 55px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(78, 199, 210, 0.3);">
                        <i class="fas fa-book-open" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promedio -->
        <div class="col-lg-3 col-md-6">
            <div class="summary-card" style="background: white; border-radius: 12px; padding: 1.5rem; border-left: 4px solid #10b981; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Mi Promedio</p>
                        <h2 class="mb-0" style="color: #10b981; font-weight: 800;">{{ $promedioGeneral }}%</h2>
                        <small class="text-muted">Calificación general</small>
                    </div>
                    <div class="icon-circle" style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-chart-line" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asistencia -->
        <div class="col-lg-3 col-md-6">
            <div class="summary-card" style="background: white; border-radius: 12px; padding: 1.5rem; border-left: 4px solid #f59e0b; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Asistencia</p>
                        <h2 class="mb-0" style="color: #f59e0b; font-weight: 800;">{{ $asistencia }}%</h2>
                        <small class="text-muted">Porcentaje de asistencia</small>
                    </div>
                    <div class="icon-circle" style="width: 55px; height: 55px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-calendar-check" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tareas Pendientes -->
        <div class="col-lg-3 col-md-6">
            <div class="summary-card" style="background: white; border-radius: 12px; padding: 1.5rem; border-left: 4px solid #ef4444; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Pendientes</p>
                        <h2 class="mb-0" style="color: #ef4444; font-weight: 800;">{{ $tareasPendientes }}</h2>
                        <small class="text-muted">Tareas por entregar</small>
                    </div>
                    <div class="icon-circle" style="width: 55px; height: 55px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);">
                        <i class="fas fa-tasks" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="row g-3">
        <!-- Mis Materias -->
        <div class="col-lg-8">
            <div class="card border-0" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #003b73; font-weight: 700;">
                            <i class="fas fa-book" style="color: #4ec7d2;"></i>
                            Mis Materias
                        </h5>
                        <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.4rem 0.8rem; border-radius: 8px;">
                            {{ count($misMaterias) }} materias
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th class="border-0 px-4 py-3" style="font-size: 0.85rem; font-weight: 700; color: #003b73;">Materia</th>
                                    <th class="border-0 px-4 py-3" style="font-size: 0.85rem; font-weight: 700; color: #003b73;">Profesor</th>
                                    <th class="border-0 px-4 py-3" style="font-size: 0.85rem; font-weight: 700; color: #003b73;">Promedio</th>
                                    <th class="border-0 px-4 py-3" style="font-size: 0.85rem; font-weight: 700; color: #003b73;">Asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($misMaterias as $materia)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-small" style="width: 40px; height: 40px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                                                <i class="fas fa-book" style="color: white; font-size: 0.9rem;"></i>
                                            </div>
                                            <span style="font-weight: 600; color: #003b73;">{{ $materia['nombre'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <small style="color: #6b7280;">
                                            <i class="fas fa-chalkboard-teacher" style="color: #4ec7d2;"></i>
                                            {{ $materia['profesor'] }}
                                        </small>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
    $colorPromedio = $materia['promedio'] >= 90 ? '#10b981' : ($materia['promedio'] >= 70 ? '#f59e0b' : '#ef4444');
    $estiloPromedio = 'background: ' . $colorPromedio . '; color: white; padding: 0.4rem 0.7rem; border-radius: 8px; font-weight: 700;';
@endphp
<span class="badge" style="<?php echo $estiloPromedio; ?>">
    {{ $materia['promedio'] }}%
</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="progress" style="height: 8px; border-radius: 10px; background: #e5e7eb;">
                                            @php $anchoAsistencia = $materia['asistencia']; @endphp
                                            <div class="progress-bar" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); width: <?php echo $anchoAsistencia; ?>%; border-radius: 10px;"></div>
                                        </div>
                                        <small class="text-muted">{{ $materia['asistencia'] }}%</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tareas Próximas -->
            <div class="card border-0 mt-3" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-clipboard-list" style="color: #ef4444;"></i>
                        Tareas Próximas
                    </h5>
                </div>
                <div class="card-body p-3">
                    @if(count($tareasProximas) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($tareasProximas as $tarea)
                            <div class="list-group-item border-0 px-2 py-3" style="background: #f8f9fa; border-radius: 10px; margin-bottom: 0.5rem;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1" style="color: #003b73; font-weight: 700;">
                                            {{ $tarea['titulo'] }}
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-book" style="color: #4ec7d2;"></i>
                                            {{ $tarea['materia'] }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-warning text-dark" style="border-radius: 8px; padding: 0.4rem 0.7rem;">
                                            <i class="far fa-calendar"></i>
                                            {{ \Carbon\Carbon::parse($tarea['fecha_entrega'])->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle" style="font-size: 3rem; color: #10b981;"></i>
                            <p class="text-muted mt-3 mb-0">¡No tienes tareas pendientes!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Rendimiento -->
            <div class="card border-0" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-trophy" style="color: #f59e0b;"></i>
                        Mi Rendimiento
                    </h5>
                </div>
                <div class="card-body p-3">
                    <!-- Promedio General -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="font-weight: 600; color: #003b73;">Promedio General</span>
                            <span style="font-weight: 700; color: #10b981;">{{ $promedioGeneral }}%</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 10px;">
                            @php $anchoPromedio = $promedioGeneral; @endphp
                            <div class="progress-bar" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); width: <?php echo $anchoPromedio; ?>%; border-radius: 10px;"></div>
                        </div>
                    </div>

                    <!-- Asistencia -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="font-weight: 600; color: #003b73;">Asistencia</span>
                            <span style="font-weight: 700; color: #f59e0b;">{{ $asistencia }}%</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 10px;">
                            @php $anchoAsist = $asistencia; @endphp
                            <div class="progress-bar" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); width: <?php echo $anchoAsist; ?>%; border-radius: 10px;"></div>
                        </div>
                    </div>

                    <!-- Estado General -->
                    <div class="p-3 text-center" style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%); border-radius: 12px; border: 2px dashed #4ec7d2;">
                        @if($promedioGeneral >= 90)
                            <i class="fas fa-star" style="font-size: 2.5rem; color: #f59e0b;"></i>
                            <h6 class="mt-2 mb-0" style="color: #003b73; font-weight: 700;">¡Excelente Trabajo!</h6>
                            <small class="text-muted">Sigue así, lo estás haciendo genial</small>
                        @elseif($promedioGeneral >= 70)
                            <i class="fas fa-thumbs-up" style="font-size: 2.5rem; color: #10b981;"></i>
                            <h6 class="mt-2 mb-0" style="color: #003b73; font-weight: 700;">¡Buen Rendimiento!</h6>
                            <small class="text-muted">Continúa esforzándote</small>
                        @else
                            <i class="fas fa-battery-half" style="font-size: 2.5rem; color: #f59e0b;"></i>
                            <h6 class="mt-2 mb-0" style="color: #003b73; font-weight: 700;">Puedes Mejorar</h6>
                            <small class="text-muted">¡No te rindas!</small>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="card border-0 mt-3" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-bolt" style="color: #fee140;"></i>
                        Accesos Rápidos
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-lg text-start" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 10px; padding: 1rem; border: none; font-weight: 600; box-shadow: 0 4px 15px rgba(78, 199, 210, 0.3);">
                            <i class="fas fa-chart-line me-2"></i>
                            Ver Mis Calificaciones
                        </a>
                        <a href="#" class="btn btn-lg text-start" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 10px; padding: 1rem; border: none; font-weight: 600; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-calendar-check me-2"></i>
                            Mi Asistencia
                        </a>
                        <a href="#" class="btn btn-lg text-start" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 10px; padding: 1rem; border: none; font-weight: 600; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-book-reader me-2"></i>
                            Material de Estudio
                        </a>
                        <a href="#" class="btn btn-lg text-start" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 10px; padding: 1rem; border: none; font-weight: 600; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);">
                            <i class="fas fa-inbox me-2"></i>
                            Mis Tareas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
    }

    .welcome-card {
        position: relative;
        overflow: hidden;
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .table tbody tr:hover {
        background-color: rgba(78, 199, 210, 0.05);
    }

    .icon-circle {
        transition: transform 0.3s ease;
    }

    .summary-card:hover .icon-circle {
        transform: scale(1.1) rotate(5deg);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.6s ease;
    }

    .bg-gradient-custom {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%) !important;
    }
</style>
@endpush
@endsection
