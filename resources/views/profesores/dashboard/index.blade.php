@extends('layouts.app')

@section('title', 'Mi Dashboard')

@section('page-title', 'Dashboard del Profesor')

@section('content')
<div class="container-fluid" style="max-width: 1400px;">

    <!-- Mensaje de bienvenida -->
    <div class="welcome-card mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 2rem; color: white; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="mb-2" style="font-weight: 700;">
                    <i class="fas fa-chalkboard-teacher"></i>
                    ¡Bienvenido, Prof. {{ auth()->user()->name }}!
                </h3>
                <p class="mb-0" style="font-size: 1rem; opacity: 0.95;">
                    <i class="far fa-calendar"></i>
                    {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </p>
            </div>
            <div class="col-md-4 text-end">
                <div class="p-3" style="background: rgba(255, 255, 255, 0.15); border-radius: 12px; backdrop-filter: blur(10px);">
                    <h2 class="mb-0" style="font-weight: 800;">{{ $clasesHoy }}</h2>
                    <p class="mb-0" style="font-size: 0.9rem;">Clases hoy</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="row g-3 mb-4">
        <!-- Mis Clases -->
        <div class="col-lg-3 col-md-6">
            <div class="summary-card" style="background: white; border-radius: 12px; padding: 1.5rem; border-left: 4px solid #667eea; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Mis Clases</p>
                        <h2 class="mb-0" style="color: #667eea; font-weight: 800;">{{ $totalClases }}</h2>
                        <small class="text-muted">Materias que imparto</small>
                    </div>
                    <div class="icon-circle" style="width: 55px; height: 55px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                        <i class="fas fa-book" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Estudiantes -->
        <div class="col-lg-3 col-md-6">
            <div class="summary-card" style="background: white; border-radius: 12px; padding: 1.5rem; border-left: 4px solid #4ec7d2; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Estudiantes</p>
                        <h2 class="mb-0" style="color: #4ec7d2; font-weight: 800;">{{ $totalEstudiantes }}</h2>
                        <small class="text-muted">En todas mis clases</small>
                    </div>
                    <div class="icon-circle" style="width: 55px; height: 55px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(78, 199, 210, 0.3);">
                        <i class="fas fa-users" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clases Hoy -->
        <div class="col-lg-3 col-md-6">
            <div class="summary-card" style="background: white; border-radius: 12px; padding: 1.5rem; border-left: 4px solid #f093fb; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Clases Hoy</p>
                        <h2 class="mb-0" style="color: #f093fb; font-weight: 800;">{{ $clasesHoy }}</h2>
                        <small class="text-muted">Programadas</small>
                    </div>
                    <div class="icon-circle" style="width: 55px; height: 55px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);">
                        <i class="fas fa-calendar-day" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tareas Pendientes -->
        <div class="col-lg-3 col-md-6">
            <div class="summary-card" style="background: white; border-radius: 12px; padding: 1.5rem; border-left: 4px solid #fa709a; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Por Revisar</p>
                        <h2 class="mb-0" style="color: #fa709a; font-weight: 800;">{{ $tareasPendientes }}</h2>
                        <small class="text-muted">Tareas pendientes</small>
                    </div>
                    <div class="icon-circle" style="width: 55px; height: 55px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3);">
                        <i class="fas fa-clipboard-check" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="row g-3">
        <!-- Mis Clases -->
        <div class="col-lg-8">
            <div class="card border-0" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #003b73; font-weight: 700;">
                            <i class="fas fa-chalkboard" style="color: #667eea;"></i>
                            Mis Clases
                        </h5>
                        <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.4rem 0.8rem; border-radius: 8px;">
                            {{ count($misClases) }} clases
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th class="border-0 px-4 py-3" style="font-size: 0.85rem; font-weight: 700; color: #003b73;">Materia</th>
                                    <th class="border-0 px-4 py-3" style="font-size: 0.85rem; font-weight: 700; color: #003b73;">Grado</th>
                                    <th class="border-0 px-4 py-3" style="font-size: 0.85rem; font-weight: 700; color: #003b73;">Sección</th>
                                    <th class="border-0 px-4 py-3" style="font-size: 0.85rem; font-weight: 700; color: #003b73;">Estudiantes</th>
                                    <th class="border-0 px-4 py-3" style="font-size: 0.85rem; font-weight: 700; color: #003b73;">Horario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($misClases as $clase)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-small" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                                                <i class="fas fa-book-open" style="color: white; font-size: 0.9rem;"></i>
                                            </div>
                                            <span style="font-weight: 600; color: #003b73;">{{ $clase['nombre'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge" style="background: rgba(102, 126, 234, 0.15); color: #667eea; padding: 0.4rem 0.7rem; border-radius: 8px; font-weight: 600;">
                                            {{ $clase['grado'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; padding: 0.4rem 0.7rem; border-radius: 8px; font-weight: 600;">
                                            Sección {{ $clase['seccion'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span style="color: #003b73; font-weight: 600;">
                                            <i class="fas fa-user-graduate" style="color: #4ec7d2; font-size: 0.85rem;"></i>
                                            {{ $clase['estudiantes'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <small style="color: #6b7280; font-weight: 500;">
                                            <i class="far fa-clock"></i>
                                            {{ $clase['horario'] }}
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estudiantes Destacados -->
        <div class="col-lg-4">
            <div class="card border-0" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-star" style="color: #fa709a;"></i>
                        Estudiantes Destacados
                    </h5>
                </div>
                <div class="card-body p-3">
                    @if($estudiantesDestacados->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($estudiantesDestacados as $estudiante)
                            <div class="list-group-item border-0 px-2 py-3" style="background: #f8f9fa; border-radius: 10px; margin-bottom: 0.5rem;">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $estudiante->foto) }}" 
                                         class="rounded-circle" 
                                         style="width: 45px; height: 45px; object-fit: cover; border: 3px solid #667eea;"
                                         alt="Foto">
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 0.9rem;">
                                            {{ $estudiante->nombre_completo }}
                                        </h6>
                                        <small class="text-muted">{{ $estudiante->grado }} - Sección {{ $estudiante->seccion }}</small>
                                    </div>
                                    <i class="fas fa-medal" style="color: #fa709a; font-size: 1.2rem;"></i>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-graduate" style="font-size: 3rem; color: #e5e7eb;"></i>
                            <p class="text-muted mt-3 mb-0">No hay estudiantes destacados aún</p>
                        </div>
                    @endif
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
                        <a href="#" class="btn btn-lg text-start" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px; padding: 1rem; border: none; font-weight: 600; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Registrar Asistencia
                        </a>
                        <a href="#" class="btn btn-lg text-start" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 10px; padding: 1rem; border: none; font-weight: 600; box-shadow: 0 4px 15px rgba(78, 199, 210, 0.3);">
                            <i class="fas fa-edit me-2"></i>
                            Registrar Calificaciones
                        </a>
                        <a href="#" class="btn btn-lg text-start" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 10px; padding: 1rem; border: none; font-weight: 600; box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);">
                            <i class="fas fa-tasks me-2"></i>
                            Crear Tarea
                        </a>
                        <a href="#" class="btn btn-lg text-start" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; border-radius: 10px; padding: 1rem; border: none; font-weight: 600; box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3);">
                            <i class="fas fa-file-alt me-2"></i>
                            Ver Reportes
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
        background-color: rgba(102, 126, 234, 0.05);
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
</style>
@endpush
@endsection